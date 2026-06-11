@extends('layouts.app')
@section('title', 'Fluxo de Caixa')

@section('content')
<div class="topbar">
    <span class="topbar-title">{{ __('Projeção de fluxo de caixa — ') }} {{ $months }} {{ __('meses') }}</span>
    <div class="topbar-actions">
        <form method="GET" action="{{ route('reports.cash-flow') }}" style="display:flex;gap:8px;align-items:center;background:var(--color-background-secondary);padding:4px;border-radius:12px">
            <button type="submit" name="months" value="1" class="btn" {!! $months == 1 ? 'style="font-size:11px;padding:4px 8px;border-radius:8px;background:var(--color-background-primary);color:var(--color-text-primary);border:1px solid var(--color-border)"' : 'style="font-size:11px;padding:4px 8px;border-radius:8px;background:transparent;border:none"' !!}>{{ __('Próximo mês') }}</button>
            <button type="submit" name="months" value="3" class="btn" {!! $months == 3 ? 'style="font-size:11px;padding:4px 8px;border-radius:8px;background:var(--color-background-primary);color:var(--color-text-primary);border:1px solid var(--color-border)"' : 'style="font-size:11px;padding:4px 8px;border-radius:8px;background:transparent;border:none"' !!}>{{ __('3 Meses') }}</button>
            <button type="submit" name="months" value="6" class="btn" {!! $months == 6 ? 'style="font-size:11px;padding:4px 8px;border-radius:8px;background:var(--color-background-primary);color:var(--color-text-primary);border:1px solid var(--color-border)"' : 'style="font-size:11px;padding:4px 8px;border-radius:8px;background:transparent;border:none"' !!}>{{ __('6 Meses') }}</button>
            <button type="submit" name="months" value="12" class="btn" {!! $months == 12 ? 'style="font-size:11px;padding:4px 8px;border-radius:8px;background:var(--color-background-primary);color:var(--color-text-primary);border:1px solid var(--color-border)"' : 'style="font-size:11px;padding:4px 8px;border-radius:8px;background:transparent;border:none"' !!}>{{ __('1 Ano') }}</button>
        </form>
    </div>
</div>

<div class="content">
    <div class="metrics-row" style="margin-bottom:20px">
        <div class="metric-card">
            <div class="metric-label">{{ __('Saldo atual (contas)') }}</div>
            <div class="metric-value" style="color:var(--color-text-success)">
                {{ money($projection['current_balance']) }}
            </div>
        </div>
        <div class="metric-card">
            <div class="metric-label">{{ __('Total em CDB') }}</div>
            <div class="metric-value" style="color:var(--color-text-info)">
                {{ money($projection['cdb_total']) }}
            </div>
        </div>
    </div>

    <div class="card">
        <div class="section-title">{{ __('Projeção mensal') }}</div>
        <div class="table-wrap" style="border:none">
            <table>
                <thead>
                    <tr>
                        <th>{{ __('Mês') }}</th>
                        <th>{{ __('Receita projetada') }}</th>
                        <th>{{ __('Despesa projetada') }}</th>
                        <th>{{ __('Resultado') }}</th>
                        <th>{{ __('Rendimento CDB') }}</th>
                        <th>{{ __('Saldo projetado') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($projection['months'] as $m)
                        <tr>
                            <td style="font-weight:500">{{ $m['label'] }}</td>
                            <td style="color:var(--color-text-success)">{{ money($m['projected_income']) }}</td>
                            <td style="color:var(--color-text-danger)">{{ money($m['projected_expense']) }}</td>
                            <td @style(['color: var(--color-text-success)' => $m['net'] >= 0, 'color: var(--color-text-danger)' => $m['net'] < 0])>
                                {{ money($m['net']) }}
                            </td>
                            <td style="color:var(--color-text-info)">{{ money($m['cdb_yield']) }}</td>
                            <td @style(['font-weight: 500', 'color: var(--color-text-success)' => $m['total_with_investments'] >= 0, 'color: var(--color-text-danger)' => $m['total_with_investments'] < 0])>
                                {{ money($m['total_with_investments']) }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
