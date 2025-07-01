<template>
    <button
        @click="verifyIntegrity"
        :disabled="loading"
        class="flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 disabled:bg-blue-400
               text-white font-medium rounded-lg transition-colors duration-200 mr-2"
        :class="{ 'opacity-50 cursor-not-allowed': loading }"
    >
        <svg v-if="loading" class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>

        <svg v-else class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>

        {{ loading ? 'Vérification...' : 'Vérifier l\'intégrité' }}
    </button>
</template>

<script setup>
import { ref } from 'vue'
import { router } from '@inertiajs/vue3'
import {showErrorNotification, showSuccessNotification} from "@/event-bus.js";

const emit = defineEmits(['verification-complete'])

const loading = ref(false)

const verifyIntegrity = async () => {
    loading.value = true

    router.post(route('files.verifyIntegrity'), {}, {
        preserveState: true,
        preserveScroll: true,
        onSuccess: (page) => {
            const message = page.props.flash?.verification_message
            const summary = page.props.flash?.verification_summary

            if (message) {
                showSuccessNotification(message)
            } else if (summary) {
                showSuccessNotification(`Vérification terminée: ${summary.total_files} fichiers vérifiés, ${summary.verified} intacts, ${summary.modified} modifiés`)
            } else {
                showSuccessNotification('Vérification d\'intégrité terminée avec succès!')
            }

            // Rafraîchir la liste des fichiers
            router.reload({ only: ['files'] })

            emit('verification-complete', page.props.flash)
        },
        onError: (errors) => {
            console.error('Erreurs:', errors)
            showErrorNotification('Erreur lors de la vérification de l\'intégrité')
        },
        onFinish: () => {
            loading.value = false
        }
    })
}
</script>
