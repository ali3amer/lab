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
    public $searchName = "";
    public $searchAge = "";
    public $searchPhone = "";
    public $searchGender = "choose";
    public $searchDuration = "choose";

    #[Rule('required', message: 'أدخل إسم المريض')]
    public $patientName = "";
    public $duration = "years";
    public $gender = "male";
    public $insurance_id = null;
    public $visit_date = "";
    public $doctor = "";
    public $age = 0;
    public $phone = 0;
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

    public function mount()
    {
        $this->patients = \App\Models\Patient::all();
        $this->insurances = \App\Models\Insurance::all();
        $this->firstVisitDate = date('Y-m-d');
    }

    public function getPatients()
    {
        $this->patients = \App\Models\Patient::all();
    }

    public function searchAnalyses()
    {
        $this->subAnalyses = SubAnalysis::where('subAnalysisName', 'LIKE', '%'.$this->searchAnalysis.'%')->get();
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
        foreach ($this->visitAnalyses as $analysis) {
            VisitAnalysis::create([
                'visit_id' => $this->currentVisit['id'],
                'sub_analysis_id' => $analysis['sub_analysis_id'],
                'price' => $analysis['price'],
                'result' => $analysis['result'],
            ]);
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
        $this->getAnalyses($visit['id']);
    }

    public function getAnalyses($id)
    {
        $this->subAnalyses = SubAnalysis::all();
        $this->visitAnalyses = VisitAnalysis::where("visit_id", $id)->get()->toArray();
    }

    public function addAnalysis($analysis)
    {
        $this->visitAnalyses[$analysis['id']] = $analysis;
        $this->visitAnalyses[$analysis['id']]['sub_analysis_id'] = $analysis['id'];
        $this->visitAnalyses[$analysis['id']]['price'] = 0;
        $this->visitAnalyses[$analysis['id']]['result'] = null;
    }

    public function deleteAnalysis($id)
    {
        unset($this->visitAnalyses[$id]);
    }

    public function resetData()
    {
        $this->reset('id', 'patientName', 'gender', 'age', 'phone', 'currentPatient');
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
