<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use App\Models\WorkExperienceType;
use Illuminate\Http\Request;

class WorkExperienceTypeController extends Controller
{
     /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $workexperiencetypes = WorkExperienceType::select(
                'wWorkExperienceType.work_experience_type_id', 
                'wWorkExperienceType.work_experience_type_value')
                ->where('wWorkExperienceType.is_deleted', '!=', '1')
            ->get();

        } catch (Exception $e) {
            Log::error("$e");
        }
        if ($request->ajax()) {
            return DataTables::class::of($workexperiencetypes)->make(true);
        } else {
            return response()->json($workexperiencetypes);
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
                'work_experience_type_id' => 'required|max:255|unique:work_experience_types',
                'work_experience_type_value' => 'required'
                //'team_leader' => 'required|int|unique:sub_branches'
            ];
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'errors' => $validator->errors()
                ]);
            } else {
                WorkExperienceType::create([
                    'work_experience_type_id' => $request->get('work_experience_type_id'),
                    'work_experience_type_value' => ucwords($request->get('work_experience_type_value')),
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
                'work_experience_type_id' => 'required|max:255|unique:work_experience_types,work_experience_type_id,' . $id . ',work_experience_type_id',
                'work_experience_type_value' => 'required'                               //column name       //id        //column_id          
                //'team_leader' => 'required|max:255|unique:sub_branches,team_leader,' . $id . ',sub_branch_id',
            ];
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'errors' => $validator->errors()
                ]);
            } else {
                $affected_rows = WorkExperienceType::where('work_experience_type_id', $id)->update([
                    'work_experience_type_id' => $request->get('work_experience_type_id'),
                    'work_experience_type_value' => ucwords($request->get('work_experience_type_value')),
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
            $updated = WorkExperienceType::where('work_experience_type_id', $id)->update([
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
