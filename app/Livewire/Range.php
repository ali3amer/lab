<?php

namespace App\Livewire;

use Livewire\Component;

class Range extends Component
{
    public $age_gender_group_id;
    public $result_type;
    public function render()
    {
        return view('livewire.range');
    }
}
