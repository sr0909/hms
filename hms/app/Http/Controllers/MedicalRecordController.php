<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use App\Models\MedicalRecord;
use App\Models\Diagnosis;
use App\Models\Staff;
use App\Models\Patient;
use App\Models\Doctor;
use App\Models\Department;

class MedicalRecordController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        if ($user->hasRole('doctor')) {
            $staff = Staff::where('username', $user->name)->first();
            $doctorId = $staff->id;
            $doctorName = $staff->name;

        } else if ($user->hasRole('normal user')) {
            $doctorId = "";
            $doctorName = "";

            $patient = Patient::where('username', $user->name)->first();

            if ($patient != "") {
                $patientId = $patient->patient_id;
            } else {
                $patientId = "";
            }
        }

        if ($request->ajax()) {
            $query = DB::table('medical_record');

            if ($user->hasRole('doctor')) {
                if ($request->has('filter_doctor') && $request->filter_doctor != 'ALL') {
                    $query->where('doctor_id', $request->filter_doctor);
                }

            } else if ($user->hasRole('normal user')) {
                $query->where('patient_id', $patientId);
            }

            $data = $query->orderBy('medical_record_date')->get();

            $datatable = Datatables::of($data)
                ->addIndexColumn()
                
                ->addColumn('doctor_name', function($row){
                    $staff = DB::table('staff')->where('id', $row->doctor_id)->first();

                    return $staff->name;
                });

            // Conditionally add columns based on the user role
            if ($user->hasRole('doctor')) {
                $datatable->addColumn('patient_name', function ($row) {
                    $patient = DB::table('patient')->where('patient_id', $row->patient_id)->first();

                    return $patient->patient_name;
                })
                ->addColumn('action', function($row){

                    $btn = '<div class="btn-group"><a href="javascript:void(0)" class="btn btn-light btn-sm me-2 view-btn" data-id="' . $row->medical_record_id . '"><i class="bi bi-eye-fill"></i></a>';

                    $btn = $btn . '<a href="javascript:void(0)" class="btn btn-light btn-sm me-2 edit-btn" data-id="' . $row->medical_record_id . '"><i class="bi bi-pencil-fill"></i></a>';

                    $btn = $btn . '<a href="javascript:void(0)" class="btn btn-light btn-sm delete-btn" data-id="' . $row->medical_record_id . '"><i class="bi bi-trash3-fill"></i></a></div>';

                    return $btn;
                });
            } elseif ($user->hasRole('normal user')) {
                $datatable->addColumn('dept_name', function ($row) {
                    $doctor = DB::table('doctor')->where('id', $row->doctor_id)->first();

                    $department = DB::table('department')->where('id', $doctor->dept_id)->first();

                    return $department->dept_name;
                })
                ->addColumn('action', function($row){
                    
                    $btn = '<a href="javascript:void(0)" class="btn btn-light btn-sm view-btn" data-id="' . $row->medical_record_id . '"><i class="bi bi-eye-fill"></i></a>';
                    
                    return $btn;
                });
            }

            return $datatable
                ->rawColumns(['patient_name', 'dept_name', 'doctor_name', 'action'])
                ->make(true);
        }

        return view('medical_record.index', compact('doctorId', 'doctorName'));
    }

    public function print(Request $request, $id = FALSE)
    {
        $medicalrecord = MedicalRecord::where('medical_record_id', $id)->first();

        if (!$medicalrecord) {
            return response()->json([
                'state' => 'error',
                'message' => 'Medical record not found!'
            ]);
        }

        $patient = Patient::where('patient_id', $medicalrecord->patient_id)->first();
        $staff = Staff::where('id', $medicalrecord->doctor_id)->first();
        $doctor = Doctor::where('id', $medicalrecord->doctor_id)->first();
        $department = Department::where('id', $doctor->dept_id)->first();

        $diagnosislist = Diagnosis::where('medical_record_id', $id)->get();

        // Generate the HTML content for print preview
        $htmlContent = view('medical_record.print', compact('medicalrecord', 'patient', 'staff', 'department', 'diagnosislist'))->render();

        return response($htmlContent);
    }
}
