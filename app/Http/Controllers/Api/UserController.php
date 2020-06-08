<?php

namespace App\Http\Controllers\Api;

use App\Events\TwitterFriendsSaved;
use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Graduate;
use App\Models\SocialAccount;
use App\Models\User;
use App\Traits\StaticTrait;
use App\Utilities\GraduateSimilarity;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class UserController extends Controller
{
    use StaticTrait;

    private $user;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->user = User::find(auth('api')->user()->user_id);
    }

    /**
     * Display the list of existing users.
     *
     * @return \Illuminate\Http\Response
     */
    public function users()
    {
        $users = User::with([
            'socialAccounts', 'contacts', 'academic', 'companies', 'graduates.academic',
            'responses', 'achievement.rank', 'rewards', 'preference'
        ])->get();

        return response()->json(compact('users'));
    }

    /**
     * Display the specified user.
     *
     * @return \Illuminate\Http\Response
     */
    public function user()
    {
        $user = User::with([
            'socialAccounts', 'contacts', 'academic', 'companies', 'graduates.academic',
            'responses', 'achievement.rank', 'rewards', 'preference'
        ])->find($this->user->user_id);

        event(new TwitterFriendsSaved($user));

        return response()->json(compact('user'));
    }

    /**
     * Display the recommended graduates based on similar attributes.
     *
     * @return \Illuminate\Http\Response
     */
    public function graduates() {
        $graduates = Graduate::all();
        $selectedId = $this->user->graduates()->first()->graduate_id;
        $provider = SocialAccount::where(function ($query) {
            return $query->where('provider_name', 'twitter.com')->where('user_id', $this->user->user_id);
        })->first();
        $graduateSimilarity = new GraduateSimilarity($graduates, $provider->provider_id);

        $similarityMatrix = $graduateSimilarity->calculateSimilarityMatrix();
        $graduates = $graduateSimilarity->getGraduatesSortedBySimilarity($selectedId, $similarityMatrix, $this->user);

        return response()->json(compact('graduates'));
    }

    /**
     * Stores the user's information from Twitter in the storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function twitter(Request $request)
    {
        $twitter = $this->getTwitterUser($request->userName);

        $this->user->socialAccounts()->create([
            'id' => Str::random(),
            'provider_id' => $twitter['id_str'],
            'provider_name' => 'twitter.com',
            'profile_url' => "twitter.com/{$twitter['screen_name']}"
        ]);

        return response()->json([
            'message' => 'Twitter account successfully updated.'
        ]);
    }

    /**
     * Update the employment data of existing user.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function employment(Request $request)
    {
        $company = Company::firstOrCreate([
            'name' => $request->companyName,
            'address' => $request->companyAddress
        ], [
            'company_id' => Str::random()
        ]);

        $this->user->employments()->create([
            'company_id' => $company->company_id,
            'job_position' => $request->jobPosition,
            'date_employed' => $request->dateEmployed
        ]);

        return response()->json(['message' => "Your profile has been updated."]);
    }

    /**
     * Set preference according to the user's interests.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function preference(Request $request)
    {
        $this->user->preference()->update([
            'school' => $request->school,
            'department' => $request->department,
            'degree' => $request->degree,
            'school_year' => $request->schoolYear,
            'batch' => $request->batch
        ]);

        return response()->json([
            'message' => 'User preference saved successfully.'
        ]);
    }

    /**
     * Record transaction history of reward items by the exchanged points.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function reward(Request $request)
    {
        $this->user->achievement()->update([
            'points' => ($this->user->achievement->points - $request->rewardPoints)
        ]);
        $this->user->rewards()->attach($request->rewardId, ['id' => Str::random()]);

        return response()->json([
            'message' => "Confirmation sent. Just present your reference # to the department office to claim your reward.\n\nReference #: {$this->user->rewards->first()->pivot->id}"
        ]);
    }
}
