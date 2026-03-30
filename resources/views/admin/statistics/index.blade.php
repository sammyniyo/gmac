<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Statistics Counters') }}
            </h2>
            <a href="{{ route('admin.statistics.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded shadow">
                Add New Counter
            </a>
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
                <div class="p-6 text-gray-900">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b bg-gray-50">
                                <th class="p-3 w-16 text-center">Order</th>
                                <th class="p-3">Title</th>
                                <th class="p-3">Number/Value</th>
                                <th class="p-3">Icon Class</th>
                                <th class="p-3 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($statistics as $stat)
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="p-3 text-center font-mono text-gray-500">{{ $stat->order }}</td>
                                    <td class="p-3 font-semibold text-gray-900">{{ $stat->title }}</td>
                                    <td class="p-3 font-bold text-indigo-600">{{ $stat->number }}</td>
                                    <td class="p-3 font-mono text-sm text-gray-500">
                                        @if($stat->icon)
                                            <i class="{{ $stat->icon }} mr-2"></i> {{ $stat->icon }}
                                        @else
                                            <span class="text-gray-300 italic">None</span>
                                        @endif
                                    </td>
                                    <td class="p-3 text-right">
                                        <a href="{{ route('admin.statistics.edit', $stat) }}" class="text-blue-600 hover:text-blue-900 font-medium mr-3">Edit</a>
                                        <form action="{{ route('admin.statistics.destroy', $stat) }}" method="POST" class="inline" onsubmit="return confirm('Delete this statistic counter?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900 font-medium cursor-pointer">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="p-6 text-center text-gray-500 py-10">
                                        No statistics counters found. <br><br>
                                        <a href="{{ route('admin.statistics.create') }}" class="text-indigo-600 hover:underline">Create your first counter</a>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
