<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $guarded = [];

    public function admins()
    {
        return $this->belongsToMany(Admin::class, 'admin_page', 'page_id', 'admin_id')->withTimestamps();
    }
}
