<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Laravel Project')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 text-slate-800 font-sans antialiased">
    <!-- Header -->
    <header class="flex flex-wrap sm:justify-start sm:flex-nowrap z-50 w-full bg-white border-b border-gray-200 text-sm py-3 sm:py-0">
        <nav class="max-w-[85rem] w-full mx-auto px-4 sm:flex sm:items-center sm:justify-between" aria-label="Global">
            <div class="flex items-center justify-between">
                <a class="flex-none text-xl font-semibold text-indigo-600" href="{{ route('public.players') }}">
                    MyApp
                </a>
                <div class="sm:hidden">
                    <button type="button" class="hs-collapse-toggle p-2 inline-flex justify-center items-center gap-2 rounded-md border font-medium bg-white text-gray-700 shadow-sm align-middle hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-white focus:ring-blue-600 transition-all text-sm" data-hs-collapse="#navbar-collapse-with-animation" aria-controls="navbar-collapse-with-animation" aria-label="Toggle navigation">
                        <i data-lucide="menu" class="w-4 h-4"></i>
                        <i data-lucide="x" class="hidden w-4 h-4"></i>
                    </button>
                </div>
            </div>
            <div id="navbar-collapse-with-animation" class="hs-collapse hidden overflow-hidden transition-all duration-300 basis-full grow sm:block">
                <div class="flex flex-col gap-5 mt-5 sm:flex-row sm:items-center sm:justify-end sm:mt-0 sm:pl-5">
                    <a class="font-medium {{ request()->routeIs('public.players') ? 'text-indigo-600' : 'text-gray-600 hover:text-gray-400' }}" href="{{ route('public.players') }}">
                        Players
                    </a>
                    <a class="font-medium text-gray-600 hover:text-gray-400" href="{{ route('admin.players') }}">
                        <div class="flex items-center gap-x-2">
                            <i data-lucide="shield-check" class="w-4 h-4"></i>
                            Admin Area
                        </div>
                    </a>
                </div>
            </div>
        </nav>
    </header>

    <main class="max-w-[85rem] mx-auto px-4 sm:px-6 lg:px-8 py-10">
        @yield('content')
    </main>
</body>
</html>
