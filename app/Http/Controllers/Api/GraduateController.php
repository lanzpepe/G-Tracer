<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Graduate;
use App\Models\Response;
use App\Models\Token;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class GraduateController extends Controller
{
    public function getAllGraduates()
    {
        $graduates = Graduate::with('tasks')->get();

        return response()->json(compact('graduates'));
    }

    public function getGraduate($graduateId)
    {
        $graduate = Graduate::with('tasks')->findOrFail($graduateId);

        return response()->json(compact('graduate'));
    }

    // graduate added by users
    public function addGraduate(Request $request, $graduateId)
    {
        $user = User::findOrFail($request->userId);
        $user->addGraduates()->attach($graduateId);

        return response()->json(['message' => "Graduate has been added."], 200);
    }

    public function addResponseToGraduate(Request $request, $graduateId)
    {
        $respondent = User::findOrFail($request->respondentId);
        $response = Response::create([
            'response_id' => Str::random(),
            'company_name' => $request->companyName,
            'company_address' => $request->companyAddress,
            'company_position' => $request->companyPosition,
            'remarks' => $request->remarks
        ]);
        $response->users()->attach($respondent);

        return response()->json(['message' => 'Submitted. Thank you for your time.'], 200);
    }

    public function addToken(Request $request)
    {
        Token::updateOrCreate([
            'token' => $request->token
        ]);
    }
}
