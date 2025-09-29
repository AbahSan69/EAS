<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Psy\TabCompletion\Matcher\FunctionsMatcher;

class HomeController extends Controller
{
    //Home
    public function index()
    {
        return view('admin.dashboard');
    }

    public function tes()
    {
        return view('ea.create');
    }

    public function tes2()
    {
        return view('progress.load');
    }

    public function tes3()
    {
        return view('ea.index');
    }

    public function tes4($id)
    {
        $id_pts = $id;
        return view('ea.index', compact('id_pts'));
    }
}
