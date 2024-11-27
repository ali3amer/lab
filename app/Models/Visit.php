<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visit extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function visitTests()
    {
        return $this->hasMany(VisitTest::class);
    }

    public function insurance()
    {
        return $this->belongsTo(Insurance::class);
    }

    public function visitAnalyses()
    {
        return $this->hasMany(VisitAnalysis::class);
    }

    public function results()
    {
        return $this->hasMany(Result::class);
    }

    protected function calcAmount()
    {
        return $this->visitTests()
            ->with('children.children', 'results')
            ->get()
            ->sum(function($visitTest) {
                return $this->calculateRecursiveAmount($visitTest);
            });
    }

// دالة تكرارية لجمع السعر من الأبناء المتداخلين
    protected function calculateRecursiveAmount($visitTest)
    {
        // نبدأ بجمع السعر الحالي
        $total = $visitTest->price;

        // التحقق من وجود أبناء من نفس النوع ونضيف أسعارهم
        if ($visitTest->children) {
            foreach ($visitTest->children as $child) {
                $total += $this->calculateRecursiveAmount($child); // استدعاء تكراري للأبناء
            }
        }

        // إضافة الأسعار من Result إذا لم يكن هناك أبناء من نفس النوع
        if ($visitTest->results && !$visitTest->children->isNotEmpty()) {
            $total += $visitTest->results->sum('price');
        }

        return $total;
    }


//    public function getAmountAttribute()
//    {
//        return $this->calcAmount() - $this->discount;
//    }

}
