<?php

namespace App\Livewire;

use Livewire\Component;

class Client extends Component
{

    public $header = "المرضى";
    public function render()
    {
        return view('livewire.client');
    }
}
