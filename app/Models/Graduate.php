<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;

class Graduate extends Model
{
    protected $guarded = [];
    protected $primaryKey = 'graduate_id';
    public $incrementing = false;

    public function image()
    {
        $defaultImage = $this->gender == 'Male' ? 'defaults/default_avatar_m.png' : 'defaults/default_avatar_f.png';
        $imagePath = 'storage/' . rawurldecode($this->image_uri);

        if (File::exists($imagePath)) {
            return $imagePath;
        }

        return 'storage/' . $defaultImage;
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'graduate_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_graduate', 'graduate_id', 'user_id')->withPivot('response_id')->withTimestamps();
    }

    public function responses()
    {
        return $this->belongsToMany(Response::class, 'user_graduate', 'graduate_id', 'response_id')->withPivot('user_id')->withTimestamps();
    }

    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->middle_name . ' ' . $this->last_name;
    }

    public function getBatchYearAttribute()
    {
        return $this->batch . ' ' . $this->school_year;
    }
}
