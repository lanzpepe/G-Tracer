<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Academic extends Model
{
    protected $guarded = [];
    protected $primaryKey = 'academic_id';
    public $incrementing = false;

    public function user()
    {
        return $this->belongsTo(User::class, 'academic_id');
    }

    public function graduate()
    {
        return $this->belongsTo(Graduate::class, 'academic_id');
    }
}
