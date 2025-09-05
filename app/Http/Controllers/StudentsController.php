<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Upload;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Inertia\Inertia;

class StudentsController extends Controller
{
    public function index()
    {
        return Inertia::render('Students/Index');
    }
    public function EnrolledStudents()
    {
        return Inertia::render('Students/EnrolledStudents');
    }
    public function enroll_new_students()
    {
        return Inertia::render('Students/CreateNewStudent');
    }
    public function create()
    {
        return Inertia::render('FrontEnd/Enrollment/Enroll');
    }
    public function show($id)
    {
        $studentRecord = Student::findOrFail($id);

        if ($studentRecord->image) {
            $upload = Upload::where('id', $studentRecord->image)->first();
            if ($upload) {
                $profilePicture = $upload ? getFileUrl($upload->file_name) : null;
                $studentRecord->image = $profilePicture;
            }
        }

        return Inertia::render('Students/CreateNewStudent', ['studentId' => $id, 'studentData' => $studentRecord]);
    }
    public function students()
    {
        $students = Student::orderBy('created_at')->get();
        foreach ($students as $student) {
            if ($student->image) {

                $upload = Upload::where('id', $student->image)->first();
                if ($upload) {
                    $profilePicture = $upload ? getFileUrl($upload->file_name) : null;
                    $student->image = $profilePicture;
                }
            }
        }

        return $students;
    }
    public function enrolled_students()
    {
        $students = Student::orderBy('created_at')->where('status', 1)->get();
        foreach ($students as $student) {
            if ($student->image) {

                $upload = Upload::where('id', $student->image)->first();
                if ($upload) {
                    $profilePicture = $upload ? getFileUrl($upload->file_name) : null;
                    $student->image = $profilePicture;
                }
            }
        }

        return $students;
    }

