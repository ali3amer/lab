<?php

namespace App\Livewire;

use PDF;
use App\Models\RangeChoice;
use App\Models\ReferenceRange;
use App\Models\Visit;
use App\Models\VisitTest;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Artisan;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\WithPagination;

class Result extends Component
{
    use LivewireAlert;
    use WithPagination;

    public $header = "النتائج";
    public Collection $visitTests;
    public $results;
    public array $cart = [];
    public array $parents = [];
    public array $options = [];
    public $currentOption = null;
    public array $currentOptions = [];
    public $user;
    public array $currentVisit = [];
    public array $currentPatient = [];
    public $patientSearch = "";

    protected $rules = [
        'results.*.name' => 'required|string|min:6',
    ];
    public array $nestedChoices = [];
    public array $printResults = [];

    public function mount()
    {
        if (!auth()->check()) {
            redirect("login");
        }
    }

    public function changeOption($id)
    {
        $this->currentOptions = $this->options[$id];
    }

    public function fillOptions(VisitTest $visitTest)
    {
        if ($visitTest->children->isNotEmpty()) {
            $keys = \App\Models\VisitTest::where("visit_test_id", $visitTest['id'])->pluck("id");
            $results = \App\Models\Result::whereIn("visit_test_id", $keys)->with("test")->get()->keyBy("id")->toArray();
            $tests = \App\Models\VisitTest::where("visit_test_id", $visitTest['id'])->get();
        } else {
            $results = \App\Models\Result::where("visit_test_id", $visitTest['id'])->with("test")->get()->keyBy("id")->toArray();
            $tests = \App\Models\VisitTest::where("id", $visitTest['id'])->get();
        }
        foreach ($results as $result) {
            $this->results[$result['id']] = $result;
        }

        $this->getRanges();

        foreach ($tests as $test) {
            $this->options[$test->parent->id][$test->id] = $test->test->testName;
            $this->getVisitTestChildren($test);
        }

        $this->fillResult();

    }

    public function fillResult()
    {
        foreach ($this->cart as $index => $items) {
            $testName = \App\Models\Test::find($index)->parent->testName ?? \App\Models\Test::find($index)->testName;
            foreach ($items as $key => $item) {
                foreach ($this->results as $result) {
                    if ($result["visit_test_id"] == $key) {
                        $this->printResults[$testName][$item][$result["id"]] = $result;
                    }
                }
            }
        }

    }

    public function downloadPdf()
    {
//        $data = [
//            'name' => "علي",
//            'email' => 'ritik@test.com',
//            'phone' => '1234567890'
//        ];
//
//
//        $pdf = PDF::loadView('pdf');
//        return $pdf->stream('document.pdf');
//        return $pdf->download('pdf.pdf');

        $data = [
            'foo' => 'bar'
        ];
        $pdf = PDF::loadView('pdf');
        $pdf->autoScriptToLang = true;
        $pdf->autoArabic = true;
        $pdf->autoLangToFont = true;
        return $pdf->stream('pdf.pdf');
    }

    public function chooseVisit(Visit $visit)
    {
        $this->currentPatient = $visit->patient->toArray();
        $this->currentVisit = $visit->toArray();
        $this->visitTests = VisitTest::where('visit_id', $visit->id)->get();
        $this->results = [];
        $this->options = [];
        foreach ($this->visitTests as $visitTest) {
            $this->fillOptions($visitTest);
        }
    }

    public function setResultDefault($index)
    {
        foreach ($this->results[$index]["choices"] as $choice) {
            if ($choice["default"] && $this->results[$index]["result_choice"] == null) {
                $this->results[$index]["result_choice"] = $choice['id'];
            } elseif ($this->results[$index]["result_choice"] != null && $this->results[$index]["result_choice"] == $choice['id']) {
                $this->results[$index]["result_choice"] = $choice['id'];
            }
        }

        if ($this->results[$index]["result_choice"] == null) {
            $this->results[$index]["result_choice"] = array_key_first($this->results[$index]["choices"]);
        }

//        $this->results[$index]['result_choice'] = $this->results[$index]['choices'][0]['id'];
    }

    public function getTreeChoice($choice, $index)
    {
        $parent = $choice->parent;
        if ($parent) {
            $this->nestedChoices[$index][$parent->id] = $parent->choiceName;
            $this->getTreeChoice($parent, $index);
        }
    }

