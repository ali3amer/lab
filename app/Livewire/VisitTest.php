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
        if ($test->getAll) {
            \App\Models\VisitTest::where('visit_id', $this->visit_id)->where('test_id', $test->id)->delete();
            $this->visitTest($test);
            $this->addChildrenTests($test, $this->visit_test_id);
        } else {
            if ($test->children->isNotEmpty()) {
                $this->chooseTest($test->id);
            } else {
                $this->visitTest($test, $this->visit_test_id);
                $this->result($test);
            }
        }
    }

    public function addChildrenTests(\App\Models\Test $test, $visit_test_id)
    {
        if ($test->children->isNotEmpty()) {
            foreach ($test->children as $childTest) {
                if ($childTest->children->isNotEmpty()) {
                    $this->visitTest($childTest, $visit_test_id);
                    $this->addChildrenTests($childTest, $visit_test_id);
                } else {
                    $this->result($childTest);
                }
            }
        } else {
            $this->result($test);
        }
    }

    public function visitTest($test, $visit_test_id = null)
    {
        $visit_test = \App\Models\VisitTest::create([
            'visit_id' => $visit_test_id == null ? $this->visit_id : null,
            'visit_test_id' => $visit_test_id,
            'test_id' => $test->id,
            'price' => $test->price,
        ]);
        $this->visit_test_id = $visit_test->id;
    }

    public function result($test)
    {
        Result::create([
            'visit_test_id' => $this->visit_test_id,
            'test_id' => $test['id'],
            'price' => $test['price']
        ]);
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

    public function deleteMessage($id)
    {
        $this->confirm("  هل توافق على الحذف ؟  ", [
            'inputAttributes' => ["id" => $id],
            'toast' => false,
            'showConfirmButton' => true,
            'confirmButtonText' => 'موافق',
            'onConfirmed' => "delete",
            'showCancelButton' => true,
            'cancelButtonText' => 'إلغاء',
            'confirmButtonColor' => '#dc2626',
            'cancelButtonColor' => '#4b5563'
        ]);
    }

    public function delete($data)
    {
        \App\Models\VisitTest::where('id', $data['inputAttributes']['id'])->delete();
        $this->alert('success', 'تم الحذف بنجاح', ['timerProgressBar' => true]);
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
