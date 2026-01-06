<x-guest-layout>
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="text-center mb-8">
        <h2 class="text-2xl font-black text-[#8C6239]">Welcome Back!</h2>
        <p class="text-gray-400 text-sm italic">Sweet moments are waiting for you.</p>
    </div>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div>
            <label class="block font-bold text-xs text-[#8C6239] uppercase tracking-widest mb-1 ml-1">Email Address</label>
            <input id="email" class="block mt-1 w-full border-pink-100 focus:border-[#e75480] focus:ring-[#e75480] rounded-2xl shadow-sm bg-pink-50/30" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mt-6">
            <label class="block font-bold text-xs text-[#8C6239] uppercase tracking-widest mb-1 ml-1">Password</label>
            <input id="password" class="block mt-1 w-full border-pink-100 focus:border-[#e75480] focus:ring-[#e75480] rounded-2xl shadow-sm bg-pink-50/30" type="password" name="password" required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-pink-200 text-[#e75480] shadow-sm focus:ring-[#e75480]" name="remember">
                <span class="ms-2 text-sm text-gray-500">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex flex-col gap-4 mt-8">
            <button class="w-full py-4 bg-[#8C6239] hover:bg-[#765330] text-white rounded-2xl font-bold transition-all shadow-lg hover:shadow-[#8C6239]/30 active:scale-95">
                {{ __('LOG IN') }}
            </button>
            
            @if (Route::has('password.request'))
                <a class="text-center text-sm text-gray-400 hover:text-[#e75480] transition" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif
        </div>

        <div class="mt-8 text-center border-t border-pink-50 pt-6">
            <p class="text-sm text-gray-500">Don't have an account? 
                <a href="{{ route('register') }}" class="font-bold text-[#e75480] hover:underline italic">Create one!</a>
            </p>
        </div>
    </form>
</x-guest-layout>