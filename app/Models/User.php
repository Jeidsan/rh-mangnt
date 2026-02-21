<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as AuthUser;
use Illuminate\Notifications\Notifiable;

class User extends AuthUser
{
    use HasFactory, Notifiable, SoftDeletes;

    public function detail() : HasOne
    {
        return $this->hasOne(UserDetail::class);
    }

    public function department() : BelongsTo
    {
        return $this->belongsTo(Department::class);
    }
}
