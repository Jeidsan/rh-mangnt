<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserDetail extends Model
{
    protected $fillable = [
        'address',
        'zip_code',
        'city',
        'phone',
        'salary',
        'admission_date',
    ];

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
