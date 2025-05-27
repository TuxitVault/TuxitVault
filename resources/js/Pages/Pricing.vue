<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
</script>

<template>
    <AuthenticatedLayout>
        <div class="max-w-4xl px-4 py-12 mx-auto">
            <!-- Title -->
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900">Choose Your Plan</h2>
                <p class="mt-2 text-lg text-gray-600">Simple monthly pricing. No hidden fees.</p>
            </div>

            <!-- Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <!-- Basic Plan -->
                <div class="flex flex-col justify-between border border-gray-200 text-center rounded-2xl p-8 shadow-sm bg-white">
                    <div>
                        <!-- Placeholder for badge -->
                        <span class="mb-2 inline-block py-1 px-3 text-xs font-bold rounded-full invisible">
                            Placeholder
                        </span>

                        <h4 class="font-semibold text-xl text-gray-900">Basic Monthly</h4>
                        <span class="mt-4 font-bold text-5xl text-gray-900">
                            <span class="text-2xl align-top -ml-1">€</span>9.99
                        </span>
                        <p class="mt-2 text-sm text-gray-500">Essential features for personal use.</p>
                    </div>

                    <a
                        :href="route('checkout', { plan: 'price_1RTIkqGgofiP5UMmYOAcDqfb' })"
                        class="mt-6 py-3 px-6 inline-flex justify-center items-center text-sm font-semibold rounded-lg bg-indigo-600 text-white hover:bg-indigo-700 transition"
                    >
                        Get Started
                    </a>
                </div>



                <div class="flex flex-col justify-between border-2 border-indigo-600 text-center rounded-2xl p-8 shadow-md bg-indigo-50">
                    <div>
                        <span class="mb-2 inline-block py-1 px-3 text-xs font-bold rounded-full bg-indigo-200 text-indigo-800">
                            Most Popular
                        </span>
                        <h4 class="font-semibold text-xl text-gray-900">Pro Monthly</h4>
                        <span class="mt-4 font-bold text-5xl text-gray-900">
                            <span class="text-2xl align-top -ml-1">€</span>19.99
                        </span>
                        <p class="mt-2 text-sm text-gray-600">Advanced tools for power users.</p>
                    </div>

                    <a
                        :href="route('checkout', { plan: 'price_1RTITKGgofiP5UMmJMUfET5h' })"
                        class="mt-6 py-3 px-6 inline-flex justify-center items-center text-sm font-semibold rounded-lg bg-indigo-600 text-white hover:bg-indigo-700 transition"
                    >
                        Get Started
                    </a>
                </div>

            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>
</style>
