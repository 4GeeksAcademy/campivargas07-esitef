#!/usr/bin/env bash
# WordPress local con tema esitef-minimal (Docker)
set -euo pipefail

ROOT="$(cd "$(dirname "$0")" && pwd)"
cd "$ROOT"

WP_PLUGINS=(woocommerce tutor elementor)

wp() {
  docker compose run --rm wpcli wp "$@"
}

wait_for_wp() {
  local i
  for i in $(seq 1 30); do
    if curl -sf -o /dev/null "http://localhost:8080/"; then
      return 0
    fi
    sleep 2
  done
  echo "❌ WordPress no responde en :8080. Ejecuta: ./local-wp.sh up"
  exit 1
}

cmd="${1:-up}"

case "$cmd" in
  up)
    docker compose up -d
    echo ""
    echo "→ WordPress: http://localhost:8080"
    echo "  Setup completo: ./local-wp.sh setup"
    echo "  Solo plugins:   ./local-wp.sh plugins"
    echo "  Logs:           ./local-wp.sh logs"
    ;;
  down)
    docker compose down
    ;;
  logs)
    docker compose logs -f wordpress
    ;;
  reset)
    docker compose down -v
    echo "✅ Volúmenes borrados. Ejecuta ./local-wp.sh setup"
    ;;
  lint)
    find esitef-minimal -name '*.php' -print0 | xargs -0 -n1 php -l
    ;;
  plugins)
    wait_for_wp
    if ! wp core is-installed 2>/dev/null; then
      echo "❌ WP no instalado. Ejecuta primero: ./local-wp.sh setup"
      exit 1
    fi
    echo "→ Instalando plugins (wp.org)…"
    for slug in "${WP_PLUGINS[@]}"; do
      wp plugin is-installed "$slug" 2>/dev/null && wp plugin activate "$slug" 2>/dev/null && continue
      wp plugin install "$slug" --activate
    done
    for zip in "$ROOT"/local-plugins/*.zip; do
      [[ -f "$zip" ]] || continue
      echo "→ Instalando $(basename "$zip")…"
      wp plugin install "/local-plugins/$(basename "$zip")" --activate
    done
    wp plugin list
    echo "✅ Plugins listos."
    ;;
  setup)
    docker compose up -d
    wait_for_wp
    if ! wp core is-installed 2>/dev/null; then
      echo "→ Instalando WordPress…"
      wp core install \
        --url="http://localhost:8080" \
        --title="ESITEF Local" \
        --admin_user="admin" \
        --admin_password="admin" \
        --admin_email="dev@esitef.local" \
        --skip-email
    fi
    echo "→ Plugins…"
    for slug in "${WP_PLUGINS[@]}"; do
      wp plugin is-installed "$slug" 2>/dev/null && wp plugin activate "$slug" 2>/dev/null && continue
      wp plugin install "$slug" --activate
    done
    for zip in "$ROOT"/local-plugins/*.zip; do
      [[ -f "$zip" ]] || continue
      echo "→ Instalando $(basename "$zip")…"
      wp plugin install "/local-plugins/$(basename "$zip")" --activate
    done
    echo "→ Tema + permalinks…"
    wp theme activate esitef-minimal
    wp rewrite structure '/%postname%/' --hard
    echo ""
    echo "✅ Listo: http://localhost:8080"
    echo "   Admin: http://localhost:8080/wp-admin  (admin / admin)"
    echo "   Tutor Pro: pon el .zip en local-plugins/ y ./local-wp.sh plugins"
    ;;
  *)
    echo "Uso: $0 {up|down|logs|reset|lint|plugins|setup}"
    exit 1
    ;;
esac
