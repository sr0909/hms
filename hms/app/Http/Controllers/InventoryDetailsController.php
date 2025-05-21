<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use App\Models\Inventory;
use App\Models\Medicine;

class InventoryDetailsController extends Controller
{
    public function index(Request $request, $id = null)
    {
        $type = 'create';
        $inventory = null;
        $medicineName = null;
        
        if ($id) {
            $type = 'edit';

            $inventory = Inventory::where('id', $id)->first();

            $medicine = Medicine::where('medicine_id', $inventory->medicine_id)->first();
            $medicineName = $medicine->medicine_name;
        }
        
        return view('inventory.details', compact('type', 'inventory', 'medicineName'));
    }

    public function create(Request $request)
    {
        if ($request->ajax()) {
            DB::beginTransaction();

            try {
                $request->validate([
                    'medicine_id' => 'required|max:10',
                    'expiry_date' => 'required',
                    'batch_no' => 'required|max:20',
                    'quantity' => 'required|integer|min:0|max:9999999',
                    'reorder_level' => 'required|integer|min:1|max:9999999',
                    'reorder_quantity' => 'required|integer|min:1|max:9999999',
                    'status' => 'required',
                ]);

                // Run the select query to get the data in inventory table
                $inventories = DB::select('SELECT * FROM inventory');

                foreach ($inventories as $inventory) {
                    if ($request->batch_no == $inventory->batch_no) {
                        return response()->json([
                            'state' => 'error',
                            'message' => 'This batch of medicine is created already!'
                        ]);
                    }
                }

                $expiry_date = (new \DateTime($request->expiry_date))->format('Y-m-d');
                    
                // Insert data into database
                Inventory::create([
                    'medicine_id' => $request->medicine_id,
                    'batch_no' => $request->batch_no,
                    'expiry_date' => $expiry_date,
                    'quantity' => $request->quantity,
                    'reorder_level' => $request->reorder_level,
                    'reorder_quantity' => $request->reorder_quantity,
                    'status' => 'Active',
                ]);
                
                // Commit transaction
                DB::commit();

                return response()->json([
                    'state' => 'success',
                    'message' => 'Inventory created successfully!',
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
                    'expiry_date' => 'required',
                    'batch_no' => 'required|max:20',
                    'quantity' => 'required|integer|min:0|max:9999999',
                    'reorder_level' => 'required|integer|min:1|max:9999999',
                    'reorder_quantity' => 'required|integer|min:1|max:9999999',
                    'status' => 'required',
                ]);

                // Run the select query to get the data in inventory table
                $inventories = DB::table('inventory')
                                ->where('id', '!=', $id)
                                ->get();
 
                foreach ($inventories as $inventory) {
                    if ($request->batch_no == $inventory->batch_no) {
                        return response()->json([
                            'state' => 'error',
                            'message' => 'This batch of medicine is created already!'
                        ]);
                    }
                }

                if ($request->quantity == 0) {
                    $status = 'Inactive';
                } else {
                    $status = $request->status;
                }

                $expiry_date = (new \DateTime($request->expiry_date))->format('Y-m-d');
                
                DB::table('inventory')
                    ->where('id', $id)
                    ->update([
                        'medicine_id' => $request->medicine_id,
                        'batch_no' => $request->batch_no,
                        'expiry_date' => $expiry_date,
                        'quantity' => $request->quantity,
                        'reorder_level' => $request->reorder_level,
                        'reorder_quantity' => $request->reorder_quantity,
                        'status' => $status,
                        'updated_at' => now(),
                    ]);
                
                DB::commit();

                return response()->json([
                    'state' => 'success',
                    'message' => 'Inventory updated successfully!'
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
                DB::table('inventory')->where('id', $id)->delete();

                DB::commit();

                return response()->json([
                    'state' => 'success',
                    'message' => 'This inventory has been deleted!',
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

    public function getMedicineNameList(Request $request)
    {
        $search = $request->get('q');

        // Fetch categories from the database matching the search term
        $medicines = Medicine::where('medicine_name', 'LIKE', "%{$search}%")
                        ->limit(10) // Limit the number of results returned
                        ->get(['medicine_id', 'medicine_name']);
        
        // Format the results to match select2's expectations
        $formattedMedicine = $medicines->map(function ($medicine) {
            return [
                'medicine_id' => $medicine->medicine_id,
                'medicine_name' => $medicine->medicine_name
            ];
        });

        return response()->json($formattedMedicine);
    }
}
