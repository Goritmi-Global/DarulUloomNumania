<?php

use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\BayanaatController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\ClassController;
use App\Http\Controllers\CommonDataController;
use App\Http\Controllers\DashboardController;
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
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
 */

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('/countries/pluck', [HomeController::class, 'countries_pluck'])->name('api.countries.pluck');
Route::get('/countries/code/pluck', [HomeController::class, 'countriesWithCodePluck'])->name('api.countries.code.pluck');
Route::get('/states/pluck/{country_of_birth_id}', [HomeController::class, 'states_pluck'])->name('api.states.pluck');
Route::get('/cities/pluck/{state_id}', [HomeController::class, 'cities_pluck'])->name('api.cities.pluck');

Route::get('/translate', [LanguageController::class, 'translate'])->name('api.translate');
Route::post('/missing/translations/store', [LanguageController::class, 'missing_translations_store'])->name('api.missing-translations.store');

Route::post('login', [HomeController::class, 'login'])->name('api.login');
Route::middleware(['web'])->group(function () {
    Route::post('/logout', [HomeController::class, 'logout_user'])->name('api.logout');

    Route::get('/dashbaord/transaction/fetch', [DashboardController::class, 'dashboard_fetch'])->name('api.dashbaord.transaction.fetch');
    Route::get('/dashbaord/income/details/fetch', [DashboardController::class, 'income_details'])->name('api.dashboard.income.details.fetch');
    Route::get('/dashbaord/expense/details/fetch', [DashboardController::class, 'expense_details'])->name('api.dashboard.expense.details.fetch');
    // Fetch all transaction entries
    // Users Api
    Route::get('/users/fetch', [UserController::class, 'users_fetch'])->name('api.users.fetch');
    Route::post('/users/store', [UserController::class, 'store'])->name('api.users.store');
    Route::delete('/users/delete/{id}', [UserController::class, 'delete'])->name('api.users.delete');
    Route::get('/users/show/{id}', [UserController::class, 'show'])->name('api.users.show');
    Route::post('/users/update', [UserController::class, 'users_update'])->name('api.users.update');

    // Students...
    Route::get('/students/fetch', [StudentsController::class, 'students'])->name('api.students.fetch');
    Route::get('/accepted/students/fetch', [StudentsController::class, 'enrolled_students'])->name('api.accepted.students.fetch');
    Route::post('/students/update-status', [StudentsController::class, 'updateStatus'])->name('api.students.updateStatus');

    Route::delete('/students/delete/{id}', [StudentsController::class, 'delete'])->name('api.students.delete');

    // teachers Routes
    Route::post('/teachers/store', [TeacherController::class, 'store'])->name('api.teachers.store');
    Route::get('/teachers/fetch', [TeacherController::class, 'fetch'])->name('api.teachers.fetch');
    Route::get('/teachers/{id}', [TeacherController::class, 'show'])->name('api.teachers.show');

    // Cashbook routes
    Route::post('/transaction/fetch', [TransactionController::class, 'fetch'])->name('api.transaction.fetch');            // Fetch all transaction entries
    Route::post('/transaction/store', [TransactionController::class, 'store'])->name('api.transaction.store');            // Create or update a transaction entry
    Route::get('/transaction/show/{id}', [TransactionController::class, 'show'])->name('api.transaction.show');           // Show a specific transaction entry
    Route::delete('/transaction/delete/{id}', [TransactionController::class, 'destroy'])->name('api.transaction.delete'); // Delete a specific transaction entry
    Route::get('/transaction/pluck', [TransactionController::class, 'pluck'])->name('api.transaction.pluck');             // (Optional) Fetch transaction data for dropdowns or other purposes
    // route for multiple Expense
    Route::post('/transactions/multiple', [TransactionController::class, 'storeMultiple'])
        ->name('api.transaction.storeMultiple');
    // /Income Expense routes
    // Fetch all transaction entries
    Route::post('/income/expense/store', [IncomeExpenseController::class, 'store'])->name('api.income.expense.store');                     // Create or update a transaction entry
    Route::get('/income/expense/fetch/{process}', [IncomeExpenseController::class, 'fetch'])->name('api.income.expense.fetch');            // Fetch all transaction entries
    Route::get('/income/expense/show/{id}/{process}', [IncomeExpenseController::class, 'show'])->name('api.income.expense.show');          // Show a specific transaction entry
    Route::delete('/income/expense/delete/{id}/{process}', [IncomeExpenseController::class, 'delete'])->name('api.income.expense.delete'); // Delete a specific transaction entry
    Route::get('/expense/pluck', [IncomeExpenseController::class, 'pluck'])->name('api.expense.pluck');
    Route::get('/income/pluck/', [IncomeExpenseController::class, 'pluckIncome'])->name('api.income.pluck');
    Route::get('/advance/pluck', [IncomeExpenseController::class, 'pluckAdvance'])->name('api.advance.pluck');
    Route::get('/teacher/pluck', [IncomeExpenseController::class, 'pluckTeacher'])->name('api.teacher.pluck');

    Route::get('/expense/pluck/', [IncomeExpenseController::class, 'pluckExpenses'])->name('api.expense.pluck');

    // session

    Route::prefix('sessions')->name('api.sessions.')->group(function () {
        Route::get('/fetch', [SessionController::class, 'fetch'])->name('fetch');
        Route::get('/show/{id}', [SessionController::class, 'show'])->name('show');
        Route::post('/store', [SessionController::class, 'store'])->name('store');
    });

    // Routes for Hostels
    Route::prefix('hostels')->name('api.hostels.')->group(function () {
        Route::get('/fetch', [HostelController::class, 'fetch'])->name('fetch');
        Route::get('/show/{id}', [HostelController::class, 'show'])->name('show');
        Route::post('/store', [HostelController::class, 'store'])->name('store');
        Route::delete('{id}', [HostelController::class, 'destroy'])->name('destroy');
    });

    // Rouets for Classes
    Route::prefix('classes')->name('api.classes.')->group(function () {
        Route::get('cards', [ClassController::class, 'cards'])->name('cards');    // <- new
        Route::get('list', [ClassController::class, 'list'])->name('list');      // optional
        Route::get('fetch', [ClassController::class, 'fetch'])->name('fetch');
        Route::get('{id}', [ClassController::class, 'show'])->name('show');
        Route::post('store', [ClassController::class, 'store'])->name('store');
        Route::delete('{id}', [ClassController::class, 'destroy'])->name('destroy');
    });

    // Route for attendance

    Route::post('/attendance/mark', [AttendanceController::class, 'store']);

    // Route for Result 
    Route::post('/results/save', [ResultController::class, 'store']);


    Route::prefix('subjects')->name('api.subjects.')->group(function () {
        Route::post('store', [SubjectController::class, 'store'])->name('store');
        Route::delete('{id}', [SubjectController::class, 'destroy'])->name('destroy');
    });
    Route::get('/subjects', [SubjectController::class, 'getSubjects']);

    // Business Type Routes
    Route::post('/business/type/save', [CommonDataController::class, 'saveBusinessType'])->name('api.business.types.store');
    Route::get('/business/types', [CommonDataController::class, 'getAllBusinessTypes'])->name('api.business.types.fetch');
    Route::delete('/business/type/{id}', [CommonDataController::class, 'deleteBusinessType'])->name('api.business.type.delete');
    Route::get('/business/types/pluck', [CommonDataController::class, 'pluckBusinessTypes'])->name('api.business.types.pluck');

    // Person Routes
    Route::post('/person/save', [CommonDataController::class, 'savePerson'])->name('api.person.store');
    Route::get('/persons', [CommonDataController::class, 'getAllPersons'])->name('api.persons.fetch');
    Route::delete('/person/{id}', [CommonDataController::class, 'deletePerson'])->name('api.person.delete');
    Route::get('/persons/pluck', [CommonDataController::class, 'pluckPersons'])->name('api.persons.pluck');

    // reports
    Route::post('/transaction/reports/fetch', [ReportController::class, 'transactions_reports_fetch'])->name('api.transaction.report.fetch');                               // Fetch all transaction entries
    // income statements reports
    Route::post('/transaction/income/statements/fetch', [IncomeStatementController::class, 'transactions_reports_fetch'])->name('api.transaction.income.statements.fetch'); // Fetch all transaction entries

    // languages
    Route::get('/all/languages', [LanguageController::class, 'languages_index'])->name('api.all.languages');
    Route::get('/languages', [LanguageController::class, 'languages'])->name('languages');
    Route::post('/languages/store', [LanguageController::class, 'languages_store'])->name('api.languages.store');
    Route::get('/languages/show/{id}', [LanguageController::class, 'languages_show'])->name('api.languages.show');
    Route::post('/languages/update', [LanguageController::class, 'languages_update'])->name('api.languages.update');
    Route::delete('/languages/delete/{id}', [LanguageController::class, 'languages_delete'])->name('api.languages.delete');

    Route::post('/translations/show', [LanguageController::class, 'translations'])->name('api.translations.show');
    Route::post('/translations/store', [LanguageController::class, 'translations_store'])->name('api.translations.store');
    Route::post('/translations/search', [LanguageController::class, 'translations_search'])->name('api.translations.search');
    Route::delete('/translation/delete/{id}', [LanguageController::class, 'translation_delete'])->name('api.translation.delete');

    // changing default language
    Route::post('/make/default/language', [LanguageController::class, 'make_default_language'])->name('api.make.default.language');
    Route::get('/fetch/default/language', [LanguageController::class, 'fetch_default_language'])->name('api.fetch.default.language');
    Route::get('/languages/data', [LanguageController::class, 'languages_data'])->name('api.languages.data');

    // introduction controller

    Route::prefix('introduction')->group(function () {
        Route::get('/fetch', [IntroductionController::class, 'fetch'])->name('api.introduction.fetch');
        Route::get('/show/{id}', [IntroductionController::class, 'show'])->name('api.introduction.show');
        Route::post('/store', [IntroductionController::class, 'store'])->name('api.introduction.store');
        Route::delete('/delete/{id}', [IntroductionController::class, 'destroy'])->name('api.introduction.delete');
    });

    // Book Controller Routes
    Route::prefix('books')->group(function () {
        Route::get('/', [BookController::class, 'fetch'])->name('api.books.fetch');           // Fetch all books
        Route::post('/', [BookController::class, 'store'])->name('api.books.store');          // Create a book
        Route::get('/{id}', [BookController::class, 'show'])->name('api.books.show');         // Fetch a single book
        Route::put('/{id}', [BookController::class, 'update'])->name('api.books.update');     // Update a book
        Route::delete('/{id}', [BookController::class, 'destroy'])->name('api.books.delete'); // Delete a book
    });

    // Bayanat
    Route::prefix('bayanaat')->group(function () {
        Route::get('/', [BayanaatController::class, 'fetch'])->name('api.bayanaat.fetch');           // Fetch all Bayanaat
        Route::post('/', [BayanaatController::class, 'store'])->name('api.bayanaat.store');          // Create a new Bayaan
        Route::get('/{id}', [BayanaatController::class, 'show'])->name('api.bayanaat.show');         // Fetch a specific Bayaan
        Route::put('/{id}', [BayanaatController::class, 'update'])->name('api.bayanaat.update');     // Update a Bayaan
        Route::delete('/{id}', [BayanaatController::class, 'destroy'])->name('api.bayanaat.delete'); // Delete a Bayaan
    });

    // Islamic names
    Route::prefix('islamic-names')->group(function () {
        Route::get('/', [IslamicNameController::class, 'fetch'])->name('api.islamic-names.fetch');           // Get all names
        Route::post('/', [IslamicNameController::class, 'store'])->name('api.islamic-names.store');          // Create a new name
        Route::get('/{id}', [IslamicNameController::class, 'show'])->name('api.islamic-names.show');         // Get a single name
        Route::put('/{id}', [IslamicNameController::class, 'update'])->name('api.islamic-names.update');     // Update a name
        Route::delete('/{id}', [IslamicNameController::class, 'destroy'])->name('api.islamic-names.delete'); // Delete a name
    });

    // qeustions and anser
    Route::get('/api/question/fetch', [QuestionAnswerController::class, 'fetchQuestions'])->name('api.question.fetch');
    Route::post('/api/answer/store', [QuestionAnswerController::class, 'answerStore'])->name('api.answer.store');
    Route::delete('/api/question/delete/{id}', [QuestionAnswerController::class, 'delete'])->name('api.question.delete');

});

