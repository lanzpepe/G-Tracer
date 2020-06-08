<?php

namespace App\Traits;

use App\Models\Admin;
use App\Models\Graduate;
use App\Models\User;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;

trait StaticTrait
{
    /**
     * Return the data of graduate being searched.
     *
     * @param \Illuminate\Http\Request $request
     * @return mixed
     */
    public function search(Request $request)
    {
        $graduate = Graduate::whereHas('academic', function ($query) use ($request) {
                        return $query->where('code', $request->code)->where('degree', $request->degree)
                                ->where('major', $request->major)->where('department', $request->department)
                                ->where('school', $request->school)->where('year', $request->schoolYear)
                                ->where('batch', $request->batch);
                    })->where('last_name', $request->lastName)->where('first_name', $request->firstName);

        return $graduate->first();
    }

    /**
     * Find department users related to department and school of the respondent.
     *
     * @param \App\Models\User $user
     * @return mixed
     */
    public function findAdmins(User $user)
    {
        $admins = Admin::whereHas('departments', function ($query) use ($user) {
            return $query->where('departments.name', $user->academic->department);
        })->whereHas('schools', function ($query) use ($user) {
            return $query->where('schools.name', $user->academic->school);
        })->whereHas('roles', function ($query) {
            return $query->where('roles.name', config('constants.roles.dept'));
        })->get();

        return $admins;
    }

    /**
     * Capitalize each word in a string.
     *
     * @param string $tag
     * @return mixed
     */
    public function capitalize($tag)
    {
        $words = ['And', 'In', 'Of', 'The'];
        $word = ucwords($tag);
        $regex = '/\b(' . implode('|', $words) . ')\b/i';

        return preg_replace_callback($regex, function ($matches) {
            return strtolower($matches[1]);
        }, $word);
    }

    /**
     * Returns the user's information from Twitter.
     *
     * @param string $username
     * @return mixed
     */
    public function getTwitterUser($username)
    {
        $url = "https://api.twitter.com/1.1/users/show.json";
        $accessToken = env('TWITTER_ACCESS_TOKEN');
        $client = new Client([
            'headers' => [
                'Authorization' => "Bearer {$accessToken}"
            ],
            'query' => [
                'screen_name' => $username
            ]
        ]);
        $res = $client->request('GET', $url);
        $result = json_decode($res->getBody(), true);

        return $result;
    }

    /**
     * Returns a cursored collection of user IDs for every user the specified user is following
     * (otherwise known as their "friends").
     *
     * @param string $id
     * @return mixed
     */
    public function getTwitterFriendIds($id)
    {
        $url = "https://api.twitter.com/1.1/friends/ids.json";
        $accessToken = env('TWITTER_ACCESS_TOKEN');
        $users = collect();
        $client = new Client([
            'headers' => [
                'Authorization' => "Bearer {$accessToken}"
            ],
            'query' => [
                'user_id' => $id
            ]
        ]);

        try {
            $res = $client->request('GET', $url);
            $result = json_decode($res->getBody(), true);
            $users->push($result['ids']);
        } catch (RequestException $e) {
            return $users->first();
        }

        return $users->first();
    }

    /**
     * Converts encoded address into geographic coordinates (latitude and longitude).
     *
     * @param string $address
     * @return mixed
     */
    public function getLatLng($address)
    {
        $url = 'https://maps.googleapis.com/maps/api/geocode/json';
        $client = new Client([
            'query' => [
                'address' => $address,
                'region' => 'PH',
                'key' => env('FCM_SERVER_KEY')
            ]
        ]);
        $res = $client->request('GET', $url);
        $result = json_decode($res->getBody(), true);

        return $result['results'][0]['geometry']['location'];
    }

    /**
     * Returns the computed distance between two points in kilometers.
     *
     * @param float $lat1
     * @param float $lat2
     * @param float $long1
     * @param float $long2
     * @return float
     */
    public function getDistance($lat1, $lat2, $long1, $long2)
    {
        $sin = sin(deg2rad($lat1)) * sin(deg2rad($lat2));
        $cos = cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($long1) - deg2rad($long2));

        return acos($sin + $cos) * 6371;
    }
}
