<?php
namespace App\Http\Controllers;

use App\Models\Bayanaat;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;

class BayanaatController extends Controller
{
    public function index()
    {
        return Inertia::render('Bayanaat/Index');
    }
    public function fetch()
    {
        return Bayanaat::all();
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'        => 'required|string|max:255',
            'author'       => 'required|string|max:255',
            'islamic_date' => 'required|string|max:255',
            'english_date' => 'required|date',
            // 'content' => 'required|string'
        ]);

        if ($request->id) {
            $bayanaat = Bayanaat::findOrFail($request->id);
        } else {

            $bayanaat     = new Bayanaat();
            $bayanaat->id = Str::orderedUuid();
        }
        $bayanaat->title        = $request->title;
        $bayanaat->author       = $request->author;
        $bayanaat->islamic_date = $request->islamic_date;
        $bayanaat->english_date = $request->english_date;
        $bayanaat->content      = $request->content;
        $bayanaat->save();

        return response()->json(['message' => 'Bayanaat saved successfully.'], 200);
    }

    public function destroy($id)
    {
        Bayanaat::findOrFail($id)->delete();
        return response()->json(['message' => 'Bayanaat deleted successfully.'], 200);
    }
}
