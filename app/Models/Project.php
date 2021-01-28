<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Helpers\ProjectHelper;
use Illuminate\Support\Facades\Auth;
use Laravel\Passport\HasApiTokens;


class Project extends Model
{
    use HasApiTokens,HasFactory;

    protected $fillable =[
        "name",
        "user_id",
        "api_key",
        "api_secret",


    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function errors()
    {
        return $this->hasMany(Error::class);
    }

    public static function boot()
    {
        parent::boot();

        self::creating(function($model){
            $model->user_id  = Auth::id();
            $model->api_key = ProjectHelper::code();
            $model->api_secret = ProjectHelper::code();
        });
    }
}
