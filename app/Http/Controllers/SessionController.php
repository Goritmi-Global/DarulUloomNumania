<?php

namespace App\Http\Controllers;

use App\Models\Session;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SessionController extends Controller
{
    public function index()
    {
        return inertia::render('Sessions/index');
    }

     public function fetch()
    {
        return response()->json(Session::all());
    }

    public function show($id)
    {
        return response()->json(Session::findOrFail($id));
    }

    public function store(Request $request)
    {
        $request->validate([
            'data' => 'required|string|unique:sessions,data,'.$request->id,
            'status' => 'required|boolean',
        ]);

        $session = Session::updateOrCreate(
            ['id' => $request->id],
            [
                'data' => $request->data,
                'status' => $request->status,
            ]
        );

        return response()->json($session, 201);
    }
}