    public function getRanges()
    {
        foreach ($this->results as $key => $result) {
            $test = \App\Models\Test::find($result['test_id']);
            $ageGenderGroups = $test->ageGenderGroups;
            $result_type = $test->result_type;
            if ($ageGenderGroups) {
                if (count($ageGenderGroups) == 1) {
                    $ageGenderGroup = $ageGenderGroups->first();
                } elseif (count($ageGenderGroups) > 1) {
                    $ageGenderGroup = $ageGenderGroups->where('gender', $this->currentPatient['gender'])->where('age', $this->currentPatient['duration'])->where('min_age', '<=', $this->currentPatient['age'])->where('max_age', '>=', $this->currentPatient['age'])->first();
                }

                if ($ageGenderGroup) {
                    $this->results[$key]['age_gender_group'] = $ageGenderGroup->id;
                    $this->results[$key]['testName'] = \App\Models\Test::find($result['test_id'])->testName;
                    if ($result_type == "multiple_choice") {
                        $choices = $ageGenderGroup->choiceRanges;
//                        $this->results[$key]['result_choice'] = $ageGenderGroup->choiceRanges->where("default", true)->first()->id ?? $ageGenderGroup->choiceRanges->first()->id;
                        $this->results[$key]['choices'] = $choices->keyBy("id")->toArray();
                    } elseif ($result_type == "number") {

                        $this->results[$key]['numeric_ranges'] = $ageGenderGroup->numericRanges->first()->toArray();
                    } elseif ($result_type == "text") {
                        $this->results[$key]['text_ranges'] = $ageGenderGroup->textRanges->toArray();
                    }
                    $this->results[$key]['result_type'] = $result_type;
                }

            }
        }
    }


    public function getPrintResults()
    {
//        return $this->printResults;
        $this->fillResult();
        return $this->redirect('pdf');

    }

    public function getVisitTestChildren(VisitTest $visitTest)
    {
        $children = $visitTest->children;
        if ($children->count() > 0) {
            foreach ($children as $child) {
                if ($child->children->count() > 0) {
                    $this->getVisitTestChildren($child);
                } else {
                    $this->cart[$child->parent->test->id][$child->id] = $child->test->testName;

                    $testsResult = \App\Models\Result::where("visit_test_id", $child->id)->join("tests", "results.test_id", "=", "tests.id")->select("results.*", "tests.testName")->get()->keyBy("id");

                    foreach ($testsResult as $test) {
                        if ($test->result_type == "multiple_choice") {
                            $this->setResultDefault($test->id);
                        }

                    }

                }
            }
        } else {
            $testsResult = \App\Models\Result::where("visit_test_id", $visitTest->id)->get()->keyBy("id");

            $this->cart[$visitTest->test->id][$visitTest->id] = $visitTest->test->testName;
            foreach ($testsResult as $test) {
                if ($test->test->result_type == "multiple_choice") {
                    $this->setResultDefault($test->id);
                }

            }
        }
    }

    public function chooseChoice($index)
    {
        $choice = \App\Models\ChoiceRange::where("id", $this->results[$index]['result_choice'])->first();
        $choices = $choice->children->keyBy("id")->toArray();

        if (!empty($choices)) {
            $this->results[$index]["choices"] = $choices;
            $this->nestedChoices[$index][$choice->id] = $choice->choiceName;
        }
    }

    public function getParentChoice($index)
    {
        $parent = \App\Models\ChoiceRange::where("id", $this->results[$index]["result_choice"])->first();
        if ($parent->choice_range_id != null) {
            unset($this->nestedChoices[$index][$parent->id]);
            $this->results[$index]["result_choice"] = $parent->id;
            $this->results[$index]["choices"] = $parent->parent->choiceRanges->keyBy("id")->toArray();
        } else {
            $this->nestedChoices = [];
            $choices = \App\Models\ChoiceRange::where("id", $this->results[$index]["result_choice"])->first()->ageGenderGroup->choiceRanges->keyBy("id");
            $this->results[$index]["result_choice"] = $choices->first()->id;
            $this->results[$index]["choices"] = $choices->keyBy("id")->toArray();
        }
    }

    public function save()
    {
        foreach ($this->results as $result) {
            \App\Models\Result::where("id", $result["id"])->update([
                "result_choice" => $result["result_choice"] ?? null,
            ]);
        }

        $this->fillResult();

        $this->alert('success', 'تم الحفظ بنجاح', ['timerProgressBar' => true]);

    }

    public function printResult()
    {

    }

