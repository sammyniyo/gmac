<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="text-xs font-semibold uppercase tracking-[0.24em] text-slate-500">Account</p>
            <h2 class="mt-1 text-2xl font-semibold tracking-tight text-slate-950">
                Dashboard
            </h2>
            <p class="mt-2 text-sm text-slate-500">
                Your account is active and ready to use.
            </p>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border">
                <div class="p-6 text-gray-900">
                    <div class="grid gap-4 md:grid-cols-2">
                        <div class="rounded-2xl border border-slate-200 bg-slate-50 p-5">
                            <div class="text-sm font-semibold text-slate-900">{{ auth()->user()->name }}</div>
                            <div class="mt-1 text-sm text-slate-500">{{ auth()->user()->email }}</div>
                            <div class="mt-4 inline-flex rounded-full border border-slate-200 bg-white px-3 py-1 text-xs font-medium text-slate-600">
                                {{ auth()->user()->is_admin ? 'Administrator' : 'User account' }}
                            </div>
                        </div>

                        <div class="rounded-2xl border border-slate-200 bg-slate-50 p-5">
                            <div class="text-sm font-semibold text-slate-900">Quick access</div>
                            <p class="mt-2 text-sm leading-6 text-slate-500">
                                Update your profile information or return to the public website.
                            </p>
                            <div class="mt-4 flex flex-wrap gap-3">
                                <a href="{{ route('profile.edit') }}" class="rounded-md border border-slate-200 bg-white px-4 py-2 text-sm font-medium text-slate-700 transition hover:bg-slate-100">
                                    Edit profile
                                </a>
                                <a href="{{ route('home') }}" class="rounded-md border border-slate-200 bg-white px-4 py-2 text-sm font-medium text-slate-700 transition hover:bg-slate-100">
                                    Visit website
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
