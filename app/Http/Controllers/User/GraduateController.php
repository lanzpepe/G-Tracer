<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Graduate;
use App\Models\Response;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class GraduateController extends Controller
{
    public function graduate($graduateId)
    {
        $graduate = Graduate::with(['responses', 'users'])->findOrFail($graduateId);

        return response()->json(compact('graduate'));
    }

    // responses from user
    public function response(Request $request, $graduateId)
    {
        $user = User::findOrFail($request->respondentId);
        $response = Response::create([
            'response_id' => Str::random(),
            'company_name' => $request->companyName,
            'company_address' => $request->companyAddress,
            'job_position' => $request->jobPosition,
            'date_employed' => $request->dateEmployed,
            'remarks' => $request->remarks
        ]);

        $user->graduates()->attach([
            $graduateId => ['response_id' => $response->response_id]
        ]);

        return response()->json(['message' => 'Submitted. Thank you for your time.']);
    }
}
