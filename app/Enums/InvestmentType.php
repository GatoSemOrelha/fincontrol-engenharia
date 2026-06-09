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
            self::CDB => __('CDB'),
            self::LCI => __('LCI'),
            self::LCA => __('LCA'),
            self::TESOURO_DIRETO => __('Tesouro Direto'),
            self::ACAO => __('Ação'),
            self::FUNDO_IMOBILIARIO => __('Fundo Imobiliário'),
            self::OUTRO => __('Outro'),
        };
    }
}
