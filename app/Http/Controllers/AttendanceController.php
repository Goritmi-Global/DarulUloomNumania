<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\ClassModel;
use App\Models\Student;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AttendanceController extends Controller
{
    public function index()
    {
        return inertia::render('Attendance/index');
    }

    public function showClassStudents($id)
    {
        $class = ClassModel::findOrFail($id);
        $students = Student::where('class_id', $id)->orderBy('name')->get();

        return Inertia::render('Attendance/ClassStudents', [
            'classData' => $class,
            'students' => $students,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'class_id' => 'required|exists:classes,id',
            'attendances' => 'required|array',
        ]);

        foreach ($request->attendances as $attendance) {
            Attendance::updateOrCreate(
                [
                    'student_id' => $attendance['student_id'],
                    'class_id' => $request->class_id,
                    'attendance_date' => now()->toDateString(),
                ],
                [
                    'status' => $attendance['status'],
                ]
            );
        }

        return response()->json(['success' => true, 'message' => 'Attendance marked successfully!']);
    }
}
