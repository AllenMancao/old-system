<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = [
        'course_code',
        'course_name',
        'required_hours',
    ];

    public function interns()
    {
        return $this->hasMany(InternProfile::class);
    }

    public function ojtSupervisor()
    {
        return $this->belongsTo(User::class,'ojt_supervisor_id');
    }
}
