@extends('layouts.app')

@section('content')
<div class="max-w-[30rem] mx-auto w-full p-6">
    <div class="mt-7 bg-white border border-slate-200 rounded-xl shadow-sm">
        <div class="p-4 sm:p-7">
            <div class="text-center">
                <h1 class="block text-2xl font-bold text-slate-800">{{ __('Verify Your Email Address') }}</h1>
            </div>

            <div class="mt-5">
                @if (session('resent'))
                    <div class="mb-4 bg-teal-50 border border-teal-200 text-sm text-teal-800 rounded-lg p-4" role="alert">
                        {{ __('A fresh verification link has been sent to your email address.') }}
                    </div>
                @endif

                <div class="text-sm text-slate-600 space-y-4">
                    <p>
                        {{ __('Before proceeding, please check your email for a verification link.') }}
                    </p>
                    <p>
                        {{ __('If you did not receive the email') }},
                        <form class="inline" method="POST" action="{{ route('verification.resend') }}">
                            @csrf
                            <button type="submit" class="text-indigo-600 hover:text-indigo-700 decoration-2 hover:underline font-medium transition-all">{{ __('click here to request another') }}</button>.
                        </form>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
