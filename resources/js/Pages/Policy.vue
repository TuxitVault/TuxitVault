<template>
    <div class="min-h-screen bg-gradient-to-br from-green-50 via-white to-green-50">
        <!-- Header avec navigation -->
        <div class="bg-white shadow-sm border-b border-gray-200">
            <div class="max-w-4xl mx-auto px-6 py-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <img src="/images/logo.png" alt="TuxitVault" class="w-10 h-10 mr-3" />
                        <h1 class="text-xl font-bold text-gray-900">Conditions légales</h1>
                    </div>

                    <!-- Bouton retour accueil -->
                    <a
                        href="/"
                        class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition duration-200"
                    >
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Retour à l'accueil
                    </a>
                </div>
            </div>
        </div>

        <!-- Contenu principal -->
        <div class="max-w-4xl mx-auto px-6 py-12">
            <!-- En-tête de la page -->
            <div class="text-center mb-12">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-green-100 rounded-full mb-6">
                    <svg class="w-8 h-8 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd" />
                    </svg>
                </div>

                <h1 class="text-4xl font-bold text-gray-900 mb-4">
                    Conditions Générales d'Utilisation & <br>Politique de Confidentialité
                </h1>
                <p class="text-lg text-gray-600 mb-2">
                    Transparence et protection de vos données
                </p>
                <p class="text-sm text-gray-500 bg-gray-100 inline-block px-3 py-1 rounded-full">
                    Dernière mise à jour : 30/06/2025
                </p>
            </div>

            <!-- Table des matières -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-8">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <svg class="w-5 h-5 text-green-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Sommaire
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                    <a
                        v-for="(section, index) in sections"
                        :key="index"
                        :href="`#section-${index + 1}`"
                        class="text-sm text-green-600 hover:text-green-700 hover:bg-green-50 p-2 rounded transition duration-200"
                    >
                        {{ section.title }}
                    </a>
                </div>
            </div>

            <!-- Sections du contenu -->
            <div class="space-y-8">
                <section
                    v-for="(section, index) in sections"
                    :key="index"
                    :id="`section-${index + 1}`"
                    class="bg-white rounded-xl shadow-sm border border-gray-200 p-8 scroll-mt-8"
                >
                    <h2 class="text-2xl font-semibold text-gray-900 mb-6 pb-3 border-b border-gray-200 flex items-center">
            <span class="inline-flex items-center justify-center w-8 h-8 bg-green-100 text-green-600 rounded-full text-sm font-bold mr-3">
              {{ index + 1 }}
            </span>
                        {{ section.title.split('. ')[1] || section.title }}
                    </h2>

                    <div class="space-y-4">
                        <div v-for="(para, i) in section.content" :key="i">
                            <p v-if="typeof para === 'string'" class="text-gray-700 leading-relaxed">
                                {{ para }}
                            </p>
                            <ul v-else-if="Array.isArray(para)" class="space-y-2 ml-6">
                                <li
                                    v-for="(item, j) in para"
                                    :key="j"
                                    class="text-gray-700 leading-relaxed flex items-start"
                                >
                                    <svg class="w-4 h-4 text-green-500 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                    </svg>
                                    {{ item }}
                                </li>
                            </ul>
                        </div>
                    </div>
                </section>
            </div>

            <!-- Section contact -->
            <div class="bg-green-600 rounded-xl p-8 mt-12 text-white text-center">
                <h3 class="text-2xl font-bold mb-4">Des questions ?</h3>
                <p class="text-green-100 mb-6">
                    Notre équipe est là pour vous aider à comprendre nos conditions d'utilisation
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a
                        href="mailto:support@tuxitvault.fr"
                        class="inline-flex items-center justify-center px-6 py-3 bg-white text-green-600 rounded-lg hover:bg-green-50 transition font-semibold"
                    >
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                            <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                        </svg>
                        Nous contacter
                    </a>
                    <a
                        href="/"
                        class="inline-flex items-center justify-center px-6 py-3 border-2 border-white text-white rounded-lg hover:bg-white hover:text-green-600 transition font-semibold"
                    >
                        Retour à l'accueil
                    </a>
                </div>
            </div>

            <!-- Footer -->
            <div class="text-center mt-12 pt-8 border-t border-gray-200">
                <div class="flex items-center justify-center mb-4">
                    <img src="/images/logo.png" alt="TuxitVault" class="w-8 h-8 mr-2" />
                    <span class="font-semibold text-gray-900">TuxitVault</span>
                </div>
                <p class="text-sm text-gray-500 mb-2">
                    © 2025 TuxitVault — Tous droits réservés
                </p>
                <a
                    href="https://www.tuxitvault.filiere.info"
                    class="text-green-600 hover:text-green-700 text-sm transition duration-200"
                >
                    www.tuxitvault.filiere.info
                </a>
            </div>

            <!-- Bouton retour en haut -->
            <div class="fixed bottom-8 right-8">
                <button
                    @click="scrollToTop"
                    class="w-12 h-12 bg-green-600 text-white rounded-full shadow-lg hover:bg-green-700 transition duration-200 transform hover:scale-110"
                >
                    <svg class="w-6 h-6 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
</template>

<script setup>
const sections = [
    {
        title: '1. Présentation du service',
        content: [
            "Le site Tuxitvault, accessible à l'adresse https://www.tuxitvault.filiere.info, propose un service de sauvegarde, de stockage et de partage de fichiers en ligne.",
            "L'utilisation du Site implique l'acceptation pleine et entière des présentes Conditions Générales d'Utilisation (CGU) et de la Politique de Confidentialité."
        ]
    },
    {
        title: '2. Création de compte et accès au service',
        content: [
            "La création d'un compte est obligatoire et nécessite une adresse e-mail valide et un mot de passe.",
            "L'utilisateur est responsable de la sécurité de ses identifiants.",
            "Le service est accessible 24h/24, 7j/7, sauf interruption pour maintenance."
        ]
    },
    {
        title: '3. Offres et abonnements',
        content: [
            [
                "Formule gratuite : espace limité, fonctionnalités de base.",
                "Formules Standard et Premium : plus d'espace, fonctionnalités étendues, support prioritaire."
            ],
            "Les abonnements sont renouvelables automatiquement et résiliables via l'espace personnel."
        ]
    },
    {
        title: '4. Utilisation et contenu des fichiers',
        content: [
            "L'utilisateur est responsable du contenu qu'il stocke.",
            [
                "Pas de contenu illicite ou portant atteinte à l'ordre public.",
                "Pas de contenu violant les droits d'auteur ou de tiers.",
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
                "Conservation : pendant l'utilisation + 12 mois après suppression du compte.",
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
            "E-mail : support@tuxitvault.fr"
        ]
    }
];

// Fonction pour remonter en haut de page
const scrollToTop = () => {
    window.scrollTo({ top: 0, behavior: 'smooth' });
};
</script>

<style scoped>
/* Scroll smooth pour les ancres */
html {
    scroll-behavior: smooth;
}

/* Style pour les liens du sommaire */
a[href^="#"]:hover {
    transform: translateX(4px);
}
</style>
