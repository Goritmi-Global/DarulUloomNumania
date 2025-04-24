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
        $questions = Question::with('answer')->get();
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
            'message' => translate('Question submitted successfully.'),
            'data'    => $record,
        ]);
    }

    public function answerStore(Request $request)
    {
 
        // dd($request->all());
        // Validate the incoming request
        $request->validate([
            'question_id'       => 'nullable|exists:questions,id',
            'short_question'      => 'nullable|required_if:new_fatwa,true|string|max:255',
            'full_question'       => 'nullable|required_if:new_fatwa,true|string|max:255',
             
            'answer_short_form'   => ['required', 'string', 'max:255', function ($attribute, $value, $fail) {
            if (Str::of(strip_tags($value))->trim()->isEmpty()) {
                $fail("The $attribute field cannot be empty.");
            }
        }],
        'answer_full_form'    => ['required', 'string', function ($attribute, $value, $fail) {
            if (Str::of(strip_tags($value))->trim()->isEmpty()) {
                $fail("The $attribute field cannot be empty.");
            }
        }],
            'approved_by_mufti' => 'nullable|string|max:255',
            
            
        ]);
    
        
        // Create a new answer record
        if ($request->id) {
            $answer = Answer::find($request->id);
            // dd("extig",$answer,$request->id);
        } else {
            $answer = new Answer();
            $answer->id = Str::uuid();

            // Generate the next fitwa_number automatically
            $lastAnswer = Answer::latest('fitwa_number')->first(); // Get the latest answer by fitwa_number
            $lastFitwaNumber = $lastAnswer ? (int) $lastAnswer->fitwa_number : 0; // If no answers, start from 0
        
            // Generate new fitwa_number, incrementing from the last one
            $newFitwaNumber = str_pad($lastFitwaNumber + 1, 6, '0', STR_PAD_LEFT);
            $answer->fitwa_number = $newFitwaNumber; // Set the generated fitwa_number
            // dd("new");
        }
    
   
        if($request->new_fatwa)
        {

            $record     = new Question();
            $record->id = Str::uuid();  
            $record->name        = "جامعہ دارالعلوم نعمانیہ اتمانزئی";
            $record->email       = " jamianumania2025@gmail.com";
            $record->subject     = $request->short_question;
            $record->description = $request->full_question;
            $record->date        = Carbon::now(); // Store current date
            $record->save();
            $question_id = $record->id;
    
        }else
        {
            $question_id = $request->question_id;
        }
  

    
        // Assign the other fields from the request
//  dd($answer);
        $answer->question_id = $question_id; 
        $answer->answer_short_form = $request->answer_short_form;
        $answer->answer_full_form = $request->answer_full_form;
        $answer->approved_by_mufti = $request->approved_by_mufti;
    
        // Update the question's status based on the approval
        $question = Question::where('id',$question_id)->first();
    
        if ($request->approved_by_mufti) {
            $question->status = 2; // Approved by Mufti
        } else {
            $question->status = 1; // Not approved
        }
        
        $question->save();
    
        // Save the answer record with the auto-generated fitwa_number
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
