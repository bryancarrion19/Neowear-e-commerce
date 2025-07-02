@extends('layouts.app')

@section('content')
    <div class="flex items-start justify-center bg-gray-100 px-4 pt-12">
        <div class="w-full max-w-md bg-white shadow-lg rounded-2xl p-8">
            <h2 class="text-2xl font-semibold text-gray-900 text-center mb-6">{{ __('Verify Your Email Address') }}</h2>

            @if (session('resent'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                    <p>{{ __('A fresh verification link has been sent to your email address.') }}</p>
                </div>
            @endif

            <p class="text-gray-700 mb-4">{{ __('Before proceeding, please check your email for a verification link.') }}</p>
            <p class="text-gray-700 mb-4">{{ __('If you did not receive the email') }},</p>

            <form method="POST" action="{{ route('verification.resend') }}">
                @csrf
                <button type="submit"
                    class="w-full bg-gray-900 text-white py-3 rounded-lg hover:bg-gray-800 transition font-medium">
                    {{ __('Click here to request another') }}
                </button>
            </form>
        </div>
    </div>
@endsection
