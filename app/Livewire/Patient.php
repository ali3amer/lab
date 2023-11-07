<?php

namespace App\Livewire;

use App\Models\ReferenceRange;
use App\Models\SubAnalysis;
use App\Models\Visit;
use App\Models\VisitAnalysis;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Patient extends Component
{
    use LivewireAlert;

    protected $listeners = [
        'delete',
    ];
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
        'years' => 'سنة',
        'months' => 'شهر',
        'weeks' => 'أسبوع',
        'days' => 'يوم',
        'hours' => 'ساعه',
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
        $this->patients = \App\Models\Patient::latest()->get();
        $this->insurances = \App\Models\Insurance::all();
        $this->firstVisitDate = date('Y-m-d');
    }

    public function getPatients()
    {
        $this->patients = \App\Models\Patient::latest()->get();
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
        $this->visits = \App\Models\Visit::where("patient_id", $id)->latest()->get();
    }

    public function search()
    {
        if ($this->searchGender == 'choose') {
            if ($this->searchDuration == 'choose') {
                $this->patients = \App\Models\Patient::where('patientName', 'LIKE', '%' . $this->searchName . '%')->
                where('phone', 'LIKE', '%' . $this->searchPhone . '%')->
                where('age', 'LIKE', '%' . $this->searchAge . '%')->latest()->get();
            } else {
                $this->patients = \App\Models\Patient::where('patientName', 'LIKE', '%' . $this->searchName . '%')->
                where('phone', 'LIKE', '%' . $this->searchPhone . '%')->
                where('age', 'LIKE', '%' . $this->searchAge . '%')->
                where('duration', '=', $this->searchDuration)->latest()->get();
            }
        } else {
            if ($this->searchDuration == 'choose') {
                $this->patients = \App\Models\Patient::where('patientName', 'LIKE', '%' . $this->searchName . '%')->
                where('phone', 'LIKE', '%' . $this->searchPhone . '%')->
                where('age', 'LIKE', '%' . $this->searchAge . '%')->
                where('gender', '=', $this->searchGender)->latest()->get();
            } else {
                $this->patients = \App\Models\Patient::where('patientName', 'LIKE', '%' . $this->searchName . '%')->
                where('phone', 'LIKE', '%' . $this->searchPhone . '%')->
                where('age', 'LIKE', '%' . $this->searchAge . '%')->
                where('gender', '=', $this->searchGender)->
                where('duration', '=', $this->searchDuration)->latest()->get();
            }
        }

    }

    public function save()
    {
        $this->validate();
        if ($this->id == 0) {
            $patient = \App\Models\Patient::create([
                'patientName' => $this->patientName,
                'gender' => $this->gender,
                'duration' => $this->duration,
                'age' => $this->age,
                'phone' => $this->phone,
                'firstVisitDate' => $this->firstVisitDate,
            ]);

            $this->choosePatient($patient->toArray());
            $this->alert('success', 'تم الحفظ بنجاح', ['timerProgressBar' => true]);

        } else {
            \App\Models\Patient::where('id', $this->id)->update([
                'patientName' => $this->patientName,
                'gender' => $this->gender,
                'duration' => $this->duration,
                'age' => $this->age,
                'phone' => $this->phone,
                'firstVisitDate' => $this->firstVisitDate,
            ]);

            $this->alert('success', 'تم التعديل بنجاح', ['timerProgressBar' => true]);
            $this->getPatients();

            $this->resetData();
        }

    }


    public function edit($patient)
    {
        $this->id = $patient['id'];
        $this->patientName = $patient['patientName'];
        $this->gender = $patient['gender'];
        $this->age = $patient['age'];
        $this->phone = $patient['phone'];
    }

    public function deletePatientMessage($id)
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
        \App\Models\Patient::where("id", $data['inputAttributes']['id'])->delete();
        $this->alert('success', 'تم الحذف بنجاح', ['timerProgressBar' => true]);

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
            $visit = \App\Models\Visit::create([
                'patient_id' => $this->currentPatient['id'],
                'insurance_id' => $this->insurance_id,
                'patientEndurance' => $this->insurance_id != null || $this->insurance_id != "" ? \App\Models\Insurance::where("id", $this->insurances)->first()->patientEndurance : 100,
                'doctor' => $this->doctor,
                'visit_date' => $this->visit_date,
                'user_id' => auth()->id(),
            ]);
            $this->chooseVisit($visit->toArray());
        } else {
            \App\Models\Visit::where('id', $this->visitId)->update([
                'insurance_id' => $this->insurance_id,
                'patientEndurance' => $this->insurance_id != null || $this->insurance_id != "" ? \App\Models\Insurance::where("id", $this->insurances)->first()->patientEndurance : 100,
                'doctor' => $this->doctor,
                'total_amount' => $this->total_amount,
                'visit_date' => $this->visit_date,
                'user_id' => auth()->id(),
            ]);

            $this->resetVisitData();
            $this->getVisits($this->currentPatient['id']);
        }

        $this->alert('success', 'تم الحفظ بنجاح', ['timerProgressBar' => true]);


    }

    public function saveVisitAnalyses()
    {
        VisitAnalysis::where("visit_id", $this->currentVisit['id'])->delete();
        Visit::where("id", $this->currentVisit['id'])->update([
            'amount' => $this->amount,
            'discount' => $this->discount,
            'total_amount' => $this->total_amount,
            'visit_date' => $this->visit_date,
        ]);
        $this->amount = 0;
        foreach ($this->visitAnalyses as $analyses) {
            foreach ($analyses as $analysis) {
                $range = ReferenceRange::where("sub_analysis_id", $analysis['id'])->first();
                if (isset($range->result_types)) {
                    if ($range->result_types == "number" || $range->result_types == "text") {
                        VisitAnalysis::create([
                            'visit_id' => $this->currentVisit['id'],
                            'sub_analysis_id' => $analysis['sub_analysis_id'],
                            'price' => $analysis['price'],
                            'result' => $analysis['result'],
                        ]);
                    } else {
                        $result = $analysis['result_choice'] == null ? array_key_first($range->result_multable_choice) : $analysis['result_choice'];
                        VisitAnalysis::create([
                            'visit_id' => $this->currentVisit['id'],
                            'sub_analysis_id' => $analysis['sub_analysis_id'],
                            'price' => $analysis['price'],
                            'result' => $analysis['result'],
                            'result_choice' => $result,
                        ]);
                    }
                } else {
                    VisitAnalysis::create([
                        'visit_id' => $this->currentVisit['id'],
                        'sub_analysis_id' => $analysis['sub_analysis_id'],
                        'price' => $analysis['price'],
                        'result' => $analysis['result'],
                    ]);
                }

            }
        }
        $this->chooseVisit($this->currentVisit);
        $this->alert('success', 'تم الحفظ بنجاح', ['timerProgressBar' => true]);

    }

    public function editVisit($visit)
    {
        $this->printResult($visit['id']);
        $this->visitId = $visit['id'];
        $this->insurance_id = $visit['insurance_id'];
        $this->visit_date = $visit['visit_date'];
        $this->doctor = $visit['doctor'];
        $this->discount = isset($visit['discount']) ? floatval($visit['discount']) : 0;
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


    public function addAllAnalysis($subAnalyses)
    {
        foreach ($subAnalyses as $analysis) {
            $analysis["result"] = null;
            $analysis["result_choice"] = null;
            $this->addSubAnalysis($analysis);
        }
    }

    public function getSubAnalyses($id)
    {
        $this->subAnalyses = SubAnalysis::where("analysis_id", $this->currentAnalysis['id'])->get();
    }

    public function addSubAnalysis($analysis)
    {
        $id = $analysis['sub_analysis_id'] ?? $analysis['id'];
        $range = ReferenceRange::where("sub_analysis_id", $id)->first();
        $result = $analysis['result'] ?? null;
        if (isset($range->result_types)) {
            if ($range->result_types == "multable_choice" || $range->result_types == "text_and_multable_choice") {
                if (isset($analysis['result_choice'])) {
                    if ($analysis['result_choice'] != null) {
                        $result_choice = $analysis['result_choice'];
                    } else {
                        $result_choice = array_key_first($range->result_multable_choice);
                    }
                } else {
                    if (isset($range->result_multable_choice["nil"])) {
                        $result_choice = $range->result_multable_choice["nil"];
                    } elseif (isset($range->result_multable_choice["yellow"])) {
                        $result_choice = $range->result_multable_choice["yellow"];
                    } elseif (isset($range->result_multable_choice["acidic"])) {
                        $result_choice = $range->result_multable_choice["acidic"];
                    } elseif (isset($range->result_multable_choice["negative"])) {
                        $result_choice = $range->result_multable_choice["negative"];
                    } else {
                        $result_choice = array_key_first($range->result_multable_choice);
                    }
                }
            } else {
                $result_choice = null;
            }
        } else {
            $result_choice = null;

        }


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
            if (isset($ranges->first()->result_types)) {
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
                    } else {
                        $currentResult["range"] = "";
                        $currentResult["N/H"] = "";
                    }
                } elseif ($ranges->count() == 0) {
                    $currentResult["range"] = "";
                    $currentResult["N/H"] = "";
                }
                else {
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
                                if ($rangeFromTo != null) {
                                    $currentResult["range"] = $rangeFromTo->range_from . " - " . $rangeFromTo->range_to;
                                    if ($currentResult['result'] > $rangeFromTo->range_to) {
                                        $currentResult["N/H"] = "H";
                                    } elseif ($currentResult['result'] < $rangeFromTo->from) {
                                        $currentResult["N/H"] = "L";
                                    } else {
                                        $currentResult["N/H"] = "N";
                                    }
                                } else {
                                    $currentResult["N/H"] = "";
                                }
                            }
                        }
                    } else {
                        $currentResult["range"] = "";
                        $currentResult["N/H"] = "";
                    }
                }
            } else {
                $currentResult["range"] = "";
                $currentResult["N/H"] = "";
            }
        }
    }

    public function deleteAnalysis($id)
    {
        $this->amount -= $this->visitAnalyses[$this->option][$id]['price'];
        unset($this->visitAnalyses[$this->option][$id]);
        $this->calcDiscount();
    }

    public function resetData()
    {
        $this->reset('id', 'patientName', 'gender', 'age', 'phone', 'currentPatient');
        $this->getPatients();
        $this->resetVisitData();
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
        $this->reset('visitId', 'option','analysesSelectArray','currentVisit', 'printVisitAnalyses', 'doctor', 'results', 'visitAnalyses', 'total_amount', 'insurance_id','amount', 'discount', 'visit_date');
        $this->resetAnalysisData();
    }

    public function render()
    {
        return view('livewire.patient');
    }
}
