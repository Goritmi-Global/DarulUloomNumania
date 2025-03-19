<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;

use App\Models\Student;
use App\Models\Upload;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
 
use Inertia\Inertia;
use PDF;

class StudentsController extends Controller
{
    public function index()
    { 
        return Inertia::render('Students/Index');
    }
    public function create()
    { 
        return Inertia::render('FrontEnd/Enrollment/Create');
    }
    public function edit($id)
    {
        return Inertia::render('Students/Create', ['studentId' => $id]);
    }
    public function students()
    { 
        $students = Student::orderBy('created_at')->get();
         
  
        return $students;
    }
   
    public function store(Request $request)
    {  
        $request->validate([
            'apply_for' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'father' => 'required|string|max:255',
            'dob' => 'required|date',
            'permanent_address' => 'required',
            'current_address' => 'required',
            'primary_education' => 'required',
            'additional_ability' => 'required',
        ]);
    
        if ($request->id) {
            // Find existing student
            $student = Student::where('id', $request->id)->first();
        } else {
            // Create a new student record
            $student = new Student();
            $student->id = Str::uuid(); // Generate unique ID
        }
    
        // Assign values from request
        $student->apply_for = $request->apply_for;
        $student->name = $request->name;
        $student->father = $request->father;
        $student->dob = $request->dob;
        $student->permanent_address = $request->permanent_address;
        $student->current_address = $request->current_address;
        $student->primary_education = $request->primary_education;
        $student->additional_ability = $request->additional_ability;
    
        // Save record
        $student->save();
    
        return response()->json([
            'message' => $request->id ? 'Student updated successfully' : 'Student enrolled successfully'
        ]);
    }

}
