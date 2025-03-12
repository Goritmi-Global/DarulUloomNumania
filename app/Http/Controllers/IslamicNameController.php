<?php

namespace App\Http\Controllers;

use App\Models\IslamicName;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;
class IslamicNameController extends Controller
{
    public function index()
    {
        return Inertia::render('IslamicNames/Index');
    }
 
    public function fetch()
    {
        return IslamicName::all();
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'meaning' => 'required|string',
            'roman' => 'required|string|max:255',
            'inflection' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'reference' => 'required|string',
        ]);

        if($request->id)
        {
            $islamicName = IslamicName::findOrFail($request->id);
        }else
        {

            $islamicName = new IslamicName();
            $islamicName->id = Str::orderedUuid();
        }   
        $islamicName->fill($request->all());
        $islamicName->save();

        return response()->json(['message' => 'Islamic Name saved successfully.'], 200);
    }
  
    public function destroy($id)
    {
        IslamicName::findOrFail($id)->delete();
        return response()->json(['message' => 'Islamic Name deleted successfully.'], 200);
    }
}
