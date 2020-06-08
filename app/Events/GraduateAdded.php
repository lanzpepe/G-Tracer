<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class GraduateAdded
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $graduate;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($graduate)
    {
        $this->graduate = $graduate;
    }
}
