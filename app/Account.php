<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    protected $table = 'accounts';
    protected $fillable = [
        'agency', 'number', 'digit', 'type', 'name', 'document', 'social_reason', 'fk_user'
    ];

    public function transactions() {
        return $this->hasMany(\App\Transaction::class, 'fk_account', 'id');
    }

    public function owner() {
        return $this->hasOne(\App\User::class, 'id', 'fk_user');
    }
}
