<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VisitAnalysis extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function subAnalysis()
    {
        return $this->belongsTo(SubAnalysis::class);
    }
}
