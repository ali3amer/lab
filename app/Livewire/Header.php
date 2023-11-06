<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;



class Header extends Component
{


    public $header = "";

public function __construct()
{
    if(!Auth::check()) {
        return redirect("login");
    }
}

    public function render()
    {
        return view('livewire.header');
    }
}
