<?php

namespace App\Http\Controllers;

abstract class Controller
{
    public function landing(){
        return view("welcome");
    }
}
