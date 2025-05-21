<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use App\Models\Medicine;
use App\Models\MedicineCategory;

class MedicineController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = DB::table('medicine')->orderBy('medicine_name')->get();

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('category_name', function($row){
                    $category = MedicineCategory::where('id', $row->category_id)->first();
                    
                    return $category->category_name;
                })
                ->addColumn('action', function($row){
    
                    $btn = '<div class="btn-group"><a href="javascript:void(0)" class="btn btn-light btn-sm me-2 edit-btn" data-id="' . $row->medicine_id . '"><i class="bi bi-pencil-fill"></i></a>';

                    $btn = $btn . '<a href="javascript:void(0)" class="btn btn-light btn-sm delete-btn" data-id="' . $row->medicine_id . '"><i class="bi bi-trash3-fill"></i></a></div>';

                    return $btn;
                })
                ->rawColumns(['category_name', 'action'])
                ->make(true);
        }
        
        return view('medicine.index');
    }
}
