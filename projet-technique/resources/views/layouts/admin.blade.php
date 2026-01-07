<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin - @yield('title', 'Dashboard')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-50 antialiased text-slate-800">
    <!-- Sidebar Toggle -->
    <div class="sticky top-0 inset-x-0 z-20 bg-white border-y px-4 sm:px-6 md:px-8 lg:hidden">
        <div class="flex items-center py-4">
            <button type="button" class="text-gray-500 hover:text-gray-600" data-hs-overlay="#application-sidebar"
                aria-controls="application-sidebar" aria-label="Toggle navigation">
                <span class="sr-only">Toggle Navigation</span>
                <i data-lucide="menu" class="w-6 h-6"></i>
            </button>
            <ol class="ms-3 flex items-center whitespace-nowrap" aria-label="Breadcrumb">
                <li class="flex items-center text-sm text-gray-800">
                    Admin
                    <i data-lucide="chevron-right" class="w-4 h-4 mx-2 text-gray-400"></i>
                </li>
                <li class="text-sm font-semibold text-gray-800 truncate" aria-current="page">
                    @yield('header')
                </li>
            </ol>
        </div>
    </div>

    <!-- Sidebar -->
    <div id="application-sidebar"
        class="hs-overlay hs-overlay-open:translate-x-0 -translate-x-full transition-all duration-300 transform hidden fixed top-0 start-0 bottom-0 z-[60] w-64 bg-white border-e border-gray-200 pt-7 pb-10 overflow-y-auto lg:block lg:translate-x-0 lg:end-auto lg:bottom-0 [&::-webkit-scrollbar]:w-2 [&::-webkit-scrollbar-thumb]:rounded-full [&::-webkit-scrollbar-track]:bg-gray-100 [&::-webkit-scrollbar-thumb]:bg-gray-300">
        <div class="px-6">
            <a class="flex-none text-xl font-bold text-indigo-600" href="{{ route('admin.players') }}"
                aria-label="Brand">Admin Panel</a>
        </div>
        <nav class="hs-accordion-group p-6 w-full flex flex-col flex-wrap" data-hs-accordion-always-open>
            <ul class="space-y-1.5">
                <li>
                    <a class="flex items-center gap-x-3.5 py-2.5 px-3 text-sm text-slate-700 rounded-lg hover:bg-slate-100 {{ request()->routeIs('admin.players*') ? 'bg-indigo-50 text-indigo-600 font-semibold' : '' }}"
                        href="{{ route('admin.players') }}">
                        <i data-lucide="users" class="w-4 h-4"></i>
                        Players
                    </a>
                </li>
                <li>
                    <a class="flex items-center gap-x-3.5 py-2.5 px-3 text-sm text-slate-700 rounded-lg hover:bg-slate-100 {{ request()->routeIs('admin.teams*') ? 'bg-indigo-50 text-indigo-600 font-semibold' : '' }}"
                        href="{{ route('admin.teams.index') }}">
                        <i data-lucide="flag" class="w-4 h-4"></i>
                        Teams
                    </a>
                </li>
                <li class="pt-6 mt-6 border-t border-gray-200">
                    <a class="flex items-center gap-x-3.5 py-2.5 px-3 text-sm text-slate-700 rounded-lg hover:bg-slate-100"
                        href="{{ route('public.players') }}">
                        <i data-lucide="arrow-left" class="w-4 h-4"></i>
                        Back to Public Site
                    </a>
                </li>
            </ul>
        </nav>
    </div>

    <!-- Content -->
    <div class="w-full pt-10 px-4 sm:px-6 md:px-8 lg:ps-72">
        <header class="mb-8">
            <h1 class="text-2xl font-bold text-slate-800">@yield('header')</h1>
        </header>

        <main>
            @if(session('success'))
                <div class="bg-emerald-50 border border-emerald-200 rounded-lg p-4 mb-6" role="alert">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i data-lucide="check-circle-2" class="h-5 w-5 text-emerald-400"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-emerald-800">
                                {{ session('success') }}
                            </p>
                        </div>
                    </div>
                </div>
            @endif
            @yield('content')
        </main>
    </div>
</body>

</html>