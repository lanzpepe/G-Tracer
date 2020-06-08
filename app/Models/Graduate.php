<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Graduate extends Model
{
    protected $guarded = [];
    protected $primaryKey = 'graduate_id';
    public $incrementing = false;

    public function contacts()
    {
        return $this->hasMany(Contact::class, 'graduate_id');
    }

    public function academic()
    {
        return $this->hasOne(Academic::class, 'graduate_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_graduate', 'graduate_id', 'user_id')
            ->as('respondent')->withPivot('response_id')->withTimestamps()->latest();
    }

    public function responses()
    {
        return $this->belongsToMany(Response::class, 'user_graduate', 'graduate_id', 'response_id')
            ->as('respondent')->withPivot('user_id')->withTimestamps()->latest();
    }

    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->middle_name . ' ' . $this->last_name;
    }

    public function getImageAttribute()
    {
        $defaultImage = $this->gender == 'Male' ? 'defaults/default_avatar_m.png' : 'defaults/default_avatar_f.png';
        $imagePath = str_replace("+", "%20", rawurldecode($this->image_uri));

        if ($this->image_uri != null) {
            return $imagePath;
        }

        return "storage/{$defaultImage}";
    }
}
