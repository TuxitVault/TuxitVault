<template>
    <form class="w-[600px] h-[80px] flex items-center" @submit.prevent="performSearch">
        <TextInput
            type="text"
            class="block w-full mr-2"
            v-model="form.search"
            autocomplete="off"
            placeholder="Rechercher des fichiers et des dossiers"
            @input="onSearchInput"
        />
        <button
            type="submit"
            class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition-colors duration-200 flex items-center"
            :disabled="form.processing"
        >
            <svg v-if="form.processing" class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            <svg v-else class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
        </button>
        <button
            v-if="form.search"
            type="button"
            class="ml-2 px-3 py-2 text-gray-500 hover:text-gray-700 transition-colors duration-200"
            @click="clearSearch"
            title="Effacer la recherche"
        >
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
    </form>
</template>

<script setup>
import TextInput from "@/Components/TextInput.vue";
import { useForm, router, usePage } from "@inertiajs/vue3";
import { watch, onMounted } from "vue";

const page = usePage();

const form = useForm({
    search: '',
});

onMounted(() => {
    const urlParams = new URLSearchParams(window.location.search);
    const searchParam = urlParams.get('search');
    if (searchParam) {
        form.search = searchParam;
    }
});

let searchTimeout = null;

function onSearchInput() {
    clearTimeout(searchTimeout);
    searchTimeout = setTimeout(() => {
        performSearch();
    }, 500);
}

function performSearch() {
    const params = {};

    if (form.search.trim()) {
        params.search = form.search.trim();
    }

    const currentFolder = page.props.folder?.path;

    let routeName = 'myFiles';
    if (window.location.pathname.includes('/trash')) {
        routeName = 'trash';
    } else if (window.location.pathname.includes('/shared-with-me')) {
        routeName = 'sharedWithMe';
    } else if (window.location.pathname.includes('/shared-by-me')) {
        routeName = 'sharedByMe';
    }

    let routeParams = {};
    if (currentFolder && routeName === 'myFiles') {
        routeParams.folder = currentFolder;
    }

    router.get(route(routeName, routeParams), params, {
        preserveState: true,
        preserveScroll: true,
        replace: true,
        onStart: () => {
            form.processing = true;
        },
        onFinish: () => {
            form.processing = false;
        }
    });
}

function clearSearch() {
    form.search = '';
    performSearch();
}

watch(() => page.url, () => {
    const urlParams = new URLSearchParams(window.location.search);
    const searchParam = urlParams.get('search') || '';
    if (form.search !== searchParam) {
        form.search = searchParam;
    }
});
</script>
