<?php

namespace App\Http\Controllers;
use App\Models\ApplicantTag;
use Exception;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class ApplicantTagController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $applicanttags = ApplicantTag::select(
                'applicant_tags.applicant_tag_id', 
                'applicant_tags.applicant_tag_value')
                ->where('applicant_tags.is_deleted', '!=', '1')
            ->get();

        } catch (Exception $e) {
            Log::error("$e");
        }
        if ($request->ajax()) {
            return DataTables::class::of($applicanttags)->make(true);
        } else {
            return response()->json($applicanttags);
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
                'applicant_tag_id' => 'required|max:255|unique:applicant_tags',
                'applicant_tag_value' => 'required'
                //'team_leader' => 'required|int|unique:sub_branches'
            ];
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'errors' => $validator->errors()
                ]);
            } else {
                ApplicantTag::create([
                    'applicant_tag_id' => $request->get('applicant_tag_id'),
                    'applicant_tag_value' => ucwords($request->get('applicant_tag_value')),
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
    public function show($edit)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($edit)
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
                'applicant_tag_id' => 'required|max:255|unique:applicant_tags,applicant_tag_id,' . $id . ',applicant_tag_id',
                'applicant_tag_value' => 'required'                               //column name       //id        //column_id          
                //'team_leader' => 'required|max:255|unique:sub_branches,team_leader,' . $id . ',sub_branch_id',
            ];
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'errors' => $validator->errors()
                ]);
            } else {
                $affected_rows = ApplicantTag::where('applicant_tag_id', $id)->update([
                    'applicant_tag_id' => $request->get('applicant_tag_id'),
                    'applicant_tag_value' => ucwords($request->get('applicant_tag_value')),
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
            $updated = ApplicantTag::where('applicant_tag_id', $id)->update([
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
