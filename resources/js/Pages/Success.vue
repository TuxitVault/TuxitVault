<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
</script>

<template>
    <AuthenticatedLayout>
        <div class="min-h-screen bg-gradient-to-br from-green-50 via-white to-green-50 flex flex-col items-center justify-center text-center px-6">
            <!-- Icône de succès avec animation -->
            <div class="relative mb-8">
                <div class="w-24 h-24 bg-green-100 rounded-full flex items-center justify-center animate-pulse">
                    <svg class="w-12 h-12 text-green-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
                <!-- Cercles décoratifs -->
                <div class="absolute -top-2 -right-2 w-4 h-4 bg-green-300 rounded-full animate-bounce"></div>
                <div class="absolute -bottom-1 -left-2 w-3 h-3 bg-green-400 rounded-full animate-bounce" style="animation-delay: 0.5s;"></div>
            </div>

            <!-- Contenu principal -->
            <div class="max-w-md mx-auto">
                <h1 class="text-4xl font-bold text-gray-900 mb-4">
                    Paiement réussi ! 🎉
                </h1>
                <p class="text-lg text-gray-600 mb-2">
                    Merci pour votre confiance !
                </p>
                <p class="text-base text-gray-500 mb-8">
                    Votre abonnement TuxitVault est maintenant actif et vous pouvez profiter de toutes vos nouvelles fonctionnalités.
                </p>

                <!-- Informations sur l'abonnement -->
                <div class="bg-white rounded-xl p-6 shadow-lg border border-gray-100 mb-8">
                    <div class="flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-green-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                        <span class="text-green-800 font-semibold">Abonnement activé</span>
                    </div>

                    <div class="space-y-2 text-sm text-gray-600">
                        <div class="flex items-center justify-between">
                            <span>Statut :</span>
                            <span class="font-medium text-green-600">Actif</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span>Prochaine facturation :</span>
                            <span class="font-medium">Dans 30 jours</span>
                        </div>
                    </div>
                </div>

                <!-- Boutons d'action -->
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a
                        :href="route('myFiles')"
                        class="bg-green-600 text-white px-8 py-3 rounded-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-all duration-200 transform hover:scale-105 font-semibold shadow-lg"
                    >
                        Accéder à mes fichiers
                    </a>

                    <a
                        href="/"
                        class="bg-white text-gray-700 px-8 py-3 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-all duration-200 border border-gray-300 font-semibold"
                    >
                        Retour à l'accueil
                    </a>
                </div>
            </div>

            <!-- Conseils pour débuter -->
            <div class="max-w-2xl mx-auto mt-12">
                <h3 class="text-xl font-semibold text-gray-900 mb-6">Pour bien commencer :</h3>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                    <div class="bg-white rounded-lg p-4 shadow-sm border border-gray-100 text-center">
                        <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-3">
                            <svg class="w-5 h-5 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <h4 class="font-medium text-gray-900 mb-1">Uploadez vos fichiers</h4>
                        <p class="text-xs text-gray-500">Commencez par ajouter vos documents importants</p>
                    </div>

                    <div class="bg-white rounded-lg p-4 shadow-sm border border-gray-100 text-center">
                        <div class="w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-3">
                            <svg class="w-5 h-5 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3z" />
                            </svg>
                        </div>
                        <h4 class="font-medium text-gray-900 mb-1">Partagez en sécurité</h4>
                        <p class="text-xs text-gray-500">Invitez vos collaborateurs et partagez vos dossiers</p>
                    </div>

                    <div class="bg-white rounded-lg p-4 shadow-sm border border-gray-100 text-center">
                        <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-3">
                            <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z" />
                            </svg>
                        </div>
                        <h4 class="font-medium text-gray-900 mb-1">Synchronisez partout</h4>
                        <p class="text-xs text-gray-500">Accédez à vos fichiers depuis tous vos appareils</p>
                    </div>
                </div>
            </div>

            <!-- Support -->
            <div class="mt-8 text-center">
                <p class="text-sm text-gray-500 mb-2">Besoin d'aide pour commencer ?</p>
                <a href="mailto:support@tuxitvault.fr" class="text-green-600 hover:text-green-700 font-medium transition text-sm">
                    Contactez notre support →
                </a>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>
/* Animation personnalisée pour les cercles décoratifs */
@keyframes bounce {
    0%, 20%, 53%, 80%, 100% {
        transform: translate3d(0,0,0);
    }
    40%, 43% {
        transform: translate3d(0, -10px, 0);
    }
    70% {
        transform: translate3d(0, -5px, 0);
    }
    90% {
        transform: translate3d(0, -2px, 0);
    }
}

.animate-bounce {
    animation: bounce 2s infinite;
}

/* Animation pulse personnalisée */
@keyframes pulse {
    0%, 100% {
        opacity: 1;
    }
    50% {
        opacity: .8;
    }
}

.animate-pulse {
    animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
}
</style>
