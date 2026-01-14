<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Admin') - {{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Styles / Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>

    @stack('styles')
</head>

<body class="bg-gray-50 dark:bg-slate-900">
    <!-- Navigation Toggle -->
    <div
        class="sticky top-0 inset-x-0 z-20 bg-white border-y px-4 sm:px-6 md:px-8 lg:hidden dark:bg-slate-900 dark:border-gray-700">
        <div class="flex items-center py-4">
            <!-- Navigation Toggle -->
            <button type="button" class="text-gray-500 hover:text-gray-600" data-hs-overlay="#application-sidebar"
                aria-controls="application-sidebar" aria-label="Toggle navigation">
                <span class="sr-only">Toggle Navigation</span>
                <i data-lucide="menu" class="w-6 h-6"></i>
            </button>
            <!-- End Navigation Toggle -->

            <!-- Breadcrumb -->
            <ol class="ms-3 flex items-center whitespace-nowrap" aria-label="Breadcrumb">
                <li class="flex items-center text-sm text-gray-800 dark:text-gray-400">
                    Admin
                    <i data-lucide="chevron-right"
                        class="shrink-0 mx-3 overflow-visible h-2.5 w-2.5 text-gray-400 dark:text-gray-600"></i>
                </li>
                <li class="text-sm font-semibold text-gray-800 truncate dark:text-gray-400" aria-current="page">
                    @yield('header', 'Dashboard')
                </li>
            </ol>
            <!-- End Breadcrumb -->
        </div>
    </div>
    <!-- End Navigation Toggle -->

    <!-- Sidebar -->
    <div id="application-sidebar"
        class="hs-overlay hs-overlay-open:translate-x-0 -translate-x-full transition-all duration-300 transform fixed top-0 start-0 bottom-0 z-[60] w-64 bg-white border-e border-gray-200 pt-7 pb-10 overflow-y-auto lg:block lg:translate-x-0 lg:end-auto lg:bottom-0 [&::-webkit-scrollbar]:w-2 [&::-webkit-scrollbar-thumb]:rounded-full [&::-webkit-scrollbar-track]:bg-gray-100 [&::-webkit-scrollbar-thumb]:bg-gray-300 dark:[&::-webkit-scrollbar-track]:bg-slate-700 dark:[&::-webkit-scrollbar-thumb]:bg-slate-500 dark:bg-slate-900 dark:border-gray-700">
        <div class="px-6">
            <a class="flex-none text-xl font-semibold dark:text-white" href="{{ url('/') }}" aria-label="Brand">
                {{ config('app.name', 'Laravel') }}
            </a>
        </div>

        <nav class="hs-accordion-group p-6 w-full flex flex-col flex-wrap" data-hs-accordion-always-open>
            <ul class="space-y-1.5">
                <li>
                    <a class="flex items-center gap-x-3.5 py-2 px-2.5 {{ request()->routeIs('admin.players') ? 'bg-gray-100 text-slate-700 dark:bg-slate-950 dark:text-white' : 'text-slate-700 hover:bg-gray-100 dark:hover:bg-slate-800 dark:text-slate-400 dark:hover:text-slate-300' }} text-sm rounded-lg"
                        href="{{ route('admin.players') }}">
                        <i data-lucide="users" class="w-4 h-4"></i>
                        {{ __('messages.players') }}
                    </a>
                </li>

                <li>
                    <a class="flex items-center gap-x-3.5 py-2 px-2.5 {{ request()->routeIs('admin.teams.*') ? 'bg-gray-100 text-slate-700 dark:bg-slate-950 dark:text-white' : 'text-slate-700 hover:bg-gray-100 dark:hover:bg-slate-800 dark:text-slate-400 dark:hover:text-slate-300' }} text-sm rounded-lg"
                        href="{{ route('admin.teams.index') }}">
                        <i data-lucide="shield" class="w-4 h-4"></i>
                        {{ __('messages.teams') }}
                    </a>
                </li>

                <li class="pt-4 border-t border-gray-200 dark:border-gray-700 mt-4">
                    <span class="block px-2.5 pb-2 text-xs font-semibold text-gray-400 uppercase">
                        {{ __('messages.language') }}
                    </span>
                    <div class="flex gap-2 px-2.5">
                        <a href="{{ route('lang.switch', 'en') }}"
                            class="py-1 px-2 text-xs font-medium rounded-md {{ app()->getLocale() == 'en' ? 'bg-indigo-600 text-white' : 'bg-gray-100 text-gray-600 dark:bg-slate-800 dark:text-gray-400' }}">
                            EN
                        </a>
                        <a href="{{ route('lang.switch', 'fr') }}"
                            class="py-1 px-2 text-xs font-medium rounded-md {{ app()->getLocale() == 'fr' ? 'bg-indigo-600 text-white' : 'bg-gray-100 text-gray-600 dark:bg-slate-800 dark:text-gray-400' }}">
                            FR
                        </a>
                    </div>
                </li>
            </ul>
        </nav>
    </div>
    <!-- End Sidebar -->

    <!-- Content -->
    <div class="w-full pt-10 px-4 sm:px-6 md:px-8 lg:ps-72">
        <header class="mb-5">
            <h1 class="block text-2xl font-bold text-gray-800 sm:text-3xl dark:text-white">@yield('header')</h1>
        </header>

        @if(session('success'))
            <div class="bg-teal-50 border-t-2 border-teal-500 rounded-lg p-4 mb-4 dark:bg-teal-800/30" role="alert">
                <div class="flex">
                    <div class="shrink-0">
                        <i data-lucide="check-circle" class="w-4 h-4 text-teal-500 mt-0.5"></i>
                    </div>
                    <div class="ms-3">
                        <p class="text-sm text-teal-800 dark:text-teal-200">
                            {{ session('success') }}
                        </p>
                    </div>
                </div>
            </div>
        @endif

        @yield('content')
    </div>
    <!-- End Content -->

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            lucide.createIcons();
        });
    </script>
    @stack('scripts')
</body>

</html>