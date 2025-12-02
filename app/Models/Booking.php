<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'room_id',
        'user_id',
        'start_date',
        'end_date',
        'payment_amount',      // ← BARU
        'status',
        'payment_image',
        'refund_proof',        // ← BARU
        'rejection_reason',    // ← BARU
        'notes',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'payment_amount' => 'decimal:2',  // ← BARU
    ];

    // Relasi
    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // ← BARU: Helper method untuk cek status
    public function isCompleted()
    {
        return $this->status === 'Completed';
    }

    public function canBeDeleted()
    {
        return in_array($this->status, ['Completed', 'Rejected']);
    }
}