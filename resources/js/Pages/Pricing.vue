<template>
    <AuthenticatedLayout>
        <div class="bg-gray-50 py-6">
            <div class="max-w-4xl px-4 mx-auto">
                <!-- Abonnement actuel (si existe) -->
                <div v-if="subscription" class="mb-8">
                    <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center">
                                <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mr-4">
                                    <svg class="w-6 h-6 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div>
                                    <h2 class="text-xl font-bold text-gray-900">Mon abonnement actuel</h2>
                                    <p class="text-green-600 font-semibold">{{ subscription.plan_name }}</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-2xl font-bold text-gray-900">
                                    €{{ subscription.amount }}
                                    <span class="text-sm text-gray-500">/{{ subscription.interval }}</span>
                                </p>
                                <span v-if="subscription.status === 'active' && !subscription.cancel_at_period_end" class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                    </svg>
                                    Actif
                                </span>
                                <span v-else-if="subscription.status === 'active' && subscription.cancel_at_period_end" class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-orange-100 text-orange-800">
                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                    Sera annulé
                                </span>
                                <span v-else-if="subscription.status === 'canceled'" class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                    Annulé
                                </span>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                            <div class="text-center p-3 bg-gray-50 rounded-lg">
                                <p class="text-sm text-gray-600">Prochaine facturation</p>
                                <p class="font-semibold text-gray-900">{{ subscription.next_billing_date }}</p>
                            </div>
                            <div class="text-center p-3 bg-gray-50 rounded-lg">
                                <p class="text-sm text-gray-600">Début d'abonnement</p>
                                <p class="font-semibold text-gray-900">{{ subscription.start_date }}</p>
                            </div>
                            <div class="text-center p-3 bg-gray-50 rounded-lg">
                                <p class="text-sm text-gray-600">Statut</p>
                                <p class="font-semibold" :class="subscription.status === 'active' && !subscription.cancel_at_period_end ? 'text-green-600' : subscription.cancel_at_period_end ? 'text-orange-600' : 'text-red-600'">
                                    {{ subscription.status === 'active' && !subscription.cancel_at_period_end ? 'Abonnement actif' : subscription.cancel_at_period_end ? 'Sera annulé le ' + subscription.next_billing_date : 'Abonnement annulé' }}
                                </p>
                            </div>
                        </div>

                        <div class="flex flex-col sm:flex-row gap-3">
                            <button
                                v-if="subscription.status === 'active' && !subscription.cancel_at_period_end"
                                @click="showCancelModal = true"
                                class="flex-1 py-2 px-4 border border-red-300 text-red-700 rounded-lg hover:bg-red-50 transition duration-200 font-medium"
                            >
                                Annuler l'abonnement
                            </button>
                            <div v-else-if="subscription.cancel_at_period_end" class="flex-1 py-2 px-4 bg-orange-100 text-orange-800 rounded-lg text-center font-medium">
                                Annulation programmée
                            </div>
                            <button
                                @click="showUpgradeSection = !showUpgradeSection"
                                class="flex-1 py-2 px-4 bg-green-600 text-white rounded-lg hover:bg-green-700 transition duration-200 font-medium"
                            >
                                {{ showUpgradeSection ? 'Masquer les options' : 'Changer d\'offre' }}
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Header Section -->
                <div class="text-center mb-8">
                    <h1 class="text-2xl font-bold text-gray-900 mb-2">
                        {{ subscription ? 'Changer de formule' : 'Choisissez votre formule' }}
                    </h1>
                    <p class="text-base text-gray-600">
                        {{ subscription ? 'Passez à une offre qui correspond mieux à vos besoins' : 'Des tarifs simples et transparents, sans frais cachés.' }}
                    </p>
                </div>

                <!-- Pricing Cards (masquées par défaut si abonnement actif) -->
                <div v-show="!subscription || showUpgradeSection" class="grid grid-cols-1 lg:grid-cols-2 gap-6 max-w-3xl mx-auto">
                    <!-- Basic Plan -->
                    <div class="flex flex-col justify-between border border-gray-200 text-center rounded-xl p-5 shadow-lg bg-white hover:shadow-2xl transition-all duration-300 transform hover:scale-105 cursor-pointer"
                         :class="subscription?.plan_id === 'price_1RTIkqGgofiP5UMmYOAcDqfb' ? 'ring-2 ring-green-500 bg-green-50' : ''">
                        <div>
                            <!-- Badge abonnement actuel -->
                            <span v-if="subscription?.plan_id === 'price_1RTIkqGgofiP5UMmYOAcDqfb'" class="mb-2 inline-block py-1 px-2 text-xs font-bold rounded-full bg-green-600 text-white">
                                Abonnement actuel
                            </span>
                            <span v-else class="mb-2 inline-block py-1 px-2 text-xs font-bold rounded-full invisible">
                                Placeholder
                            </span>

                            <h3 class="font-semibold text-lg text-gray-900 mb-2">Basic Monthly</h3>

                            <!-- Prix -->
                            <div class="mb-3">
                                <span class="font-bold text-3xl text-gray-900">
                                    <span class="text-lg align-top -ml-1">€</span>9.99
                                </span>
                                <span class="text-gray-500 text-sm">/mois</span>
                            </div>

                            <p class="text-gray-600 mb-4 text-sm">Fonctionnalités essentielles pour un usage personnel</p>

                            <!-- Features list -->
                            <ul class="text-left space-y-1 mb-4">
                                <li class="flex items-center">
                                    <svg class="w-4 h-4 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                    </svg>
                                    <span class="text-gray-700 text-sm">100 GB de stockage</span>
                                </li>
                                <li class="flex items-center">
                                    <svg class="w-4 h-4 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                    </svg>
                                    <span class="text-gray-700 text-sm">Partage de fichiers</span>
                                </li>
                                <li class="flex items-center">
                                    <svg class="w-4 h-4 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                    </svg>
                                    <span class="text-gray-700 text-sm">Support par email</span>
                                </li>
                            </ul>
                        </div>

                        <a
                            v-if="subscription?.plan_id !== 'price_1RTIkqGgofiP5UMmYOAcDqfb'"
                            :href="route('checkout', { plan: 'price_1RTIkqGgofiP5UMmYOAcDqfb' })"
                            class="w-full py-2 px-4 inline-flex justify-center items-center text-sm font-semibold rounded-lg bg-gray-900 text-white hover:bg-gray-800 transition-all duration-200"
                        >
                            {{ subscription ? 'Changer pour Basic' : 'Commencer' }}
                        </a>
                        <div v-else class="w-full py-2 px-4 text-sm font-semibold rounded-lg bg-gray-100 text-gray-500 text-center">
                            Abonnement actuel
                        </div>
                    </div>

                    <!-- Pro Plan -->
                    <div class="flex flex-col justify-between border-2 border-green-600 text-center rounded-xl p-5 shadow-xl bg-white hover:shadow-2xl transition-all duration-300 transform hover:scale-105 cursor-pointer relative"
                         :class="subscription?.plan_id === 'price_1RTITKGgofiP5UMmJMUfET5h' ? 'ring-2 ring-green-500 bg-green-50' : ''">
                        <!-- Badge populaire ou abonnement actuel -->
                        <div class="absolute -top-2 left-1/2 transform -translate-x-1/2">
                            <span v-if="subscription?.plan_id === 'price_1RTITKGgofiP5UMmJMUfET5h'" class="bg-green-600 text-white px-3 py-1 rounded-full text-xs font-semibold shadow-lg">
                                Abonnement actuel
                            </span>
                            <span v-else class="bg-green-600 text-white px-3 py-1 rounded-full text-xs font-semibold shadow-lg">
                                Le plus populaire
                            </span>
                        </div>

                        <div>
                            <!-- Espacement pour le badge -->
                            <div class="mb-2 h-2"></div>

                            <h3 class="font-semibold text-lg text-gray-900 mb-2">Pro Monthly</h3>

                            <!-- Prix -->
                            <div class="mb-3">
                                <span class="font-bold text-3xl text-gray-900">
                                    <span class="text-lg align-top -ml-1">€</span>19.99
                                </span>
                                <span class="text-gray-500 text-sm">/mois</span>
                            </div>

                            <p class="text-gray-600 mb-4 text-sm">Outils avancés pour les utilisateurs exigeants</p>

                            <!-- Features list -->
                            <ul class="text-left space-y-1 mb-4">
                                <li class="flex items-center">
                                    <svg class="w-4 h-4 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                    </svg>
                                    <span class="text-gray-700 text-sm">1 TB de stockage</span>
                                </li>
                                <li class="flex items-center">
                                    <svg class="w-4 h-4 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                    </svg>
                                    <span class="text-gray-700 text-sm">Partage avancé</span>
                                </li>
                                <li class="flex items-center">
                                    <svg class="w-4 h-4 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                    </svg>
                                    <span class="text-gray-700 text-sm">Support prioritaire</span>
                                </li>
                                <li class="flex items-center">
                                    <svg class="w-4 h-4 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                    </svg>
                                    <span class="text-gray-700 text-sm">Historique des versions</span>
                                </li>
                            </ul>
                        </div>

                        <a
                            v-if="subscription?.plan_id !== 'price_1RTITKGgofiP5UMmJMUfET5h'"
                            :href="route('checkout', { plan: 'price_1RTITKGgofiP5UMmJMUfET5h' })"
                            class="w-full py-2 px-4 inline-flex justify-center items-center text-sm font-semibold rounded-lg bg-green-600 text-white hover:bg-green-700 transition-all duration-200 shadow-lg"
                        >
                            {{ subscription ? 'Passer au Pro' : 'Commencer' }}
                        </a>
                        <div v-else class="w-full py-2 px-4 text-sm font-semibold rounded-lg bg-gray-100 text-gray-500 text-center">
                            Abonnement actuel
                        </div>
                    </div>
                </div>

                <!-- Contact pour solutions sur mesure -->
                <div class="text-center mt-6">
                    <p class="text-gray-600 mb-1 text-sm">Besoin d'une solution sur mesure ?</p>
                    <a href="mailto:support@tuxitvault.fr" class="text-green-600 hover:text-green-700 font-semibold transition text-sm">
                        Contactez notre équipe →
                    </a>
                </div>
            </div>
        </div>

        <!-- Modal d'annulation -->
        <div v-if="showCancelModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50" @click="showCancelModal = false">
            <div class="bg-white rounded-xl p-6 max-w-md mx-4" @click.stop>
                <div class="text-center">
                    <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Annuler l'abonnement</h3>
                    <p class="text-gray-600 mb-6">
                        Êtes-vous sûr de vouloir annuler votre abonnement ? Vous garderez l'accès jusqu'à la fin de votre période de facturation.
                    </p>
                    <div class="flex gap-3">
                        <button
                            @click="showCancelModal = false"
                            class="flex-1 py-2 px-4 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition duration-200"
                        >
                            Conserver
                        </button>
                        <button
                            @click="cancelSubscription"
                            :disabled="cancelLoading"
                            class="flex-1 py-2 px-4 bg-red-600 text-white rounded-lg hover:bg-red-700 transition duration-200 disabled:opacity-50"
                        >
                            {{ cancelLoading ? 'Annulation...' : 'Annuler' }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { ref } from 'vue';
import { router } from '@inertiajs/vue3';

// Props reçues du contrôleur
const props = defineProps({
    subscription: {
        type: Object,
        default: null
    }
});

// Accès aux messages flash de Laravel
import { usePage } from '@inertiajs/vue3';
const { props: pageProps } = usePage();

// Afficher les messages de succès/erreur
if (pageProps.flash?.success) {
    alert('✅ ' + pageProps.flash.success);
}
if (pageProps.flash?.error) {
    alert('❌ ' + pageProps.flash.error);
}

// État local
const showCancelModal = ref(false);
const showUpgradeSection = ref(false);
const cancelLoading = ref(false);

// Fonctions
const cancelSubscription = async () => {
    cancelLoading.value = true;

    try {
        await router.post('/subscription/cancel', {}, {
            onSuccess: () => {
                showCancelModal.value = false;
                // Rechargement complet de la page
                window.location.reload();
            },
            onError: (errors) => {
                console.error('Erreur lors de l\'annulation:', errors);
                alert('Erreur lors de l\'annulation de l\'abonnement');
            },
            onFinish: () => {
                cancelLoading.value = false;
            }
        });
    } catch (error) {
        console.error('Erreur:', error);
        cancelLoading.value = false;
    }
};
</script>
