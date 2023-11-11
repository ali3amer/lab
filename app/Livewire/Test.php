<?php

namespace App\Livewire;

use App\Models\RangeChoice;
use App\Models\ReferenceRange;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Test extends Component
{
    use LivewireAlert;

    protected $listeners = [
        'deleteTest',
        'deleteRange',
    ];

    public $range_id = null;
    public $choiceName = null;
    public $choice_id = null;
    public $choice = "";
    public Collection $choices;
    public $currentChoice = [];
    public array $genders = [
        "all" => "الكل",
        "male" => "ذكر",
        "female" => "أنثى",
    ];

    public array $ages = [
        "all" => "الكل",
        "year" => "سنة",
        "month" => "شهر",
        "week" => "اسبوع",
        "day" => "يوم",
        "hour" => "ساعة",
    ];

    public $gender = "all";
    public $age = "all";

    public array $types = [
        "number" => "رقمي",
        "multable_choice" => "خيارات",
        "text_and_multable_choice" => "نص وخيارات",
    ];

    public $result_type = "number";

    public $min_value = null;
    public $max_value = null;
    public $min_age = null;
    public $max_age = null;
    public array $modals = ["rangeModal" => false];

    public $header = "التحاليل";

    public $categoryName = "";
    public $testName = "";
    public $shortcut = "";
    public $rangeMode = false;
    public $choicesMode = false;
    public bool $default = false;
    public $category_id = null;
    public $test_id = null;
    public $unit = null;
    public $price;
    public $id = 0;
    public $refId = 0;
    public $rangeId = 0;
    public array $currentCategory = [];
    public array $currentTest = [];
    public array $rangeTest = [];

    public array $currentLocation = [];
    public Collection $categories;
    public Collection $tests;
    public Collection $ranges;
    public $nestedChoices = [];

    public function mount()
    {
        $this->categories = \App\Models\Category::all();
    }

    public function showModal($modalName)
    {
        $this->modals[$modalName] = true;
    }

    public function closeModal($modalName)
    {
        $this->modals[$modalName] = false;
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
                "price" => floatval($this->price),
                "unit" => $this->unit,
            ]);

            $this->alert('success', 'تم الحفظ بنجاح', ['timerProgressBar' => true]);

        } else {
            \App\Models\Test::where("id", $this->id)->update([
                "testName" => $this->testName,
                "shortcut" => $this->shortcut,
                "price" => floatval($this->price),
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

    public function editTest($test, $range = false)
    {
        $this->test_id = $test['id'];
        $this->rangeMode = $range;
        if ($this->rangeMode) {
            $this->getRanges($test['id']);
        }
        $this->id = $range ? $test['id'] : 0;
        $this->testName = $test['testName'];
        $this->shortcut = $test['shortcut'];
        $this->unit = $test['unit'];
        $this->price = $test['price'];
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

    public function getRanges($id)
    {
        $this->ranges = ReferenceRange::where("test_id", $id)->get();
    }

    public function saveRange()
    {
        if ($this->range_id == 0) {
            $range = ReferenceRange::create([
                "test_id" => $this->test_id,
                "gender" => $this->gender,
                "age" => $this->age,
                "result_type" => $this->result_type,
                "min_age" => $this->min_age,
                "max_age" => $this->max_age,
                "min_value" => $this->min_value,
                "max_value" => $this->max_value,
            ]);

            if ($this->result_type == "multable_choice" || $this->result_type == "text_and_multable_choice") {

                $this->range_id = $range->id;
                $this->getChoices(true);
            }

            $this->alert('success', 'تم الحفظ بنجاح', ['timerProgressBar' => true]);

        } else {
            ReferenceRange::where("id", $this->range_id)->update([
                "gender" => $this->gender,
                "age" => $this->age,
                "result_type" => $this->result_type,
                "min_age" => $this->min_age,
                "max_age" => $this->max_age,
                "min_value" => $this->min_value,
                "max_value" => $this->max_value,
            ]);

            if ($this->result_type == "multable_choice" || $this->result_type == "text_and_multable_choice") {
                $this->choicesMode = true;
            }

            $this->alert('success', 'تم التعديل بنجاح', ['timerProgressBar' => true]);
        }
        $this->getRanges($this->test_id);
        if ($this->result_type == "number") {
            $this->resetRangeData();
        }
    }

    public function editRange($range)
    {
        $this->currentChoice = [];
        $this->choicesMode = true;
        $this->test_id = $range['test_id'];
        $this->range_id = $range['id'];
        $this->gender = $range['gender'];
        $this->age = $range['age'];
        $this->result_type = $range['result_type'];
        $this->min_age = $range['min_age'];
        $this->max_age = $range['max_age'];
        $this->min_value = $range['min_value'];
        $this->max_value = $range['max_value'];
        $this->getChoices(true);
    }

    public function deleteMassageRange($id)
    {
        $this->confirm("  هل توافق على الحذف ؟  ", [
            'inputAttributes' => ["id" => $id],
            'toast' => false,
            'showConfirmButton' => true,
            'confirmButtonText' => 'موافق',
            'onConfirmed' => "deleteRange",
            'showCancelButton' => true,
            'cancelButtonText' => 'إلغاء',
            'confirmButtonColor' => '#dc2626',
            'cancelButtonColor' => '#4b5563'
        ]);
    }

    public function deleteRange($data)
    {
        RangeChoice::where("range_id", $data['inputAttributes']['id'])->delete();
        \App\Models\ReferenceRange::where("id", $data['inputAttributes']['id'])->delete();
        $this->getRanges($this->test_id);
        $this->alert('success', 'تم الحذف بنجاح', ['timerProgressBar' => true]);
    }

    public function addChoice()
    {
        RangeChoice::create([
            "range_id" => empty($this->currentChoice) ? $this->range_id : null,
            "choiceName" => $this->choiceName,
            "default" => $this->default,
            "choice_id" => !empty($this->currentChoice) ? $this->currentChoice['id'] : null
        ]);
        $this->choiceName = "";
        $this->default = false;
        $this->getChoices(true);
    }

    public function deleteChoice($id)
    {
        RangeChoice::where("choice_id", $id)->delete();
        RangeChoice::where("id", $id)->delete();
        $this->getChoices(true);
    }

    public function getChoices($mode = false)
    {
        $this->choicesMode = $mode;
        if (empty($this->currentChoice)) {
            $this->choices = RangeChoice::where("range_id", $this->range_id)->get();
        } else {
            $this->choices = RangeChoice::where("choice_id", $this->currentChoice['id'])->get();
        }
    }
    public function chooseChoice($choice)
    {
        $this->currentChoice = $choice;
        $this->getChoices(true);
    }

    public function resetRangeData()
    {
        $this->reset( "gender", "age", "result_type", "min_age", "max_age", "min_value", "max_value", "refId");
    }

    public function resetTestData()
    {
        $this->reset("id", "testName", "shortcut", "price", "unit", "rangeMode", "test_id");
    }

    public function resetChoicesData()
    {
        if (!empty($this->currentChoice)) {
            if ($this->currentChoice['choice_id'] != null) {
                $this->currentChoice = RangeChoice::where("id", $this->currentChoice['choice_id'])->first()->toArray();
            } else {
                $this->currentChoice = [];
            }
            $this->getChoices(true);
        } else {
            $this->reset( "range_id", "choicesMode", "choiceName");
            $this->resetRangeData();
        }
    }

    public function render()
    {
        return view('livewire.test');
    }
}
