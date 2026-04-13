<x-guest-layout>
    <div>
        <p class="text-sm font-bold uppercase tracking-[0.28em] text-amber-700">Welcome Back</p>
        <h2 class="mt-3 font-[Cormorant_Garamond] text-4xl leading-none text-stone-900">Sign in to the admin dashboard</h2>
        <p class="mt-3 text-sm leading-7 text-stone-600">Use your GMAC Coffee account to manage products, content, and site settings.</p>
    </div>

    <x-auth-session-status class="mt-6 rounded-2xl border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="mt-8 space-y-5">
        @csrf

        <div>
            <label for="email" class="mb-2 block text-sm font-semibold text-stone-700">Email Address</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                class="block w-full rounded-2xl border border-stone-300 bg-stone-50 px-4 py-3 text-stone-900 shadow-sm outline-none transition focus:border-amber-500 focus:bg-white focus:ring-4 focus:ring-amber-100">
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-sm text-red-600" />
        </div>

        <div>
            <label for="password" class="mb-2 block text-sm font-semibold text-stone-700">Password</label>
            <input id="password" type="password" name="password" required autocomplete="current-password"
                class="block w-full rounded-2xl border border-stone-300 bg-stone-50 px-4 py-3 text-stone-900 shadow-sm outline-none transition focus:border-amber-500 focus:bg-white focus:ring-4 focus:ring-amber-100">
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-sm text-red-600" />
        </div>

        <div class="flex items-center justify-between gap-4">
            <label for="remember_me" class="inline-flex items-center gap-3 text-sm text-stone-600">
                <input id="remember_me" type="checkbox" name="remember" class="rounded border-stone-300 text-amber-700 shadow-sm focus:ring-amber-500">
                <span>Remember me</span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-sm font-medium text-amber-800 hover:text-amber-900" href="{{ route('password.request') }}">
                    Forgot password?
                </a>
            @endif
        </div>

        <button type="submit"
            class="inline-flex w-full items-center justify-center rounded-2xl bg-stone-950 px-5 py-3.5 text-sm font-bold uppercase tracking-[0.22em] text-white transition hover:bg-amber-800 focus:outline-none focus:ring-4 focus:ring-amber-200">
            Log In
        </button>
    </form>
</x-guest-layout>
