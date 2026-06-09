<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Model: MonthlyReport (Relatório mensal)
 * RF12 — Relatório mensal fechado e imutável.
 */
class MonthlyReport extends Model
{
    protected $fillable = [
        'year',
        'month',
        'total_income',
        'total_expense',
        'net_result',
        'report_data',
        'pdf_path',
        'is_closed',
        'user_id',
        'closed_by',
        'closed_at',
    ];

    protected $casts = [
        'year' => 'integer',
        'month' => 'integer',
        'total_income' => 'decimal:2',
        'total_expense' => 'decimal:2',
        'net_result' => 'decimal:2',
        'report_data' => 'array',
        'is_closed' => 'boolean',
        'closed_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function closedByUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'closed_by');
    }

    /**
     * Retorna label do mês/ano: "Maio 2025"
     */
    public function periodLabel(): string
    {
        $months = [
            1 => 'Janeiro', 2 => 'Fevereiro', 3 => 'Março',
            4 => 'Abril', 5 => 'Maio', 6 => 'Junho',
            7 => 'Julho', 8 => 'Agosto', 9 => 'Setembro',
            10 => 'Outubro', 11 => 'Novembro', 12 => 'Dezembro',
        ];

        return ($months[$this->month] ?? '')." {$this->year}";
    }
}
