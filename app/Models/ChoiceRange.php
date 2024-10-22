<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChoiceRange extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function children()
    {
        return $this->hasMany(ChoiceRange::class);
    }

    public function parent()
    {
        return $this->belongsTo(ChoiceRange::class, "choice_range_id");
    }

    public function ageGenderGroup()
    {
        return $this->belongsTo(AgeGenderGroup::class);
    }
}
