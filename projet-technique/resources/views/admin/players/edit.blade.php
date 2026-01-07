@extends('layouts.admin')

@section('title', 'Edit Player')
@section('header', 'Edit Player')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 sm:p-7">
        <form action="{{ url('admin/players/' . $player->id) }}" method="POST">
            @csrf
            @method('PUT')
            
             <div class="grid gap-y-4">
                <!-- Name -->
                <div>
                   <label for="name" class="block text-sm mb-2 font-medium">Full Name</label>
                   <input type="text" name="name" id="name" value="{{ old('name', $player->name) }}" required
                        class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-indigo-500 focus:ring-indigo-500 disabled:opacity-50 disabled:pointer-events-none border">
                     @error('name')
                        <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Score -->
                <div>
                    <label for="score" class="block text-sm mb-2 font-medium">Score</label>
                    <input type="number" name="score" id="score" value="{{ old('score', $player->score) }}" required min="0"
                        class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-indigo-500 focus:ring-indigo-500 disabled:opacity-50 disabled:pointer-events-none border">
                     @error('score')
                        <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Image URL -->
                <div>
                    <label for="image" class="block text-sm mb-2 font-medium">Image URL</label>
                    <div class="flex items-center gap-4">
                         <input type="url" name="image" id="image" value="{{ old('image', $player->image) }}" placeholder="https://example.com/avatar.jpg"
                            class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-indigo-500 focus:ring-indigo-500 disabled:opacity-50 disabled:pointer-events-none border">
                         @if($player->image)
                            <div class="shrink-0">
                                <img src="{{ $player->image }}" alt="Preview" class="h-12 w-12 object-cover rounded-full border">
                            </div>
                        @endif
                    </div>
                     <p class="mt-2 text-xs text-gray-500">Provide a direct link to the player's photo.</p>
                     @error('image')
                        <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                    @enderror
                </div>

                 <!-- Teams -->
                 <div>
                     <label class="block text-sm mb-2 font-medium">Assign Teams</label>
                     <div class="grid grid-cols-2 gap-2">
                        @forelse($teams as $team)
                            <label for="team-{{ $team->id }}" class="flex p-3 w-full bg-white border border-gray-200 rounded-lg text-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <span class="text-sm text-gray-500">{{ $team->name }}</span>
                                <input type="checkbox" name="teams[]" value="{{ $team->id }}" id="team-{{ $team->id }}" class="shrink-0 ms-auto mt-0.5 border-gray-200 rounded text-indigo-600 focus:ring-indigo-500 disabled:opacity-50 disabled:pointer-events-none"
                                @if($player->teams->contains($team->id)) checked @endif>
                            </label>
                        @empty
                            <p class="text-sm text-gray-500 col-span-2">No teams available.</p>
                        @endforelse
                     </div>
                </div>
            </div>

            <div class="mt-8 flex justify-end gap-x-2">
                <a href="{{ route('admin.players') }}" class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none">
                    Cancel
                </a>
                <button type="submit" class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-indigo-600 text-white hover:bg-indigo-700 disabled:opacity-50 disabled:pointer-events-none">
                    Update Player
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
