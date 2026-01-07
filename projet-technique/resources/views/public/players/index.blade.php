@extends('layouts.app')

@section('title', 'Students - MyApp')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center border-b border-gray-200 pb-4 mb-6">
        <div>
            <h1 class="text-3xl font-extrabold text-slate-800">Our Talented Students</h1>
            <p class="text-gray-500 mt-1">Discover the future professionals.</p>
        </div>
    </div>

    <!-- Preline Search Input -->
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
        <form action="{{ route('public.players') }}" method="GET">
            <label for="hs-search-box-with-loading-1" class="sr-only">Search</label>
            <div class="relative">
                <input type="text" id="hs-search-box-with-loading-1" name="search" value="{{ request('search') }}" class="py-3 px-4 ps-11 block w-full border-gray-200 shadow-sm rounded-lg text-sm focus:z-10 focus:border-indigo-500 focus:ring-indigo-500 disabled:opacity-50 disabled:pointer-events-none border" placeholder="Search students by name...">
                <div class="absolute inset-y-0 start-0 flex items-center pointer-events-none ps-4">
                    <i data-lucide="search" class="flex-shrink-0 w-4 h-4 text-gray-400"></i>
                </div>
                <div class="absolute inset-y-0 end-0 flex items-center pointer-events-none pe-4">
                    <button type="submit" class="p-1">
                        <i data-lucide="arrow-right" class="w-4 h-4 text-gray-400 hover:text-indigo-600"></i>
                    </button>
                </div>
            </div>
             @if(request('search'))
                <div class="mt-2 text-right">
                    <a href="{{ route('public.players') }}" class="text-sm text-red-500 hover:text-red-700 font-medium inline-flex items-center gap-1">
                        <i data-lucide="x-circle" class="w-3 h-3"></i> Clear Search
                    </a>
                </div>
            @endif
        </form>
    </div>

    <!-- Preline Card Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($players as $player)
            <a class="group flex flex-col bg-white border shadow-sm rounded-xl hover:shadow-md transition" href="{{ route('public.player', $player) }}">
                <div class="relative pt-[60%] sm:pt-[70%] rounded-t-xl overflow-hidden bg-slate-100">
                     @if($player->image)
                        <img class="absolute top-0 start-0 object-cover group-hover:scale-105 transition-transform duration-500 w-full h-full rounded-t-xl" src="{{ $player->image }}" alt="{{ $player->name }}">
                    @else
                        <div class="absolute top-0 start-0 w-full h-full flex items-center justify-center text-gray-400 bg-gray-200">
                            <span class="text-4xl font-bold">{{ substr($player->name, 0, 1) }}</span>
                        </div>
                    @endif
                </div>
                <div class="p-4 md:p-5">
                    <h3 class="mt-2 text-lg font-bold text-gray-800 group-hover:text-indigo-600">
                        {{ $player->name }}
                    </h3>
                    <div class="mt-2 flex items-center gap-x-2 text-sm text-gray-500">
                        <span class="inline-flex items-center gap-x-1 py-1 px-2 rounded-lg text-xs font-medium bg-blue-100 text-blue-800">
                             Score: {{ $player->score }}
                        </span>
                    </div>
                     <div class="mt-4 flex flex-wrap gap-2">
                        @foreach($player->teams as $team)
                            <span class="inline-flex items-center gap-x-1.5 py-1.5 px-3 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                {{ $team->name ?? 'Team' }}
                            </span>
                        @endforeach
                    </div>
                </div>
            </a>
        @empty
            <div class="col-span-full">
                <div class="min-h-60 flex flex-col bg-white border shadow-sm rounded-xl">
                    <div class="flex flex-auto flex-col justify-center items-center p-4 md:p-5">
                        <i data-lucide="ghost" class="w-10 h-10 text-gray-500 mb-4"></i>
                        <h3 class="text-lg font-bold text-gray-800">
                            No students found
                        </h3>
                        <p class="mt-2 text-gray-500">
                            Try adjusting your search criteria.
                        </p>
                    </div>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="mt-8">
        {{ $players->links() }}
    </div>
</div>
@endsection
