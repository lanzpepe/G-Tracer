<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reward extends Model
{
    protected $guarded = [];

    public function image()
    {
        $imagePath = urldecode($this->image_uri);

        return "storage/{$imagePath}";
    }
}
