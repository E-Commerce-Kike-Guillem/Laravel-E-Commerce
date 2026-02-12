# Projecte Laravel E-Commerce - Sprint 3

Aquest repositori conté la implementació del backend i el sistema d'administració per a la plataforma e-commerce, desenvolupat amb Laravel 11.

---

## C1 - Creació i Configuració de l'Entorn
* **Framework:** S'ha inicialitzat un projecte Laravel 11 a la carpeta `/laravel`.
* **MySQL:** L'aplicació utilitza una base de dades MySQL compartida. S'ha configurat el fitxer `.env` amb les credencials corresponents.
* **Docker/Sail:** S'ha utilitzat **Laravel Sail** com a stack de contenidors, facilitant un entorn homogeni amb PHP 8.3 i MySQL.

## C2 - Model de Dades i Migracions
* **Taula Products:** S'ha creat la migració amb els camps `sku` (índex únic), `name`, `description`, `price`, `stock`, `image` i `category`.
* **Taula Users:** S'ha estès la taula d'usuaris per defecte per incloure el camp `role` (amb valors 'user' o 'admin'), permetent el control d'accessos.
* **Seeders:** S'ha implementat un `ProductSeeder` per carregar dades inicials i verificar el llistat de l'API.

## C3 - Autenticació amb Laravel Breeze
* **Sistema:** S'ha instal·lat **Laravel Breeze** (versió Blade) per gestionar el registre i login d'usuaris.
* **Assets:** La compilació de CSS i JS es realitza mitjançant **Vite**.
* **Nota Comparativa:** A diferència de l'autenticació manual de l'Sprint 2 basada en gestió directa de cookies i sessions PHP pur, Breeze implementa un flux segur mitjançant **Eloquent** i **Middlewares**, centralitzant la protecció de rutes i el hashing de contrasenyes (Bcrypt) de forma nativa.

## C4 - Importació de Productes des d'Excel
* **Dependència:** S'utilitza la llibreria `maatwebsite/excel`.
* **Funcionalitat:** S'ha creat un controlador que processa la pujada de fitxers `.xlsx`. 
* **Lògica:** S'utilitza la classe `ProductsImport` que valida dades obligatòries i executa un `updateOrCreate` basat en l'SKU, permetent tant la creació com l'actualització massiva de stock i preus.
* **Feedback:** El sistema registra el nombre de files processades i gestiona errors de format de forma amigable.

## C5 - API REST de Productes
* **Rutes:** Disponibles a `routes/api.php` per a consulta pública.
* **Endpoints:** - `GET /api/products`: Retorna el llistat complet de productes (JSON). Admet paràmetres de cerca.
    - `GET /api/products/{id}`: Retorna el detall d'un producte específic.
* **Resources:** S'ha implementat `ProductResource` per normalitzar la sortida de dades (preus amb 2 decimals, rutes d'imatge absolutes, etc.).
* **Nota futur:** En l'Sprint 4, una aplicació SPA amb Vue.js consumirà aquests endpoints.

## C6 - CRUD d'Administració (Backoffice)
* **Accés Restringit:** S'ha creat un Middleware (`AdminMiddleware`) que verifica el camp `role` de l'usuari autenticat. L'accés a les rutes `/admin/*` està limitat exclusivament a administradors.
* **Funcionalitats:**
    - Llistat de productes importats.
    - Formulari de creació manual de productes.
    - Edició i actualització de dades existents (nom, preu, stock).
* **Vistes:** Implementades amb Blade i Tailwind CSS sense dependències de JS extern.

## C7 - Tests Automatitzats
S'ha validat la robustesa del sistema mitjançant tests de funcionalitat (Feature Tests).

### Resum d'Evidències:
| Prova | Objectiu | Resultat |
| :--- | :--- | :--- |
| **API List** | Validar que `/api/products` retorna JSON 200 i estructura correcta. | **PASS** ✅ |
| **API Detail** | Validar que es mostra el detall d'un producte pel seu ID. | **PASS** ✅ |
| **Guest Security** | Comprovar que els convidats són redirigits al login. | **PASS** ✅ |
| **Role Security** | Comprovar que un usuari 'user' rep un 403 en l'àrea admin. | **PASS** ✅ |
| **Admin Access** | Validar que l'admin (role='admin') pot gestionar productes. | **PASS** ✅ |
| **Excel Import** | Simular la pujada d'un fitxer i validar la seua càrrega. | **PASS** ✅ |

---

### Com executar el projecte
1. Entrar a la carpeta: `cd laravel`
2. Arrencar contenidors: `./vendor/bin/sail up -d`
3. Instal·lar dependències: `./vendor/bin/sail composer install && ./vendor/bin/sail npm install`
4. Preparar BBDD: `./vendor/bin/sail artisan migrate --seed`
5. Vincular fitxers: `./vendor/bin/sail artisan storage:link`
6. Executar tests: `./vendor/bin/sail artisan test`
