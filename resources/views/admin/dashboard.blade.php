<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    {{ __("Welcome to the Admin Dashboard!") }}
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 text-center">
                        <div class="text-3xl font-bold mb-2">{{ $stats['products'] }}</div>
                        <div class="text-gray-500 uppercase text-sm font-semibold tracking-wider">Total Products</div>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 text-center">
                        <div class="text-3xl font-bold mb-2">{{ $stats['messages'] }}</div>
                        <div class="text-gray-500 uppercase text-sm font-semibold tracking-wider">Contact Messages</div>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 text-center">
                        <div class="text-3xl font-bold mb-2">{{ $stats['subscribers'] }}</div>
                        <div class="text-gray-500 uppercase text-sm font-semibold tracking-wider">Newsletter Subscribers</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
