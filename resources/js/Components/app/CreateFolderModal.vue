<template>
    <modal :show="modelValue" @show="onShow" max-width="sm">
        <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900">
                Créer un dossier
            </h2>
            <div class="mt-6">
                <InputLabel for="folderName" value="Nom du dossier" class="sr-only"/>

                <TextInput type="text"
                           ref="folderNameInput"
                           id="folderName" v-model="form.name"
                           class="mt-1 block w-full"
                           :class="form.errors.name ? 'border-red-500 focus:border-red-500 focus:ring-red-500' : ''"
                           placeholder="Nom du dossier"
                           @keyup.enter="createFolder"
                />
                <InputError :message="form.errors.name" class="mt-2"/>

            </div>
            <div class="mt-6 flex justify-end">
                <SecondaryButton @click="closeModal">Annuler</SecondaryButton>
                <PrimaryButton class="ml-3"
                               :class="{ 'opacity-25': form.processing }"
                               @click="createFolder" :disable="form.processing">
                    Envoyer
                </PrimaryButton>
            </div>
        </div>
    </modal>
</template>


<script setup>

import Modal from "@/Components/Modal.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import InputError from "@/Components/InputError.vue";
import {router, useForm, usePage} from "@inertiajs/vue3";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import {nextTick, ref} from "vue";



const form = useForm({
    name: '',
    parent_id: null
})

const page = usePage();

const folderNameInput = ref(null)

const {modelValue} = defineProps({
    modelValue: Boolean
})

const emit = defineEmits(['update:modelValue'])



function onShow (){
    nextTick(() => folderNameInput.value.focus())
}


function createFolder() {
    form.parent_id = page.props.folder.id
    form.post(route('folder.create'), {
        preserveScroll: true,
        onSuccess: () => {
            closeModal();
            form.reset();
            //show sucss notif
        },
        onError: () => folderNameInput.value.focus()
    })
}

function closeModal() {
    emit('update:modelValue')
    form.clearErrors();
    form.reset()
}

</script>


<style scoped>

</style>
