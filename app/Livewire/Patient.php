<?php

namespace App\Livewire;

use App\Models\ReferenceRange;
use App\Models\SubAnalysis;
use App\Models\Visit;
use App\Models\VisitAnalysis;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Rule;
use Livewire\Component;

class Patient extends Component
{
    public $header = "المرضى";
    public $id = 0;
    public $visitId = 0;
    public $searchAnalysis = "";
    public $searchSubAnalysis = "";
    public $searchName = "";
    public $searchAge = "";
    public $searchPhone = "";
    public $searchGender = "choose";
    public $searchDuration = "choose";
    public $searchCategory = "";

    #[Rule('required', message: 'أدخل إسم المريض')]
    public $patientName = "";
    public $duration = "years";
    public $gender = "male";
    public $insurance_id = null;
    public $visit_date = "";
    public $doctor = "";
    public $option = "";
    public $age = 0;
    public $phone = 0;
    public Collection $categories;
    public Collection $patients;
    public Collection $visits;
    public Collection $insurances;
    public array $durations = [
        'years' => 'سنوات',
        'months' => 'اشهر',
        'weeks' => 'اسابيع',
        'days' => 'ايام',
        'hours' => 'ساعات',
    ];
    public $firstVisitDate = '';
    public array $currentPatient = [];
    public array $currentVisit = [];
    public array $visitAnalyses = [];
    public Collection $subAnalyses;
    public Collection $analyses;
    public array $currentCategory = [];
    public array $currentAnalysis = [];
    public array $analysesSelectArray = [];
    public $discount = 0;
    public $amount = 0;
    public $total_amount = 0;
    public Collection $printVisitAnalyses;
    public array $results = [];

    public function mount()
    {
        $this->categories = \App\Models\Category::all();
        $this->patients = \App\Models\Patient::all();
        $this->insurances = \App\Models\Insurance::all();
        $this->firstVisitDate = date('Y-m-d');
    }

    public function getPatients()
    {
        $this->patients = \App\Models\Patient::all();
    }

    public function searchCategories()
    {
        $this->categories = \App\Models\Category::where('categoryName', 'LIKE', '%' . $this->searchCategory . '%')->get();
    }

    public function searchAnalyses()
    {
        $this->analyses = \App\Models\Analysis::where('analysisName', 'LIKE', '%' . $this->searchAnalysis . '%')->get();
    }

    public function searchSubAnalyses()
    {
        $this->subAnalyses = SubAnalysis::where("analysis_id", $this->currentAnalysis['id'])->where('subAnalysisName', 'LIKE', '%' . $this->searchSubAnalysis . '%')->get();
    }

    public function getVisits($id)
    {
        $this->visits = \App\Models\Visit::where("patient_id", $id)->get();
    }

    public function search()
    {
        if ($this->searchGender == 'choose') {
            if ($this->searchDuration == 'choose') {
                $this->patients = \App\Models\Patient::where('patientName', 'LIKE', '%' . $this->searchName . '%')->
                where('phone', 'LIKE', '%' . $this->searchPhone . '%')->
                where('age', 'LIKE', '%' . $this->searchAge . '%')->get();
            } else {
                $this->patients = \App\Models\Patient::where('patientName', 'LIKE', '%' . $this->searchName . '%')->
                where('phone', 'LIKE', '%' . $this->searchPhone . '%')->
                where('age', 'LIKE', '%' . $this->searchAge . '%')->
                where('duration', '=', $this->searchDuration)->get();
            }
        } else {
            if ($this->searchDuration == 'choose') {
                $this->patients = \App\Models\Patient::where('patientName', 'LIKE', '%' . $this->searchName . '%')->
                where('phone', 'LIKE', '%' . $this->searchPhone . '%')->
                where('age', 'LIKE', '%' . $this->searchAge . '%')->
                where('gender', '=', $this->searchGender)->get();
            } else {
                $this->patients = \App\Models\Patient::where('patientName', 'LIKE', '%' . $this->searchName . '%')->
                where('phone', 'LIKE', '%' . $this->searchPhone . '%')->
                where('age', 'LIKE', '%' . $this->searchAge . '%')->
                where('gender', '=', $this->searchGender)->
                where('duration', '=', $this->searchDuration)->get();
            }
        }

    }

