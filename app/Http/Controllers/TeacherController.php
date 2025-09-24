<?php

namespace App\Http\Controllers;

use App\Models\ExpenseType;
use App\Models\IncomeType;
use App\Models\Teacher;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TeacherController extends Controller
{
    public function index()
    {
        return Inertia::render('Teachers/index');
    }

   public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'designation' => 'nullable|string|max:255',
        'monthly_salary' => 'required|numeric',
        'contact' => 'nullable|string|max:255',
    ]);

    if ($request->id) {
        // 🔹 Update existing teacher
        $teacher = Teacher::findOrFail($request->id);
    } else {
        // 🔹 Create new teacher
        $teacher = new Teacher;
    }

    $teacher->name = $request->name;
    $teacher->designation = $request->designation;
    $teacher->monthly_salary = $request->monthly_salary;
    $teacher->contact = $request->contact;
    $teacher->save();

    return response()->json(['success' => true]);
}

    public function fetch()
    {
        $teachers = Teacher::all();

        return $teachers;
    }

     public function show($id)
    {
        $record = Teacher::findOrFail($id);
        return $record;
    }

    public function showTeacherDeatails($id)
{
    $teacher = Teacher::findOrFail($id);

    return Inertia::render('Teachers/TeacherDetails', [
        'record' => [$teacher], 
    ]);
}

}
