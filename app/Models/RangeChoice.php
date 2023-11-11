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
        return $this->belongsTo(ReferenceRange::class);
    }
}
