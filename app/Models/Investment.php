<?php

namespace App\Models;

use App\Enums\InvestmentType;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Model: Investment (Investimento)
 */
class Investment extends Model
{
    protected $fillable = [
        'name',
        'type',
        'initial_amount',
        'current_amount',
        'start_date',
        'end_date',
        'interest_rate',
        'user_id',
    ];

    protected $casts = [
        'type' => InvestmentType::class,
        'initial_amount' => 'decimal:2',
        'current_amount' => 'decimal:2',
        'start_date' => 'date',
        'end_date' => 'date',
        'interest_rate' => 'decimal:4',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Projeta o valor futuro do investimento para uma data.
     * Usa juros compostos diários (taxa anual / 252 dias úteis).
     */
    public function projectValueAt(Carbon $targetDate): float
    {
        $daysFromStart = $this->start_date->diffInDays($targetDate);
        $dailyRate = $this->interest_rate / 100 / 252;

        return $this->current_amount * pow(1 + $dailyRate, $daysFromStart);
    }
}
