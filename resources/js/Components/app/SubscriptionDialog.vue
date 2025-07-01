<template>
    <TransitionRoot appear :show="showDialog" as="template">
        <Dialog as="div" @close="closeDialog" class="relative z-50">
            <TransitionChild
                as="template"
                enter="duration-300 ease-out"
                enter-from="opacity-0"
                enter-to="opacity-100"
                leave="duration-200 ease-in"
                leave-from="opacity-100"
                leave-to="opacity-0"
            >
                <div class="fixed inset-0 bg-black bg-opacity-25" />
            </TransitionChild>

            <div class="fixed inset-0 overflow-y-auto">
                <div class="flex min-h-full items-center justify-center p-4 text-center">
                    <TransitionChild
                        as="template"
                        enter="duration-300 ease-out"
                        enter-from="opacity-0 scale-95"
                        enter-to="opacity-100 scale-100"
                        leave="duration-200 ease-in"
                        leave-from="opacity-100 scale-100"
                        leave-to="opacity-0 scale-95"
                    >
                        <DialogPanel class="w-full max-w-md transform overflow-hidden rounded-2xl bg-white p-6 text-left align-middle shadow-xl transition-all">
                            <!-- Header avec icône -->
                            <div class="flex items-center justify-center w-12 h-12 mx-auto mb-4 bg-green-100 rounded-full">
                                <CreditCardIcon class="w-6 h-6 text-green-600" />
                            </div>

                            <!-- Titre -->
                            <DialogTitle as="h3" class="text-lg font-semibold leading-6 text-gray-900 text-center mb-2">
                                {{ dialogData.title }}
                            </DialogTitle>

                            <!-- Message -->
                            <div class="mt-2 mb-6">
                                <p class="text-sm text-gray-600 text-center leading-relaxed">
                                    {{ dialogData.message }}
                                </p>
                            </div>

                            <!-- Actions -->
                            <div class="flex flex-col space-y-3">
                                <button
                                    type="button"
                                    class="w-full inline-flex justify-center rounded-lg border border-transparent bg-green-600 px-4 py-3 text-sm font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition-all duration-200 transform hover:scale-105"
                                    @click="navigateToPricing"
                                >
                                    {{ dialogData.actionText }}
                                </button>

                                <button
                                    type="button"
                                    class="w-full inline-flex justify-center rounded-lg border border-gray-300 bg-white px-4 py-3 text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2"
                                    @click="closeDialog"
                                >
                                    Plus tard
                                </button>
                            </div>

                            <!-- Petite note informative -->
                            <div class="mt-4 p-3 bg-green-50 rounded-lg">
                                <p class="text-xs text-green-700 text-center">
                                    💡 Débloquez le téléchargement illimité, plus d'espace de stockage et bien plus encore !
                                </p>
                            </div>
                        </DialogPanel>
                    </TransitionChild>
                </div>
            </div>
        </Dialog>
    </TransitionRoot>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue';
import { router } from '@inertiajs/vue3';
import { emitter, SHOW_SUBSCRIPTION_DIALOG } from '@/event-bus.js';
import { Dialog, DialogPanel, DialogTitle, TransitionChild, TransitionRoot } from '@headlessui/vue';
import { CreditCardIcon } from '@heroicons/vue/24/outline';

const showDialog = ref(false);
const dialogData = ref({
    title: '',
    message: '',
    actionText: '',
    actionUrl: ''
});

function showSubscriptionDialog(data) {
    dialogData.value = data;
    showDialog.value = true;
}

function closeDialog() {
    showDialog.value = false;
}

function navigateToPricing() {
    router.visit(dialogData.value.actionUrl);
    closeDialog();
}

onMounted(() => {
    emitter.on(SHOW_SUBSCRIPTION_DIALOG, showSubscriptionDialog);
});

onUnmounted(() => {
    emitter.off(SHOW_SUBSCRIPTION_DIALOG, showSubscriptionDialog);
});
</script>
