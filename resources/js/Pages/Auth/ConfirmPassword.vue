<script setup>
import { ref } from 'vue';
import { Head, useForm, Link } from '@inertiajs/vue3';
import AuthenticationCard from '@/Components/AuthenticationCard.vue';
import AuthenticationCardLogo from '@/Components/AuthenticationCardLogo.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';

const form = useForm({
    password: '',
});

const passwordInput = ref(null);

const submit = () => {
    form.post(route('password.confirm'), {
        onFinish: () => {
            form.reset();

            passwordInput.value.focus();
        },
    });
};
</script>

<template>
    <Head title="Zone sécurisée" />

    <div class="min-h-screen bg-gradient-to-br from-green-50 via-white to-green-50 flex flex-col justify-center py-12 sm:px-6 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-md">
            <!-- Logo et titre -->
            <div class="text-center mb-8">
                <img src="/images/logo.png" alt="TuxitVault" class="w-20 h-20 mx-auto mb-4" />
                <h1 class="text-3xl font-bold text-gray-900">Zone sécurisée</h1>
                <p class="mt-2 text-gray-600">Confirmez votre identité pour continuer</p>
            </div>
        </div>

        <div class="sm:mx-auto sm:w-full sm:max-w-md">
            <div class="bg-white py-8 px-6 shadow-xl rounded-2xl sm:px-10 border border-gray-100">
                <!-- Icône de sécurité -->
                <div class="flex justify-center mb-6">
                    <div class="w-16 h-16 bg-orange-100 rounded-full flex items-center justify-center">
                        <svg class="w-8 h-8 text-orange-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                    </div>
                </div>

                <!-- Instructions -->
                <div class="mb-6 text-center">
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Confirmation requise</h3>
                    <p class="text-sm text-gray-600">
                        Pour accéder à cette section sensible, veuillez confirmer votre mot de passe actuel.
                    </p>
                </div>

                <form @submit.prevent="submit" class="space-y-6">
                    <!-- Mot de passe -->
                    <div>
                        <InputLabel for="password" value="Mot de passe actuel" class="text-gray-700 font-medium" />
                        <TextInput
                            id="password"
                            ref="passwordInput"
                            v-model="form.password"
                            type="password"
                            class="mt-2 block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 transition duration-200"
                            required
                            autocomplete="current-password"
                            autofocus
                            placeholder="Entrez votre mot de passe"
                        />
                        <InputError class="mt-2" :message="form.errors.password" />
                    </div>

                    <!-- Bouton de confirmation -->
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
                            {{ form.processing ? 'Vérification...' : 'Confirmer et continuer' }}
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

                    <!-- Liens alternatifs -->
                    <div class="flex flex-col space-y-3">
                        <Link
                            :href="route('password.request')"
                            class="w-full text-center py-2 px-4 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition duration-200"
                        >
                            Mot de passe oublié ?
                        </Link>

                        <Link
                            :href="route('logout')"
                            method="post"
                            as="button"
                            class="w-full text-center py-2 px-4 text-sm font-medium text-gray-600 hover:text-gray-800 transition duration-200"
                        >
                            Se déconnecter et revenir plus tard
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

        <!-- Information de sécurité -->
        <div class="max-w-md mx-auto mt-8">
            <div class="bg-orange-50 border border-orange-200 rounded-lg p-4">
                <div class="flex items-start">
                    <svg class="w-5 h-5 text-orange-500 mt-0.5 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                    </svg>
                    <div>
                        <h4 class="text-sm font-medium text-orange-800 mb-1">Accès sécurisé</h4>
                        <div class="text-xs text-orange-700 space-y-1">
                            <p>• Cette section contient des informations sensibles</p>
                            <p>• Votre mot de passe ne sera pas stocké après confirmation</p>
                            <p>• La session expirera automatiquement après inactivité</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Support -->
        <div class="text-center mt-6">
            <p class="text-sm text-gray-500 mb-2">Problème d'accès ?</p>
            <a href="mailto:support@tuxitvault.fr" class="text-green-600 hover:text-green-700 font-medium transition text-sm">
                Contactez notre support →
            </a>
        </div>
    </div>
</template>
