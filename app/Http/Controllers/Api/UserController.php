<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Graduate;
use App\Models\SocialAccount;
use App\Models\User;
use App\Utilities\GraduateSimilarity;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class UserController extends Controller
{
    /**
     * Display the list of existing users.
     *
     * @return \Illuminate\Http\Response
     */
    public function users()
    {
        $users = User::with([
            'contacts', 'academic', 'employments', 'employments.company',
            'socialAccount', 'graduates.responses'
        ])->get();

        return response()->json(compact('users'));
    }

    /**
     * Display the specified user.
     *
     * @param string $accountId
     * @return \Illuminate\Http\Response
     */
    public function user($accountId)
    {
        $account = SocialAccount::find($accountId);
        $user = User::with([
            'contacts', 'academic', 'employments', 'employments.company',
            'socialAccount', 'graduates.academic', 'graduates.responses'
        ])->find($account->user->user_id);

        return response()->json(compact('user'));
    }

    /**
     * Display the recommended graduates based on similar attributes.
     *
     * @param string $userId
     * @return \Illuminate\Http\Response
     */
    public function graduates($userId) {
        $user = User::find($userId);
        $graduates = Graduate::all();
        $selectedId = $user->graduates()->first()->graduate_id ?? $user->academic->graduate_id;
        $graduateSimilarity = new GraduateSimilarity($graduates);

        $similarityMatrix = $graduateSimilarity->calculateSimilarityMatrix();
        $graduates = $graduateSimilarity->getGraduatesSortedBySimilarity($selectedId, $similarityMatrix, $user);

        return response()->json(compact('graduates'));
    }

    /**
     * Update the employment data of existing user.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function updateEmployment(Request $request)
    {
        $user = User::find($request->userId);
        $company = Company::firstOrCreate([
            'name' => $request->companyName,
            'address' => $request->companyAddress
        ], [
            'company_id' => Str::random()
        ]);

        $user->employments()->create([
            'company_id' => $company->company_id,
            'job_position' => $request->jobPosition,
            'date_employed' => $request->dateEmployed
        ]);

        return response()->json(['message' => "Your profile has been updated."]);
    }
}
