<?php

namespace App\Http\Controllers;
use App\Models\EducationalAttainment;
use Exception;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class EducationalAttainmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $educationalattainments = EducationalAttainment::select(
                'educational_attainments.education_attainment_id', 
                'educational_attainments.educational_attainment_value')
                ->where('educational_attainments.is_deleted', '!=', '1')
            ->get();

        } catch (Exception $e) {
            Log::error("$e");
        }
        if ($request->ajax()) {
            return DataTables::class::of($educationalattainments)->make(true);
        } else {
            return response()->json($educationalattainments);
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
                'education_attainment_id' => 'required|max:255|unique:educational_attainments',
                'educational_attainment_value' => 'required'
                //'team_leader' => 'required|int|unique:sub_branches'
            ];
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'errors' => $validator->errors()
                ]);
            } else {
                EducationalAttainment::create([
                    'education_attainment_id' => $request->get('education_attainment_id'),
                    'educational_attainment_value' => ucwords($request->get('educational_attainment_value')),
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
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $rules = [
                'education_attainment_id' => 'required|max:255|unique:educational_attainments,education_attainment_id,' . $id . ',education_attainment_id',
                'educational_attainment_value' => 'required'                               //column name       //id        //column_id          
                //'team_leader' => 'required|max:255|unique:sub_branches,team_leader,' . $id . ',sub_branch_id',
            ];
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'errors' => $validator->errors()
                ]);
            } else {
                $affected_rows = EducationalAttainment::where('education_attainment_id', $id)->update([
                    'education_attainment_id' => $request->get('education_attainment_id'),
                    'educational_attainment_value' => ucwords($request->get('educational_attainment_value')),
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
    public function destroy(string $id)
    {
        try {
            $updated = EducationalAttainment::where('education_attainment_id', $id)->update([
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
