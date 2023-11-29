<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReferenceRange extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $casts = [
        'result_multable_choice' => 'array',
    ];

    public function test()
    {
        return $this->belongsTo(Test::class);
    }

    public function choices()
    {
        return $this->hasMany(RangeChoice::class, "range_id");
    }

    public function tree($id)
    {
      $allChoices = RangeChoice::where("test_id", $id)->get();
      dd($allChoices);
    }
}
