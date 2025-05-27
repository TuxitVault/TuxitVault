<template>
    <div class="flex">
        <Navigation/>

        <div class="h-screen flex gap-5 justify-stretch w-screen flex-col overflow-y-auto">
            <main @drop.prevent="handleDrop"
              @dragover.prevent="onDragOver"
              @dragleave.prevent="onDragLeave"
              class="h-screen w-full flex justify-between flex-col"
              :class="dragOver ? 'dropzone' : ''">

                <template v-if="dragOver" class="text-gray-500 text-center py-8 text-sm">
                    Déposez les fichiers ici pour les télécharger
                </template>
                <template v-else>
                    <div class="flex items-center justify-between w-full">
                        <SearchForm/>
                        <UserSettingsDropdown/>
                    </div>
                    <div class="flex-1 flex flex-col mx-4 sm:mx-6 md:mx-8">
                        <slot/>
                    </div>
                </template>
            </main>

        </div>
    </div>

    <ErrorDialog />


    <FormProgress :form="fileUploadForm"/>

</template>

<script setup>
import Navigation from "@/Components/app/Navigation.vue";
import SearchForm from "@/Components/app/SearchForm.vue";
import UserSettingsDropdown from "@/Components/app/UserSettingsDropdown.vue";
import {onMounted, ref} from "vue";
import {emitter, FILE_UPLOAD_STARTED, showErrorDialog} from "@/event-bus.js";
import {useForm, usePage} from "@inertiajs/vue3";
import FormProgress from "@/Components/app/FormProgress.vue";
import ErrorDialog from "@/Components/ErrorDialog.vue";


const page = usePage();

const fileUploadForm = useForm({
    files: [],
    relative_paths: [],
    parent_id: null
})



const dragOver = ref(false);



function uploadFiles(files) {
    fileUploadForm.parent_id = page.props.folder.id
    fileUploadForm.files = files
    fileUploadForm.relative_paths = [...files].map(f => f.webkitRelativePath);

    fileUploadForm.post(route('file.store'), {
        onSuccess: () => {

        },
        onError: errors => {
            let message = '';

            if (Object.keys(errors).length > 0) {
                message = errors[Object.keys(errors)[0]]
            } else {
                message = 'Erreur lors du téléchargement du fichier. Veuillez réessayer ultérieurement.'
            }

            showErrorDialog(message)
        },
        onFinish: () => {
            fileUploadForm.clearErrors()
            fileUploadForm.reset();
        }
    })
}


function onDragOver()
{
    dragOver.value = true;
}

function onDragLeave()
{
    dragOver.value = false;
}

function handleDrop(ev)
{
    dragOver.value = false;
    const files = ev.dataTransfer.files

    if (!files.length) {
        return;
    }

    uploadFiles(files);
}


onMounted(() => {
    emitter.on(FILE_UPLOAD_STARTED, uploadFiles)
})

</script>

<style scoped>
.dropzone {
    width: 100%;
    height: 100%;
    color: #8d8d8d;
    border: 2px dashed gray;
    display: flex;
    justify-content: center;
    align-items: center;
}
body {
    overflow: hidden;
}
</style>
