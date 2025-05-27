<script setup>
import { ref } from 'vue';
import { Link, useForm } from '@inertiajs/vue3';
import ActionMessage from '@/Components/ActionMessage.vue';
import FormSection from '@/Components/FormSection.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import Checkbox from '@/Components/Checkbox.vue';
import { watch } from 'vue';

const props = defineProps({
    user: Object,
});

const form = useForm({
    _method: 'PUT',
    firstname: props.user.firstname,
    lastname: props.user.lastname,
    email: props.user.email,
    professionnal: Boolean(props.user.professionnal),
    company_name: props.user.company_name,
    company_siret: props.user.company_siret,
});

const updateProfileInformation = () => {
    if (form.professionnal && (!form.company_name || !form.company_siret)) {
        form.errors.company_name = !form.company_name ? 'Le nom de société est obligatoire.' : '';
        form.errors.company_siret = !form.company_siret ? 'Le SIRET est obligatoire.' : '';
        return;
    }

    form.post(route('user-profile-information.update'), {
        errorBag: 'updateProfileInformation',
        preserveScroll: true,
    });
};

watch(() => form.professionnal, (newVal) => {
    if (!newVal) {
        form.company_name = '';
        form.company_siret = '';
    }
});
</script>

<template>
    <FormSection @submitted="updateProfileInformation">
        <template #title>
            Informations du profil
        </template>

        <template #description>
            <p>Mettez à jour les informations de votre profil.</p>
            <p><b>Si vous êtes un professionnel :</b> veuillez vous munir de votre numéro SIRET</p>
        </template>

        <template #form>
            <!-- FirstName -->
            <div class="col-span-6 sm:col-span-4">
                <InputLabel for="firstname" value="Prénom" />
                <TextInput
                    id="firstname"
                    v-model="form.firstname"
                    type="text"
                    class="mt-1 block w-full"
                    required
                    autocomplete="firstname"
                />
                <InputError :message="form.errors.firstname" class="mt-2" />
            </div>

            <!-- LastName -->
            <div class="col-span-6 sm:col-span-4">
                <InputLabel for="lastname" value="Nom" />
                <TextInput
                    id="lastname"
                    v-model="form.lastname"
                    type="text"
                    class="mt-1 block w-full"
                    required
                    autocomplete="lastname"
                />
                <InputError :message="form.errors.lastname" class="mt-2" />
            </div>

            <!-- Email -->
            <div class="col-span-6 sm:col-span-4">
                <InputLabel for="email" value="Email" />
                <TextInput
                    id="email"
                    v-model="form.email"
                    type="email"
                    class="mt-1 block w-full"
                    required
                    autocomplete="username"
                />
                <InputError :message="form.errors.email" class="mt-2" />
            </div>

            <!-- Professionnel -->
            <div class="col-span-6 sm:col-span-4 flex items-center gap-2">
                <InputLabel for="professionnal" value="Professionnel :" />
                <Checkbox
                    id="professionnal"
                    v-model:checked="form.professionnal"
                    class="mr-2"
                />
                <InputError :message="form.errors.professionnal" class="mt-2" />
            </div>

            <!-- Company Name -->
            <div class="col-span-6 sm:col-span-4">
                <InputLabel for="company_name" value="Société" />
                <TextInput
                    id="company_name"
                    v-model="form.company_name"
                    type="text"
                    class="mt-1 block w-full"
                    :disabled="!form.professionnal"
                    :required="form.professionnal"
                    autocomplete="company_name"
                />
                <InputError :message="form.errors.company_name" class="mt-2" />
            </div>

            <!-- Company SIRET -->
            <div class="col-span-6 sm:col-span-4">
                <InputLabel for="company_siret" value="SIRET" />
                <TextInput
                    id="company_siret"
                    v-model="form.company_siret"
                    type="text"
                    class="mt-1 block w-full"
                    :disabled="!form.professionnal"
                    :required="form.professionnal"
                    autocomplete="company_siret"
                />
                <InputError :message="form.errors.company_siret" class="mt-2" />
            </div>
        </template>

        <template #actions>
            <ActionMessage :on="form.recentlySuccessful" class="me-3">
                Sauvegardé
            </ActionMessage>

            <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                Savegarder
            </PrimaryButton>
        </template>
    </FormSection>
</template>
