@extends('layouts.admin')

@section('title', 'Edit Team')
@section('header', 'Edit Team')

@section('content')
    <div class="max-w-2xl mx-auto">
        <div
            class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden dark:bg-slate-900 dark:border-gray-700">
            <div class="p-4 sm:p-7">
                <form action="{{ route('admin.teams.update', $team->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="grid gap-y-4">
                        <div>
                            <label for="name" class="block text-sm font-medium mb-2 text-slate-700 dark:text-gray-200">Team
                                Name</label>
                            <input type="text" id="name" name="name" value="{{ $team->name }}"
                                class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400"
                                required>
                        </div>

                        <div>
                            <label for="type"
                                class="block text-sm font-medium mb-2 text-slate-700 dark:text-gray-200">Type</label>
                            <select id="type" name="type"
                                class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400">
                                <option value="club" {{ $team->type === 'club' ? 'selected' : '' }}>Club</option>
                                <option value="country" {{ $team->type === 'country' ? 'selected' : '' }}>Country</option>
                            </select>
                        </div>

                        <div class="mt-4 flex justify-end gap-x-2">
                            <a href="{{ route('admin.teams.index') }}"
                                class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 focus:outline-none focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-white dark:hover:bg-gray-800 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600">
                                Cancel
                            </a>
                            <button type="submit"
                                class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-indigo-600 text-white hover:bg-indigo-700 disabled:opacity-50 disabled:pointer-events-none">
                                Update Team
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection