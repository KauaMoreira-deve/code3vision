# Pingo Decor — ambiente local

O site Laravel é servido pelo Docker em **http://localhost:8001**. A porta 8000 já é usada por outro projeto neste ambiente.

Na primeira execução:

```bash
cp src/.env.example src/.env
docker compose up -d
docker compose exec app php artisan key:generate
docker compose exec app php artisan migrate
```

Nas próximas execuções, basta `docker compose up -d`. O MySQL fica disponível para a aplicação em `mysql:3306` dentro da rede do Docker, sem expor uma porta no computador.

Se seu usuário local não usa UID/GID 1000, defina `APP_UID` e `APP_GID` ao iniciar o Compose para permitir que o PHP grave em `storage` e `bootstrap/cache`.

A rota `/` usa a view `site.home.home`. As imagens, folhas de estilo, scripts e páginas HTML ficam em `src/public/pingoDecor` e são acessíveis em `/pingoDecor/`.