    public function save()
    {
        $this->validate();
        if ($this->id == 0) {
            \App\Models\Patient::create([
                'patientName' => $this->patientName,
                'gender' => $this->gender,
                'duration' => $this->duration,
                'age' => $this->age,
                'phone' => $this->phone,
                'firstVisitDate' => $this->firstVisitDate,
            ]);
        } else {
            \App\Models\Patient::where('id', $this->id)->update([
                'patientName' => $this->patientName,
                'gender' => $this->gender,
                'duration' => $this->duration,
                'age' => $this->age,
                'phone' => $this->phone,
                'firstVisitDate' => $this->firstVisitDate,
            ]);
        }

        $this->getPatients();

        $this->resetData();
    }


    public function edit($patient)
    {
        $this->id = $patient['id'];
        $this->patientName = $patient['patientName'];
        $this->gender = $patient['gender'];
        $this->age = $patient['age'];
        $this->phone = $patient['phone'];
    }

    public function delete($id)
    {
        \App\Models\Patient::where("id", $id)->delete();
        $this->getPatients();
    }

    public function choosePatient($patient)
    {
        $this->currentPatient = $patient;
        $this->edit($patient);
        $this->getVisits($patient['id']);
    }

    public function chooseCategory($category)
    {
        $this->currentCategory = $category;
        $this->analyses = \App\Models\Analysis::where('category_id', $category["id"])->get();
    }

    public function chooseAnalysis($analysis)
    {
        $this->currentAnalysis = $analysis;
        $this->analysesSelectArray[$analysis["id"]] = $analysis["analysisName"];
        $this->getSubAnalyses($analysis["id"]);
        $this->option = $analysis['id'];
        if (empty($this->visitAnalyses[$this->option])) {
            $this->visitAnalyses[$this->option] = [];
        }
    }

    public function saveVisit()
    {
        if ($this->visitId == 0) {
            \App\Models\Visit::create([
                'patient_id' => $this->currentPatient['id'],
                'insurance_id' => $this->insurance_id,
                'patientEndurance' => $this->insurance_id != null ? \App\Models\Insurance::where("id", $this->insurances)->first()->patientEndurance : 100,
                'doctor' => $this->doctor,
                'visit_date' => $this->visit_date,
            ]);
        } else {
            \App\Models\Visit::where('id', $this->visitId)->update([
                'insurance_id' => $this->insurances,
                'patientEndurance' => $this->insurance_id != null ? \App\Models\Insurance::where("id", $this->insurances)->first()->patientEndurance : 100,
                'doctor' => $this->doctor,
                'visit_date' => $this->visit_date,
            ]);
        }

        $this->resetVisitData();
        $this->getVisits($this->currentPatient['id']);

    }

    public function saveVisitAnalyses()
    {
        VisitAnalysis::where("visit_id", $this->currentVisit['id'])->delete();
        foreach ($this->visitAnalyses as $analyses) {
            foreach ($analyses as $analysis) {
                dd($analysis);
                $range = ReferenceRange::where("sub_analysis_id", $analysis['id'])->first();
                if ($range->result_types == "number" || $range->result_types == "text") {
                    if ($analysis['result'] != null) {
                        VisitAnalysis::create([
                            'visit_id' => $this->currentVisit['id'],
                            'sub_analysis_id' => $analysis['sub_analysis_id'],
                            'price' => $analysis['price'],
                            'result' => $analysis['result'],
                        ]);
                    }
                } else {
                    if ($analysis['result_choice'] != null) {
                        VisitAnalysis::create([
                            'visit_id' => $this->currentVisit['id'],
                            'sub_analysis_id' => $analysis['sub_analysis_id'],
                            'price' => $analysis['price'],
                            'result' => $analysis['result'],
                            'result_choice' => $analysis['result_choice'],
                        ]);
                    }
                }

            }
        }
        $this->chooseVisit($this->currentVisit);
    }

