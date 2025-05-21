<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use App\Models\RunningNo;

class RunningNoController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = DB::table('running_no')->orderBy('type')->get();

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
        
        return view('masterdata.runningno.index');
    }

    public function create(Request $request)
    {
        if ($request->ajax()) {
            DB::beginTransaction();

            try {
                $request->validate([
                    'type' => 'required|max:50',
                    'prefix' => 'required|max:3',
                    'running_no' => 'required|numeric|min:1|max:9999999',
                ]);

                // Run the select query to get the data in running_no table
                $runningnos = DB::select('SELECT * FROM running_no');

                // Check is the type and prefix exists
                foreach ($runningnos as $runningno) {
                    if ($request->type == $runningno->type) {
                        return response()->json([
                            'state' => 'error',
                            'message' => 'The running number of this type is existing!'
                        ]);
                    }

                    if ($request->prefix == $runningno->prefix) {
                        return response()->json([
                            'state' => 'error',
                            'message' => 'This prefix had been used already!'
                        ]);
                    }
                }

                // Insert data into database
                RunningNo::create([
                    'type' => $request->type,
                    'prefix' => $request->prefix,
                    'running_no' => $request->running_no,
                ]);
                
                // Commit transaction
                DB::commit();

                return response()->json([
                    'state' => 'success',
                    'message' => 'Running number created successfully!',
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
                    'type' => 'required|max:50',
                    'prefix' => 'required|max:3',
                    'running_no' => 'required|numeric|min:1|max:9999999',
                ]);

                // Run the select query to get the data in running_no table
                $runningnos = DB::table('running_no')
                                ->where('id', '!=', $id)
                                ->get();
 
                foreach ($runningnos as $runningno) {
                    if ($request->prefix == $runningno->prefix) {
                        return response()->json([
                            'state' => 'error',
                            'message' => 'This prefix had been used already!'
                        ]);
                    }
                }

                DB::table('running_no')
                    ->where('id', $id)
                    ->update([
                        'prefix' => $request->prefix,
                        'running_no' => $request->running_no,
                        'updated_at' => now(),
                    ]);

                DB::commit();

                return response()->json([
                    'state' => 'success',
                    'message' => 'Running number updated successfully!'
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

    public function getRunningno(Request $request)
    {
        if ($request->ajax()) {
            $id = $request->input('id');

            $runningno = DB::table('running_no')
                            ->where('id', $id)
                            ->get();

            return response()->json([
                'state' => 'success',
                'runningno' => $runningno
            ]);
        }
    }

    public function destroy(Request $request, $id = FALSE)
    {
        if ($request->ajax()) {
            DB::beginTransaction();

            try {
                DB::table('running_no')->where('id', $id)->delete();

                DB::commit();

                return response()->json([
                    'state' => 'success',
                    'message' => 'This running number has been deleted!',
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
