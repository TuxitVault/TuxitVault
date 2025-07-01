import mitt from 'mitt'

export const FILE_UPLOAD_STARTED = 'FILE_UPLOAD_STARTED'
export const SHOW_ERROR_DIALOG = 'SHOW_ERROR_DIALOG'
export const SHOW_NOTIFICATION = 'SHOW_NOTIFICATION'
export const ON_SEARCH = 'ON_SEARCH'
export const emitter = mitt()

export const SHOW_SUBSCRIPTION_DIALOG = 'SHOW_SUBSCRIPTION_DIALOG'

export function showSubscriptionDialog(options = {}) {
    emitter.emit(SHOW_SUBSCRIPTION_DIALOG, {
        title: options.title || '🔒 Accès Premium Requis',
        message: options.message || 'Vous devez disposer d\'un abonnement actif pour télécharger des fichiers. Découvrez nos offres pour débloquer cette fonctionnalité.',
        actionText: options.actionText || 'Voir les abonnements',
        actionUrl: options.actionUrl || route('pricing')
    })
}

export function showErrorDialog(message) {
    emitter.emit(SHOW_ERROR_DIALOG, {message})
}

export function showSuccessNotification(message) {
    emitter.emit(SHOW_NOTIFICATION, {type: 'success', message})
}
export function showErrorNotification(message) {
    emitter.emit(SHOW_NOTIFICATION, {type: 'error', message})
}
