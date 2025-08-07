<?php
namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\ExpenseType;
use App\Models\Income;
use App\Models\IncomeType;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;
use App\Models\BusinessType;
use App\Models\Person;
use App\Models\OperatingAdvance;


class IncomeExpenseController extends Controller
{
    // Display the expense index view
    public function expense_index()
    {
        return Inertia::render('Expense/Index');
    }
    public function income_index()
    {
        return Inertia::render('Income/Index');
    }

    public function operating_advance_index()
    {
        return Inertia::render('OperatingAdvance/Index');
    }


    // Fetch all expense entries
    public function fetch($process)
    {
        if ($process == 'Expense') {
            $records = ExpenseType::all();
        } elseif ($process == 'Income') {
            $records = IncomeType::all();
        } else {
            $records = OperatingAdvance::all();
        }

        return $records;
    }

    // Store or update a expense entry
    public function store(Request $request)
    { 
        $request->validate([
            'name' => 'required|string|max:255', 
            'designation' => 'nullable|string|max:255',
            'contact' => 'nullable|string|max:255',
        ]);

        if ($request->id) {
            if ($request->process == 'Expense') {
                $record = ExpenseType::findOrFail($request->id);
            } elseif ($request->process == 'Income') {
                $record = IncomeType::findOrFail($request->id);
            } else {
                $record = OperatingAdvance::findOrFail($request->id);
            }
        } else {
            if ($request->process == 'Expense') {
                $record = new ExpenseType;
            } elseif ($request->process == 'Income') {
                $record = new IncomeType;
            } else {
                $record = new OperatingAdvance;
            }
            $record->id = Str::orderedUuid(); // UUID
        }

        $record->name = $request->name;
        if ($request->has('designation')) $record->designation = $request->designation;
        if ($request->has('contact')) $record->contact = $request->contact;

        $record->save();
        return 'success';
    }


    // Display a specific expense entry
    public function show($id, $process)
    {
        if ($process == 'Expense') {
            $record = ExpenseType::findOrFail($id);
        } elseif ($process == 'Income') {
            $record = IncomeType::findOrFail($id);
        } else {
            $record = OperatingAdvance::findOrFail($id);
        }

        return $record;
    }


    // Delete a specific expense entry
    public function delete($id, $process)
    {
        if ($process == 'Expense') {
            $record = ExpenseType::findOrFail($id);
        } elseif ($process == 'Income') {
            $record = IncomeType::findOrFail($id);
        } else {
            $record = OperatingAdvance::findOrFail($id);
        }

        $record->delete();
        return 'success';
    }


    public function pluckExpenses()
    {
        $expense = ExpenseType::pluck('name', 'id'); // Pluck should come last
        return response()->json($expense); // Return JSON response
    }
    
    public function pluckAdvance()
    {
        $advance = OperatingAdvance::pluck('name', 'id');
        return response()->json($advance);
    }

    public function pluckIncome()
    {
        $income = IncomeType::pluck('name', 'id'); // Pluck should come last
        return response()->json($income); // Return JSON response
    }
    
    public function pluckOperatingAdvance()
    {
        $data = OperatingAdvance::pluck('name', 'id');
        return response()->json($data);
    }



    public function income_expense_details($type, $id)
    {

        if ($type == 'Expense') {
            $expense_type = ExpenseType::where('id',$id)->first();
            $expense_type_name = $expense_type->name;
            $records = Expense::where('expense_type_id', $id)->get();
            return Inertia::render('Expense/Details', ['expense_records' => $records,'expense_type_name'=>$expense_type_name]);

        }

        if ($type == 'Income') {
            $income_type = IncomeType::where('id',$id)->first();
            $income_type_name = $income_type->name;
            $records = Income::where('income_type_id', $id)->get();
            return Inertia::render('Income/Details', ['income_records' => $records,'income_type_name'=>$income_type_name]);
        }

    }
}
