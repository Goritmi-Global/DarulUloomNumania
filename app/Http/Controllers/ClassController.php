<?php

namespace App\Http\Controllers;

use App\Models\ClassModel;
use App\Models\Subject;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ClassController extends Controller
{
    public function index()
    {
        return inertia::render('Classes/index');
    }

    public function fetch()
    {
        return response()->json(ClassModel::all());
    }

    public function show($id)
    {
        return response()->json(ClassModel::findOrFail($id));
    }

    public function store(Request $request)
    {
        $request->validate([
            'class_name' => 'required|string|max:255|unique:classes,class_name,'.$request->id,
        ]);

        $class = ClassModel::updateOrCreate(
            ['id' => $request->id],
            [
                'class_name' => $request->class_name,
            ]
        );

        return response()->json($class);
    }

    public function destroy($id)
    {
        $class = ClassModel::findOrFail($id);
        $class->delete();

        return response()->json(['message' => 'Class deleted successfully.']);
    }

    public function showClassDetails(string $id)
    {
        // Find the class
        $class = ClassModel::findOrFail($id);

        // Get all subjects for this class
        $subjects = Subject::where('class_id', $id)
            ->orderBy('subject_name')
            ->get([
                'id',
                'subject_name',
                'total_marks',
                'created_at',
            ]);

        // Render the details page
        return Inertia::render('Classes/ClassDetails', [
            'record' => [
                'id' => $class->id,
                'class_name' => $class->class_name,
                'type' => 'Class',
            ],
            'subjects' => $subjects,
            'totals' => [
                'total_subjects' => $subjects->count(),
                'total_marks' => $subjects->sum('total_marks'),
            ],
        ]);
    }
public function list()
{
    return response()->json(
        \App\Models\ClassModel::select('id as value', 'class_name as label')->get()
    );
}


// app/Http/Controllers/ClassController.php

public function cards()
{
    // loads id, class_name and students_count (0 if none)
    $classes = \App\Models\ClassModel::select('id','class_name')
              ->withCount('students')
              ->orderBy('class_name')
              ->get();

    return response()->json($classes);
}


}
