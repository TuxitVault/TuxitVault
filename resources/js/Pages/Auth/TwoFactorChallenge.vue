<script setup>
import { nextTick, ref } from 'vue';
import { Head, useForm } from '@inertiajs/vue3';
import AuthenticationCard from '@/Components/AuthenticationCard.vue';
import AuthenticationCardLogo from '@/Components/AuthenticationCardLogo.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';

const recovery = ref(false);

const form = useForm({
    code: '',
    recovery_code: '',
});

const recoveryCodeInput = ref(null);
const codeInput = ref(null);

const toggleRecovery = async () => {
    recovery.value ^= true;

    await nextTick();

    if (recovery.value) {
        recoveryCodeInput.value.focus();
        form.code = '';
    } else {
        codeInput.value.focus();
        form.recovery_code = '';
    }
};

const submit = () => {
    form.post(route('two-factor.login'));
};
</script>

<template>
    <Head title="Authentification à deux facteurs" />

    <div class="min-h-screen bg-gradient-to-br from-green-50 via-white to-green-50 flex flex-col justify-center py-12 sm:px-6 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-md">
            <!-- Logo et titre -->
            <div class="text-center mb-8">
                <img src="/images/logo.png" alt="TuxitVault" class="w-20 h-20 mx-auto mb-4" />
                <h1 class="text-3xl font-bold text-gray-900">Vérification de sécurité</h1>
                <p class="mt-2 text-gray-600">Confirmez votre identité pour accéder à votre compte</p>
            </div>
        </div>

        <div class="sm:mx-auto sm:w-full sm:max-w-md">
            <div class="bg-white py-8 px-6 shadow-xl rounded-2xl sm:px-10 border border-gray-100">
                <!-- Icône de sécurité -->
                <div class="flex justify-center mb-6">
                    <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center">
                        <svg class="w-8 h-8 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                    </div>
                </div>

                <!-- Instructions -->
                <div class="mb-6 text-center">
                    <template v-if="!recovery">
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Code d'authentification</h3>
                        <p class="text-sm text-gray-600">
                            Veuillez entrer le code à 6 chiffres généré par votre application d'authentification
                        </p>
                    </template>
                    <template v-else>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Code de récupération</h3>
                        <p class="text-sm text-gray-600">
                            Entrez l'un de vos codes de récupération d'urgence
                        </p>
                    </template>
                </div>

                <form @submit.prevent="submit" class="space-y-6">
                    <!-- Code d'authentification -->
                    <div v-if="!recovery">
                        <InputLabel for="code" value="Code d'authentification" class="text-gray-700 font-medium" />
                        <TextInput
                            id="code"
                            ref="codeInput"
                            v-model="form.code"
                            type="text"
                            inputmode="numeric"
                            class="mt-2 block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 transition duration-200 text-center text-lg font-mono tracking-widest"
                            autofocus
                            autocomplete="one-time-code"
                            placeholder="123456"
                            maxlength="6"
                        />
                        <InputError class="mt-2" :message="form.errors.code" />

                        <!-- Aide visuelle -->
                        <div class="mt-3 flex justify-center">
                            <div class="flex items-center text-xs text-gray-500">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                </svg>
                                Ouvrez votre app d'authentification
                            </div>
                        </div>
                    </div>

                    <!-- Code de récupération -->
                    <div v-else>
                        <InputLabel for="recovery_code" value="Code de récupération" class="text-gray-700 font-medium" />
                        <TextInput
                            id="recovery_code"
                            ref="recoveryCodeInput"
                            v-model="form.recovery_code"
                            type="text"
                            class="mt-2 block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 transition duration-200 text-center font-mono"
                            autocomplete="one-time-code"
                            placeholder="xxxx-xxxx-xxxx"
                        />
                        <InputError class="mt-2" :message="form.errors.recovery_code" />

                        <!-- Aide visuelle pour recovery -->
                        <div class="mt-3 flex justify-center">
                            <div class="flex items-center text-xs text-gray-500">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M3 7v10a2 2 0 002 2h10a2 2 0 002-2V9a2 2 0 00-2-2h-1V5a3 3 0 00-6 0v2H7a2 2 0 00-2 2zM9 5a1 1 0 012 0v2H9V5z" clip-rule="evenodd" />
                                </svg>
                                Code fourni lors de la configuration
                            </div>
                        </div>
                    </div>

                    <!-- Boutons d'action -->
                    <div class="flex flex-col space-y-4">
                        <!-- Bouton de connexion -->
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
                            {{ form.processing ? 'Vérification...' : 'Se connecter' }}
                        </PrimaryButton>

                        <!-- Divider -->
                        <div class="relative">
                            <div class="absolute inset-0 flex items-center">
                                <div class="w-full border-t border-gray-300"></div>
                            </div>
                            <div class="relative flex justify-center text-sm">
                                <span class="px-2 bg-white text-gray-500">ou</span>
                            </div>
                        </div>

                        <!-- Bouton pour alterner entre code et recovery -->
                        <button
                            type="button"
                            @click.prevent="toggleRecovery"
                            class="w-full flex items-center justify-center py-2 px-4 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition duration-200"
                        >
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                            </svg>
                            <template v-if="!recovery">
                                Utiliser un code de récupération
                            </template>
                            <template v-else>
                                Utiliser le code d'authentification
                            </template>
                        </button>
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
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                <div class="flex items-start">
                    <svg class="w-5 h-5 text-blue-500 mt-0.5 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                    </svg>
                    <div>
                        <h4 class="text-sm font-medium text-blue-800 mb-1">Sécurité renforcée</h4>
                        <p class="text-xs text-blue-700">
                            Cette étape supplémentaire protège votre compte contre les accès non autorisés.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
