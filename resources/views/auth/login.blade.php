<x-guest-layout>
    <p class="text-sm font-medium text-[#8d6b2a]">{{ \App\Models\Setting::where('key', 'company_name')->value('value') ?? 'GMAC Coffee' }}</p>
    <h1 class="mt-2 text-[2.15rem] font-semibold leading-none text-[#2a1c14]">Sign in</h1>
    <p class="mt-3 text-sm text-[#6b5344]">Admin dashboard</p>

    <x-auth-session-status class="mt-6 rounded-[12px] border border-[#b7e4c7] bg-[#f0fdf4] px-4 py-3 text-sm text-[#166534]" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="mt-8 space-y-5" id="login-form">
        @csrf

        <div>
            <label for="email" class="mb-2 block text-sm font-medium text-[#2a1c14]">Email or username</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                placeholder="Enter the email you use for this account"
                class="block h-11 w-full rounded-[12px] border border-[#e8ddd0] bg-white px-4 text-[15px] text-[#2a1c14] outline-none transition placeholder:text-[#a08974] focus:border-[#c4a15a] focus:ring-4 focus:ring-[#c4a15a]/15">
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-sm text-red-600" />
        </div>

        <div>
            <label for="password" class="mb-2 block text-sm font-medium text-[#2a1c14]">Password</label>
            <div class="relative">
                <input id="password" type="password" name="password" required autocomplete="current-password"
                    placeholder="Enter your password here"
                    class="block h-11 w-full rounded-[12px] border border-[#e8ddd0] bg-white px-4 pr-12 text-[15px] text-[#2a1c14] outline-none transition placeholder:text-[#a08974] focus:border-[#c4a15a] focus:ring-4 focus:ring-[#c4a15a]/15">
                <button type="button" id="toggle-password" class="absolute inset-y-0 right-0 flex w-11 items-center justify-center text-[#6b5344]" aria-label="Show password">
                    <svg id="eye-open" xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.7"><path stroke-linecap="round" stroke-linejoin="round" d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7S2 12 2 12z"/><circle cx="12" cy="12" r="3"/></svg>
                    <svg id="eye-shut" class="hidden" xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.7"><path stroke-linecap="round" stroke-linejoin="round" d="M3 3l18 18M10.6 10.6A3 3 0 0012 15a3 3 0 002.4-4.4M6.7 6.7C4.3 8.2 2.8 10.4 2 12c1.5 3.1 5.2 7 10 7 1.9 0 3.6-.5 5.1-1.3M17.3 17.3C19.7 15.8 21.2 13.6 22 12c-.7-1.4-1.8-3-3.3-4.3"/></svg>
                </button>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-sm text-red-600" />
        </div>

        <div class="flex items-center justify-between gap-4">
            <label for="remember_me" class="inline-flex items-center gap-2.5 text-sm text-[#6b5344]">
                <input id="remember_me" type="checkbox" name="remember" class="rounded border-[#e8ddd0] text-[#3d2918] shadow-none focus:ring-[#c4a15a]">
                <span>Remember me</span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-sm font-medium text-[#3d2918] hover:text-[#8d6b2a]" href="{{ route('password.request') }}">
                    Forgot password?
                </a>
            @endif
        </div>

        <button type="submit"
            class="inline-flex h-[46px] w-full items-center justify-center rounded-[12px] bg-[#7a6452] px-6 text-[15px] font-medium text-white transition hover:bg-[#8d7560] focus:outline-none focus:ring-4 focus:ring-[#b89a6a]/25">
            Sign in
        </button>
    </form>

    <script>
        (function () {
            var btn = document.getElementById('toggle-password');
            var input = document.getElementById('password');
            var open = document.getElementById('eye-open');
            var shut = document.getElementById('eye-shut');
            if (!btn || !input) return;
            btn.addEventListener('click', function () {
                var show = input.type === 'password';
                input.type = show ? 'text' : 'password';
                btn.setAttribute('aria-label', show ? 'Hide password' : 'Show password');
                open.classList.toggle('hidden', show);
                shut.classList.toggle('hidden', !show);
            });
        })();
    </script>
</x-guest-layout>
