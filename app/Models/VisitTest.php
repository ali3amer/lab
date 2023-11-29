<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VisitTest extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function parent()
    {
        return $this->belongsTo(VisitTest::class, "visit_test_id");
    }

    public function visit()
    {
        return $this->belongsTo(VisitTest::class);
    }

    public function test()
    {
        return $this->belongsTo(Test::class);
    }


    public function children()
    {
        return $this->hasMany(VisitTest::class);
    }

    public function results()
    {
        return $this->hasMany(Result::class);
    }
}
