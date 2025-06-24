<template>
  <div class="legal-page p-6 md:p-12 max-w-4xl mx-auto text-justify text-gray-800">
    <h1 class="text-3xl font-bold mb-6">Conditions Générales d’Utilisation & Politique de Confidentialité</h1>
    <p class="text-sm text-gray-500 mb-8">Dernière mise à jour : 23/06/2025</p>

    <section v-for="(section, index) in sections" :key="index" class="mb-10">
      <h2 class="text-2xl font-semibold mb-4">{{ section.title }}</h2>
      <div v-for="(para, i) in section.content" :key="i" class="mb-3">
        <p v-if="typeof para === 'string'">{{ para }}</p>
        <ul v-else-if="Array.isArray(para)" class="list-disc list-inside ml-4">
          <li v-for="(item, j) in para" :key="j">{{ item }}</li>
        </ul>
      </div>
    </section>

    <p class="text-sm text-center text-gray-400 mt-16">
      © 2025 Tuxitvault — <a href="https://www.tuxitvault.filiere.info" class="underline">www.tuxitvault.filiere.info</a>
    </p>
  </div>
</template>

<script setup>
const sections = [
  {
    title: '1. Présentation du service',
    content: [
      "Le site Tuxitvault, accessible à l’adresse https://www.tuxitvault.filiere.info, propose un service de sauvegarde, de stockage et de partage de fichiers en ligne.",
      "L’utilisation du Site implique l’acceptation pleine et entière des présentes Conditions Générales d’Utilisation (CGU) et de la Politique de Confidentialité."
    ]
  },
  {
    title: '2. Création de compte et accès au service',
    content: [
      "La création d’un compte est obligatoire et nécessite une adresse e-mail valide et un mot de passe.",
      "L’utilisateur est responsable de la sécurité de ses identifiants.",
      "Le service est accessible 24h/24, 7j/7, sauf interruption pour maintenance."
    ]
  },
  {
    title: '3. Offres et abonnements',
    content: [
      [
        "Formule gratuite : espace limité, fonctionnalités de base.",
        "Formules Standard et Premium : plus d’espace, fonctionnalités étendues, support prioritaire."
      ],
      "Les abonnements sont renouvelables automatiquement et résiliables via l’espace personnel."
    ]
  },
  {
    title: '4. Utilisation et contenu des fichiers',
    content: [
      "L’utilisateur est responsable du contenu qu’il stocke.",
      [
        "Pas de contenu illicite ou portant atteinte à l’ordre public.",
        "Pas de contenu violant les droits d’auteur ou de tiers.",
        "Aucune diffusion de fichiers haineux, diffamatoires, pornographiques ou dangereux."
      ],
      "Tuxitvault peut suspendre tout compte en cas de non-respect."
    ]
  },
  {
    title: '5. Paiement et résiliation',
    content: [
      "Paiements sécurisés via Stripe ou PayPal.",
      "Résiliation possible à tout moment via le tableau de bord.",
      "Aucun remboursement ne sera effectué pour les périodes entamées."
    ]
  },
  {
    title: '6. Politique de confidentialité',
    content: [
      "Tuxitvault respecte la réglementation en vigueur (RGPD).",
      [
        "Données collectées : e-mail, mot de passe, fichiers téléversés, données de navigation, logs, préférences.",
        "Utilisation : gestion de compte, sécurité, statistiques, amélioration du service.",
        "Conservation : pendant l’utilisation + 12 mois après suppression du compte.",
        "Sécurité : chiffrement, hébergement sécurisé, accès restreint."
      ]
    ]
  },
  {
    title: '7. Partage et transfert de données',
    content: [
      "Aucune revente des données.",
      "Partage uniquement avec des prestataires techniques sous contrat.",
      "Transferts hors UE sécurisés selon les standards (clauses types, etc.)."
    ]
  },
  {
    title: '8. Cookies',
    content: [
      "Utilisation de cookies pour le fonctionnement, les statistiques et la personnalisation.",
      "Gestion des préférences via bandeau ou navigateur."
    ]
  },
  {
    title: '9. Vos droits',
    content: [
      "Conformément au RGPD, vous pouvez exercer vos droits :",
      [
        "Accès, rectification, suppression, portabilité.",
        "Limitation ou opposition au traitement.",
        "Réclamation auprès de la CNIL (France)."
      ],
      "Contact : support@tuxitvault.fr"
    ]
  },
  {
    title: '10. Modifications',
    content: [
      "Tuxitvault peut modifier à tout moment les présentes conditions.",
      "Les utilisateurs seront informés en cas de changements importants."
    ]
  },
  {
    title: '11. Loi applicable et juridiction',
    content: [
      "Les présentes conditions sont régies par le droit français.",
      "En cas de litige, les tribunaux de Paris seront compétents (sauf disposition légale contraire)."
    ]
  },
  {
    title: '12. Contact',
    content: [
      "Tuxitvault",
      "Site web : https://www.tuxitvault.filiere.info",
      "E-mail : support@tuxitvault.fr
    ]
  }
];
</script>

<style scoped>
.legal-page h1, .legal-page h2 {
  color: #1a202c;
}
</style>