    public function editVisit($visit)
    {
        $this->printResult($visit['id']);
        $this->visitId = $visit['id'];
        $this->insurance_id = $visit['insurance_id'];
        $this->visit_date = $visit['visit_date'];
        $this->doctor = $visit['doctor'];
        $this->discount = floatval($visit['discount']);
        $this->amount = floatval($visit['amount']);
        $this->total_amount = floatval($visit['total_amount']);
    }

    public function chooseVisit($visit)
    {
        $this->currentVisit = $visit;
        $this->editVisit($visit);
        $visitAnalysis = VisitAnalysis::where("visit_id", $visit['id'])->get();
        $this->visitAnalyses = [];
        foreach ($visitAnalysis as $analysis) {
            $this->option = $analysis->subAnalysis->analysis_id;
            $analysis->subAnalysis->toArray()["result"] = $analysis->result;
            $analysis->subAnalysis->toArray()["result_choice"] = $analysis->result_choice;
            $this->addSubAnalysis($analysis);
//            $this->visitAnalyses[$analysis->subAnalysis->analysis->id][$analysis->sub_analysis_id] = $analysis->toArray();
//            $this->visitAnalyses[$analysis->subAnalysis->analysis->id][$analysis->sub_analysis_id]["subAnalysisName"] = $analysis->subAnalysis->subAnalysisName;
            $this->analysesSelectArray[$analysis->subAnalysis->analysis->id] = $analysis->subAnalysis->analysis->analysisName;
        }
    }

    public function getSubAnalyses($id)
    {
        $this->subAnalyses = SubAnalysis::where("analysis_id", $this->currentAnalysis['id'])->get();
    }

    public function addSubAnalysis($analysis)
    {
        $result = $analysis->result ?? null;
        $result_choice = $analysis->result_choice ?? null;
        if (!is_array($analysis)) {
            $analysis = $analysis->subAnalysis->toArray();
        }
        $this->visitAnalyses[$analysis['analysis_id']][$analysis['id']] = $analysis;
        $this->visitAnalyses[$analysis['analysis_id']][$analysis['id']]["sub_analysis_id"] = $analysis["id"];
        $this->visitAnalyses[$analysis['analysis_id']][$analysis['id']]['result'] = $result;
        $this->visitAnalyses[$analysis['analysis_id']][$analysis['id']]['result_choice'] = $result_choice;
        $this->amount += $analysis["price"];
        $this->calcDiscount();
    }

    public function calcDiscount()
    {
        $this->total_amount = $this->amount - floatval($this->discount);
    }


