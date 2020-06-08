<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\LinkedInProfile;
use App\Models\User;
use App\Traits\StaticTrait;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    use StaticTrait;

    public function department($courseId, $schoolId)
    {
        $department = Department::whereHas('courses', function ($query) use ($courseId) {
            return $query->where('id', $courseId);
        })->whereHas('schools', function ($query) use ($schoolId) {
            return $query->where('id', $schoolId);
        })->firstOrFail();

        return response()->json(compact('department'));
    }

    public function linkedin(Request $request)
    {
        $profile = LinkedInProfile::where('last_name', $request->lastName)
                    ->where('first_name', $request->firstName)
                    ->firstOrFail();

        return response()->json(compact('profile'));
    }

    public function verify(Request $request)
    {
        $graduate = $this->search($request);

        if ($graduate) {
            return response()->json([
                'message' => 'Your education data have matched with the stored data from our server. Confirm to proceed.'
            ]);
        }

        return response()->json([
            'message' => 'Your education data did not match with any stored data from our server.'
        ], 404);
    }

    public function token(Request $request)
    {
        $user = User::findOrFail($request->userId);

        $user->update(['device_token' => $request->token]);

        return response()->json([
            'message' => 'Token saved successfully.'
        ]);
    }
}
