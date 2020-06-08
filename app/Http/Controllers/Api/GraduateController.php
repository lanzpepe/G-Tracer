<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Graduate;
use App\Models\Response;
use App\Models\User;
use App\Notifications\UserResponse;
use App\Traits\StaticTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class GraduateController extends Controller
{
    use StaticTrait;

    private $userId;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->userId = auth('api')->user()->user_id;
    }

    /**
     * Display the list of stored graduates.
     *
     * @return \Illuminate\Http\Response
     */
    public function graduates()
    {
        $graduates = Graduate::with([
            'contacts', 'academic', 'responses', 'users'
        ])->get();

        return response()->json(compact('graduates'));
    }

    /**
     * Display the specified graduate.
     *
     * @param string $graduateId
     * @return \Illuminate\Http\Response
     */
    public function graduate($graduateId)
    {
        $graduate = Graduate::with([
            'contacts', 'academic', 'responses', 'users'
        ])->find($graduateId);

        return response()->json(compact('graduate'));
    }

    /**
     * Store the newly saved graduate in the database.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function save(Request $request)
    {
        $user = User::find($this->userId);
        $graduate = Graduate::find($request->graduateId);

        if ($graduate) {
            $user->graduates()->attach($graduate->graduate_id);
        }

        return response()->json([
            'message' => "{$graduate->getFullNameAttribute()} is added to Pending list."
        ]);
    }

    /**
     * Store the user's response of graduate in the database.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function response(Request $request)
    {
        $user = User::find($this->userId);
        $graduate = Graduate::find($request->graduateId);

        $company = Company::firstOrCreate([
            'name' => $request->companyName,
            'address' => $request->companyAddress
        ], [
            'company_id' => Str::random()
        ]);
        $response = Response::create([
            'id' => Str::random(),
            'company_name' => $company->name,
            'company_address' => $company->address,
            'job_position' => $request->jobPosition,
            'date_employed' => $request->dateEmployed,
            'remarks' => $request->remarks
        ]);

        $user->graduates()->syncWithoutDetaching([
            $graduate->graduate_id => ['response_id' => $response->id]
        ]);

        $admins = $this->findAdmins($user);

        foreach ($admins as $admin) {
            $admin->notify(new UserResponse($graduate));
        }

        return response()->json(['message' => 'Submitted. Thank you for your time.']);
    }
}
