@extends('layouts.app')

@section('title', $player->name . ' - PlayerScore')

@section('content')
    <div class="max-w-4xl mx-auto">
        <!-- Breadcrumb -->
        <nav class="flex mb-6" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="{{ route('public.players') }}"
                        class="inline-flex items-center text-sm font-medium text-slate-700 hover:text-indigo-600">
                        <i data-lucide="users" class="w-4 h-4 mr-2"></i>
                        Players
                    </a>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <i data-lucide="chevron-right" class="w-4 h-4 text-slate-400"></i>
                        <span class="ml-1 text-sm font-medium text-slate-500 md:ml-2">{{ $player->name }}</span>
                    </div>
                </li>
            </ol>
        </nav>

        <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden">
            <div class="md:flex">
                <!-- Image Section -->
                <div class="md:w-1/3 bg-slate-100 relative">
                    @if($player->image)
                        <img class="w-full h-full object-cover min-h-[300px]" src="{{ $player->image }}"
                            alt="{{ $player->name }}">
                    @else
                        <div class="w-full h-full min-h-[300px] flex items-center justify-center bg-gray-100 text-gray-300">
                            <span class="text-9xl font-bold">{{ substr($player->name, 0, 1) }}</span>
                        </div>
                    @endif
                </div>

                <!-- Content Section -->
                <div class="p-8 md:w-2/3 flex flex-col justify-between">
                    <div>
                        <div class="flex justify-between items-start">
                            <div>
                                <h1 class="text-3xl font-bold text-slate-800">{{ $player->name }}</h1>
                                <p class="text-indigo-600 font-medium mt-1 inline-flex items-center gap-1">
                                    <i data-lucide="id-card" class="w-4 h-4"></i> Registered Player
                                </p>
                            </div>

                            <!-- Score Circle -->
                            <div class="flex flex-col items-center">
                                <div
                                    class="relative flex items-center justify-center w-24 h-24 rounded-full border-4 {{ $player->score >= 50 ? 'border-indigo-100 bg-indigo-50' : 'border-slate-100 bg-slate-50' }}">
                                    <span
                                        class="text-3xl font-bold {{ $player->score >= 50 ? 'text-indigo-600' : 'text-slate-600' }}">{{ $player->score }}</span>
                                </div>
                                <span class="text-xs font-semibold uppercase tracking-wide text-slate-500 mt-2">Current
                                    Score</span>
                            </div>
                        </div>

                        <div class="border-t border-slate-100 my-6"></div>

                        <!-- Teams Section -->
                        <div>
                            <h2
                                class="text-sm font-semibold text-slate-500 uppercase tracking-wider mb-4 flex items-center gap-2">
                                <i data-lucide="flag" class="w-4 h-4"></i> Team Information
                            </h2>

                            <div class="bg-slate-50 rounded-xl p-6 border border-slate-100">
                                @if($player->teams && $player->teams->count() > 0)
                                    <div class="flex flex-wrap gap-3">
                                        @foreach($player->teams as $team)
                                            <div
                                                class="group relative inline-flex items-center justify-center px-4 py-2 border border-slate-200 rounded-lg bg-white text-sm font-medium text-slate-700 shadow-sm hover:shadow hover:border-indigo-200 hover:text-indigo-700 transition-all cursor-default">
                                                <span
                                                    class="w-2 h-2 rounded-full bg-indigo-400 mr-2 group-hover:bg-indigo-600"></span>
                                                {{ $team->name }}
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="text-center py-4">
                                        <p class="text-slate-500 italic">This player is not currently assigned to any teams.</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Footer Actions -->
                    <div class="mt-8 pt-6 border-t border-slate-100 flex justify-end">
                        <a href="{{ route('public.players') }}"
                            class="inline-flex items-center justify-center px-5 py-2.5 border border-slate-200 font-medium rounded-lg text-slate-700 bg-white hover:bg-slate-50 transition-all hover:shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-slate-500">
                            Back to Players
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection