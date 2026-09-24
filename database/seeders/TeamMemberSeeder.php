<?php

namespace Database\Seeders;

use App\Models\TeamMember;
use App\Support\FrontendShowcase;
use Illuminate\Database\Seeder;

class TeamMemberSeeder extends Seeder
{
    public function run(): void
    {
        $keep = [];

        foreach (FrontendShowcase::teamMembers() as $i => $row) {
            $keep[] = $row['name'];

            $member = TeamMember::updateOrCreate(
                ['name' => $row['name']],
                [
                    'role' => $row['role'],
                    'email' => $row['email'] ?? null,
                    'phone' => $row['phone'] ?? null,
                    'bio' => $row['bio'] ?? null,
                    'order' => $i + 1,
                    'is_active' => true,
                ]
            );

            $file = $row['photo_file'] ?? null;
            $path = $file ? public_path('images/'.$file) : null;

            if ($path && is_file($path) && ! $member->hasMedia('photos')) {
                $member->addMedia($path)->preservingOriginal()->toMediaCollection('photos');
            } elseif ($path && is_file($path) && str_contains(mb_strtolower($member->name), 'jeanne')) {
                $member->clearMediaCollection('photos');
                $member->addMedia($path)->preservingOriginal()->toMediaCollection('photos');
            }
        }

        TeamMember::whereNotIn('name', $keep)->update(['is_active' => false]);
    }
}
