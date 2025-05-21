<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use App\Models\AppointmentTime;

class AppointmentTimeController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = AppointmentTime::orderBy('app_time')->get();

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
    
                    $btn = '<div class="btn-group"><a href="javascript:void(0)" class="btn btn-light btn-sm me-2 edit-btn" data-id="' . $row->id . '"><i class="bi bi-pencil-fill"></i></a>';

                    $btn = $btn . '<a href="javascript:void(0)" class="btn btn-light btn-sm delete-btn" data-id="' . $row->id . '"><i class="bi bi-trash3-fill"></i></a></div>';

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        
        return view('masterdata.appointment_time.index');
    }

    public function create(Request $request)
    {
        if ($request->ajax()) {
            DB::beginTransaction();

            try {
                $request->validate([
                    'app_time' => ['required', 'regex:/^([01]\d|2[0-3]):([0-5]\d)$/'],
                ], [
                    'app_time.regex' => 'The appointment time must be in 24-hour format (HH:mm).'
                ]);

                // Run the select query to get the data in appointment_time table
                $appointmentTimes = AppointmentTime::all();

                // Check is the appointment time exists
                foreach ($appointmentTimes as $appointmentTime) {
                    if ($request->app_time == $appointmentTime->app_time) {
                        return response()->json([
                            'state' => 'error',
                            'message' => 'This appointment time is existing!'
                        ]);
                    }
                }

                // Insert data into database
                AppointmentTime::create([
                    'app_time' => $request->app_time,
                ]);
                
                // Commit transaction
                DB::commit();

                return response()->json([
                    'state' => 'success',
                    'message' => 'Appointment Time created successfully!',
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
                    'app_time' => ['required', 'regex:/^([01]\d|2[0-3]):([0-5]\d)$/'],
                ], [
                    'app_time.regex' => 'The appointment time must be in 24-hour format (HH:mm).'
                ]);

                // Run the select query to get the data in appointment_time table
                $appointmentTimes = AppointmentTime::all();

                // Check is the appointment time exists
                foreach ($appointmentTimes as $appointmentTime) {
                    if ($request->app_time == $appointmentTime->app_time) {
                        return response()->json([
                            'state' => 'error',
                            'message' => 'This appointment time is existing!'
                        ]);
                    }
                }

                DB::table('appointment_time')
                    ->where('id', $id)
                    ->update([
                        'app_time' => $request->app_time,
                        'updated_at' => now(),
                    ]);

                DB::commit();

                return response()->json([
                    'state' => 'success',
                    'message' => 'Appointment Time updated successfully!'
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

    public function getAppointmentTime(Request $request)
    {
        if ($request->ajax()) {
            $id = $request->input('id');

            $appointmentTime = AppointmentTime::where('id', $id)->get();

            return response()->json([
                'state' => 'success',
                'appointmentTime' => $appointmentTime
            ]);
        }
    }

    public function destroy(Request $request, $id = FALSE)
    {
        if ($request->ajax()) {
            DB::beginTransaction();

            try {
                DB::table('appointment_time')->where('id', $id)->delete();

                DB::commit();

                return response()->json([
                    'state' => 'success',
                    'message' => 'This appointment time has been deleted!',
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
