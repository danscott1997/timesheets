<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Staff extends Model
{
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
    ];

    protected $appends = ['full_name'];

    public function getFullNameAttribute(): string
    {
        return Str::limit(ucwords(sprintf("%s %s", $this->first_name, $this->last_name)), 20);
    }
}
