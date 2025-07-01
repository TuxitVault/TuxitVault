<template>
    <div class="flex items-center">
        <div v-if="!file.is_folder && file.has_hash" class="mr-2">
            <div
                v-if="file.is_modified"
                class="w-3 h-3 bg-red-500 rounded-full"
                title="Fichier modifié - Intégrité compromise"
            ></div>
            <div
                v-else
                class="w-3 h-3 bg-green-500 rounded-full"
                title="Fichier intact - Intégrité vérifiée"
            ></div>
        </div>

        <div v-else-if="!file.is_folder && !file.has_hash" class="mr-2">
            <div
                class="w-3 h-3 bg-yellow-500 rounded-full"
                title="Hash non généré - Non vérifiable"
            ></div>
        </div>

        <FileIcon :file="file" />

        <span class="ml-2">{{ file.name }}</span>
    </div>
</template>

<script setup>
import FileIcon from './FileIcon.vue'

defineProps({
    file: {
        type: Object,
        required: true
    }
})
</script>
