<template>
    <div class="min-h-screen flex flex-col bg-gray-50">
        <div class="flex flex-1">
            <Navigation />

            <div class="flex-1 flex flex-col overflow-y-auto gap-5">
                <main class="flex-1 flex flex-col justify-between">
                    <div class="flex items-center justify-between w-full px-4 sm:px-6 md:px-8 pt-4">
                        <SearchForm />
                        <UserSettingsDropdown />
                    </div>

                    <div class="flex-1 flex flex-col px-4 sm:px-6 md:px-8">
                        <slot />
                    </div>
                </main>
            </div>
        </div>

        <Footer />

        <ErrorDialog />
        <FormProgress :form="fileUploadForm" />
        <Notification/>
        <!-- Ajout du nouveau composant -->
        <SubscriptionDialog />
    </div>
</template>

<script setup>
import Navigation from "@/Components/app/Navigation.vue";
import SearchForm from "@/Components/app/SearchForm.vue";
import UserSettingsDropdown from "@/Components/app/UserSettingsDropdown.vue";
import {onMounted} from "vue";
import {emitter, FILE_UPLOAD_STARTED, showErrorDialog, showSuccessNotification, showSubscriptionDialog} from "@/event-bus.js";
import {useForm, usePage} from "@inertiajs/vue3";
import FormProgress from "@/Components/app/FormProgress.vue";
import ErrorDialog from "@/Components/ErrorDialog.vue";
import Footer from "@/Components/Footer.vue";
import Notification from "@/Components/Notification.vue";
import SubscriptionDialog from "@/Components/app/SubscriptionDialog.vue";

const page = usePage();
const fileUploadForm = useForm({
    files: [],
    relative_paths: [],
    parent_id: null
})

function uploadFiles(files) {
    console.log('Uploading files:', files);

    if (!page.props.subscribed) {
        showSubscriptionDialog({
            title: '🔒 Accès Premium Requis',
            message: 'Vous devez disposer d\'un abonnement actif pour télécharger des fichiers. Découvrez nos offres pour débloquer cette fonctionnalité et bien plus encore !',
            actionText: 'Découvrir les abonnements',
            actionUrl: route('pricing')
        });
        return;
    }

    const parentId = page.props.folder?.id || null;

    fileUploadForm.parent_id = parentId;
    fileUploadForm.files = files;
    fileUploadForm.relative_paths = [...files].map(f => f.webkitRelativePath);

    fileUploadForm.post(route('file.store'), {
        forceFormData: true,
        preserveState: true,
        onSuccess: (response) => {
            const fileCount = files.length;
            const message = fileCount === 1
                ? `✅ Fichier téléchargé avec succès`
                : `✅ ${fileCount} fichiers téléchargés avec succès`;

            showSuccessNotification(message);
        },
        onError: (errors, response) => {
            console.error('Upload errors:', errors, response);

            if (response?.status === 403) {
                try {
                    const responseData = typeof response.data === 'string'
                        ? JSON.parse(response.data)
                        : response.data;

                    if (responseData?.subscription_required) {
                        showSubscriptionDialog({
                            title: '🔒 Session expirée',
                            message: 'Votre session a expiré ou votre abonnement n\'est plus actif. Veuillez vous reconnecter ou renouveler votre abonnement.',
                            actionText: 'Voir les abonnements',
                            actionUrl: route('pricing')
                        });
                        return;
                    }
                } catch (e) {
                    console.error('Error parsing response:', e);
                }
            }

            let message = '';
            if (Object.keys(errors).length > 0) {
                message = errors[Object.keys(errors)[0]];
            } else {
                message = 'Erreur lors du téléchargement. Veuillez réessayer.';
            }

            showErrorDialog(message);
        },
        onFinish: () => {
            fileUploadForm.clearErrors();
            fileUploadForm.reset();
        }
    });
}

onMounted(() => {
    emitter.on(FILE_UPLOAD_STARTED, uploadFiles)
})
</script>

<style scoped>
body {
    overflow: hidden;
}
</style>