    public function store(Request $request)
    {

        $request->validate([
            'apply_for'          => 'required',
            'name'               => 'required|string|max:255',
            'father'             => 'required|string|max:255',
            'dob'                => 'required|date',
            'cnic'               => 'required|string|max:255',
            'country'            => 'required',
            'province'           => 'required',
            'district'           => 'required',
            'reg_no'             => 'required',
            // 'visaNumber'        =>  'required',
            'phone_number'       => 'required|string|max:255',
            'whatsapp'           => 'required|string|max:255',
            // 'hostelName'         => 'required',
            'guardian_name'      => 'required|string|max:255',
            'guardian_cnic'      => 'required|string|max:255',
            'guardian_mobile'    => 'required|string|max:255',

            'previous_madrasa'   => 'required|string|max:255',
            'previous_class'     => 'required|string|max:255',
            'total_marks'        => 'required|string|max:255',
            'obtained_marks'     => 'required|string|max:255',

            // 'primary_education'  => 'required|string|max:255',
            // 'additional_ability' => 'required|string|max:255',

            'permanent_address'  => 'required|string',
            'current_address'    => 'required|string',
        ]);

        $student = $request->id
            ? Student::findOrFail($request->id)
            : new Student(['id' => Str::uuid()]);

        // Personal Information
        $student->apply_for    = $request->apply_for;
        $student->name         = $request->name;
        $student->father       = $request->father;
        $student->dob          = $request->dob;
        $student->cnic         = $request->cnic;
        $student->reg_no         = $request->reg_no;
        $student->country      = $request->country;
        $student->province     = $request->province;
        $student->district     = $request->district;
        $student->visa    = $request->visaNumber;
        $student->phone_number = $request->phone_number;
        $student->whatsapp     = $request->whatsapp;
        $student->hostel     = $request->hostelName;
        // Guardian Info
        $student->guardian_name   = $request->guardian_name;
        $student->guardian_cnic   = $request->guardian_cnic;
        $student->guardian_mobile = $request->guardian_mobile;

        // Academic Info
        $student->previous_madrasa   = $request->previous_madrasa;
        $student->previous_class     = $request->previous_class;
        $student->total_marks        = $request->total_marks;
        $student->obtained_marks     = $request->obtained_marks;
        $student->primary_education  = $request->primary_education;
        $student->additional_ability = $request->additional_ability;

        // Address
        $student->permanent_address = $request->permanent_address;
        $student->current_address   = $request->current_address;
        $student->session           = Carbon::now()->format('Y');
        $student->status            = $request->status;

        if ($request->image) {
            // Delete old image if exists
            if ($student->image) {
                $existing = Upload::find($student->image);
                if ($existing) {
                    Storage::disk('public')->delete($existing->file_name);
                    File::delete(public_path('storage/' . $existing->file_name)); // clean up public side
                    $existing->delete();
                }
            }

            // Decode Base64 image
            $data = substr($request->image, strpos($request->image, ',') + 1);
            $data = base64_decode($data);

            // Generate unique name and path
            $image_name = Str::random(40) . '.png';
            $image_path = 'StudentImages/' . $image_name;

            // Store in storage/app/public
            Storage::disk('public')->put($image_path, $data);

            // Copy to public/storage for web access (no symlink needed)
            $source      = storage_path('app/public/' . $image_path);
            $destination = public_path('storage/' . $image_path);
            File::ensureDirectoryExists(dirname($destination));
            File::copy($source, $destination);

            // Save in Uploads table
            $upload                     = new Upload;
            $upload->file_original_name = $image_name;
            $upload->extension          = 'png';
            $upload->type               = 'image/png';
            $upload->file_name          = $image_path;
            $upload->save();

            // Attach to transaction
            $student->image = $upload->id;
        }

        if ($request->cnic_front) {
            // Delete old image if exists
            if ($student->cnic_front) {
                Storage::disk('public')->delete($student->cnic_front);
                File::delete(public_path('storage/' . $student->cnic_front)); // clean up public side
            }

            // Decode Base64 image
            $data = substr($request->cnic_front, strpos($request->cnic_front, ',') + 1);
            $data = base64_decode($data);

            // Generate unique name and path
            $image_name = Str::random(40) . '.png';
            $image_path = 'StudentImages/' . $image_name;

            // Store in storage/app/public
            Storage::disk('public')->put($image_path, $data);

            // Copy to public/storage for web access
            $source      = storage_path('app/public/' . $image_path);
            $destination = public_path('storage/' . $image_path);
            File::ensureDirectoryExists(dirname($destination));
            File::copy($source, $destination);

            // Save path in students table (cnic_front column)
            $student->cnic_front = $image_path;
        }

        if ($request->cnic_back) {
            // Delete old image if exists
            if ($student->cnic_back) {
                Storage::disk('public')->delete($student->cnic_back);
                File::delete(public_path('storage/' . $student->cnic_back)); // clean up public side
            }

            // Decode Base64 image
            $data = substr($request->cnic_back, strpos($request->cnic_back, ',') + 1);
            $data = base64_decode($data);

            // Generate unique name and path
            $image_name = Str::random(40) . '.png';
            $image_path = 'StudentImages/' . $image_name;

            // Store in storage/app/public
            Storage::disk('public')->put($image_path, $data);

            // Copy to public/storage for web access
            $source      = storage_path('app/public/' . $image_path);
            $destination = public_path('storage/' . $image_path);
            File::ensureDirectoryExists(dirname($destination));
            File::copy($source, $destination);

            // Save path in students table (cnic_back column)
            $student->cnic_back = $image_path;
        }

        // Save
        $student->save();

        return response()->json([
            'message' => $request->id
                ? 'Student updated successfully'
                : 'Student enrolled successfully',
        ]);
    }

    public function checkAdmissionStatus($cnic)
    {
        $student = Student::select('name', 'cnic', 'father', 'apply_for', 'status')
            ->where('cnic', $cnic)
            ->first();

        return $student;
    }

    public function updateStatus(Request $request)
    {
        // dd($request);
        $student         = Student::findOrFail($request->id);
        $student->status = $request->status;
        $student->save();

        return response()->json(['message' => 'Status updated']);
    }

    public function delete($id)
    {
        $student = Student::findOrFail($id);
        $student->delete();

        return 'success';
    }

    public function findByRegNo($regNo)
    {

      $student = Student::where('reg_no', $regNo)
                ->latest()
                ->first();
        
        if (!$student) {
            return response()->json(['message' => 'Student not found'], 404);
        }

        return response()->json($student);
    }
}
