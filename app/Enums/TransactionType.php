<?php

namespace App\Enums;

/**
 * Tipos de transação financeira.
 */
enum TransactionType: string
{
    case INCOME = 'INCOME';
    case EXPENSE = 'EXPENSE';

    /**
     * Retorna o label em português para exibição na UI.
     */
    public function label(): string
    {
        return match ($this) {
            self::INCOME => 'Entrada',
            self::EXPENSE => 'Saída',
        };
    }

    /**
     * Retorna a classe CSS correspondente.
     */
    public function cssClass(): string
    {
        return match ($this) {
            self::INCOME => 'tag-in',
            self::EXPENSE => 'tag-out',
        };
    }
}
