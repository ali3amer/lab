<?php

namespace App\Livewire;

use App\Models\Result;
use Illuminate\Database\Eloquent\Collection;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class VisitTest extends Component
{
    use LivewireAlert;
    use WithPagination;

    protected $listeners = [
        'delete',
    ];
    public $visit_id;
    public $user;
    public Collection $categories;
    public Collection $tests;
    public array $currentLocation = [];
    public array $cart = [];
    public $visit_test_id = 0;
    public $amount = 0;
    public $total_amount = 0;
    public $discount = 0;

    public array $currentCategory = [];
    public array $currentTest = [];

    public function mount()
    {
        $this->categories = \App\Models\Category::all();
        $this->changeLocation(-1);
        $this->cart = [];
        $this->loadDataFromDatabase();
    }

    public function chooseCategory($category)
    {
        $this->currentCategory = $category;
        $this->currentLocation[0] = $this->currentCategory['categoryName'];
        $this->getTests();
    }

    public function getTests()
    {
        if (empty($this->currentCategory)) {
            $this->tests = \App\Models\Test::where("category_id", $this->currentTest['id'])->get();
        } else {
            $this->tests = \App\Models\Test::where("category_id", $this->currentCategory['id'])->get();
        }
    }

    public function addTest(\App\Models\Test $test)
    {
        $check = \App\Models\VisitTest::where("visit_id", $this->visit_id)->where("test_id", $test['id'])->first();

        if ($check != null) {
            if ($check->children->count() == 0 && $check->results->count() == 0) {
                $check->delete();
                $check = null;
            }
        }
        if ($check == null) {
            if ($test->getAll) {
                $testModel = \App\Models\Test::find($test['id']);
                $this->amount += floatval($testModel->price);

                if ($testModel) {

                    \App\Models\VisitTest::where("visit_id", $this->visit_id)->where("test_id", $testModel->id)->delete();
                    $visit_test = \App\Models\VisitTest::create([
                        "visit_id" => $this->visit_id,
                        "test_id" => $testModel->id,
                        "price" => floatval($testModel->price),
                    ]);

                    foreach ($this->cart as $key => $item) {
                        if ($item['testName'] === $test['testName']) {
                            unset($this->cart[$key]);
                            $this->cart = array_values($this->cart); // إعادة ترتيب المفاتيح بعد الحذف
                            break;
                        }
                    }
                    $this->cart[$testModel['id']]['testName'] = $testModel['testName'];
                    $this->cart[$testModel['id']]['price'] = $testModel['price'];
                    $this->getChildrenTree($testModel, $visit_test['id']);
                }
            } else {
                if ($test->children->count() > 0) {
                    if ($test->parent) {
                        \App\Models\VisitTest::where("visit_test_id", $this->visit_test_id)->where("test_id", $test->id)->delete();

                        $visit_test = \App\Models\VisitTest::create([
                            "visit_test_id" => $this->visit_test_id,
                            "test_id" => $test->id,
                            "price" => floatval($test->price),
                        ]);

                        $this->visit_test_id = $visit_test->id;
                        $this->amount += floatval($test->price);

                    } else {
                        $check = \App\Models\VisitTest::where("visit_id", $this->visit_id)->where("test_id", $test->id)->first();
                        if ($check) {
                            $this->visit_test_id = $check->id;
                        } else {
                            $visit_test = \App\Models\VisitTest::create([
                                "visit_id" => $this->visit_id,
                                "test_id" => $test->id,
                                "price" => floatval($test->price),
                            ]);
                            $this->visit_test_id = $visit_test->id;
                        }

                        $this->amount += floatval($test->price);

                    }
                    $this->chooseTest($test->id);
                } else {

                    if ($this->visit_test_id == 0) {

                        \App\Models\VisitTest::where("visit_id", $this->visit_id)->where("test_id", $test->id)->delete();
                        $visit_test = \App\Models\VisitTest::create([
                            "visit_id" => $this->visit_id,
                            "test_id" => $test->id,
                            "price" => floatval($test->price),
                        ]);
                        $result = Result::create([
                            "visit_test_id" => $visit_test->id,
                            "test_id" => $test->id,
                            "price" => floatval($test->price),
                        ]);
                    } else {

                        $result = Result::create([
                            "visit_test_id" => $this->visit_test_id,
                            "test_id" => $test->id,
                            "price" => floatval($test->price),
                        ]);

                    }

                    foreach ($this->cart as $key => $item) {
                        if ($item['testName'] === $test['testName']) {
                            unset($this->cart[$key]);
                            $this->cart = array_values($this->cart); // إعادة ترتيب المفاتيح بعد الحذف
                            break;
                        }
                    }

                    $this->cart[$result->id]['testName'] = $test['testName'];
                    $this->cart[$result->id]['price'] = $test['price'];


                    $this->amount += floatval($test->price);

                }
            }

            \App\Models\Visit::where("id", $this->visit_id)->update([
                "discount" => $this->discount,
            ]);
        }
        $this->visit_test_id = 0;
    }

    protected function getChildrenTree($test, $id)
    {
        $children = $test->children;

        if ($children->count() > 0) {
            $tree = [];

            foreach ($children as $child) {
                if ($child->children->count() > 0) {
                    $visit_test = \App\Models\VisitTest::create([
                        "visit_test_id" => $id,
                        "test_id" => $child->id,
                        "price" => floatval($child->price),
                    ]);
                    $this->amount += floatval($child->price);

                    $childTree = $this->getChildrenTree($child, $visit_test['id']);
                    $tree[$child->id] = $child->toArray();
                } else {
                    Result::create([
                        "visit_test_id" => $id,
                        "test_id" => $child->id,
                        "price" => floatval($child->price),
                    ]);
                    $this->amount += floatval($child->price);

                }
            }

            return $tree;
        } else {

            Result::create([
                "visit_test_id" => $id,
                "test_id" => $test->id,
                "price" => floatval($test->price),
            ]);
            $this->amount += floatval($test->price);


        }

        return [];
    }

    public function chooseTest($id)
    {
        if ($id == 0) {
            $this->getTests();
        } else {
            $this->currentTest = \App\Models\Test::where("id", $id)->first()->toArray();

            $this->currentLocation[$id] = $this->currentTest['testName'];
            $this->tests = \App\Models\Test::where("test_id", $this->currentTest['id'])->get();
        }
    }

    public function changeLocation($index)
    {

        if ($index == -1) {
            $this->currentCategory = [];
            $this->currentLocation = [];
            $this->currentTest = [];
        } else {

            $this->chooseTest($index);

            $newArray = [];
            foreach ($this->currentLocation as $key => $location) {
                $newArray[$key] = $location;
                if ($index == $key) {
                    break;
                }
            }

            $this->currentLocation = $newArray;

        }

    }


    public function loadDataFromDatabase()
    {
        $visitTests = \App\Models\VisitTest::where('visit_id', $this->visit_id)->get();

        foreach ($visitTests as $visitTest) {
            $test = $visitTest->test;

            if ($test->getAll) {
                foreach ($this->cart as $key => $item) {
                    if ($item['testName'] === $test['testName']) {
                        unset($this->cart[$key]);
                        $this->cart = array_values($this->cart); // إعادة ترتيب المفاتيح بعد الحذف
                        break;
                    }
                }
                $this->cart[$test['id']]['testName'] = $test['testName'];
                $this->cart[$test['id']]['price'] = $test['price'];
            } else {
                $this->loadChildrenFromDatabase($visitTest);
            }
        }
    }

    protected function loadChildrenFromDatabase($visitTest)
    {
        $children = $visitTest->children;
        if ($children->count() > 0) {
            foreach ($children as $child) {
                $this->loadChildrenFromDatabase($child);
            }
        } else {
            foreach ($visitTest->results as $result) {
                $this->cart[$result->id]['testName'] = $result->test->testName;
                $this->cart[$result->id]['price'] = $result->test->price;
            }

        }
    }

    public function decreseAmount($visitTest)
    {
        $amount = 0;
        $children = $visitTest->children;
        foreach ($children as $child) {
            $amount += floatval($child->price);
            if ($child->children->count() > 0) {
                $this->decreseAmount($child);
            } else {
                $amount += $child->results->sum("price");
            }
        }
        return $amount;
    }

    public function deleteFromCart($id)
    {
        // البحث عن الاختبار بناءً على test_id والزيارة الحالية
        $visitTest = \App\Models\VisitTest::where("test_id", $id)->where("visit_id", $this->visit_id)->first();

        if ($visitTest) {
            // تقليل المبلغ بالسعر الخاص بالاختبار الحالي
            $this->amount -= floatval($visitTest->price);

            // إذا كان للاختبار أبناء، نحسب المجموع الخاص بالأبناء ونزيله من المبلغ
            if ($visitTest->children->count() > 0) {
                $this->amount -= $this->decreaseAmountForChildren($visitTest);
            } else {
                // إذا لم يكن له أبناء، نقوم بتقليل المبلغ بناءً على النتائج المرتبطة به
                $this->amount -= $visitTest->results->sum("price");
            }

            // حذف الاختبار
            $visitTest->delete();
        } else {
            // إذا كان العنصر هو نتيجة، نبحث عن النتيجة ونقوم بحذفها
            $result = Result::find($id);
            if ($result) {
                $this->amount -= floatval($result->price);

                // إذا كانت النتيجة هي الأخيرة المرتبطة بالاختبار، نحذف الاختبار أيضًا
                if ($result->visitTest->results->where("id", "!=", $id)->count() > 0) {
                    $result->delete();
                } else {
                    $result->visitTest->delete();
                }
            }
        }

        unset($this->cart[$id]);
        $this->changeLocation(-1);

    }

// دالة لحساب مجموع أسعار جميع الأبناء
    protected function decreaseAmountForChildren($visitTest)
    {
        $total = 0;

        foreach ($visitTest->children as $child) {
            $total += floatval($child->price);
            if ($child->children->count() > 0) {
                $total += $this->decreaseAmountForChildren($child);
            } else {
                $total += $child->results->sum("price");
            }
        }

        return $total;
    }

    public function render()
    {
        $this->user = auth()->user();
        if (!auth()->check()) {
            redirect("login");
        }
        return view('livewire.visit-test', [
            "visitTests" => \App\Models\VisitTest::where("visit_id", $this->visit_id)->get(),
        ]);
    }
}
