<?php

use App\Http\Controllers\CommonDataController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\IncomeExpenseController;
use App\Http\Controllers\IncomeStatementController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\StudentsController;
use App\Http\Controllers\TransactionController;

use App\Http\Controllers\IntroductionController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\BayanaatController;
use App\Http\Controllers\IslamicNameController;
use App\Http\Controllers\QuestionAnswerController;

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
 */

Route::get('/storage-link', function () {
    Artisan::call('storage:link');
    return "Storage link has been created successfully!";
});

Route::get('/', [HomeController::class, 'index'])->name('/');

Route::get('/login', [HomeController::class, 'index'])->name('login');

Route::middleware(['auth:sanctum'])->group(function () {

    Route::get('/profile', [UserController::class, 'profile'])->name('profile');
    Route::get('/profile/show/{id}', [UserController::class, 'profile_show'])->name('api.profile.show');
    Route::post('/profile/update', [UserController::class, 'profile_update'])->name('api.profile.update');
    // Dashboard Routes
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile Routes
    Route::get('/users', [UserController::class, 'index'])->name('users');
    // Admissions

    //  Cashbook
    Route::get('/transactions', [TransactionController::class, 'Index'])->name('transactions');
    //  Banks
    Route::get('/banks', [BankController::class, 'Index'])->name('banks');
    //  Accounts
    Route::get('/accounts', [AccountController::class, 'index'])->name('accounts');
    //  Accounts
    Route::get('/expense/types', [IncomeExpenseController::class, 'expense_index'])->name('expense.types');
    Route::get('/income/expense/details/{type}/{id}', [IncomeExpenseController::class, 'income_expense_details'])->name('income.expanse.details');
    Route::get('/income/types', [IncomeExpenseController::class, 'income_index'])->name('income.types');
    //  reports
    Route::get('/reports', [ReportController::class, 'index'])->name('reports');
    //  reports
    Route::get('/income-statements', [IncomeStatementController::class, 'index'])->name('income-statements');

    // Business Types
    Route::get('/business/types', [CommonDataController::class, 'indexBusinessTypes'])->name('business.types');
    Route::get('/businsess/type/details/{id}', [CommonDataController::class, 'businsess_type_details'])->name('businsess.type.details');
    Route::get('/person/details/{id}', [CommonDataController::class, 'person_details'])->name('person.details');
    // Persons
    Route::get('/loan-management', [CommonDataController::class, 'indexPersonTypes'])->name('loan-management');

    // data saving routes
    Route::post('/download-pdf', [TransactionController::class, 'transactions_pdf_download'])->name('download-pdf');
    Route::post('/download-report-pdf', [ReportController::class, 'report_pdf_download'])->name('download-report-pdf');
    Route::post('/download-excel', [TransactionController::class, 'transactions_exportTo_excel'])->name('download-excel');
    Route::post('/download-report-excel', [ReportController::class, 'report_exportTo_excel'])->name('download-report-excel');
    Route::post('/download-income-statement-pdf', [IncomeStatementController::class, 'downloadIncomeStatementPDF'])->name('download-income-statement-pdf');

    // languages Routes
    Route::get('/languages', [LanguageController::class, 'index'])->name('languages');
    Route::get('/languages/add', [LanguageController::class, 'languages_add'])->name('languages.add');
    Route::get('/languages/edit/{id}', [LanguageController::class, 'languages_edit'])->name('languages.edit');
    Route::get('/translations/show/{id}', [LanguageController::class, 'translations_show'])->name('translations.show');

// Student Routes
    Route::get('/students', [StudentsController::class, 'index'])->name('students');
    Route::get('/student/details/{id}', [StudentsController::class, 'details'])->name('student.details');
    Route::get('/student/payment/details/{id}', [StudentsController::class, 'student_payement_details'])->name('student.payment.details');
    Route::get('/student/edit/{id}', [StudentsController::class, 'edit'])->name('student.edit');

    Route::get('/download/pdf/{student_id}/{slip_id}', [StudentsController::class, 'download_student_enrollment_pdf'])->name('download.pdf');

    Route::get('/print/pdf/{student_id}/{slip_id}', [StudentsController::class, 'print_student_enrollment_pdf'])->name('print.pdf');

// Route::get('/student/details/pdf/download/{student_id}', [StudentsController::class, 'download_student_details_pdf'])->name('student.details.pdf.download');

    Route::get('/student/details/pdf/print/{student_id}/{process}', [StudentsController::class, 'download_print_student_details_pdf'])->name('student.details.pdf.print');

   
    
    Route::get('/introduction', [IntroductionController::class, 'index'])->name('introduction');
    Route::get('/books', [BookController::class, 'index'])->name('books');
    Route::get('/bayanaat', [BayanaatController::class, 'index'])->name('bayanaat');
    Route::get('/islamic-names', [IslamicNameController::class, 'index'])->name('islamic.names');
    Route::get('/questions-answers', [QuestionAnswerController::class, 'index'])->name('questions.answers');
    



});
