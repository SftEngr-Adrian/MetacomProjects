<?php

namespace App\Http\Controllers;
use Exception;
use App\Models\BpoAccountType;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class BpoAccountTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $bpoaccountypes = BpoAccountType::select(
                'bpo_account_types.bpo_account_type_id', 
                'bpo_account_types.bpo_account_type_value')
                ->where('bpo_account_types.is_deleted', '!=', '1')
            ->get();

        } catch (Exception $e) {
            Log::error("$e");
        }
        if ($request->ajax()) {
            return DataTables::class::of($bpoaccountypes)->make(true);
        } else {
            return response()->json($bpoaccountypes);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $rules = [
                'bpo_account_type_id' => 'required|max:255|unique:bpo_account_types',
                'bpo_account_type_value' => 'required'
                //'team_leader' => 'required|int|unique:sub_branches'
            ];
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'errors' => $validator->errors()
                ]);
            } else {
                BpoAccountType::create([
                    'bpo_account_type_id' => $request->get('bpo_account_type_id'),
                    'bpo_account_type_value' => ucwords($request->get('bpo_account_type_value')),
                ]);

                return response()->json([
                    'success' => 'Successfully Inserted.'
                ]);
            }
        } catch (Exception $e) {
            Log::error($e);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $rules = [
                'bpo_account_type_id' => 'required|max:255|unique:bpo_account_types,bpo_account_type_id,' . $id . ',bpo_account_type_id',
                'bpo_account_type_value' => 'required'                               //column name       //id        //column_id          
                //'team_leader' => 'required|max:255|unique:sub_branches,team_leader,' . $id . ',sub_branch_id',
            ];
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'errors' => $validator->errors()
                ]);
            } else {
                $affected_rows = BpoAccountType::where('bpo_account_type_id', $id)->update([
                    'bpo_account_type_id' => $request->get('bpo_account_type_id'),
                    'bpo_account_type_value' => ucwords($request->get('bpo_account_type_value')),
                ]);

                if ($affected_rows > 0) {
                    return response()->json([
                        'success' => 'Successfully Updated.'
                    ]);
                } else {
                    return response()->json([
                        'warning' => 'No Changes.'
                    ]);
                }
            }
        } catch (Exception $e) {
            Log::error($e);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $updated = BpoAccountType::where('bpo_account_type_id', $id)->update([
                'is_deleted' => 1
            ]);

            if ($updated) {
                return response()->json([
                    'success' => 'Successfully Deleted.'
                ]);
            }
        } catch (Exception $e) {
            Log::error($e);
        }
    }
}
