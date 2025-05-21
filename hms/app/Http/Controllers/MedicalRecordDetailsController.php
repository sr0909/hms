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
use App\Models\Staff;
use App\Models\Patient;

class MedicalRecordDetailsController extends Controller
{
    public function index(Request $request, $id = null)
    {
        $type = 'create';
        $medicalrecord = null;
        $patientname = null;

        $staff = Staff::where('username', Auth::user()->name)->first();
        $doctorname = $staff->name;
        
        if ($id) {
            $type = 'edit';

            $medicalrecord = MedicalRecord::where('medical_record_id', $id)->first();

            $patient = Patient::where('patient_id', $medicalrecord->patient_id)->first();
            $patientname = $patient->patient_name;

            $staff = Staff::where('id', $medicalrecord->doctor_id)->first();
            $doctorname = $staff->name;
        }

        if ($request->ajax()) {
            $medicalRecordId = $request->input('medicalRecordId');

            $data = DB::table('diagnosis')->where('medical_record_id', $medicalRecordId)->orderBy('diagnosis_id')->get();

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
    
                    $btn = '<div class="btn-group"><a href="javascript:void(0)" class="btn btn-light btn-sm me-2 edit-btn" data-id="' . $row->diagnosis_id . '"><i class="bi bi-pencil-fill"></i></a>';

                    $btn = $btn . '<a href="javascript:void(0)" class="btn btn-light btn-sm delete-btn" data-id="' . $row->diagnosis_id . '"><i class="bi bi-trash3-fill"></i></a></div>';

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        
        return view('medical_record.details', compact('type', 'medicalrecord', 'patientname', 'doctorname'));
    }

    public function create(Request $request)
    {
        if ($request->ajax()) {
            DB::beginTransaction();

            try {
                $request->validate([
                    'medical_record_id' => 'required|max:10',
                    'patient_id' => 'required|max:10',
                    'patient_name' => 'required|max:150',
                    'medical_record_date' => 'required',
                    'status' => 'required|max:30',
                ]);
                
                // Get Doctor ID
                $staff = Staff::where('username', Auth::user()->name)->first();
                $doctorId = $staff->id;

                // Format dates using DateTime
                $medical_record_date = (new \DateTime($request->medical_record_date))->format('Y-m-d');

                // Status cannot be closed when created
                if ($request->status == 'Closed') {
                    return response()->json([
                        'state' => 'error',
                        'message' => 'Status cannot be closed when medical record is created!'
                    ]);
                }

                // Insert data into medical_record table
                MedicalRecord::create([
                    'medical_record_id' => $request->medical_record_id,
                    'patient_id' => $request->patient_id,
                    'doctor_id' => $doctorId,
                    'medical_record_date' => $medical_record_date,
                    'notes' => $request->notes,
                    'status' => $request->status,
                ]);

                // Get the current running no
                $runningno = DB::table('running_no')
                            ->where('type', 'medical record')
                            ->first();

                $updated_running_no = $runningno->running_no + 1;
                
                // Update running no
                DB::table('running_no')
                    ->where('type', 'medical record')
                    ->update([
                        'running_no' => $updated_running_no,
                        'updated_at' => now(),
                    ]);
                
                // Commit transaction
                DB::commit();

                return response()->json([
                    'state' => 'success',
                    'message' => 'Medical record created successfully!',
                ]);

            } catch (\Exception $e) {
                // Roll back the transaction if an exception occurs
                DB::rollback();

                // Returning error message
                return response()->json([
                    'state' => 'error',
                    'message' => $e->getMessage()
                ], 500);
            }
        }
    }

    public function edit(Request $request, $id = FALSE)
    {
        if ($request->ajax()) {
            DB::beginTransaction();

            try {
                $request->validate([
                    'medical_record_id' => 'required|max:10',
                    'patient_id' => 'required|max:10',
                    'patient_name' => 'required|max:150',
                    'medical_record_date' => 'required',
                    'status' => 'required|max:30',
                ]);

                // Status cannot be closed when there is any treatment is scheduled or in progress
                // Get diagnosis of the medical record
                $diagnosislist = Diagnosis::where('medical_record_id', $id)->get();

                foreach ($diagnosislist as $diagnosis) {
                    // Check the treatment status is in progress or not
                    $treatments = Treatment::where('diagnosis_id', $diagnosis->diagnosis_id)->get();

                    foreach ($treatments as $treatment) {
                        if ($treatment->status == 'Scheduled' || $treatment->status == 'In Progress') {
                            return response()->json([
                                'state' => 'error',
                                'message' => 'Failed to close medical record since there is scheduled or in progress treatment!'
                            ]);
                        }
                    }
                }
                
                DB::table('medical_record')
                    ->where('medical_record_id', $id)
                    ->update([
                        'notes' => $request->notes,
                        'status' => $request->status,
                        'updated_at' => now(),
                    ]);
                
                DB::commit();

                return response()->json([
                    'state' => 'success',
                    'message' => 'Medical Record updated successfully!'
                ]);

            } catch (\Exception $e) {
                DB::rollback();

                return response()->json([
                    'state' => 'error',
                    'message' => $e->getMessage()
                ], 500);
            }
        }
    }

    public function destroy(Request $request, $id = FALSE)
    {
        if ($request->ajax()) {
            DB::beginTransaction();

            try {
                // Get diagnosis of the medical record
                $diagnosislist = Diagnosis::where('medical_record_id', $id)->get();

                foreach ($diagnosislist as $diagnosis) {
                    // Check the treatment status is in progress or not
                    $treatments = Treatment::where('diagnosis_id', $diagnosis->diagnosis_id)->get();

                    foreach ($treatments as $treatment) {
                        if ($treatment->status == 'In Progress') {
                            return response()->json([
                                'state' => 'error',
                                'message' => 'Failed to delete medical record since there is treatment in progress!'
                            ]);
                        }

                        // Delete prescription of the treatment
                        DB::table('prescription')->where('treatment_id', $treatment->treatment_id)->delete();
                    }

                    // Delete treatment
                    DB::table('treatment')->where('diagnosis_id', $diagnosis->diagnosis_id)->delete();
                }
                
                // Delete diagnosis
                DB::table('diagnosis')->where('medical_record_id', $id)->delete();

                // Delete medical record header
                DB::table('medical_record')->where('medical_record_id', $id)->delete();

                DB::commit();

                return response()->json([
                    'state' => 'success',
                    'message' => 'This medical record has been deleted!',
                ]);
            } catch (\Exception $e) {
                DB::rollback();

                return response()->json([
                    'state' => 'error',
                    'message' => $e->getMessage()
                ], 500);
            }
        }
    }

    public function getMedicalRecordId(Request $request)
    {
        if ($request->ajax()) {
            $runningno = DB::table('running_no')
                        ->where('type', 'medical record')
                        ->first();

            $num = str_pad($runningno->running_no, 7, '0', STR_PAD_LEFT);

            $medicalRecordId = $runningno->prefix . $num;
            
            return response()->json([
                'state' => 'success',
                'medicalRecordId' => $medicalRecordId
            ]);
        }
    }

    public function getMRCreatedStatus(Request $request)
    {
        if ($request->ajax()) {
            $medicalRecordId = $request->input('medicalRecordId');

            // Run query to get the medical record with the medical record ID
            $medicalRecord = MedicalRecord::where('medical_record_id', $medicalRecordId)->get();

            if ($medicalRecord->isNotEmpty()) {
                $createdStatus = true;
            } else {
                $createdStatus = false;
            }

            return response()->json([
                'state' => 'success',
                'createdStatus' => $createdStatus
            ]);
        }
    }
}
