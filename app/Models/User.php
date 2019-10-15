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

    public function likedGraduates()
    {
        return $this->hasMany(LikedGraduate::class, 'user_id')->latest();
    }

    public function responses()
    {
        return $this->hasMany(Response::class, 'user_id')->latest();
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

    public function createLikedGraduate($graduate)
    {
        return $this->likedGraduates()->create($graduate);
    }

    public function createResponse($response)
    {
        return $this->responses()->create($response);
    }
}
