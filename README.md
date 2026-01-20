SA.3 Iteració: Migració a Laravel v2

En aquesta Iteració anem a migrar part del nostre projecte a l'entorn laravel.

Comparativa d'Autenticació: PHP Natiu (v1) vs Laravel Breeze (v2)

Gestió de l'Estat:
v1 (Manual): Es feia servir session_start() i es manipulava directament la superglobal $_SESSION. Calia comprovar manualment a l'inici de cada fitxer si la sessió existia.

v2 (Breeze): Laravel gestiona la sessió automàticament via Middleware. Les rutes protegides s'agrupen sota el middleware auth, que redirigeix al login si l'usuari no està autenticat, sense necessitat de repetir codi als controladors.

Seguretat:
v1: Ús manual de password_hash() i password_verify(). Risc d'oblidar proteccions com CSRF als formularis.

v2: Ús del sistema Auth i models Eloquent. Les contrasenyes es hashegen automàticament (Bcrypt). Inclou protecció CSRF (@csrf) automàtica en tots els formularis i protecció contra atacs de força bruta (Rate Limiting) al login.

Arquitectura:
v1: Codi barrejat (HTML + lògica PHP) en el mateix fitxer de login.

v2: Separació MVC. Tenim AuthenticatedSessionController per a la lògica, Vistes Blade per al disseny, i Rutes definides a auth.php.
