<script setup>
import { Head, Link } from '@inertiajs/vue3';
import Footer from '@/Components/Footer.vue';

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

// Scroll vers la section pricing
const scrollToPricing = () => {
    document.getElementById('pricing-section').scrollIntoView({ behavior: 'smooth' });
};
</script>

<template>
    <Head title="Accueil" />

    <div class="min-h-screen bg-gradient-to-b from-green-800 via-green-600 to-white">
        <!-- Header Hero Section -->
        <header class="relative h-screen flex flex-col">
            <!-- Navigation -->
            <nav v-if="canLogin" class="flex justify-end pt-6 px-6 z-10">
                <div class="flex space-x-4">
                    <Link
                        v-if="$page.props.auth.user"
                        :href="route('myFiles')"
                        class="text-white hover:text-green-200 transition font-medium px-4 py-2 rounded-lg hover:bg-white/10"
                    >
                        Dashboard
                    </Link>
                    <template v-else>
                        <Link
                            :href="route('login')"
                            class="text-white hover:text-green-200 transition font-medium px-4 py-2 rounded-lg hover:bg-white/10"
                        >
                            Se connecter
                        </Link>
                        <Link
                            v-if="canRegister"
                            :href="route('register')"
                            class="bg-white text-green-800 hover:bg-green-50 transition font-medium px-6 py-2 rounded-lg shadow-lg hover:shadow-xl"
                        >
                            Créer un compte
                        </Link>
                    </template>
                </div>
            </nav>

            <!-- Hero Content -->
            <div class="flex-1 flex flex-col items-center justify-center text-center px-6">
                <div class="mb-8">
                    <img src="/images/logo.png" alt="TuxitVault" class="w-32 h-32 mx-auto mb-6 drop-shadow-lg" />
                    <h1 class="text-6xl md:text-7xl font-extrabold text-white drop-shadow-lg mb-4">
                        TuxitVault
                    </h1>
                    <p class="text-xl md:text-2xl text-green-100 font-light max-w-2xl mx-auto mb-8">
                        Votre solution de sauvegarde numérique sécurisée et fiable
                    </p>
                </div>

                <!-- CTA Buttons -->
                <div class="flex flex-col sm:flex-row gap-4 mb-12">
                    <Link
                        v-if="canRegister"
                        :href="route('register')"
                        class="bg-white text-green-800 hover:bg-green-50 transition font-semibold px-8 py-4 rounded-xl shadow-lg hover:shadow-xl transform hover:scale-105 text-lg"
                    >
                        Commencer gratuitement
                    </Link>
                    <button
                        @click="scrollToPricing"
                        class="border-2 border-white text-white hover:bg-white hover:text-green-800 transition font-semibold px-8 py-4 rounded-xl text-lg"
                    >
                        Voir les tarifs
                    </button>
                </div>

                <!-- Features highlights -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 max-w-4xl mx-auto">
                    <div class="text-center text-white">
                        <div class="w-12 h-12 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-3">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <h3 class="font-semibold mb-2">Sécurité maximale</h3>
                        <p class="text-green-100 text-sm">Chiffrement avancé et serveurs sécurisés</p>
                    </div>
                    <div class="text-center text-white">
                        <div class="w-12 h-12 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-3">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z" />
                            </svg>
                        </div>
                        <h3 class="font-semibold mb-2">Accès universel</h3>
                        <p class="text-green-100 text-sm">Vos fichiers partout, tout le temps</p>
                    </div>
                    <div class="text-center text-white">
                        <div class="w-12 h-12 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-3">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h3 class="font-semibold mb-2">Simplicité d'usage</h3>
                        <p class="text-green-100 text-sm">Interface intuitive et moderne</p>
                    </div>
                </div>
            </div>

            <!-- Scroll indicator -->
            <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 animate-bounce">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3" />
                </svg>
            </div>
        </header>

        <!-- Features Section -->
        <section class="py-20 bg-white">
            <div class="max-w-6xl mx-auto px-6">
                <div class="text-center mb-16">
                    <h2 class="text-4xl font-bold text-gray-900 mb-4">
                        Pourquoi choisir TuxitVault ?
                    </h2>
                    <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                        Une solution complète pour tous vos besoins de sauvegarde et de stockage
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <div class="text-center p-6 rounded-xl hover:shadow-lg transition">
                        <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-3">Sauvegarde automatique</h3>
                        <p class="text-gray-600">Vos fichiers sont automatiquement sauvegardés et synchronisés en temps réel</p>
                    </div>

                    <div class="text-center p-6 rounded-xl hover:shadow-lg transition">
                        <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-3">Partage sécurisé</h3>
                        <p class="text-gray-600">Partagez vos fichiers en toute sécurité avec qui vous voulez</p>
                    </div>

                    <div class="text-center p-6 rounded-xl hover:shadow-lg transition">
                        <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M12.395 2.553a1 1 0 00-1.45-.385c-.345.23-.614.558-.822.88-.214.33-.403.713-.57 1.116-.334.804-.614 1.768-.84 2.734a31.365 31.365 0 00-.613 3.58 2.64 2.64 0 01-.945-1.067c-.328-.68-.398-1.534-.398-2.654A1 1 0 005.05 6.05 6.981 6.981 0 003 11a7 7 0 1011.95-4.95c-.592-.591-.98-.985-1.348-1.467-.363-.476-.724-1.063-1.207-2.03zM12.12 15.12A3 3 0 017 13s.879.5 2.5.5c0-1 .5-4 1.25-4.5.5 1 .786 1.293 1.371 1.879A2.99 2.99 0 0113 13a2.99 2.99 0 01-.879 2.121z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-3">Performance optimale</h3>
                        <p class="text-gray-600">Téléchargements rapides et interface réactive</p>
                    </div>

                    <div class="text-center p-6 rounded-xl hover:shadow-lg transition">
                        <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-3">Support réactif</h3>
                        <p class="text-gray-600">Notre équipe vous accompagne 24h/24 et 7j/7</p>
                    </div>

                    <div class="text-center p-6 rounded-xl hover:shadow-lg transition">
                        <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-3">Conformité RGPD</h3>
                        <p class="text-gray-600">Vos données sont protégées selon les standards européens</p>
                    </div>

                    <div class="text-center p-6 rounded-xl hover:shadow-lg transition">
                        <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-3">Multi-plateforme</h3>
                        <p class="text-gray-600">Accessible depuis tous vos appareils : ordinateur, mobile, tablette</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Pricing Section -->
        <section id="pricing-section" class="py-20 bg-gray-50">
            <div class="max-w-4xl mx-auto px-6">
                <div class="text-center mb-16">
                    <h2 class="text-4xl font-bold text-gray-900 mb-4">
                        Choisissez votre formule
                    </h2>
                    <p class="text-xl text-gray-600">
                        Des tarifs transparents, sans frais cachés
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-4xl mx-auto">
                    <!-- Basic Plan -->
                    <div class="flex flex-col justify-between border border-gray-200 text-center rounded-2xl p-8 shadow-sm bg-white hover:shadow-lg transition">
                        <div>
                            <span class="mb-2 inline-block py-1 px-3 text-xs font-bold rounded-full invisible">
                                Placeholder
                            </span>
                            <h4 class="font-semibold text-2xl text-gray-900 mb-4">Basic Monthly</h4>
                            <div class="mb-6">
                                <span class="font-bold text-5xl text-gray-900">
                                    <span class="text-2xl align-top -ml-1">€</span>9.99
                                </span>
                                <span class="text-gray-500">/mois</span>
                            </div>
                            <p class="text-gray-600 mb-6">Parfait pour un usage personnel</p>

                            <ul class="text-left space-y-3 mb-8">
                                <li class="flex items-center">
                                    <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                    </svg>
                                    <span class="text-gray-700">100 GB de stockage</span>
                                </li>
                                <li class="flex items-center">
                                    <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                    </svg>
                                    <span class="text-gray-700">Partage de fichiers</span>
                                </li>
                                <li class="flex items-center">
                                    <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                    </svg>
                                    <span class="text-gray-700">Support par email</span>
                                </li>
                            </ul>
                        </div>

                        <Link
                            :href="route('register')"
                            class="w-full py-3 px-6 bg-gray-900 text-white rounded-lg hover:bg-gray-800 transition font-semibold"
                        >
                            Commencer
                        </Link>
                    </div>

                    <!-- Pro Plan -->
                    <div class="flex flex-col justify-between border-2 border-green-600 text-center rounded-2xl p-8 shadow-lg bg-white relative hover:shadow-xl transition">
                        <div class="absolute -top-4 left-1/2 transform -translate-x-1/2 z-10">
                            <span class="bg-green-600 text-white px-4 py-1 rounded-full text-sm font-semibold">
                                Le plus populaire
                            </span>
                        </div>

                        <div>
                            <span class="mb-2 inline-block py-1 px-3 text-xs font-bold rounded-full invisible">
                                Placeholder
                            </span>
                            <h4 class="font-semibold text-2xl text-gray-900 mb-4">Pro Monthly</h4>
                            <div class="mb-6">
                                <span class="font-bold text-5xl text-gray-900">
                                    <span class="text-2xl align-top -ml-1">€</span>19.99
                                </span>
                                <span class="text-gray-500">/mois</span>
                            </div>
                            <p class="text-gray-600 mb-6">Pour les utilisateurs avancés</p>

                            <ul class="text-left space-y-3 mb-8">
                                <li class="flex items-center">
                                    <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                    </svg>
                                    <span class="text-gray-700">1 TB de stockage</span>
                                </li>
                                <li class="flex items-center">
                                    <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                    </svg>
                                    <span class="text-gray-700">Partage avancé</span>
                                </li>
                                <li class="flex items-center">
                                    <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                    </svg>
                                    <span class="text-gray-700">Support prioritaire</span>
                                </li>
                                <li class="flex items-center">
                                    <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                    </svg>
                                    <span class="text-gray-700">Historique des versions</span>
                                </li>
                            </ul>
                        </div>

                        <Link
                            :href="route('register')"
                            class="w-full py-3 px-6 bg-green-600 text-white rounded-lg hover:bg-green-700 transition font-semibold"
                        >
                            Commencer
                        </Link>
                    </div>
                </div>

                <div class="text-center mt-12">
                    <p class="text-gray-600 mb-4">Besoin d'une solution sur mesure ?</p>
                    <a href="mailto:support@tuxitvault.fr" class="text-green-600 hover:text-green-700 font-semibold">
                        Contactez notre équipe →
                    </a>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section class="py-20 bg-green-600">
            <div class="max-w-4xl mx-auto text-center px-6">
                <h2 class="text-4xl font-bold text-white mb-4">
                    Prêt à sécuriser vos données ?
                </h2>
                <p class="text-xl text-green-100 mb-8 max-w-2xl mx-auto">
                    Rejoignez des milliers d'utilisateurs qui font confiance à TuxitVault pour leurs sauvegardes
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <Link
                        v-if="canRegister"
                        :href="route('register')"
                        class="bg-white text-green-600 hover:bg-green-50 transition font-semibold px-8 py-4 rounded-xl shadow-lg hover:shadow-xl transform hover:scale-105 text-lg"
                    >
                        Créer mon compte gratuitement
                    </Link>
                    <Link
                        :href="route('pricing')"
                        class="border-2 border-white text-white hover:bg-white hover:text-green-600 transition font-semibold px-8 py-4 rounded-xl text-lg"
                    >
                        Voir tous les tarifs
                    </Link>
                </div>
            </div>
        </section>
    </div>

    <Footer />
</template>

<style scoped>
/* Animation bounce personnalisée */
@keyframes bounce {
    0%, 20%, 53%, 80%, 100% {
        transform: translate3d(0,0,0);
    }
    40%, 43% {
        transform: translate3d(0, -30px, 0);
    }
    70% {
        transform: translate3d(0, -15px, 0);
    }
    90% {
        transform: translate3d(0, -4px, 0);
    }
}

.animate-bounce {
    animation: bounce 2s infinite;
}

/* Scroll smooth */
html {
    scroll-behavior: smooth;
}
</style>
