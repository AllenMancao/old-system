<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AttendanceLog extends Model
{
    protected $fillable = [
        'intern_profile_id',
        'date',
        'time_in',
        'time_out',
        'rendered_hours',
        'status',
        'activity_description',
    ];

    protected function casts(): array
    {
        return [
            'date' => 'date',
            'time_in' => 'datetime',
            'time_out' => 'datetime',
            'rendered_hours' => 'decimal:2',
        ];
    }

    public function intern()
    {
        return $this->belongsTo(InternProfile::class);
    }
}
