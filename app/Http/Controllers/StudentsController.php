<?php

namespace App\Http\Controllers;

use App\Models\Annual;
use App\Models\Batch;
use App\Models\BatchFeeStructure;
use App\Models\FeeReceipt;
use App\Models\FeeSlip;
use App\Models\Program;
use App\Models\User;
use App\Models\Semester;
use App\Models\Session;
use App\Models\Student;
use App\Models\Upload;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Inertia\Inertia;
use PDF;

class StudentsController extends Controller
{
    public function index()
    {
        return Inertia::render('Students/Index');
    }
    public function create()
    {
        return Inertia::render('Students/Create');
    }
    public function edit($id)
    {
        return Inertia::render('Students/Create', ['studentId' => $id]);
    }
    public function students()
    {
        $students = Student::orderBy('created_at')->get();
        foreach ($students as $student) {
             
            if ($student->program_id) {
                $program = Program::where('id', $student->program_id)->first();
                $student->programName = $program->name ?? "";
                
            }
            if ($student->c_session_id) {
                $session = Session::where('id', $student->c_session_id)->first();
                $student->sessionName = $session->session ?? "";
            }
            if ($student->program_id) {
                $batch = Batch::where('id', $student->batch_id)->first();
                $student->batchName = $batch->name ?? "";
            }
            if ($student->image) {

                $Upload = Upload::where('id', $student->image)->first();
                $profilePicture = get_storage_url($Upload->file_name) ?? "";
                $student->image = $profilePicture;
            }
        }
  
        return $students;
    }
    // the store function is used to store and update the record of the student
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:254',
            'form_no' => 'required|string|max:254',
            'college' => 'required|string|max:254',
            'program' => 'required|string|max:254',
            'session' => 'required|string|max:254',
            'batch' => 'required|string|max:254',

