<script setup>
import { Head, useForm, Link } from '@inertiajs/vue3';
import AuthenticationCard from '@/Components/AuthenticationCard.vue';
import AuthenticationCardLogo from '@/Components/AuthenticationCardLogo.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';

const props = defineProps({
    email: String,
    token: String,
});

const form = useForm({
    token: props.token,
    email: props.email,
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('password.update'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <Head title="Nouveau mot de passe" />

    <div class="min-h-screen bg-gradient-to-br from-green-50 via-white to-green-50 flex flex-col justify-center py-12 sm:px-6 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-md">
            <!-- Logo et titre -->
            <div class="text-center mb-8">
                <img src="/images/logo.png" alt="TuxitVault" class="w-20 h-20 mx-auto mb-4" />
                <h1 class="text-3xl font-bold text-gray-900">Nouveau mot de passe</h1>
                <p class="mt-2 text-gray-600">Créez un mot de passe sécurisé pour votre compte</p>
            </div>
        </div>

        <div class="sm:mx-auto sm:w-full sm:max-w-md">
            <div class="bg-white py-8 px-6 shadow-xl rounded-2xl sm:px-10 border border-gray-100">
                <!-- Icône de sécurité -->
                <div class="flex justify-center mb-6">
                    <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center">
                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c0 3.517-1.009 6.799-2.753 9.571m-3.44-2.04l.054-.09A13.916 13.916 0 008 11a4 4 0 118 0c0 1.017-.07 2.019-.203 3m-2.118 6.844A21.88 21.88 0 0015.171 17m3.839 1.132c.645-2.266.99-4.659.99-7.132A8 8 0 008 4.07M3 15.364c.64-1.319 1-2.8 1-4.364 0-1.457.39-2.823 1.07-4" />
                        </svg>
                    </div>
                </div>

                <!-- Instructions -->
                <div class="mb-6 text-center">
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Définissez votre nouveau mot de passe</h3>
                    <p class="text-sm text-gray-600">
                        Choisissez un mot de passe fort et unique pour sécuriser votre compte.
                    </p>
                </div>

                <form @submit.prevent="submit" class="space-y-6">
                    <!-- Email (lecture seule) -->
                    <div>
                        <InputLabel for="email" value="Adresse email" class="text-gray-700 font-medium" />
                        <TextInput
                            id="email"
                            v-model="form.email"
                            type="email"
                            class="mt-2 block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm bg-gray-50 text-gray-500 cursor-not-allowed"
                            required
                            readonly
                            autocomplete="username"
                        />
                        <InputError class="mt-2" :message="form.errors.email" />
                        <p class="mt-1 text-xs text-gray-500">Cette adresse ne peut pas être modifiée</p>
                    </div>

                    <!-- Nouveau mot de passe -->
                    <div>
                        <InputLabel for="password" value="Nouveau mot de passe" class="text-gray-700 font-medium" />
                        <TextInput
                            id="password"
                            v-model="form.password"
                            type="password"
                            class="mt-2 block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 transition duration-200"
                            required
                            autocomplete="new-password"
                            placeholder="Minimum 8 caractères"
                        />
                        <InputError class="mt-2" :message="form.errors.password" />

                        <!-- Indicateurs de sécurité -->
                        <div class="mt-2 space-y-1">
                            <div class="flex items-center text-xs">
                                <svg :class="form.password.length >= 8 ? 'text-green-500' : 'text-gray-400'" class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                                <span :class="form.password.length >= 8 ? 'text-green-600' : 'text-gray-500'">Au moins 8 caractères</span>
                            </div>
                            <div class="flex items-center text-xs">
                                <svg :class="/[A-Z]/.test(form.password) && /[a-z]/.test(form.password) ? 'text-green-500' : 'text-gray-400'" class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                                <span :class="/[A-Z]/.test(form.password) && /[a-z]/.test(form.password) ? 'text-green-600' : 'text-gray-500'">Majuscules et minuscules</span>
                            </div>
                            <div class="flex items-center text-xs">
                                <svg :class="/\d/.test(form.password) ? 'text-green-500' : 'text-gray-400'" class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                                <span :class="/\d/.test(form.password) ? 'text-green-600' : 'text-gray-500'">Au moins un chiffre</span>
                            </div>
                        </div>
                    </div>

                    <!-- Confirmation mot de passe -->
                    <div>
                        <InputLabel for="password_confirmation" value="Confirmer le mot de passe" class="text-gray-700 font-medium" />
                        <TextInput
                            id="password_confirmation"
                            v-model="form.password_confirmation"
                            type="password"
                            class="mt-2 block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 transition duration-200"
                            required
                            autocomplete="new-password"
                            placeholder="Répétez votre nouveau mot de passe"
                        />
                        <InputError class="mt-2" :message="form.errors.password_confirmation" />

                        <!-- Indicateur de correspondance -->
                        <div v-if="form.password_confirmation.length > 0" class="mt-2">
                            <div class="flex items-center text-xs">
                                <svg :class="form.password === form.password_confirmation && form.password.length > 0 ? 'text-green-500' : 'text-red-500'" class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path v-if="form.password === form.password_confirmation && form.password.length > 0" fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                    <path v-else fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                                <span :class="form.password === form.password_confirmation && form.password.length > 0 ? 'text-green-600' : 'text-red-600'">
                                    {{ form.password === form.password_confirmation && form.password.length > 0 ? 'Les mots de passe correspondent' : 'Les mots de passe ne correspondent pas' }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Bouton de soumission -->
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
                            {{ form.processing ? 'Mise à jour...' : 'Définir le nouveau mot de passe' }}
                        </PrimaryButton>
                    </div>

                    <!-- Lien retour connexion -->
                    <div class="text-center">
                        <p class="text-sm text-gray-600">
                            Vous vous souvenez de votre mot de passe ?
                            <Link :href="route('login')" class="font-medium text-green-600 hover:text-green-700 transition duration-200">
                                Retour à la connexion
                            </Link>
                        </p>
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

        <!-- Conseils de sécurité -->
        <div class="max-w-md mx-auto mt-8">
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                <div class="flex items-start">
                    <svg class="w-5 h-5 text-blue-500 mt-0.5 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                    </svg>
                    <div>
                        <h4 class="text-sm font-medium text-blue-800 mb-1">Conseils de sécurité</h4>
                        <div class="text-xs text-blue-700 space-y-1">
                            <p>• Utilisez un mot de passe unique pour TuxitVault</p>
                            <p>• Évitez les informations personnelles évidentes</p>
                            <p>• Considérez l'utilisation d'un gestionnaire de mots de passe</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
