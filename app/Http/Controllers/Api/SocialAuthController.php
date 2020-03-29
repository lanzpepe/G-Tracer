<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Course;
use App\Models\Graduate;
use App\Models\Response;
use App\Models\SocialAccount;
use App\Models\User;
use App\Traits\IssueTokenTrait;
use App\Traits\StaticTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
            $this->search($socialAccount->user);

            return $this->issueToken($request, 'social');
        }
        else {
            return response()->json(['message' => "Account does not exists."], 404);
        }
    }

    public function register(Request $request)
    {
        $this->addUserAccount($request);

        return $this->issueToken($request, 'social');
    }

    private function addUserAccount(Request $request)
    {
        $course = Course::where('name', $request->degree)->where('major', $request->major)->first();

        $user = User::create([
            'user_id' => Str::random(), 'last_name' => $request->lastName,
            'first_name' => $request->firstName, 'middle_name' => $request->middleName,
            'birth_date' => $request->birthDate, 'gender' => $request->gender,
            'image_uri' => $request->imageUri
        ]);

        $user->contacts()->create([
            'contact_id' => Str::random(), 'address' => $request->address,
            'latitude' => $this->getLatLng($request->address)['lat'],
            'longitude' => $this->getLatLng($request->address)['lng'],
            'contact_number' => $request->contactNumber, 'email' => $request->email
        ]);

        $user->academic()->create([
            'academic_id' => Str::random(), 'code' => $course->code,
            'degree' => $request->degree, 'major' => $request->major,
            'department' => $request->department, 'school' => $request->school,
            'year' => $request->schoolYear, 'batch' => $request->batch
        ]);

        $this->addSocialAccount($request, $user);
        $this->addEmployment($request, $user);

        $graduate = $this->search($user);

        if ($graduate) {
            $this->addEmploymentResponse($request, $user, $graduate);
        }

        return $user;
    }

    private function addEmployment(Request $request, User $user)
    {
        $company = Company::create([
            'company_id' => Str::random(),
            'name' => $request->companyName,
            'address' => $request->companyAddress
        ]);

        $company->employments()->create([
            'user_id' => $user->user_id,
            'job_position' => $request->jobPosition,
            'date_employed' => $request->dateEmployed
        ]);
    }

    private function addEmploymentResponse(Request $request, User $user, Graduate $graduate)
    {
        if ($request->has('companyName')) {
            $response = Response::create([
                'response_id' => Str::random(),
                'company_name' => $request->companyName,
                'company_address' => $request->companyAddress,
                'job_position' => $request->jobPosition,
                'date_employed' => $request->dateEmployed,
                'remarks' => $request->remarks
            ]);

            $user->graduates()->syncWithoutDetaching([
                $graduate->graduate_id => ['response_id' => $response->response_id]
            ]);
        }

        return $user;
    }

    private function addSocialAccount(Request $request, User $user)
    {
        $this->validate($request, [
    		'provider_name' => ['required', Rule::unique('social_accounts')->where(function ($query) use ($user) {
    			return $query->where('user_id', $user->user_id);
    		})],
    		'provider_id' => 'required'
        ]);

        $user->socialAccount()->create([
			'provider_name' => $request->provider_name,
    		'provider_id' => $request->provider_id
        ]);

        return $user;
    }

    public function logout()
    {
        $accessToken = Auth::user()->token();
        $result = DB::table('oauth_refresh_tokens')->where('access_token_id', $accessToken->id);

        if ($result) {
            $result->update(['revoked' => true]);
            $accessToken->revoke();
        }

        return response()->json(['message' => "Logged out successfully!"]);
    }
}
