<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use App\Models\Patient;

class PatientController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = DB::table('patient')->orderBy('patient_name')->get();

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
    
                    $btn = '<div class="btn-group"><a href="javascript:void(0)" class="btn btn-light btn-sm me-2 edit-btn" data-id="' . $row->patient_id . '"><i class="bi bi-pencil-fill"></i></a>';

                    $btn = $btn . '<a href="javascript:void(0)" class="btn btn-light btn-sm delete-btn" data-id="' . $row->patient_id . '"><i class="bi bi-trash3-fill"></i></a></div>';

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        
        return view('patient.index');
    }
    
    public function create(Request $request)
    {
        if ($request->ajax()) {
            $user = Auth::user();

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

                $update = false;

                // Run the select query to get the data in patient table
                $patients = DB::select('SELECT * FROM patient');

                if ($user->hasRole('normal user')) {
                    foreach ($patients as $patient) {
                        if ($request->patient_name == $patient->patient_name && $patient->username != null) {
                            return response()->json([
                                'state' => 'error',
                                'message' => 'This patient is registered already!'
                            ]);
                        } else if ($request->patient_name == $patient->patient_name && $patient->username == null) {
                            $update = true;

                            $updatedPatientId = $patient->patient_id;
                        }
                    }

                    $username = Auth::user()->name;

                }else{
                    // Check is the patient name exists
                    foreach ($patients as $patient) {
                        if ($request->patient_name == $patient->patient_name) {
                            return response()->json([
                                'state' => 'error',
                                'message' => 'This patient is registered already!'
                            ]);
                        }
                    }

                    $username = null;
                }

                $dob = (new \DateTime($request->dob))->format('Y-m-d');

                if ($update == true) {
                    DB::table('patient')
                        ->where('patient_id', $updatedPatientId)
                        ->update([
                            'username' => $username,
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

                }else{
                    // Insert data into database
                    Patient::create([
                        'patient_id' => $request->patient_id,
                        'patient_name' => $request->patient_name,
                        'username' => $username,
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
                    ]);

                    // Get the current running no
                    $runningno = DB::table('running_no')
                                ->where('type', 'patient')
                                ->first();

                    $updated_running_no = $runningno->running_no + 1;
                    
                    // Update running no
                    DB::table('running_no')
                        ->where('type', 'patient')
                        ->update([
                            'running_no' => $updated_running_no,
                            'updated_at' => now(),
                        ]);
                }
                
                // Commit transaction
                DB::commit();

                return response()->json([
                    'state' => 'success',
                    'message' => 'Patient registered successfully!',
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
}
