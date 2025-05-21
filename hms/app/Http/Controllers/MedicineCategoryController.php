<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use App\Models\MedicineCategory;

class MedicineCategoryController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = DB::table('medicine_category')->orderBy('category_name')->get();

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
        
        return view('masterdata.medicine_category.index');
    }

    public function create(Request $request)
    {
        if ($request->ajax()) {
            DB::beginTransaction();

            try {
                $request->validate([
                    'category_name' => 'required|max:100',
                    'category_description' => 'required',
                ]);

                // Run the select query to get the data in medicine_category table
                $categories = DB::select('SELECT * FROM medicine_category');

                // Check is the category name exists
                foreach ($categories as $category) {
                    if ($request->category_name == $category->category_name) {
                        return response()->json([
                            'state' => 'error',
                            'message' => 'This medicine category is existing!'
                        ]);
                    }
                }

                // Insert data into database
                MedicineCategory::create([
                    'category_name' => $request->category_name,
                    'category_description' => $request->category_description,
                ]);
                
                // Commit transaction
                DB::commit();

                return response()->json([
                    'state' => 'success',
                    'message' => 'Medicine category created successfully!',
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
                    'category_name' => 'required|max:100',
                    'category_description' => 'required',
                ]);

                // Run the select query to get the data in medicine_category table
                $medicinecategories = DB::table('medicine_category')
                                ->where('id', '!=', $id)
                                ->get();
 
                foreach ($medicinecategories as $category) {
                    if ($request->category_name == $category->category_name) {
                        return response()->json([
                            'state' => 'error',
                            'message' => 'This medicine category is created already!'
                        ]);
                    }
                }

                DB::table('medicine_category')
                    ->where('id', $id)
                    ->update([
                        'category_name' => $request->category_name,
                        'category_description' => $request->category_description,
                        'updated_at' => now(),
                    ]);

                DB::commit();

                return response()->json([
                    'state' => 'success',
                    'message' => 'Medicine category updated successfully!'
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

    public function getMedicineCategory(Request $request)
    {
        if ($request->ajax()) {
            $id = $request->input('id');

            $medicine_category = DB::table('medicine_category')
                                    ->where('id', $id)
                                    ->get();

            return response()->json([
                'state' => 'success',
                'medicine_category' => $medicine_category
            ]);
        }
    }

    public function destroy(Request $request, $id = FALSE)
    {
        if ($request->ajax()) {
            DB::beginTransaction();

            try {
                DB::table('medicine_category')->where('id', $id)->delete();

                DB::commit();

                return response()->json([
                    'state' => 'success',
                    'message' => 'This medicine category has been deleted!',
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
