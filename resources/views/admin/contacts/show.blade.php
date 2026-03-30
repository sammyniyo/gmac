<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center">
                <a href="{{ route('admin.contacts.index') }}" class="text-gray-500 hover:text-gray-700 mr-2">&larr; Back</a>
                {{ __('Message from:') }} {{ $contact->name }}
            </h2>
            <form action="{{ route('admin.contacts.destroy', $contact) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this message?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-50 text-red-600 hover:bg-red-100 px-4 py-2 rounded-md transition font-medium text-sm">Delete Message</button>
            </form>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-8 text-gray-900 border-b border-gray-200">
                    
                    <div class="flex flex-col md:flex-row md:justify-between md:items-start mb-8 pb-6 border-b">
                        <div>
                            <h3 class="text-2xl font-bold mb-1">{{ $contact->subject ?: 'No Subject' }}</h3>
                            <div class="flex items-center text-sm text-gray-500 mt-2 space-x-4">
                                <span><strong class="text-gray-700">From:</strong> {{ $contact->name }}</span>
                                <span><strong class="text-gray-700">Email:</strong> <a href="mailto:{{ $contact->email }}" class="text-blue-600 hover:underline">{{ $contact->email }}</a></span>
                            </div>
                        </div>
                        <div class="mt-4 md:mt-0 text-right">
                            <span class="text-sm text-gray-500 block">{{ $contact->created_at->format('l, F j, Y') }}</span>
                            <span class="text-xs text-gray-400 block">{{ $contact->created_at->format('g:i A') }} ({{ $contact->created_at->diffForHumans() }})</span>
                        </div>
                    </div>

                    <div class="prose max-w-none mb-8">
                        <p class="whitespace-pre-wrap text-gray-800 leading-relaxed">{{ $contact->message }}</p>
                    </div>

                    <div class="mt-10 pt-6 border-t border-gray-100 flex justify-start">
                        <a href="mailto:{{ $contact->email }}?subject=Re: {{ urlencode($contact->subject ?: 'Your inquiry') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            Reply to {{ $contact->name }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
