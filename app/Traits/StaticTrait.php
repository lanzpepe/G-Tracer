<?php

namespace App\Traits;

use App\Models\Graduate;
use App\Models\User;

trait StaticTrait
{
    public function search(User $user)
    {
        $graduate = Graduate::where('last_name', $user->last_name)
                    ->where('first_name', $user->first_name)
                    ->where('degree', $user->academic->degree)
                    ->where('major', $user->academic->major)
                    ->where('department', $user->academic->department)
                    ->where('school', $user->academic->school)
                    ->where('school_year', $user->academic->school_year)
                    ->where('batch', $user->academic->batch)->first();

        if ($graduate) {
            $user->graduate()->save($graduate);
        }

        return $graduate;
    }

    public function capitalize($tag)
    {
        $words = ['And', 'In', 'Of', 'The'];
        $word = ucwords($tag);
        $regex = '/\b(' . implode('|', $words) . ')\b/i';

        return preg_replace_callback($regex, function ($matches) {
            return strtolower($matches[1]);
        }, $word);
    }
}
