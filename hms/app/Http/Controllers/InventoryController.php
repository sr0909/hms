<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use App\Models\Inventory;
use App\Models\Medicine;

class InventoryController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = DB::table('inventory');

            if ($request->has('filter_status') && $request->filter_status != 'ALL') {
                $query->where('status', $request->filter_status);
            }

            $data = $query->orderBy('medicine_id')->get();

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('medicine_name', function($row){
                    $medicine = Medicine::where('medicine_id', $row->medicine_id)->first();
                    
                    return $medicine->medicine_name;
                })
                ->addColumn('quantity', function($row) {
                    $quantity = $row->quantity;
                    $reorderLevel = $row->reorder_level;
                    
                    if ($quantity <= $reorderLevel) {
                        return '<span class="text-danger fw-bold">' . $quantity . '</span>';
                    }
                    return $quantity;
                })
                ->addColumn('action', function($row){
    
                    $btn = '<div class="btn-group"><a href="javascript:void(0)" class="btn btn-light btn-sm me-2 edit-btn" data-id="' . $row->id . '"><i class="bi bi-pencil-fill"></i></a>';

                    $btn = $btn . '<a href="javascript:void(0)" class="btn btn-light btn-sm delete-btn" data-id="' . $row->id . '"><i class="bi bi-trash3-fill"></i></a></div>';

                    return $btn;
                })
                ->rawColumns(['medicine_name', 'quantity', 'action'])
                ->make(true);
        }
        
        return view('inventory.index');
    }
}
