<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use App\Models\MedicalRecord;
use App\Models\Diagnosis;
use App\Models\Treatment;
use App\Models\TreatmentType;
use App\Models\Medicine;
use App\Models\Prescription;
use App\Models\Patient;
use App\Models\Staff;

class PrescriptionApprovalController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Treatment::select('medical_record.medical_record_id', 'medical_record.patient_id', 'medical_record.doctor_id', 'diagnosis.diagnosis_id', 'diagnosis.diagnosis_name', 'treatment.treatment_id', 'treatment.treatment_name', 'treatment.type_id', 'treatment.start_date', 'treatment.status')
                                ->join('diagnosis', 'treatment.diagnosis_id', '=', 'diagnosis.diagnosis_id')
                                ->join('medical_record', 'diagnosis.medical_record_id', '=', 'medical_record.medical_record_id')
                                ->where('treatment.type_id', 1);
                                
            if ($request->has('filter_status') && $request->filter_status != 'ALL') {
                $query->where('treatment.status', $request->filter_status);
            }

            $data = $query->orderBy('start_date')->get();

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('patient_name', function($row){
                    $patient = Patient::where('patient_id', $row->patient_id)->first();

                    return $patient->patient_name;
                })
                ->addColumn('doctor_name', function($row){
                    $doctor = Staff::where('id', $row->doctor_id)->first();

                    return $doctor->name;
                })
                ->addColumn('action', function($row){
    
                    $btn = '<a href="javascript:void(0)" class="btn btn-light btn-sm me-2 edit-btn" data-id="' . $row->treatment_id . '"><i class="bi bi-pencil-fill"></i></a>';

                    return $btn;
                })
                ->rawColumns(['patient_name', 'doctor_name', 'action'])
                ->make(true);
        }

        return view('prescription.index');
    }
}
