<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InternProfile extends Model
{
    protected $fillable = [
        'user_id',
        'course_id',
        'hte_unit_id',
        'student_number',
        'year_level',
        'start_date',
        'end_date',
        'required_hours',
        'current_hours',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date' => 'date',
            'current_hours' => 'decimal:2',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function hteUnit()
    {
        return $this->belongsTo(HTEUnit::class);
    }

    public function attendanceLogs()
    {
        return $this->hasMany(AttendanceLog::class);
    }
}
