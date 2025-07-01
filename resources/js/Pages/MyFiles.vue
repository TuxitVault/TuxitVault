<template>
    <AuthenticatedLayout>
        <nav v-if="props.subscribed" class="flex items-center justify-between p-1 mb-3">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li v-for="ans of ancestors.data" :key="ans.id" class="inline-flex items-center">
                    <Link v-if="!ans.parent_id" :href="route('myFiles')"
                          class="sticky top-0 inline-flex items-center text-sm font-medium text-gray-700 hover:text-green-500 dark:text-gray-400
                  dark:hover:text-green">
                        <HomeIcon class="w-4 h-4"/>
                        My Files
                    </Link>
                    <div v-else class="flex items-center">
                        <svg aria-hidden="true" class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20"
                             xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                  d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                  clip-rule="evenodd"></path>
                        </svg>
                        <Link :href="route('myFiles', {folder: ans.path})"
                              class="ml-1 text-sm font-medium text-gray-700 hover:text-green-500 md:ml-2 dark:text-gray-400 dark:hover:text-green">
                            {{ ans.name }}
                        </Link>
                    </div>
                </li>
            </ol>

            <div class="flex items-center space-x-2">
                <VerifyIntegrityButton @verification-complete="onVerificationComplete" />
                <ShareFilesButton :all-selected="allSelected" :selected-ids="selectedIds" />
                <DownloadFileButton :all="allSelected" :ids="selectedIds" />
                <DeleteFileButton :delete-all="allSelected" :delete-ids="selectedIds" @delete="onDelete"/>
            </div>
        </nav>

        <div v-if="props.subscribed">
            <div v-if="searchQuery" class="mb-4 p-3 bg-blue-50 border border-blue-200 rounded-lg">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        <span class="text-blue-800 font-medium">
                            Résultats de recherche pour : "{{ searchQuery }}"
                        </span>
                        <span class="text-blue-600 ml-2">
                            ({{ allFiles.data.length }} résultat{{ allFiles.data.length > 1 ? 's' : '' }})
                        </span>
                    </div>
                    <button
                        @click="clearSearch"
                        class="text-blue-600 hover:text-blue-800 underline text-sm"
                    >
                        Effacer la recherche
                    </button>
                </div>
            </div>

            <div class="flex-1 overflow-auto">
                <table class="min-w-full">
                    <thead class="bg-gray-100 border-b">
                    <tr>
                        <th class="text-sm font-medium text-gray-900 px-6 py-4 text-left w-[30px] max-w-[30px] pr-0">
                            <Checkbox @change="onSelectAllChange" v-model:checked="allSelected" />
                        </th>
                        <th class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                            Nom
                        </th>
                        <th class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                            Propriétaire
                        </th>
                        <th class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                            Dernière modification
                        </th>
                        <th class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                            Taille
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="file of allFiles.data" :key="file.id"
                        @click="$event => toggleFileSelect(file)"
                        @dblclick="openFolder(file)"
                        class="border-b transition duration-300 ease-in-out hover:bg-green-100 cursor-pointer"
                        :class="(selected[file.id] || allSelected) ? 'bg-green-50' : 'bg-white'">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 w-[30px] max-w-[30px] pr-0">
                            <Checkbox @change="$event => onSelectCheckboxChange(file)" v-model="selected[file.id]" :checked="selected[file.id] || allSelected" />
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 flex items-center">
                            <IntegrityIndicator :file="file" />
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            {{ file.owner }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            {{ file.updated_at }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            {{ file.size }}
                        </td>
                    </tr>
                    </tbody>
                </table>

                <div v-if="!allFiles.data.length" class="py-8 text-center text-sm text-gray-400">
                    <div v-if="searchQuery">
                        <svg class="w-12 h-12 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        <p class="text-lg text-gray-500 mb-2">Aucun résultat trouvé</p>
                        <p class="text-sm text-gray-400">
                            Essayez de modifier votre recherche ou
                            <button @click="clearSearch" class="text-blue-600 hover:text-blue-800 underline">
                                effacer les filtres
                            </button>
                        </p>
                    </div>
                    <div v-else>
                        Il n'y a aucune donnée dans ce dossier
                    </div>
                </div>
                <div ref="loadMoreIntersect"></div>
            </div>
        </div>

        <div v-else class="flex flex-col items-center justify-center min-h-[60vh] px-4 text-center">
            <div class="mb-6 p-6 bg-gray-100 rounded-full">
                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                          d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                </svg>
            </div>

            <div class="max-w-md mx-auto">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Accès restreint</h2>
                <p class="text-gray-600 mb-2 leading-relaxed">
                    Pour accéder à vos fichiers et profiter de toutes les fonctionnalités,
                    vous devez disposer d'un abonnement actif.
                </p>
                <p class="text-sm text-gray-500 mb-8">
                    Choisissez le plan qui correspond le mieux à vos besoins.
                </p>

                <div class="space-y-3">
                    <button
                        @click="navigateToPricing"
                        :disabled="isNavigating"
                        class="w-full px-8 py-3 bg-green-600 hover:bg-green-700 disabled:bg-green-400
                               text-white font-semibold rounded-lg transition-all duration-200
                               transform hover:scale-105 hover:shadow-lg focus:outline-none focus:ring-2
                               focus:ring-green-500 focus:ring-offset-2 flex items-center justify-center"
                    >
                        <span v-if="!isNavigating">Voir les abonnements</span>
                        <span v-else class="flex items-center">
                            <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Chargement...
                        </span>
                    </button>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import {HomeIcon} from "@heroicons/vue/20/solid";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {router, Link} from "@inertiajs/vue3";
import FileIcon from "@/Components/app/FileIcon.vue";
import { computed, onMounted, onUnmounted, onUpdated, ref } from "vue";
import {httpGet} from "@/Helper/http-helper.js";
import Checkbox from "@/Components/Checkbox.vue";
import DeleteFileButton from "@/Components/app/DeleteFileButton.vue";
import DownloadFileButton from "@/Components/app/DownloadFileButton.vue";
import ShareFilesButton from "@/Components/app/ShareFilesButton.vue";
import IntegrityIndicator from "@/Components/app/IntegrityIndicator.vue";
import VerifyIntegrityButton from "@/Components/app/VerifyIntegrityButton.vue";

const props = defineProps({
    files: Object,
    folder: Object,
    ancestors: Object,
    subscribed: Boolean
})

const isNavigating = ref(false);

const selectedIds = computed(() => Object.entries(selected.value).filter(a => a[1]).map(a => a[0]))

const allSelected = ref(false);
const selected = ref({});

const loadMoreIntersect = ref(null)

const allFiles = ref({
    data: props.files.data,
    next: props.files.links.next
})

const searchQuery = computed(() => {
    const urlParams = new URLSearchParams(window.location.search);
    return urlParams.get('search') || '';
});

function openFolder(file) {
    if (!file.is_folder) {
        return;
    }

    router.visit(route('myFiles', {folder: file.path}))
}

function navigateToPricing() {
    isNavigating.value = true;

    router.visit(route('pricing'), {
        method: 'get',
        preserveState: false,
        preserveScroll: false,
        onFinish: () => {
            isNavigating.value = false;
        },
        onError: () => {
            isNavigating.value = false;
            console.error('Erreur lors de la navigation vers la page des prix');
        }
    });
}

function loadMore() {
    console.log("load more");
    console.log(allFiles.value.next);

    if (allFiles.value.next === null) {
        return
    }

    httpGet(allFiles.value.next)
        .then(res => {
            allFiles.value.data = [...allFiles.value.data, ...res.data]
            allFiles.value.next = res.links.next
        })
}

function onSelectAllChange() {
    allFiles.value.data.forEach(f => {
        selected.value[f.id] = allSelected.value;
    })
}

function toggleFileSelect(file) {
    selected.value[file.id] = !selected.value[file.id];
    onSelectCheckboxChange(file)
}

function onSelectCheckboxChange(file) {
    if (!selected.value[file.id]) {
        allSelected.value = false;
    } else {
        let checked = true;

        for (let file of allFiles.value.data) {
            if (!selected.value[file.id]) {
                checked = false;
                break;
            }
        }

        allSelected.value = checked
    }
}

function onDelete() {
    allSelected.value = false
    selected.value = {}
}

function clearSearch() {
    const currentFolder = props.folder?.path;
    const params = {};

    if (currentFolder) {
        router.get(route('myFiles', { folder: currentFolder }), params, {
            preserveState: true,
            preserveScroll: true,
            replace: true
        });
    } else {
        router.get(route('myFiles'), params, {
            preserveState: true,
            preserveScroll: true,
            replace: true
        });
    }
}

onUpdated(() => {
    allFiles.value = {
        data: props.files.data,
        next: props.files.links.next
    }
})

onMounted(() => {
    if (props.subscribed && loadMoreIntersect.value) {
        const observer = new IntersectionObserver((entries) => entries.forEach(entry => entry.isIntersecting && loadMore()), {
            rootMargin: '-250px 0px 0px 0px'
        })

        observer.observe(loadMoreIntersect.value)

        onUnmounted(() => {
            observer.disconnect()
        })
    }
})

function onVerificationComplete(data) {
    console.log('Vérification terminée:', data);
}

</script>

<style scoped>

</style>
