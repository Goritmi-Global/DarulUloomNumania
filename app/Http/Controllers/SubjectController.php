<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'subject_name' => 'required|string|max:255',
            'total_marks' => 'required|integer|min:1|max:1000',
            'class_id' => 'required|exists:classes,id',
        ]);

        $subject = Subject::create([
            'subject_name' => $request->subject_name,
            'total_marks' => $request->total_marks,
            'class_id' => $request->class_id,
        ]);

        return response()->json($subject);
    }

    public function destroy($id)
    {
        $subject = Subject::findOrFail($id);
        $subject->delete();

        return response()->json(['message' => 'Subject deleted successfully.']);
    }

    public function getSubjects()
    {

        return response()->json(Subject::select('id', 'subject_name')->get());
    }
}
