<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Washing Station:') }} {{ $washing_station->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('admin.washing-stations.update', $washing_station) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                            <!-- Left Column: Primary Details -->
                            <div class="lg:col-span-2 space-y-6">
                                
                                <div class="bg-gray-50 p-4 rounded-md border">
                                    <h3 class="font-bold text-gray-700 border-b pb-2 mb-4">Basic Information</h3>
                                    
                                    <div class="mb-4">
                                        <label for="name" class="block text-gray-700 font-bold mb-2">Station Name <span class="text-red-500">*</span></label>
                                        <input type="text" name="name" id="name" class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" value="{{ old('name', $washing_station->name) }}" required>
                                        @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                    </div>
    
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <label for="location" class="block text-gray-700 font-bold mb-2">Location (District/Sector)</label>
                                            <input type="text" name="location" id="location" class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" value="{{ old('location', $washing_station->location) }}">
                                        </div>
                                        <div>
                                            <label for="altitude" class="block text-gray-700 font-bold mb-2">Altitude (m a.s.l)</label>
                                            <input type="text" name="altitude" id="altitude" class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" value="{{ old('altitude', $washing_station->altitude) }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="bg-gray-50 p-4 rounded-md border">
                                    <h3 class="font-bold text-gray-700 border-b pb-2 mb-4">Agronomic Details</h3>
                                    
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                        <div>
                                            <label for="coffee_variety" class="block text-gray-700 font-bold mb-2">Coffee Variety</label>
                                            <input type="text" name="coffee_variety" id="coffee_variety" class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" value="{{ old('coffee_variety', $washing_station->coffee_variety) }}">
                                        </div>
                                        <div>
                                            <label for="type_of_soil" class="block text-gray-700 font-bold mb-2">Type of Soil</label>
                                            <input type="text" name="type_of_soil" id="type_of_soil" class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" value="{{ old('type_of_soil', $washing_station->type_of_soil) }}">
                                        </div>
                                        <div>
                                            <label for="farmers_working" class="block text-gray-700 font-bold mb-2">No. of Farmers</label>
                                            <input type="number" name="farmers_working" id="farmers_working" class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" value="{{ old('farmers_working', $washing_station->farmers_working) }}">
                                        </div>
                                        <div>
                                            <label for="total_area_under_production" class="block text-gray-700 font-bold mb-2">Total Area (Ha)</label>
                                            <input type="text" name="total_area_under_production" id="total_area_under_production" class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" value="{{ old('total_area_under_production', $washing_station->total_area_under_production) }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="bg-gray-50 p-4 rounded-md border">
                                    <h3 class="font-bold text-gray-700 border-b pb-2 mb-4">Production & Quality</h3>
                                    
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                        <div>
                                            <label for="harvest_period" class="block text-gray-700 font-bold mb-2">Harvest Period</label>
                                            <input type="text" name="harvest_period" id="harvest_period" class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" value="{{ old('harvest_period', $washing_station->harvest_period) }}">
                                        </div>
                                        <div>
                                            <label for="cupping_score" class="block text-gray-700 font-bold mb-2">Cupping Score</label>
                                            <input type="text" name="cupping_score" id="cupping_score" class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" value="{{ old('cupping_score', $washing_station->cupping_score) }}">
                                        </div>
                                    </div>

                                    <div class="mb-4">
                                        <label for="processing" class="block text-gray-700 font-bold mb-2">Processing Methods</label>
                                        <textarea name="processing" id="processing" rows="2" class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('processing', $washing_station->processing) }}</textarea>
                                    </div>

                                    <div class="mb-4">
                                        <label for="traceability" class="block text-gray-700 font-bold mb-2">Traceability</label>
                                        <textarea name="traceability" id="traceability" rows="2" class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('traceability', $washing_station->traceability) }}</textarea>
                                    </div>
                                    
                                    <div class="mb-4">
                                        <label for="environment" class="block text-gray-700 font-bold mb-2">Environment / Flora & Fauna</label>
                                        <textarea name="environment" id="environment" rows="2" class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('environment', $washing_station->environment) }}</textarea>
                                    </div>
                                </div>

                            </div>

                            <!-- Right Column: Images and Meta -->
                            <div class="space-y-6">
                                <div class="bg-gray-50 p-4 rounded-md border">
                                    <h3 class="font-bold text-gray-700 border-b pb-2 mb-4">Media</h3>
                                    
                                    <div class="mb-4">
                                        <label for="image" class="block text-gray-700 font-bold mb-2">Cover Image</label>
                                        
                                        @if($washing_station->hasMedia('station_cover'))
                                            <div class="mb-3">
                                                <img src="{{ $washing_station->getFirstMediaUrl('station_cover') }}" alt="Cover" class="w-full h-auto object-cover rounded shadow-sm border">
                                            </div>
                                        @endif
                                        
                                        <input type="file" name="image" id="image" class="w-full text-sm border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" accept="image/*">
                                        <p class="text-xs text-gray-500 mt-1">Upload to replace main cover.</p>
                                    </div>

                                    <div class="mb-4 border-t pt-4">
                                        <label for="gallery_images" class="block text-gray-700 font-bold mb-2">Gallery Images</label>
                                        
                                        @if($washing_station->hasMedia('station_gallery'))
                                            <div class="grid grid-cols-3 gap-2 mb-3">
                                                @foreach($washing_station->getMedia('station_gallery') as $media)
                                                    <div class="relative group">
                                                        <img src="{{ $media->getUrl() }}" class="w-full h-16 object-cover rounded shadow-sm border">
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif
                                        
                                        <input type="file" name="gallery_images[]" id="gallery_images" class="w-full text-sm border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" accept="image/*" multiple>
                                        <p class="text-xs text-gray-500 mt-1">Upload to ADD to gallery.</p>
                                    </div>
                                </div>
                                
                                <div class="bg-gray-50 p-4 rounded-md border">
                                    <h3 class="font-bold text-gray-700 border-b pb-2 mb-4">Other Settings</h3>
                                    
                                    <div class="mb-4">
                                        <label for="certification" class="block text-gray-700 font-bold mb-2">Certifications</label>
                                        <input type="text" name="certification" id="certification" class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" value="{{ old('certification', $washing_station->certification) }}">
                                    </div>

                                    <div class="mb-4">
                                        <label for="other_coffee_available" class="block text-gray-700 font-bold mb-2">Other Coffee Available</label>
                                        <input type="text" name="other_coffee_available" id="other_coffee_available" class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" value="{{ old('other_coffee_available', $washing_station->other_coffee_available) }}">
                                    </div>

                                    <div class="mb-4">
                                        <label for="order" class="block text-gray-700 font-bold mb-2">Display Order</label>
                                        <input type="number" name="order" id="order" class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" value="{{ old('order', $washing_station->order) }}">
                                        <p class="text-xs text-gray-500 mt-1">Used to sort list display.</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-8 pt-4 border-t">
                            <a href="{{ route('admin.washing-stations.index') }}" class="text-gray-500 hover:underline mr-4">Cancel</a>
                            <button type="submit" class="bg-blue-600 text-white px-8 py-2 rounded-md hover:bg-blue-700 transition shadow-md">Update Station</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
