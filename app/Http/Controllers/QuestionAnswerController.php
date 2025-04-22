<?php
namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Question;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;

class QuestionAnswerController extends Controller
{
    public function index()
    {
        // $introductions = Introduction::all();
        return Inertia::render('QuestionsAnswers/Index');
    }
    public function fetchQuestions()
    {
        $questions = Question::with('answer')->orderByDesc('date')->get();
        return $questions;
    }

    public function store(Request $request)
    {
        $request->validate([
            'question_id'       => 'required|exists:questions,id',
            'answer_short_form' => 'required|string|max:255',
            'answer_full_form'  => 'required|string',
            'approved_by_mufti' => 'nullable|string|max:255',
            'fitwa_number'      => 'required',
        ]);

        Answer::create($request->all());

        return response()->json(['message' => 'Answer submitted successfully.'], 201);
    }

    public function destroy($id)
    {
        Introduction::findOrFail($id)->delete();
        return response()->json(['message' => 'Introduction deleted successfully.'], 200);
    }

    // front end
    public function ask_question()
    {
        return Inertia::render('FrontEnd/AskQuestion');
    }

    public function saveQuestion(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'email'       => 'required|email|max:255',
            'subject'     => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $record     = new Question();
        $record->id = Str::uuid(); // Assigning a UUID if creating a new record

        $record->name        = $request->name;
        $record->email       = $request->email;
        $record->subject     = $request->subject;
        $record->description = $request->description;
        $record->date        = Carbon::now(); // Store current date
        $record->save();

        return response()->json([
            'message' => 'Question submitted successfully.',
            'data'    => $record,
        ]);
    }

    public function answerStore(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'question_id'       => 'required|exists:questions,id',
            'answer_short_form' => 'required|string|max:255',
            'answer_full_form'  => 'required|string',
            'approved_by_mufti' => 'nullable|string|max:255',
            'fitwa_number'      => 'required',
        ]);

        // Create a new answer record
        if ($request->id) {
            $answer = Answer::find($request->id);
        } else {

            $answer     = new Answer();
            $answer->id = Str::uuid();
        }
        $answer->question_id       = $request->question_id;
        $answer->answer_short_form = $request->answer_short_form;
        $answer->answer_full_form  = $request->answer_full_form;
        $answer->approved_by_mufti = $request->approved_by_mufti;
        $answer->fitwa_number      = $request->fitwa_number;
        if ($request->approved_by_mufti) {
            $question         = Question::find($request->question_id);
            $question->status = 2;
            $question->save();
        } else {
            $question         = Question::find($request->question_id);
            $question->status = 1;
            $question->save();
        }
        $answer->date = Carbon::now(); // Store current date
        $answer->save();

        return response()->json(['message' => 'Answer stored successfully!'], 201);
    }

    public function getApprovedQuestions(Request $request)
    {
        $search = $request->query('search');

                                                               // dd("etes");
        $query = Question::with('answer')->where('status', 2); // Only approved questions

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('subject', 'LIKE', "%{$search}%")
                    ->orWhere('description', 'LIKE', "%{$search}%");
            });
        }

        $questions = $query->paginate(20); // Show 5 records per page
        return response()->json($questions);
    }

    public function delete($id)
    {
        $question = Question::find($id);
        $answer   = Answer::where('question_id', $id)->first();
        if ($answer) {
            $answer->delete();
        }
        $question->delete();
        return 'success';

    }

}
