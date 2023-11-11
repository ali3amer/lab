<?php

namespace App\Livewire;

use App\Models\ReferenceRange;
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
    public $searchName = "";
    public $searchAge = "";
    public $searchPhone = "";
    public $searchGender = "choose";
    public $searchDuration = "choose";

    #[Rule('required', message: 'أدخل إسم المريض')]
    public $patientName = "";
    public $duration = "year";
    public $gender = "male";
    public $insurance_id = null;
    public $age = 0;
    public $phone = 0;
    public Collection $patients;
    public Collection $insurances;
    public array $durations = [
        'year' => 'سنة',
        'month' => 'شهر',
        'week' => 'أسبوع',
        'day' => 'يوم',
        'hour' => 'ساعه',
    ];
    public $firstVisitDate = '';
    public array $currentPatient = [];
    public $discount = 0;
    public $amount = 0;
    public $total_amount = 0;

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

            $this->resetPatientData();
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
    }

    public function chooseCategory($category)
    {
        $this->currentCategory = $category;
        $this->analyses = \App\Models\Analysis::where('category_id', $category["id"])->get();
    }

    public function calcDiscount()
    {
        $this->total_amount = $this->amount - floatval($this->discount);
    }

    public function resetPatientData()
    {
        $this->reset('id', 'patientName', 'gender', 'age', 'phone', 'currentPatient');
        $this->getPatients();
    }

    public function render()
    {
        return view('livewire.patient');
    }
}
