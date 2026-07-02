# ESITEF Minimal — Tema WordPress

Tema unificado para esitef.com/online (WooCommerce + Tutor LMS).

## Instalación

1. Subir carpeta a `wp-content/themes/esitef-minimal/`
2. Activar en **Apariencia → Temas** (crea páginas Ingresar, Mentorías, La Escuela)
3. Asignar menú **Primary** y página estática **Inicio**

## Deploy staging / producción

Ver [`deploy/STAGING-SETUP.md`](deploy/STAGING-SETUP.md), [`deploy/QA-CHECKLIST.md`](deploy/QA-CHECKLIST.md), [`deploy/CUTOVER.md`](deploy/CUTOVER.md).

```bash
cp deploy/.env.deploy.example deploy/.env.deploy
./deploy/upload-theme.sh
```

## Templates

| Template | Archivo |
|----------|---------|
| Home | `front-page.php` |
| Login | `page-templates/page-login.php` |
| Mentorías | `page-templates/page-mentorias.php` |
| La Escuela | `page-templates/page-la-escuela.php` |
| Cursos | `tutor/archive-course.php` |
