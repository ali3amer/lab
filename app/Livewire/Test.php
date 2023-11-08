<?php

namespace App\Livewire;

use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Test extends Component
{
    use LivewireAlert;

    protected $listeners = [
        'deleteTest',
    ];

    public $header = "التحاليل";

    public $categoryName = "";
    public $testName = "";
    public $shortcut = "";
    public $category_id = null;
    public $test_id = null;
    public $unit = null;
    public $price;
    public $id = 0;
    public array $currentCategory = [];
    public array $currentTest = [];

    public array $currentLocation = [];
    public Collection $categories;
    public Collection $tests;

    public function mount()
    {
        $this->categories = \App\Models\Category::all();
    }

    public function searchCategory()
    {
        $this->categories = \App\Models\Category::where("categoryName", "LIKE", '%' . $this->categoryName . '%')->get();
    }

    public function chooseCategory($category)
    {
        $this->currentCategory = $category;
        $this->currentLocation[0] = $this->currentCategory['categoryName'];
        $this->getTests();
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

    public function getTests()
    {
        $this->tests = \App\Models\Test::where("category_id", $this->currentCategory['id'])->whereNull("test_id")->get();
    }

    public function saveTest()
    {
        if ($this->id == 0) {
            \App\Models\Test::create([
                "testName" => $this->testName,
                "shortcut" => $this->shortcut,
                "category_id" => empty($this->currentTest) ? $this->currentCategory['id'] : null,
                "test_id" => empty($this->currentTest) ? null : $this->currentTest['id'],
                "unit" => $this->unit
            ]);

            $this->alert('success', 'تم الحفظ بنجاح', ['timerProgressBar' => true]);

        } else {
            \App\Models\Test::where("id", $this->id)->create([
                "testName" => $this->testName,
                "shortcut" => $this->shortcut,
                "price" => $this->price,
                "category_id" => empty($this->currentTest) ? $this->currentCategory['id'] : null,
                "test_id" => empty($this->currentTest) ? null : $this->currentTest['id'],
                "unit" => $this->unit
            ]);

            $this->alert('success', 'تم التعديل بنجاح', ['timerProgressBar' => true]);

        }

        if (empty($this->currentTest)) {
            $this->getTests();
        } else {
            $this->chooseTest($this->currentTest['id']);
        }
        $this->resetTestData();
    }

    public function editTest($test) {
        $this->id = $test['id'];
        $this->testName = $test['testName'];
        $this->shortcut = $test['shortcut'];
        $this->unit = $test['unit'];
    }

    public function deleteTestMassage($id)
    {
        $this->confirm("  هل توافق على الحذف ؟  ", [
            'inputAttributes' => ["id" => $id],
            'toast' => false,
            'showConfirmButton' => true,
            'confirmButtonText' => 'موافق',
            'onConfirmed' => "deleteTest",
            'showCancelButton' => true,
            'cancelButtonText' => 'إلغاء',
            'confirmButtonColor' => '#dc2626',
            'cancelButtonColor' => '#4b5563'
        ]);
    }

    public function deleteTest($data)
    {
        \App\Models\Test::where("id", $data['inputAttributes']['id'])->delete();
        $this->alert('success', 'تم الحذف بنجاح', ['timerProgressBar' => true]);

    }
    public function resetTestData()
    {
        $this->reset("id", "testName", "shortcut", "price", "unit");
    }


    public function render()
    {
        return view('livewire.test');
    }
}
