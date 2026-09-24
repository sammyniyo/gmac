<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    protected $table = 'feedbacks';

    protected $guarded = [];

    protected $casts = [
        'is_approved' => 'boolean',
        'rating' => 'integer',
    ];
}
