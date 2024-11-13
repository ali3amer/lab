<?php

namespace App\Livewire;

use App\Models\Result;
use App\Models\VisitTest;
use Illuminate\Database\Eloquent\Collection;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class Visit extends Component
{
    use LivewireAlert;
    use WithPagination;

    protected $listeners = [
        'delete',
    ];
    public $patient_id;
    public $user;
    public $id = 0;
    public $firstVisitDate = '';
    public $insurance_id = null;
    public array $insurances = [];

    public $discount = 0;
    public $amount = 0;
    public $total_amount = 0;
    public $insuranceNumber = null;
    public $doctor = null;
    public $patientEndurance = null;
    public $visit_date = "";

    public array $currentVisit = [];

    public bool $visitTestMode = false;
    public $visit_id = null;


    public function mount()
    {
        if (!auth()->check()) {
            redirect("login");
        }
        $this->insurances = \App\Models\Insurance::all()->keyBy("id")->toArray();
        $this->firstVisitDate = date('Y-m-d');

    }

    public function save()
    {
        if ($this->id == 0) {
            $visit = \App\Models\Visit::create([
                'patient_id' => $this->patient_id,
                'user_id' => auth()->id(),
                'insurance_id' => $this->insurance_id,
                'insuranceNumber' => $this->insuranceNumber,
                'amount' => $this->amount,
                'total_amount' => $this->total_amount,
                'discount' => $this->discount,
                'doctor' => $this->doctor,
                'patientEndurance' => $this->insurance_id != null ? $this->insurances[$this->insurance_id]["patientEndurance"] : 100,
                'visit_date' => $this->visit_date,
            ]);

            $this->chooseVisit($visit->toArray());
            $this->alert('success', 'تم الحفظ بنجاح', ['timerProgressBar' => true]);

        } else {
            \App\Models\Visit::where('id', $this->id)->update([
                'user_id' => auth()->id(),
                'insurance_id' => $this->insurance_id,
                'insuranceNumber' => $this->insuranceNumber,
                'total_amount' => $this->total_amount,
                'discount' => $this->discount,
                'doctor' => $this->doctor,
                'patientEndurance' => $this->insurance_id != null ? $this->insurances[$this->insurance_id]["patientEndurance"] : 100,
                'visit_date' => $this->visit_date,
            ]);

            $this->alert('success', 'تم التعديل بنجاح', ['timerProgressBar' => true]);

            $this->resetVisitData();
        }

    }

    public function chooseVisit($visit)
    {
        $this->visitTestMode = true;
        $this->currentVisit = $visit;
        $this->visit_id = $visit['id'];

        $this->edit($this->currentVisit);
    }

    public function edit($visit)
    {
        $this->id = $visit['id'];
        $this->insurance_id = $visit['insurance_id'];
        $this->insuranceNumber = $visit['insuranceNumber'];
        $this->amount = $visit['amount'];
        $this->total_amount = $visit['total_amount'];
        $this->discount = $visit['discount'];
        $this->doctor = $visit['doctor'];
        $this->patientEndurance = $visit['patientEndurance'];
        $this->visit_date = $visit['visit_date'];
    }

    public function deleteMessage($id)
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
        \App\Models\Visit::where("id", $data['inputAttributes']['id'])->delete();
        $this->alert('success', 'تم الحذف بنجاح', ['timerProgressBar' => true]);
    }

    public function resetVisitData()
    {
        $this->reset("id", "insurance_id", "insuranceNumber", "amount", "discount", "total_amount", "doctor", "patientEndurance", "visit_date", "currentVisit", "visitTestMode");
    }


    public function render()
    {
        $this->user = auth()->user();
        if (!auth()->check()) {
            redirect("login");
        }
        if ($this->visit_date == "") {
            $this->visit_date = date("Y-m-d");
        }
        return view('livewire.visit', [
            "visits" => \App\Models\Visit::where("patient_id", $this->patient_id)->latest()->get()
        ]);
    }
}
