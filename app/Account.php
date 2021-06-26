<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    protected $table = 'accounts';
    protected $fillable = [
        'agency', 'number', 'digit', 'type', 'name', 'document', 'social_reason', 'fk_user'
    ];
}
