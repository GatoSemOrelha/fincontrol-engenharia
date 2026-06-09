<?php

namespace App\Enums;

/**
 * Tipos de investimento suportados pelo sistema.
 */
enum InvestmentType: string
{
    case CDB = 'CDB';
    case LCI = 'LCI';
    case LCA = 'LCA';
    case TESOURO_DIRETO = 'TESOURO_DIRETO';
    case ACAO = 'ACAO';
    case FUNDO_IMOBILIARIO = 'FUNDO_IMOBILIARIO';
    case OUTRO = 'OUTRO';

    /**
     * Retorna o label em português para exibição na UI.
     */
    public function label(): string
    {
        return match ($this) {
            self::CDB => 'CDB',
            self::LCI => 'LCI',
            self::LCA => 'LCA',
            self::TESOURO_DIRETO => 'Tesouro Direto',
            self::ACAO => 'Ação',
            self::FUNDO_IMOBILIARIO => 'Fundo Imobiliário',
            self::OUTRO => 'Outro',
        };
    }
}
