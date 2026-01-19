<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="mb-8 text-center">
        <h2 class="text-3xl font-bold text-gray-800">Welcome Back</h2>
        <p class="text-gray-600 mt-2">Please enter your details to sign in</p>
    </div>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" class="text-gray-700 font-semibold" />
            <x-text-input id="email" class="block mt-1 w-full border-gray-200 focus:border-indigo-500 focus:ring-indigo-500 rounded-xl" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-6">
            <x-input-label for="password" :value="__('Password')" class="text-gray-700 font-semibold" />

            <x-text-input id="password" class="block mt-1 w-full border-gray-200 focus:border-indigo-500 focus:ring-indigo-500 rounded-xl"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-6">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded-lg border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-sm text-gray-600 font-medium">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex flex-col gap-4 mt-8">
            <x-primary-button class="w-full justify-center py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl shadow-lg shadow-indigo-500/30 transition-all duration-300">
                {{ __('Log in') }}
            </x-primary-button>

            @if (Route::has('password.request'))
                <div class="text-center">
                    <a class="text-sm text-indigo-600 hover:text-indigo-800 font-semibold transition-colors" href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                </div>
            @endif
        </div>
    </form>
</x-guest-layout>
