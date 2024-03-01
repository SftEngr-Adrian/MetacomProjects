<?php

namespace App\Http\Controllers;
use App\Models\ApplicantStatus;
use Exception;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class ApplicantStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $applicantstatuses = ApplicantStatus::select(
                'applicant_statuses.applicant_status_id',
                'applicant_statuses.applicant_status_value'
            )
                ->where('applicant_statuses.is_deleted', '!=', '1')
                ->get();
        } catch (Exception $e) {
            Log::error("$e");
        }
        if ($request->ajax()) {
            return DataTables::class::of($applicantstatuses)->make(true);
        } else {
            return response()->json($applicantstatuses);
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
                'applicant_status_id' => 'required|max:255|unique:applicant_statuses',
                'applicant_status_value' => 'required'
                //'team_leader' => 'required|int|unique:sub_branches'
            ];
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'errors' => $validator->errors()
                ]);
            } else {
                ApplicantStatus::create([
                    'applicant_status_id' => $request->get('applicant_status_id'),
                    'applicant_status_value' => ucwords($request->get('applicant_status_value')),
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
                'applicant_status_id' => 'required|max:255|unique:applicant_statuses,applicant_status_id,' . $id . ',applicant_status_id',
                'applicant_status_value' => 'required'                               //column name       //id        //column_id          
                //'team_leader' => 'required|max:255|unique:sub_branches,team_leader,' . $id . ',sub_branch_id',
            ];
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'errors' => $validator->errors()
                ]);
            } else {
                $affected_rows = ApplicantStatus::where('applicant_status_id', $id)->update([
                    'applicant_status_id' => $request->get('applicant_status_id'),
                    'applicant_status_value' => ucwords($request->get('applicant_status_value')),
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
            $updated = ApplicantStatus::where('applicant_status_id', $id)->update([
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
