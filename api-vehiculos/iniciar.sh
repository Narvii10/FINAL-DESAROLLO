#!/usr/bin/env bash
# Inicia MySQL y la API de Laravel con Docker (GitHub Codespaces o cualquier PC con Docker).
cd "$(dirname "$0")" || exit 1

echo ""
echo "==> Iniciando MySQL y la API (la primera vez tarda 2 o 3 minutos)..."
docker compose up -d --build || { echo "No se pudo iniciar Docker."; exit 1; }

echo "==> Instalando Thunder Client (si ya está instalado, no pasa nada)..."
code --install-extension rangav.vscode-thunder-client >/dev/null 2>&1 || true

echo "==> Esperando a que la API responda..."
for i in $(seq 1 120); do
  if curl -s -o /dev/null --max-time 2 http://127.0.0.1:8000/api/vehiculos; then
    echo ""
    echo "======================================================"
    echo "  API lista en: http://127.0.0.1:8000/api/vehiculos"
    echo "  Ya puede hacer las pruebas en Thunder Client."
    echo "======================================================"
    exit 0
  fi
  sleep 2
done

echo "La API tardó demasiado en responder. Revise los mensajes con:"
echo "  docker compose logs app"
exit 1
