<?php

namespace App\Models;

use App\Enums\InvoiceStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Model: Invoice (Nota fiscal / Fatura)
 */
class Invoice extends Model
{
    protected $fillable = [
        'invoice_number',
        'description',
        'total_amount',
        'due_date',
        'status',
        'user_id',
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
        'due_date' => 'date',
        'status' => InvoiceStatus::class,
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function installments(): HasMany
    {
        return $this->hasMany(Installment::class);
    }

    /**
     * Retorna as transações vinculadas via parcelas.
     */
    public function transactions()
    {
        return $this->hasManyThrough(
            Transaction::class,
            Installment::class,
            'invoice_id',
            'id',
            'id',
            'transaction_id'
        );
    }
}
