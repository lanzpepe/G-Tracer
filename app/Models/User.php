<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $primaryKey = 'user_id';
    protected $guarded = [];
    public $incrementing = false;

    public function image()
    {
        $path = $this->gender == 'Male' ? asset('storage/defaults/default_avatar_m.png') : asset('storage/defaults/default_avatar_f.png');

        return $path;
    }

    public function admins()
    {
        return $this->hasMany(Admin::class, 'user_id');
    }

    public function contacts()
    {
        return $this->hasMany(Contact::class, 'user_id')->latest();
    }

    public function academic()
    {
        return $this->hasOne(Academic::class, 'user_id');
    }

    public function employments()
    {
        return $this->hasMany(Employment::class, 'user_id')->latest();
    }

    public function socialAccount()
    {
        return $this->hasOne(SocialAccount::class, 'user_id');
    }

    public function addedGraduates()
    {
        return $this->belongsToMany(Graduate::class, 'added_graduates', 'user_id',
            'graduate_id')->withTimestamps();
    }

    public function responses()
    {
        return $this->belongsToMany(Response::class, 'added_graduates', 'user_id',
            'graduate_id', 'response_id')->withTimestamps();
    }

    public function createContact($contact)
    {
        return $this->contacts()->create($contact);
    }

    public function createAcademic($academic)
    {
        return $this->academic()->create($academic);
    }

    public function createEmployment($employment)
    {
        return $this->employments()->create($employment);
    }

    public function createSocialAccount($socialAccount)
    {
        return $this->socialAccount()->create($socialAccount);
    }
}
