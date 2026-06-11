<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <title>{{ __('Relatório Mensal') }} — FinControl</title>
    <style>
        @page { margin: 35px; }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Helvetica', 'Arial', sans-serif; font-size: 11px; color: #1a1a19; line-height: 1.5; background: #ffffff; }

        .header { background: #042c53; color: white; padding: 20px; border-radius: 6px; margin-bottom: 25px; }
        
        .header h1 { font-size: 20px; font-weight: bold; margin-bottom: 4px; color: #ffffff; }
        .header p { font-size: 12px; color: #e6f1fb; }
        .header-badge { background: #185fa5; padding: 5px 10px; border-radius: 4px; font-size: 10px; font-weight: bold; text-transform: uppercase; color: #ffffff; display: inline-block; margin-bottom: 6px; }

        .section { margin-bottom: 20px; }
        .section-title { font-size: 13px; font-weight: bold; color: #042c53; border-bottom: 1px solid #cce0f5; padding-bottom: 4px; margin-bottom: 10px; text-transform: uppercase; }

        .metrics-table { width: 100%; border-collapse: separate; border-spacing: 10px 0; margin: 0 -10px 20px -10px; }
        .metrics-table td { width: 33.33%; background: #f8f9fa; border: 1px solid #e9ecef; border-radius: 6px; padding: 15px; text-align: center; }
        
        .metric-label { font-size: 10px; color: #6c757d; text-transform: uppercase; margin-bottom: 4px; font-weight: bold; }
        .metric-value { font-size: 20px; font-weight: bold; }
        
        .text-success { color: #2b8a3e; }
        .text-danger { color: #e03131; }
        .text-info { color: #1971c2; }
        .text-muted { color: #868e96; }

        table.data-table { width: 100%; border-collapse: collapse; font-size: 10px; margin-bottom: 10px; }
        table.data-table th { background: #f1f3f5; padding: 8px; text-align: left; font-weight: bold; color: #495057; border-bottom: 1px solid #dee2e6; text-transform: uppercase; }
        table.data-table td { padding: 8px; border-bottom: 1px solid #dee2e6; color: #212529; }
        table.data-table tr:nth-child(even) td { background: #fdfdfd; }
        
        .font-weight-bold { font-weight: bold; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }

        .badge-status { font-size: 9px; font-weight: bold; text-transform: uppercase; }
        
        .footer { margin-top: 30px; padding-top: 10px; border-top: 1px solid #dee2e6; font-size: 9px; color: #adb5bd; text-align: center; width: 100%; position: fixed; bottom: 0; }
        
        .page-break { page-break-before: always; }
        
        .empty-state { text-align: center; padding: 15px; background: #f8f9fa; color: #adb5bd; font-style: italic; border: 1px dashed #dee2e6; }
        
        table.layout-table { width: 100%; border-collapse: collapse; }
        table.layout-table td { vertical-align: top; }
        .spacer-td { width: 4%; }
        .half-td { width: 48%; }
    </style>
</head>
<body>
    {{-- Header --}}
    <div class="header">
        <table style="width: 100%; border-collapse: collapse;">
            <tr>
                <td style="width: 60%; vertical-align: middle;">
                    <h1>{{ __('Relatório Mensal de Gestão') }}</h1>
                    <p>FinControl — {{ __('Controle Financeiro e Resultados') }}</p>
                </td>
                <td style="width: 40%; text-align: right; vertical-align: middle;">
                    <div class="header-badge">{{ $report->periodLabel() }}</div>
                    <p>{{ __('Emitido em') }} {{ now()->format('d/m/Y H:i') }}</p>
                </td>
            </tr>
        </table>
    </div>

    {{-- Resumo Executivo --}}
    <div class="section">
        <div class="section-title">{{ __('Resumo Executivo') }}</div>
        <p style="color: #495057; text-align: justify;">
            No período de <strong>{{ $report->periodLabel() }}</strong>, o faturamento total alcançou <strong class="text-success">{{ money($report->total_income) }}</strong>, 
            enquanto os custos e despesas somaram <strong class="text-danger">{{ money($report->total_expense) }}</strong>. 
            O resultado líquido (lucro ou prejuízo) do mês fechou em <strong class="{{ $report->net_result >= 0 ? 'text-info' : 'text-danger' }}">{{ money($report->net_result) }}</strong>.
        </p>
    </div>

    {{-- Métricas Principais --}}
    <table class="metrics-table">
        <tr>
            <td>
                <div class="metric-label">{{ __('Receitas Totais') }}</div>
                <div class="metric-value text-success">{{ money($report->total_income) }}</div>
            </td>
            <td>
                <div class="metric-label">{{ __('Despesas Totais') }}</div>
                <div class="metric-value text-danger">{{ money($report->total_expense) }}</div>
            </td>
            <td>
                <div class="metric-label">{{ __('Resultado Líquido') }}</div>
                <div class="metric-value {{ $report->net_result >= 0 ? 'text-info' : 'text-danger' }}">{{ money($report->net_result) }}</div>
            </td>
        </tr>
    </table>

    {{-- Resumos por Categoria (2 Colunas com Tabela HTML) --}}
    <table class="layout-table">
        <tr>
            <td class="half-td">
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
                        <div class="empty-state">{{ __('Nenhum dado de receita.') }}</div>
                    @endif
                </div>
            </td>
            <td class="spacer-td"></td>
            <td class="half-td">
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
                        <div class="empty-state">{{ __('Nenhum dado de despesa.') }}</div>
                    @endif
                </div>
            </td>
        </tr>
    </table>

    {{-- Novo detalhe: Top 5 Maiores Despesas --}}
    @php
        $expensesOnly = array_filter($data['transactions'] ?? [], fn($t) => $t['transaction_type'] === 'EXPENSE');
        usort($expensesOnly, fn($a, $b) => $b['amount'] <=> $a['amount']);
        $topExpenses = array_slice($expensesOnly, 0, 5);
    @endphp

    <table class="layout-table">
        <tr>
            <td class="half-td">
                <div class="section">
                    <div class="section-title">{{ __('Receitas por Cliente') }}</div>
                    @if(!empty($data['income_by_client']))
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>{{ __('Cliente') }}</th>
                                    <th class="text-center">{{ __('Qtd') }}</th>
                                    <th class="text-right">{{ __('Total') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data['income_by_client'] as $client)
                                    <tr>
                                        <td>{{ $client['client_name'] }}</td>
                                        <td class="text-center">{{ $client['count'] }}</td>
                                        <td class="text-right text-success font-weight-bold">{{ money($client['total']) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="empty-state">{{ __('Nenhum cliente gerou receita.') }}</div>
                    @endif
                </div>
            </td>
            <td class="spacer-td"></td>
            <td class="half-td">
                <div class="section">
                    <div class="section-title">{{ __('Top 5 Maiores Despesas') }}</div>
                    @if(!empty($topExpenses))
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>{{ __('Descrição') }}</th>
                                    <th>{{ __('Data') }}</th>
                                    <th class="text-right">{{ __('Valor') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($topExpenses as $exp)
                                    <tr>
                                        <td>{{ \Illuminate\Support\Str::limit($exp['description'], 15) }}</td>
                                        <td>{{ \Carbon\Carbon::parse($exp['due_date'])->format('d/m/y') }}</td>
                                        <td class="text-right text-danger font-weight-bold">{{ money($exp['amount']) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="empty-state">{{ __('Nenhuma despesa registrada.') }}</div>
                    @endif
                </div>
            </td>
        </tr>
    </table>

    {{-- Extrato Detalhado --}}
    <div class="page-break"></div>
    
    <div class="header">
        <table style="width: 100%; border-collapse: collapse;">
            <tr>
                <td style="width: 70%; vertical-align: middle;">
                    <h1>{{ __('Extrato Analítico') }}</h1>
                    <p>FinControl — {{ __('Todas as Movimentações do Período') }}</p>
                </td>
                <td style="width: 30%; text-align: right; vertical-align: middle;">
                    <div class="header-badge">{{ $report->periodLabel() }}</div>
                </td>
            </tr>
        </table>
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
                                    <span class="badge-status text-success">{{ __('Pago') }}</span>
                                @else
                                    <span class="badge-status text-danger">{{ __('Aberto') }}</span>
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
        FinControl — {{ __('Sistema de Gestão Financeira') }} · {{ __('Relatório gerado automaticamente') }} · {{ now()->format('d/m/Y H:i:s') }}
    </div>
</body>
</html>
