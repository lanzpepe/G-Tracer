<?php

namespace App\Handlers;

use Illuminate\Support\Facades\Auth;
use UniSharp\LaravelFilemanager\Handlers\ConfigHandler;

class LfmConfigHandler extends ConfigHandler
{
    public function userField()
    {
        return Auth::user()->admin_id;
    }
}
