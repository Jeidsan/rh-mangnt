<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class User extends Model
{
    public function detail() : HasOne
    {
        return $this->hasOne(UserDetail::class);
    }

    public function department() : BelongsTo
    {
        return $this->belongsTo(Department::class);
    }
}
