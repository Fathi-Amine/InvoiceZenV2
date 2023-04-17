<x-app-layout>
    <form action="{{ route('login') }}"method="POST" class="w-[400px] mx-auto p-6 my-16">
        @csrf
        <h2 class="text-2xl font-semibold text-center mb-5">
            Login to your account
        </h2>
        <p class="text-center text-gray-500 mb-6">
            or
            <a href="{{ route('register') }}" class="text-sm text-purple-700 hover:text-purple-600">create new account</a>
        </p>
        <x-input-error :messages="$errors->get('email')" class="mt-2" />
        <x-input-error :messages="$errors->get('password')" class="mt-2" />
        <div class="mb-4">
            <x-text-input id="loginEmail" type="email" name="email" :value="old('email')" :errors="$errors"
                placeholder="Your email address"
                class="border-gray-300 focus:border-purple-500 focus:outline-none focus:ring-purple-500 rounded-md w-full" />

        </div>
        <div class="mb-4">
            <x-text-input id="loginPassword" type="password" name="password" placeholder="Your password"
                class="border-gray-300 focus:border-purple-500 focus:outline-none focus:ring-purple-500 rounded-md w-full" />

        </div>

        <div class="flex justify-between items-center mb-5">
            <div class="flex items-center">
                <input id="loginRememberMe" type="checkbox"
                    class="mr-3 rounded border-gray-300 text-purple-500 focus:ring-purple-500" name="remember" />
                <label for="loginRememberMe">Remember Me</label>
            </div>
            <a href="{{ route('password.request') }}" class="text-sm text-purple-700 hover:text-purple-600">Forgot
                Password?</a>
        </div>
        <button class="btn-primary bg-emerald-500 hover:bg-emerald-600 active:bg-emerald-700 w-full">
            Login
        </button>
    </form>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />
    {{-- 
    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"
                required autofocus autocomplete="username" />

        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                autocomplete="current-password" />


        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox"
                    class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <x-primary-button class="ml-3">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form> --}}
</x-app-layout>
