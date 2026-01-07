@extends('layouts.app')

@section('title', $player->name)

@section('content')
<div class="bg-white border rounded-xl shadow-sm sm:flex">
    <div class="shrink-0 relative w-full rounded-t-xl overflow-hidden pt-[40%] sm:rounded-s-xl sm:max-w-60 md:rounded-se-none md:max-w-xs">
         @if($player->image)
            <img class="absolute top-0 start-0 w-full h-full object-cover" src="{{ $player->image }}" alt="{{ $player->name }}">
        @else
            <div class="absolute top-0 start-0 w-full h-full flex items-center justify-center text-gray-400 bg-gray-200">
                <span class="text-6xl font-bold">{{ substr($player->name, 0, 1) }}</span>
            </div>
        @endif
    </div>
    <div class="flex flex-wrap">
        <div class="p-4 flex flex-col h-full sm:p-7">
            <h3 class="text-2xl font-bold text-gray-800">
                {{ $player->name }}
            </h3>
            <p class="mt-1 text-gray-500">
                Full-Stack Student
            </p>

            <div class="mt-5 sm:mt-auto">
                <span class="text-xs font-semibold uppercase tracking-wide text-gray-500">Current Score</span>
                <div class="flex items-center gap-x-2 mt-2">
                    <span class="text-3xl font-bold text-indigo-600">{{ $player->score }}</span>
                    <span class="text-gray-400">/ 100</span>
                </div>
            </div>

            <div class="mt-8">
                 <h4 class="text-sm font-semibold text-gray-800 mb-3">Teams & Squads</h4>
                 <div class="flex flex-wrap gap-2">
                    @forelse($player->teams as $team)
                        <span class="inline-flex items-center gap-x-1.5 py-1.5 px-3 rounded-full text-xs font-medium bg-teal-100 text-teal-800">
                            {{ $team->name ?? 'Team ' . $team->id }}
                        </span>
                    @empty
                        <span class="text-sm text-gray-500 italic">No team assignments.</span>
                    @endforelse
                 </div>
            </div>

            <div class="mt-10 pt-6 border-t border-gray-200">
                <a class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none" href="{{ route('public.players') }}">
                    <i data-lucide="arrow-left" class="w-4 h-4"></i>
                    Back to List
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
