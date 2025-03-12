<?php 

namespace App\Http\Controllers;

use App\Models\Introduction;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;

class IntroductionController extends Controller
{
    public function index()
    {
        $introductions = Introduction::all();
        return Inertia::render('Introduction/Index');
    }
    public function fetch()
    {
        $introductions = Introduction::all();
        return $introductions;
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $record = new Introduction();
        $record->id = Str::orderedUuid();
        $record->title = $request->title;
        $record->description = $request->description;
        $record->save();

        return response()->json(['message' => 'Introduction saved successfully.'], 200);
    }

    public function show($id)
    {
        $record = Introduction::findOrFail($id);
        return response()->json($record);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $record = Introduction::findOrFail($id);
        $record->title = $request->title;
        $record->description = $request->description;
        $record->save();

        return response()->json(['message' => 'Introduction updated successfully.'], 200);
    }

    public function destroy($id)
    {
        Introduction::findOrFail($id)->delete();
        return response()->json(['message' => 'Introduction deleted successfully.'], 200);
    }
}

