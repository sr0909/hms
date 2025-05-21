<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use App\Models\Medicine;
use App\Models\MedicineCategory;

class MedicineDetailsController extends Controller
{
    public function index(Request $request, $id = null)
    {
        $type = 'create';
        $medicine = null;
        $categoryName = null;
        
        if ($id) {
            $type = 'edit';

            $medicine = Medicine::where('medicine_id', $id)->first();

            $category = MedicineCategory::where('id', $medicine->category_id)->first();
            $categoryName = $category->category_name;
        }
        
        return view('medicine.details', compact('type', 'medicine', 'categoryName'));
    }

    public function create(Request $request)
    {
        if ($request->ajax()) {
            DB::beginTransaction();

            try {
                $request->validate([
                    'medicine_id' => 'required|max:10',
                    'medicine_name' => 'required|max:150',
                    'manufacturer' => 'required|max:150',
                    'category_id' => 'required',
                    'dosage_form' => 'required|max:50',
                    'strength' => 'required|max:50',
                    'package_size' => 'required|max:50',
                    'price' => 'required',
                    'medicine_description' => 'required',
                ]);

                // Run the select query to get the data in medicine table
                $medicines = DB::select('SELECT * FROM medicine');

                foreach ($medicines as $medicine) {
                    if ($request->medicine_name == $medicine->medicine_name) {
                        return response()->json([
                            'state' => 'error',
                            'message' => 'This medicine is created already!'
                        ]);
                    }
                }
                    
                // Insert data into database
                Medicine::create([
                    'medicine_id' => $request->medicine_id,
                    'medicine_name' => $request->medicine_name,
                    'medicine_description' => $request->medicine_description,
                    'category_id' => $request->category_id,
                    'dosage_form' => $request->dosage_form,
                    'strength' => $request->strength,
                    'package_size' => $request->package_size,
                    'price' => $request->price,
                    'manufacturer' => $request->manufacturer,
                ]);

                // Get the current running no
                $runningno = DB::table('running_no')
                            ->where('type', 'medicine')
                            ->first();

                $updated_running_no = $runningno->running_no + 1;
                    
                // Update running no
                DB::table('running_no')
                    ->where('type', 'medicine')
                    ->update([
                        'running_no' => $updated_running_no,
                        'updated_at' => now(),
                    ]);
                
                // Commit transaction
                DB::commit();

                return response()->json([
                    'state' => 'success',
                    'message' => 'Medicine created successfully!',
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
                    'medicine_id' => 'required|max:10',
                    'medicine_name' => 'required|max:150',
                    'manufacturer' => 'required|max:150',
                    'category_id' => 'required',
                    'dosage_form' => 'required|max:50',
                    'strength' => 'required|max:50',
                    'package_size' => 'required|max:50',
                    'price' => 'required',
                    'medicine_description' => 'required',
                ]);

                // Run the select query to get the data in medicine table
                $medicines = DB::table('medicine')
                                ->where('medicine_id', '!=', $id)
                                ->get();
 
                foreach ($medicines as $medicine) {
                    if ($request->medicine_name == $medicine->medicine_name) {
                        return response()->json([
                            'state' => 'error',
                            'message' => 'This medicine is created already!'
                        ]);
                    }
                }
                
                DB::table('medicine')
                    ->where('medicine_id', $id)
                    ->update([
                        'medicine_name' => $request->medicine_name,
                        'manufacturer' => $request->manufacturer,
                        'category_id' => $request->category_id,
                        'dosage_form' => $request->dosage_form,
                        'strength' => $request->strength,
                        'package_size' => $request->package_size,
                        'price' => $request->price,
                        'medicine_description' => $request->medicine_description,
                        'updated_at' => now(),
                    ]);
                
                DB::commit();

                return response()->json([
                    'state' => 'success',
                    'message' => 'Medicine updated successfully!'
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
                // Run the select query to get the data in inventory table
                $inventories = DB::select('SELECT * FROM inventory');

                // Check is the medicine exists in inventory
                foreach ($inventories as $inventory) {
                    if ($id == $inventory->medicine_id) {
                        return response()->json([
                            'state' => 'error',
                            'message' => 'Failed to delete this medicine as it is associated with other modules!'
                        ]);
                    }
                }

                // Run the select query to get the data in prescription table
                $prescriptions = DB::select('SELECT * FROM prescription');

                // Check is the medicine exists in prescription
                foreach ($prescriptions as $prescription) {
                    if ($id == $prescription->medicine_id) {
                        return response()->json([
                            'state' => 'error',
                            'message' => 'Failed to delete this medicine as it is associated with other modules!'
                        ]);
                    }
                }

                DB::table('medicine')->where('medicine_id', $id)->delete();

                DB::commit();

                return response()->json([
                    'state' => 'success',
                    'message' => 'This medicine has been deleted!',
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

    public function getMedicineId(Request $request)
    {
        if ($request->ajax()) {
            $runningno = DB::table('running_no')
                        ->where('type', 'medicine')
                        ->first();

            $num = str_pad($runningno->running_no, 7, '0', STR_PAD_LEFT);

            $medicineId = $runningno->prefix . $num;
            
            return response()->json([
                'state' => 'success',
                'medicineId' => $medicineId
            ]);
        }
    }

    public function getMedicineCategoryList(Request $request)
    {
        $search = $request->get('q');

        // Fetch categories from the database matching the search term
        $categories = MedicineCategory::where('category_name', 'LIKE', "%{$search}%")
                        ->limit(10) // Limit the number of results returned
                        ->get(['id', 'category_name']);
        
        // Format the results to match select2's expectations
        $formattedCategory = $categories->map(function ($category) {
            return [
                'id' => $category->id,
                'category_name' => $category->category_name
            ];
        });

        return response()->json($formattedCategory);
    }
}
