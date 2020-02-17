<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Graduate;
use App\Models\SocialAccount;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function users()
    {
        $users = User::with([
            'contacts', 'academic', 'employments', 'employments.company',
            'socialAccount', 'graduates.responses'
        ])->get();

        return response()->json(compact('users'));
    }

    public function user($id)
    {
        $account = SocialAccount::find($id);
        $user = User::with([
            'contacts', 'academic', 'employments', 'employments.company',
            'socialAccount', 'graduates.responses'
        ])->find($account->user->user_id);

        return response()->json(compact('user'));
    }

    // display graduates based on related profile accordingly
    public function graduates($userId) {
        $user = User::find($userId);

        $graduates = Graduate::with('responses')->whereDoesntHave('users', function ($query) use ($user) {
            return $query->where('users.user_id', $user->user_id); // remove saved graduates
        })->get()->toJson();

        dd($graduates);

        // retrieve graduates with same course, department, school, school year, batch - PRIORITY
        /* $first = Graduate::with('responses')->whereDoesntHave('users', function ($query) use ($user) {
            return $query->where('users.user_id', $user->user_id); // remove saved graduates
        })->where(function ($query) use ($user) {
            return $query->where('school', $user->academic->school)
            ->where('department', $user->academic->department)
            ->where('degree', $user->academic->degree)
            ->where('school_year', $user->academic->school_year)
            ->where('batch', $user->academic->batch);
        })->get()->shuffle()->all(); */

        // retrieve all batch of graduates related to school year, degree, department and school
        /* $second = Graduate::with('responses')->whereDoesntHave('users', function ($query) use ($user) {
            return $query->where('users.user_id', $user->user_id); // remove saved graduates
        })->where(function ($query) use ($user) {
            return $query->where('school', $user->academic->school)
            ->where('department', $user->academic->department)
            ->where('degree', $user->academic->degree)
            ->where('school_year', $user->academic->school_year);
        })->get()->shuffle()->all(); */

        // retrieve all batch and school year of graduates related to degree, department and school
        /* $third = Graduate::with('responses')->whereDoesntHave('users', function ($query) use ($user) {
            return $query->where('users.user_id', $user->user_id); // remove saved graduates
        })->where(function ($query) use ($user) {
            return $query->where('school', $user->academic->school)
            ->where('department', $user->academic->department)
            ->where('degree', $user->academic->degree);
        })->get()->shuffle()->all(); */

        // retrieve all batch, school year and course of graduates related to department and school
        /* $fourth = Graduate::with('responses')->whereDoesntHave('users', function ($query) use ($user) {
            return $query->where('users.user_id', $user->user_id); // remove saved graduates
        })->where(function ($query) use ($user) {
            return $query->where('school', $user->academic->school)
            ->where('department', $user->academic->department);
        })->get()->shuffle()->all(); */

        // retrieve all batch, degree and department of graduates related to school
        /* $fifth = Graduate::with('responses')->whereDoesntHave('users', function ($query) use ($user) {
            return $query->where('users.user_id', $user->user_id); // remove saved graduates
        })->where(function ($query) use ($user) {
            return $query->where('school', $user->academic->school);
        })->get()->shuffle()->all(); */

        // merge results
        /* $graduates = collect($first)->merge($second)->merge($third)
                    ->merge($fourth)->merge($fifth)->unique()->values()->all(); */

        return response()->json(compact('graduates'));
    }

    public function updateEmployment(Request $request, $id)
    {
        $user = User::find($id);
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
