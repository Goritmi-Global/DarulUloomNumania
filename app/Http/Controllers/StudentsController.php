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
    public function EnrolledStudents()
    { 
        return Inertia::render('Students/EnrolledStudents');
    }
    public function enroll_new_students()
    { 
        return Inertia::render('Students/CreateNewStudent');
    }
    public function create()
    { 
        return Inertia::render('FrontEnd/Enrollment/Enroll');
    }
    public function show($id)
    {
        return Inertia::render('Students/CreateNewStudent', ['studentId' => $id,'studentData'=> Student::findOrFail($id)]);
    }
    public function students()
    { 
        $students = Student::orderBy('created_at')->get();
         
  
        return $students;
    }
    public function enrolled_students()
    { 
        $students = Student::orderBy('created_at')->where('status',1)->get();
        // dd($students);
         
  
        return $students;
    }
   
    public function store(Request $request)
{
    
    $request->validate([
        'apply_for' => 'required',
        'name' => 'required|string|max:255',
        'father' => 'required|string|max:255',
        'dob' => 'required|date',
        'cnic' => 'required|string|max:255',
        'country' => 'required',
        'province' => 'required',
        'phone_number' => 'required|string|max:255',
        'whatsapp' => 'required|string|max:255',

        'guardian_name' => 'required|string|max:255',
        'guardian_cnic' => 'required|string|max:255',
        'guardian_mobile' => 'required|string|max:255',

        'previous_madrasa' => 'required|string|max:255',
        'previous_class' => 'required|string|max:255',
        'total_marks' => 'required|string|max:255',
        'obtained_marks' => 'required|string|max:255',

        'primary_education' => 'required|string|max:255',
        'additional_ability' => 'required|string|max:255',

        'permanent_address' => 'required|string',
        'current_address' => 'required|string',
    ]);
 
    $student = $request->id
        ? Student::findOrFail($request->id)
        : new Student(['id' => Str::uuid()]);

    // Personal Information
    $student->apply_for = $request->apply_for;
    $student->name = $request->name;
    $student->father = $request->father;
    $student->dob = $request->dob;
    $student->cnic = $request->cnic;
    $student->country = $request->country;
    $student->province = $request->province;
    $student->phone_number = $request->phone_number;
    $student->whatsapp = $request->whatsapp;

    // Guardian Info
    $student->guardian_name = $request->guardian_name;
    $student->guardian_cnic = $request->guardian_cnic;
    $student->guardian_mobile = $request->guardian_mobile;

    // Academic Info
    $student->previous_madrasa = $request->previous_madrasa;
    $student->previous_class = $request->previous_class;
    $student->total_marks = $request->total_marks;
    $student->obtained_marks = $request->obtained_marks;
    $student->primary_education = $request->primary_education;
    $student->additional_ability = $request->additional_ability;

    // Address
    $student->permanent_address = $request->permanent_address;
    $student->current_address = $request->current_address;
    $student->session = Carbon::now()->format('Y');
    $student->status = $request->status ?? '';
    // Save
    $student->save();

    return response()->json([
        'message' => $request->id
            ? 'Student updated successfully'
            : 'Student enrolled successfully'
    ]);
}

public function checkAdmissionStatus($cnic)
{
    $student = Student::select('name', 'cnic', 'father', 'apply_for', 'status')
        ->where('cnic', $cnic)
        ->first();

    return $student;
}


public function updateStatus(Request $request)
{
    // dd($request);
    $student = Student::findOrFail($request->id);
    $student->status = $request->status;
    $student->save();

    return response()->json(['message' => 'Status updated']);
}


public function delete($id)
{
    $student = Student::findOrFail($id);
    $student->delete();

    return 'success'; 
}


}
