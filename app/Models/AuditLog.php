<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Model: AuditLog (Log de auditoria)
 * Registra alterações relevantes no sistema.
 */
class AuditLog extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'action',
        'auditable_type',
        'auditable_id',
        'old_values',
        'new_values',
        'ip_address',
        'created_at',
    ];

    protected $casts = [
        'old_values' => 'array',
        'new_values' => 'array',
        'created_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Retorna o label da ação para exibição.
     */
    public function actionLabel(): string
    {
        return match ($this->action) {
            'created' => __('Criado'),
            'updated' => __('Editado'),
            'deleted' => __('Excluído'),
            'paid' => __('Pago'),
            default => __(ucfirst($this->action)),
        };
    }

    /**
     * Retorna a classe CSS do badge da ação.
     */
    public function actionBadgeClass(): string
    {
        return match ($this->action) {
            'created' => 'badge-info',
            'updated' => 'badge-info',
            'deleted' => 'badge-danger',
            'paid' => 'badge-success',
            default => 'badge-warning',
        };
    }

    /**
     * Retorna o nome "amigável" do tipo de entidade.
     */
    public function entityName(): string
    {
        return match ($this->auditable_type) {
            'App\Models\Transaction' => __('Lançamento'),
            'App\Models\BankAccount' => __('Conta bancária'),
            'App\Models\Category' => __('Categoria'),
            'App\Models\User' => __('Usuário'),
            'App\Models\CreditCard' => __('Cartão de crédito'),
            'App\Models\Investment' => __('Investimento'),
            default => class_basename($this->auditable_type),
        };
    }
}
