# Dossier technique TuxitVault – Groupe Lucas BRUYERE

Ce document constitue la base de la partie technique du mémoire du groupe **Lucas BRUYERE**. Il rassemble l'ensemble des éléments nécessaires pour présenter le fonctionnement interne de la plateforme TuxitVault, les choix d'architecture, les modules applicatifs, la sécurité, l'infrastructure ainsi que les procédures d'exploitation. Chaque section peut être réutilisée ou enrichie pour la soutenance et la rédaction finale.

---

## 1. Synthèse technique du produit

- **Type de solution** : plateforme SaaS de coffre-fort numérique pour particuliers et PME.
- **Objectif fonctionnel** : stockage, organisation, partage, vérification d'intégrité et monétisation par abonnement.
- **Pile technologique** : Laravel 11 (PHP 8.2), Vue.js 3 + Inertia.js, Tailwind CSS, MySQL/PostgreSQL, Stripe + Laravel Cashier, stockage via Laravel Filesystem.
- **Contraintes principales** : sécurité avancée (2FA, hash, audit), scalabilité, UX fluide, conformité RGPD.

---

## 2. Architecture globale

### 2.1 Découpage logique

| Couche | Responsabilités | Technologies clés |
| --- | --- | --- |
| Présentation | Interface utilisateur, interactions temps réel, notifications | Vue.js 3, Inertia.js, Tailwind CSS |
| Application | Routes HTTP, contrôleurs, validations, policies | Laravel 11, Sanctum, Jetstream |
| Domaine | Modèles Eloquent, services métiers, événements | PHP 8.2, Eloquent ORM, Jobs/Queues |
| Persistance | Stockage relationnel, fichiers, cache | MySQL/PostgreSQL, Laravel Filesystem, Redis (optionnel) |
| Intégrations | Paiements, emails, monitoring | Stripe, Laravel Cashier, Mailhog/SMTP, Sentry |

### 2.2 Diagramme de séquence (texte) – Upload d'un fichier

1. `MyFiles.vue` déclenche un `Inertia.post('/files')` avec le fichier et le dossier cible.
2. `FileController@store` valide les entrées (`StoreFileRequest`).
3. Service `FileStorageService` calcule le chemin, enregistre le fichier (`Storage::putFileAs`).
4. Modèle `File` crée l'entrée en base, associe les métadonnées (taille, hash SHA-256).
5. Événement `FileUploaded` alimente la queue pour le mail de confirmation ou les tâches d'intégrité.
6. Réponse Inertia renvoyée → rafraîchissement de la liste côté Vue.

### 2.3 Flux principaux

- **Gestion d'arborescence** : arbre `nested set` pour dossiers/fichiers, breadcrumbs dynamique, pagination.
- **Partage interne** : `FileShare` lie un fichier à un utilisateur invité ; mail via `ShareFilesMail` + entrée dans « Partagés avec moi ».
- **Abonnements** : `CheckoutController` initie Stripe Checkout, `SubscriptionController` gère les actions post-achat, webhooks synchronisent les statuts.
- **Vérification d'intégrité** : Jobs en file d'attente qui recalculent le hash et marquent `integrity_verified`.

---

## 3. Backend Laravel

### 3.1 Structure des contrôleurs

| Contrôleur | Rôle | Points d'attention |
| --- | --- | --- |
| `DashboardController` | Statistiques globales de stockage et d'intégrité | Utilise des requêtes agrégées pour optimiser les performances |
| `FileController` | CRUD fichiers/dossiers, upload multiple, corbeille, favoris | Vérifie les quotas d'abonnement et la propriété des fichiers |
| `ShareController` | Inviter, révoquer, lister les partages | Envoie des notifications et enregistre l'audit |
| `IntegrityController` | Génération / vérification de hash | Pousse les traitements lourds vers la queue |
| `CheckoutController` | Session Stripe Checkout | Crée ou met à jour le client Stripe via Cashier |
| `SubscriptionController` | Annulation, reprise, changement de plan | S'appuie sur les helpers Cashier (`$user->subscribed()`) |

