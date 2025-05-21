<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use App\Models\Appointment;
use App\Models\AppointmentTime;
use App\Models\Patient;
use App\Models\Staff;

class AppointmentController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $user = Auth::user();

            $query = DB::table('appointment')
                        ->select('appointment.id', 'appointment.patient_id', 'appointment.doctor_id', 'appointment.dept_id', 'appointment.app_date', 'appointment.app_start_time_id', 'appointment.app_end_time', 'appointment.duration', 'appointment.type', 'appointment.notes', 'appointment.status', 'appointment.created_at', 'appointment.updated_at', 'appointment_time.app_time')
                        ->join('appointment_time', 'appointment.app_start_time_id', '=', 'appointment_time.id');

            if ($user->hasRole('normal user')) {
                $patient = Patient::where('username', Auth::user()->name)->first();

                if ($patient != "") {
                    $patientId = $patient->patient_id;
                }else{
                    $patientId = "";
                }

                $query->where('patient_id', $patientId);

            } elseif ($user->hasRole('doctor')) {
                $doctor = Staff::where('username', Auth::user()->name)->first();
                
                if ($doctor != "") {
                    $doctorId = $doctor->id;
                }else{
                    $doctorId = "";
                }

                $query->where('doctor_id', $doctorId);
            }

            if ($request->has('filter_status') && $request->filter_status != 'ALL') {
                $query->where('status', $request->filter_status);
            }

            $data = $query->orderBy('app_date')->orderBy('appointment_time.app_time')->get();

            $datatable = Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('app_time', function($row){
                    $appointmentTime = AppointmentTime::where('id', $row->app_start_time_id)->first();

                    return $appointmentTime->app_time;
                })
                ->addColumn('formatted_duration', function($row){
                    $formattedDuration = $row->duration . ' hour(s)';

                    return $formattedDuration;
                })
                ->addColumn('dept_name', function($row){
                    $dept = DB::table('department')->where('id', $row->dept_id)->first();

                    return $dept->dept_name;
                })
                ->addColumn('action', function($row){
    
                    $btn = '<div class="btn-group"><a href="javascript:void(0)" class="btn btn-light btn-sm me-2 edit-btn" data-id="' . $row->id . '"><i class="bi bi-pencil-fill"></i></a>';

                    $btn = $btn . '<a href="javascript:void(0)" class="btn btn-light btn-sm delete-btn" data-id="' . $row->id . '"><i class="bi bi-trash3-fill"></i></a></div>';

                    return $btn;
                });

                // Conditionally add columns based on the user role
                if ($user->hasRole('normal user')) {
                    $datatable->addColumn('doctor_name', function($row){
                        $staff = DB::table('staff')->where('id', $row->doctor_id)->first();
    
                        return $staff->name;
                    });
                } elseif ($user->hasRole('doctor')) {
                    $datatable->addColumn('patient_name', function ($row) {
                        $patient = DB::table('patient')->where('patient_id', $row->patient_id)->first();

                        return $patient->patient_name;
                    });
                }
                
                return $datatable
                    ->rawColumns(['app_time', 'formatted_duration', 'doctor_name', 'patient_name', 'dept_name', 'action'])
                    ->make(true);
        }
        
        return view('appointment.index');
    }
}
