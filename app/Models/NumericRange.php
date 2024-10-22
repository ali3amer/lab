<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NumericRange extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function ageGenderGroup()
    {
        return $this->belongsTo(AgeGenderGroup::class);
    }
}
