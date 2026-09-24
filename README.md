# FilamentPHP Boilerplate
 
 A modern Laravel starter kit with FilamentPHP 5, designed to accelerate development with a pre-configured admin panel, authentication, roles & permissions, and a curated set of plugins ready to use out of the box.
 
  ## 📋 Requirements
 
 - PHP >= 8.4
 - Composer >= 2.x
 - Node.js >= 18.x
 - pnpm >= 9
 - MySQL >= 8.0 / PostgreSQL >= 13 / SQLite
 
 ---
 
 ## 🧰 Stack
 
 | Technology | Version |
 |---|---|
 | PHP | ^8.4 |
 | Laravel | ^12.0 |
 | FilamentPHP | ^5.0 |
 | Livewire | ^4.0 |
 | Alpine.js | Bundled with Livewire |
 | Tailwind CSS | ^4.1 |
 
 ---
 
 ## 📦 Packages Included
 
 | Package | Description |
 |---|---|
 | `filament/filament` | Admin panel core |
 | `bezhansalleh/filament-shield` | Role & permission management for Filament |
 | `jeffgreco13/filament-breezy` | Authentication, profile & 2FA for Filament |
 | `laravel/fortify` | Backend authentication scaffolding |
 | `livewire/livewire` | Full-stack component framework |
 | `livewire/flux` | Official Livewire UI component library |
 | `livewire/blaze` | Livewire performance utilities |
 | `openplain/filament-shadcn-theme` | Shadcn-inspired theme for Filament |
 | `pxlrbt/filament-environment-indicator` | Visual environment indicator in the panel |
 | `swisnl/filament-backgrounds` | Customizable backgrounds for auth screens |
 | `achyutn/filament-log-viewer` | Log viewer integrated in the admin panel |
 | `laravel-lang/common` | Translations for common Laravel packages |
 | `pestphp/pest` | Testing framework |
 | `larastan/larastan` | Static analysis for Laravel (PHPStan) |
 | `rector/rector` | Automated code refactoring |
 
 ---
 
 ## 🚀 Installation
 
 ### 1. Clone the repository
 ```bash
 git clone https://github.com/jairmmz/filamentphp-boilerplate.git
 cd filamentphp-boirlerplate
 ```
 
 ### 2. Install PHP dependencies
 ```bash
 composer install
 ```
 
 ### 3. Install Node dependencies
 ```bash
 pnpm install
 ```
 
 ### 4. Environment setup
 ```bash
 cp .env.example .env
 php artisan key:generate
 ```
 
 ### 5. Configure your database
 
 Edit the `.env` file and set your database credentials:
 ```env
 DB_CONNECTION=mysql
 DB_HOST=127.0.0.1
 DB_PORT=3306
 DB_DATABASE=your_database
 DB_USERNAME=your_username
 DB_PASSWORD=your_password
 ```
 
 ### 6. Run migrations
 ```bash
 php artisan migrate
 ```
 
 ### 7. Run seeders
 ```bash
 php artisan db:seed
 ```
 
 ### 8. Storage link
 ```bash
 php artisan storage:link
 ```
 
 ### 9. Compile assets
 ```bash
 pnpm run build
 ```
 
 > For development with hot reload:
 > ```bash
 > pnpm run dev
 > ```
 
 ---
 
 ## 🐳 Development with Laravel Sail
 
 This project is configured to run with [Laravel Sail](https://laravel.com/docs/sail) (Docker). All commands can be run through Sail or directly with `vendor/bin/`.
 
 ### Start Sail
 ```bash
 ./vendor/bin/sail up -d
 ```
 
 All the commands below can be prefixed with `./vendor/bin/sail` (e.g. `./vendor/bin/sail artisan test`) or run directly via the `vendor/bin/` binaries when PHP is available locally.
 
 ---
 
 ## 👤 Default Credentials
 
 After running the seeders, you can log in with:
 
 | Field | Value |
 |---|---|
 | Email | `admin@example.com` |
 | Password | `123456789` |
 
 > ⚠️ Change these credentials immediately in a production environment.
 
---
 
## 🧪 Testing & Code Quality
 
### Run tests (Pest)
```bash
# Via Sail
./vendor/bin/sail composer test
./vendor/bin/sail artisan test
# Via vendor binaries
./vendor/bin/pest
./vendor/bin/phpunit
```
> `composer test` runs: `config:clear` → Pint check → PHPStan → Pest tests. The single command `composer ci:check` runs the same pipeline (used by the CI).
> Note: tests need the `testing` database — created automatically by Sail's MySQL container.
 
### Run code style (Pint)
```bash
# Fix code style
./vendor/bin/sail bin pint
./vendor/bin/pint
# Check only (no modifications)
./vendor/bin/sail bin pint --test
./vendor/bin/pint --test
```
> Composer aliases: `composer lint` (fix) and `composer lint:check` (check only).
 
### Static analysis (PHPStan with Larastan)
```bash
./vendor/bin/sail bin phpstan analyse --memory-limit=1G
./vendor/bin/phpstan analyse --memory-limit=1G
```
> Composer alias: `composer analyse`. Configuration lives in `phpstan.neon` (level 8).
 
### Refactoring (Rector)
```bash
# Dry run (shows changes without applying)
./vendor/bin/sail bin rector process --dry-run
./vendor/bin/rector process --dry-run
# Apply changes
./vendor/bin/sail bin rector process
./vendor/bin/rector process
```
> Configuration lives in `rector.php`.
 
### Full check (Pint + PHPStan + tests)
```bash
./vendor/bin/sail composer ci:check
./vendor/bin/composer ci:check
```
 
---

## ✅ Checklist antes de subir cambios (push / PR)

Los pipelines de GitHub Actions (`tests.yml` y `lint.yml`) corren **Pint**, **PHPStan** y **Pest** en PHP 8.4 y 8.5. Si no ejecutas estos comandos antes de hacer push, el CI dará error con alta probabilidad (formato fuera de estilo, tipos, o tests fallando). Ejecútalos siempre localmente antes de subir:

```bash
# 1. Formatear código (arregla el estilo automáticamente)
./vendor/bin/sail bin pint

# 2. Verificar estilo de nuevo (debe quedar en "passed")
./vendor/bin/sail bin pint --test

# 3. Análisis estático (PHPStan nivel 8 + Larastan)
./vendor/bin/sail bin phpstan analyse --memory-limit=1G

# 4. Refactorización (revisa y aplica mejoras de código)
./vendor/bin/sail bin rector process --dry-run   # primero ver qué cambiará
./vendor/bin/sail bin rector process             # luego aplicarlo

# 5. Tests (Pest) — usa artisan test o la suite completa
./vendor/bin/sail artisan test
# — o todo de una vez (Pint check + PHPStan + tests):
./vendor/bin/sail composer ci:check
./vendor/bin/sail composer test

# 6. (Opcional) regenerar helper de IDE tras cambiar modelos
./vendor/bin/sail artisan ide-helper:models
```

> 💡 Los comandos de arriba usan **Sail**. Si tienes PHP local, reemplaza `./vendor/bin/sail` por el binario de `vendor/bin/` (ej: `./vendor/bin/pint`, `./vendor/bin/phpstan`, `./vendor/bin/pest`).
>
> ⚠️ El CI corre los mismos checks, así que si cualquiera de estos falla, **no subas** hasta que esté en verde.

### Gotchas frecuentes que rompen el CI

| Situación | Qué hacer |
|---|---|
| Cambiaste dependencias PHP | Commitear el `composer.lock` actualizado (`./vendor/bin/sail composer update` → después subir ambos). |
| Cambiaste dependencias JS | Commitear el `pnpm-lock.yaml` actualizado. |
| Añadiste una variable de entorno | Añadirla también a `.env.example`, porque el CI copia ese archivo. |
| Añadiste/editaste tablas | Crear la migración y correr `./vendor/bin/sail artisan migrate` antes de los tests. |
| No subas `vendor/` ni `node_modules` | Están en `.gitignore`; si aparecen en `git status`, algo está mal. |
| Pint/`rector` modificaron archivos | Commiteá esos cambios junto con tu feature, o el CI fallará por formato. |

---

## 📝 Conventional Commits

Usa el formato [Conventional Commits](https://www.conventionalcommits.org/) para los mensajes de commit:

```
<tipo>(<alcance>): <descripción>
```

Tipos más usados:

| Tipo | Uso |
|---|---|
| `feat` | Nueva funcionalidad |
| `fix` | Corrección de un bug |
| `refactor` | Cambio de código sin cambiar comportamiento |
| `docs` | Cambios en documentación |
| `style` | Formato, pint, espacios — sin cambio de lógica |
| `test` | Agregar o corregir tests |
| `perf` | Mejoras de rendimiento |
| `ci` | Cambios en pipelines/actions (`.github/workflows`) |
| `chore` | Tareas de mantenimiento, dependencias |

Ejemplos:
```bash
git commit -m "feat: add user export PDF"
git commit -m "fix(auth): handle invalid 2FA code"
git commit -m "refactor(users): extract UserService"
git commit -m "ci: bump actions to node24 runtime"
git commit -m "test: cover password reset flow"
git commit -m "chore(deps): bump filament to v5.2"
```

> 💡 Si el commit corrige un bug pendiente, añade `Closes #<issue>` en el cuerpo:
> ```bash
> git commit -m "fix(auth): handle invalid 2FA code" -m "Closes #12"
> ```

---

## 🧠 Laravel IDE Helper
 
Generate IDE helper files for better autocompletion support:
```bash
./vendor/bin/sail artisan ide-helper:generate
./vendor/bin/sail artisan ide-helper:models
./vendor/bin/sail artisan ide-helper:meta
# Or directly
php artisan ide-helper:generate
php artisan ide-helper:models
php artisan ide-helper:meta
```
---
   
 ## 🌐 Localization
 
 This boilerplate includes `laravel-lang/common` for multi-language support. To publish and install a language:
 ```bash
 php artisan lang:add es
 ```
 
 Set your application locale in `.env`:
 ```env
 APP_LOCALE=es
 ```
 
 ---
 
 ## 🖥️ Running the Application
 ```bash
 php artisan serve
 ```
 
 Access the admin panel at: [http://localhost:8000/admin](http://localhost:8000/admin)
 
 ---
 
 ## ⚙️ Useful Commands
 ```bash
 php artisan optimize:clear         # Clear all cached files
 php artisan filament:upgrade       # Upgrade Filament assets
 php artisan shield:generate --all  # Regenerate all permissions
 ```
 
 ---
   
 ## 🛡️ Shield — Roles & Permissions
 
 After seeding, generate the Shield policies and register permissions:
 ```bash
 php artisan shield:generate --all
 ```