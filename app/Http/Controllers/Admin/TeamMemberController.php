<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TeamMember;
use Illuminate\Http\Request;

class TeamMemberController extends Controller
{
    public function index()
    {
        $members = TeamMember::orderBy('order')->latest()->paginate(10);

        return view('admin.team-members.index', compact('members'));
    }

    public function create()
    {
        return view('admin.team-members.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'role' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:255',
            'bio' => 'nullable|string',
            'order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
            'photo' => 'nullable|image|max:4096',
        ]);

        $member = TeamMember::create([
            'name' => $validated['name'],
            'role' => $validated['role'],
            'email' => $validated['email'] ?? null,
            'phone' => $validated['phone'] ?? null,
            'bio' => $validated['bio'] ?? null,
            'order' => $validated['order'] ?? 0,
            'is_active' => $request->boolean('is_active'),
        ]);

        if ($request->hasFile('photo')) {
            $member->addMediaFromRequest('photo')->toMediaCollection('photos');
        }

        return redirect()->route('admin.team-members.index')->with('success', 'Team member created successfully.');
    }

    public function edit(TeamMember $team_member)
    {
        return view('admin.team-members.edit', ['member' => $team_member]);
    }

    public function update(Request $request, TeamMember $team_member)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'role' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:255',
            'bio' => 'nullable|string',
            'order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
            'photo' => 'nullable|image|max:4096',
        ]);

        $team_member->update([
            'name' => $validated['name'],
            'role' => $validated['role'],
            'email' => $validated['email'] ?? null,
            'phone' => $validated['phone'] ?? null,
            'bio' => $validated['bio'] ?? null,
            'order' => $validated['order'] ?? 0,
            'is_active' => $request->boolean('is_active'),
        ]);

        if ($request->hasFile('photo')) {
            $team_member->clearMediaCollection('photos');
            $team_member->addMediaFromRequest('photo')->toMediaCollection('photos');
        }

        return redirect()->route('admin.team-members.index')->with('success', 'Team member updated successfully.');
    }

    public function destroy(TeamMember $team_member)
    {
        $team_member->delete();

        return redirect()->route('admin.team-members.index')->with('success', 'Team member deleted successfully.');
    }
}
