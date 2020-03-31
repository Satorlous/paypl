<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class SiteController extends Controller
{
    public function index()
    {
        return view('index');
    }

    public function test()
    {

    }
}
