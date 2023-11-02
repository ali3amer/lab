<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubAnalysis extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function analysis()
    {
        return $this->belongsTo(Analysis::class);
    }

    public function ranges()
    {
        return $this->hasMany(ReferenceRange::class);
    }

    public function visits()
    {
        return $this->hasMany(VisitAnalysis::class);
    }
}
