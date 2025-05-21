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

class DiagnosisDetailsController extends Controller
{
    public function index(Request $request, $medicalrecordID, $id = null)
    {
        $medicalrecordid = $medicalrecordID;

        $type = 'create';
        $diagnosis = null;
        
        if ($id) {
            $type = 'edit';

            $diagnosis = Diagnosis::where('diagnosis_id', $id)->first();
        }

        if ($request->ajax()) {
            $diagnosisId = $request->input('diagnosisId');

            $data = DB::table('treatment')->where('diagnosis_id', $diagnosisId)->orderBy('start_date')->get();

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('type', function($row){
                    $treatmentType = TreatmentType::where('id', $row->type_id)->first();

                    return $treatmentType->type;
                })
                ->addColumn('action', function($row){
    
                    $btn = '<div class="btn-group"><a href="javascript:void(0)" class="btn btn-light btn-sm me-2 edit-btn" data-id="' . $row->treatment_id . '"><i class="bi bi-pencil-fill"></i></a>';

                    $btn = $btn . '<a href="javascript:void(0)" class="btn btn-light btn-sm delete-btn" data-id="' . $row->treatment_id . '"><i class="bi bi-trash3-fill"></i></a></div>';

                    return $btn;
                })
                ->rawColumns(['type', 'action'])
                ->make(true);
        }
        
        return view('medical_record.diagnosis.details', compact('medicalrecordid', 'type', 'diagnosis'));
    }

    public function create(Request $request)
    {
        if ($request->ajax()) {
            DB::beginTransaction();

            try {
                $request->validate([
                    'diagnosis_id' => 'required|max:10',
                    'medical_record_id' => 'required|max:10',
                    'diagnosis_name' => 'required|max:255',
                    'diagnosis_description' => 'required',
                ]);

                // Insert data into diagnosis table
                Diagnosis::create([
                    'diagnosis_id' => $request->diagnosis_id,
                    'medical_record_id' => $request->medical_record_id,
                    'diagnosis_name' => $request->diagnosis_name,
                    'diagnosis_description' => $request->diagnosis_description,
                ]);

                // Get the current running no
                $runningno = DB::table('running_no')
                            ->where('type', 'diagnosis')
                            ->first();

                $updated_running_no = $runningno->running_no + 1;
                
                // Update running no
                DB::table('running_no')
                    ->where('type', 'diagnosis')
                    ->update([
                        'running_no' => $updated_running_no,
                        'updated_at' => now(),
                    ]);
                
                // Commit transaction
                DB::commit();

                return response()->json([
                    'state' => 'success',
                    'message' => 'Diagnosis Result created successfully!',
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
                    'diagnosis_id' => 'required|max:10',
                    'medical_record_id' => 'required|max:10',
                    'diagnosis_name' => 'required|max:255',
                    'diagnosis_description' => 'required',
                ]);
                
                DB::table('diagnosis')
                    ->where('diagnosis_id', $id)
                    ->update([
                        'diagnosis_name' => $request->diagnosis_name,
                        'diagnosis_description' => $request->diagnosis_description,
                        'updated_at' => now(),
                    ]);
                
                DB::commit();

                return response()->json([
                    'state' => 'success',
                    'message' => 'Diagnosis Result updated successfully!'
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
                // Check the treatment status is in progress or not
                $treatments = Treatment::where('diagnosis_id', $id)->get();

                foreach ($treatments as $treatment) {
                    if ($treatment->status == 'In Progress') {
                        return response()->json([
                            'state' => 'error',
                            'message' => 'Failed to delete diagnosis result since the treatment is still in progress!'
                        ]);
                    }

                    // Delete prescription of the treatment
                    DB::table('prescription')->where('treatment_id', $treatment->treatment_id)->delete();
                }

                // Delete treatment of the diagnosis
                DB::table('treatment')->where('diagnosis_id', $id)->delete();

                // Delete diagnosis header
                DB::table('diagnosis')->where('diagnosis_id', $id)->delete();

                DB::commit();

                return response()->json([
                    'state' => 'success',
                    'message' => 'This diagnosis has been deleted!',
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

    public function getDiagnosisId(Request $request)
    {
        if ($request->ajax()) {
            $runningno = DB::table('running_no')
                        ->where('type', 'diagnosis')
                        ->first();

            $num = str_pad($runningno->running_no, 7, '0', STR_PAD_LEFT);

            $diagnosisId = $runningno->prefix . $num;
            
            return response()->json([
                'state' => 'success',
                'diagnosisId' => $diagnosisId
            ]);
        }
    }

    public function getDiagnosisCreatedStatus(Request $request)
    {
        if ($request->ajax()) {
            $diagnosisId = $request->input('diagnosisId');
            
            $diagnosis = Diagnosis::where('diagnosis_id', $diagnosisId)->get();

            if ($diagnosis->isNotEmpty()) {
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
