import baseComponent from '../baseComponent';

export default function playerManager() {
    return {
        ...baseComponent(),
        search: '',
        tableHtml: '',

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
                        this.deletePlayer(e.target);
                    }
                }
            });
        },

        async fetchPlayers(url = "/admin/players") {
            try {
                this.tableHtml = await this.fetchTableData(url, { search: this.search });
            } catch (error) {
                console.error('Error fetching players:', error);
            }
        },

        async submitForm(e) {
            const success = await this.handleFormSubmission(e, () => {
                this.fetchPlayers();
                alert('Player added successfully');
            }, '#hs-add-player-modal');
        },

        async deletePlayer(form) {
            await this.handleDeletion(form, () => {
                this.fetchPlayers();
                alert('Player deleted successfully');
            }, 'Are you sure you want to delete this player?');
        }
    }
}
