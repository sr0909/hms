<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use Carbon\Carbon;
use App\Models\Appointment;
use App\Models\AppointmentTime;
use App\Models\Patient;
use App\Models\Staff;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $patient = Patient::where('username', Auth::user()->name)->first();
            $patientId = $patient->patient_id;

            // Get today's date
            $todayDate = Carbon::today();
    
            // Get appointments data
            $appointments = DB::table('appointment')
                ->select('appointment.id', 'appointment.patient_id', 'appointment.doctor_id', 'appointment.dept_id', 'appointment.app_date', 'appointment.app_start_time_id', 'appointment.app_end_time', 'appointment.duration', 'appointment.type', 'appointment.notes', 'appointment.status', 'appointment.created_at', 'appointment.updated_at', 'appointment_time.app_time')
                ->join('appointment_time', 'appointment.app_start_time_id', '=', 'appointment_time.id')
                ->where('patient_id', $patientId)
                ->where('status', 'Scheduled')
                ->whereDate('app_date', '>=', $todayDate)
                ->orderBy('app_date')
                ->orderBy('appointment_time.app_time')
                ->get()
                ->map(function($row, $index) {
                    $row->DT_RowIndex = $index + 1;
                    $row->formatted_duration = $row->duration . ' hour(s)';
                    $row->dept_name = DB::table('department')->where('id', $row->dept_id)->value('dept_name');
                    $row->doctor_name = DB::table('staff')->where('id', $row->doctor_id)->value('name');
                    $row->action = '<a href="javascript:void(0)" class="btn btn-light btn-sm view-appointment-btn" data-id="' . $row->id . '"><i class="bi bi-eye-fill"></i></a>';
                    return $row;
                });
    
            // Get medical records data
            $oneMonthAgo = Carbon::now()->subMonth()->format('Y-m-d');

            $medicalRecords = DB::table('medical_record')
                ->select('medical_record.medical_record_id', 'medical_record.patient_id', 'medical_record.doctor_id', 'medical_record.medical_record_date', 'medical_record.notes', 'doctor.dept_id')
                ->join('doctor', 'medical_record.doctor_id', '=', 'doctor.id')
                ->where('patient_id', $patientId)
                ->whereDate('medical_record.medical_record_date', '>=', $oneMonthAgo)
                ->orderBy('medical_record_date')
                ->get()
                ->map(function($row, $index) {
                    $row->DT_RowIndex = $index + 1;
                    $row->dept_name = DB::table('department')->where('id', $row->dept_id)->value('dept_name');
                    $row->doctor_name = DB::table('staff')->where('id', $row->doctor_id)->value('name');
                    $row->action = '<a href="javascript:void(0)" class="btn btn-light btn-sm view-medical-record-btn" data-id="' . $row->medical_record_id . '"><i class="bi bi-eye-fill"></i></a>';
                    return $row;
                });
    
            return response()->json([
                'appointments' => $appointments,
                'medical_records' => $medicalRecords,
            ]);
        }

        return view('dashboard.index');
    }

    public function doctorIndex(Request $request)
    {
        if ($request->ajax()) {
            // Get the information of the doctor
            $doctor = Staff::where('username', Auth::user()->name)->first();
            $doctorId = $doctor->id;

            // Get today date
            $today = Carbon::today()->format('Y-m-d');
    
            // Get appointments data
            $appointments = DB::table('appointment')
                ->select('appointment.id', 'appointment.patient_id', 'appointment.doctor_id', 'appointment.dept_id', 'appointment.app_date', 'appointment.app_start_time_id', 'appointment.app_end_time', 'appointment.duration', 'appointment.type', 'appointment.notes', 'appointment.status', 'appointment.created_at', 'appointment.updated_at', 'appointment_time.app_time')
                ->join('appointment_time', 'appointment.app_start_time_id', '=', 'appointment_time.id')
                ->where('doctor_id', $doctorId)
                ->where('status', 'Scheduled')
                ->whereDate('app_date', '=', $today)
                ->orderBy('app_date')
                ->orderBy('appointment_time.app_time')
                ->get()
                ->map(function($row, $index) {
                    $row->DT_RowIndex = $index + 1;
                    $row->formatted_duration = $row->duration . ' hour(s)';
                    $row->patient_name = DB::table('patient')->where('patient_id', $row->patient_id)->value('patient_name');
                    $row->action = '<a href="javascript:void(0)" class="btn btn-light btn-sm view-appointment-btn" data-id="' . $row->id . '"><i class="bi bi-eye-fill"></i></a>';
                    return $row;
                });
    
            // Get medical records data
            $oneMonthAgo = Carbon::now()->subMonth()->format('Y-m-d');

            $medicalRecords = DB::table('medical_record')
                ->select('medical_record.medical_record_id', 'medical_record.patient_id', 'medical_record.doctor_id', 'medical_record.medical_record_date', 'medical_record.notes', 'doctor.dept_id')
                ->join('doctor', 'medical_record.doctor_id', '=', 'doctor.id')
                ->where('doctor_id', $doctorId)
                ->where('status', 'Open')
                ->whereDate('medical_record.medical_record_date', '>=', $oneMonthAgo)
                ->orderBy('medical_record_date')
                ->get()
                ->map(function($row, $index) {
                    $row->DT_RowIndex = $index + 1;
                    $row->patient_name = DB::table('patient')->where('patient_id', $row->patient_id)->value('patient_name');
                    $row->action = '<div class="btn-group"><a href="javascript:void(0)" class="btn btn-light btn-sm me-2 view-medical-record-btn" data-id="' . $row->medical_record_id . '"><i class="bi bi-eye-fill"></i></a><a href="javascript:void(0)" class="btn btn-light btn-sm edit-btn" data-id="' . $row->medical_record_id . '"><i class="bi bi-pencil-fill"></i></a></div>';
                    return $row;
                });
    
            return response()->json([
                'appointments' => $appointments,
                'medical_records' => $medicalRecords,
            ]);
        }
        
        return view('dashboard.doctor.index');
    }

    public function pharmacistIndex(Request $request)
    {
        if ($request->ajax()) {
            // Get prescription data
            $prescription = DB::table('treatment')
                ->select('medical_record.medical_record_id', 'medical_record.patient_id', 'medical_record.doctor_id', 'diagnosis.diagnosis_id', 'diagnosis.diagnosis_name', 'treatment.treatment_id', 'treatment.treatment_name', 'treatment.type_id', 'treatment.start_date', 'treatment.status')
                ->join('diagnosis', 'treatment.diagnosis_id', '=', 'diagnosis.diagnosis_id')
                ->join('medical_record', 'diagnosis.medical_record_id', '=', 'medical_record.medical_record_id')
                ->where('treatment.type_id', 1)
                ->where('treatment.status', 'Pending')
                ->orderBy('treatment.start_date')
                ->get()
                ->map(function($row, $index) {
                    $row->DT_RowIndex = $index + 1;
                    $row->patient_name = DB::table('patient')->where('patient_id', $row->patient_id)->value('patient_name');
                    $row->doctor_name = DB::table('staff')->where('id', $row->doctor_id)->value('name');
                    $row->action = '<a href="javascript:void(0)" class="btn btn-light btn-sm view-prescription-btn" data-id="' . $row->treatment_id . '"><i class="bi bi-eye-fill"></i></a>';
                    return $row;
                });
    
            // Get inventory data
            $inventory = DB::table('inventory')
                ->select('inventory.id', 'inventory.medicine_id', 'inventory.batch_no', 'inventory.expiry_date', 'inventory.quantity', 'inventory.reorder_level', 'inventory.reorder_quantity', 'medicine.medicine_name')
                ->join('medicine', 'inventory.medicine_id', '=', 'medicine.medicine_id')
                ->whereColumn('inventory.quantity', '<=', 'inventory.reorder_level')
                ->orderBy('medicine.medicine_name')
                ->get()
                ->map(function($row, $index) {
                    $row->DT_RowIndex = $index + 1;
                    $row->quantity = '<span class="text-danger fw-bold">' . $row->quantity . '</span>';
                    $row->action = '<a href="javascript:void(0)" class="btn btn-light btn-sm view-inventory-btn" data-id="' . $row->id . '"><i class="bi bi-eye-fill"></i></a>';
                    return $row;
                });
    
            return response()->json([
                'prescription' => $prescription,
                'inventory' => $inventory,
            ]);
        }
        
        return view('dashboard.pharmacist.index');
    }

    public function adminIndex(Request $request)
    {
        if ($request->ajax()) {
            // Get inventory data
            $inventory = DB::table('inventory')
                ->select('inventory.id', 'inventory.medicine_id', 'inventory.batch_no', 'inventory.expiry_date', 'inventory.quantity', 'inventory.reorder_level', 'inventory.reorder_quantity', 'medicine.medicine_name')
                ->join('medicine', 'inventory.medicine_id', '=', 'medicine.medicine_id')
                ->whereColumn('inventory.quantity', '<=', 'inventory.reorder_level')
                ->orderBy('medicine.medicine_name')
                ->get()
                ->map(function($row, $index) {
                    $row->DT_RowIndex = $index + 1;
                    $row->quantity = '<span class="text-danger fw-bold">' . $row->quantity . '</span>';
                    $row->action = '<a href="javascript:void(0)" class="btn btn-light btn-sm view-inventory-btn" data-id="' . $row->id . '"><i class="bi bi-eye-fill"></i></a>';
                    return $row;
                });
    
            return response()->json([
                'inventory' => $inventory,
            ]);
        }
        
        return view('dashboard.admin.index');
    }
}
