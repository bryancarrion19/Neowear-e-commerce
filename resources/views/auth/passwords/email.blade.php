@extends('layouts.app')

@section('content')
    <div class="flex items-start justify-center bg-gray-100 px-4 pt-12">
        <div class="w-full max-w-md bg-white shadow-lg rounded-2xl p-8">
            <h2 class="text-2xl font-semibold text-gray-900 text-center mb-6">{{ __('Reset Password') }}</h2>

            @if (session('status'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                    <p>{{ session('status') }}</p>
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <div class="mb-4">
                    <label for="email" class="block text-gray-700 font-medium mb-1">{{ __('Email Address') }}</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required
                        autocomplete="email" autofocus
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-gray-900 transition @error('email') border-red-500 @enderror">
                    @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mt-6">
                    <button type="submit"
                        class="w-full bg-gray-900 text-white py-3 rounded-lg hover:bg-gray-800 transition font-medium">
                        {{ __('Send Password Reset Link') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
