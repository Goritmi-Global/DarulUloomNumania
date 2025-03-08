<?php

namespace App\Http\Controllers;

use App\Models\BusinessType;
use App\Models\Person;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CommonDataController extends Controller
{
    public function indexBusinessTypes()
    {
        return Inertia::render('CommonData/BusinessType');
    }
    public function indexPersonTypes()
    {
        return Inertia::render('CommonData/Persons');
    }
    // Store or Update Business Type
    public function saveBusinessType(Request $request)
    {
        $request->validate(['name'=>'required']);
        
        $businessType = $request->id ? BusinessType::find($request->id) : new BusinessType();

        if (!$businessType) {
            return response()->json(['message' => 'Business Type not found'], 404);
        }

        $businessType->name = $request->name;
        $businessType->save();

        return response()->json(['message' => 'Business Type saved successfully', 'data' => $businessType]);
    }

    // Fetch All Business Types
    public function getAllBusinessTypes()
    {
        return response()->json(BusinessType::all());
    }

    // Delete Business Type
    public function deleteBusinessType($id)
    {
        $businessType = BusinessType::find($id);

        if (!$businessType) {
            return response()->json(['message' => 'Business Type not found'], 404);
        }

        $businessType->delete();
        return response()->json(['message' => 'Business Type deleted successfully']);
    }

    // Pluck Business Types (ID => Name)
    public function pluckBusinessTypes()
    {
        return response()->json(BusinessType::pluck('name', 'id'));
    }

    // Store or Update Person
    public function savePerson(Request $request)
    {
        $request->validate(['name'=>'required','contact'=>'required']);
        $person = $request->id ? Person::find($request->id) : new Person();

        if (!$person) {
            return response()->json(['message' => 'Person not found'], 404);
        }

        $person->name = $request->name;
        $person->contact = $request->contact;
        $person->save();

        return response()->json(['message' => 'Person saved successfully', 'data' => $person]);
    }

    // Fetch All Persons
    public function getAllPersons()
    {
        return response()->json(Person::all());
    }

    // Delete Person
    public function deletePerson($id)
    {
        $person = Person::find($id);

        if (!$person) {
            return response()->json(['message' => 'Person not found'], 404);
        }

        $person->delete();
        return response()->json(['message' => 'Person deleted successfully']);
    }

    // Pluck Persons (ID => Name)
    public function pluckPersons()
    {
        return response()->json(Person::pluck('name', 'id'));
    }
}
