<?php

namespace App\Listeners;

use App\Models\SocialAccount;
use App\Models\TwitterFriendId;
use App\Traits\StaticTrait;
use Illuminate\Contracts\Queue\ShouldQueue;

class StoreTwitterFriendIds implements ShouldQueue
{
    use StaticTrait;

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        $userId = $event->user->user_id;

        $provider = SocialAccount::where(function ($query) use ($userId) {
            return $query->where('provider_name', 'twitter.com')->where('user_id', $userId);
        })->first();

        if ($provider) {
            $twitterFriendIds = $this->getTwitterFriendIds($provider->provider_id);

            foreach ($twitterFriendIds as $key => $value) {
                TwitterFriendId::updateOrCreate([
                    'user_id' => $userId,
                    'friend_id' => $value
                ]);
            }
        }
    }
}
