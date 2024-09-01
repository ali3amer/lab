<?php

namespace App\Livewire;

use App\Models\RangeChoice;
use App\Models\ReferenceRange;
use App\Models\Visit;
use App\Models\VisitTest;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Artisan;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Result extends Component
{
    use LivewireAlert;

    public $header = "النتائج";
    public Collection $visits;
    public array $results = [];
    public Collection $visitTests;
    public array $cart = [];
    public $option = "";
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
        if(!auth()->check()) {
            redirect("login");
        }
        $this->visits = Visit::latest()->get();
    }

    public function search()
    {
        $this->visits = Visit::join("patients", "patients.id", "=", "visits.patient_id")->where("patients.patientName", "LIKE", "%" . $this->patientSearch . "%")->select("visits.*", "patients.patientName")->latest()->get();
    }

    public function changeOption($visit)
    {
        $this->option = "";
        $this->option = $visit["testName"];
    }

    public function chooseVisit(Visit $visit)
    {
        $this->currentPatient = $visit->patient->toArray();
        $this->currentVisit = $visit->toArray();
        $this->visitTests = $visit->visitTests;
        foreach ($this->visitTests as $visitTest) {
            $this->chooseVisitTest($visitTest);
        }

        foreach ($this->cart as $index => $items) {
            foreach ($items as $key => $item) {
                foreach ($this->results as $result) {
                    if ($result["visit_test_id"] == $key) {
                        $this->printResults[$index][$item][$result["id"]] = $result;
                    }
                }
            }
        }

    }

    public function chooseVisitTest(VisitTest $visitTest)
    {
//        $this->save();
//        $this->cart = [];
        $this->getVisitTestChildren($visitTest);

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

    public function getRanges($test)
    {
        if ($test->test->ranges->count() == 1) {
            $range = $test->test->ranges->first();
            if ($range->result_type != "number") {
                if ($test->result_choice == null) {
                    $test->choices = $range->choices->keyBy("id")->toArray();
                } else {
                    $choice = RangeChoice::where("id", $test->result_choice)->first();
                    if ($choice->parent) {
                        $test->choices = $choice->parent->choices->keyBy("id")->toArray();
                        $this->getTreeChoice($choice, $test->id);
                    } else {
                        $test->choices = $range->choices->keyBy("id")->toArray();
                    }
                }

                $test->result_type = "multable_choice";
            } else {
                $test->min_value = $range->min_value;
                $test->max_value = $range->max_value;
                $test->result_type = "number";
            }
        } elseif ($test->test->ranges->count() > 1) {

            $ranges = $test->test->ranges;

            $result_type = $test->test->ranges->first()->result_type;

            $full = $ranges->where("gender", $this->currentPatient['gender'])->where("age", $this->currentPatient['duration'])->where("min_age", "<=", $this->currentPatient['age'])->where("max_age", ">=", $this->currentPatient['age'])->first();

            if ($result_type != "number") {
                if ($full) {
                    if ($test->result_choice == null) {
                        $test->choices = $full->choices->keyBy("id")->toArray();
                    } else {
                        $choice = RangeChoice::where("id", $test->result_choice)->first();
                        if ($choice->parent) {
                            $test->choices = $choice->parent->choices->keyBy("id")->toArray();
                            $this->getTreeChoice($choice, $test->id);
                        } else {
                            $test->choices = $full->choices->keyBy("id")->toArray();
                        }
                    }

                    $test->result_type = "multable_choice";

                } elseif($ranges->where("gender", "all")->where("age", "all")->first()) {
                    $all = $ranges->where("gender", "all")->where("age", "all")->first();
                    if ($test->result_choice == null) {
                        $test->choices = $all->choices->keyBy("id")->toArray();
                    } else {
                        $choice = RangeChoice::where("id", $test->result_choice)->first();
                        if ($choice->parent) {
                            $test->choices = $choice->parent->choices->keyBy("id")->toArray();
                            $this->getTreeChoice($choice, $test->id);
                        } else {
                            $test->choices = $all->choices->keyBy("id")->toArray();
                        }
                    }
                    $test->result_type = "multable_choice";

                } elseif ($ranges->where("gender", "all")->where("age", $this->currentPatient['duration'])->where("min_age", "<=", $this->currentPatient['age'])->where("max_age", ">=", $this->currentPatient['age'])->first()) {
                    $age = $ranges->where("gender", "all")->where("age", $this->currentPatient['duration'])->where("min_age", "<=", $this->currentPatient['age'])->where("max_age", ">=", $this->currentPatient['age'])->first();
                    if ($test->result_choice == null) {
                        $test->choices = $age->choices->keyBy("id")->toArray();
                    } else {
                        $choice = RangeChoice::where("id", $test->result_choice)->first();
                        if ($choice->parent) {
                            $test->choices = $choice->parent->choices->keyBy("id")->toArray();
                            $this->getTreeChoice($choice, $test->id);
                        } else {
                            $test->choices = $age->choices->keyBy("id")->toArray();
                        }
                    }
                    $test->result_type = "multable_choice";
                } elseif ($ranges->where("gender", $this->currentPatient['gender'])->where("age", "all")->first()) {
                    $gender = $ranges->where("gender", $this->currentPatient['gender'])->where("age", $this->currentPatient['duration'])->first();
                    if ($test->result_choice == null) {
                        $test->choices = $gender->choices->keyBy("id")->toArray();
                    } else {
                        $choice = RangeChoice::where("id", $test->result_choice)->first();
                        if ($choice->parent) {
                            $test->choices = $choice->parent->choices->keyBy("id")->toArray();
                            $this->getTreeChoice($choice, $test->id);
                        } else {
                            $test->choices = $gender->choices->keyBy("id")->toArray();
                        }
                    }
                    $test->result_type = "multable_choice";
                } else {
                    $test->result_type = "text";
                }
            } else {
                if ($full) {
                    $test->min_value = $full->min_value;
                    $test->max_value = $full->max_value;
                    $test->result_type = "number";

                } elseif ($ranges->where("gender", "all")->where("age", "all")->first()) {
                    $all = $ranges->where("gender", "all")->where("age", "all")->first();
                    $test->min_value = $all->min_value;
                    $test->max_value = $all->max_value;
                    $test->result_type = "number";

                } elseif ($ranges->where("gender", $this->currentPatient['gender'])->where("age", "all")->first()) {
                    $gender = $ranges->where("gender", $this->currentPatient['gender'])->where("age", "all")->first();
                    $test->min_value = $gender->min_value;
                    $test->max_value = $gender->max_value;
                    $test->result_type = "number";

                } elseif ($ranges->where("gender", "all")->where("age", $this->currentPatient['duration'])->where("min_age", "<=", $this->currentPatient['age'])->where("max_age", ">=", $this->currentPatient['age'])->first()) {
                    $age = $ranges->where("gender", "all")->where("age", $this->currentPatient["duration"])->where("min_age", "<=", $this->currentPatient['age'])->where("max_age", ">=", $this->currentPatient['age'])->first();
                    $test->min_value = $age->min_value;
                    $test->max_value = $age->max_value;
                    $test->result_type = "number";

                } else {
                    $test->result_type = "text";
                }


            }


//            foreach ($test->test->ranges as $range) {
//
//                if ($range->result_type != "number") {
//                    if ($range->gender == $this->currentPatient["gender"] && $range->age == $this->currentPatient["duration"] && $range->min_age <= $this->currentPatient["age"] && $range->age >= $this->currentPatient["age"]) {
//
//                        $choice = RangeChoice::where("id", $test->result_choice)->first();
//                        if ($choice->parent) {
//                            $test->choices = $choice->parent->choices->keyBy("id")->toArray();
//                            $this->getTreeChoice($choice, $test->id);
//                        } else {
//                            $test->choices = $range->choices->keyBy("id")->toArray();
//                        }
//                    } elseif ($range->age == $this->currentPatient["duration"] && $range->min_age <= $this->currentPatient["age"] && $range->age >= $this->currentPatient["age"]) {
//
//                        $choice = RangeChoice::where("id", $test->result_choice)->first();
//                        if ($choice->parent) {
//                            $test->choices = $choice->parent->choices->keyBy("id")->toArray();
//                            $this->getTreeChoice($choice, $test->id);
//                        } else {
//                            $test->choices = $range->choices->keyBy("id")->toArray();
//                        }
//
//                    } elseif ($range->gender == $this->currentPatient["gender"]) {
//                        $choice = RangeChoice::where("id", $test->result_choice)->first();
//                        if ($choice->parent) {
//                            $test->choices = $choice->parent->choices->keyBy("id")->toArray();
//                            $this->getTreeChoice($choice, $test->id);
//                        } else {
//                            $test->choices = $range->choices->keyBy("id")->toArray();
//                        }
//                    } else {
//                        $choice = RangeChoice::where("id", $test->result_choice)->first();
//                        if ($choice->parent) {
//                            $test->choices = $choice->parent->choices->keyBy("id")->toArray();
//                            $this->getTreeChoice($choice, $test->id);
//                        } else {
//                            $test->choices = $range->choices->keyBy("id")->toArray();
//                        }
//                    }
//
//                    $test->result_type = "multable_choice";
//                } else {
//
//                    if ($range->gender == $this->currentPatient["gender"] && $range->age == $this->currentPatient["duration"] && $range->min_age <= $this->currentPatient["age"] && $range->age >= $this->currentPatient["age"]) {
//
//                        $test->min_value = $range->min_value;
//                        $test->max_value = $range->max_value;
//                    } elseif ($range->age == $this->currentPatient["duration"] && $range->min_age <= $this->currentPatient["age"] && $range->age >= $this->currentPatient["age"]) {
//
//                        $test->min_value = $range->min_value;
//                        $test->max_value = $range->max_value;
//
//                    } elseif ($range->gender == $this->currentPatient["gender"]) {
//                        $test->min_value = $range->min_value;
//                        $test->max_value = $range->max_value;
//                    } else {
//                        $test->min_value = $range->min_value;
//                        $test->max_value = $range->max_value;
//                    }
//
//                    $test->result_type = "number";
//
//                }
//            }
        } else {
            $test->result_type = "text";
        }

    }

    public function getVisitTestChildren(VisitTest $visitTest)
    {
        $children = $visitTest->children;
        if ($children->count() > 0) {
            foreach ($children as $child) {
                if ($child->children->count() > 0) {
                    $this->getVisitTestChildren($child);
                } else {
                    $this->cart[$child->parent->test->testName][$child->id] = $child->test->testName;

                    $testsResult = \App\Models\Result::where("visit_test_id", $child->id)->join("tests", "results.test_id", "=", "tests.id")->select("results.*", "tests.testName")->get()->keyBy("id");

                    foreach ($testsResult as $test) {
                        $this->getRanges($test);
                        $this->results[$test->id] = $test->toArray();
                        if ($test->result_type == "multable_choice") {
                            $this->setResultDefault($test->id);
                        }

                    }

                }
            }
        } else {
            $testsResult = \App\Models\Result::where("visit_test_id", $visitTest->id)->join("tests", "results.test_id", "=", "tests.id")->select("results.*", "tests.testName")->get()->keyBy("id");

            $this->cart[$visitTest->test->testName][$visitTest->id] = $visitTest->test->testName;

            foreach ($testsResult as $test) {
                $this->getRanges($test);
                $this->results[$test->id] = $test->toArray();
                if ($test->result_type == "multable_choice") {
                    $this->setResultDefault($test->id);
                }

            }
        }
    }

    public function chooseChoice($index)
    {
        $choice = RangeChoice::where("id", $this->results[$index]['result_choice'])->first();
        $choices = $choice->choices->keyBy("id")->toArray();

        if (!empty($choices)) {
            $this->results[$index]["choices"] = $choices;
            $this->nestedChoices[$index][$choice->id] = $choice->choiceName;
        }
    }

    public function getParentChoice($index)
    {
        $parent = RangeChoice::where("id", $this->results[$index]["result_choice"])->first()->parent;
        if ($parent->choice_id != null) {
            unset($this->nestedChoices[$index][$parent->id]);
            $this->results[$index]["result_choice"] = $parent->id;
            $this->results[$index]["choices"] = $parent->parent->choices->keyBy("id")->toArray();
        } else {
            $this->nestedChoices = [];
            $choices = RangeChoice::where("id", $this->results[$index]["result_choice"])->first()->parent->range->choices->keyBy("id")->toArray();
            $this->results[$index]["result_choice"] = $choices->first()->id;
            $this->results[$index]["choices"] = $choices->keyBy("id")->toArray();
        }
    }

    public function save($massage = false)
    {
        foreach ($this->results as $result) {
            \App\Models\Result::where("id", $result["id"])->update([
                "result" => $result["result"],
                "result_choice" => $result["result_choice"],
            ]);
        }

        foreach ($this->cart as $index => $items) {
            foreach ($items as $key => $item) {
                foreach ($this->results as $result) {
                    if ($result["visit_test_id"] == $key) {
                        $this->printResults[$index][$item][$result["id"]] = $result;
                    }
                }
            }
        }

        if ($massage) {
            $this->alert('success', 'تم الحفظ بنجاح', ['timerProgressBar' => true]);
        }

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
//        \App\Models\Category::where("id", ">", 0)->delete();
        $db2 = \DB::connection('db2');
        $categories = $db2->table('categories')->get()->keyBy("id");
        foreach ($categories as $category) {
            $cat = \App\Models\Category::create([
                "categoryName" => $category->categoryName
            ]);
            $analyses = $db2->table('analyses')->where("category_id", $category->id)->get()->keyBy("id");
            foreach ($analyses as $analysis) {
                $sub_analyses = $db2->table('sub_analyses')->where("analysis_id", $analysis->id)->get()->keyBy("id");
                $count = $sub_analyses->count();
                if ($count == 1) {
                    $test = \App\Models\Test::create([
                        "testName" => $sub_analyses->first()->subAnalysisName,
                        "unit" => $sub_analyses->first()->unit,
                        "price" => $sub_analyses->first()->price,
                        "category_id" => $cat->id
                    ]);

                    $ranges = $db2->table('reference_ranges')->where("sub_analysis_id", $sub_analyses->first()->id)->get();

                    foreach ($ranges as $range) {
                        $ref = ReferenceRange::create([
                            "test_id" => $test->id,
                            "age" => $range->age == "years" ? "year" : $range->age,
                            "gender" => $range->gender,
                            "min_value" => $range->range_from,
                            "max_value" => $range->range_to,
                            "min_age" => $range->age_from,
                            "max_age" => $range->age_to,
                            "result_type" => $range->result_types,
                        ]);

                        if ($range->result_types == "multable_choice") {
                            foreach (json_decode($range->result_multable_choice) as $index => $choice) {
                                RangeChoice::create([
                                    "range_id" => $ref->id,
                                    "choiceName" => $choice,
                                    "default" => in_array($choice, ["nil", "yellow", "negative", "clear", "Brown", "Normal"])
                                ]);
                            }
                        }
                    }

                } else {
                    $parentTest = \App\Models\Test::create([
                        "testName" => $analysis->analysisName,
                        "category_id" => $cat->id
                    ]);
                    foreach ($sub_analyses as $sub) {
                        $test = \App\Models\Test::create([
                            "testName" => $sub->subAnalysisName,
                            "unit" => $sub->unit,
                            "price" => $sub->price,
                            "test_id" => $parentTest->id
                        ]);

                        $ranges = $db2->table('reference_ranges')->where("sub_analysis_id", $sub->id)->get();

                        foreach ($ranges as $range) {
                            $ref = ReferenceRange::create([
                                "test_id" => $test->id,
                                "age" => $range->age == "years" ? "year" : $range->age,
                                "gender" => $range->gender,
                                "min_value" => $range->range_from,
                                "max_value" => $range->range_to,
                                "min_age" => $range->age_from,
                                "max_age" => $range->age_to,
                                "result_type" => $range->result_types,
                            ]);

                            if ($range->result_types == "multable_choice") {
                                foreach (json_decode($range->result_multable_choice) as $index => $choice) {
                                    RangeChoice::create([
                                        "range_id" => $ref->id,
                                        "choiceName" => $choice,
                                        "default" => in_array($choice, ["nil", "yellow", "negative", "clear"])
                                    ]);
                                }
                            }
                        }
                    }
                }
            }

        }

        $urin = \App\Models\Test::create(["testName" => "URINE GENERAL", "category_id" => 3, "getAll" => true]);
        $stool = \App\Models\Test::create(["testName" => "STOOL GENERAL", "category_id" => 3, "getAll" => true]);

        \App\Models\Test::where("testName", "URINE GENERAL - Microscopy")->update([
            "testName" => "Microscopy",
            "category_id" => null,
            "test_id" => $urin->id
        ]);
        \App\Models\Test::where("testName", "URINE GENERAL - MACRO")->update([
            "testName" => "MACRO",
            "category_id" => null,
            "test_id" => $urin->id
        ]);
        \App\Models\Test::where("testName", "Stool Genral -MACRO")->update([
            "testName" => "MACRO",
            "category_id" => null,
            "test_id" => $stool->id
        ]);
        \App\Models\Test::where("testName", "Stool Genral -MICRO")->update([
            "testName" => "MICRO",
            "category_id" => null,
            "test_id" => $stool->id
        ]);

        \App\Models\Test::where("testName", "CBC")->update([
            "getAll" => true
        ]);
    }

    public function resetData()
    {
        $this->reset("results", "cart", "option", "currentVisit", "currentPatient", "patientSearch");
    }

    public function render()
    {
//        $this->collectFromAnotherDatabase();
        $this->user = auth()->user();

        return view('livewire.result');
    }
}
