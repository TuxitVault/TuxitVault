<script setup>

import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
</script>

<template>
    <AuthenticatedLayout>
        <div class="min-h-screen bg-white flex flex-col items-center justify-center text-center px-6">
            <svg class="w-20 h-20 text-green-500 mb-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
            </svg>

            <h1 class="text-3xl font-bold text-gray-800 mb-4">Paiement Réussi</h1>
            <p class="text-lg text-gray-600 mb-8">
                Merci pour votre achat ! Votre abonnement est maintenant actif.
            </p>

            <a :href="route('myFiles')" class="bg-indigo-600 text-white px-6 py-3 rounded-md hover:bg-indigo-700 transition">
                Retour au tableau de bord
            </a>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>

</style>
