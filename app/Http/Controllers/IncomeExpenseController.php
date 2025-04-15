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

    // Fetch all expense entries
    public function fetch($process)
    {
        if ($process == 'Expense') {
            $records = ExpenseType::all();
            

        } else {
            $records = IncomeType::all();

        }
        foreach($records as $record)
            {
                $business_type = BusinessType::where('id',$record->business_type)->first();
                if($business_type)
                { 
                    $record->related_business_type = $business_type->name;
                }
                // dd($record->related_business_type);
            }
        return $records;
    }

    // Store or update a expense entry
    public function store(Request $request)
    { 
        $request->validate([
            'name' => 'required|string|max:255',
            'business_type' => 'required',
        ]);

        if ($request->id) {

            if ($request->process == 'Expense') {
                $record = ExpenseType::findOrFail($request->id);

            } else {
                $record = IncomeType::findOrFail($request->id);

            }
        } else {
            if ($request->process == 'Expense') {
                $record = new ExpenseType;

            } else {

                $record = new IncomeType;
            }
            $record->id = Str::orderedUuid(); // Generate UUID for new record
        }

        // Set values
        $record->name = $request->name;
        $record->business_type = $request->business_type;

        // $record->status = 1;

        $record->save();

        return 'success';
    }

    // Display a specific expense entry
    public function show($id, $process)
    {
        if ($process == 'Expense') {

            $record = ExpenseType::findOrFail($id);
        } else {
            $record = IncomeType::findOrFail($id);
        }

        return $record;
    }

    // Delete a specific expense entry
    public function delete($id, $process)
    {
        if ($process == 'Expense') {
            $record = ExpenseType::findOrFail($id);

        } else {
            $record = IncomeType::findOrFail($id);

        }
        $record->delete();
        return 'success';
    }

    public function pluckExpenses()
    {
        $expense = ExpenseType::pluck('name', 'id'); // Pluck should come last
        return response()->json($expense); // Return JSON response
    }
    
    public function pluckIncome()
    {
        $income = IncomeType::pluck('name', 'id'); // Pluck should come last
        return response()->json($income); // Return JSON response
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
