<?php

namespace App\Livewire;

use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class Insurance extends Component
{
    public $header = "التأمينات";
    public Collection $insurances;
    public $searchName = "";
    public $id = 0;
    public $insuranceName = "";
    public $companyEndurance = "";
    public $patientEndurance = "";

    public function mount()
    {
        $this->insurances = \App\Models\Insurance::all();
    }

    public function getInsurances()
    {
        $this->insurances = \App\Models\Insurance::all();
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
                'companyEndurance' => $this->companyEndurance,
                'patientEndurance' => $this->patientEndurance,
            ]);
        } else {
            \App\Models\Insurance::where('id', $this->id)->update([
                'insuranceName' => $this->insuranceName,
                'companyEndurance' => $this->companyEndurance,
                'patientEndurance' => $this->patientEndurance,
            ]);
        }

        $this->getInsurances();

        $this->resetData();
    }

    public
    function edit($insurance)
    {
        $this->id = $insurance['id'];
        $this->insuranceName = $insurance['insuranceName'];
        $this->companyEndurance = $insurance['companyEndurance'];
        $this->patientEndurance = $insurance['patientEndurance'];
    }

    public function delete($id)
    {
        \App\Models\Insurance::where("id", $id)->delete();
        $this->getInsurances();
    }


    public function resetData()
    {
        $this->reset('id', 'insuranceName', 'companyEndurance', 'patientEndurance');
    }

    public function render()
    {
        return view('livewire.insurance');
    }
}
