<script setup>
import { computed } from 'vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import AuthenticationCard from '@/Components/AuthenticationCard.vue';
import AuthenticationCardLogo from '@/Components/AuthenticationCardLogo.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

const props = defineProps({
    status: String,
});

const form = useForm({});

const submit = () => {
    form.post(route('verification.send'));
};

const verificationLinkSent = computed(() => props.status === 'verification-link-sent');
</script>

<template>
    <Head title="Vérification email" />

    <div class="min-h-screen bg-gradient-to-br from-green-50 via-white to-green-50 flex flex-col justify-center py-12 sm:px-6 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-md">
            <!-- Logo et titre -->
            <div class="text-center mb-8">
                <img src="/images/logo.png" alt="TuxitVault" class="w-20 h-20 mx-auto mb-4" />
                <h1 class="text-3xl font-bold text-gray-900">Vérifiez votre email</h1>
                <p class="mt-2 text-gray-600">Une dernière étape avant de commencer</p>
            </div>
        </div>

        <div class="sm:mx-auto sm:w-full sm:max-w-md">
            <div class="bg-white py-8 px-6 shadow-xl rounded-2xl sm:px-10 border border-gray-100">
                <!-- Icône email -->
                <div class="flex justify-center mb-6">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 7.89a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>
                </div>

                <!-- Instructions -->
                <div class="mb-6 text-center">
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Vérification par email</h3>
                    <p class="text-sm text-gray-600">
                        Nous avons envoyé un lien de vérification à votre adresse email. Cliquez sur le lien pour activer votre compte.
                    </p>
                </div>

                <!-- Message de confirmation d'envoi -->
                <div v-if="verificationLinkSent" class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                        <span class="text-sm font-medium text-green-800">
                            Un nouveau lien de vérification a été envoyé à votre adresse email.
                        </span>
                    </div>
                </div>

                <form @submit.prevent="submit" class="space-y-6">
                    <!-- Bouton renvoyer email -->
                    <div>
                        <PrimaryButton
                            type="submit"
                            class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition duration-200 transform hover:scale-[1.02]"
                            :class="{ 'opacity-50 cursor-not-allowed': form.processing }"
                            :disabled="form.processing"
                        >
                            <svg v-if="form.processing" class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            {{ form.processing ? 'Envoi en cours...' : 'Renvoyer l\'email de vérification' }}
                        </PrimaryButton>
                    </div>

                    <!-- Divider -->
                    <div class="relative">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-gray-300"></div>
                        </div>
                        <div class="relative flex justify-center text-sm">
                            <span class="px-2 bg-white text-gray-500">ou</span>
                        </div>
                    </div>

                    <!-- Actions alternatives -->
                    <div class="flex flex-col space-y-3">
                        <Link
                            :href="route('profile.show')"
                            class="w-full text-center py-2 px-4 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition duration-200"
                        >
                            Modifier mon profil
                        </Link>

                        <Link
                            :href="route('logout')"
                            method="post"
                            as="button"
                            class="w-full text-center py-2 px-4 text-sm font-medium text-gray-600 hover:text-gray-800 transition duration-200"
                        >
                            Se déconnecter
                        </Link>
                    </div>
                </form>
            </div>

            <!-- Retour à l'accueil -->
            <div class="text-center mt-6">
                <a href="/" class="inline-flex items-center text-sm text-gray-500 hover:text-gray-700 transition duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Retour à l'accueil
                </a>
            </div>
        </div>

        <!-- Conseils et aide -->
        <div class="max-w-md mx-auto mt-8">
            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                <div class="flex items-start">
                    <svg class="w-5 h-5 text-yellow-500 mt-0.5 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                    </svg>
                    <div>
                        <h4 class="text-sm font-medium text-yellow-800 mb-1">Vous ne recevez pas l'email ?</h4>
                        <div class="text-xs text-yellow-700 space-y-1">
                            <p>• Vérifiez votre dossier spam ou courrier indésirable</p>
                            <p>• Assurez-vous que l'adresse email est correcte</p>
                            <p>• Contactez le support si le problème persiste</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Support -->
        <div class="text-center mt-6">
            <p class="text-sm text-gray-500 mb-2">Besoin d'aide ?</p>
            <a href="mailto:support@tuxitvault.fr" class="text-green-600 hover:text-green-700 font-medium transition text-sm">
                Contactez notre support →
            </a>
        </div>
    </div>
</template>
