<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Psy\TabCompletion\Matcher\FunctionsMatcher;

class HomeController extends Controller
{
    //Home
    public function home()
    {
        return view('home');
    }
}
