<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <title>{{ __('Relatório Mensal') }} — FinControl</title>
    <style>
        @page { margin: 40px 40px; }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Helvetica', 'Arial', sans-serif; font-size: 11px; color: #1a1a19; line-height: 1.5; background: #ffffff; }

        .header { background: #042c53; color: white; padding: 30px; margin: -40px -40px 30px -40px; }
        .header-content { width: 100%; display: table; }
        .header-left { display: table-cell; vertical-align: middle; }
        .header-right { display: table-cell; text-align: right; vertical-align: middle; }
        
        .header h1 { font-size: 22px; font-weight: bold; letter-spacing: 0.5px; margin-bottom: 4px; color: #ffffff; }
        .header p { font-size: 12px; opacity: 0.8; color: #f1efea; }
        .header-badge { background: rgba(255,255,255,0.15); padding: 4px 10px; border-radius: 4px; font-size: 10px; font-weight: bold; letter-spacing: 1px; text-transform: uppercase; color: #ffffff; }

        .section { margin-bottom: 25px; }
        .section-title { font-size: 14px; font-weight: bold; color: #042c53; border-bottom: 2px solid #e6f1fb; padding-bottom: 6px; margin-bottom: 12px; text-transform: uppercase; letter-spacing: 0.5px; }

        .metrics-table { width: 100%; border-collapse: separate; border-spacing: 12px 0; margin: 0 -12px 25px -12px; }
        .metrics-table td { width: 33.33%; background: #f5f5f4; border: 1px solid #eeede8; border-radius: 8px; padding: 16px; text-align: center; }
        
        .metric-label { font-size: 10px; color: #5f5e5a; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 6px; }
        .metric-value { font-size: 20px; font-weight: bold; }
        
        .text-success { color: #3b6d11; }
        .text-danger { color: #a32d2d; }
        .text-info { color: #185fa5; }

        table.data-table { width: 100%; border-collapse: collapse; font-size: 10px; margin-bottom: 10px; }
        table.data-table th { background: #f5f5f4; padding: 8px 10px; text-align: left; font-weight: bold; color: #5f5e5a; border-top: 1px solid #eeede8; border-bottom: 2px solid #eeede8; text-transform: uppercase; letter-spacing: 0.5px; }
        table.data-table td { padding: 8px 10px; border-bottom: 1px solid #eeede8; color: #1a1a19; }
        table.data-table tr:nth-child(even) td { background: #fafafa; }
        
        .font-weight-bold { font-weight: bold; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }

        .badge-status { padding: 3px 6px; border-radius: 4px; font-size: 9px; font-weight: bold; text-transform: uppercase; }
        .badge-paid { background: #eaf3de; color: #3b6d11; border: 1px solid #97c459; }
        .badge-open { background: #faeeda; color: #854f0b; border: 1px solid #ef9f27; }

        .footer { margin-top: 40px; padding-top: 15px; border-top: 1px solid #eeede8; font-size: 9px; color: #888780; text-align: center; width: 100%; position: fixed; bottom: 0; }
        
        .page-break { page-break-before: always; }
        
        .empty-state { text-align: center; padding: 20px; background: #f5f5f4; color: #888780; font-style: italic; border-radius: 6px; }
    </style>
</head>
<body>
    {{-- Header --}}
    <div class="header">
        <div class="header-content">
            <div class="header-left">
                <h1>{{ __('Relatório Mensal') }}</h1>
                <p>FinControl — {{ __('Gestão Financeira') }}</p>
            </div>
            <div class="header-right">
                <span class="header-badge">{{ $report->periodLabel() }}</span>
                <p style="margin-top: 8px;">{{ __('Gerado em') }} {{ now()->format('d/m/Y H:i') }}</p>
            </div>
        </div>
    </div>

    {{-- Métricas Principais --}}
    <table class="metrics-table">
        <tr>
            <td>
                <div class="metric-label">{{ __('Receitas') }}</div>
                <div class="metric-value text-success">{{ money($report->total_income) }}</div>
            </td>
            <td>
                <div class="metric-label">{{ __('Despesas') }}</div>
                <div class="metric-value text-danger">{{ money($report->total_expense) }}</div>
            </td>
            <td>
                <div class="metric-label">{{ __('Resultado Líquido') }}</div>
                <div class="metric-value text-info">{{ money($report->net_result) }}</div>
            </td>
        </tr>
    </table>

    {{-- Resumos por Categoria --}}
    <table style="width: 100%; border-collapse: separate; border-spacing: 20px 0; margin: 0 -20px 25px -20px;">
        <tr>
            <td style="width: 50%; vertical-align: top;">
                <div class="section">
                    <div class="section-title">{{ __('Receitas por Categoria') }}</div>
                    @if(!empty($data['income_by_category']))
                        <table class="data-table">
                            <thead><tr><th>{{ __('Categoria') }}</th><th class="text-right">{{ __('Total') }}</th><th class="text-right">%</th></tr></thead>
                            <tbody>
                                @foreach($data['income_by_category'] as $cat)
                                    <tr>
                                        <td>{{ $cat['category_name'] }}</td>
                                        <td class="text-right text-success font-weight-bold">{{ money($cat['total']) }}</td>
                                        <td class="text-right">{{ $cat['percentage'] }}%</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="empty-state">{{ __('Nenhum dado encontrado.') }}</div>
                    @endif
                </div>
            </td>
            <td style="width: 50%; vertical-align: top;">
                <div class="section">
                    <div class="section-title">{{ __('Despesas por Categoria') }}</div>
                    @if(!empty($data['expenses_by_category']))
                        <table class="data-table">
                            <thead><tr><th>{{ __('Categoria') }}</th><th class="text-right">{{ __('Total') }}</th><th class="text-right">%</th></tr></thead>
                            <tbody>
                                @foreach($data['expenses_by_category'] as $cat)
                                    <tr>
                                        <td>{{ $cat['category_name'] }}</td>
                                        <td class="text-right text-danger font-weight-bold">{{ money($cat['total']) }}</td>
                                        <td class="text-right">{{ $cat['percentage'] }}%</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="empty-state">{{ __('Nenhum dado encontrado.') }}</div>
                    @endif
                </div>
            </td>
        </tr>
    </table>

    {{-- Receitas por Cliente --}}
    <div class="section">
        <div class="section-title">{{ __('Receitas por Cliente') }}</div>
        @if(!empty($data['income_by_client']))
            <table class="data-table">
                <thead>
                    <tr>
                        <th>{{ __('Cliente') }}</th>
                        <th class="text-center">{{ __('Lançamentos') }}</th>
                        <th class="text-right">{{ __('Participação') }}</th>
                        <th class="text-right">{{ __('Total') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data['income_by_client'] as $client)
                        <tr>
                            <td>{{ $client['client_name'] }}</td>
                            <td class="text-center">{{ $client['count'] }}</td>
                            <td class="text-right">{{ $client['percentage'] }}%</td>
                            <td class="text-right text-success font-weight-bold">{{ money($client['total']) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="empty-state">{{ __('Nenhum cliente gerou receita neste período.') }}</div>
        @endif
    </div>

    {{-- Extrato Detalhado --}}
    <div class="page-break"></div>
    
    <div class="header">
        <div class="header-content">
            <div class="header-left">
                <h1>{{ __('Extrato Detalhado') }}</h1>
                <p>FinControl — {{ __('Todas as Movimentações') }}</p>
            </div>
            <div class="header-right">
                <span class="header-badge">{{ $report->periodLabel() }}</span>
            </div>
        </div>
    </div>

    <div class="section">
        @if(!empty($data['transactions']))
            <table class="data-table">
                <thead>
                    <tr>
                        <th>{{ __('Data') }}</th>
                        <th>{{ __('Descrição') }}</th>
                        <th>{{ __('Categoria') }}</th>
                        <th>{{ __('Conta') }}</th>
                        <th class="text-center">{{ __('Tipo') }}</th>
                        <th class="text-center">{{ __('Status') }}</th>
                        <th class="text-right">{{ __('Valor') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data['transactions'] as $tx)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($tx['due_date'])->format('d/m/Y') }}</td>
                            <td>{{ $tx['description'] }}</td>
                            <td>{{ $tx['category']['name'] ?? '—' }}</td>
                            <td>{{ $tx['bank_account']['name'] ?? '—' }}</td>
                            <td class="text-center">
                                @if($tx['transaction_type'] === 'INCOME')
                                    <span class="text-success">{{ __('Entrada') }}</span>
                                @else
                                    <span class="text-danger">{{ __('Saída') }}</span>
                                @endif
                            </td>
                            <td class="text-center">
                                @if($tx['status'] === 'PAID')
                                    <span class="badge-status badge-paid">{{ __('Pago') }}</span>
                                @else
                                    <span class="badge-status badge-open">{{ __('Em aberto') }}</span>
                                @endif
                            </td>
                            <td class="text-right font-weight-bold {{ $tx['transaction_type'] === 'INCOME' ? 'text-success' : 'text-danger' }}">
                                {{ money($tx['amount']) }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="empty-state">{{ __('Nenhuma movimentação encontrada para este período.') }}</div>
        @endif
    </div>

    <div class="footer">
        FinControl — {{ __('Sistema de Gestão Financeira') }} · {{ __('Relatório gerado automaticamente e imutável') }} · {{ now()->format('d/m/Y H:i:s') }}
    </div>
</body>
</html>
