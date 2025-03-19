<?php

namespace App\Http\Controllers; 
use Illuminate\Support\Str;  
use Illuminate\Http\Request; 
use Inertia\Inertia;
 

class ExternalWebstieController extends Controller
{
    public function index()
    { 
      
        return Inertia::render('FrontEnd/Index');
    }
    public function create()
    { 
        return Inertia::render('FrontEnd/Enrollment/Create');
    }
    public function about()
    {
        return Inertia::render('FrontEnd/About');
    }
    public function events()
    {
        return Inertia::render('FrontEnd/Events');
    }
    public function contact()
    {
        return Inertia::render('FrontEnd/Contact');
    }
  

}
