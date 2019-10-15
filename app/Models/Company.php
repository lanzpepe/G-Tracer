<?php

namespace App\Models;

use App\Models\UserEmployment;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $guarded = [];
    protected $primaryKey = "company_id";
    public $incrementing = false;

    public function employments()
    {
        return $this->hasMany(UserEmployment::class, "company_id");
    }
}
