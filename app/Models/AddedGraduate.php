<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AddedGraduate extends Model
{
    protected $guarded = [];
    protected $primaryKey = 'user_id';
    public $incrementing = false;

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function graduate()
    {
        return $this->belongsTo(Graduate::class, 'graduate_id');
    }

    public function response()
    {
        return $this->belongsTo(Response::class, 'response_id');
    }
}
