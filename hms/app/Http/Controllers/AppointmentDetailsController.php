<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use App\Models\Appointment;
use App\Models\AppointmentTime;
use App\Models\Department;
use App\Models\Doctor;
use App\Models\Staff;
use App\Models\Patient;
use App\Models\RunningNo;

class AppointmentDetailsController extends Controller
{
    public function searchindex(Request $request)
    {
        if ($request->ajax()) {
            $query = Doctor::query()
                        ->join('staff', 'doctor.id', '=', 'staff.id')
                        ->select('doctor.id as doctorId', 'doctor.*', 'staff.*')
                        ->orderBy('dept_id');

            // Filter by date and time if provided
            if ( $request->app_date != "" && $request->app_start_time_id != "" ) {

                // Format app_date in Y-m-d format
                $app_date = \Carbon\Carbon::createFromFormat('d-m-Y', $request->app_date)->format('Y-m-d');

                // Get the start time
                $appointmentTime = DB::table('appointment_time')->where('id', $request->app_start_time_id)->first();
                $app_start_time = $appointmentTime->app_time;

                $docIdsWithAppointment = Appointment::join('appointment_time', 'appointment.app_start_time_id', '=', 'appointment_time.id')
                                        ->where('appointment.app_date', $app_date)
                                        ->whereTime('appointment_time.app_time', '<=', $app_start_time)
                                        ->whereTime('appointment.app_end_time', '>', $app_start_time)
                                        ->where('appointment.status', '!=', 'Cancelled')
                                        ->pluck('appointment.doctor_id');
                
                $query->whereNotIn('doctor.id', $docIdsWithAppointment);
            }

            // Filter by department if provided
            if ($request->dept_id != "") {
                $dept_id = $request->dept_id;

                $query->where('dept_id', $dept_id);
            }

            $data = $query->get();

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('dept_name', function($row){
                    $dept = DB::table('department')->where('id', $row->dept_id)->first();

                    return $dept->dept_name;
                })
                ->addColumn('action', function($row){
                    $btn = '<div class="text-center"><a href="javascript:void(0)" class="btn btn-light btn-sm book-btn" data-id="' . $row->doctorId . '">Book</a></div>';

                    return $btn;
                })
                ->rawColumns(['dept_name', 'action'])
                ->make(true);
        }
        
        $appointmentTimes = AppointmentTime::orderBy('app_time')->get();
        $departments = Department::orderBy('dept_name')->get();

        return view('appointment.search', compact('appointmentTimes', 'departments'));
    }

    public function index(Request $request, $id = null)
    {
        $type = "create";
        $appointment = null;
        $doctor_id = "";
        $doctor_name = "";
        $patient_name = "";
        $dept_id = "";

        if ($id) {
            $first_character = substr($id, 0, 1);
            
            $doctorRunningNo = RunningNo::where('type', 'doctor')->first();
            $doctorPrefix = $doctorRunningNo->prefix;

            if ($first_character == $doctorPrefix) {
                $doctor_id = $id;

                $staff = Staff::where('id', $id)->first();
                $doctor_name = $staff->name;

                $doctor = Doctor::where('id', $id)->first();
                $dept_id = $doctor->dept_id;

            } else {
                $type = "edit";

                $appointment = Appointment::where('id', $id)->first();

                $doctor_id = $appointment->doctor_id;

                $staff = Staff::where('id', $doctor_id)->first();
                $doctor_name = $staff->name;

                $patient = Patient::where('patient_id', $appointment->patient_id)->first();
                $patient_name = $patient->patient_name;
            }
        }

        $appointmentTimes = AppointmentTime::orderBy('app_time')->get();
        $departments = Department::orderBy('dept_name')->get();

        // Retrieve app_date and app_start_time_id from the request
        $app_date = $request->query('app_date');
        $app_start_time_id = $request->query('app_start_time_id');

        // Check is the patient registered or not
        $patient = Patient::where('username', Auth::user()->name)->first();

        if (!$patient) {
            $patientIsRegistered = false;
        }else{
            $patientIsRegistered = true;
        }
        
        return view('appointment.details', compact('type', 'appointment', 'doctor_id', 'doctor_name', 'patient_name', 'dept_id', 'appointmentTimes', 'departments', 'app_date', 'app_start_time_id', 'patientIsRegistered'));
    }

