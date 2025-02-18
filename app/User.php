<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'users';
    protected $fillable = [
        'name', 'email', 'password', 'phone', 'cpf'
    ];

    protected $hidden = [
        'password'
    ];

    public function accounts()
    {
        return $this->hasMany(\App\Account::class, 'fk_user', 'id');
    }
}
