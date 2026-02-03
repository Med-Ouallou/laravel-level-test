@extends('layouts.app')

@section('content')
<div class="max-w-[50rem] mx-auto w-full p-6">
    <div class="mt-7 bg-white border border-slate-200 rounded-xl shadow-sm">
        <div class="p-4 sm:p-7">
            <div class="flex items-center gap-x-3 mb-4">
                <div class="inline-flex justify-center items-center w-10 h-10 rounded-lg bg-indigo-50">
                    <i data-lucide="layout-dashboard" class="w-5 h-5 text-indigo-600"></i>
                </div>
                <h1 class="text-xl font-bold text-slate-800">{{ __('Dashboard') }}</h1>
            </div>

            <div class="mt-5">
                @if (session('status'))
                    <div class="mb-4 bg-teal-50 border border-teal-200 text-sm text-teal-800 rounded-lg p-4" role="alert">
                        {{ session('status') }}
                    </div>
                @endif

                <div class="bg-indigo-50 border border-indigo-100 rounded-lg p-5">
                    <div class="flex gap-x-3">
                        <i data-lucide="check-circle-2" class="size-5 text-indigo-600 mt-0.5"></i>
                        <div class="grow">
                            <h3 class="text-sm font-semibold text-slate-800 tracking-tight">
                                Authentication Successful
                            </h3>
                            <p class="mt-1 text-sm text-slate-600">
                                {{ __('You are logged in!') }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="mt-8 grid sm:grid-cols-2 gap-4">
                    <a class="group border border-slate-200 rounded-xl p-4 hover:border-indigo-600 hover:shadow-sm transition-all" href="{{ route('public.players') }}">
                        <div class="flex items-center gap-x-3">
                            <i data-lucide="users" class="size-5 text-slate-400 group-hover:text-indigo-600"></i>
                            <div class="grow">
                                <h4 class="text-sm font-bold text-slate-800">Browse Players</h4>
                                <p class="text-xs text-slate-500">View rankings and player profiles.</p>
                            </div>
                        </div>
                    </a>
                    
                    @can('isAdmin')
                    <a class="group border border-slate-200 rounded-xl p-4 hover:border-indigo-600 hover:shadow-sm transition-all" href="{{ route('admin.players') }}">
                        <div class="flex items-center gap-x-3">
                            <i data-lucide="settings" class="size-5 text-slate-400 group-hover:text-indigo-600"></i>
                            <div class="grow">
                                <h4 class="text-sm font-bold text-slate-800">Admin Area</h4>
                                <p class="text-xs text-slate-500">Manage players and teams.</p>
                            </div>
                        </div>
                    </a>
                    @endcan
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
