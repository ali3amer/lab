<?php

namespace App\Livewire;

use App\Models\InsuranceDebt;
use App\Models\Visit;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;
class Insurance extends Component
{
    use LivewireAlert;
    protected $listeners = [
        'deleteInsurance',
        'deleteInsuranceDebt',
    ];
    public $header = "التأمينات";
    public Collection $insurances;
    public $searchName = "";
    public $id = 0;
    public $balance = 0;
    public $riminder = 0;
    public $insuranceName = "";
    public $companyEndurance = "";
    public $patientEndurance = "";
    public Collection $debts;
    public $contractDate = "";
    public array $currentInsurance = [];
    public $debtId = 0;
    public $amount = 0;
    public $note = "";
    public $user;
    public $paid_date = "";

    public function mount()
    {
        if(!auth()->check()) {
            redirect("login");
        }

        $this->insurances = \App\Models\Insurance::all();
    }

    public function getInsurances()
    {
        $this->insurances = \App\Models\Insurance::all();
    }

    public function getInsuranceDebts()
    {
        $this->debts = \App\Models\InsuranceDebt::where("insurance_id", $this->currentInsurance['id'])->get();
        $this->chooseInsurance($this->currentInsurance);
    }

    public function search()
    {
        $this->insurances = \App\Models\Insurance::where('insuranceName', 'LIKE', '%' . $this->searchName . '%')->get();
    }

    public function save()
    {
        if ($this->id == 0) {
            \App\Models\Insurance::create([
                'insuranceName' => $this->insuranceName,
                'companyEndurance' => floatval($this->companyEndurance),
                'patientEndurance' => floatval($this->patientEndurance),
                'contractDate' => $this->contractDate,
            ]);
            $this->alert('success', 'تم الحفظ بنجاح', ['timerProgressBar' => true]);

        } else {
            \App\Models\Insurance::where('id', $this->id)->update([
                'insuranceName' => $this->insuranceName,
                'companyEndurance' => floatval($this->companyEndurance),
                'patientEndurance' => floatval($this->patientEndurance),
                'contractDate' => $this->contractDate,
            ]);
            $this->alert('success', 'تم التعديل بنجاح', ['timerProgressBar' => true]);

        }

        $this->getInsurances();

        $this->resetData();
    }

    public function saveDebt()
    {
        if ($this->debtId == 0) {
            \App\Models\InsuranceDebt::create([
                'insurance_id' => $this->currentInsurance['id'],
                'amount' => $this->amount,
                'paid_date' => $this->paid_date,
                'note' => $this->note,
            ]);
            $this->alert('success', 'تم الحفظ بنجاح', ['timerProgressBar' => true]);

        } else {
            \App\Models\InsuranceDebt::where('id', $this->debtId)->update([
                'amount' => $this->amount,
                'paid_date' => $this->paid_date,
                'note' => $this->note,
            ]);
            $this->alert('success', 'تم التعديل بنجاح', ['timerProgressBar' => true]);

        }

        $this->getInsuranceDebts();
        $this->resetDebtsData();
    }

    public function edit($insurance)
    {
        $this->id = $insurance['id'];
        $this->insuranceName = $insurance['insuranceName'];
        $this->companyEndurance = $insurance['companyEndurance'];
        $this->patientEndurance = $insurance['patientEndurance'];
        $this->contractDate = $insurance['contractDate'];
    }

    public function editDebt($debt)
    {
        $this->debtId = $debt['id'];
        $this->paid_date = $debt['paid_date'];
        $this->amount = $debt['amount'];
        $this->note = $debt['note'];
    }

    public function deleteMessage($id)
    {
        $this->confirm("  هل توافق على الحذف ؟  ", [
            'inputAttributes' => ["id" => $id],
            'toast' => false,
            'showConfirmButton' => true,
            'confirmButtonText' => 'موافق',
            'onConfirmed' => "deleteInsurance",
            'showCancelButton' => true,
            'cancelButtonText' => 'إلغاء',
            'confirmButtonColor' => '#dc2626',
            'cancelButtonColor' => '#4b5563'
        ]);
    }
    public function deleteInsurance($data)
    {
        \App\Models\Insurance::where("id", $data['inputAttributes']['id'])->delete();
        $this->alert('success', 'تم الحذف بنجاح', ['timerProgressBar' => true]);
        $this->getInsurances();
    }

    public function deleteDebtMessage($id)
    {
        $this->confirm("  هل توافق على الحذف ؟  ", [
            'inputAttributes' => ["id" => $id],
            'toast' => false,
            'showConfirmButton' => true,
            'confirmButtonText' => 'موافق',
            'onConfirmed' => "deleteInsuranceDebt",
            'showCancelButton' => true,
            'cancelButtonText' => 'إلغاء',
            'confirmButtonColor' => '#dc2626',
            'cancelButtonColor' => '#4b5563'
        ]);
    }

    public function deleteInsuranceDebt($data)
    {
        \App\Models\InsuranceDebt::where("id", $data)->delete();
        $this->getInsuranceDebts();
        $this->alert('success', 'تم الحذف بنجاح', ['timerProgressBar' => true]);
    }

    public function chooseInsurance($insurance)
    {
        $this->currentInsurance = $insurance;
        $this->edit($insurance);
        $this->balance = \App\Models\Insurance::find($insurance['id'])->balance;
        $this->debts = InsuranceDebt::where("insurance_id", $insurance['id'])->get();
    }


    public function resetData()
    {
        $this->reset('id', 'insuranceName', 'companyEndurance', 'patientEndurance', 'currentInsurance', 'contractDate');
    }

    public function resetDebtsData()
    {
        $this->reset('debtId', 'amount', 'paid_date', 'note',);
    }

    public function render()
    {
        if ($this->contractDate == "") {
            $this->contractDate = date("Y-m-d");
        }

        if ($this->paid_date == "") {
            $this->paid_date = date("Y-m-d");
        }

        if (!empty($this->currentInsurance)) {
            $this->riminder = $this->balance - $this->amount;
        }
        $this->user = auth()->user();

        return view('livewire.insurance');
    }
}
