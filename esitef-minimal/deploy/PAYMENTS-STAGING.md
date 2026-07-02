# Pasarelas de pago en staging (modo TEST)

Ejecutar **inmediatamente después** de clonar producción a staging.

## PayPal

1. [developer.paypal.com](https://developer.paypal.com) → Sandbox accounts
2. WooCommerce → Pagos → PayPal → **Sandbox ON**
3. Client ID y Secret de la app Sandbox (no live)

## Stripe

1. Dashboard Stripe → Modo prueba
2. Claves `pk_test_...` y `sk_test_...` en WooCommerce → Stripe

## WooCommerce — Pago de prueba

Activar **Pago de prueba (test)** para smoke test sin pasarela externa.

## Verificación

- [ ] Panel PayPal Sandbox muestra transacciones test
- [ ] Ningún cargo en cuenta live
- [ ] Ver `QA-CHECKLIST.md` sección Pagos

## Producción

**No ejecutar este doc en producción.** En cutover las credenciales live ya están en prod; solo cambia el tema.
