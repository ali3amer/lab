<?php

namespace App\Livewire;

use App\Models\RangeChoice;
use Livewire\Component;

class ChoiceRange extends Component
{

    public function addChoice()
    {
        if ($this->choiceId == 0) {
            RangeChoice::create([
                "range_id" => empty($this->currentChoice) ? $this->range_id : null,
                "choiceName" => $this->choiceName,
                "default" => $this->default,
                "choice_id" => !empty($this->currentChoice) ? $this->currentChoice['id'] : null
            ]);
        } else {
            RangeChoice::where("id", $this->choiceId)->update([
                "choiceName" => $this->choiceName,
                "default" => $this->default,
            ]);
        }
        $this->choiceName = "";
        $this->choiceId = 0;
        $this->default = false;
        $this->getChoices(true);
    }

    public function editChoice($choice)
    {
        $this->choiceId = $choice["id"];
        $this->choiceName = $choice["choiceName"];
        $this->default = $choice["default"];
    }

    public function deleteChoice($id)
    {
        RangeChoice::where("choice_id", $id)->delete();
        RangeChoice::where("id", $id)->delete();
        $this->getChoices(true);
    }

    public function getChoices($mode = false)
    {
        $this->choicesMode = $mode;
        if (empty($this->currentChoice)) {
            $this->choices = RangeChoice::where("range_id", $this->range_id)->get();
        } else {
            $this->choices = RangeChoice::where("choice_id", $this->currentChoice['id'])->get();
        }
    }

    public function chooseChoice($choice)
    {
        $this->currentChoice = $choice;
        $this->getChoices(true);
    }

    public function resetRangeData()
    {
        $this->reset("gender", "age", "result_type", "refId");
    }

    public function resetChoicesData()
    {
        if (!empty($this->currentChoice)) {
            if ($this->currentChoice['choice_id'] != null) {
                $this->currentChoice = RangeChoice::where("id", $this->currentChoice['choice_id'])->first()->toArray();
            } else {
                $this->currentChoice = [];
            }
            $this->getChoices(true);
        } else {
            $this->reset("range_id", "choicesMode", "choiceName", "choiceId");
            $this->resetRangeData();
        }
    }

    public function render()
    {
        return view('livewire.choice-range');
    }
}
