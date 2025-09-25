<?php

namespace App\Http\Controllers;

use App\Models\Hostel;
use Illuminate\Http\Request;
use Inertia\Inertia;

class HostelController extends Controller
{
    public function index()
    {
        return inertia::render('Hostels/index');
    }

    public function fetch()
    {
        return response()->json(Hostel::all());
    }

    public function show($id)
    {
        return response()->json(Hostel::findOrFail($id));
    }

    public function store(Request $request)
    {
        $request->validate([
            'hostel_name' => 'required|string|max:255|unique:hostels,hostel_name,'.$request->id,
            'contact_number' => 'nullable|string|max:20',
        ]);

        $hostel = Hostel::updateOrCreate(
            ['id' => $request->id],
            [
                'hostel_name' => $request->hostel_name,
                'contact_number' => $request->contact_number,
            ]
        );

        return response()->json($hostel);
    }

    public function destroy($id)
    {
        $hostel = Hostel::findOrFail($id);
        $hostel->delete();

        return response()->json(['message' => 'Hostel deleted successfully.']);
    }
}
