<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Graduate;
use App\Models\Token;
use App\Models\User;
use App\Models\Response;
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
        $graduate = Graduate::find($graduateId)->with('tasks')->firstOrFail();

        return response()->json(compact('graduate'));
    }

    // graduates liked by user
    public function saveGraduates(Request $request, $graduateId)
    {
        $graduate = Graduate::find($graduateId);
        $user = User::find($request->userId);
        $user->createLikedGraduate([
            'graduate_id' => $graduate->graduate_id,
            'responded' => false
        ]);

        return response()->json(['message' => "Graduate has been saved."], 200);
    }

    public function addResponseToGraduate(Request $request, $graduateId)
    {
        try {
            $respondent = User::find($request->respondentId)->userGraduates->firstOrFail();
            $response = Response::create([
                'response_id' => Str::random(),
                'company_name' => $request->companyName,
                'company_address' => $request->companyAddress,
                'company_position' => $request->companyPosition
            ]);
            $respondent->response_id = $response->response_id;
            $respondent->save();

            return response()->json(['message' => 'Submitted. Thank you for your time.'], 200);

        } catch (Exception $e) {
            return response()->json(['message' => $e], 422);
        }
    }

    public function addToken(Request $request)
    {
        Token::updateOrCreate([
            'token' => $request->token
        ]);
    }
}
