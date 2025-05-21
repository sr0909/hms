<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use App\Models\Country;

class CountryController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = DB::table('country')->orderBy('country_code')->get();

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
        
        return view('masterdata.country.index');
    }

    public function create(Request $request)
    {
        if ($request->ajax()) {
            DB::beginTransaction();

            try {
                $request->validate([
                    'country_code' => 'required|max:3',
                    'country_name' => 'required|max:100',
                ]);

                // Run the select query to get the data in country table
                $countries = DB::select('SELECT * FROM country');

                // Check is the country code exists
                foreach ($countries as $country) {
                    if ($request->country_code == $country->country_code) {
                        return response()->json([
                            'state' => 'error',
                            'message' => 'This country is existing!'
                        ]);
                    }
                }

                // Insert data into database
                Country::create([
                    'country_code' => $request->country_code,
                    'country_name' => $request->country_name,
                ]);
                
                // Commit transaction
                DB::commit();

                return response()->json([
                    'state' => 'success',
                    'message' => 'Country created successfully!',
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
                    'country_code' => 'required|max:3',
                    'country_name' => 'required|max:100',
                ]);

                DB::table('country')
                    ->where('id', $id)
                    ->update([
                        'country_name' => $request->country_name,
                        'updated_at' => now(),
                    ]);

                DB::commit();

                return response()->json([
                    'state' => 'success',
                    'message' => 'Country updated successfully!'
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

    public function getCountry(Request $request)
    {
        if ($request->ajax()) {
            $id = $request->input('id');

            $country = DB::table('country')
                            ->where('id', $id)
                            ->get();

            return response()->json([
                'state' => 'success',
                'country' => $country
            ]);
        }
    }

    public function destroy(Request $request, $id = FALSE)
    {
        if ($request->ajax()) {
            DB::beginTransaction();

            try {
                DB::table('country')->where('id', $id)->delete();

                DB::commit();

                return response()->json([
                    'state' => 'success',
                    'message' => 'This country has been deleted!',
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