    public function adminIndex(Request $request, $id = null)
    {
        $type = "create";
        $appointment = null;
        $patient_name = "";

        $staff = Staff::where('username', Auth::user()->name)->first();
        $doctor_id = $staff->id;
        $doctor_name = $staff->name;

        $doctor = Doctor::where('id', $doctor_id)->first();
        $dept_id = $doctor->dept_id;

        if ($id) {
            Log::channel('errorlog')->info('id:'. $id);
            $type = "edit";

            $appointment = Appointment::where('id', $id)->first();
            // Log::channel('errorlog')->info('appointment:', $appointment->toArray());
            $patient = Patient::where('patient_id', $appointment->patient_id)->first();
            $patient_name = $patient->patient_name;
        }

        $appointmentTimes = AppointmentTime::orderBy('app_time')->get();
        $departments = Department::orderBy('dept_name')->get();
        
        return view('appointment.admin.details', compact('type', 'appointment', 'doctor_id', 'doctor_name', 'patient_name', 'dept_id', 'appointmentTimes', 'departments'));
    }

    public function create(Request $request)
    {
        if ($request->ajax()) {
            $user = Auth::user();

            DB::beginTransaction();

            try {
                $request->validate([
                    'app_date' => 'required',
                    'app_start_time_id' => 'required',
                    'doctor_name' => 'required|max:150',
                    'duration' => 'required|max:50',
                    'dept_id' => 'required',
                    'type' => 'required|max:50',
                    'patient_id' => 'required|max:10',
                    'patient_name' => 'required|max:150',
                    'status' => 'required|max:30',
                ]);

                // Get the start time
                $appointmentTime = AppointmentTime::where('id', $request->app_start_time_id)->first();
                $app_start_time = $appointmentTime->app_time;

                // Parse the start time
                list($hours, $minutes) = explode(':', $app_start_time);
                $start_hours = (int) $hours;
                $start_minutes = (int) $minutes;

                // Calculate the end time
                $duration_minutes = $request->duration * 60;
                $total_minutes = $start_hours * 60 + $start_minutes + $duration_minutes;

                // Get the end time in hours and minutes
                $end_hours = floor($total_minutes / 60);
                $end_minutes = $total_minutes % 60;

                // Format the end time
                $app_end_time = sprintf('%02d:%02d', $end_hours, $end_minutes);


                // Format dates using DateTime
                $app_date = (new \DateTime($request->app_date))->format('Y-m-d');

                $scheduledAppointmentTime = DB::table('appointment_time')->where('id', $request->app_start_time_id)->first();
                $scheduled_app_start_time = $scheduledAppointmentTime->app_time;

                // Check for doctor availability
                $appointment = Appointment::join('appointment_time', 'appointment.app_start_time_id', '=', 'appointment_time.id')
                                            ->where('appointment.doctor_id', $request->doctor_id)
                                            ->where('appointment.app_date', $app_date)
                                            ->whereTime('appointment_time.app_time', '<=', $scheduled_app_start_time)
                                            ->whereTime('appointment.app_end_time', '>', $scheduled_app_start_time)
                                            ->where('appointment.status', '!=', 'Cancelled')
                                            ->get();

                $checkEndTime = Appointment::join('appointment_time', 'appointment.app_start_time_id', '=', 'appointment_time.id')
                                            ->where('appointment.doctor_id', $request->doctor_id)
                                            ->where('appointment.app_date', $app_date)
                                            ->whereTime('appointment_time.app_time', '<', $app_end_time)
                                            ->whereTime('appointment.app_end_time', '>=', $app_end_time)
                                            ->where('appointment.status', '!=', 'Cancelled')
                                            ->get();

                // Check for patient availability
                $patientAppointment = Appointment::join('appointment_time', 'appointment.app_start_time_id', '=', 'appointment_time.id')
                                            ->where('appointment.patient_id', $request->patient_id)
                                            ->where('appointment.app_date', $app_date)
                                            ->whereTime('appointment_time.app_time', '<=', $scheduled_app_start_time)
                                            ->whereTime('appointment.app_end_time', '>', $scheduled_app_start_time)
                                            ->where('appointment.status', '!=', 'Cancelled')
                                            ->get();

                $patientCheckEndTime = Appointment::join('appointment_time', 'appointment.app_start_time_id', '=', 'appointment_time.id')
                                            ->where('appointment.patient_id', $request->patient_id)
                                            ->where('appointment.app_date', $app_date)
                                            ->whereTime('appointment_time.app_time', '<', $app_end_time)
                                            ->whereTime('appointment.app_end_time', '>=', $app_end_time)
                                            ->where('appointment.status', '!=', 'Cancelled')
                                            ->get();

                // Log::channel('errorlog')->info('doctor_id:'. $request->doctor_id);
                // Log::channel('errorlog')->info('patient_id:'. $request->patient_id);
                // Log::channel('errorlog')->info('appointment:', $appointment->toArray());
                // Log::channel('errorlog')->info('checkEndTime:', $checkEndTime->toArray());
                // Log::channel('errorlog')->info('patientAppointment:', $patientAppointment->toArray());
                // Log::channel('errorlog')->info('patientCheckEndTime:', $patientCheckEndTime->toArray());

                if ($appointment->isNotEmpty() || $checkEndTime->isNotEmpty() || $patientAppointment->isNotEmpty() || $patientCheckEndTime->isNotEmpty())
                {
                    if ($appointment->isNotEmpty() || $checkEndTime->isNotEmpty()) 
                    {
                        if ($user->hasRole('normal user')) {
                            $msg = 'The doctor is not available at this slot! Please try other slots.';
                        } elseif ($user->hasRole('doctor')) {
                            $msg = 'You are not available at this slot! Please try other slots.';
                        }
                    } else {
                        if ($user->hasRole('normal user')) {
                            $msg = 'You are not available at this slot! Please try other slots.';
                        } elseif ($user->hasRole('doctor')) {
                            $msg = 'The patient is not available at this slot! Please try other slots.';
                        }
                    }
                    
                    return response()->json([
                        'state' => 'error',
                        'message' => $msg
                    ]);
                }

                // Insert data into staff table
                Appointment::create([
                    'patient_id' => $request->patient_id,
                    'doctor_id' => $request->doctor_id,
                    'dept_id' => $request->dept_id,
                    'app_date' => $app_date,
                    'app_start_time_id' => $request->app_start_time_id,
                    'app_end_time' => $app_end_time,
                    'duration' => $request->duration,
                    'type' => $request->type,
                    'notes' => $request->notes,
                    'status' => $request->status,
                ]);
                
                // Commit transaction
                DB::commit();

                return response()->json([
                    'state' => 'success',
                    'message' => 'Appointment scheduled successfully!',
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
            $user = Auth::user();

            DB::beginTransaction();

            try {
                $request->validate([
                    'app_date' => 'required',
                    'app_start_time_id' => 'required',
                    'doctor_name' => 'required|max:150',
                    'duration' => 'required|max:50',
                    'dept_id' => 'required',
                    'type' => 'required|max:50',
                    'patient_id' => 'required|max:10',
                    'patient_name' => 'required|max:150',
                    'status' => 'required|max:30',
                ]);

                // Get the start time
                $appointmentTime = AppointmentTime::where('id', $request->app_start_time_id)->first();
                $app_start_time = $appointmentTime->app_time;

                // Parse the start time
                list($hours, $minutes) = explode(':', $app_start_time);
                $start_hours = (int) $hours;
                $start_minutes = (int) $minutes;

                // Calculate the end time
                $duration_minutes = $request->duration * 60;
                $total_minutes = $start_hours * 60 + $start_minutes + $duration_minutes;

                // Get the end time in hours and minutes
                $end_hours = floor($total_minutes / 60);
                $end_minutes = $total_minutes % 60;

                // Format the end time
                $app_end_time = sprintf('%02d:%02d', $end_hours, $end_minutes);


                // Format dates using DateTime
                $app_date = (new \DateTime($request->app_date))->format('Y-m-d');

                $scheduledAppointmentTime = DB::table('appointment_time')->where('id', $request->app_start_time_id)->first();
                $scheduled_app_start_time = $scheduledAppointmentTime->app_time;

                // Check for doctor availability
                $appointment = Appointment::join('appointment_time', 'appointment.app_start_time_id', '=', 'appointment_time.id')
                                            ->where('appointment.doctor_id', $request->doctor_id)
                                            ->where('appointment.app_date', $app_date)
                                            ->whereTime('appointment_time.app_time', '<=', $scheduled_app_start_time)
                                            ->whereTime('appointment.app_end_time', '>', $scheduled_app_start_time)
                                            ->where('appointment.status', '!=', 'Cancelled')
                                            ->where('appointment.id', '!=', $id)
                                            ->get();

                $checkEndTime = Appointment::join('appointment_time', 'appointment.app_start_time_id', '=', 'appointment_time.id')
                                            ->where('appointment.doctor_id', $request->doctor_id)
                                            ->where('appointment.app_date', $app_date)
                                            ->whereTime('appointment_time.app_time', '<', $app_end_time)
                                            ->whereTime('appointment.app_end_time', '>=', $app_end_time)
                                            ->where('appointment.status', '!=', 'Cancelled')
                                            ->where('appointment.id', '!=', $id)
                                            ->get();

                // Check for patient availability
                $patientAppointment = Appointment::join('appointment_time', 'appointment.app_start_time_id', '=', 'appointment_time.id')
                                            ->where('appointment.patient_id', $request->patient_id)
                                            ->where('appointment.app_date', $app_date)
                                            ->whereTime('appointment_time.app_time', '<=', $scheduled_app_start_time)
                                            ->whereTime('appointment.app_end_time', '>', $scheduled_app_start_time)
                                            ->where('appointment.status', '!=', 'Cancelled')
                                            ->where('appointment.id', '!=', $id)
                                            ->get();

                $patientCheckEndTime = Appointment::join('appointment_time', 'appointment.app_start_time_id', '=', 'appointment_time.id')
                                            ->where('appointment.patient_id', $request->patient_id)
                                            ->where('appointment.app_date', $app_date)
                                            ->whereTime('appointment_time.app_time', '<', $app_end_time)
                                            ->whereTime('appointment.app_end_time', '>=', $app_end_time)
                                            ->where('appointment.status', '!=', 'Cancelled')
                                            ->where('appointment.id', '!=', $id)
                                            ->get();

                if ($appointment->isNotEmpty() || $checkEndTime->isNotEmpty() || $patientAppointment->isNotEmpty() || $patientCheckEndTime->isNotEmpty())
                {
                    if ($appointment->isNotEmpty() || $checkEndTime->isNotEmpty()) 
                    {
                        if ($user->hasRole('normal user')) {
                            $msg = 'The doctor is not available at this slot! Please try other slots.';
                        } elseif ($user->hasRole('doctor')) {
                            $msg = 'You are not available at this slot! Please try other slots.';
                        }
                    } else {
                        if ($user->hasRole('normal user')) {
                            $msg = 'You are not available at this slot! Please try other slots.';
                        } elseif ($user->hasRole('doctor')) {
                            $msg = 'The patient is not available at this slot! Please try other slots.';
                        }
                    }
                    
                    return response()->json([
                        'state' => 'error',
                        'message' => $msg
                    ]);
                }

                DB::table('appointment')
                    ->where('id', $id)
                    ->update([
                        'app_date' => $app_date,
                        'app_start_time_id' => $request->app_start_time_id,
                        'app_end_time' => $app_end_time,
                        'duration' => $request->duration,
                        'type' => $request->type,
                        'notes' => $request->notes,
                        'status' => $request->status,
                        'updated_at' => now(),
                    ]);
                
                DB::commit();

                return response()->json([
                    'state' => 'success',
                    'message' => 'Appointment updated successfully!'
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
                DB::table('appointment')->where('id', $id)->delete();

                DB::commit();

                return response()->json([
                    'state' => 'success',
                    'message' => 'This appointment has been deleted!',
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

    public function getPatientId(Request $request)
    {
        if ($request->ajax()) {
            $patientIsRegistered = $request->input('patientIsRegistered');

            $role = 'patient';

            if ($patientIsRegistered == false) {
                $runningno = DB::table('running_no')
                                ->where('type', $role)
                                ->first();

                $num = str_pad($runningno->running_no, 7, '0', STR_PAD_LEFT);

                $patientId = $runningno->prefix . $num;
                $patientName = "";
            }else{
                $patient = Patient::where('username', Auth::user()->name)->first();

                $patientId = $patient->patient_id;
                $patientName = $patient->patient_name;
            }
            
            return response()->json([
                'state' => 'success',
                'patientId' => $patientId,
                'patientName' => $patientName,
            ]);
        }
    }

    public function getPatientNameList(Request $request)
    {
        $search = $request->get('q');

        // Fetch patients from the database matching the search term
        $patients = Patient::where('patient_name', 'LIKE', "%{$search}%")
                        ->limit(10) // Limit the number of results returned
                        ->get(['patient_id', 'patient_name']);
        
        // Format the results to match select2's expectations
        $formattedPatients = $patients->map(function ($patient) {
            return [
                'patient_id' => $patient->patient_id,
                'patient_name' => $patient->patient_name
            ];
        });

        return response()->json($formattedPatients);
    }
}
