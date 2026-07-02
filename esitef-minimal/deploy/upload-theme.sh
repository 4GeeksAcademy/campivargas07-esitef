#!/usr/bin/env bash
# Sube esitef-minimal al servidor staging vía rsync/scp
set -euo pipefail
ROOT="$(cd "$(dirname "$0")/.." && pwd)"
ENV_FILE="$(dirname "$0")/.env.deploy"

if [[ ! -f "$ENV_FILE" ]]; then
  echo "Crea $ENV_FILE desde .env.deploy.example"
  exit 1
fi
# shellcheck disable=SC1090
source "$ENV_FILE"

if [[ -z "${SFTP_HOST:-}" || -z "${REMOTE_THEME_PATH:-}" ]]; then
  echo "SFTP_HOST y REMOTE_THEME_PATH requeridos en .env.deploy"
  exit 1
fi

echo "Subiendo tema a ${SFTP_USER}@${SFTP_HOST}:${REMOTE_THEME_PATH}"
rsync -avz --delete \
  -e "ssh -p ${SFTP_PORT:-22}" \
  --exclude 'deploy/.env.deploy' \
  --exclude '.git' \
  "$ROOT/" "${SFTP_USER}@${SFTP_HOST}:${REMOTE_THEME_PATH}/"

echo "Listo. Activa el tema en ${WP_ADMIN_URL:-staging}"
