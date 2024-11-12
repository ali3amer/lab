<?php

namespace App\Livewire;

use App\Models\RangeChoice;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Livewire\WithPagination;

class ChoiceRange extends Component
{

    use LivewireAlert;
    use WithPagination;

    protected $listeners = [
        'delete',
    ];
    public $age_gender_group_id;
    public $choice_range_id = null;
    public $id = 0;
    #[Rule('required', message: 'أدخل الخيار')]
    public $choiceName = "";
    public bool $default = false;
    public array $currentLocation = [];
    public array $currentChoice = [];

    public function changeLocation($index)
    {
        $this->resetData();

        if ($index == -1) {
            $this->currentLocation = [];
            $this->currentChoice = [];
            $this->choice_range_id = null;
        } else {

            $this->chooseRange($index);

            $newArray = [];
            foreach ($this->currentLocation as $key => $location) {
                $newArray[$key] = $location;
                if ($index == $key) {
                    break;
                }
            }

            $this->currentLocation = $newArray;

        }

    }

    public function chooseRange($id)
    {
        $this->currentChoice = \App\Models\ChoiceRange::where("id", $id)->first()->toArray();
        $this->choice_range_id = $this->currentChoice['id'];
        $this->currentLocation[$id] = $this->currentChoice['choiceName'];
    }


    public function save()
    {
        $this->validate();
        if ($this->id == 0) {
            \App\Models\ChoiceRange::create([
                'age_gender_group_id' => $this->choice_range_id == null ? $this->age_gender_group_id : null,
                'choice_range_id' => $this->choice_range_id,
                'choiceName' => $this->choiceName,
                'default' => $this->default,
            ]);
        } else {
            \App\Models\ChoiceRange::where("id", $this->id)->update([
                'choiceName' => $this->choiceName,
                'default' => $this->default,
            ]);
        }
        $this->resetData();
        $this->alert('success', 'تم الحفظ بنجاح', ['timerProgressBar' => true]);
    }

    public function resetData()
    {
        $this->reset('choiceName', 'id', 'default');
    }

    public function edit($choiceRange)
    {
        $this->id = $choiceRange['id'];
        $this->default = $choiceRange['default'];
        $this->choiceName = $choiceRange['choiceName'];
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
        \App\Models\ChoiceRange::where("id", $data['inputAttributes']['id'])->delete();
        $this->resetData();
        $this->alert('success', 'تم الحذف بنجاح', ['timerProgressBar' => true]);
    }

    public function render()
    {
        return view('livewire.choice-range', [
            'choiceRanges' => $this->choice_range_id == null ? \App\Models\ChoiceRange::where('age_gender_group_id', $this->age_gender_group_id)->get() : \App\Models\ChoiceRange::where('choice_range_id', $this->choice_range_id)->get()
        ]);
    }
}
