@extends('layouts.admin')

@section('title', 'Manage Players')
@section('header', 'Player Management')

@push('styles')
<style>
    /* Robust fallback for Preline modal visibility in Tailwind 4 */
    #hs-add-player-modal.open {
        display: flex !important;
        opacity: 1 !important;
        pointer-events: auto !important;
    }
    #hs-add-player-modal.open > div {
        opacity: 1 !important;
        pointer-events: auto !important;
        transform: none !important;
    }
    #hs-add-player-modal.open .pointer-events-none {
        pointer-events: auto !important;
    }
</style>
@endpush

@section('content')
    <div x-data="playerManager()" x-init="init()" class="flex flex-col">
        <div class="-m-1.5 overflow-x-auto">
            <div class="p-1.5 min-w-full inline-block align-middle">
                <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
                    <div class="px-6 py-4 grid gap-3 md:flex md:justify-between md:items-center border-b border-gray-200">
                        <div>
                            <h2 class="text-xl font-semibold text-gray-800">
                                All Players
                            </h2>
                        </div>

                        <div class="inline-flex gap-x-2">
                            <div class="relative">
                                <input type="text" x-model.debounce.300ms="search"
                                    class="py-2 px-3 pl-9 block w-full border-gray-200 rounded-lg text-sm focus:border-indigo-500 focus:ring-indigo-500 disabled:opacity-50 disabled:pointer-events-none"
                                    placeholder="Search players...">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <i data-lucide="search" class="w-4 h-4 text-gray-400"></i>
                                </div>
                            </div>

                        @can('add-players')
                            <button type="button"
                                class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-indigo-600 text-white hover:bg-indigo-700 disabled:opacity-50 disabled:pointer-events-none"
                                aria-haspopup="dialog" aria-expanded="false" aria-controls="hs-add-player-modal"
                                data-hs-overlay="#hs-add-player-modal">
                                <i data-lucide="plus" class="w-4 h-4"></i>
                                Add New Player
                            </button>
                        @endcan
                        </div>
                    </div>

                    <div id="player-table-container" x-html="tableHtml">
                        @include('admin.players.partials.table')
                    </div>
                </div>
            </div>
        </div>

    @can('add-players')
    <!-- Add Player Modal -->
    <div id="hs-add-player-modal"
        class="hs-overlay hidden size-full fixed top-0 start-0 z-[80] overflow-x-hidden overflow-y-auto pointer-events-none"
        role="dialog" tabindex="-1" aria-labelledby="hs-add-player-modal-label">
        <div
            class="hs-overlay-open:mt-7 hs-overlay-open:opacity-100 hs-overlay-open:duration-500 mt-0 opacity-0 ease-out transition-all sm:max-w-lg sm:w-full m-3 sm:mx-auto">
            <div
                class="hs-overlay-open:mt-7 hs-overlay-open:opacity-100 hs-overlay-open:duration-500 mt-0 opacity-0 ease-out transition-all sm:max-w-lg sm:w-full m-3 sm:mx-auto">
                <div
                    class="flex flex-col bg-white border shadow-sm rounded-xl pointer-events-auto">
                    <div class="flex justify-between items-center py-3 px-4 border-b">
                        <h3 id="hs-add-player-modal-label" class="font-bold text-gray-800">
                            Add New Player
                        </h3>
                        <button type="button"
                            class="size-8 inline-flex justify-center items-center gap-x-2 rounded-full border border-transparent bg-gray-100 text-gray-800 hover:bg-gray-200 focus:outline-none focus:bg-gray-200 disabled:opacity-50 disabled:pointer-events-none"
                            aria-label="Close" data-hs-overlay="#hs-add-player-modal">
                            <span class="sr-only">Close</span>
                            <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path d="M18 6 6 18"></path>
                                <path d="m6 6 12 12"></path>
                            </svg>
                        </button>
                    </div>
                    <form x-on:submit.prevent="submitForm($event)" action="{{ url('admin/players') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="p-4 overflow-y-auto">
                            <div class="space-y-4">
                                <div>
                                    <label for="modal-name" class="block text-sm font-medium mb-2 text-slate-700">Full Name
                                        <span class="text-red-500">*</span></label>
                                    <input type="text" name="name" id="modal-name" required
                                        class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-indigo-500 focus:ring-indigo-500"
                                        placeholder="e.g. John Doe">
                                    <p class="text-xs text-red-600 mt-2" x-show="errors.name" x-text="errors.name"></p>
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label for="modal-score" class="block text-sm font-medium mb-2 text-slate-700">Score
                                            <span class="text-red-500">*</span></label>
                                        <input type="number" name="score" id="modal-score" value="0" required
                                            min="0"
                                            class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        <p class="text-xs text-red-600 mt-2" x-show="errors.score" x-text="errors.score"></p>
                                    </div>
                                    <div>
                                        <label for="modal-image" class="block text-sm font-medium mb-2 text-slate-700">Avatar
                                            Image</label>
                                        <input type="file" name="image" id="modal-image" accept="image/*"
                                            class="block w-full text-sm text-slate-500 file:me-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-indigo-600 file:text-white hover:file:bg-indigo-700 file:cursor-pointer">
                                        <p class="text-xs text-red-600 mt-2" x-show="errors.image" x-text="errors.image"></p>
                                    </div>
                                </div>

                                <div>
                                    <label for="modal-teams" class="block text-sm font-medium mb-3 text-slate-700">Assign
                                        Teams</label>
                                    <div class="space-y-3">
                                        @foreach($teams as $type => $groupTeams)
                                            <div class="space-y-2">
                                                <h5 class="text-xs font-bold uppercase text-slate-400 tracking-wider">
                                                    {{ $type }}s</h5>
                                                <div class="grid grid-cols-2 gap-2">
                                                    @foreach($groupTeams as $team)
                                                        <label class="flex items-center gap-x-2 p-2 rounded-lg border border-gray-100 hover:bg-gray-50 cursor-pointer transition-colors">
                                                            <input type="checkbox" name="teams[]" value="{{ $team->id }}"
                                                                class="shrink-0 rounded text-indigo-600 focus:ring-indigo-500">
                                                            <span class="text-sm text-gray-700">{{ $team->name }}</span>
                                                        </label>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="flex justify-end items-center gap-x-2 py-3 px-4 border-t">
                            <button type="button"
                                class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none"
                                data-hs-overlay="#hs-add-player-modal">
                                Close
                            </button>
                            <button type="submit" x-bind:disabled="submitting"
                                class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-indigo-600 text-white hover:bg-indigo-700 disabled:opacity-50 disabled:pointer-events-none">
                                <span x-show="submitting" class="animate-spin inline-block size-4 border-[3px] border-current border-t-transparent text-white rounded-full" role="status" aria-label="loading"></span>
                                Save Player
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endcan

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const searchInput = document.getElementById('search-input');
            const tableContainer = document.getElementById('player-table-container');
            const addForm = document.getElementById('add-player-form');
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            let timeout = null;

            // Search functionality
            if (searchInput) {
                searchInput.addEventListener('input', () => {
                    clearTimeout(timeout);
                    timeout = setTimeout(() => {
                        const query = searchInput.value;
                        const url = new URL('{{ url('admin/players') }}');
                        if (query) {
                            url.searchParams.set('search', query);
                        }

                        fetch(url, {
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest'
                            }
                        })
                        .then(response => response.text())
                        .then(html => {
                            tableContainer.innerHTML = html;
                            // Reinitialize lucide icons
                            if (typeof window.createIcons !== 'undefined' && typeof window.lucideIcons !== 'undefined') {
                                window.createIcons({ icons: window.lucideIcons });
                            }
                        })
                        .catch(error => {
                            console.error('Error fetching players:', error);
                        });
                    }, 300);
                });
            }

            // Handle Pagination AJAX
            document.addEventListener('click', (e) => {
                const paginationLink = e.target.closest('#pagination-links a');
                if (paginationLink) {
                    e.preventDefault();
                    const url = paginationLink.href;
                    const search = searchInput.value;
                    const finalUrl = new URL(url);
                    if (search) {
                        finalUrl.searchParams.set('search', search);
                    }

                    fetch(finalUrl, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => response.text())
                    .then(html => {
                        tableContainer.innerHTML = html;
                        // Reinitialize lucide icons
                        if (typeof window.createIcons !== 'undefined' && typeof window.lucideIcons !== 'undefined') {
                            window.createIcons({ icons: window.lucideIcons });
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching paginated players:', error);
                    });
                }
            });

            // Add Player functionality
            if (addForm) {
                addForm.addEventListener('submit', (e) => {
                    e.preventDefault();
                    const formData = new FormData(addForm);
                    const submitBtn = document.getElementById('submit-player-btn');
                    submitBtn.disabled = true;

                    // Reset errors
                    document.querySelectorAll('[id^="error-"]').forEach(el => el.classList.add('hidden'));

                    fetch('{{ url('admin/players') }}', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken,
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        body: formData
                    })
                    .then(response => {
                        if (!response.ok) {
                            return response.json().then(data => {
                                throw { status: response.status, data: data };
                            });
                        }
                        return response.json();
                    })
                    .then(data => {
                        // Success - close modal
                        if (window.HSOverlay) {
                            window.HSOverlay.close('#hs-add-player-modal');
                        } else {
                            const modal = document.getElementById('hs-add-player-modal');
                            modal.classList.add('hidden');
                            modal.classList.remove('open');
                            document.body.style.overflow = '';
                            const backdrop = document.querySelector('.hs-overlay-backdrop');
                            if (backdrop) backdrop.remove();
                        }
                        
                        addForm.reset();
                        // Refresh table
                        if (searchInput) {
                            searchInput.dispatchEvent(new Event('input'));
                        }
                        alert('Player added successfully');
                    })
                    .catch(error => {
                        if (error.status === 422 && error.data && error.data.errors) {
                            const errors = error.data.errors;
                            Object.keys(errors).forEach(key => {
                                const errorEl = document.getElementById(`error-${key}`);
                                if (errorEl) {
                                    errorEl.innerText = errors[key][0];
                                    errorEl.classList.remove('hidden');
                                }
                            });
                        } else {
                            console.error('Error adding player:', error);
                            alert('An error occurred. Please try again.');
                        }
                    })
                    .finally(() => {
                        submitBtn.disabled = false;
                    });
                });
            }

            // Handle Delete AJAX
            document.addEventListener('submit', (e) => {
                if (e.target.matches('form[action*="/admin/players/"]')) {
                    const methodInput = e.target.querySelector('input[name="_method"]');
                    if (methodInput && methodInput.value === 'DELETE') {
                        e.preventDefault();
                        if (!confirm('Are you sure you want to delete this player?')) return;
                        
                        const action = e.target.action;
                        const formData = new FormData(e.target);
                        
                        fetch(action, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': csrfToken,
                                'X-Requested-With': 'XMLHttpRequest'
                            },
                            body: formData
                        })
                        .then(response => response.json())
                        .then(data => {
                            // Refresh table
                            if (searchInput) {
                                searchInput.dispatchEvent(new Event('input'));
                            }
                            alert('Player deleted successfully');
                        })
                        .catch(error => {
                            console.error('Error deleting player:', error);
                            alert('An error occurred while deleting the player.');
                        });
                    }
                }
            });
        });
    </script>
@endpush
@endsection