<x-guest-layout>
    <div class="text-center mb-8">
        <h2 class="text-2xl font-black text-[#8C6239]">Join the Club!</h2>
        <p class="text-gray-400 text-sm italic">Create an account for sweeter deals.</p>
    </div>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div>
            <label class="block font-bold text-xs text-[#8C6239] uppercase tracking-widest mb-1 ml-1">Name</label>
            <input id="name" class="block mt-1 w-full border-pink-100 focus:border-[#e75480] focus:ring-[#e75480] rounded-2xl shadow-sm bg-pink-50/30" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div class="mt-4">
            <label class="block font-bold text-xs text-[#8C6239] uppercase tracking-widest mb-1 ml-1">Email Address</label>
            <input id="email" class="block mt-1 w-full border-pink-100 focus:border-[#e75480] focus:ring-[#e75480] rounded-2xl shadow-sm bg-pink-50/30" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mt-4">
            <label class="block font-bold text-xs text-[#8C6239] uppercase tracking-widest mb-1 ml-1">Password</label>
            <input id="password" class="block mt-1 w-full border-pink-100 focus:border-[#e75480] focus:ring-[#e75480] rounded-2xl shadow-sm bg-pink-50/30" type="password" name="password" required autocomplete="new-password" placeholder="" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="mt-4">
            <label class="block font-bold text-xs text-[#8C6239] uppercase tracking-widest mb-1 ml-1">Confirm Password</label>
            <input id="password_confirmation" class="block mt-1 w-full border-pink-100 focus:border-[#e75480] focus:ring-[#e75480] rounded-2xl shadow-sm bg-pink-50/30" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="mt-8">
            <button class="w-full py-4 bg-[#8C6239] hover:bg-[#765330] text-white rounded-2xl font-bold transition-all shadow-lg hover:shadow-[#8C6239]/30 active:scale-95 uppercase tracking-widest">
                {{ __('Create Account') }}
            </button>
        </div>

        <div class="mt-8 text-center border-t border-pink-50 pt-6">
            <p class="text-sm text-gray-500">Already have an account? 
                <a href="{{ route('login') }}" class="font-bold text-[#e75480] hover:underline italic">Log In here</a>
            </p>
        </div>
    </form>
</x-guest-layout>