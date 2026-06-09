<?php

namespace App\Enums;

/**
 * Status possíveis de uma invoice (nota fiscal / fatura).
 */
enum InvoiceStatus: string
{
    case PENDING = 'PENDING';
    case PARTIALLY_PAID = 'PARTIALLY_PAID';
    case PAID = 'PAID';
    case CANCELED = 'CANCELED';

    /**
     * Retorna o label em português para exibição na UI.
     */
    public function label(): string
    {
        return match ($this) {
            self::PENDING => 'Pendente',
            self::PARTIALLY_PAID => 'Parcialmente pago',
            self::PAID => 'Pago',
            self::CANCELED => 'Cancelado',
        };
    }

    /**
     * Retorna a classe CSS do badge correspondente.
     */
    public function badgeClass(): string
    {
        return match ($this) {
            self::PENDING => 'badge-warning',
            self::PARTIALLY_PAID => 'badge-info',
            self::PAID => 'badge-success',
            self::CANCELED => 'badge-danger',
        };
    }
}
