@extends('layouts.app')

@section('content')
<div class="max-w-[24rem] mx-auto w-full p-6">
    <div class="mt-7 bg-white border border-slate-200 rounded-xl shadow-sm">
        <div class="p-4 sm:p-7">
            <div class="text-center">
                <h1 class="block text-2xl font-bold text-slate-800">{{ __('Login') }}</h1>
                @if (Route::has('register'))
                <p class="mt-2 text-sm text-slate-600">
                    Don't have an account yet?
                    <a class="text-indigo-600 hover:text-indigo-700 decoration-2 hover:underline font-medium transition-all" href="{{ route('register') }}">
                        Sign up here
                    </a>
                </p>
                @endif
            </div>

            <div class="mt-5">
                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="grid gap-y-4">
                        <!-- Email Address -->
                        <div>
                            <label for="email" class="block text-sm mb-2 font-medium text-slate-700 font-semibold">{{ __('Email Address') }}</label>
                            <div class="relative">
                                <input type="email" id="email" name="email" value="{{ old('email') }}" class="py-3 px-4 block w-full border-slate-200 rounded-lg text-sm focus:border-indigo-500 focus:ring-indigo-500 disabled:opacity-50 disabled:pointer-events-none @error('email') border-red-500 focus:border-red-500 focus:ring-red-500 @enderror" required autocomplete="email" autofocus>
                                @error('email')
                                <p class="text-xs text-red-600 mt-2" id="email-error">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Password -->
                        <div>
                            <div class="flex justify-between items-center">
                                <label for="password" class="block text-sm mb-2 font-medium text-slate-700 font-semibold">{{ __('Password') }}</label>
                                @if (Route::has('password.request'))
                                <a class="text-sm text-indigo-600 hover:text-indigo-700 decoration-2 hover:underline font-medium transition-all" href="{{ route('password.request') }}">
                                    {{ __('Forgot Your Password?') }}
                                </a>
                                @endif
                            </div>
                            <div class="relative">
                                <input type="password" id="password" name="password" class="py-3 px-4 block w-full border-slate-200 rounded-lg text-sm focus:border-indigo-500 focus:ring-indigo-500 disabled:opacity-50 disabled:pointer-events-none @error('password') border-red-500 focus:border-red-500 focus:ring-red-500 @enderror" required autocomplete="current-password">
                                @error('password')
                                <p class="text-xs text-red-600 mt-2" id="password-error">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Remember Me -->
                        <div class="flex items-center">
                            <div class="flex">
                                <input id="remember" name="remember" type="checkbox" {{ old('remember') ? 'checked' : '' }} class="shrink-0 mt-0.5 border-slate-200 rounded text-indigo-600 focus:ring-indigo-500">
                            </div>
                            <div class="ms-3">
                                <label for="remember" class="text-sm text-slate-600">{{ __('Remember Me') }}</label>
                            </div>
                        </div>

                        <button type="submit" class="w-full py-3 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-indigo-600 text-white hover:bg-indigo-700 disabled:opacity-50 disabled:pointer-events-none transition-all">
                            {{ __('Login') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
