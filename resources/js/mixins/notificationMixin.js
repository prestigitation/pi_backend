export const notificationMixin = {
    methods: {
        showSuccessMessage(message) {
            Swal.fire({
                icon: 'success',
                title: message
            })
        },
        showFailMessage(message) {
            Swal.fire({
                icon: 'error',
                title: message
            })
        }
    }
}