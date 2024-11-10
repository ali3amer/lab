<?php

namespace App\Livewire;

use App\Models\ChoiceRange;
use App\Models\TextRange;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Livewire\WithPagination;

class NumericRange extends Component
{
    use LivewireAlert;
    use WithPagination;

    protected $listeners = [
        'delete',
    ];
    public $age_gender_group_id;
    public $id = 0;
    #[Rule('required', message: 'أدخل القيمه الأقل')]
    public $min_value = 0;
    #[Rule('required', message: 'أدخل القيمة الأعلى')]
    public $max_value = 0;

    public function save()
    {
        $this->validate();
        if ($this->id == 0) {
            \App\Models\NumericRange::create([
                'age_gender_group_id' => $this->age_gender_group_id,
                'min_value' => $this->min_value,
                'max_value' => $this->max_value,
            ]);
        } else {
            \App\Models\NumericRange::where("id", $this->id)->update([
                'min_value' => $this->min_value,
                'max_value' => $this->max_value,
            ]);
        }
        $this->resetData();
        $this->alert('success', 'تم الحفظ بنجاح', ['timerProgressBar' => true]);
    }

    public function resetData()
    {
        $this->reset('min_value', 'max_value', 'id');
    }

    public function edit($numericRange)
    {
        $this->resetData();
        $this->id = $numericRange['id'];
        $this->min_value = $numericRange['min_value'];
        $this->max_value = $numericRange['max_value'];
    }

    public function deleteMassage($id)
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
        \App\Models\NumericRange::where("id", $data['inputAttributes']['id'])->delete();
        $this->resetData();

        $this->alert('success', 'تم الحذف بنجاح', ['timerProgressBar' => true]);
    }

    public function render()
    {
        return view('livewire.numeric-range', [
            'numericRanges' => \App\Models\NumericRange::where('age_gender_group_id', $this->age_gender_group_id)->get()
        ]);
    }
}
