<?php

namespace App\Models;

use App\Models\Concerns\HasSafeMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;

class TeamMember extends Model implements HasMedia
{
    use HasSafeMedia;

    protected $guarded = [];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public static function makeInitials(?string $name): string
    {
        $parts = preg_split('/\s+/u', trim((string) $name)) ?: [];
        $letters = [];

        foreach ($parts as $part) {
            if ($part === '') {
                continue;
            }

            $letters[] = mb_strtoupper(mb_substr($part, 0, 1));

            if (count($letters) === 2) {
                break;
            }
        }

        return implode('', $letters) ?: '?';
    }

    public function avatarInitials(): string
    {
        return self::makeInitials($this->name);
    }

    public function portraitUrl(): string
    {
        return $this->getFirstMediaUrl('photos');
    }
}
