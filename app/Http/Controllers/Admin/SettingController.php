<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Setting;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::all()->pluck('value', 'key');
        return view('admin.settings.index', compact('settings'));
    }

    public function store(Request $request)
    {
        $inputs = $request->except(['_token', '_method']);

        foreach ($inputs as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => is_array($value) ? json_encode($value) : $value]
            );
        }

        // Handle specific media/files if uploaded, e.g. logo
        if ($request->hasFile('site_logo')) {
            $setting = Setting::firstOrCreate(['key' => 'site_logo']);
            $setting->clearMediaCollection('logo');
            $setting->addMediaFromRequest('site_logo')->toMediaCollection('logo');
            $setting->update(['value' => $setting->getFirstMediaUrl('logo')]);
        }

        return redirect()->route('admin.settings.index')->with('success', 'Settings updated successfully.');
    }
}
