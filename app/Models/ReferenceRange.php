<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReferenceRange extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $casts = [
        'result_multable_choice' => 'array',
    ];
}
