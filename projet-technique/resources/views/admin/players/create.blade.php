@extends('layouts.admin')

@section('title', 'Add Player')
@section('header', 'Add New Player')

@section('content')
    <div class="max-w-3xl mx-auto">
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="p-4 sm:p-7">
                <div class="mb-6">
                    <h3 class="text-lg font-bold text-slate-800">
                        Player Details
                    </h3>
                    <p class="text-sm text-slate-500">
                        Enter the information for the new player.
                    </p>
                </div>

                <form action="{{ url('admin/players') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="grid gap-6">
                        <!-- Name -->
                        <div>
                            <label for="name" class="block text-sm font-medium mb-2 text-slate-700">Full Name <span
                                    class="text-red-500">*</span></label>
                            <div class="relative">
                                <input type="text" name="name" id="name" value="{{ old('name') }}" required
                                    class="py-3 px-4 pl-11 block w-full border-slate-200 rounded-lg text-sm focus:border-indigo-500 focus:ring-indigo-500 disabled:opacity-50 disabled:pointer-events-none shadow-sm"
                                    placeholder="e.g. John Doe">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none">
                                    <i data-lucide="user" class="w-4 h-4 text-slate-400"></i>
                                </div>
                            </div>
                            @error('name')
                                <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid md:grid-cols-2 gap-6">
                            <!-- Score -->
                            <div>
                                <label for="score" class="block text-sm font-medium mb-2 text-slate-700">Score <span
                                        class="text-red-500">*</span></label>
                                <div class="relative">
                                    <input type="number" name="score" id="score" value="{{ old('score', 0) }}" required
                                        min="0"
                                        class="py-3 px-4 pl-11 block w-full border-slate-200 rounded-lg text-sm focus:border-indigo-500 focus:ring-indigo-500 disabled:opacity-50 disabled:pointer-events-none shadow-sm">
                                    <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none">
                                        <i data-lucide="trophy" class="w-4 h-4 text-slate-400"></i>
                                    </div>
                                </div>
                                <p class="mt-2 text-xs text-slate-500">Enter the player's total score.</p>
                                @error('score')
                                    <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Image File -->
                            <div>
                                <label for="image" class="block text-sm font-medium mb-2 text-slate-700">Avatar
                                    Image</label>
                                <div class="relative">
                                    <input type="file" name="image" id="image" accept="image/*" class="block w-full text-sm text-slate-500
                                            file:me-4 file:py-2 file:px-4
                                            file:rounded-lg file:border-0
                                            file:text-sm file:font-semibold
                                            file:bg-indigo-600 file:text-white
                                            file:disabled:opacity-50 file:disabled:pointer-events-none
                                            hover:file:bg-indigo-700
                                            file:cursor-pointer">
                                </div>
                                <p class="mt-2 text-xs text-slate-500">Upload a JPG, PNG or WEBP image.</p>
                                @error('image')
                                    <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Teams with Optgroup -->
                        <div class="pt-2 border-t border-slate-200">
                            <label for="teams" class="block text-sm font-medium mb-3 text-slate-700">Assign Teams</label>
                            <select name="teams[]" id="teams" multiple
                                class="py-3 px-4 pe-9 block w-full border-slate-200 rounded-lg text-sm focus:border-indigo-500 focus:ring-indigo-500 disabled:opacity-50 disabled:pointer-events-none shadow-sm">
                                <option value="" disabled>Select teams...</option>
                                @foreach($teams as $type => $groupTeams)
                                    <optgroup label="{{ ucfirst($type) }}">
                                        @foreach($groupTeams as $team)
                                            <option value="{{ $team->id }}">{{ $team->name }}</option>
                                        @endforeach
                                    </optgroup>
                                @endforeach
                            </select>
                            <p class="mt-2 text-xs text-slate-500">Hold Ctrl (Windows) or Command (Mac) to select multiple
                                teams.</p>
                        </div>
                    </div>

                    <div class="mt-8 flex justify-end gap-x-3 pt-6 border-t border-slate-200">
                        <a href="{{ route('admin.players') }}"
                            class="py-2.5 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-slate-200 bg-white text-slate-700 shadow-sm hover:bg-slate-50 disabled:opacity-50 disabled:pointer-events-none focus:outline-none focus:ring-2 focus:ring-slate-500">
                            Cancel
                        </a>
                        <button type="submit"
                            class="py-2.5 px-4 inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-indigo-600 text-white hover:bg-indigo-700 disabled:opacity-50 disabled:pointer-events-none focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            <i data-lucide="save" class="w-4 h-4"></i>
                            Save Player
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection