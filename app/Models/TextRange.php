<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TextRange extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function ageGenderGroup()
    {
        return $this->belongsTo(AgeGenderGroup::class);
    }
}
