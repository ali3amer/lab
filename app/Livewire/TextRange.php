<?php

namespace App\Livewire;

use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class TextRange extends Component
{
    use LivewireAlert;
    use WithPagination;

    protected $listeners = [
        'delete',
    ];
    public $age_gender_group_id;
    public $id = 0;
    public $text = "";

    public function save()
    {
        if ($this->id == 0) {
            \App\Models\TextRange::create([
                'age_gender_group_id' => $this->age_gender_group_id,
                'text' => $this->text,
            ]);
        } else {
            \App\Models\TextRange::where("id", $this->id)->update([
                'text' => $this->text,
            ]);
        }
        $this->resetData();
        $this->alert('success', 'تم الحفظ بنجاح', ['timerProgressBar' => true]);
    }

    public function resetData()
    {
        $this->reset('text', 'id');
    }

    public function edit($text)
    {
        $this->id = $text['id'];
        $this->text = $text['text'];
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
        \App\Models\TextRange::where("id", $data['inputAttributes']['id'])->delete();

        $this->alert('success', 'تم الحذف بنجاح', ['timerProgressBar' => true]);
    }

    public function render()
    {
        return view('livewire.text-range', [
            'texts' => \App\Models\TextRange::where('age_gender_group_id', $this->age_gender_group_id)->get()
        ]);
    }
}
