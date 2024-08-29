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
    public $paid_date = "";

    public function mount()
    {
        $this->insurances = \App\Models\Insurance::all();
    }

    public function getInsurances()
    {
        $this->insurances = \App\Models\Insurance::all();
    }

    public function getInsuranceDebts()
    {
        $this->debts = \App\Models\InsuranceDebt::where("insurance_id", $this->currentInsurance['id'])->get();
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
        } else {
            \App\Models\Insurance::where('id', $this->id)->update([
                'insuranceName' => $this->insuranceName,
                'companyEndurance' => floatval($this->companyEndurance),
                'patientEndurance' => floatval($this->patientEndurance),
                'contractDate' => $this->contractDate,
            ]);
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
        } else {
            \App\Models\InsuranceDebt::where('id', $this->debtId)->update([
                'amount' => $this->amount,
                'paid_date' => $this->paid_date,
                'note' => $this->note,
            ]);
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

    public function delete($id)
    {
        \App\Models\Insurance::where("id", $id)->delete();
        $this->getInsurances();
    }

    public function deleteDebt($id)
    {
        \App\Models\InsuranceDebt::where("id", $id)->delete();
        $this->getInsuranceDebts();
    }

    public function chooseInsurance($insurance)
    {
        $this->currentInsurance = $insurance;
        $this->edit($insurance);
        $this->balance = 0;
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
        if (!empty($this->currentInsurance)) {
            $this->riminder = $this->balance - $this->amount;
        }
        return view('livewire.insurance');
    }
}
