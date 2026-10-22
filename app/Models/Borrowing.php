<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Borrowing extends Model
{
    protected $fillable = [
        'user_id',
        'duration_days',
        'requested_date',
        'approved_at_date',
        'due_date',
        'returned_at_date',
        'status',
        'admin_note',
    ];

    protected function casts(): array
    {
        return [
            'requested_date' => 'date',
            'approved_at_date' => 'date',
            'due_date' => 'date',
            'returned_at_date' => 'date',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function details(): HasMany
    {
        return $this->hasMany(BorrowingDetail::class);
    }
}