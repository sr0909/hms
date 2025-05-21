<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash; 
use Yajra\DataTables\DataTables;
use App\Models\Patient;
use App\Models\Staff;
use App\Models\User;

class MyAccountController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        if ($user->hasRole('normal user')) {
            $role = 'patient';

            $loginuser = Patient::where('username', $user->name)->first();

        } else {
            $role = 'staff';

            $loginuser = Staff::where('username', $user->name)->first();
        }

        return view('myaccount.index', compact('role', 'loginuser'));
    }

    public function edit(Request $request, $id = FALSE)
    {
        if ($request->ajax()) {
            DB::beginTransaction();

            try {
                $request->validate([
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
                    'message' => 'Your info is updated successfully!'
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

    public function staffEdit(Request $request, $id = FALSE)
    {
        if ($request->ajax()) {
            DB::beginTransaction();

            try {
                $request->validate([
                    'name' => 'required|max:150',
                    'gender' => 'required|max:1',
                    'email' => 'required|email',
                    'phone' => 'required|max:20',
                    'dob' => 'required',
                    'street' => 'required|max:255',
                    'city' => 'required|max:50',
                    'zip_code' => 'required|max:5',
                    'state' => 'required|max:50',
                ]);

                // Run the select query to get the data in staff table
                $staffs = DB::table('staff')
                                ->where('id', '!=', $id)
                                ->get();
 
                foreach ($staffs as $staff) {
                    if ($request->name == $staff->name) {
                        return response()->json([
                            'state' => 'error',
                            'message' => 'This staff is registered already!'
                        ]);
                    }
                }

                $dob = (new \DateTime($request->dob))->format('Y-m-d');
                
                DB::table('staff')
                    ->where('id', $id)
                    ->update([
                        'name' => $request->name,
                        'gender' => $request->gender,
                        'email' => $request->email,
                        'phone' => $request->phone,
                        'dob' => $dob,
                        'street' => $request->street,
                        'city' => $request->city,
                        'state' => $request->state,
                        'zip_code' => $request->zip_code,
                        'updated_at' => now(),
                    ]);
                
                DB::commit();

                return response()->json([
                    'state' => 'success',
                    'message' => 'Your info is updated successfully!'
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

    public function changePass(Request $request)
    {
        if ($request->ajax()) {
            $user = Auth::user();

            DB::beginTransaction();

            try {
                $request->validate([
                    'old_password' => 'required',
                    'password' => 'required',
                    'confirm_password' => 'required|same:password',
                ]);

                // Run the select query to get the data in users table
                $user = User::where('name', $user->name)->first();

                // Check is the old password match with the password
                if (!Hash::check($request->old_password, $user->password)) {
                    return response()->json([
                        'state' => 'error',
                        'message' => 'Wrong old password!'
                    ], 400);
                }

                DB::table('users')
                ->where('name', $user->name)
                ->update([
                    'password' => bcrypt($request->password),
                    'updated_at' => now(),
                ]);
            
                DB::commit();

                return response()->json([
                    'state' => 'success',
                    'message' => 'Your password is changed successfully!'
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
