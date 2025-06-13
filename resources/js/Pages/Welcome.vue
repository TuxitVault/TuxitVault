<script setup>
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    laravelVersion: {
        type: String,
        required: true,
    },
    phpVersion: {
        type: String,
        required: true,
    },
});

</script>

<template>
    <Head title="Welcome" />

    <div class="bg-gradient-to-b from-green-800 to-white h-screen w-full">
        <header class="h-1/3 flex flex-col px-6">
            <nav v-if="canLogin" class="flex justify-end pt-6">
                <div class="flex space-x-4">
                    <Link
                        v-if="$page.props.auth.user"
                        :href="route('myFiles')"
                        class="text-white hover:text-gray-300 transition font-medium"
                    >
                        Dashboard
                    </Link>
                    <template v-else>
                        <Link
                            :href="route('login')"
                            class="text-white hover:text-gray-300 transition font-medium"
                        >
                            Se connecter
                        </Link>
                        <Link
                            v-if="canRegister"
                            :href="route('register')"
                            class="text-white hover:text-gray-300 transition font-medium"
                        >
                            Créer un compte
                        </Link>
                    </template>
                </div>
            </nav>

            <div class="flex flex-col items-center text-center">
                <img src="/images/logo.png" alt="TuxitVault" class="w-44 h-44" />
                <h1 class="text-5xl font-extrabold text-white drop-shadow-lg">
                    TuxitVault
                </h1>
            </div>
        </header>

<main class="h-2/3 flex flex-col items-center justify-center px-4 gap-6">
    <!-- Carte d’intro -->
    <div class="bg-white rounded-2xl shadow-lg p-6 max-w-md w-full text-center">
        <p class="text-gray-700 text-lg font-medium">
            Votre nouvel outil de sauvegarde numérique<br />
            Inscrivez-vous et découvrez nos offres :
        </p>
    </div>

    <!-- Cartes de tarifs côte à côte -->
    <div class="flex flex-nowrap justify-center gap-6 mt-4 max-w-5xl w-full overflow-auto">
        <!-- Basic Monthly -->
        <div class="flex flex-col justify-between border border-gray-200 text-center rounded-2xl p-8 shadow-sm bg-white max-w-sm w-full">
            <div>
                <span class="mb-2 inline-block py-1 px-3 text-xs font-bold rounded-full invisible">
                    Placeholder
                </span>
                <h4 class="font-semibold text-xl text-gray-900">Basic Monthly</h4>
                <span class="mt-4 font-bold text-5xl text-gray-900">
                    <span class="text-2xl align-top -ml-1">€</span>9.99
                </span>
                <p class="mt-2 text-sm text-gray-500">Essential features for personal use.</p>
            </div>
        </div>

        <div class="flex flex-col justify-between border border-gray-200 text-center rounded-2xl p-8 shadow-sm bg-white max-w-sm w-full">
            <div>
                <span class="mb-2 inline-block py-1 px-3 text-xs font-bold rounded-full invisible">
                    Placeholder
                </span>
                <h4 class="font-semibold text-xl text-gray-900">Pro Monthly</h4>
                <span class="mt-4 font-bold text-5xl text-gray-900">
                    <span class="text-2xl align-top -ml-1">€</span>19.99
                </span>
                <p class="mt-2 text-sm text-gray-600">Advanced tools for power users.</p>
            </div>
        </div>
    </div>
</main>


    </div>
</template>

