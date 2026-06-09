#!/bin/bash
# ============================================================
# FinControl — Docker Entrypoint
# Executa configurações automáticas ao iniciar o container
# ============================================================

set -e

echo "============================================"
echo "  FinControl — Iniciando ambiente virtual"
echo "============================================"

# 0. Criar .env se não existir
if [ ! -f ".env" ] && [ -f ".env.example" ]; then
    echo "[0/6] Criando arquivo .env..."
    cp .env.example .env
fi

# 1. Gerar APP_KEY se não existir
if [ -z "$APP_KEY" ] || [ "$APP_KEY" = "" ]; then
    echo "[1/6] Gerando APP_KEY..."
    php artisan key:generate --force --no-interaction
else
    echo "[1/6] APP_KEY já configurada."
fi

# 2. Aguardar MySQL ficar disponível
echo "[2/6] Aguardando MySQL..."
max_tries=30
count=0
until php artisan db:monitor --databases=mysql > /dev/null 2>&1 || [ $count -ge $max_tries ]; do
    sleep 2
    count=$((count + 1))
    echo "  Tentativa $count/$max_tries..."
done

if [ $count -ge $max_tries ]; then
    echo "  Tentando conexão direta..."
fi

# 3. Executar migrations
echo "[3/6] Executando migrations..."
php artisan migrate --force --no-interaction 2>/dev/null || {
    echo "  Aguardando mais 5s para MySQL estabilizar..."
    sleep 5
    php artisan migrate --force --no-interaction
}

# 4. Executar seeders (apenas se tabela roles estiver vazia)
ROLE_COUNT=$(php artisan tinker --execute="echo App\Models\Role::count();" 2>/dev/null || echo "0")
if [ "$ROLE_COUNT" = "0" ] || [ -z "$ROLE_COUNT" ]; then
    echo "[4/6] Populando banco com dados iniciais..."
    php artisan db:seed --force --no-interaction
else
    echo "[4/6] Banco já possui dados, pulando seed."
fi

# 5. Link de storage
echo "[5/6] Criando link de storage..."
php artisan storage:link --force --no-interaction 2>/dev/null || true

# 6. Otimizar cache
echo "[6/6] Otimizando aplicação..."
php artisan config:clear --no-interaction 2>/dev/null || true
php artisan view:clear --no-interaction 2>/dev/null || true

echo ""
echo "============================================"
echo "  FinControl pronto!"
echo ""
echo "  App:        http://localhost:8000"
echo "  phpMyAdmin: http://localhost:8080"
echo ""
echo "  Login Admin:"
echo "    Email: joao@empresa.com.br"
echo "    Senha: admin123"
echo "============================================"
echo ""

# Executar o comando principal (Apache)
exec "$@"
