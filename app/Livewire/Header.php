<?php

namespace App\Livewire;

use Livewire\Component;

class Header extends Component
{
    public $header = "";
    public function render()
    {
        return view('livewire.header');
    }
}
