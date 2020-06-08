<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Graduate;
use App\Models\Response;
use App\Models\SocialAccount;
use App\Models\User;
use App\Notifications\UserResponse;
use App\Traits\IssueTokenTrait;
use App\Traits\StaticTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Laravel\Passport\Client;

class SocialAuthController extends Controller
{
    use IssueTokenTrait, StaticTrait;

    private $client;

    public function __construct()
    {
        $this->client = Client::find(1);
    }

    public function login(Request $request)
    {
        $socialAccount = SocialAccount::where('provider_name', $request->provider_name)
        ->where('provider_id', $request->provider_id)->first();

        if ($socialAccount) {
            return $this->issueToken($request, 'social');
        }
        else {
            return response()->json(['message' => "Account does not exists."], 404);
        }
    }

    public function register(Request $request)
    {
        $graduate = $this->search($request);

        if ($graduate) {
            $user = User::firstOrCreate([
                'user_id' => Str::uuid(), 'last_name' => $request->lastName,
                'first_name' => $request->firstName, 'middle_name' => $request->middleName,
                'birth_date' => $request->birthDate, 'gender' => $request->gender,
                'image_uri' => $request->imageUri
            ]);

            $graduate->contacts()->update([
                'user_id' => $user->user_id,
                'contact_number' => $request->contactNumber,
                'email' => $request->email
            ]);

            $graduate->academic()->update(['user_id' => $user->user_id]);

            $user->preference()->create([
                'id' => Str::random(),
                'school' => $request->school,
                'department' => $request->department,
                'degree' => $request->code,
                'school_year' => $request->schoolYear,
                'batch' => $request->batch
            ]);

            $user->achievement()->create([
                'id' => Str::random(),
                'points' => 0,
                'exp_points' => 0,
                'rank_id' => 1
            ]);

            $this->addSocialAccount($request, $user);
            $this->addEmployment($request, $user);
            $this->addEmploymentResponse($request, $user, $graduate);

            return $this->issueToken($request, 'social');
        }

        return response()->json([
            'message' => 'There is something wrong with the server. Please try again.'
        ], 500);
    }

    private function addEmployment(Request $request, User $user)
    {
        $company = Company::create([
            'company_id' => Str::random(),
            'name' => $request->companyName,
            'address' => $request->companyAddress
        ]);

        $user->companies()->attach([$company->company_id => [
            'job_position' => $request->jobPosition,
            'date_employed' => $request->dateEmployed
        ]]);
    }

    private function addEmploymentResponse(Request $request, User $user, Graduate $graduate)
    {
        if ($request->has('companyName')) {
            $response = Response::create([
                'id' => Str::random(),
                'company_name' => $request->companyName,
                'company_address' => $request->companyAddress,
                'job_position' => $request->jobPosition,
                'date_employed' => $request->dateEmployed,
                'remarks' => $request->remarks
            ]);

            $user->graduates()->syncWithoutDetaching([
                $graduate->graduate_id => ['response_id' => $response->id]
            ]);
        }

        $admins = $this->findAdmins($user);

        foreach ($admins as $admin) {
            $admin->notify(new UserResponse($graduate));
        }
    }

    private function addSocialAccount(Request $request, User $user)
    {
        $this->validate($request, [
    		'provider_name' => ['required', Rule::unique('social_accounts')->where(function ($query) use ($user) {
    			return $query->where('user_id', $user->user_id);
    		})],
    		'provider_id' => 'required'
        ]);

        $user->socialAccounts()->create([
            'id' => Str::random(),
			'provider_name' => $request->provider_name,
            'provider_id' => $request->provider_id
        ]);
    }

    public function logout()
    {
        $accessToken = auth('api')->user()->token();
        $result = DB::table('oauth_refresh_tokens')->where('access_token_id', $accessToken->id);

        if ($result) {
            $result->update(['revoked' => true]);
            $accessToken->revoke();
        }

        return response()->json(['message' => "Logged out successfully!"]);
    }

    public function friends(Request $request)
    {
        $users = $this->getTwitterFriendIds($request->userId);

        return response()->json(compact('users'));
    }
}