### 3.2 Services et classes de support

- `FileStorageService` : encapsule la logique de chemin, de versioning, de suppression physique.
- `IntegrityService` : calcule les empreintes SHA-256, compare les valeurs, déclenche des alertes.
- `QuotaService` : calcule l'espace utilisé, vérifie le respect des limites par plan.
- `ShareService` : centralise la création des invitations, gère les expirations.

### 3.3 FormRequests et validation

- `StoreFileRequest` : taille maximale, types de fichiers autorisés, abonnement actif.
- `UpdateFileRequest` : unicité des noms dans un dossier, intégrité des identifiants.
- `ShareFileRequest` : vérification d'existence de l'utilisateur invité, contrôle des permissions.
- `CheckoutRequest` : plan valide, acceptation des CGU.

### 3.4 Policies et autorisations

- `FilePolicy` : `view`, `update`, `delete`, `share`, `verifyIntegrity` basées sur le propriétaire et l'abonnement.
- `SubscriptionPolicy` : limite certaines actions aux utilisateurs disposant d'un plan actif.
- Utilisation de `Gate::define` pour des règles transverses (accès admin, maintenance).

### 3.5 Notifications & events

- `FileShared` → Notification `ShareFilesMail` + enregistrement dans `notifications`.
- `SubscriptionAboutToExpire` → mail automatique + bannière dans l'UI.
- `IntegrityMismatchDetected` → déclenche un canal Slack/Teams via webhook.

---

## 4. Modèles Eloquent et base de données

### 4.1 Tables principales

| Table | Colonnes clés | Remarques |
| --- | --- | --- |
| `users` | `id`, `name`, `email`, `two_factor_secret`, `stripe_id`, `storage_quota` | Hérite de Jetstream + Cashier |
| `files` | `id`, `user_id`, `parent_id`, `_lft`, `_rgt`, `name`, `type`, `size`, `hash`, `integrity_verified`, `storage_path`, `deleted_at` | Implémente `SoftDeletes` et `NodeTrait` |
| `file_shares` | `id`, `file_id`, `shared_by`, `shared_with`, `expires_at`, `permissions` | Permissions granularisées (lecture/téléchargement) |
| `starred_files` | `file_id`, `user_id` | Index unique composite pour éviter les doublons |
| `subscriptions` | colonnes Cashier standard | Plan actif, statut, période |
| `audit_logs` (optionnel) | `id`, `user_id`, `action`, `target_type`, `target_id`, `metadata` JSON | Historique pour conformité |

### 4.2 Migrations notables

- `create_files_table` : ajoute les colonnes `_lft`, `_rgt`, `depth` pour la hiérarchie + `hash` et `integrity_verified`.
- `add_storage_path_to_files_table` : stocke le chemin unique pour faciliter la suppression/ restauration.
- `create_file_shares_table` : gère les expirations via `nullableTimestamp`.
- Migrations Cashier : `create_subscriptions_table`, `create_subscription_items_table`, `create_customer_columns`.

### 4.3 Indexation et performance

- Index composites sur `(user_id, deleted_at)` pour accélérer la corbeille.
- Index sur `hash` pour les recherches d'intégrité.
- Index sur `shared_with` pour les vues « Partagés avec moi ».
- Potentiel ajout d'index sur `created_at` pour les rapports temporels.

### 4.4 Stratégie d'intégrité référentielle

- Clés étrangères avec `onDelete('cascade')` pour `files` et `file_shares`.
- Validation applicative pour éviter les cycles dans l'arborescence (`NodeTrait`).
- Transactions lors des opérations critiques (move, delete multiple).

---

## 5. Frontend Vue.js + Inertia

### 5.1 Organisation des fichiers

