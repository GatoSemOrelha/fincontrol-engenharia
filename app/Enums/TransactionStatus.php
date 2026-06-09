<?php

namespace App\Enums;

/**
 * Status possíveis de um lançamento financeiro.
 */
enum TransactionStatus: string
{
    case PENDING = 'PENDING';
    case PAID = 'PAID';

    /**
     * Retorna o label em português para exibição na UI.
     */
    public function label(): string
    {
        return match ($this) {
            self::PENDING => 'Em aberto',
            self::PAID => 'Pago',
        };
    }

    /**
     * Retorna a classe CSS do badge correspondente.
     */
    public function badgeClass(): string
    {
        return match ($this) {
            self::PENDING => 'badge-warning',
            self::PAID => 'badge-success',
        };
    }
}
