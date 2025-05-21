<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use App\Models\Staff;

class StaffController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = DB::table('staff')->where('role', '!=', 'super admin')->orderBy('name')->get();

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
        
        return view('staff.index');
    }
}
