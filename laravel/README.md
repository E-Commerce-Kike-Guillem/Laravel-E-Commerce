Documentació Backend (Laravel)
==============================

### Arquitectura Interna

L'aplicació utilitza el patró **MVC (Model-Vista-Controlador)**. L'API és completament RESTful, garantint una comunicació clara amb el frontend. L'autenticació es gestiona mitjançant Laravel Sanctum (per a tokens d'API) i Laravel Socialite (per al login amb Google).

### Tecnologies Utilitzades

*   **Framework:** Laravel 11.x (PHP 8.3).
    
*   **Base de dades:** MySQL (gestionat externament a AWS RDS).
    
*   **Autenticació:** Laravel Sanctum i Google OAuth2.
    
*   **Contenidors:** Docker (configuració optimitzada per a producció amb Nginx i PHP-FPM).
    

### Configuració i Execució

1.  **Configuració:** Copia el fitxer de variables: cp .env.example .env.
    
2.  **Entorn:** Assegura't d'establir DB\_HOST, DB\_DATABASE, DB\_USERNAME, DB\_PASSWORD i les claus d'OAuth (GOOGLE\_CLIENT\_ID, GOOGLE\_CLIENT\_SECRET) al .env.
    
3.  **Desenvolupament:** Executa docker compose up -d per aixecar els serveis.
    
4.  **Instal·lació:** docker exec laravel\_app\_container composer install.
    

### Procés de Build i CI/CD

El workflow de GitHub Actions (backend-deploy.yml) realitza:

*   Build de la imatge Docker.
    
*   Publicació en el registre d'imatges.
    
*   SSH a l'instància AWS EC2 per actualitzar el contenidor amb docker compose pull && docker compose up -d.
    

### Escalabilitat i Disponibilitat

*   **Escalabilitat:** Base de dades a RDS per separar la càrrega.
    
*   **Disponibilitat:** Política de reinici restart: always en els contenidors per garantir el servei continu.