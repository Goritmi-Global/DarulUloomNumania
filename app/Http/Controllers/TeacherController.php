<?php

namespace App\Http\Controllers;

use App\Models\ExpenseType;
use App\Models\IncomeType;
use App\Models\Teacher;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class TeacherController extends Controller
{
    public function index()
    {
        return Inertia::render('Teachers/index');
    }

   public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'designation' => 'nullable|string|max:255',
        'monthly_salary' => 'required|numeric',
        'contact' => 'nullable|string|max:255',
    ]);

    if ($request->id) {
        // 🔹 Update existing teacher
        $teacher = Teacher::findOrFail($request->id);
    } else {
        // 🔹 Create new teacher
        $teacher = new Teacher;
    }

    $teacher->name = $request->name;
    $teacher->designation = $request->designation;
    $teacher->monthly_salary = $request->monthly_salary;
    $teacher->contact = $request->contact;
    $teacher->save();

    return response()->json(['success' => true]);
}

    public function fetch()
    {
        $teachers = Teacher::all();

        return $teachers;
    }

     public function show($id)
    {
        $record = Teacher::findOrFail($id);
        return $record;
    }
public function showTeacherDeatails(string $id)
{
    // Ensure the Advance exists
    $advance = Teacher::findOrFail($id);

    // 1) Collect all transaction_ids from operating_advances_enteries for this advance
    $txIds = DB::table('salaries')
        ->where('advance_type_id', $id)
        ->pluck('transaction_id')
        ->values();

        // dd($txIds);
    // 2) Pull matching transactions (if none, you'll just get an empty collection)
    $transactions = $txIds->isEmpty()
        ? collect()
        : Transaction::query()
            ->whereIn('id', $txIds)
            ->with('salary')
            ->orderByDesc('transaction_date')
            ->get([
                'id',
                'transaction_date',
                'islamic_date',
                'ref_no',
                'method',
                'received_from',
                'received_by',
                'remarks',
                'cash_in',
                'cash_out',
                'transaction_type',
            ]);
           
    // 3) Totals
    $totalIn  = (int) $transactions->sum('cash_in');
    $totalOut = (int) $transactions->sum('cash_out');

    // 4) Render
    return Inertia::render('Teachers/TeacherDetails', [
        'record' => [
            'id'          => $advance->id,
            'name'        => $advance->name,
            'designation' => $advance->designation ?? null,
            'contact'     => $advance->contact ?? null,
            'type'        => 'Advance',
        ],
        'transactions' => $transactions,
        'totals' => [
            'in'  => $totalIn,
            'out' => $totalOut,
            'net' => $totalIn - $totalOut,
        ],
    ]);
}

}
