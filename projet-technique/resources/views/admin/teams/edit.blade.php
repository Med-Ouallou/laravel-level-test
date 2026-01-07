@extends('layouts.admin')

@section('title', 'Edit Team')
@section('header', 'Edit Team')

@section('content')
<div class="max-w-xl mx-auto">
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 sm:p-7">
        <form action="{{ route('admin.teams.update', $team) }}" method="POST">
            @csrf
            @method('PUT')
            
             <div class="grid gap-y-4">
                <!-- Name -->
                <div>
                   <label for="name" class="block text-sm mb-2 font-medium">Team Name</label>
                   <input type="text" name="name" id="name" value="{{ old('name', $team->name) }}" required
                        class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-indigo-500 focus:ring-indigo-500 disabled:opacity-50 disabled:pointer-events-none border">
                     @error('name')
                        <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mt-8 flex justify-end gap-x-2">
                <a href="{{ route('admin.teams.index') }}" class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none">
                    Cancel
                </a>
                <button type="submit" class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-indigo-600 text-white hover:bg-indigo-700 disabled:opacity-50 disabled:pointer-events-none">
                    Update Team
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