            'dob' => 'nullable',
            'marital_status' => 'nullable|string|max:254',
            'gender' => 'nullable|string|max:254',
            'image' => 'nullable',
            'permanent_address' => 'nullable|string|max:254',
            'student_country' => 'nullable|string|max:254',
            'student_domicile' => 'nullable|string|max:254',
            'student_district' => 'nullable|string|max:254',
            'cell_no_a' => 'nullable|string|max:254',
            'cell_no_b' => 'nullable|string|max:254',
            'student_email' => 'nullable|email|max:254',
            'cnic_formb' => 'nullable|string|max:254',
            'father_name' => 'nullable|string|max:254',
            'father_profession' => 'nullable|string|max:254',
            'father_address' => 'nullable|string|max:254',
            'father_district' => 'nullable|string|max:254',
            'father_country' => 'nullable|string|max:254',
            'father_phone' => 'nullable|string|max:254',
            'father_cell' => 'nullable|string|max:254',
            'father_email' => 'nullable|email|max:254',
            'same_as_parent_status' => 'nullable|string|max:254',
            'guardian_name' => 'nullable|string|max:254',
            'guardian_address' => 'nullable|string|max:254',
            'guardian_phone' => 'nullable|string|max:254',
            'guardian_cell' => 'nullable|string|max:254',
            'guardian_email' => 'nullable|email|max:254',
            'status' => 'nullable|string|max:254',

        ]);
        $process = "";

        if ($request->student_id) {
            $student = Student::findOrFail($request->student_id);
            $process = "update";
        } else {
            $process = "new";
            $student = new Student;
            $student->id = Str::orderedUuid();

            $latestStudent = Student::where('program_id', $request->program)->latest()->first();
            $program = Program::where('id', $request->program)->first();

            $session = Session::where('id', $request->session)->first();
            $session = $program->code . '-' . $session->session . '-';
            $programType = $program->program_type;

            $lastRegistrationNumber = $latestStudent ? (int) substr($latestStudent->registration_number, -3) : 0;
            $number = str_pad($lastRegistrationNumber + 1, 3, '0', STR_PAD_LEFT);

            $registrationNumber = $session . $number;
            $student->registration_number = $registrationNumber;

            // data adding into fee slip modal
            $fee_slip = new FeeSlip;
            $fee_slip->id = Str::orderedUuid();
            $fee_slip->student_id = $student->id;

            // Get the last inserted record
            $lastFeeSlip = FeeSlip::latest('id')->first();
            // Generate the unique slip number
            // $nextNumber = $lastFeeSlip ? intval(substr($lastFeeSlip->unique_number, 0, 3)) + 1 : 1;
            // $uniqueNumber = sprintf('%03d-%s', $nextNumber, now()->format('YM'));
            $nextNumber = $lastFeeSlip ? intval(substr($lastFeeSlip->unique_number, -2)) + 1 : 1;
            $uniqueNumber = sprintf('%s-%02d', now()->format('ym'), $nextNumber);
            // Set the generated slip number on the FeeSlip model
            $fee_slip->unique_number = $uniqueNumber;

            if ($programType == 'Annual') {

                // $batch_admission_fee = BatchFeeStructure::where('batch_id', $request->batch)->where('category', $programType)->where('fee_for', 'First Year')->where('title', 'Admission')->value('amount');
                // $batch_tuition_fee = BatchFeeStructure::where('batch_id', $request->batch)->where('category', $programType)->where('fee_for', 'First Year')->where('title', 'Tuition')->value('amount');
                // $batch_security_fee = BatchFeeStructure::where('batch_id', $request->batch)->where('category', $programType)->where('fee_for', 'First Year')->where('title', 'Security')->value('amount');
                // $batch_examination_fee = BatchFeeStructure::where('batch_id', $request->batch)->where('category', $programType)->where('fee_for', 'First Year')->where('title', 'Examination')->value('amount');
                // $batch_other_fee = BatchFeeStructure::where('batch_id', $request->batch)->where('category', $programType)->where('fee_for', 'First Year')->where('title', 'Other')->value('amount');

                // $admission_fee = $batch_admission_fee ?? 0.00;
                // $tuition_fee = $batch_tuition_fee ?? 0.00;
                // $security_fee = $batch_security_fee ?? 0.00;
                // $exam_fee = $batch_examination_fee ?? 0.00;
                // $other_fee = $batch_other_fee ?? 0.00;

                $feeTitles = ['Admission', 'Tuition', 'Security', 'Examination', 'Other'];
                $feeAmounts = [];
                foreach ($feeTitles as $title) {
                    $feeAmounts[$title] = BatchFeeStructure::where('batch_id', $request->batch)
                        ->where('category', $programType)
                        ->where('fee_for', 'First Year')
                        ->where('title', $title)
                        ->value('amount') ?? 0.00;
                }
                $admission_fee = $feeAmounts['Admission']; 
                $tuition_fee = $feeAmounts['Tuition'];
                $security_fee = $feeAmounts['Security'];
                $exam_fee = $feeAmounts['Examination'];
                $other_fee = $feeAmounts['Other'];

                $fee_slip->payfor = "First Year";
                $fee_slip->notes = "First year admission fee, Tuition fee and other.";
                $student->current_year = "First Year";

            } else {
                $feeTitles = ['Admission', 'Tuition', 'Security', 'Examination', 'Other'];
                $feeAmounts = [];
                foreach ($feeTitles as $title) {
                    $feeAmounts[$title] = BatchFeeStructure::where('batch_id', $request->batch)
                        ->where('category', $programType)
                        ->where('fee_for', 'First Semester')
                        ->where('title', $title)
                        ->value('amount') ?? 0.00;
                }
                $admission_fee = $feeAmounts['Admission']; 
                $tuition_fee = $feeAmounts['Tuition'];
                $security_fee = $feeAmounts['Security'];
                $exam_fee = $feeAmounts['Examination'];
                $other_fee = $feeAmounts['Other'];
                // $batch_admission_fee = BatchFeeStructure::where('batch_id', $request->batch)->where('category', $programType)->where('fee_for', 'First Semester')->where('title', 'Admission')->value('amount');

                // $batch_tuition_fee = BatchFeeStructure::where('batch_id', $request->batch)->where('category', $programType)->where('fee_for', 'First Semester')->where('title', 'Tuition')->value('amount');

                // $batch_security_fee = BatchFeeStructure::where('batch_id', $request->batch)->where('category', $programType)->where('fee_for', 'First Semester')->where('title', 'Security')->value('amount');

                // $batch_examination_fee = BatchFeeStructure::where('batch_id', $request->batch)->where('category', $programType)->where('fee_for', 'First Semester')->where('title', 'Examination')->value('amount');

                // $batch_other_fee = BatchFeeStructure::where('batch_id', $request->batch)->where('category', $programType)->where('fee_for', 'First Semester')->where('title', 'Other')->value('amount');
                

                // $admission_fee = $batch_admission_fee ?? 0.00;
                // $tuition_fee = $batch_tution_fee ?? 0.00;
                // $security_fee = $batch_security_fee ?? 0.00;
                // $exam_fee = $batch_examination_fee ?? 0.00;
                // $other_fee = $batch_other_fee ?? 0.00;

                // Assigning individual fees to variables
                


                $fee_slip->payfor = "First Semester";
                $student->current_semester = "First Semester";
                $fee_slip->notes = "First semester admission fee, Tuition fee and other.";
            }

            $batch_total_fee = $admission_fee + $tuition_fee + $security_fee + $exam_fee + $other_fee;
            $fee_slip->actual_fee = $batch_total_fee;
            $fee_slip->payable_fee = $batch_total_fee;
            $fee_slip->admission_fee = $admission_fee;
            $fee_slip->tuition_fee = $tuition_fee;
            $fee_slip->security_fee = $security_fee;
            $fee_slip->exam_fee = $exam_fee;
            $fee_slip->other_fee = $other_fee;
            $fee_slip->remained_fee = $batch_total_fee;
            $fee_slip->discount_amount = 0.00;
            $fee_slip->paid_fee = 0.00;
            $fee_slip->create_date = Carbon::now()->format('Y-m-d');
            $fee_slip->last_payment = 0;
            $fee_slip->status = 0;
            $fee_slip->save();

        }

        $student->form_no = $request->form_no;
        $student->program_id = $request->program;
        $student->college_id = $request->college;
        $student->session_id = $request->session;
        $student->c_session_id = $request->session;
        $student->form_no = $request->form_no;
        $student->batch_id = $request->batch;
        $student->name = $request->name;
        $student->dob = Carbon::parse($request->dob);
        $student->marital_status = $request->marital_status;
        $student->gender = $request->gender;

        $student->p_address = $request->permanent_address;
        $student->s_district = $request->student_district;
        $student->s_domicile = $request->student_domicile;
        $student->s_country = $request->student_country;
        $student->cell_no_a = $request->cell_no_a;
        $student->cell_no_b = $request->cell_no_b;
        $student->email = $request->student_email;
        $student->cnic_formb = $request->cnic_formb;

        $student->father_name = $request->father_name;
        $student->father_profession = $request->father_profession;
        $student->father_address = $request->father_address;
        $student->f_district = $request->father_district;
        $student->f_country = $request->father_country;
        $student->f_phone = $request->father_phone;
        $student->father_cell = $request->father_cell;
        $student->father_email = $request->father_email;
        $student->same_as_parent_status = $request->same_as_parent_status;

        if ($request->same_as_parent_status == 'true') {
            $student->guardian_name = $request->father_name;
            $student->guardian_address = $request->father_address;
            $student->g_phone = $request->father_phone;
            $student->g_cell = $request->father_cell;
            $student->g_email = $request->father_email;
        } else {

            $student->guardian_name = $request->guardian_name;
            $student->guardian_address = $request->guardian_address;
            $student->g_phone = $request->guardian_phone;
            $student->g_cell = $request->guardian_cell;
            $student->g_email = $request->guardian_email;
        }

        $student->status = $request->status;
        $student->current_status = "Active";

        $student->entry_date = Carbon::now()->format('Y-m-d');

        if ($request->image) {
            Upload::where('id', $student->photo_id)->delete();
            $data = substr($request->image, strpos($request->image, ',') + 1);
            $data = base64_decode($data);

            $photo_name_with_path = 'StudentProfilePictures/' . Str::random(40) . '.png';
            Storage::put($photo_name_with_path, $data);
            $fileSize = strlen($data);
            $Upload = new Upload;

            $Upload->file_original_name = $photo_name_with_path;
            $Upload->extension = 'png';
            $Upload->type = 'image/png';
            $Upload->file_size = $fileSize;
            $Upload->file_name = $photo_name_with_path;

            $Upload->save();

            $student->image = $Upload->id;

        }

        $student->save();
        // dd("tes");
        return ['process' => $process, 'student_id' => $student->id, 'slip_id' => $fee_slip->id ?? ""];
    }

    public function show($id)
    {
        $student = Student::findOrFail($id);
        if ($student->image) {
            $Upload = Upload::where('id', $student->image)->first();
            $profilePicture = get_storage_url($Upload->file_name) ?? "";
            $student->image = $profilePicture;

        }

        $student->batch = $student->batch_id;
        $student->session = $student->session_id;
        $student->program = $student->program_id;

        return $student;
    }
    public function delete($id)
    {
        $student = Student::findOrFail($id);
         
        Upload::where('id', $student->photo_id)->delete();
        $student->delete();
        return 'success';
    }
    public function details($id)
    {
        return Inertia::render('Students/Details', ['studentId' => $id]);

    }
    public function details_fetch($id)
    {
        $student = Student::where('id', $id)->first();
        if ($student) {
            if ($student->image) {

                $Upload = Upload::where('id', $student->image)->first();
                $profilePicture = get_storage_url($Upload->file_name) ?? "";
                $student->image = $profilePicture;
            }

            $programName = $student->program->name ?? "";
            $student->programName = $programName;

            $sessionName = $student->session->session ?? "";
            $student->sessionName = $sessionName;

            $batchName = $student->batch->name ?? "";
            $student->batchName = $batchName;

            $student->college_id = $student->college->name ?? "";

        }
        return $student;

    }

    public function search(Request $request)
    {
        $request->validate([
            'batch' => 'required',
            'program' => 'required',
            'session' => 'required',
            'semester' => 'required_without:annual',
            'annual' => 'required_without:semester',
        ]);

        $year = "";
        $semester = "";

        if ($request->semester) {
            $semester = $request->semester;
        }

        if ($request->annual) {
            $year = $request->annual;
        }

        $studentsQuery = DB::table('students');

        if ($request->batch && $request->batch != "null") {
            $studentsQuery->where('batch_id', $request->batch);
        }
        if ($request->program && $request->program != "null") {
            $studentsQuery->where('program_id', $request->program);
        }

        if ($request->session && $request->session != "null") {
            $studentsQuery->where('c_session_id', $request->session);
        }

        if ($semester) {
            $studentsQuery->where('current_semester', $request->semester);
        }
        // dd($studentsQuery->get());

        if ($year) {
            $studentsQuery->where('current_year', $request->annual);
        }

        $students = $studentsQuery->get();

        foreach ($students as $student) {
            if ($student->program_id) {
                $program = Program::where('id', $student->program_id)->first();
                $student->programName = $program->name ?? "";
            }
            if ($student->c_session_id) {
                $session = Session::where('id', $student->c_session_id)->first();
                $student->sessionName = $session->session;
            }
            if ($student->program_id) {
                $batch = Batch::where('id', $student->batch_id)->first();
                $student->batchName = $batch->name ?? "";
            }
            if ($student->image) {

                $Upload = Upload::where('id', $student->image)->first();
                $profilePicture = get_storage_url($Upload->file_name) ?? "";
                $student->image = $profilePicture ?? "";
            }

        }

        return $students;
    }
    public function search_by_name_regno(Request $request)
    {
        $request->validate([
            'reg_no' => 'required_without:student_name',
            'student_name' => 'required_without:reg_no',
        ]);

        $students = Student::when($request->student_name && $request->student_name != "null", function ($query) use ($request) {
            $query->where('name', 'LIKE', '%' . $request->student_name . '%');
        })
            ->when($request->father_name && $request->father_name != "null", function ($query) use ($request) {
                $query->where('father_name', 'LIKE', '%' . $request->father_name . '%');
            })
            ->when($request->cnic && $request->cnic != "null", function ($query) use ($request) {
                $query->where('cnic', 'LIKE', '%' . $request->cnic . '%');
            })
            ->when($request->reg_no && $request->reg_no != "null", function ($query) use ($request) {
                $query->where('registration_number', $request->reg_no);
            })
            ->get();

        foreach ($students as $student) {
 
            if ($student->program_id) {
                $program = Program::where('id', $student->program_id)->first();
                $student->programName = $program->name ?? "";
            }
            if ($student->c_session_id) {
                $session = Session::where('id', $student->c_session_id)->first();
                $student->sessionName = $session->session ?? "";
            }
            if ($student->program_id) {
                $batch = Batch::where('id', $student->batch_id)->first();
                $student->batchName = $batch->name ?? "";
            }
        }

        return $students;
    }
    public function quick_search(Request $request)
    {
 
        $request->validate([
            // 'program' => 'required',

            // ... add other validation rules as needed
        ]);

        
        $semester = $request->semester ?? "";
        $year = $request->year ?? "";
        $college = $request->college;

        $students = Student::when($request->batch && $request->batch != "null", function ($query) use ($request) {
            $query->where('batch_id', $request->batch);
        })
            ->when($request->program && $request->program != "null", function ($query) use ($request) {
                $query->where('program_id', $request->program);
            })
            ->when($college && $college != "null" && $college != 0, function ($query) use ($college) {
                $query->where('college_id', $college);
            })
            ->when($request->session && $request->session != "null", function ($query) use ($request) {
                $query->where('c_session_id', $request->session);
            })
            ->when($semester, function ($query) use ($semester) {
                $query->where('current_semester', $semester);
            })
            ->when($year, function ($query) use ($year) {
                $query->where('current_year', $year);
            })
            ->when($request->student_name && $request->student_name != "null", function ($query) use ($request) {
                $query->where('name', 'LIKE', '%' . $request->student_name . '%');
            })
            ->when($request->father_name && $request->father_name != "null", function ($query) use ($request) {
                $query->where('father_name', 'LIKE', '%' . $request->father_name . '%');
            })
            ->when($request->cnic && $request->cnic != "null", function ($query) use ($request) {
                $query->where('cnic_formb', $request->cnic);
            })
            ->when($request->reg_no && $request->reg_no != "null", function ($query) use ($request) {
                $query->where('registration_number', $request->reg_no);
            })
            ->get();

        foreach ($students as $student) { 
            if ($student->program_id) {
                $program = Program::where('id', $student->program_id)->first();
                $student->programName = $program->name ?? "";
            }
            if ($student->c_session_id) {
                $session = Session::where('id', $student->c_session_id)->first();
                $student->sessionName = $session->session ?? "";
            }
            if ($student->program_id) {
                $batch = Batch::where('id', $student->batch_id)->first();
                $student->batchName = $batch->name ?? "";
            }
            if ($student->image) {

                $Upload = Upload::where('id', $student->image)->first();
                $profilePicture = get_storage_url($Upload->file_name) ?? "";
                $student->image = $profilePicture;
            }
        }

        return $students;
    }

    public function search_by_regno(Request $request)
    {
        $request->validate([
            'reg_no' => 'required',
        ]);

        $student = Student::where('registration_number', $request->reg_no)->first();
        if ($student) {

            $programName = $student->program->name ?? "";
            $student->programName = $programName;

            $sessionName = $student->session->session ?? "";
            $student->sessionName = $sessionName;

            $batchName = $student->batch->name ?? "";
            $student->batchName = $batchName;

        }
        return $student;
    }
    public function active_students_search_by_name_regno(Request $request)
    {
        $request->validate([
            'reg_no' => 'required_without:student_name',
            'student_name' => 'required_without:reg_no',
            'current_status' => 'required',
        ]);

        $students = Student::when($request->student_name && $request->student_name != "null", function ($query) use ($request) {
            $query->where('name', 'LIKE', '%' . $request->student_name . '%');
        })
            ->when($request->father_name && $request->father_name != "null", function ($query) use ($request) {
                $query->where('father_name', 'LIKE', '%' . $request->father_name . '%');
            })
            ->when($request->cnic && $request->cnic != "null", function ($query) use ($request) {
                $query->where('cnic', 'LIKE', '%' . $request->cnic . '%');
            })
            ->when($request->reg_no && $request->reg_no != "null", function ($query) use ($request) {
                $query->where('registration_number', $request->reg_no);
            })
            ->when($request->current_status && $request->current_status != "null", function ($query) use ($request) {
                $query->where('current_status', $request->current_status);
            })
            ->get();

        foreach ($students as $student) {
 

            if ($student->program_id) {
                $program = Program::where('id', $student->program_id)->first();
                $student->programName = $program->name ?? "";
            }
            if ($student->c_session_id) {
                $session = Session::where('id', $student->c_session_id)->first();
                $student->sessionName = $session->session ?? "";
            }
            if ($student->program_id) {
                $batch = Batch::where('id', $student->batch_id)->first();
                $student->batchName = $batch->name ?? "";
            }
            if ($student->image) {

                $Upload = Upload::where('id', $student->image)->first();
                $profilePicture = get_storage_url($Upload->file_name) ?? "";
                $student->image = $profilePicture;
            }

        }

        return $students;
    }

    // Promote\
    public function promote(Request $request)
    {
        $request->validate(['promoted_session' => 'required']);
        $promoting_session = $request->promoted_session;
        $semester = '';
        $year = '';

        $student_ids_array = explode(',', $request->student_ids);
        foreach ($student_ids_array as $student_id) {

            // data adding into fee slip modal
            $fee_slip = new FeeSlip;
            $fee_slip->id = Str::orderedUuid();
            $fee_slip->student_id = $student_id;

            // Get the last inserted record
            $lastFeeSlip = FeeSlip::latest('id')->first();
            // Generate the unique slip number
            $nextNumber = $lastFeeSlip ? intval(substr($lastFeeSlip->unique_number, 0, 3)) + 1 : 1;
            $uniqueNumber = sprintf('%03d-%s', $nextNumber, now()->format('d-m-Y'));
            // Set the generated slip number on the FeeSlip model
            $fee_slip->unique_number = $uniqueNumber;

            $student = Student::where('id', $student_id)->first();

            if ($student) {

                if ($student->current_semester) {

                    $current_semester = $student->current_semester;
                    $fee_slip->payfor = $current_semester;
                    $fee_slip->notes = $current_semester . " and admission fee";

                    $promoted_semester = '';
                    if ($current_semester == 'First Semester') {
                        $promoted_semester = 'Second Semester';
                    } else if ($current_semester == 'Second Semester') {
                        $promoted_semester = 'Third Semester';
                    } else if ($current_semester == 'Third Semester') {
                        $promoted_semester = 'Forth Semester';
                    }
                    $student->current_semester = $promoted_semester;

                    $batch_admission_fee = BatchFeeStructure::where('batch_id', $request->batch)->where('category', "Semester")->where('fee_for', $promoted_semester)->where('title', 'Admission')->value('amount');

                    $batch_tuition_fee = BatchFeeStructure::where('batch_id', $request->batch)->where('category', "Semester")->where('fee_for', $promoted_semester)->where('title', 'Tuition')->value('amount');

                    $batch_security_fee = BatchFeeStructure::where('batch_id', $request->batch)->where('category', "Semester")->where('fee_for', $promoted_semester)->where('title', 'Security')->value('amount');

                    $batch_examination_fee = BatchFeeStructure::where('batch_id', $request->batch)->where('category', "Semester")->where('fee_for', $promoted_semester)->where('title', 'Examination')->value('amount');

                    $batch_other_fee = BatchFeeStructure::where('batch_id', $request->batch)->where('category', "Semester")->where('fee_for', $promoted_semester)->where('title', 'Other')->value('amount');

                    $admission_fee = $batch_admission_fee ?? 0.00;
                    $tuition_fee = $batch_tuition_fee ?? 0.00;
                    $security_fee = $batch_security_fee ?? 0.00;
                    $exam_fee = $batch_examination_fee ?? 0.00;
                    $other_fee = $batch_other_fee ?? 0.00;

                    $fee_slip->payfor = $promoted_semester;
                    $fee_slip->notes = $promoted_semester . " admission fee, Tuition fee and other.";

                }
                if ($student->current_year) {

                    $current_year = $student->current_year;

                    $promoted_year = '';
                    if ($current_year == 'First Year') {
                        $promoted_year = 'Second Year';
                    }
                    $student->current_year = $promoted_year;

                    $batch_admission_fee = BatchFeeStructure::where('batch_id', $request->batch)->where('category', 'Annual')->where('fee_for', $promoted_year)->where('title', 'Admission')->value('amount');

                    $batch_tuition_fee = BatchFeeStructure::where('batch_id', $request->batch)->where('category', 'Annual')->where('fee_for', $promoted_year)->where('title', 'Tuition')->value('amount');

                    $batch_security_fee = BatchFeeStructure::where('batch_id', $request->batch)->where('category', 'Annual')->where('fee_for', $promoted_year)->where('title', 'Security')->value('amount');

                    $batch_examination_fee = BatchFeeStructure::where('batch_id', $request->batch)->where('category', 'Annual')->where('fee_for', $promoted_year)->where('title', 'Examination')->value('amount');

                    $batch_other_fee = BatchFeeStructure::where('batch_id', $request->batch)->where('category', 'Annual')->where('fee_for', $promoted_year)->where('title', 'Other')->value('amount');

                    $admission_fee = $batch_admission_fee ?? 0.00;
                    $tuition_fee = $batch_tuition_fee ?? 0.00;
                    $security_fee = $batch_security_fee ?? 0.00;
                    $exam_fee = $batch_examination_fee ?? 0.00;
                    $other_fee = $batch_other_fee ?? 0.00;

                    $fee_slip->payfor = $promoted_year;
                    $fee_slip->notes = $promoted_year . " admission fee, Tuition fee and other.";

                }

                $student->c_session_id = $promoting_session;

                $batch_total_fee = $admission_fee + $tuition_fee + $security_fee + $exam_fee + $other_fee;
                $fee_slip->actual_fee = $batch_total_fee;
                $fee_slip->payable_fee = $batch_total_fee;
                $fee_slip->admission_fee = $admission_fee;
                $fee_slip->tuition_fee = $tuition_fee;
                $fee_slip->security_fee = $security_fee;
                $fee_slip->exam_fee = $exam_fee;
                $fee_slip->other_fee = $other_fee;
                $fee_slip->remained_fee = $batch_total_fee;
                $fee_slip->discount_amount = 0.00;
                $fee_slip->paid_fee = 0.00;
                $fee_slip->create_date = Carbon::now()->format('Y-m-d');
                $fee_slip->last_payment = 0;
                $fee_slip->status = 0;
                $fee_slip->save();

                $student->save();
            }
        }
        return 'success';

    }
    // Demote
    public function demote(Request $request)
    {
        $request->validate(['demoted_session' => 'required']);
        $demoting_session = $request->demoted_session;
        $semester = "";
        $annual = "";

        $student_ids_array = explode(',', $request->student_ids);

        foreach ($student_ids_array as $student_id) {

            $student = Student::where('id', $student_id)->first();
            if ($student) {
                if ($student->current_semester) {

                    $current_semester = $student->current_semester;

                    $feeSlip = FeeSlip::where('student_id', $student_id)->where('payfor', $current_semester)->first();
                    if ($feeSlip) {
                        $fee_receipts = FeeReceipt::where('slip_id', $feeSlip->id)->delete();
                        $feeSlip->delete();
                    }

                    $demoted_semester = '';
                    if ($current_semester == 'Second Semester') {
                        $demoted_semester = 'First Semester';
                    } else if ($current_semester == 'Third Semester') {
                        $demoted_semester = 'Second Semester';
                    } else if ($current_semester == 'Fourth Semester') {
                        $demoted_semester = 'Third Semester';
                    }
                    $student->current_semester = $demoted_semester;

                }
                if ($student->current_year) {

                    $current_year = $student->current_year;
                    $feeSlip = FeeSlip::where('student_id', $student_id)->where('payfor', $current_year)->first();
                    if ($feeSlip) {

                        $fee_receipts = FeeReceipt::where('slip_id', $feeSlip->id)->delete();
                        $feeSlip->delete();
                    }

                    $demoted_year = '';
                    if ($current_year == 'Second Year') {
                        $demoted_year = 'First Year';
                    }
                    $student->current_year = $demoted_year;
                }

                $student->c_session_id = $demoting_session;

                $student->save();
            }
        }

        return 'success';

    }
    // Freeze
    public function semester_freeze(Request $request)
    {

        $student = Student::where('id', $request->student_id)->first();
        if ($student) {
            if ($request->process == 'Activate') {
                $student->current_status = "Active";
            }
            if ($request->process == 'Freeze') {
                $student->current_status = "Freezed";
            }

            $student->save();
        }

        return 'success';
    }
    // Admission Cancel
    public function admission_cancel(Request $request)
    {

        $student = Student::where('id', $request->student_id)->first();
        if ($student) {
            if ($request->process == 'Activate') {
                $student->current_status = "Active";
            }
            if ($request->process == 'Cancelled') {
                $student->current_status = "Cancelled";
            }
            $student->save();
        }

        return 'success';
    }

    // graduation code \

    public function search_for_graduation(Request $request)
    {

        $request->validate([
            'batch' => 'required',
            'program' => 'required',
            'session' => 'required',
            'semester' => 'required_without:annual',
            'annual' => 'required_without:semester',
        ]);

        $semester = "";
        $year = "";
        if ($request->semester) {
            $semester = $request->semester;
        }

        if ($request->annual) {
            $year = $request->annual;
        }

        $studentsQuery = DB::table('students');

        if ($request->batch && $request->batch != "null") {
            $studentsQuery->where('batch_id', $request->batch);
        }

        if ($request->program && $request->program != "null") {
            $studentsQuery->where('program_id', $request->program);
        }

        if ($request->session && $request->session != "null") {
            $studentsQuery->where('c_session_id', $request->session);
        }

        if ($semester) {
            $studentsQuery->where('current_semester', $request->semester);
        }

        if ($year) {

            $studentsQuery->where('current_year', $request->annual);
        }

        $students = $studentsQuery->get();

        foreach ($students as $key => $student) {

            $programName = $student->program->name ?? "";
            $student->programName = $programName;

            $sessionName = $student->session->session ?? "";
            $student->sessionName = $sessionName;

            $batchName = $student->batch->name ?? "";
            $student->batchName = $batchName;
            if ($student->image) {

                $Upload = Upload::where('id', $student->image)->first();
                $profilePicture = get_storage_url($Upload->file_name) ?? "";
                $student->image = $profilePicture;
            }
            $fee_slips = FeeSlip::where('student_id', $student->id)->get();
            if ($fee_slips) {

                $payable_fee = $fee_slips->sum('payable_fee');
                $paid_fee = $fee_slips->sum('paid_fee');
                $remained_fee = $fee_slips->sum('remained_fee');

                $student->payable_fee = $payable_fee;
                $student->paid_fee = $paid_fee;
                $student->remained_fee = $remained_fee;

                if ($remained_fee != 0) {

                    unset($students[$key]);

                }

            }
        }

        return $students;
    }

    public function graduate(Request $request)
    {

        $student_ids_array = explode(',', $request->student_ids);
        foreach ($student_ids_array as $student_id) {
            $student = Student::where('id', $student_id)->first();
            if ($student) {
                $current_semester = $student->current_semester;
                $current_year = $student->current_year;

                $student->current_status = "Graduated";
                if ($current_semester) {

                    $student->current_semester = "Graduated";
                } else if ($current_year) {
                    $student->current_year = "Graduated";
                }
            }
            $student->save();
        }
        return 'success';

    }
    // graduation code ended

    public function student_payement_details($student_id)
    {
        return Inertia::render('QuickSearch/Details', ['studentId' => $student_id]);
    }

    public function student_fetch_fee_slips($student_id)
    {
        $fee_slips = FeeSlip::where('student_id', $student_id)->get();
        foreach ($fee_slips as $slip) {
            $student = Student::where('id', $slip->student_id)->first();

            $slip->student_name = $student->name ?? "";
            if ($slip->semester == 'semester1_fee') {
                $slip->semester = "First Semester";
            }
            $programName = $student->program->name ?? "";
            $slip->programName = $programName;

            $sessionName = $student->session->session ?? "";
            $slip->sessionName = $sessionName;

            $batchName = $student->batch->name ?? "";
            $slip->batchName = $batchName;

        }

        return $fee_slips;
    }

    public function fetch_receipts_for_refund($slip_id)
    {
        $fee_slips = FeeSlip::where('student_id', $student_id)->get();
        foreach ($fee_slips as $slip) {
            $student = Student::where('id', $slip->student_id)->first();

            $slip->student_name = $student->name ?? "";
            if ($slip->semester == 'semester1_fee') {
                $slip->semester = "First Semester";
            }
            $programName = $student->program->name ?? "";
            $slip->programName = $programName;

            $sessionName = $student->session->session ?? "";
            $slip->sessionName = $sessionName;

            $batchName = $student->batch->name ?? "";
            $slip->batchName = $batchName;

        }

        return $fee_slips;
    }

    public function student_fetch_fee_receipts($student_id)
    {
        $total_admission_fee_collected = 0.00;
        $total_tuition_fee_collected = 0.00;
        $total_other_fee_collected = 0.00;
        $total_fee_collected = 0.00;
        $fee_slip_ids = FeeSlip::where('student_id', $student_id)->pluck('id');

        $fee_receipts = FeeReceipt::whereIn('slip_id', $fee_slip_ids)->get();
        foreach($fee_receipts as $receipt)
        {
            $user = User::where('id',$receipt->user_id)->first();
            $receipt->user_name = $user->name;
        }

        return $fee_receipts;
    }

    public function download_student_enrollment_pdf($student_id, $slip_id)
    {
        $student = Student::where('id', $student_id)->first();
        if ($student) {

            $programName = $student->program->name ?? "";
            $student->programName = $programName;

            $sessionName = $student->session->session ?? "";
            $student->sessionName = $sessionName;

            $batchName = $student->batch->name ?? "";
            $student->batchName = $batchName;
        }
        $slip = FeeSlip::where('id', $slip_id)->first();

        $pdf = PDF::loadView('pdf/slip', compact('student', 'slip'));
        return $pdf->download($student->name . " - " . $student->current_semester . ".pdf");
    }

    public function print_student_enrollment_pdf($student_id, $slip_id)
    {
        $student = Student::where('id', $student_id)->first();
        if ($student) {

            $programName = $student->program->name ?? "";
            $student->programName = $programName;

            $sessionName = $student->session->session ?? "";
            $student->sessionName = $sessionName;

            $batchName = $student->batch->name ?? "";
            $student->batchName = $batchName;
        }
        $slip = FeeSlip::where('id', $slip_id)->first();

        $pdf = PDF::loadView('pdf/slip', compact('student', 'slip'));
        return $pdf->stream('slip.pdf', ['print' => true]);
    }

    public function download_print_student_details_pdf($student_id, $process)
    {

        $student = Student::where('id', $student_id)->first();
        if ($student) {

            $programName = $student->program->name ?? "";
            $student->programName = $programName;

            $sessionName = $student->session->session ?? "";
            $student->sessionName = $sessionName;

            $batchName = $student->batch->name ?? "";
            $student->batchName = $batchName;
        }
        $slips = FeeSlip::where('student_id', $student->id)->get();
        $receipts = FeeReceipt::where('student_id', $student->id)->get();

        $pdf = PDF::loadView('pdf/studentDetails', compact('student', 'slips', 'receipts'));
        if ($process == 'print') {
            return $pdf->stream('studentDetails.pdf', ['print' => true]);

        } else {
            return $pdf->download($student->name . " - " . $student->registration_number . ".pdf");
        }
    }

    public function student_report_search(Request $request)
    {
        
         

        $semester = $request->semester ?? "";
        $year = $request->year ?? "";
        $college = $request->college;

        $students = Student::when($request->batch && $request->batch != "null", function ($query) use ($request) {
            $query->where('batch_id', $request->batch);
        })
            ->when($request->program && $request->program != "null", function ($query) use ($request) {
                $query->where('program_id', $request->program);
            })
            ->when($college && $college != "null" && $college != 0, function ($query) use ($college) {
        $query->where('college_id', $college);
    })
            ->when($request->session && $request->session != "null", function ($query) use ($request) {
                $query->where('c_session_id', $request->session);
            })
            ->when($semester, function ($query) use ($semester) {
                $query->where('current_semester', $semester);
            })
            ->when($year, function ($query) use ($year) {
                $query->where('current_year', $year);
            })
            ->when($request->student_name && $request->student_name != "null", function ($query) use ($request) {
                $query->where('name', 'LIKE', '%' . $request->student_name . '%');
            })
            ->when($request->father_name && $request->father_name != "null", function ($query) use ($request) {
                $query->where('father_name', 'LIKE', '%' . $request->father_name . '%');
            })
            ->when($request->cnic && $request->cnic != "null", function ($query) use ($request) {
                $query->where('cnic_formb', $request->cnic);
            })
            ->when($request->reg_no && $request->reg_no != "null", function ($query) use ($request) {
                $query->where('registration_number', $request->reg_no);
            })
            ->get();
            $payable_fee = 0;
            $paid_fee = 0;
            $remained_fee = 0;
        foreach ($students as $student) { 
            if ($student->program_id) {
                $program = Program::where('id', $student->program_id)->first();
                $student->programName = $program->name ?? "";
            }
            if ($student->c_session_id) {
                $session = Session::where('id', $student->c_session_id)->first();
                $student->sessionName = $session->session ?? "";
            }
            if ($student->program_id) {
                $batch = Batch::where('id', $student->batch_id)->first();
                $student->batchName = $batch->name ?? "";
            }
            if ($student->image) {

                $Upload = Upload::where('id', $student->image)->first();
                $profilePicture = get_storage_url($Upload->file_name) ?? "";
                $student->image = $profilePicture;
            }

            $fee_slips = FeeSlip::where('student_id', $student->id)->get();
            if ($fee_slips) {

                $payable_fee = $fee_slips->sum('payable_fee');
                $paid_fee = $fee_slips->sum('paid_fee');
                $remained_fee = $fee_slips->sum('remained_fee');

                $student->payable_fee = $payable_fee;
                $student->paid_fee = $paid_fee;
                $student->remained_fee = $remained_fee;

                if ($request->type === 'Outstanding' && $remained_fee == 0) {

                    unset($students[$key]);

                }

            }
        }


     

        return $students->values()->all();

    }

    public function semesters_pluck()
    {
        $semester = Semester::pluck('semester', 'id');
        return $semester;
    }
    public function years_pluck()
    {
        $annual = Annual::pluck('year', 'id');
        return $annual;
    }
    public function batch_pluck_for_enrollment()
    {
        $batches = Batch::where('status', 1)->pluck('name', 'id');
        return $batches;
    }

}
