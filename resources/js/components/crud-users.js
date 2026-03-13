export default function crudUsers({ flashMessage = '' } = {}) {
    return {
        flashMessage,

        async deleteUser(event, url) {
            const ok = window.confirm('Delete this user?');
            if (!ok) {
                return;
            }

            const row = event.currentTarget.closest('[data-user-row]');

            try {
                const response = await window.axios.delete(url, {
                    headers: {
                        Accept: 'application/json',
                    },
                });

                if (row) {
                    row.remove();
                }

                this.flashMessage = response.data.message || 'User deleted.';
            } catch (error) {
                this.flashMessage = error.response?.data?.message || 'Failed to delete user.';
            }
        },
    };
}


