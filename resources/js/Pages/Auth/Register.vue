<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import AuthenticationCard from '@/Components/AuthenticationCard.vue';
import AuthenticationCardLogo from '@/Components/AuthenticationCardLogo.vue';
import Checkbox from '@/Components/Checkbox.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';

const form = useForm({
    firstname: '',
    lastname: '',
    email: '',
    password: '',
    password_confirmation: '',
    terms: false,
    professionnal: false,
    companyName: '',
    companySiret: ''
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <Head title="Créer un compte" />

    <div class="min-h-screen bg-gradient-to-br from-green-50 via-white to-green-50 flex flex-col justify-center py-12 sm:px-6 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-md">
            <!-- Logo et titre -->
            <div class="text-center mb-8">
                <img src="/images/logo.png" alt="TuxitVault" class="w-20 h-20 mx-auto mb-4" />
                <h1 class="text-3xl font-bold text-gray-900">Créer votre compte</h1>
                <p class="mt-2 text-gray-600">Rejoignez TuxitVault et sécurisez vos données</p>
            </div>
        </div>

        <div class="sm:mx-auto sm:w-full sm:max-w-md">
            <div class="bg-white py-8 px-6 shadow-xl rounded-2xl sm:px-10 border border-gray-100">
                <form @submit.prevent="submit" class="space-y-6">
                    <!-- Nom et Prénom -->
                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                        <div>
                            <InputLabel for="firstname" value="Prénom" class="text-gray-700 font-medium" />
                            <TextInput
                                id="firstname"
                                v-model="form.firstname"
                                type="text"
                                class="mt-2 block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 transition duration-200"
                                required
                                autofocus
                                autocomplete="firstname"
                                placeholder="Votre prénom"
                            />
                            <InputError class="mt-2" :message="form.errors.firstname" />
                        </div>

                        <div>
                            <InputLabel for="lastname" value="Nom" class="text-gray-700 font-medium" />
                            <TextInput
                                id="lastname"
                                v-model="form.lastname"
                                type="text"
                                class="mt-2 block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 transition duration-200"
                                required
                                autocomplete="lastname"
                                placeholder="Votre nom"
                            />
                            <InputError class="mt-2" :message="form.errors.lastname" />
                        </div>
                    </div>

                    <!-- Email -->
                    <div>
                        <InputLabel for="email" value="Adresse email" class="text-gray-700 font-medium" />
                        <TextInput
                            id="email"
                            v-model="form.email"
                            type="email"
                            class="mt-2 block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 transition duration-200"
                            required
                            autocomplete="username"
                            placeholder="votre@email.com"
                        />
                        <InputError class="mt-2" :message="form.errors.email" />
                    </div>

                    <!-- Mot de passe -->
                    <div>
                        <InputLabel for="password" value="Mot de passe" class="text-gray-700 font-medium" />
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
                            placeholder="Répétez votre mot de passe"
                        />
                        <InputError class="mt-2" :message="form.errors.password_confirmation" />
                    </div>

                    <!-- Case à cocher "Professionnel" -->
                    <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                        <label class="flex items-start space-x-3 cursor-pointer">
                            <Checkbox
                                id="professionnal"
                                v-model:checked="form.professionnal"
                                name="professionnal"
                                class="mt-1 h-5 w-5 text-green-600 border-gray-300 rounded focus:ring-green-500"
                            />
                            <div class="flex-1">
                                <span class="text-sm font-medium text-gray-900">Je suis une entreprise</span>
                                <p class="text-xs text-gray-500 mt-1">Accédez à des fonctionnalités dédiées aux professionnels</p>
                            </div>
                        </label>
                    </div>

                    <!-- Champs supplémentaires pour les professionnels -->
                    <div v-if="form.professionnal" class="space-y-4 bg-green-50 p-4 rounded-lg border border-green-200">
                        <div>
                            <InputLabel for="companyName" value="Nom de la société" class="text-gray-700 font-medium" />
                            <TextInput
                                id="companyName"
                                v-model="form.companyName"
                                type="text"
                                class="mt-2 block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 transition duration-200"
                                required
                                placeholder="Nom de votre entreprise"
                            />
                            <InputError class="mt-2" :message="form.errors.companyName" />
                        </div>

                        <div>
                            <InputLabel for="companySiret" value="Numéro SIRET" class="text-gray-700 font-medium" />
                            <TextInput
                                id="companySiret"
                                v-model="form.companySiret"
                                type="text"
                                class="mt-2 block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 transition duration-200"
                                required
                                placeholder="12345678901234"
                                maxlength="14"
                            />
                            <InputError class="mt-2" :message="form.errors.companySiret" />
                        </div>
                    </div>

                    <!-- Conditions d'utilisation -->
                    <div v-if="$page.props.jetstream.hasTermsAndPrivacyPolicyFeature" class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                        <label class="flex items-start space-x-3 cursor-pointer">
                            <Checkbox
                                id="terms"
                                v-model:checked="form.terms"
                                name="terms"
                                required
                                class="mt-1 h-5 w-5 text-green-600 border-gray-300 rounded focus:ring-green-500"
                            />
                            <div class="flex-1 text-sm text-gray-600">
                                J'accepte les
                                <a target="_blank" :href="route('terms.show')" class="text-green-600 hover:text-green-700 underline font-medium">
                                    Conditions d'utilisation
                                </a>
                                et la
                                <a target="_blank" :href="route('policy.show')" class="text-green-600 hover:text-green-700 underline font-medium">
                                    Politique de confidentialité
                                </a>
                            </div>
                        </label>
                        <InputError class="mt-2" :message="form.errors.terms" />
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
                            {{ form.processing ? 'Création du compte...' : 'Créer mon compte' }}
                        </PrimaryButton>
                    </div>

                    <!-- Lien vers la connexion -->
                    <div class="text-center">
                        <p class="text-sm text-gray-600">
                            Vous avez déjà un compte ?
                            <Link :href="route('login')" class="font-medium text-green-600 hover:text-green-700 transition duration-200">
                                Se connecter
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
    </div>
</template>
