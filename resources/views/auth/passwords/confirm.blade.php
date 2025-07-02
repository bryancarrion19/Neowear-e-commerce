@extends('layouts.app')

@section('content')
    <div class="flex items-start justify-center bg-gray-100 px-4 pt-12">
        <div class="w-full max-w-md bg-white shadow-lg rounded-2xl p-8">
            <h2 class="text-2xl font-semibold text-gray-900 text-center mb-6">{{ __('Confirm Password') }}</h2>

            <p class="text-gray-700 mb-4">{{ __('Please confirm your password before continuing.') }}</p>

            <form method="POST" action="{{ route('password.confirm') }}">
                @csrf

                <div class="mb-4">
                    <label for="password" class="block text-gray-700 font-medium mb-1">{{ __('Password') }}</label>
                    <input id="password" type="password" name="password" required autocomplete="current-password"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-gray-900 transition @error('password') border-red-500 @enderror">
                    @error('password')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mt-6 flex items-center justify-between">
                    <button type="submit"
                        class="bg-gray-900 text-white py-3 rounded-lg hover:bg-gray-800 transition font-medium px-4">
                        {{ __('Confirm Password') }}
                    </button>

                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-gray-600 hover:text-gray-900 text-sm">
                            {{ __('Forgot Your Password?') }}
                        </a>
                    @endif
                </div>
            </form>
        </div>
    </div>
@endsection
