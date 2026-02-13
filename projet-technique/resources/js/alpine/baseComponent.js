export default function baseComponent() {
    return {
        submitting: false,
        errors: {},
        csrfToken: document.querySelector('meta[name="csrf-token"]')?.getAttribute('content'),

        async fetchTableData(url, params = {}) {
            const finalUrl = new URL(url, window.location.origin);
            Object.keys(params).forEach(key => {
                if (params[key]) {
                    finalUrl.searchParams.set(key, params[key]);
                }
            });

            try {
                const response = await fetch(finalUrl, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });
                const html = await response.text();

                this.$nextTick(() => {
                    if (typeof window.createIcons === 'function') {
                        window.createIcons({ icons: window.lucideIcons });
                    }
                });

                return html;
            } catch (error) {
                console.error('Fetch error:', error);
                throw error;
            }
        },

        async handleFormSubmission(e, successCallback, modalId = null) {
            this.submitting = true;
            this.errors = {};
            const formData = new FormData(e.target);

            try {
                const response = await fetch(e.target.action, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': this.csrfToken,
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: formData
                });

                const data = await response.json();

                if (!response.ok) {
                    if (response.status === 422) {
                        this.errors = Object.keys(data.errors).reduce((acc, key) => {
                            acc[key] = data.errors[key][0];
                            return acc;
                        }, {});
                    } else {
                        throw new Error(data.message || 'Something went wrong');
                    }
                    return false;
                } else {
                    if (modalId && window.HSOverlay) {
                        window.HSOverlay.close(modalId);
                    } else if (modalId) {
                        const modal = document.querySelector(modalId);
                        if (modal) modal.classList.add('hidden');
                    }

                    e.target.reset();
                    if (typeof successCallback === 'function') {
                        successCallback(data);
                    }
                    return true;
                }
            } catch (error) {
                console.error('Submission error:', error);
                alert(error.message || 'An error occurred. Please try again.');
                return false;
            } finally {
                this.submitting = false;
            }
        },

        async handleDeletion(form, successCallback, confirmMessage = 'Are you sure?') {
            if (!confirm(confirmMessage)) return;

            const formData = new FormData(form);
            try {
                const response = await fetch(form.action, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': this.csrfToken,
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: formData
                });

                if (response.ok) {
                    if (typeof successCallback === 'function') {
                        successCallback();
                    }
                    return true;
                } else {
                    alert('Error deleting item');
                    return false;
                }
            } catch (error) {
                console.error('Deletion error:', error);
                alert('An error occurred');
                return false;
            }
        }
    };
}
