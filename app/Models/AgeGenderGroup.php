<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgeGenderGroup extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function test()
    {
        return $this->belongsTo(Test::class);
    }

    public function choiceRanges()
    {
        return $this->hasMany(ChoiceRange::class);
    }

    public function textRanges()
    {
        return $this->hasMany(TextRange::class);
    }

    public function numericRanges()
    {
        return $this->hasMany(NumericRange::class);
    }
}
