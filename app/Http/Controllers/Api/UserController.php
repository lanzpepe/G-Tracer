<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Graduate;
use App\Models\SocialAccount;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function getAllUsers()
    {
        $users = User::with([
            'contacts', 'academic', 'employments', 'employments.company',
            'socialAccount', 'likedGraduates.graduate', 'responses'
        ])->get();

        return response()->json(compact('users'));
    }

    public function getUser($accountId)
    {
        $account = SocialAccount::find($accountId)->user;
        $user = User::with([
            'contacts', 'academic', 'employments', 'employments.company',
            'socialAccount', 'likedGraduates.graduate', 'responses'
        ])->where('user_id', $account->user_id)->firstOrFail();

        return response()->json(compact('user'));
    }

    // if user is a college graduate, match graduates based on related information
    public function getAllGraduatesExceptId($userId)
    {
        $user = User::findOrFail($userId);
        // get the graduates based on school, department, year and batch
        $graduates = Graduate::where('last_name', '<>', $user->last_name)
            ->where('first_name', '<>', $user->first_name)
            ->where('middle_name', '<>', $user->middle_name)
            ->where(function ($query) use ($user) { // query school
                $query->where('school', $user->academic->school); })
            ->where(function ($query) use ($user) { // query department
                $query->where('department', $user->academic->department); })
            ->where(function ($query) use ($user) { // query school year and batch
                $query->where('school_year', $user->academic->school_year)
                    ->orWhere('batch', $user->academic->batch); })
            // remove graduates that are already saved from the swipe card
            ->leftJoin('liked_graduates', 'graduates.graduate_id', '=', 'liked_graduates.graduate_id')
            ->whereNull('liked_graduates.user_id')->orWhere('liked_graduates.user_id', '<>', $user->user_id)
            ->select('graduates.*')->get();

        return response()->json(compact('graduates'));
    }

    // if user is not a college graduate, match other users based on related information
    public function getAllUsersExceptId($userId)
    {
        $user = User::find($userId);
        $users = User::where('user_id', '<>', $user->userId);
    }
}
