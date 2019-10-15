<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GraduateTask extends Model
{
    protected $guarded = [];
    protected $primaryKey = 'task_id';
    public $incrementing = false;

    public function graduate()
    {
        return $this->belongsTo(Graduate::class);
    }
}
