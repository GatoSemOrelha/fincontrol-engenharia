<div align="center">
  <img src="public/favicon.ico" alt="FinControl Logo" width="80" height="80">
  <h1 align="center">FinControl</h1>
  <p align="center">
    <strong>Sistema Premium de Gestão Financeira Pessoal & Empresarial</strong>
  </p>
  <p align="center">
    <img src="https://img.shields.io/badge/Laravel-11-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel 11" />
    <img src="https://img.shields.io/badge/PHP-8.3-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP 8.3" />
    <img src="https://img.shields.io/badge/MySQL-8.4-4479A1?style=for-the-badge&logo=mysql&logoColor=white" alt="MySQL 8.4" />
    <img src="https://img.shields.io/badge/Docker-Ready-2496ED?style=for-the-badge&logo=docker&logoColor=white" alt="Docker Ready" />
  </p>
</div>

<br />

O **FinControl** é uma plataforma moderna, veloz e robusta para gestão financeira. Desenvolvido com foco absoluto em **Experiência do Usuário (UX)** e perfomance de ponta a ponta.

---

## ✨ Features Premium

- ⚡ **Navegação Ultra-Rápida (Turbo 8):** Sensação de Single Page Application (SPA). Mudanças de tela sem recarregamento da página através da tecnologia Hotwire/Turbo nativa.
- 🎨 **Temas Dinâmicos & Micro-Animações:** Suporte completo aos modos Claro, Escuro e Amoled (para economia de bateria em telas OLED) via Central de Configurações.
- 🌍 **Internacionalização Multi-Moeda:** Configure seu perfil para exibir as métricas financeiras de acordo com seu país ou moeda global.
- 📊 **Dashboard & Relatórios Inteligentes:** Resumos executivos em tempo real e exportação de PDFs de alto padrão e imutáveis com traduções nativas automáticas via DomPDF.
- 💳 **Gestão de Cartões e Faturas:** Acompanhe o limite e o fechamento de múltiplas faturas de diferentes cartões em um só lugar.
- 📈 **Controle de Investimentos:** Categorize aportes e acompanhe ativos (Ações, Tesouro, CDB, FIIs).
- 🔄 **Despesas Recorrentes:** Automação inteligente que injeta na sua timeline os custos fixos sem esforço manual.

## 🚀 Como Executar Localmente

O ecossistema inteiro foi desenhado para rodar sobre **Docker**, garantindo zero dor de cabeça com instalações de dependências locais na sua máquina.

### Pré-requisitos
- [Docker](https://www.docker.com/products/docker-desktop/) e [Docker Compose](https://docs.docker.com/compose/) instalados na sua máquina.

### Passo a passo

1. **Clone o repositório:**
   ```bash
   git clone https://github.com/seu-usuario/fincontrol.git
   cd fincontrol
   ```

2. **Inicie o Container Docker:**
   O script cuidará de instalar o MySQL, Redis, Servidor Apache, PHP 8.3 e baixar as dependências do Composer automaticamente.
   ```bash
   docker compose up -d --build
   ```

3. **Crie o Banco de Dados e Alimente o Sistema:**
   Entre no container e rode as migrações e seeders (população inicial).
   ```bash
   docker compose exec app php artisan migrate:fresh --seed
   ```

4. **Acesse o Sistema:**
   - **App:** [http://localhost:8000](http://localhost:8000)
   - **Banco de Dados Visual (phpMyAdmin):** [http://localhost:8080](http://localhost:8080)
   - **Login Padrão:** `joao@empresa.com.br`
   - **Senha Padrão:** `admin123`

---

## 🛠️ Arquitetura e Decisões de Engenharia
- **Backend:** Laravel 11 (O framework PHP mais expressivo e elegante).
- **Frontend:** Blade Templating Engine + Vanilla CSS Custom Properties (CSS variables) garantindo carregamento instantâneo sem frameworks gigantes.
- **Cache & Sessões:** Redis em memória, garantindo alta disponibilidade.
- **Relatórios:** DOMPdf emparelhado com o motor Carbon Locale-Aware.
- **View Transitions:** Implementação da API View Transitions dos navegadores modernos para morfismo entre abas sem esforço javascript extra.

---

<div align="center">
  <i>Construído com obsessão por qualidade estética e técnica.</i>
</div>
