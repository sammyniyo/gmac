<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Washing Stations') }}
            </h2>
            <a href="{{ route('admin.washing-stations.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition">Add New Station</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b">
                                <th class="p-3 w-24">Cover</th>
                                <th class="p-3">Name</th>
                                <th class="p-3">Location</th>
                                <th class="p-3">Altitude</th>
                                <th class="p-3">Farmers</th>
                                <th class="p-3 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($stations as $station)
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="p-3">
                                        @if($station->hasMedia('station_cover'))
                                            <img src="{{ $station->getFirstMediaUrl('station_cover') }}" alt="{{ $station->name }}" class="w-16 h-12 object-cover rounded shadow-sm">
                                        @else
                                            <div class="w-16 h-12 bg-gray-200 rounded flex items-center justify-center text-xs text-gray-500">No Img</div>
                                        @endif
                                    </td>
                                    <td class="p-3 font-semibold">{{ $station->name }}</td>
                                    <td class="p-3 text-sm text-gray-600">{{ $station->location ?: '-' }}</td>
                                    <td class="p-3 text-sm text-gray-600">{{ $station->altitude ?: '-' }}</td>
                                    <td class="p-3 text-sm text-gray-600">{{ $station->farmers_working ?: '-' }}</td>
                                    <td class="p-3 text-right flex justify-end items-center space-x-3 h-full pt-4 mt-1">
                                        <a href="{{ route('admin.washing-stations.edit', $station) }}" class="text-blue-500 hover:underline">Edit</a>
                                        <form action="{{ route('admin.washing-stations.destroy', $station) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this washing station?');" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:underline cursor-pointer">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="p-4 text-center text-gray-500">No washing stations found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    
                    <div class="mt-4">
                        {{ $stations->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
