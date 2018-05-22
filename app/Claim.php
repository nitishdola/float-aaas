<?php

namespace App;

use App\Notifications\ClaimResetPassword;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Claim extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'username', 'password',
    ];

    public static $rules = [
        'name'              =>  'required|max:255',
        'username'          =>  'required|max:255|unique:claims',
        'password'          =>  'required',
        'password_confirmation'    =>  'required_with:password|same:password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ClaimResetPassword($token));
    }
}
