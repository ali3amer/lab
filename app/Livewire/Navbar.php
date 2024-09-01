<?php

namespace App\Livewire;

use Livewire\Component;

class Navbar extends Component
{
    public $user;
    public function render()
    {
        $this->user = auth()->user();
        return view('livewire.navbar');
    }
}
