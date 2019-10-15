<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $guarded = [];
    protected $primaryKey = 'contact_id';
    public $incrementing = false;

    public function user()
    {
        return $this->belongsTo(User::class, 'contact_id');
    }
}