```
resources/js
├── App.vue
├── app.js
├── Components
│   ├── ApplicationLogo.vue
│   ├── Breadcrumbs.vue
│   ├── FileCard.vue
│   ├── FileTable.vue
│   ├── IntegrityStatus.vue
│   ├── Modals
│   │   ├── ConfirmDialog.vue
│   │   └── ShareDialog.vue
│   └── Widgets
│       └── StorageUsage.vue
├── Composables
│   ├── useFileActions.js
│   ├── useClipboard.js
│   └── useNotifications.js
└── Pages
    ├── Dashboard.vue
    ├── MyFiles.vue
    ├── SharedWithMe.vue
    ├── Trash.vue
    ├── Pricing.vue
    ├── Checkout.vue
    └── Settings
        └── Billing.vue
```

### 5.2 Points clés UI/UX

- Layout principal Jetstream, slots personnalisés pour le tableau de bord.
- Upload multi-fichiers avec drag & drop (`<input type="file" multiple webkitdirectory>` optionnel).
- Progress bars et notifications temps réel via `useNotifications` (basé sur events Inertia).
- Fil d'Ariane généré depuis le backend (chemin complet) et rendu par `Breadcrumbs.vue`.
- Vue « Integrity » avec badges (vert, orange, rouge) pour l'état des fichiers.

### 5.3 Gestion d'état

- Inertia transmet `props` : `files`, `breadcrumbs`, `metrics`, `subscription`.
- `useFileActions` encapsule les appels : `upload`, `rename`, `delete`, `restore`, `share`.
- Détection offline : hook sur `window.navigator.onLine` → désactivation des actions critiques.

### 5.4 Accessibilité & internationalisation

- Utilisation systématique de `aria-label`, `role` sur les boutons et modales.
- Palette de couleurs conforme WCAG AA (contraste > 4.5:1).
- Fichiers de traduction dans `lang/fr` et `lang/en`, chargés via Ziggy + Inertia.

---

## 6. Sécurité

### 6.1 Authentification & sessions

- Jetstream + Sanctum pour la gestion des sessions, tokens API et 2FA.
- Limitation des tentatives de connexion (`LoginController` + `ThrottleRequests`).
- Revocation des sessions depuis l'espace utilisateur.

### 6.2 Protection des données

