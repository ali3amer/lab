<?php

namespace App\Livewire;

use App\Models\ChoiceRange;
use App\Models\NumericRange;
use App\Models\ReferenceRange;
use App\Models\TextRange;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class AgeGenderGroup extends Component
{
    use LivewireAlert;
    use WithPagination;

    protected $listeners = [
        'delete',
    ];
    public array $genders = [
        "all" => "الكل",
        "male" => "ذكر",
        "female" => "أنثى",
    ];

    public array $ages = [
        "all" => "الكل",
        "year" => "سنة",
        "month" => "شهر",
        "week" => "اسبوع",
        "day" => "يوم",
        "hour" => "ساعة",
    ];

    public $gender = "all";
    public $age = "all";
    public $result_type;
    public $id = 0;
    public $age_gender_group_id = 0;
    public $test_id;
    public $refId = 0;
    public $rangeMode = false;
    public $choicesMode = false;
    public bool $default = false;

    public $min_value = null;
    public $max_value = null;
    public $text = null;
    public $min_age = null;
    public $max_age = null;

    public function save()
    {
        if ($this->id == 0) {
            $ageGenderGroup = \App\Models\AgeGenderGroup::create([
                "test_id" => $this->test_id,
                "gender" => $this->gender,
                "age" => $this->age,
                "min_age" => floatval($this->min_age) == 0 ? null : floatval($this->min_age),
                "max_age" => floatval($this->max_age) == 0 ? null : floatval($this->max_age),
            ]);

            $this->alert('success', 'تم الحفظ بنجاح', ['timerProgressBar' => true]);

        } else {
            \App\Models\AgeGenderGroup::where("id", $this->id)->update([
                "gender" => $this->gender,
                "age" => $this->age,
                "min_age" => floatval($this->min_age) == 0 ? null : floatval($this->min_age),
                "max_age" => floatval($this->max_age) == 0 ? null : floatval($this->max_age),
            ]);

            $this->alert('success', 'تم التعديل بنجاح', ['timerProgressBar' => true]);
        }
        $this->resetData();
    }

    public function edit($ageGenderGroup)
    {
        $this->resetData();
        $this->id = $ageGenderGroup['id'];
        $this->gender = $ageGenderGroup['gender'];
        $this->age = $ageGenderGroup['age'];
        $this->min_age = $ageGenderGroup['min_age'];
        $this->max_age = $ageGenderGroup['max_age'];
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
        \App\Models\AgeGenderGroup::where("id", $data['inputAttributes']['id'])->delete();
        $this->resetData();

        $this->alert('success', 'تم الحذف بنجاح', ['timerProgressBar' => true]);
    }

    public function chooseAgeGenderGroup($ageGenderGroup)
    {
        $this->age_gender_group_id = $ageGenderGroup['id'];
        $this->rangeMode = true;
    }

    public function resetData()
    {
        $this->reset('id', 'age_gender_group_id', 'gender', 'age', 'min_age', 'max_age', 'rangeMode');
    }

    public function render()
    {
        return view('livewire.age-gender-group', [
            'ageGenderGroups' => \App\Models\AgeGenderGroup::where('test_id', $this->test_id)->get(),
        ]);
    }
}
