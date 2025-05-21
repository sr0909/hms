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

class TreatmentDetailsController extends Controller
{
    public function index(Request $request, $medicalrecordID, $diagnosisID, $id = null)
    {
        $medicalrecordid = $medicalrecordID;
        $diagnosisid = $diagnosisID;

        $type = 'create';
        $treatment = null;
        
        if ($id) {
            $type = 'edit';

            $treatment = Treatment::where('treatment_id', $id)->first();
        }

        $treatmentTypes = TreatmentType::orderBy('type')->get();

        if ($request->ajax()) {
            $treatmentId = $request->input('treatmentId');

            $data = DB::table('prescription')->where('treatment_id', $treatmentId)->orderBy('medicine_id')->get();

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('medicine_name', function($row){
                    $medicine = Medicine::where('medicine_id', $row->medicine_id)->first();

                    return $medicine->medicine_name;
                })
                ->addColumn('action', function($row){
    
                    $btn = '<div class="btn-group"><a href="javascript:void(0)" class="btn btn-light btn-sm me-2 edit-btn" data-id="' . $row->id . '"><i class="bi bi-pencil-fill"></i></a>';

                    $btn = $btn . '<a href="javascript:void(0)" class="btn btn-light btn-sm delete-btn" data-id="' . $row->id . '"><i class="bi bi-trash3-fill"></i></a></div>';

                    return $btn;
                })
                ->rawColumns(['medicine_name', 'action'])
                ->make(true);
        }
        
        return view('medical_record.treatment.details', compact('medicalrecordid', 'diagnosisid', 'type', 'treatmentTypes', 'treatment'));
    }

