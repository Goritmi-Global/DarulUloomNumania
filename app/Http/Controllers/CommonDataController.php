<?php

namespace App\Http\Controllers;

use App\Models\BusinessType;
use App\Models\Person;
use Illuminate\Http\Request;
use App\Models\MoneyGivenTo;
use App\Models\MoneyTakenFrom;
use Inertia\Inertia;
use Illuminate\Support\Str;

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
    public function person_details($id)
    {
        // Fetch person details
        $person = Person::find($id);
    
        if (!$person) {
            return redirect()->back()->with('error', 'Person not found');
        }
    
        // Fetch transactions related to the person
        $moneyTaken = MoneyTakenFrom::where('person_id', $id)->get();
        if($moneyTaken)
        {

            foreach($moneyTaken as $singleRecord)
            {
                $singleRecord->credit = '1';
                $singleRecord->debit = '0';
            }
        }
    
        $moneyGiven = MoneyGivenTo::where('person_id', $id)->get();
        if($moneyGiven)
        {

            foreach($moneyGiven as $singleRecord)
            {
                $singleRecord->credit = '0';
                $singleRecord->debit = '1';
            }
        }
        // Merge and sort by created_at
        $ledger = $moneyTaken->merge($moneyGiven)->sortBy('created_at')->values();
    
 
        return Inertia::render('CommonData/PersonDetails', [
            'person_name' => $person->name,
            'ledger' => $ledger
        ]);
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
