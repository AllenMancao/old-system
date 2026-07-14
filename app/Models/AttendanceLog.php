<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AttendanceLog extends Model
{
    protected $fillable = [
        'intern_id',
        'date',
        'time_in',
        'time_out',
        'rendered_hours',
        'status',
    ];

    protected $casts = [
    'date' => 'date:Y-m-d',
    'time_in' => 'datetime:H:i:s',
    'time_out' => 'datetime:H:i:s',
    'rendered_hours' => 'decimal:2',
];

    public function intern(): BelongsTo
    {
        return $this->belongsTo(User::class, 'intern_id');
    }
}