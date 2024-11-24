<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function test()
    {
        return $this->belongsTo(Test::class);
    }



    public function visit()
    {
        return $this->belongsTo(Visit::class);
    }
}
