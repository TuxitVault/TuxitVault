<template>
    <AuthenticatedLayout>
        <div class="bg-gradient-to-br from-green-50 via-white to-green-50 py-6">
            <div class="max-w-4xl px-4 mx-auto">
                <!-- Header Section -->
                <div class="text-center mb-8">
                    <h1 class="text-2xl font-bold text-gray-900 mb-2">
                        Choisissez votre formule
                    </h1>
                    <p class="text-base text-gray-600">
                        Des tarifs simples et transparents, sans frais cachés.
                    </p>
                </div>

                <!-- Pricing Cards -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 max-w-3xl mx-auto">
                    <!-- Basic Plan -->
                    <div class="flex flex-col justify-between border border-gray-200 text-center rounded-xl p-5 shadow-lg bg-white hover:shadow-2xl transition-all duration-300 transform hover:scale-105 cursor-pointer">
                        <div>
                            <!-- Badge invisible pour alignement -->
                            <span class="mb-2 inline-block py-1 px-2 text-xs font-bold rounded-full invisible">
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
                            :href="route('checkout', { plan: 'price_1RTIkqGgofiP5UMmYOAcDqfb' })"
                            class="w-full py-2 px-4 inline-flex justify-center items-center text-sm font-semibold rounded-lg bg-gray-900 text-white hover:bg-gray-800 transition-all duration-200"
                        >
                            Commencer
                        </a>
                    </div>

                    <!-- Pro Plan -->
                    <div class="flex flex-col justify-between border-2 border-green-600 text-center rounded-xl p-5 shadow-xl bg-white hover:shadow-2xl transition-all duration-300 transform hover:scale-105 cursor-pointer relative">
                        <!-- Badge populaire -->
                        <div class="absolute -top-2 left-1/2 transform -translate-x-1/2">
                            <span class="bg-green-600 text-white px-3 py-1 rounded-full text-xs font-semibold shadow-lg">
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
                            :href="route('checkout', { plan: 'price_1RTITKGgofiP5UMmJMUfET5h' })"
                            class="w-full py-2 px-4 inline-flex justify-center items-center text-sm font-semibold rounded-lg bg-green-600 text-white hover:bg-green-700 transition-all duration-200 shadow-lg"
                        >
                            Commencer
                        </a>
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
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
</script>
