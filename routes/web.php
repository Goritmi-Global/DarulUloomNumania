<?php

use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\BayanaatController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\ClassController;
use App\Http\Controllers\CommonDataController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExternalWebstieController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\HostelController;
use App\Http\Controllers\IncomeExpenseController;
use App\Http\Controllers\IncomeStatementController;
use App\Http\Controllers\IntroductionController;
use App\Http\Controllers\IslamicNameController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\QuestionAnswerController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ResultController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\StudentsController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\TransactionController;
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

    return 'Storage link has been created successfully!';
});

Route::get('/login', [HomeController::class, 'index'])->name('login');
Route::get('/policy/and/privacy', [HomeController::class, 'privacyPolicy'])->name('privacy.policy');

// Authenticated routes
Route::middleware(['auth:sanctum'])->group(function () {

    // 👤 General Authenticated Access (e.g. everyone logged in)
    Route::get('/profile', [UserController::class, 'profile'])->name('profile');
    Route::get('/profile/show/{id}', [UserController::class, 'profile_show'])->name('api.profile.show');
    Route::post('/profile/update', [UserController::class, 'profile_update'])->name('api.profile.update');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // 👑 Super Admin Access to Everything
    Route::middleware(['role.superadmin'])->group(function () {

        // 👑 Users Management
        Route::get('/users', [UserController::class, 'index'])->name('users');

        // 💼 Accountant Routes
        Route::get('/transactions', [TransactionController::class, 'Index'])->name('transactions');
        Route::get('/expense/types', [IncomeExpenseController::class, 'expense_index'])->name('expense.types');
        Route::get('/income/expense/details/{type}/{id}', [IncomeExpenseController::class, 'income_expense_details'])->name('income.expanse.details');
        Route::get('/income/types', [IncomeExpenseController::class, 'income_index'])->name('income.types');
        Route::get('/reports', [ReportController::class, 'index'])->name('reports');
        Route::get('/income-statements', [IncomeStatementController::class, 'index'])->name('income-statements');
        Route::post('/download-pdf', [TransactionController::class, 'transactions_pdf_download'])->name('download-pdf');
        Route::post('/download-report-pdf', [ReportController::class, 'report_pdf_download'])->name('download-report-pdf');
        Route::post('/download-excel', [TransactionController::class, 'transactions_exportTo_excel'])->name('download-excel');
        Route::post('/download-report-excel', [ReportController::class, 'report_exportTo_excel'])->name('download-report-excel');
        Route::post('/download-income-statement-pdf', [IncomeStatementController::class, 'downloadIncomeStatementPDF'])->name('download-income-statement-pdf');

        Route::get('/operating/advance', [IncomeExpenseController::class, 'operating_advance_index'])->name('operating.advance');

        Route::get('/operating-advance/{id}', [IncomeExpenseController::class, 'operating_advance_show'])
            ->whereUuid('id')
            ->name('operating_advance.show');

        // 🏫 Admission Officer Routes
        Route::get('/students', [StudentsController::class, 'index'])->name('students');
        Route::get('/enrolled-students', [StudentsController::class, 'EnrolledStudents'])->name('enrolled-students');
        Route::get('/enroll-new-students', [StudentsController::class, 'enroll_new_students'])->name('enroll-new-students');
        Route::get('/student/details/{id}', [StudentsController::class, 'details'])->name('student.details');
        Route::get('/student/payment/details/{id}', [StudentsController::class, 'student_payement_details'])->name('student.payment.details');
        Route::get('/student/show/{id}', [StudentsController::class, 'show'])->name('student.show');
        Route::get('/download/pdf/{student_id}/{slip_id}', [StudentsController::class, 'download_student_enrollment_pdf'])->name('download.pdf');
        Route::get('/print/pdf/{student_id}/{slip_id}', [StudentsController::class, 'print_student_enrollment_pdf'])->name('print.pdf');
        Route::get('/student/details/pdf/print/{student_id}/{process}', [StudentsController::class, 'download_print_student_details_pdf'])->name('student.details.pdf.print');

        // Routes for Teacher
        Route::get('/teachers', [TeacherController::class, 'index'])->name('teachers');
        Route::get('/teachers/{id}', [TeacherController::class, 'showTeacherDeatails'])->name('teachers.show');

        // Route for Session
        Route::get('/sessions', [SessionController::class, 'index'])->name('sessions');

        // Route for Hostel
        Route::get('/hostels', [HostelController::class, 'index'])->name('hostels');
        // Rout for Attendance
        Route::get('/attendances', [AttendanceController::class, 'index'])->name('attendances');
        Route::get('/attendance/class/{id}', [AttendanceController::class, 'showClassStudents'])
            ->name('attendance.class.show');

        // Route for Result
        Route::get('/results', [ResultController::class, 'index'])->name('results');
        Route::get('/results/class/{id}', [ResultController::class, 'showClassResults'])->name('results.class.show');

        // Route for Class
        Route::prefix('classes')->name('classes.')->group(function () {
            Route::get('/', [ClassController::class, 'index'])->name('index');
            Route::get('{id}', [ClassController::class, 'showClassDetails'])->name('show');
        });

        // 📚 Iftah Manager Routes
        Route::get('/introduction', [IntroductionController::class, 'index'])->name('introduction');
        Route::get('/books', [BookController::class, 'index'])->name('books');
        Route::get('/bayanaat', [BayanaatController::class, 'index'])->name('bayanaat');
        Route::get('/islamic-names', [IslamicNameController::class, 'index'])->name('islamic.names');
        Route::get('/questions-answers', [QuestionAnswerController::class, 'index'])->name('questions.answers');
    });

    // 💼 Accountant Routes
    Route::middleware(['role.accountant'])->group(function () {
        Route::get('/transactions', [TransactionController::class, 'Index'])->name('transactions');
        Route::get('/expense/types', [IncomeExpenseController::class, 'expense_index'])->name('expense.types');
        Route::get('/income/expense/details/{type}/{id}', [IncomeExpenseController::class, 'income_expense_details'])->name('income.expanse.details');
        Route::get('/income/types', [IncomeExpenseController::class, 'income_index'])->name('income.types');
        Route::get('/reports', [ReportController::class, 'index'])->name('reports');
        Route::get('/income-statements', [IncomeStatementController::class, 'index'])->name('income-statements');
        Route::post('/download-pdf', [TransactionController::class, 'transactions_pdf_download'])->name('download-pdf');
        Route::post('/download-report-pdf', [ReportController::class, 'report_pdf_download'])->name('download-report-pdf');
        Route::post('/download-excel', [TransactionController::class, 'transactions_exportTo_excel'])->name('download-excel');
        Route::post('/download-report-excel', [ReportController::class, 'report_exportTo_excel'])->name('download-report-excel');
        Route::post('/download-income-statement-pdf', [IncomeStatementController::class, 'downloadIncomeStatementPDF'])->name('download-income-statement-pdf');
    });

    // 🌍 Common Data (Optional: Use 'admin' or others if needed)
    Route::get('/business/types', [CommonDataController::class, 'indexBusinessTypes'])->name('business.types');
    Route::get('/businsess/type/details/{id}', [CommonDataController::class, 'businsess_type_details'])->name('businsess.type.details');
    Route::get('/person/details/{id}', [CommonDataController::class, 'person_details'])->name('person.details');
    Route::get('/loan-management', [CommonDataController::class, 'indexPersonTypes'])->name('loan-management');

    // 🏫 Admission Officer Routes
    Route::middleware(['role.admission'])->group(function () {
        Route::get('/students', [StudentsController::class, 'index'])->name('students');
        Route::get('/enrolled-students', [StudentsController::class, 'EnrolledStudents'])->name('enrolled-students');
        Route::get('/alreadyEnrolled-students', [StudentsController::class, 'AlreadyEnrolledStudents'])->name('alreadyEnrolled-students');
        Route::get('/enroll-new-students', [StudentsController::class, 'enroll_new_students'])->name('enroll-new-students');
        Route::get('/student/details/{id}', [StudentsController::class, 'details'])->name('student.details');
        Route::get('/student/payment/details/{id}', [StudentsController::class, 'student_payement_details'])->name('student.payment.details');
        Route::get('/student/show/{id}', [StudentsController::class, 'show'])->name('student.show');
        Route::get('/download/pdf/{student_id}/{slip_id}', [StudentsController::class, 'download_student_enrollment_pdf'])->name('download.pdf');
        Route::get('/print/pdf/{student_id}/{slip_id}', [StudentsController::class, 'print_student_enrollment_pdf'])->name('print.pdf');
        Route::get('/student/details/pdf/print/{student_id}/{process}', [StudentsController::class, 'download_print_student_details_pdf'])->name('student.details.pdf.print');
    });

    // 📚 Iftah Manager Routes
    Route::middleware(['role.iftah'])->group(function () {
        Route::get('/introduction', [IntroductionController::class, 'index'])->name('introduction');
        Route::get('/books', [BookController::class, 'index'])->name('books');
        Route::get('/bayanaat', [BayanaatController::class, 'index'])->name('bayanaat');
        Route::get('/islamic-names', [IslamicNameController::class, 'index'])->name('islamic.names');
        Route::get('/questions-answers', [QuestionAnswerController::class, 'index'])->name('questions.answers');
    });

    // 🌐 Language Management (Optional: Assign role.admin or similar if needed)
    Route::get('/languages', [LanguageController::class, 'index'])->name('languages');
    Route::get('/languages/add', [LanguageController::class, 'languages_add'])->name('languages.add');
    Route::get('/languages/edit/{id}', [LanguageController::class, 'languages_edit'])->name('languages.edit');
    Route::get('/translations/show/{id}', [LanguageController::class, 'translations_show'])->name('translations.show');
});

Route::get('/student/enroll', [StudentsController::class, 'create'])->name('student.enroll');
Route::get('/', [ExternalWebstieController::class, 'Index'])->name('/');
Route::get('/about', [ExternalWebstieController::class, 'about'])->name('/about');
Route::get('/events', [ExternalWebstieController::class, 'events'])->name('/events');
Route::get('/contact', [ExternalWebstieController::class, 'contact'])->name('/contact');
Route::get('/ask/question', [QuestionAnswerController::class, 'ask_question'])->name('ask.question');


Route::get('/courses/enroll', [SubjectController::class, 'getCourses'])->name('get.courses');