    public function create(Request $request)
    {
        if ($request->ajax()) {
            DB::beginTransaction();

            try {
                $request->validate([
                    'treatment_id' => 'required|max:10',
                    'diagnosis_id' => 'required|max:10',
                    'start_date' => 'required',
                    'type_id' => 'required',
                    'status' => 'required|max:30',
                    'treatment_name' => 'required|max:255',
                    'treatment_description' => 'required',
                ]);

                // Format dates using DateTime
                $start_date = (new \DateTime($request->start_date))->format('Y-m-d');

                if ($request->end_date == '') {
                    $end_date = null;
                } else {
                    $end_date = (new \DateTime($request->end_date))->format('Y-m-d');
                }

                if ($request->status == 'Completed') {
                    // Get today's date
                    $today = new \DateTime();
                    $todayFormatted = $today->format('Y-m-d');

                    if ($end_date == null) {
                        // Check if start_date after today
                        if ($start_date > $todayFormatted) {
                            return response()->json([
                                'state' => 'error',
                                'message' => 'Treatment status cannot be completed as the treatment has not started yet!'
                            ]);
                        }
                    } else {
                        // Check if end_date after today
                        if ($end_date > $todayFormatted) {
                            return response()->json([
                                'state' => 'error',
                                'message' => 'Treatment status cannot be completed as the treatment is not ended!'
                            ]);
                        }
                    }
                }

                // Check is the treatment type = medication, if yes the status = pending
                if ($request->type_id == 1) {
                    $status = 'Pending';
                } else {
                    $status = $request->status;
                }

                // Insert data into treatment table
                Treatment::create([
                    'treatment_id' => $request->treatment_id,
                    'diagnosis_id' => $request->diagnosis_id,
                    'treatment_name' => $request->treatment_name,
                    'treatment_description' => $request->treatment_description,
                    'type_id' => $request->type_id,
                    'start_date' => $start_date,
                    'end_date' => $end_date,
                    'status' => $status,
                ]);

                // Get the current running no
                $runningno = DB::table('running_no')
                            ->where('type', 'treatment')
                            ->first();

                $updated_running_no = $runningno->running_no + 1;
                
                // Update running no
                DB::table('running_no')
                    ->where('type', 'treatment')
                    ->update([
                        'running_no' => $updated_running_no,
                        'updated_at' => now(),
                    ]);
                
                // Commit transaction
                DB::commit();

                return response()->json([
                    'state' => 'success',
                    'message' => 'Treatment created successfully!',
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
                    'treatment_id' => 'required|max:10',
                    'diagnosis_id' => 'required|max:10',
                    'start_date' => 'required',
                    'type_id' => 'required',
                    'status' => 'required|max:30',
                    'treatment_name' => 'required|max:255',
                    'treatment_description' => 'required',
                ]);

                // Format dates using DateTime
                $start_date = (new \DateTime($request->start_date))->format('Y-m-d');

                if ($request->end_date == '') {
                    $end_date = null;
                } else {
                    $end_date = (new \DateTime($request->end_date))->format('Y-m-d');
                }

                if ($request->status == 'Completed') {
                    // Get today's date
                    $today = new \DateTime();
                    $todayFormatted = $today->format('Y-m-d');

                    if ($end_date == null) {
                        // Check if start_date after today
                        if ($start_date > $todayFormatted) {
                            return response()->json([
                                'state' => 'error',
                                'message' => 'Treatment status cannot be completed as the treatment has not started yet!'
                            ]);
                        }
                    } else {
                        // Check if end_date after today
                        if ($end_date > $todayFormatted) {
                            return response()->json([
                                'state' => 'error',
                                'message' => 'Treatment status cannot be completed as the treatment is not ended!'
                            ]);
                        }
                    }

                    if ($request->type_id == 1) {
                        // Status cannot changed to completed if the status = pending, rejected
                        $treatment = Treatment::where('treatment_id', $id)->first();
    
                        if ($treatment->status == 'Pending' || $treatment->status == 'Rejected') {
                            return response()->json([
                                'state' => 'error',
                                'message' => 'Treatment status cannot be completed as the prescription waiting for approval or has been rejected!'
                            ]);
                        }
                    }
                }

                // Check whether the treatment has prescription records when the type is not medication
                if ($request->type_id != 1) {
                    $prescription = Prescription::where('treatment_id', $id)->get();

                    if ($prescription->isNotEmpty()) {
                        return response()->json([
                            'state' => 'error',
                            'message' => 'Please delete the existing prescription first to change to other treatments!'
                        ]);
                    }
                }
                
                DB::table('treatment')
                    ->where('treatment_id', $id)
                    ->update([
                        'treatment_name' => $request->treatment_name,
                        'treatment_description' => $request->treatment_description,
                        'type_id' => $request->type_id,
                        'start_date' => $start_date,
                        'end_date' => $end_date,
                        'status' => $request->status,
                        'updated_at' => now(),
                    ]);
                
                DB::commit();

                return response()->json([
                    'state' => 'success',
                    'message' => 'Treatment updated successfully!'
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
                $treatment = Treatment::where('treatment_id', $id)->first();

                if ($treatment->status == 'In Progress') {
                    return response()->json([
                        'state' => 'error',
                        'message' => 'Failed to delete treatment since it is still in progress!'
                    ]);
                }

                DB::table('prescription')->where('treatment_id', $id)->delete();

                DB::table('treatment')->where('treatment_id', $id)->delete();

                DB::commit();

                return response()->json([
                    'state' => 'success',
                    'message' => 'This treatment has been deleted!',
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

    public function getTreatmentId(Request $request)
    {
        if ($request->ajax()) {
            $runningno = DB::table('running_no')
                        ->where('type', 'treatment')
                        ->first();

            $num = str_pad($runningno->running_no, 7, '0', STR_PAD_LEFT);

            $treatmentId = $runningno->prefix . $num;
            
            return response()->json([
                'state' => 'success',
                'treatmentId' => $treatmentId
            ]);
        }
    }

    public function getTreatmentCreatedStatus(Request $request)
    {
        if ($request->ajax()) {
            $treatmentId = $request->input('treatmentId');
            
            $treatment = Treatment::where('treatment_id', $treatmentId)->get();

            if ($treatment->isNotEmpty()) {
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
