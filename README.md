# Bogø Portalen

En webportal for Bogø med nyheder, begivenheder, foreninger og administrativ styring.

## Systemkrav
- PHP 8.1 eller nyere
- MariaDB (eller MySQL 8.0+)
- Webserver (Apache med `mod_rewrite` eller Nginx)
- PHP-udvidelser: `pdo_mysql`, `mbstring`, `session`

## Opsætning af Database (MariaDB)

1. Log ind på din MariaDB/MySQL server:
   ```bash
   mariadb -u root -p
   ```

2. Opret databasen og en dedikeret bruger:
   ```sql
   CREATE DATABASE bogoe_portalen CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
   CREATE USER 'bogoe'@'localhost' IDENTIFIED BY 'dit_stærke_kodeord';
   GRANT ALL PRIVILEGES ON bogoe_portalen.* TO 'bogoe'@'localhost';
   FLUSH PRIVILEGES;
   EXIT;
   ```

3. Importer tabellerne fra `database/schema.sql`:
   ```bash
   mariadb -u bogoe -p bogoe_portalen < database/schema.sql
   ```

## Konfiguration

Opdater database-forbindelsen i `src/config/database.php`:

```php
define('DB_HOST', '127.0.0.1');
define('DB_NAME', 'bogoe_portalen');
define('DB_USER', 'bogoe');
define('DB_PASS', 'dit_stærke_kodeord'); // Erstat med dit valgte kodeord
```

## Vigtigt: Routing

**Applikationen vil KUN fungere, hvis den køres gennem `public/router.php`.** 
Dette gælder både under udvikling (lokal server) og ved opsætning på en produktionsserver. Router-scriptet er fundamentalt for at systemet kan håndtere anmodninger korrekt.

## Udvikling (Lokal server)

Brug PHP's indbyggede webserver sammen med router-scriptet:

1. Åbn en terminal i projektets rodmappe.
2. Kør følgende kommando:
   ```bash
   php -S localhost:8000 -t public public/router.php
   ```
3. Besøg `http://localhost:8000` i din browser.

## Opsætning på Server (Production)

Det er afgørende, at din webserver er konfigureret til at bruge `public/router.php` som det primære indgangspunkt for alle anmodninger.

### Nginx (Anbefalet)
Konfigurer din server-blok til altid at sende forespørgsler til `router.php`, medmindre der er tale om en eksisterende fil:

```nginx
location / {
    try_files $uri $uri/ /router.php?$args;
}

location ~ \.php$ {
    include snippets/fastcgi-php.conf;
    fastcgi_pass unix:/var/run/php/php8.1-fpm.sock; # Tilpas PHP-version
}
```

### Apache
Selvom `.htaccess` som standard peger på `index.php`, anbefales det for dette projekt at sikre, at router-scriptets logik altid overholdes. Hvis du oplever problemer med standard `.htaccess`, bør du sikre at forespørgsler dirigeres gennem `router.php`.

### Mapperettigheder
Sørg for at webserveren (f.eks. `www-data`) har skriverettigheder til eventuelle upload-mapper, hvis de tilføjes (f.eks. `public/assets/uploads`).

## Administration
- Gå til `/admin` for at logge ind.
- For at oprette den første administrator-bruger, kan du besøge `/admin/setup.php`.

> [!CAUTION]
> **VIGTIGT: Fjern `public/admin` mappen efter brug!**
> Når du har oprettet din første administrator via `setup.php`, skal du **SLETTE** mappen `public/admin/` fuldstændigt.
>
> Hvis mappen ikke fjernes, vil serveren (især Apache og PHP's indbyggede server) tro, at `/admin/dashboard` er en fysisk mappe under `public/admin/`. Dette medfører:
> 1. At login og admin-sider **IKKE VIRKER**.
> 2. At CSS og andre filer **IKKE KAN FINDES**, da stierne bliver forkerte.
