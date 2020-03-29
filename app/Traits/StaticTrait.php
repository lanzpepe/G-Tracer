<?php

namespace App\Traits;

use App\Models\Graduate;
use App\Models\Notification;
use GuzzleHttp\Client;
use LaravelFCM\Facades\FCM;
use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;

trait StaticTrait
{
    /**
     * Return the data of graduate being searched.
     *
     * @param \App\Models\User $user
     * @return \App\Models\Graduate
     */
    public function search($user)
    {
        $graduate = Graduate::where('last_name', $user->last_name)
                    ->where('first_name', $user->first_name)
                    ->whereHas('academic', function ($query) use ($user) {
                        return $query->where('degree', $user->academic->degree)
                                ->where('major', $user->academic->major)
                                ->where('department', $user->academic->department)
                                ->where('year', $user->academic->year)
                                ->where('batch', $user->academic->batch);
                    })->first();

        if ($graduate) {
            $user->graduate()->save($graduate);
        }

        return $graduate;
    }

    /**
     * Capitalize each word in a string.
     *
     * @param string $tag
     * @return string
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
     * Retrieve the latitude and longitude of encoded address.
     *
     * @param string $address
     * @return array
     */
    public function getLatLng($address)
    {
        $url = 'https://maps.googleapis.com/maps/api/geocode/json';
        $client = new Client();
        $res = $client->request('GET', $url, [
            'query' => [
                'address' => $address,
                'region' => 'PH',
                'key' => env('FCM_SERVER_KEY')
            ]
        ]);
        $result = json_decode($res->getBody(), true);

        return $result['results'][0]['geometry']['location'];
    }

    /**
     * Return the computed distance between two points in kilometers.
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

    /**
     * Trigger real-time notification of user activities.
     *
     * @param string $token
     * @param string $title
     * @param string $body
     * @param string|nullable $icon
     * @param string|nullable $action
     * @return void
     */
    public function sendNotification($token, $title, $body, $icon = null, $action = null)
    {
        $optionBuilder = new OptionsBuilder();
        $optionBuilder->setTimeToLive(60*20);

        $notificationBuilder = new PayloadNotificationBuilder($title);
        $notificationBuilder->setBody($body)
                            ->setSound('default')
                            ->setBadge(Notification::count())
                            ->setIcon($icon)
                            ->setClickAction($action);

        $dataBuilder = new PayloadDataBuilder();
        $option = $optionBuilder->build();
        $notification = $notificationBuilder->build();
        $data = $dataBuilder->build();

        $downstreamResponse = FCM::sendTo($token, $option, $notification, $data);

        $downstreamResponse->numberSuccess();
        $downstreamResponse->numberFailure();
        $downstreamResponse->numberModification();

        // remove all tokens in the database
        $downstreamResponse->tokensToDelete();

        // modify tokens in the database
        $downstreamResponse->tokensToModify();

        // resend messages to tokens in the array
        $downstreamResponse->tokensToRetry();

        // remove all tokens in the database (production)
        $downstreamResponse->tokensWithError();
    }
}
