# Cutover producción — Fase 5

1. **Backup** archivos + BD producción
2. `./deploy/upload-theme.sh` apuntando a producción `REMOTE_THEME_PATH`
3. Apariencia → Temas → ESITEF Minimal
4. Replicar páginas/menús desde staging
5. Smoke test: home, login, carrito
6. 301 raíz en `.htaccess` de `esitef.com`:

```apache
Redirect 301 / https://esitef.com/online/
```

7. Mantener tema anterior 48h para rollback (reactivar en Apariencia)

**Rollback:** reactivar tema anterior — no tocar BD si no hubo cambios de contenido.
