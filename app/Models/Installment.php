<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Model: Installment (Parcela — vínculo invoice ↔ transaction)
 */
class Installment extends Model
{
    protected $fillable = [
        'invoice_id',
        'transaction_id',
        'installment_number',
    ];

    protected $casts = [
        'installment_number' => 'integer',
    ];

    public function invoice(): BelongsTo
    {
        return $this->belongsTo(Invoice::class);
    }

    public function transaction(): BelongsTo
    {
        return $this->belongsTo(Transaction::class);
    }
}
