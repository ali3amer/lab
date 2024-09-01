<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Insurance extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function insuranceDebts()
    {
        return $this->hasMany(InsuranceDebt::class);
    }

    public function visits()
    {
        return $this->hasMany(Visit::class);
    }

    public function getBalanceAttribute()
    {
        return $this->visits->sum(function ($visit) {
            return $visit->total_amount * ((100 - $visit->patientEndurance) / 100);
        }) - $this->insuranceDebts->sum("amount");
    }
}
