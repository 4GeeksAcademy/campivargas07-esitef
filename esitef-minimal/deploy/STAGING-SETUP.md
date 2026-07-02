# Staging ESITEF — Fase 0

## 1. Clonar `/online/`

**Opción A — Plugin Duplicator / WP Staging** (recomendado en panel WP)

**Opción B — SSH**

```bash
# En servidor: copiar archivos
cp -a public_html/online public_html/staging

# Exportar/importar BD y actualizar URLs:
wp search-replace 'https://esitef.com/online' 'https://staging.esitef.com' --all-tables
wp option update siteurl 'https://staging.esitef.com'
wp option update home 'https://staging.esitef.com'
```

## 2. DNS

Crear `staging.esitef.com` → carpeta del clon.

## 3. Basic auth

```bash
htpasswd -c .htpasswd usuario_staging
# Copiar staging-basic-auth.htaccess.example → .htaccess raíz staging
```

## 4. Pasarelas en TEST (obligatorio antes de probar pagos)

WooCommerce → Ajustes → Pagos:

- PayPal: **Sandbox mode** + credenciales developer.paypal.com
- Stripe: claves `pk_test_` / `sk_test_`
- Activar **Pago de prueba** de WooCommerce para smoke test rápido

Desactivar SMTP de producción o usar Email Log.

## 5. Subir tema

```bash
cp deploy/.env.deploy.example deploy/.env.deploy
# Editar credenciales
chmod +x deploy/upload-theme.sh
./deploy/upload-theme.sh
```

## 6. Activar en WP Admin

1. Apariencia → Temas → **ESITEF Minimal**
2. Ajustes → Lectura → Página estática → Home
3. Crear páginas: Ingresar (template Login), Mentorías, La Escuela
4. Asignar menú principal

Ver `QA-CHECKLIST.md` antes del cutover.
