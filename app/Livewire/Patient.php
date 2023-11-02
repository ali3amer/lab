<?php

namespace App\Livewire;

use App\Models\SubAnalysis;
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
                'insurance_id' => null,
                'doctor' => $this->doctor,
                'visit_date' => $this->visit_date,
            ]);
        } else {
            \App\Models\Visit::where('id', $this->visitId)->update([
                'insurance_id' => null,
                'doctor' => $this->doctor,
                'visit_date' => $this->visit_date,
            ]);
        }

        $this->resetVisitData();
        $this->getVisits($this->currentPatient['id']);

    }

    public function saveVisitAnalyses()
    {
        foreach ($this->visitAnalyses as $analyses) {
            foreach ($analyses as $analysis) {
                VisitAnalysis::create([
                    'visit_id' => $this->currentVisit['id'],
                    'sub_analysis_id' => $analysis['sub_analysis_id'],
                    'price' => $analysis['price'],
                    'result' => $analysis['result'],
                ]);
            }
        }
    }

    public function editVisit($visit)
    {
        $this->visitId = $visit['id'];
        $this->insurance_id = $visit['insurance_id'];
        $this->visit_date = $visit['visit_date'];
        $this->doctor = $visit['doctor'];
    }

    public function chooseVisit($visit)
    {
        $this->currentVisit = $visit;
        $this->editVisit($visit);
        $visitAnalysis = VisitAnalysis::where("visit_id", $visit['id'])->get();
        $this->visitAnalyses = [];
        foreach ($visitAnalysis as $analysis) {
            $this->visitAnalyses[$analysis->subAnalysis->analysis->id][$analysis->sub_analysis_id] = $analysis->toArray();
            $this->visitAnalyses[$analysis->subAnalysis->analysis->id][$analysis->sub_analysis_id]["subAnalysisName"] = $analysis->subAnalysis->subAnalysisName;
            $this->analysesSelectArray[$analysis->subAnalysis->analysis->id] = $analysis->subAnalysis->analysis->category->categoryName;
            $this->option = $analysis->subAnalysis->analysis->id;
        }
    }

    public function getSubAnalyses($id)
    {
        $this->subAnalyses = SubAnalysis::where("analysis_id", $this->currentAnalysis['id'])->get();
    }

    public function addSubAnalysis($analysis)
    {
        $this->visitAnalyses[$analysis['analysis_id']][$analysis['id']] = $analysis;
        $this->visitAnalyses[$analysis['analysis_id']][$analysis['id']]["sub_analysis_id"] = $analysis["id"];
        $this->visitAnalyses[$analysis['analysis_id']][$analysis['id']]['result'] = null;
    }

    public function deleteAnalysis($id)
    {
        unset($this->visitAnalyses[$this->option][$id]);
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
        $this->reset('visitId', 'currentVisit', 'doctor', 'insurance_id', 'visit_date');
    }

    public function render()
    {
        return view('livewire.patient');
    }
}