    public function collectFromAnotherDatabase()
    {
//        $choices = RangeChoice::where("choiceName", "LIKE", "%+%")->get()->toArray();
//        $c = [];
//        foreach ($choices as $choice) {
//            $c[$choice["id"]] = $choice["choiceName"];
//        }
//        dd($c);

        Artisan::call("migrate:fresh --seed");
        $this->alert('success', 'تم اعداد قاعدة البيانات بنجاح', ['timerProgressBar' => true]);

//        \App\Models\Category::where("id", ">", 0)->delete();
        $db2 = \DB::connection('db2');
        $categories = $db2->table('categories')->get()->keyBy("id");
        foreach ($categories as $category) {
            \App\Models\Category::create([
                'id' => $category->id,
                'categoryName' => $category->categoryName,
                'created_at' => $category->created_at,
                'updated_at' => $category->updated_at,
            ]);
        }

        $tests = $db2->table('tests')->whereNotNull("category_id")->get()->keyBy("id");

        foreach ($tests as $test) {
            $range = $db2->table('reference_ranges')->where("test_id", $test->id)->first();
            if ($range) {
                $result_type = $range->result_type == "multable_choice" ? "multiple_choice" : "number";
            } else {
                $result_type = "number";
            }
            \App\Models\Test::create([
                'id' => $test->id,
                'testName' => $test->testName,
                'result_type' => $result_type,
                'shortcut' => $test->shortcut,
                'price' => floatval($test->price),
                'unit' => $test->unit,
                'category_id' => $test->category_id,
                'test_id' => $test->test_id,
                'getAll' => $test->getAll,
                'created_at' => $test->created_at,
                'updated_at' => $test->updated_at,
            ]);
        }

        $tests = $db2->table('tests')->whereNull("category_id")->get()->keyBy("id");

        foreach ($tests as $test) {
            $range = $db2->table('reference_ranges')->where("test_id", $test->id)->first();
            if ($range) {
                $result_type = $range->result_type == "multable_choice" ? "multiple_choice" : "number";
            } else {
                $result_type = "number";
            }
            \App\Models\Test::create([
                'id' => $test->id,
                'testName' => $test->testName,
                'result_type' => $result_type,
                'shortcut' => $test->shortcut,
                'price' => floatval($test->price),
                'unit' => $test->unit,
                'category_id' => $test->category_id,
                'test_id' => $test->test_id,
                'getAll' => $test->getAll,
                'created_at' => $test->created_at,
                'updated_at' => $test->updated_at,
            ]);
        }

        $reference_ranges = $db2->table('reference_ranges')->get()->keyBy("id");

        foreach ($reference_ranges as $reference_range) {
            $ageGenderGroup = \App\Models\AgeGenderGroup::create([
                'test_id' => $reference_range->test_id,
                'gender' => $reference_range->gender,
                'age' => $reference_range->age,
                'min_age' => $reference_range->min_age,
                'max_age' => $reference_range->max_age,
            ]);

            if ($ageGenderGroup->test->result_type == "number") {
                \App\Models\NumericRange::create([
                    'age_gender_group_id' => $ageGenderGroup->id,
                    'min_value' => $reference_range->min_value,
                    'max_value' => $reference_range->max_value,
                ]);
            } elseif ($ageGenderGroup->test->result_type == "multiple_choice") {
                $choices = $db2->table('range_choices')->where("range_id", $reference_range->id)->get()->keyBy("id");

                foreach ($choices as $choice) {
                    \App\Models\ChoiceRange::create([
                        'age_gender_group_id' => $ageGenderGroup->id,
                        'choiceName' => $choice->choiceName,
                        'default' => $choice->default,
                    ]);

                    $this->addChoices($choice);
                }
            }

        }
        $this->alert('success', 'تم بحمد الله', ['timerProgressBar' => true]);


//        foreach ($categories as $category) {
//            $cat = \App\Models\Category::create([
//                "categoryName" => $category->categoryName
//            ]);
//            $analyses = $db2->table('analyses')->where("category_id", $category->id)->get()->keyBy("id");
//            foreach ($analyses as $analysis) {
//                $sub_analyses = $db2->table('sub_analyses')->where("analysis_id", $analysis->id)->get()->keyBy("id");
//                $count = $sub_analyses->count();
//                if ($count == 1) {
//                    $test = \App\Models\Test::create([
//                        "testName" => $sub_analyses->first()->subAnalysisName,
//                        "unit" => $sub_analyses->first()->unit,
//                        "price" => $sub_analyses->first()->price,
//                        "category_id" => $cat->id
//                    ]);
//
//                    $ranges = $db2->table('reference_ranges')->where("sub_analysis_id", $sub_analyses->first()->id)->get();
//
//                    foreach ($ranges as $range) {
//                        $ref = ReferenceRange::create([
//                            "test_id" => $test->id,
//                            "age" => $range->age == "years" ? "year" : $range->age,
//                            "gender" => $range->gender,
//                            "min_value" => $range->range_from,
//                            "max_value" => $range->range_to,
//                            "min_age" => $range->age_from,
//                            "max_age" => $range->age_to,
//                            "result_type" => $range->result_types,
//                        ]);
//
//                        if ($range->result_types == "multiple_choice") {
//                            foreach (json_decode($range->result_multiple_choice) as $index => $choice) {
//                                RangeChoice::create([
//                                    "range_id" => $ref->id,
//                                    "choiceName" => $choice,
//                                    "default" => in_array($choice, ["nil", "yellow", "negative", "clear", "Brown", "Normal"])
//                                ]);
//                            }
//                        }
//                    }
//
//                } else {
//                    $parentTest = \App\Models\Test::create([
//                        "testName" => $analysis->analysisName,
//                        "category_id" => $cat->id
//                    ]);
//                    foreach ($sub_analyses as $sub) {
//                        $test = \App\Models\Test::create([
//                            "testName" => $sub->subAnalysisName,
//                            "unit" => $sub->unit,
//                            "price" => $sub->price,
//                            "test_id" => $parentTest->id
//                        ]);
//
//                        $ranges = $db2->table('reference_ranges')->where("sub_analysis_id", $sub->id)->get();
//
//                        foreach ($ranges as $range) {
//                            $ref = ReferenceRange::create([
//                                "test_id" => $test->id,
//                                "age" => $range->age == "years" ? "year" : $range->age,
//                                "gender" => $range->gender,
//                                "min_value" => $range->range_from,
//                                "max_value" => $range->range_to,
//                                "min_age" => $range->age_from,
//                                "max_age" => $range->age_to,
//                                "result_type" => $range->result_types,
//                            ]);
//
//                            if ($range->result_types == "multiple_choice") {
//                                foreach (json_decode($range->result_multiple_choice) as $index => $choice) {
//                                    RangeChoice::create([
//                                        "range_id" => $ref->id,
//                                        "choiceName" => $choice,
//                                        "default" => in_array($choice, ["nil", "yellow", "negative", "clear"])
//                                    ]);
//                                }
//                            }
//                        }
//                    }
//                }
//            }
//
//        }
//
//        $urin = \App\Models\Test::create(["testName" => "URINE GENERAL", "category_id" => 3, "getAll" => true]);
//        $stool = \App\Models\Test::create(["testName" => "STOOL GENERAL", "category_id" => 3, "getAll" => true]);
//
//        \App\Models\Test::where("testName", "URINE GENERAL - Microscopy")->update([
//            "testName" => "Microscopy",
//            "category_id" => null,
//            "test_id" => $urin->id
//        ]);
//        \App\Models\Test::where("testName", "URINE GENERAL - MACRO")->update([
//            "testName" => "MACRO",
//            "category_id" => null,
//            "test_id" => $urin->id
//        ]);
//        \App\Models\Test::where("testName", "Stool Genral -MACRO")->update([
//            "testName" => "MACRO",
//            "category_id" => null,
//            "test_id" => $stool->id
//        ]);
//        \App\Models\Test::where("testName", "Stool Genral -MICRO")->update([
//            "testName" => "MICRO",
//            "category_id" => null,
//            "test_id" => $stool->id
//        ]);
//
//        \App\Models\Test::where("testName", "CBC")->update([
//            "getAll" => true
//        ]);
    }

    public function addChoices($choice)
    {
        $db2 = \DB::connection('db2');
        $newChoices = $db2->table('range_choices')->where("choice_id", $choice->id)->get()->keyBy("id");
        if ($newChoices->count() > 0) {
            foreach ($newChoices as $ch) {
                \App\Models\ChoiceRange::create([
                    'choice_range_id' => $choice['id'],
                    'choiceName' => $ch->choiceName,
                    'default' => $ch->default,
                ]);
                $this->addChoices($ch);
            }
        }
    }

    public function resetData()
    {
        $this->reset("results", "cart", "currentVisit", "currentPatient", "patientSearch");
    }

    public function render()
    {
//        $this->collectFromAnotherDatabase();
        $this->user = auth()->user();

        return view('livewire.result', [
            "visits" => Visit::join("patients", "patients.id", "=", "visits.patient_id")->where("patients.patientName", "LIKE", "%" . $this->patientSearch . "%")->select("visits.*", "patients.patientName")->latest()->paginate(10)
        ]);
    }
}
