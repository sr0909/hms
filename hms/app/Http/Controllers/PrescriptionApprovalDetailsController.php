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
use App\Models\Inventory;

class PrescriptionApprovalDetailsController extends Controller
{
    public function index(Request $request, $id = null)
    {
        $treatment = null;
        $diagnosis = null;
        $patientName = null;
        $doctorName = null;

        if ($id) {
            $treatment = Treatment::where('treatment_id', $id)->first();
            $diagnosis = Diagnosis::where('diagnosis_id', $treatment->diagnosis_id)->first();
            $medicalrecord = MedicalRecord::where('medical_record_id', $diagnosis->medical_record_id)->first();

            $patient = Patient::where('patient_id', $medicalrecord->patient_id)->first();
            $patientName = $patient->patient_name;

            $doctor = Staff::where('id', $medicalrecord->doctor_id)->first();
            $doctorName = $doctor->name;
        }

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
        
        return view('prescription.approval', compact('treatment', 'diagnosis', 'patientName', 'doctorName'));
    }

    public function prescriptionDetailsIndex(Request $request, $id = null)
    {
        $prescription = null;
        $medicineName = null;
        
        if ($id) {
            $prescription = Prescription::where('id', $id)->first();

            $medicine = Medicine::where('medicine_id', $prescription->medicine_id)->first();
            $medicineName = $medicine->medicine_name;
        }
        
        return view('prescription.details', compact('prescription', 'medicineName'));
    }

    public function edit(Request $request, $id = FALSE)
    {
        if ($request->ajax()) {
            DB::beginTransaction();

            try {
                $request->validate([
                    'medicine_id' => 'required|max:10',
                    'treatment_id' => 'required|max:10',
                    'dosage' => 'required|max:50',
                    'frequency' => 'required|max:50',
                    'duration' => 'required|max:50',
                ]);
                
                DB::table('prescription')
                    ->where('id', $id)
                    ->update([
                        'medicine_id' => $request->medicine_id,
                        'dosage' => $request->dosage,
                        'frequency' => $request->frequency,
                        'duration' => $request->duration,
                        'instructions' => $request->instructions,
                        'updated_at' => now(),
                    ]);
                
                DB::commit();

                return response()->json([
                    'state' => 'success',
                    'message' => 'Prescription updated successfully!'
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
                DB::table('prescription')->where('id', $id)->delete();

                DB::commit();

                return response()->json([
                    'state' => 'success',
                    'message' => 'This prescription has been deleted!',
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

    public function approve(Request $request, $id = FALSE)
    {
        if ($request->ajax()) {
            DB::beginTransaction();

            try {
                $treatment = Treatment::where('treatment_id', $id)->first();

                if ($treatment->status == 'Approved' || $treatment->status == 'Rejected' || $treatment->status == 'Completed') {
                    return response()->json([
                        'state' => 'error',
                        'message' => 'This prescription has been approved, rejected or completed!'
                    ]);
                }

                // Update inventory of the medicine - 1
                $prescriptionlines = Prescription::where('treatment_id', $id)->get();

                foreach ($prescriptionlines as $prescription) {
                    $inventories = Inventory::where('medicine_id', $prescription->medicine_id)
                                    ->where('status', 'Active')
                                    ->get();
                    
                    $medicine = Medicine::where('medicine_id', $prescription->medicine_id)->first();
                    $medicineName = $medicine->medicine_name;

                    $msg = $medicineName . ' is out of stock!';

                    if ($inventories->isNotEmpty()) {
                        $updated = false;
                        
                        foreach ($inventories as $inventory) {
                            if ($inventory->quantity > 0) {
                                $qty = $inventory->quantity - 1;
    
                                DB::table('inventory')
                                    ->where('id', $inventory->id)
                                    ->update([
                                        'quantity' => $qty,
                                        'updated_at' => now(),
                                    ]);
    
                                $updated = true;
                                break; // Exit the loop once the inventory is updated
                            }
                        }
    
                        if (!$updated) {
                            return response()->json([
                                'state' => 'error',
                                'message' => $msg
                            ]);
                        }
                    } else {
                        return response()->json([
                            'state' => 'error',
                            'message' => $msg
                        ]);
                    }
                }

                DB::table('treatment')
                    ->where('treatment_id', $id)
                    ->update([
                        'status' => 'Approved',
                        'updated_at' => now(),
                    ]);
                
                DB::commit();

                return response()->json([
                    'state' => 'success',
                    'message' => 'Prescription is approved!'
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

    public function reject(Request $request, $id = FALSE)
    {
        if ($request->ajax()) {
            DB::beginTransaction();

            try {
                $treatment = Treatment::where('treatment_id', $id)->first();

                if ($treatment->status == 'Approved' || $treatment->status == 'Rejected' || $treatment->status == 'Completed') {
                    return response()->json([
                        'state' => 'error',
                        'message' => 'This prescription has been approved, rejected or completed!'
                    ]);
                }

                DB::table('treatment')
                    ->where('treatment_id', $id)
                    ->update([
                        'status' => 'Rejected',
                        'updated_at' => now(),
                    ]);
                
                DB::commit();

                return response()->json([
                    'state' => 'success',
                    'message' => 'Prescription is rejected!'
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
}
