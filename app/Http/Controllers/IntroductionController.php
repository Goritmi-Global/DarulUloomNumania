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
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
        ]);
        if ($request->id) {
            $record = Introduction::where('id',$request->id)->first();
        } else {
            
            $record     = new Introduction();
            $record->id = Str::orderedUuid();
        }
        $record->title       = $request->title;
        $record->description = $request->description;
        $record->save();
        return response()->json(['message' => 'Islamic Name saved successfully.'], 200);

        return 'success';
    }

    public function destroy($id)
    {
        Introduction::findOrFail($id)->delete();
        return response()->json(['message' => 'Introduction deleted successfully.'], 200);
    }
}
