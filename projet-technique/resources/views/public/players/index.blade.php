@extends('layouts.app')

@section('title', 'Players - PlayerScore')

@section('content')
    <div class="space-y-8">
        <!-- Header & Search -->
        <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 border-b border-slate-200 pb-6">
            <div>
                <h1 class="text-3xl font-bold text-slate-800 tracking-tight">Players & Rankings</h1>
                <p class="text-slate-500 mt-2">Browse players, check scores, and view team assignments.</p>
            </div>

            <div class="w-full sm:w-auto">
                <form action="{{ route('public.players') }}" method="GET" class="relative max-w-xs w-full">
                    <label for="search" class="sr-only">Search</label>
                    <div class="relative">
                        <input type="text" id="search" name="search" value="{{ request('search') }}"
                            class="py-2.5 px-4 pl-10 block w-full border-slate-200 shadow-sm rounded-lg text-sm focus:z-10 focus:border-indigo-500 focus:ring-indigo-500 disabled:opacity-50 disabled:pointer-events-none"
                            placeholder="Search players...">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <i data-lucide="search" class="w-4 h-4 text-slate-400"></i>
                        </div>
                    </div>
                    @if(request('search'))
                        <div class="absolute -bottom-6 right-0">
                            <a href="{{ route('public.players') }}"
                                class="text-xs text-red-500 hover:text-red-700 font-medium inline-flex items-center gap-1">
                                <i data-lucide="x" class="w-3 h-3"></i> Clear
                            </a>
                        </div>
                    @endif
                </form>
            </div>
        </div>

        <!-- Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @forelse($players as $player)
                <a class="group flex flex-col bg-white border border-slate-200 shadow-sm rounded-xl hover:shadow-lg hover:border-indigo-100 transition-all duration-300 h-full"
                    href="{{ route('public.player', $player) }}">
                    <div class="relative pt-[60%] overflow-hidden rounded-t-xl bg-slate-100">
                        @if($player->image)
                            <img class="absolute top-0 left-0 object-cover w-full h-full group-hover:scale-105 transition-transform duration-500"
                                src="{{ asset('storage/' . $player->image) }}" alt="{{ $player->name }}">
                        @else
                            <div
                                class="absolute top-0 left-0 w-full h-full flex items-center justify-center bg-gradient-to-br from-slate-100 to-slate-200">
                                <span
                                    class="text-4xl font-bold text-slate-300 group-hover:text-indigo-200 transition-colors">{{ substr($player->name, 0, 1) }}</span>
                            </div>
                        @endif

                        <!-- Score Badge -->
                        <div class="absolute top-3 right-3">
                            <span
                                class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/90 backdrop-blur-sm shadow-sm border border-white/20 text-sm font-bold {{ $player->score >= 50 ? 'text-indigo-600' : 'text-slate-600' }}">
                                {{ $player->score }}
                            </span>
                        </div>
                    </div>

                    <div class="p-5 flex flex-col flex-grow">
                        <h3 class="text-lg font-bold text-slate-800 group-hover:text-indigo-600 transition-colors line-clamp-1">
                            {{ $player->name }}
                        </h3>

                        <div class="mt-4 flex flex-wrap gap-2">
                            @forelse($player->teams as $team)
                                <span
                                    class="inline-flex items-center py-1 px-2.5 rounded-md text-xs font-medium bg-slate-100 text-slate-700 border border-slate-100 group-hover:border-indigo-100 group-hover:bg-indigo-50 group-hover:text-indigo-700 transition-colors">
                                    {{ $team->name ?? 'Team' }}
                                </span>
                            @empty
                                <span class="text-xs text-slate-400 italic">No teams</span>
                            @endforelse
                        </div>

                        <div
                            class="mt-auto pt-4 flex items-center text-indigo-600 text-sm font-medium opacity-0 group-hover:opacity-100 transition-opacity transform translate-y-2 group-hover:translate-y-0">
                            View Profile <i data-lucide="arrow-right" class="w-4 h-4 ml-1"></i>
                        </div>
                    </div>
                </a>
            @empty
                <div class="col-span-full py-12">
                    <div class="text-center">
                        <div class="inline-flex justify-center items-center w-16 h-16 rounded-full bg-slate-50 mb-4">
                            <i data-lucide="users" class="w-8 h-8 text-slate-400"></i>
                        </div>
                        <h3 class="text-lg font-bold text-slate-800">
                            No players found
                        </h3>
                        <p class="mt-2 text-slate-500 max-w-sm mx-auto">
                            We couldn't find any players matching your search. Try a different name or clear the filter.
                        </p>
                        @if(request('search'))
                            <div class="mt-6">
                                <a href="{{ route('public.players') }}"
                                    class="inline-flex items-center justify-center px-4 py-2 border border-transparent font-medium rounded-lg text-indigo-600 bg-indigo-100 hover:bg-indigo-200 transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Clear Search
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="mt-8 border-t border-slate-200 pt-6">
            {{ $players->links('vendor.pagination.preline') }}
        </div>
    </div>
@endsection