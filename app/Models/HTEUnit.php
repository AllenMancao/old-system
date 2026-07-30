<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HTEUnit extends Model
{
    protected $table = 'hte_units';

    protected $fillable = [
        'unit_name',
        'hte_supervisor_id',
    ];

    public function interns()
    {
        return $this->hasMany(InternProfile::class);
    }

    public function supervisor()
    {
        return $this->belongsTo(User::class, 'hte_supervisor_id');
    }
}