# Deploy a staging (SiteGround)

## 1. Obtener credenciales SSH

1. [Site Tools](https://my.siteground.com) → tu sitio → **Devs → SSH Keys Manager**
2. Genera un par de claves (o usa existente)
3. **Kebab menu → SSH Credentials** → anota:
   - **Hostname** → `SFTP_HOST`
   - **Username** → `SFTP_USER`
4. **Kebab menu → Private Key** → guarda en tu Mac, ej. `~/.ssh/siteground_esitef`
   ```bash
   chmod 600 ~/.ssh/siteground_esitef
   ```
   SiteGround **no acepta password** en SSH/SFTP — solo clave privada.

## 2. Ruta del tema en staging

**Site Tools → Site → File Manager** → navega a:

```
staging3.esitef.com → public_html → online → wp-content → themes → esitef-minimal
```

Copia la ruta absoluta (barra superior del File Manager) → `REMOTE_THEME_PATH`

## 3. Configurar `.env.deploy`

```bash
cp esitef-minimal/deploy/.env.deploy.example esitef-minimal/deploy/.env.deploy
# Edita con tus valores reales
```

## 4. Sincronizar (cada vez que cambies código)

```bash
chmod +x esitef-minimal/deploy/upload-theme.sh
./esitef-minimal/deploy/upload-theme.sh
```

O en Cursor: pide al agente **"deploy staging"**.

## 5. Caché

Site Tools → **Speed → Caching → Flush Cache** tras cada deploy.

## MCP vs SFTP

| Tarea | Herramienta |
|-------|-------------|
| Subir PHP/CSS/JS | Este script (SFTP) |
| Menús, páginas WP | MCP WordPress |
