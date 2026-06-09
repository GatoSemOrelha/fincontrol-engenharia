<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Model: Category (Categoria financeira)
 *
 * @property int $id
 * @property string $name
 * @property string $type INCOME|EXPENSE
 */
class Category extends Model
{
    protected $fillable = [
        'name',
        'type',
    ];

    // ─── Relacionamentos ──────────────────────────

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    // ─── Scopes ───────────────────────────────────

    public function scopeIncome($query)
    {
        return $query->where('type', 'INCOME');
    }

    public function scopeExpense($query)
    {
        return $query->where('type', 'EXPENSE');
    }
}
