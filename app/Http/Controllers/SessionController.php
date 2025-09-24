<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class SessionController extends Controller
{
    public function index(){
       return inertia::render('Sessions/index');
    }
}
