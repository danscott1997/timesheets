<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TimeEntries extends Model
{
    protected $fillable = [
        'staff_id',
        'date',
        'clocked_in',
        'clocked_out',
    ];

    public function staff(): BelongsTo
    {
        return $this->belongsTo(Staff::class);
    }
}
