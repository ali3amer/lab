<?php

namespace App\Livewire;

use App\Models\ReferenceRange;
use App\Models\Result;
use App\Models\Visit;
use App\Models\VisitTest;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\WithPagination;


class Patient extends Component
{
    use LivewireAlert;
    use WithPagination;

    protected $listeners = [
        'delete',
        'deleteVisit',
    ];
    public $header = "المرضى";
    public $id = 0;
    public $user = 0;
    public $searchName = "";

    #[Rule('required', message: 'أدخل إسم المريض')]
    public $patientName = "";
    public $duration = "year";
    public $gender = "male";
    public $age = 0;
    public $phone = 0;
    public array $durations = [
        'year' => 'سنة',
        'month' => 'شهر',
        'week' => 'أسبوع',
        'day' => 'يوم',
        'hour' => 'ساعه',
    ];
    public array $currentPatient = [];
    public $patient_id = null;


    public function mount()
    {
        if (!auth()->check()) {
            redirect("login");
        }
    }

    public function getVisits($id)
    {
        $this->visits = \App\Models\Visit::where("patient_id", $id)->latest()->get();
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
            $this->currentPatient = \App\Models\Patient::where("id", $this->id)->first()->toArray();
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

    }

    public function choosePatient($patient)
    {
        $this->currentPatient = $patient;
        $this->edit($patient);
        $this->patient_id = $this->currentPatient['id'];
        $this->visits = Visit::where("patient_id", $this->currentPatient['id'])->get();
    }

    public function resetPatientData()
    {
        $this->resetVisitData();
        $this->reset('id', 'patientName', 'gender', 'age', 'phone', 'currentPatient');
    }


    public function render()
    {
        $this->user = auth()->user();
        return view('livewire.patient', [
            "patients" => \App\Models\Patient::where('patientName', 'LIKE', '%' . $this->searchName . '%')->latest()->paginate(10)
        ]);
    }
}
