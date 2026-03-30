<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\GalleryItem;

class GalleryItemController extends Controller
{
    public function index()
    {
        $galleryItems = GalleryItem::latest('order')->paginate(20);
        return view('admin.gallery.index', compact('galleryItems'));
    }

    public function create()
    {
        return view('admin.gallery.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'nullable|string|max:255',
            'order' => 'nullable|integer',
            'is_active' => 'boolean',
            'image' => 'required|image|max:4096',
        ]);

        $validated['is_active'] = $request->has('is_active');
        $validated['order'] = $validated['order'] ?? 0;

        $galleryItem = GalleryItem::create(\Illuminate\Support\Arr::except($validated, ['image']));

        if ($request->hasFile('image')) {
            $galleryItem->addMediaFromRequest('image')->toMediaCollection('gallery');
        }

        return redirect()->route('admin.gallery.index')->with('success', 'Image added to gallery successfully.');
    }

    public function edit(GalleryItem $gallery)
    {
        return view('admin.gallery.edit', compact('gallery'));
    }

    public function update(Request $request, GalleryItem $gallery)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'nullable|string|max:255',
            'order' => 'nullable|integer',
            'is_active' => 'boolean',
            'image' => 'nullable|image|max:4096',
        ]);

        $validated['is_active'] = $request->has('is_active');
        $validated['order'] = $validated['order'] ?? 0;

        $gallery->update(\Illuminate\Support\Arr::except($validated, ['image']));

        if ($request->hasFile('image')) {
            $gallery->clearMediaCollection('gallery');
            $gallery->addMediaFromRequest('image')->toMediaCollection('gallery');
        }

        return redirect()->route('admin.gallery.index')->with('success', 'Gallery item updated successfully.');
    }

    public function destroy(GalleryItem $gallery)
    {
        $gallery->delete();
        return redirect()->route('admin.gallery.index')->with('success', 'Gallery item deleted successfully.');
    }
}
