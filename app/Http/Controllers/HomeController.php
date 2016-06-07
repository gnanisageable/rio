<?php

namespace App\Http\Controllers;

use Log;
use App\Http\Controllers\QuintypeController;

class HomeController extends QuintypeController
{
    public function index()
    {
        return view('home', $this->toView(["foo" => 42]));
    }
}