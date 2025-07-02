@extends('layouts.app')

@section('content')
<div class="flex items-start justify-center bg-gray-100 px-4 pt-12">
    <div class="w-full max-w-md bg-white shadow-lg rounded-2xl p-8">
        <h2 class="text-2xl font-semibold text-gray-900 text-center mb-6">{{ __('Login') }}</h2>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="mb-4">
                <label for="email" class="block text-gray-700 font-medium mb-1">{{ __('Email Address') }}</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-gray-900 transition @error('email') border-red-500 @enderror">
                @error('email')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="password" class="block text-gray-700 font-medium mb-1">{{ __('Password') }}</label>
                <input id="password" type="password" name="password" required autocomplete="current-password" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-gray-900 transition @error('password') border-red-500 @enderror">
                @error('password')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4 flex items-center justify-between">
                <div class="flex items-center">
                    <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }} class="text-gray-900 focus:ring-gray-900">
                    <label for="remember" class="ml-2 text-gray-700">{{ __('Remember Me') }}</label>
                </div>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-gray-600 hover:text-gray-900 text-sm">{{ __('Forgot Your Password?') }}</a>
                @endif
            </div>

            <div class="mt-6">
                <button type="submit" class="w-full bg-gray-900 text-white py-3 rounded-lg hover:bg-gray-800 transition font-medium">
                    {{ __('Login') }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
