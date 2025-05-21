<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use App\Models\Patient;

class PatientDetailsController extends Controller
{
    public function index(Request $request, $id = null)
    {
        $type = 'create';
        $patient = null;
        
        if ($id) {
            $type = 'edit';

            $patient = Patient::where('patient_id', $id)->first();
        }
        
        return view('patient.details', compact('type', 'patient'));
    }

    public function edit(Request $request, $id = FALSE)
    {
        if ($request->ajax()) {
            DB::beginTransaction();

            try {
                $request->validate([
                    'patient_id' => 'required|max:10',
                    'patient_name' => 'required|max:150',
                    'ic' => 'required|max:12',
                    'gender' => 'required|max:1',
                    'email' => 'required|email',
                    'phone' => 'required|max:20',
                    'dob' => 'required',
                    'street' => 'required|max:255',
                    'city' => 'required|max:50',
                    'zip_code' => 'required|max:5',
                    'state' => 'required|max:50',
                    'emergency_contact' => 'required|max:20',
                    'emergency_contact_relationship' => 'required|max:30',
                ]);

                // Run the select query to get the data in patient table
                $patients = DB::table('patient')
                                ->where('patient_id', '!=', $id)
                                ->get();
 
                foreach ($patients as $patient) {
                    if ($request->patient_name == $patient->patient_name) {
                        return response()->json([
                            'state' => 'error',
                            'message' => 'This patient is registered already!'
                        ]);
                    }
                }

                $dob = (new \DateTime($request->dob))->format('Y-m-d');
                
                DB::table('patient')
                    ->where('patient_id', $id)
                    ->update([
                        'patient_name' => $request->patient_name,
                        'gender' => $request->gender,
                        'email' => $request->email,
                        'phone' => $request->phone,
                        'ic' => $request->ic,
                        'dob' => $dob,
                        'street' => $request->street,
                        'city' => $request->city,
                        'state' => $request->state,
                        'zip_code' => $request->zip_code,
                        'emergency_contact' => $request->emergency_contact,
                        'emergency_contact_relationship' => $request->emergency_contact_relationship,
                        'updated_at' => now(),
                    ]);
                
                DB::commit();

                return response()->json([
                    'state' => 'success',
                    'message' => 'Patient updated successfully!'
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
                // Run the select query to get the data in appointment table
                $appointments = DB::select('SELECT * FROM appointment');

                // Check is the patient exists in appointment
                foreach ($appointments as $appointment) {
                    if ($id == $appointment->patient_id) {
                        return response()->json([
                            'state' => 'error',
                            'message' => 'Failed to delete this patient as he/she is associated with other modules!'
                        ]);
                    }
                }

                // Run the select query to get the data in medical_record table
                $medicalrecords = DB::select('SELECT * FROM medical_record');

                // Check is the patient exists in medical_record
                foreach ($medicalrecords as $medicalrecord) {
                    if ($id == $medicalrecord->patient_id) {
                        return response()->json([
                            'state' => 'error',
                            'message' => 'Failed to delete this patient as he/she is associated with other modules!'
                        ]);
                    }
                }
                
                DB::table('patient')->where('patient_id', $id)->delete();

                DB::commit();

                return response()->json([
                    'state' => 'success',
                    'message' => 'This patient has been deleted!',
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

    public function getNewPatientId(Request $request)
    {
        if ($request->ajax()) {
            $runningno = DB::table('running_no')
                        ->where('type', 'patient')
                        ->first();

            $num = str_pad($runningno->running_no, 7, '0', STR_PAD_LEFT);

            $patientId = $runningno->prefix . $num;
            
            return response()->json([
                'state' => 'success',
                'patientId' => $patientId
            ]);
        }
    }
}
