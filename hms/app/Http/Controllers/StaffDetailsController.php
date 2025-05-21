<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use App\Models\Staff;
use App\Models\User;
use App\Models\Doctor;
use App\Models\Department;

class StaffDetailsController extends Controller
{
    public function index(Request $request, $id = null)
    {
        $type = 'create';
        $staff = null;
        $role = null;
        $doctor = null;
        
        if ($id) {
            $type = 'edit';

            $staff = DB::table('staff')
                        ->where('id', $id)
                        ->first();

            $role = $staff->role;
            
            if ($staff && $role == 'doctor') {
                $doctor = DB::table('doctor')
                            ->where('id', $id)
                            ->first();
            }
        }
        
        $departments = Department::all();
        
        return view('staff.details', compact('type', 'departments', 'staff', 'role', 'doctor'));
    }

    public function create(Request $request)
    {
        if ($request->ajax()) {
            DB::beginTransaction();

            try {
                $request->validate([
                    'role' => 'required|max:50',
                    'id' => 'required|max:10',
                    'name' => 'required|max:150',
                    'email' => 'required|email',
                    'gender' => 'required|max:1',
                    'phone' => 'required|max:20',
                    'street' => 'required|max:255',
                    'city' => 'required|max:50',
                    'zip_code' => 'required|max:5',
                    'state' => 'required|max:50',
                    'dob' => 'required',
                    'hired_date' => 'required',
                    'salary' => 'max:11',
                    'status' => 'required|max:30',
                    'username' => 'required|max:255',
                    'password' => 'required',
                    'confirm_password' => 'required|same:password',
                ]);

                if ($request->role === 'doctor') {
                    $request->validate([
                        'dept_id' => 'required|max:7',
                        'years_of_experience' => 'required|numeric|min:1|max:100',
                    ]);
                }

                // Count the number of staff records match with the given name from the request
                $staffCount = Staff::where('name', $request->name)->count();

                if ($staffCount > 0) {
                    return response()->json([
                        'state' => 'error',
                        'message' => 'This staff is registered already!'
                    ]);
                }
                
                // Run the select query to get the data in users table
                $users = DB::select('SELECT * FROM users');

                // Check is the email and name exists
                foreach ($users as $user) {
                    if ($request->email == $user->email) {
                        return response()->json([
                            'state' => 'error',
                            'message' => 'This email is registered already!'
                        ]);
                    }

                    if ($request->username == $user->name) {
                        return response()->json([
                            'state' => 'error',
                            'message' => 'This username is registered already!'
                        ]);
                    }
                }

                // Format dates using DateTime
                $dob = (new \DateTime($request->dob))->format('Y-m-d');
                $hired_date = (new \DateTime($request->hired_date))->format('Y-m-d');

                if ($request->status == 'Active') {
                    $terminated_date = null;
                }else{
                    $terminated_date = (new \DateTime($request->terminated_date))->format('Y-m-d');
                }

                // Insert data into staff table
                Staff::create([
                    'id' => $request->id,
                    'role' => $request->role,
                    'name' => $request->name,
                    'username' => $request->username,
                    'gender' => $request->gender,
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'dob' => $dob,
                    'street' => $request->street,
                    'city' => $request->city,
                    'state' => $request->state,
                    'zip_code' => $request->zip_code,
                    'hired_date' => $hired_date,
                    'terminated_date' => $terminated_date,
                    'salary' => $request->salary,
                    'status' => $request->status,
                ]);

                // Insert data into users table
                $newuser = User::create([
                    'name' => $request->username,
                    'email' => $request->email,
                    'password' => bcrypt($request->password), // Hashing password
                ]);

                $newuser->assignRole($request->role);

                // Insert data into doctor table
                if ($request->role === 'doctor') {
                    Doctor::create([
                        'id' => $request->id,
                        'dept_id' => $request->dept_id,
                        'years_of_experience' => $request->years_of_experience,
                    ]);
                }

                // Get the current running no
                $runningno = DB::table('running_no')
                            ->where('type', $request->role)
                            ->first();

                $updated_running_no = $runningno->running_no + 1;
                
                // Update running no
                DB::table('running_no')
                    ->where('type', $request->role)
                    ->update([
                        'running_no' => $updated_running_no,
                        'updated_at' => now(),
                    ]);
                
                // Commit transaction
                DB::commit();

                return response()->json([
                    'state' => 'success',
                    'role' => $request->role,
                    'doctor_id' => $request->id, 
                    'message' => 'Staff registered successfully!',
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
                    'role' => 'required|max:50',
                    'id' => 'required|max:10',
                    'name' => 'required|max:150',
                    'email' => 'required|email',
                    'gender' => 'required|max:1',
                    'phone' => 'required|max:20',
                    'street' => 'required|max:255',
                    'city' => 'required|max:50',
                    'zip_code' => 'required|max:5',
                    'state' => 'required|max:50',
                    'dob' => 'required',
                    'hired_date' => 'required',
                    'salary' => 'max:11',
                    'status' => 'required|max:30',
                ]);

                if ($request->role === 'doctor') {
                    $request->validate([
                        'dept_id' => 'required|max:7',
                        'years_of_experience' => 'required|numeric|min:1|max:100',
                    ]);
                }

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

                // Format dates using DateTime
                $dob = (new \DateTime($request->dob))->format('Y-m-d');
                $hired_date = (new \DateTime($request->hired_date))->format('Y-m-d');

                if ($request->status == 'Active') {
                    $terminated_date = null;
                }else{
                    $terminated_date = (new \DateTime($request->terminated_date))->format('Y-m-d');
                }

                // Update staff table
                DB::table('staff')
                    ->where('id', $id)
                    ->update([
                        'name' => $request->name,
                        'gender' => $request->gender,
                        'phone' => $request->phone,
                        'dob' => $dob,
                        'street' => $request->street,
                        'city' => $request->city,
                        'state' => $request->state,
                        'zip_code' => $request->zip_code,
                        'hired_date' => $hired_date,
                        'terminated_date' => $terminated_date,
                        'salary' => $request->salary,
                        'status' => $request->status,
                        'updated_at' => now(),
                    ]);
                
                if ($request->role === 'doctor') {
                    DB::table('doctor')
                        ->where('id', $id)
                        ->update([
                            'dept_id' => $request->dept_id,
                            'years_of_experience' => $request->years_of_experience,
                        ]);
                }
                
                DB::commit();

                return response()->json([
                    'state' => 'success',
                    'message' => 'Staff updated successfully!'
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

    public function getStaffId(Request $request)
    {
        if ($request->ajax()) {
            $role = $request->input('role');

            if ($role != '') {
                // Get the info of running_no
                $runningno = DB::table('running_no')
                            ->where('type', $role)
                            ->first();

                // Add 0 before the running_no
                $num = str_pad($runningno->running_no, 7, '0', STR_PAD_LEFT);

                // Concatenate the prefix with num
                $staffId = $runningno->prefix . $num;
            }else{
                $staffId = '';
            }
            
            return response()->json([
                'state' => 'success',
                'staffId' => $staffId
            ]);
        }
    }

    public function destroy(Request $request, $id = FALSE)
    {
        if ($request->ajax()) {
            DB::beginTransaction();

            try {
                $staff = DB::table('staff')
                            ->where('id', $id)
                            ->first();
                
                if ($staff->role === 'doctor') {
                    // Run the select query to get the data in appointment table
                    $appointments = DB::select('SELECT * FROM appointment');

                    // Check is the doctor exists in appointment
                    foreach ($appointments as $appointment) {
                        if ($id == $appointment->doctor_id) {
                            return response()->json([
                                'state' => 'error',
                                'message' => 'Failed to delete this doctor as he/she is associated with other modules!'
                            ]);
                        }
                    }

                    // Run the select query to get the data in medical_record table
                    $medicalrecords = DB::select('SELECT * FROM medical_record');

                    // Check is the doctor exists in medical_record
                    foreach ($medicalrecords as $medicalrecord) {
                        if ($id == $medicalrecord->doctor_id) {
                            return response()->json([
                                'state' => 'error',
                                'message' => 'Failed to delete this doctor as he/she is associated with other modules!'
                            ]);
                        }
                    }
                    
                    DB::table('doctor')->where('id', $id)->delete();
                }
                
                // Delete from users table
                DB::table('users')->where('name', $staff->username)->delete();

                // Delete from staff table
                DB::table('staff')->where('id', $id)->delete();

                DB::commit();

                return response()->json([
                    'state' => 'success',
                    'message' => 'This staff has been deleted!',
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
