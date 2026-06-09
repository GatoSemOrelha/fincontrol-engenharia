@extends('layouts.app')
@section('title', __('Configurações'))

@section('content')
<div class="topbar">
    <span class="topbar-title">{{ __('Central de Configurações') }}</span>
</div>

<div class="content">
    @if(session('success'))
        <div class="alert alert-success" style="background:var(--color-background-success);color:var(--color-text-success);padding:12px;border-radius:var(--border-radius-md);margin-bottom:20px;display:flex;align-items:center;gap:8px">
            <i class="ti ti-check"></i> {{ session('success') }}
        </div>
    @endif

    <div class="grid-2">
        {{-- Card: Aparência (Tema) --}}
        <div class="card">
            <h3 style="display:flex;align-items:center;gap:8px;margin-bottom:16px;color:var(--color-text-primary)">
                <i class="ti ti-palette" style="color:var(--color-text-info)"></i> {{ __('Aparência do Sistema') }}
            </h3>
            <p style="color:var(--color-text-secondary);font-size:13px;margin-bottom:16px;">
                {{ __('Escolha o tema que mais te agrada. O modo Amoled ajuda a economizar bateria em telas OLED.') }}
            </p>
            
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">
                <button type="button" onclick="setTheme('light')" class="btn" style="justify-content:center"><i class="ti ti-sun"></i> {{ __('Claro') }}</button>
                <button type="button" onclick="setTheme('dark')" class="btn" style="justify-content:center"><i class="ti ti-moon"></i> {{ __('Escuro') }}</button>
                <button type="button" onclick="setTheme('amoled')" class="btn" style="justify-content:center"><i class="ti ti-device-mobile"></i> {{ __('Amoled') }}</button>
                <button type="button" onclick="setTheme('system')" class="btn" style="justify-content:center"><i class="ti ti-device-desktop"></i> {{ __('Sistema') }}</button>
            </div>
        </div>

        {{-- Card: Moeda --}}
        <div class="card">
            <h3 style="display:flex;align-items:center;gap:8px;margin-bottom:16px;color:var(--color-text-primary)">
                <i class="ti ti-cash" style="color:var(--color-text-success)"></i> {{ __('Moeda Padrão') }}
            </h3>
            <p style="color:var(--color-text-secondary);font-size:13px;margin-bottom:16px;">
                {{ __('Isso alterará os símbolos de moeda em todos os relatórios, cartões e faturas do sistema.') }}
            </p>
            
            <form method="POST" action="{{ route('settings.currency') }}">
                @csrf
                <div class="form-group">
                    <select name="currency" class="form-select" style="width:100%;padding:10px;border-radius:var(--border-radius-md);border:1px solid var(--color-border-primary);background:var(--color-background-primary);color:var(--color-text-primary);margin-bottom:12px;">
                        <option value="BRL" {{ auth()->user()->currency == 'BRL' ? 'selected' : '' }}>Real Brasileiro (R$)</option>
                        <option value="USD" {{ auth()->user()->currency == 'USD' ? 'selected' : '' }}>Dólar Americano ($)</option>
                        <option value="EUR" {{ auth()->user()->currency == 'EUR' ? 'selected' : '' }}>Euro (€)</option>
                        <option value="GBP" {{ auth()->user()->currency == 'GBP' ? 'selected' : '' }}>Libra Esterlina (£)</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center">{{ __('Atualizar Moeda') }}</button>
            </form>
        </div>

        {{-- Card: Idioma --}}
        <div class="card">
            <h3 style="display:flex;align-items:center;gap:8px;margin-bottom:16px;color:var(--color-text-primary)">
                <i class="ti ti-language" style="color:var(--color-text-warning)"></i> {{ __('Idioma') }}
            </h3>
            <p style="color:var(--color-text-secondary);font-size:13px;margin-bottom:16px;">
                {{ __('Selecione o idioma de interface do sistema.') }}
            </p>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">
                <a href="{{ route('lang.switch', 'pt_BR') }}" class="btn {{ app()->getLocale() == 'pt_BR' ? 'btn-primary' : '' }}" style="justify-content:center;text-decoration:none;">Português (BR)</a>
                <a href="{{ route('lang.switch', 'en') }}" class="btn {{ app()->getLocale() == 'en' ? 'btn-primary' : '' }}" style="justify-content:center;text-decoration:none;">English (US)</a>
            </div>
        </div>

        {{-- Card: Preferências de Notificação (Placeholder) --}}
        <div class="card" style="opacity: 0.7;">
            <h3 style="display:flex;align-items:center;gap:8px;margin-bottom:16px;color:var(--color-text-primary)">
                <i class="ti ti-bell" style="color:var(--color-text-info)"></i> {{ __('Notificações (Em breve)') }}
            </h3>
            <p style="color:var(--color-text-secondary);font-size:13px;margin-bottom:16px;">
                {{ __('Alertas de vencimento de faturas, fechamento de cartão e limites atingidos diretamente no seu e-mail ou Telegram.') }}
            </p>
            <div style="display:flex;align-items:center;gap:8px;margin-bottom:12px;">
                <input type="checkbox" disabled checked> <span style="color:var(--color-text-secondary);font-size:14px;">{{ __('Alertas na plataforma') }}</span>
            </div>
            <div style="display:flex;align-items:center;gap:8px;">
                <input type="checkbox" disabled> <span style="color:var(--color-text-secondary);font-size:14px;">{{ __('Alertas por E-mail') }}</span>
            </div>
        </div>
    </div>
</div>
@endsection
