<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function children()
    {
        return $this->hasMany(Test::class);
    }

    public function parent()
    {
        return $this->belongsTo(Test::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }



//    public static function tree($id)
//    {
//        $allTests = Test::get();
//        $rootTests = $allTests->whereNull("test_id");
//
//        Self::formatTree($rootTests, $allTests);
//
//        return $rootTests;
//    }
//
//    private static function formatTree($tests, $allTests)
//    {
//        foreach ($tests as $test) {
//            $test->children = $allTests->where("test_id", $test->id);
//
//            if ($test->children->isNotEmpty()) {
//                Self::formatTree($test->children, $allTests);
//            }
//        }
//    }
}
