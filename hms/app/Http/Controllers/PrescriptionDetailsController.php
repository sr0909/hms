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

class PrescriptionDetailsController extends Controller
{
    public function index(Request $request, $medicalrecordID, $diagnosisID, $treatmentID, $id = null)
    {
        $medicalrecordid = $medicalrecordID;
        $diagnosisid = $diagnosisID;
        $treatmentid = $treatmentID;

        $type = 'create';
        $prescription = null;
        $medicineName = null;
        
        if ($id) {
            $type = 'edit';

            $prescription = Prescription::where('id', $id)->first();

            $medicine = Medicine::where('medicine_id', $prescription->medicine_id)->first();
            $medicineName = $medicine->medicine_name;
        }
        
        return view('medical_record.prescription.details', compact('medicalrecordid', 'diagnosisid', 'treatmentid', 'type', 'prescription', 'medicineName'));
    }

    public function create(Request $request)
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

                // Insert data into treatment table
                Prescription::create([
                    'treatment_id' => $request->treatment_id,
                    'medicine_id' => $request->medicine_id,
                    'dosage' => $request->dosage,
                    'frequency' => $request->frequency,
                    'duration' => $request->duration,
                    'instructions' => $request->instructions,
                ]);
                
                // Commit transaction
                DB::commit();

                return response()->json([
                    'state' => 'success',
                    'message' => 'Prescription created successfully!',
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

    public function getMedicineDosage(Request $request)
    {
        $medicineId = $request->input('medicine_id');
    
        $medicine = Medicine::where('medicine_id', $medicineId)->first();

        $dosage = $medicine->strength;
        
        if ($medicine) {
            return response()->json([
                'state' => 'success',
                'dosage' => $dosage
            ]);
        } else {
            return response()->json(['dosage' => ''], 404);
        }
    }
}
