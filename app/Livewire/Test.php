<?php

namespace App\Livewire;

use Livewire\Component;

class Test extends Component
{

    public $header = "التحاليل";


    public function render()
    {
        dd(\App\Models\Test::tree(1))->get();
        return view('livewire.test');
    }
}
