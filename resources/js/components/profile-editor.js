export default function profileEditor({
    initialMessage = '',
    initialErrors = {},
    initialAvatarUrl = '',
} = {}) {
    return {
        successMessage: initialMessage,
        errors: initialErrors,
        avatarPreview: initialAvatarUrl,
        isSaving: false,

        clearErrors() {
            this.errors = {};
        },

        previewAvatar(event) {
            const [file] = event.target.files || [];
            if (file) {
                this.avatarPreview = URL.createObjectURL(file);
            }
        },

        async submit() {
            if (!this.$refs.form) {
                return;
            }

            this.isSaving = true;
            this.successMessage = '';
            this.clearErrors();

            const formData = new FormData(this.$refs.form);

            try {
                const response = await window.axios.post(this.$refs.form.action, formData, {
                    headers: {
                        Accept: 'application/json',
                    },
                });

                this.successMessage = response.data.message || 'Profile updated.';

                if (response.data.data && response.data.data.avatar_url) {
                    this.avatarPreview = response.data.data.avatar_url;
                }
            } catch (error) {
                const status = error.response?.status;

                if (status === 422) {
                    this.errors = error.response?.data?.errors || {};
                } else {
                    this.successMessage = 'Something went wrong. Please try again.';
                }
            } finally {
                this.isSaving = false;
            }
        },

        confirmDelete(event) {
            if (window.confirm('Are you sure you want to delete your account?')) {
                event.target.submit();
            }
        },
    };
}

