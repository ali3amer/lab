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

    public function choiceRange()
    {
        return $this->hasMany(ChoiceRange::class);
    }

    public function textRange()
    {
        return $this->hasOne(TextRange::class);
    }

    public function numericRange()
    {
        return $this->hasOne(NumericRange::class);
    }
}
