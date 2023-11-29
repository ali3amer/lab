<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RangeChoice extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function range()
    {
        return $this->belongsTo(ReferenceRange::class, "range_id");
    }

    public function choices()
    {
        return $this->hasMany(RangeChoice::class, "choice_id");
    }

    public function parent()
    {
        return $this->belongsTo(RangeChoice::class, "choice_id");
    }
}
