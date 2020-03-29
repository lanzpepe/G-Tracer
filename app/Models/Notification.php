<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Notification extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function unread()
    {
        return self::all()->sortByDesc('created_at');
    }

    public static function count()
    {
        return self::where('read_at', null)->count();
    }
}
