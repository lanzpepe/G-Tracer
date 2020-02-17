<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Graduate;
use App\Models\ItemSimilarity;
use App\Models\Response;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class GraduateController extends Controller
{
    public function graduates()
    {
        $graduates = Graduate::all();

        return response()->json(compact('graduates'));
    }

    public function graduate($graduateId)
    {
        $graduate = Graduate::with(['responses', 'users'])->findOrFail($graduateId);

        return response()->json(compact('graduate'));
    }

    public function save(Request $request, $graduateId)
    {
        $user = User::findOrFail($request->respondentId);
        $graduates = Graduate::with('responses')->whereDoesntHave('users', function ($query) use ($user) {
            return $query->where('users.user_id', $user->user_id); // remove saved graduates
        })->get();
        $graduate = Graduate::findOrFail($graduateId);
        $selectedId = $graduate->graduate_id;
        $selected = $graduates[0];

        /* $selectedGraduates = array_filter($graduates, function ($graduate) use ($selectedId) {
            return $graduate->graduate_id == $selectedId;
        }); */

        $selectedGraduates = $graduates->filter(function ($value) use ($selectedId) {
            return $value->graduate_id == $selectedId;
        });

        if ($selectedGraduates->count()) {
            $selected = $selectedGraduates[$selectedGraduates->keys()->first()];
        }

        $similarity = new ItemSimilarity($graduates);
        $similarityMatrix = $similarity->calculateSimilarityMatrix();

        dd($similarityMatrix);

        // $user->graduates()->attach($graduateId);

        return response()->json([
            'message' => "{$graduate->getFullNameAttribute()} is added to Pending list."
        ]);
    }

    // responses from user
    public function response(Request $request, $graduateId)
    {
        $user = User::findOrFail($request->respondentId);
        $company = Company::firstOrCreate([
            'name' => $request->companyName,
            'address' => $request->companyAddress
        ], [
            'company_id' => Str::random()
        ]);
        $response = Response::create([
            'response_id' => Str::random(),
            'company_name' => $company->name,
            'company_address' => $company->address,
            'job_position' => $request->jobPosition,
            'date_employed' => $request->dateEmployed,
            'remarks' => $request->remarks
        ]);

        $user->graduates()->syncWithoutDetaching([
            $graduateId => ['response_id' => $response->response_id]
        ]);

        return response()->json(['message' => 'Submitted. Thank you for your time.']);
    }
}
