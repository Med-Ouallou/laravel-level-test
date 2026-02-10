export default function playerManager() {
    return {
        search: '',
        tableHtml: '',
        submitting: false,
        errors: {},
        csrfToken: document.querySelector('meta[name="csrf-token"]')?.getAttribute('content'),

        init() {
            // Capture initial table HTML from Blade render
            const container = document.getElementById('player-table-container');
            if (container) {
                this.tableHtml = container.innerHTML;
            }

            this.$watch('search', () => this.fetchPlayers());

            // Handle pagination clicks
            document.addEventListener('click', (e) => {
                const link = e.target.closest('#pagination-links a');
                if (link) {
                    e.preventDefault();
                    this.fetchPlayers(link.href);
                }
            });

            // Handle delete button clicks
            document.addEventListener('submit', (e) => {
                if (e.target.matches('form[action*="/admin/players/"]')) {
                    const methodInput = e.target.querySelector('input[name="_method"]');
                    if (methodInput && methodInput.value === 'DELETE') {
                        e.preventDefault();
                        if (confirm('Are you sure you want to delete this player?')) {
                            this.deletePlayer(e.target);
                        }
                    }
                }
            });
        },

        fetchPlayers(url = "/admin/players") {
            const finalUrl = new URL(url, window.location.origin);
            if (this.search) {
                finalUrl.searchParams.set('search', this.search);
            }

            fetch(finalUrl, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
                .then(response => response.text())
                .then(html => {
                    this.tableHtml = html;
                    this.$nextTick(() => {
                        if (typeof window.createIcons === 'function') {
                            window.createIcons({ icons: window.lucideIcons });
                        }
                    });
                })
                .catch(error => console.error('Error fetching players:', error));
        },

        async submitForm(e) {
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
                        throw new Error('Something went wrong');
                    }
                } else {
                    // Success
                    if (window.HSOverlay) {
                        window.HSOverlay.close('#hs-add-player-modal');
                    } else {
                        const modal = document.getElementById('hs-add-player-modal');
                        if (modal) modal.classList.add('hidden');
                    }

                    e.target.reset();
                    this.fetchPlayers();
                    alert('Player added successfully');
                }
            } catch (error) {
                console.error('Error adding player:', error);
                alert('An error occurred. Please try again.');
            } finally {
                this.submitting = false;
            }
        },

        async deletePlayer(form) {
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
                    this.fetchPlayers();
                    alert('Player deleted successfully');
                } else {
                    alert('Error deleting player');
                }
            } catch (error) {
                console.error('Error:', error);
                alert('An error occurred');
            }
        }
    }
}
