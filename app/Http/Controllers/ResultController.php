<?php

namespace App\Http\Controllers;

use App\Models\ClassModel;
use App\Models\Result;
use App\Models\Student;
use App\Models\Subject;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ResultController extends Controller
{
    public function index()
    {
        return Inertia::render('Result/index');
    }

    public function showClassResults($classId)
    {

        $class = ClassModel::findOrFail($classId);
        $students = Student::where('class_id', $classId)->orderBy('name')->get();
        $subjects = Subject::where('class_id', $classId)->get();

        return Inertia::render('Result/ClassResult', [
            'classData' => $class,
            'students' => $students,
            'subjects' => $subjects,
        ]);
    }

    public function store(Request $request)
    {
       
        $data = $request->validate([
            'class_id' => 'required|exists:classes,id',
            'results' => 'required|array',
            // 'marks' => 'required'
        ]); 

        foreach ($data['results'] as $result) {
            Result::updateOrCreate(
                [
                    'student_id' => $result['student_id'],
                    'class_id' => $result['class_id'],
                ],
                [
                    'marks' => json_encode($result['marks']),
                ]
            );
        }

        return response()->json(['message' => 'Results saved successfully!']);
    }
}