// front end changing default language
Route::post('/user/default/language', [LanguageController::class, 'make_frontend_default_language'])->name('api.user.default.language');
Route::get('/front_end/languages/data', [LanguageController::class, 'frontend_languages_data'])->name('api.front_end.languages.data');

Route::post('/students/store', [StudentsController::class, 'store'])->name('api.student.store');
// API's For Mobile
Route::get('/madrasa/introduction', [IntroductionController::class, 'fetch'])->name('api.madrasa.introduction');
Route::get('/madrasa/books', [BookController::class, 'fetch'])->name('api.madrasa.books');
Route::get('/madrasa/bayanaat', [BayanaatController::class, 'fetch'])->name('api.madrasa.bayanaat');
Route::get('/madrasa/islamic/names', [IslamicNameController::class, 'fetch'])->name('api.madrasa.islamic.names');

Route::post('/question/store', [QuestionAnswerController::class, 'saveQuestion'])->name('api.question.store');
// Route::get('/show/questions/approved', [QuestionController::class, 'getApprovedQuestions'])->name('api.show.questions.approved');
Route::get('/questions/approved', [QuestionAnswerController::class, 'getApprovedQuestions'])->name('api.questions.approved');

Route::get('/enroll/status/check/{cnic}', [StudentsController::class, 'checkAdmissionStatus'])->name('api.enroll.status.check');
Route::get('/students/{regNo}', [StudentsController::class, 'findByRegNo']);
