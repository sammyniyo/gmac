<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\WashingStation;

class WashingStationController extends Controller
{
    public function index()
    {
        $stations = WashingStation::orderBy('order')->paginate(10);
        return view('admin.washing-stations.index', compact('stations'));
    }

    public function create()
    {
        return view('admin.washing-stations.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'nullable|string|max:255',
            'altitude' => 'nullable|string|max:255',
            'type_of_soil' => 'nullable|string|max:255',
            'coffee_variety' => 'nullable|string|max:255',
            'farmers_working' => 'nullable|integer',
            'total_area_under_production' => 'nullable|string|max:255',
            'harvest_period' => 'nullable|string|max:255',
            'processing' => 'nullable|string',
            'other_coffee_available' => 'nullable|string|max:255',
            'cupping_score' => 'nullable|string|max:255',
            'traceability' => 'nullable|string',
            'certification' => 'nullable|string|max:255',
            'environment' => 'nullable|string',
            'order' => 'nullable|integer',
            'image' => 'nullable|image|max:4096',
            'gallery_images.*' => 'nullable|image|max:4096'
        ]);

        $validated['order'] = $validated['order'] ?? 0;

        $station = WashingStation::create(\Illuminate\Support\Arr::except($validated, ['image', 'gallery_images']));

        if ($request->hasFile('image')) {
            $station->addMediaFromRequest('image')->toMediaCollection('station_cover');
        }

        if ($request->hasFile('gallery_images')) {
            foreach ($request->file('gallery_images') as $file) {
                $station->addMedia($file)->toMediaCollection('station_gallery');
            }
        }

        return redirect()->route('admin.washing-stations.index')->with('success', 'Washing Station created successfully.');
    }

    public function edit(WashingStation $washing_station)
    {
        return view('admin.washing-stations.edit', compact('washing_station'));
    }

    public function update(Request $request, WashingStation $washing_station)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'nullable|string|max:255',
            'altitude' => 'nullable|string|max:255',
            'type_of_soil' => 'nullable|string|max:255',
            'coffee_variety' => 'nullable|string|max:255',
            'farmers_working' => 'nullable|integer',
            'total_area_under_production' => 'nullable|string|max:255',
            'harvest_period' => 'nullable|string|max:255',
            'processing' => 'nullable|string',
            'other_coffee_available' => 'nullable|string|max:255',
            'cupping_score' => 'nullable|string|max:255',
            'traceability' => 'nullable|string',
            'certification' => 'nullable|string|max:255',
            'environment' => 'nullable|string',
            'order' => 'nullable|integer',
            'image' => 'nullable|image|max:4096',
            'gallery_images.*' => 'nullable|image|max:4096'
        ]);

        $validated['order'] = $validated['order'] ?? 0;

        $washing_station->update(\Illuminate\Support\Arr::except($validated, ['image', 'gallery_images']));

        if ($request->hasFile('image')) {
            $washing_station->clearMediaCollection('station_cover');
            $washing_station->addMediaFromRequest('image')->toMediaCollection('station_cover');
        }

        if ($request->hasFile('gallery_images')) {
            foreach ($request->file('gallery_images') as $file) {
                $washing_station->addMedia($file)->toMediaCollection('station_gallery');
            }
        }

        return redirect()->route('admin.washing-stations.index')->with('success', 'Washing Station updated successfully.');
    }

    public function destroy(WashingStation $washing_station)
    {
        $washing_station->delete();
        return redirect()->route('admin.washing-stations.index')->with('success', 'Washing Station deleted successfully.');
    }
}
