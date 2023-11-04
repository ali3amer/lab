<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InsuranceDebt extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function insurance() {
        return $this->belongsTo(Insurance::class);
}
}
