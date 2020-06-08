<?php

namespace App\Providers;

use App\Events\GraduateAdded;
use App\Events\TwitterFriendsSaved;
use App\Listeners\StoreGraduateLatLng;
use App\Listeners\StoreTwitterFriendIds;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        GraduateAdded::class => [
            StoreGraduateLatLng::class
        ],
        TwitterFriendsSaved::class => [
            StoreTwitterFriendIds::class
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
