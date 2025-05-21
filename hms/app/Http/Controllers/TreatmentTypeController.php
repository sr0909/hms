<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use App\Models\TreatmentType;

class TreatmentTypeController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = DB::table('treatment_type')->orderBy('type')->get();

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
        
        return view('masterdata.treatment_type.index');
    }

    public function create(Request $request)
    {
        if ($request->ajax()) {
            DB::beginTransaction();

            try {
                $request->validate([
                    'type' => 'required|max:50',
                    'type_description' => 'required',
                ]);

                // Run the select query to get the data in treatment_type table
                $types = DB::select('SELECT * FROM treatment_type');

                // Check is the treatment type name exists
                foreach ($types as $type) {
                    if ($request->type == $type->type) {
                        return response()->json([
                            'state' => 'error',
                            'message' => 'This treatment type is existing!'
                        ]);
                    }
                }

                // Insert data into database
                TreatmentType::create([
                    'type' => $request->type,
                    'type_description' => $request->type_description,
                ]);
                
                // Commit transaction
                DB::commit();

                return response()->json([
                    'state' => 'success',
                    'message' => 'Treatment type created successfully!',
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
                    'type_description' => 'required',
                ]);

                // Run the select query to get the data in treatment_type table
                $types = DB::table('treatment_type')
                                ->where('id', '!=', $id)
                                ->get();
 
                foreach ($types as $type) {
                    if ($request->type == $type->type) {
                        return response()->json([
                            'state' => 'error',
                            'message' => 'This treatment type is existing!'
                        ]);
                    }
                }

                DB::table('treatment_type')
                    ->where('id', $id)
                    ->update([
                        'type' => $request->type,
                        'type_description' => $request->type_description,
                        'updated_at' => now(),
                    ]);

                DB::commit();

                return response()->json([
                    'state' => 'success',
                    'message' => 'Treatment type updated successfully!'
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

    public function getTreatmentType(Request $request)
    {
        if ($request->ajax()) {
            $id = $request->input('id');

            $treatment_type = DB::table('treatment_type')
                            ->where('id', $id)
                            ->get();

            return response()->json([
                'state' => 'success',
                'treatment_type' => $treatment_type
            ]);
        }
    }

    public function destroy(Request $request, $id = FALSE)
    {
        if ($request->ajax()) {
            DB::beginTransaction();

            try {
                DB::table('treatment_type')->where('id', $id)->delete();

                DB::commit();

                return response()->json([
                    'state' => 'success',
                    'message' => 'This treatment type has been deleted!',
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
