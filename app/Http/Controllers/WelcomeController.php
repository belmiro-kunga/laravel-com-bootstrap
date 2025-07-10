<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\ConfigHelper;

class WelcomeController extends Controller
{
    public function index()
    {
        return view('home');
    }
}
