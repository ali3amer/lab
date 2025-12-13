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
    public $setting;

    public function mount()
    {
        if (!auth()->check()) {
            redirect("login");
        }

        $this->setting = \App\Models\Setting::first();
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
            $test = \App\Models\Test::find($result['test_id']);
            $this->results[$result['id']]['testName'] = $test['testName'];
            $this->results[$result['id']]['result_type'] = $test['result_type'];
        }

        $this->getRanges();

        foreach ($tests as $test) {
            $this->options[$test->parent->id ?? $test->id][$test->id] = $test->test->testName;
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

        session([
            'printResults' => $this->printResults,
            'currentVisit' => $this->currentVisit,
            'currentPatient' => $this->currentPatient,
        ]);
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
        ini_set('max_execution_time', '300');
        ini_set("pcre.backtrack_limit", "5000000");

        $pdf = PDF::loadView('pdf', ['currentVisit' => session('currentVisit'), 'currentPatient' => session('currentPatient'), 'printResults' => session('printResults')]);
        $pdf->autoScriptToLang = true;
        $pdf->autoArabic = true;
        $pdf->autoLangToFont = true;
        return $pdf->stream('pdf.pdf');
//        return response($pdf->output(), 200, [
//            'Content-Type' => 'application/pdf',
//            'Content-Disposition' => 'attachment; filename="pdf.pdf"',
//        ]);
    }

    public function chooseVisit($id)
    {
        $visit = Visit::find($id);
        $this->currentPatient = $visit->patient->toArray();
        $this->currentVisit = $visit->toArray();
        $this->currentVisit['insuranceName'] = $visit->insurance->insuranceName ?? null;
        $this->currentVisit['amount'] = $visit->amount * ($visit->patientEndurance / 100);
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
                } else {
                    $this->results[$key]['choices'] = [];
                    $this->results[$key]['numeric_ranges'] = ['min_value' => 0, 'max_value' => 0];
                    $this->results[$key]['text_ranges'] = [];
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
        Visit::where('id', $this->currentVisit['id'])->update([
            'discount' => floatval($this->currentVisit['discount']),
        ]);


        foreach ($this->results as $result) {
            \App\Models\Result::where("id", $result["id"])->update([
                "result_choice" => $result["result_choice"] ?? null,
                "result" => $result["result"] ?? null,
            ]);
        }

        $this->fillResult();

        $this->chooseVisit($this->currentVisit['id']);


        $this->alert('success', 'تم الحفظ بنجاح', ['timerProgressBar' => true]);

    }

    public function printResult()
    {

    }

    public function resetData()
    {
        $this->reset("results", "cart", "currentVisit", "currentPatient", "patientSearch");
    }

    public function render()
    {
        $this->user = auth()->user();

        return view('livewire.result', [
            "visits" => Visit::join("patients", "patients.id", "=", "visits.patient_id")->where("patients.patientName", "LIKE", "%" . $this->patientSearch . "%")->select("visits.*", "patients.patientName")->latest()->paginate(10)
        ]);
    }
}
