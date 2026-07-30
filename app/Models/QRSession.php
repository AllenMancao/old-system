<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QRSession extends Model
{
    protected $fillable = [
        'hte_supervisor_id',
        'token',
        'expires_at',
        'is_active',
    ];
    protected $table = 'qr_sessions';

    protected function casts(): array
    {
        return [
            'expires_at' => 'datetime',
            'is_active' => 'boolean',
        ];
    }

    public function supervisor()
    {
        return $this->belongsTo(User::class, 'hte_supervisor_id');
    }

    public function isExpired(): bool
    {
        return $this->expires_at->isPast() || ! $this->is_active;
    }
    
}