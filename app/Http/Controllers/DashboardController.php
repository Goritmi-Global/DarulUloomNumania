<?php
namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\ExpenseType;
use App\Models\Income;
use App\Models\IncomeType;
use App\Models\Transaction;
use Inertia\Inertia;
use Carbon\Carbon;
use App\Models\MoneyGivenTo;
use App\Models\MoneyTakenFrom;
use App\Models\Person;
use App\Models\Upload;
use App\Models\BusinessType;

class DashboardController extends Controller
{
    public function index()
    {
        return Inertia::render('Dashboard/Index');
    }
    public function create()
    {
        return Inertia::render('Dashboard/Create', [
            'title' => "Create new Events",
        ]);
    }
    public function dashboard_fetch()
    {
        $transactions = Transaction::orderByDesc('transaction_date')->get();
    
        foreach ($transactions as $transaction) {
            // Initialize cash_in and cash_out
            $transaction->cash_in = 0;
            $transaction->cash_out = 0;
    
            // Check transaction type and assign cash flow accordingly
            switch ($transaction->transaction_type) {
                case 'Expense':
                    $expense = Expense::where('transaction_id', $transaction->id)->first();
                    if ($expense) {
                        $transaction->cash_out = $expense->amount;
                    }
                    break;
    
                case 'Income':
                    $income = Income::where('transaction_id', $transaction->id)->first();
                    if ($income) {
                        $transaction->cash_in = $income->amount;
                    }
                    break;
    
                case 'Lend':
                    $moneyGiven = MoneyGivenTo::where('transaction_id', $transaction->id)->first();
                    if ($moneyGiven) {
                        $transaction->cash_out = $moneyGiven->amount;
                    }
                    break;
    
                case 'Borrow':
                    $moneyTaken = MoneyTakenFrom::where('transaction_id', $transaction->id)->first();
                    if ($moneyTaken) {
                        $transaction->cash_in = $moneyTaken->amount;
                    }
                    break;
            }
    
            // Format transaction date
            $transaction->transaction_date = Carbon::parse($transaction->transaction_date)->format('Y-m-d');
    
            // Handle receipt image
            if ($transaction->receipt_image) {
                $upload = Upload::where('id', $transaction->receipt_image)->first();
                $transaction->receipt_image = $upload ? getFileUrl($upload->file_name) : null;
            }
        }
    
        return $transactions;
    }
    

    public function income_details()
    {
        // Step 1: Get the total income of all types combined
        $total_income = Income::join('transactions', 'transactions.id', '=', 'incomes.transaction_id')
            ->sum('transactions.cash_in');

        // Step 2: Group incomes by income type and sum amounts in one query
        $incomeTypes = Income::join('transactions', 'transactions.id', '=', 'incomes.transaction_id')
            ->selectRaw('incomes.income_type_id, SUM(transactions.cash_in) as total_income_type')
            ->groupBy('incomes.income_type_id')
            ->get();

        // Step 3: Attach income type details and calculate percentages
        $incomeTypes = $incomeTypes->map(function ($incomeType) use ($total_income) {
            $type = IncomeType::find($incomeType->income_type_id);
            return [
                'id'                  => $type->id,
                'name'                => $type->name,
                'total_income_type'   => number_format($incomeType->total_income_type, 2), // Format amount
                'percentage_of_total' => number_format(
                    $total_income > 0
                    ? ($incomeType->total_income_type / $total_income) * 100
                    : 0,
                    2
                ), // Format percentage
            ];

        });

        return response()->json([
            'total_income' => number_format($total_income, 2), 
            'income_types' => $incomeTypes,
        ]);
    }

    public function expense_details()
{
    // Step 1: Get the total expense of all types combined
    $total_expense = Expense::join('transactions', 'transactions.id', '=', 'expenses.transaction_id')
        ->sum('transactions.cash_out');

    // Step 2: Group expenses by expense type and sum amounts in one query
    $expenseTypes = Expense::join('transactions', 'transactions.id', '=', 'expenses.transaction_id')
        ->selectRaw('expenses.expense_type_id, SUM(transactions.cash_out) as total_expense_type')
        ->groupBy('expenses.expense_type_id')
        ->get();

    // Step 3: Attach expense type details and calculate percentages
    $expenseTypes = $expenseTypes->map(function ($expenseType) use ($total_expense) {
        $type = ExpenseType::find($expenseType->expense_type_id);
        return [
            'id'                  => $type->id,
            'name'                => $type->name,
            'total_expense_type'   => number_format($expenseType->total_expense_type, 2), // Format amount
            'percentage_of_total' => number_format(
                $total_expense > 0
                ? ($expenseType->total_expense_type / $total_expense) * 100
                : 0,
                2
            ), // Format percentage
        ];
    });

    return response()->json([
        'total_expense' => number_format($total_expense, 2),
        'expense_types' => $expenseTypes,
    ]);
}


}