- Chiffrement TLS (Let's Encrypt) sur toutes les communications.
- Option de stockage chiffré côté serveur (LUKS) ou recours à S3 avec SSE.
- Hash SHA-256 + option HMAC avec secret serveur pour détecter les manipulations.
- Commande artisan `files:verify-integrity` planifiée (cron) pour vérification nocturne.

### 6.3 Conformité et audit

- Journalisation des actions sensibles dans `audit_logs`.
- Politique de rétention : corbeille 30 jours, purge physique ensuite.
- Gestion RGPD : export des données utilisateur, suppression compte (`DeleteUser` job).

### 6.4 Sécurité applicative

- CSRF automatique via Jetstream/Inertia.
- Headers de sécurité dans `AppServiceProvider` (`CSP`, `X-Frame-Options`, `Referrer-Policy`).
- Scans réguliers OWASP ZAP, corrections XSS/Content Security Policy.
- Vérification antivirus optionnelle via intégration ClamAV (queue `ScanFileJob`).

---

## 7. Performance et scalabilité

### 7.1 Optimisations backend

- Pagination + lazy loading pour les grandes arborescences.
- Cache des statistiques `Dashboard` (`Cache::remember` 5 minutes).
- Jobs asynchrones pour emails, vérifications, conversions.
- Utilisation de `Storage::disk('s3')` pour externaliser facilement.

### 7.2 Optimisations frontend

- Code splitting via Vite (`dynamic import()` pour les pages lourdes).
- Lazy loading des composants modaux.
- Optimisation des images et des icônes SVG inline.

### 7.3 Stratégies d'extension

- **Horizontal scaling** : plusieurs instances Laravel derrière un load balancer (HAProxy/Nginx) + base managée.
- **Stockage** : migration vers S3/Wasabi, CDN (CloudFront) pour le téléchargement rapide.
- **Queue** : Redis ou Amazon SQS pour absorber les pics d'activité.
- **Monitoring** : Prometheus + Grafana, Sentry pour les erreurs.

---

## 8. Paiements et monétisation

### 8.1 Plans et quotas

| Plan | Stockage | Fonctions incluses |
| --- | --- | --- |
| `free` | 5 Go | Upload fichiers unitaires, partage limité |
| `pro` | 200 Go | Upload dossier, intégrité illimitée, partage avancé |
| `business` | 1 To | Rôles personnalisés, audit détaillé, support prioritaire |

### 8.2 Flux d'abonnement

1. L'utilisateur choisit un plan sur `/pricing` (données provenant de Stripe API).
2. `CheckoutController` crée la session Checkout (`$user->newSubscription($plan)`).
3. Stripe héberge la saisie de carte ; retour webhook `invoice.payment_succeeded`.
4. Cashier met à jour `subscriptions.status` et déclenche un mail de bienvenue.
5. Middleware `EnsureSubscribed` filtre l'accès aux fonctionnalités premium.

### 8.3 Facturation et conformité

- Factures PDF générées par Stripe, disponibles dans `Settings/Billing` via API.
- Gestion de la TVA (Stripe Tax ou configuration manuelle).
- Export CSV des transactions pour la comptabilité.

---

## 9. Tests et qualité logicielle

### 9.1 Automatisation

- **PHPUnit** : tests de contrôleurs (`FileControllerTest`), services (`IntegrityServiceTest`), policies.
- **PestPHP** (optionnel) : syntaxe fluide pour les tests unitaires.
- **Laravel Dusk** : tests end-to-end pour le parcours utilisateur.
- **Cypress** côté front pour les interactions drag & drop.

### 9.2 Couverture & intégration continue

- Pipeline GitHub Actions : `composer install`, `npm ci`, `phpunit`, `npm run build`.
- Rapport de couverture via `phpunit --coverage-xml` + badge Codecov.
- Linting : `phpcs` (PSR-12), `eslint`, `stylelint`.

### 9.3 Tests de charge et sécurité

- Scénarios JMeter/Gatling : 200 utilisateurs simultanés, upload 10 Mo.
- Vérification du temps de réponse < 500 ms pour 95e percentile.
- Scans OWASP ZAP intégrés au pipeline (staging).

---

## 10. Infrastructure et déploiement

### 10.1 Environnements

- **Développement** : Sail ou Docker Compose (PHP-FPM, MySQL, Redis, Mailhog).
- **Recette/Staging** : VM Linux (Ubuntu 22.04), Nginx, PHP 8.2, base MySQL managée.
- **Production** : infrastructure cloud (Scaleway, OVH, AWS) avec backups automatisés.

### 10.2 Pipeline CI/CD

1. Merge sur `main` déclenche la CI.
2. Build des assets (`npm run build`).
3. Exécution des tests (`phpunit`, `npm run test`).
4. Déploiement via `Envoy` ou GitHub Actions (SSH + `php artisan down/up`).
5. Migrations `php artisan migrate --force`, cache config/route/view.

### 10.3 Supervision et alerting

- Metrics : CPU, RAM, I/O via Prometheus node exporter.
- Logs : Stack ELK (Filebeat + Logstash + Elasticsearch + Kibana) ou Laravel Telescope.
- Alertes : seuils sur espace disque, erreurs 5xx, temps de réponse.

### 10.4 Sauvegardes & PRA

- Dump quotidien de la base (`mysqldump` + chiffrement GPG).
- Sauvegarde incrémentale du stockage (`rclone` vers S3/Backblaze).
- Plan de reprise : réplication froide sur région secondaire, documentation de restauration (`restore.md`).

---

## 11. Commandes et scripts utiles

| Commande | Objectif |
| --- | --- |
| `php artisan migrate` | Appliquer les migrations |
| `php artisan files:purge-trash` | Purge la corbeille au-delà du délai |
| `php artisan files:verify-integrity` | Vérifie les hashes pour tous les fichiers |
| `php artisan subscription:notify-renewal` | Préviens les utilisateurs de la reconduction |
| `npm run dev` / `npm run build` | Build front en dev / prod |
| `php artisan queue:work` | Traitement des jobs (upload massif, intégrité, emails) |

---

## 12. Roadmap technique (6-12 mois)

- **Lien public sécurisé** : génération de liens temporaires avec mot de passe.
- **Scan antivirus** : intégration ClamAV côté queue (`ScanFileJob`).
- **Applications mobiles** : clients iOS/Android via Ionic ou React Native utilisant l'API REST.
- **Recherche full-text** : intégration Meilisearch ou ElasticSearch pour la recherche avancée.
- **Data Loss Prevention** : règles détectant des patterns sensibles (IBAN, NIR) dans les uploads.
- **Support multi-tenant** : séparation logique des organisations, custom branding.
- **Automatisation facturation** : rappels de paiement, relance d'expiration de carte.

---

## 13. Annexes techniques

### 13.1 Matrice responsabilités (RACI)

| Domaine | Responsable | Support |
| --- | --- | --- |
| Backend Laravel | Lucas BRUYERE | Équipe développement |
| Frontend Vue | Lucas BRUYERE | UX/UI |
| Sécurité | Lucas BRUYERE | Référent SSI |
| Infrastructure | Lucas BRUYERE | Administrateur système |
| Paiements | Lucas BRUYERE | Support Stripe |

### 13.2 Checklist de revue de code

- [ ] Validation centralisée (`FormRequest`).
- [ ] Tests mis à jour (unitaires ou Dusk).
- [ ] Nomination claire des méthodes et variables.
- [ ] Gestion des erreurs (try/catch ciblés, retours utilisateur).
- [ ] Respect PSR-12 / ESLint.
- [ ] Aucune donnée sensible dans les logs.

### 13.3 Modèle d'API REST (si ouverture externe)

| Endpoint | Méthode | Description | Auth |
| --- | --- | --- | --- |
| `/api/files` | GET | Lister les fichiers/dossiers racine | Token Sanctum |
| `/api/files` | POST | Upload fichier/dossier | Token + quota |
| `/api/files/{id}` | DELETE | Supprimer (corbeille) | Propriétaire |
| `/api/files/{id}/share` | POST | Créer un partage | Propriétaire |
| `/api/integrity/run` | POST | Lancer vérification | Admin |
| `/api/subscription` | GET | Récupérer statut d'abonnement | Utilisateur |

### 13.4 Schéma d'infrastructure recommandé

1. **Frontend** servi par Nginx + assets versionnés (Vite).
2. **Backend Laravel** derrière PHP-FPM (pool dédié).
3. **Base de données** : MySQL managé (replica en lecture).
4. **Stockage** : S3-compatible + bucket privé.
5. **Queue** : Redis/SQS + workers autoscalés.
6. **Monitoring** : Prometheus + Grafana, Sentry.

---

## 14. Points clés à mentionner en soutenance

1. Cohérence Laravel/Vue grâce à Inertia (moins de duplication, validations partagées).
2. Gestion hiérarchique performante grâce à `nested set` et optimisations SQL.
3. Sécurité intégrée : 2FA, hash d'intégrité, audit, conformité RGPD.
4. Scalabilité prévue : externalisation stockage, queues, architecture cloud-ready.
5. Modèle économique structuré avec Stripe + Cashier, quotas différenciés.
6. Qualité logicielle : tests automatisés, pipelines CI/CD, revues de code.
7. Roadmap crédible vers des fonctionnalités avancées (API publique, DLP, mobile).

Ce dossier peut être enrichi avec des captures d'écran, schémas UML ou scripts supplémentaires selon les besoins de présentation.
