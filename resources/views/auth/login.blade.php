   @if ($errors->any())
    <div class="alert alert-danger bg-red-600 text-center">
        {{ $errors->first() }}
    </div>
@endif
<x-guest-layout>

    @slot('title')
        Your Stay Awaits!
    @endslot

    @slot('description')
        Login in to access your bookings and enjoy a steamless hotel experience.
    @endslot
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />


    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" placeholder="Enter your email" class="block mt-1 w-full placeholder-gray-400 placeholder:italic" type="email" name="email" :value="old('email')" required autofocus autocomplete="username"  />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

       
        <!-- Password -->
        <div class="mt-4 relative">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full pr-12 placeholder-gray-400 placeholder:italic"
                        type="password"
                        name="password"
                        placeholder="Enter your password"
                        required autocomplete="current-password" />

            <!-- Eye Icon Button -->
            <button type="button"
                    onclick="togglePassword()"
                    class="absolute right-3 top-9 text-gray-500 hover:text-gray-400">
                <!-- Eye (visible) -->
                <svg id="eye-open" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                    class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>

                <!-- Eye Slash (hidden) -->
                <svg id="eye-closed" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                    class="w-5 h-5 hidden">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M3 3l18 18M10.477 10.477A3 3 0 0113.5 13.5M6.53 6.53A9.97 9.97 0 0112 5c4.477 0 8.268 2.943 9.542 7a9.98 9.98 0 01-4.026 5.035M9.88 9.88A3 3 0 0114.12 14.12"/>
                </svg>
            </button>
     @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-300 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>


        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded bg-gray-300 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800" name="remember">
                <span class="ms-2 text-sm text-gray-300 dark:text-gray-400">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
           
             <a href="{{ route('register') }}"
            class="underline text-sm hover:text-gray-200 text-gray-200 dark:hover:text-gray-100">
                {{ __("Don't have an account? Sign up") }}
            </a>
            <x-primary-button class="ms-3">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>

<script>
function togglePassword() {
    const input = document.getElementById("password");
    const eyeOpen = document.getElementById("eye-open");
    const eyeClosed = document.getElementById("eye-closed");

    if (input.type === "password") {
        input.type = "text";
        eyeOpen.classList.add("hidden");
        eyeClosed.classList.remove("hidden");
    } else {
        input.type = "password";
        eyeClosed.classList.add("hidden");
        eyeOpen.classList.remove("hidden");
    }
}
</script>
