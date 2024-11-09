<?php

namespace App\Livewire;

use App\Models\ChoiceRange;
use App\Models\TextRange;
use Livewire\Component;

class NumericRange extends Component
{
    public function save()
    {
        if ($this->result_type == "number") {
            \App\Models\NumericRange::create([
                'age_gender_group_id' => $ageGenderGroup['id'],
                'min_value' => $this->min_value,
                'max_value' => $this->max_value,
            ]);
        } elseif ($this->result_type == "text") {
            TextRange::create([
                'age_gender_group' => $ageGenderGroup['id'],
                'text' => $this->text
            ]);
        } elseif ($this->result_type == "multiple_choice") {
            ChoiceRange::create([
                'age_gender_group' => $ageGenderGroup['id'],
                'choiceName' => $this->choiceName,
                'default' => $this->default,
                'choice_range_id' => $this->choice_range_id,
            ]);
        } elseif ($this->result_type == "text_and_multiple_choice") {

        }
    }

    public function deleteMassageRange($id)
    {
        $this->confirm("  هل توافق على الحذف ؟  ", [
            'inputAttributes' => ["id" => $id],
            'toast' => false,
            'showConfirmButton' => true,
            'confirmButtonText' => 'موافق',
            'onConfirmed' => "deleteRange",
            'showCancelButton' => true,
            'cancelButtonText' => 'إلغاء',
            'confirmButtonColor' => '#dc2626',
            'cancelButtonColor' => '#4b5563'
        ]);
    }
    public function deleteRange($data)
    {
        if ($this->currentTest['result_type'] == "number") {
            \App\Models\NumericRange::where("id", $data['inputAttributes']['id'])->delete();
        } elseif ($this->currentTest['result_type'] == "text") {
            TextRange::where("id", $data['inputAttributes']['id'])->delete();
        } elseif ($this->currentTest['result_type'] == "multiple_choice") {
            ChoiceRange::where("id", $data['inputAttributes']['id'])->delete();
        }
        $this->getRanges($this->test_id);
        $this->alert('success', 'تم الحذف بنجاح', ['timerProgressBar' => true]);
    }

    public function render()
    {
        return view('livewire.numeric-range');
    }
}
