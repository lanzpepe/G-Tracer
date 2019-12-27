<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\SocialAccount;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Laravel\Passport\Client;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class SocialAuthController extends Controller
{
    use IssueTokenTrait;

    private $client;

    public function __construct()
    {
        $this->client = Client::find(1);
    }

    public function login(Request $request)
    {
        $socialAccount = SocialAccount::where('provider_name', $request->provider_name)
        ->where('provider_id', $request->provider_id)->first();

        if ($socialAccount)
            return $this->issueToken($request, 'social');
        else
            return response()->json(['message' => "Account does not exists."], 404);
    }

    public function register(Request $request)
    {
        $this->addUserAccount($request);

        return $this->issueToken($request, 'social');
    }

    private function addUserAccount(Request $request)
    {
        DB::transaction(function () use ($request){
            $user = User::create([
                'user_id' => Str::random(), 'last_name' => $request->lastName,
                'first_name' => $request->firstName, 'middle_name' => $request->middleName,
                'suffix' => $request->suffix, 'birth_date' => $request->birthDate,
                'gender' => $request->gender, 'image_uri' => $request->imageUri
            ]);

            $user->createContact([
                'contact_id' => Str::random(), 'address_line' => $request->address,
                'city' => $request->city, 'province' => $request->province,
                'contact_number' => $request->contactNumber, 'email' => $request->email
            ]);

            $user->createAcademic([
                'academic_id' => Str::random(), 'degree' => $request->degree,
                'major' => $request->major, 'department' => $request->department,
                'school' => $request->school, 'school_year' => $request->schoolYear,
                'batch' => $request->batch
            ]);

            $this->addEmployment($request, $user);

            $this->addSocialAccount($request, $user);
    	});
    }

    private function addEmployment(Request $request, User $user)
    {
        $company = Company::create([
            'company_id' => Str::random(), 'name' => $request->companyName,
            'address' => $request->companyAddress, 'contact' => $request->companyContact
        ]);

        $user->createEmployment([
            'company_id' => $company->company_id, 'position' => $request->position,
            'date_employed' => $request->dateHired
        ]);
    }

    private function addSocialAccount(Request $request, User $user)
    {
        $this->validate($request, [
    		'provider_name' => ['required', Rule::unique('social_accounts')->where(function($query) use ($user) {
    			return $query->where('user_id', $user->user_id);
    		})],
    		'provider_id' => 'required'
        ]);

    	$user->createSocialAccount([
			'provider_name' => $request->provider_name,
    		'provider_id' => $request->provider_id
        ]);
    }

    public function logout()
    {
        $accessToken = auth()->user()->token();

        DB::table('oauth_refresh_tokens')->where('access_token_id', $accessToken->id)
        ->update(['revoked' => true]);

        $accessToken->revoke();

        return response()->json([
            'message' => "Logged out successfully!"
        ], 200);
    }
}
