<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    protected $casts = [
        'quantity'     => 'integer',
        'total_amount' => 'decimal:2',
    ];

    protected $fillable = [
        'order_number',
        'customer_id',
        'book_id',
        'quantity',
        'total_amount',
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(User::class, foreignKey: 'customer_id');
    }

    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }
}