    public function printResult($id)
    {
        $this->results = [];
        $this->printVisitAnalyses = VisitAnalysis::where("visit_id", $id)->get();
        foreach ($this->printVisitAnalyses as $printVisitAnalysis) {
            $ranges = $printVisitAnalysis->subAnalysis->ranges;
            $this->results[$printVisitAnalysis->subAnalysis->analysis->category->categoryName][$printVisitAnalysis->subAnalysis->analysis->analysisName][$printVisitAnalysis->id] = $printVisitAnalysis;
            $currentResult = $this->results[$printVisitAnalysis->subAnalysis->analysis->category->categoryName][$printVisitAnalysis->subAnalysis->analysis->analysisName][$printVisitAnalysis->id];
            if ($ranges->count() == 1) {
                $range = $ranges->first();
                if ($range->result_types == "number") {
                    $currentResult["range"] = $range->range_from . " - " . $range->range_to;
                    if ($currentResult->result > $range->range_to) {
                        $currentResult["N/H"] = "H";
                    } elseif ($currentResult->result < $range->range_from) {
                        $currentResult["N/H"] = "L";
                    } else {
                        $currentResult["N/H"] = "N";
                    }
                } elseif ($range->result_types == "text") {
                    $currentResult["range"] = "";
                    $currentResult["N/H"] = "";
                } elseif ($range->result_types == "multable_choice" || $range->result_types == "text_and_multable_choice") {
                    $currentResult["range"] = $range->result_multable_choice;
                    $currentResult["N/H"] = "";
                }
            } else {
                $range = $ranges->first();

                if ($range->result_types == "number") {
                    if ($range->gender == "all") {
                        if ($range->age_from == null) {
                            $rangeFromTo = $ranges->where("age", $this->currentPatient["duration"])->first();
                            $currentResult["range"] = $rangeFromTo->range_from . " - " . $rangeFromTo->range_to;
                            if ($currentResult->result > $rangeFromTo->range_to) {
                                $currentResult["N/H"] = "H";
                            } elseif ($currentResult->result < $rangeFromTo->from) {
                                $currentResult["N/H"] = "L";
                            } else {
                                $currentResult["N/H"] = "N";
                            }
                        } else {
                            $rangeFromTo = $ranges->where("age", $this->currentPatient["duration"])->where("age_from", "<=", $this->currentPatient["age"])->where("age_to", ">=", $this->currentPatient["age"])->first();
                            $currentResult["range"] = $rangeFromTo->range_from . " - " . $rangeFromTo->range_to;
                            if ($currentResult['result'] > $rangeFromTo->range_to) {
                                $currentResult["N/H"] = "H";
                            } elseif ($currentResult['result'] < $rangeFromTo->from) {
                                $currentResult["N/H"] = "L";
                            } else {
                                $currentResult["N/H"] = "N";
                            }
                        }
                    } else {
                        if ($range->age_from == null) {
                            $rangeFromTo = $ranges->where("age", $this->currentPatient["duration"])->where("gender", $this->currentPatient["gender"])->first();
                            $currentResult["range"] = $rangeFromTo->range_from . " - " . $rangeFromTo->range_to;
                            if ($currentResult['result'] > $rangeFromTo->range_to) {
                                $currentResult["N/H"] = "H";
                            } elseif ($currentResult['result'] < $rangeFromTo->from) {
                                $currentResult["N/H"] = "L";
                            } else {
                                $currentResult["N/H"] = "N";
                            }
                        } else {
                            $rangeFromTo = $ranges->where("age", $this->currentPatient["duration"])->where("gender", $this->currentPatient["gender"])->where("age_from", "<=", $this->currentPatient["age"])->where("age_to", ">=", $this->currentPatient["age"])->first();
                            $currentResult["range"] = $rangeFromTo->range_from . " - " . $rangeFromTo->range_to;
                            if ($currentResult['result'] > $rangeFromTo->range_to) {
                                $currentResult["N/H"] = "H";
                            } elseif ($currentResult['result'] < $rangeFromTo->from) {
                                $currentResult["N/H"] = "L";
                            } else {
                                $currentResult["N/H"] = "N";
                            }
                        }
                    }
                } elseif ($range->result_types == "text" || $range->result_types == "multable_choice") {
                    $currentResult["range"] = "";
                    $currentResult["N/H"] = "";
                }
            }

        }
    }

    public function deleteAnalysis($id)
    {
        unset($this->visitAnalyses[$this->option][$id]);
        $this->calcDiscount();
    }

    public function resetData()
    {
        $this->reset('id', 'patientName', 'gender', 'age', 'phone', 'currentPatient');
    }

    public function resetAnalysisData()
    {
        $this->reset('currentAnalysis');
    }

    public function resetCategoryData()
    {
        $this->reset('currentCategory');
    }

    public function resetVisitData()
    {
        $this->reset('visitId', 'currentVisit', 'printVisitAnalyses', 'doctor', 'results', 'visitAnalyses', 'insurance_id', 'visit_date');
    }

    public function render()
    {
        return view('livewire.patient');
    }
}
