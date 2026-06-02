Documentació Frontend (Vue.js)
==============================

### Arquitectura Interna

Aplicació **SPA (Single Page Application)** desenvolupada amb Vue 3 i Vite. S'ha prioritzat el rendiment utilitzant la Composition API. La comunicació amb l'API es centralitza mitjançant Axios.

### Tecnologies Utilitzades

*   **Framework:** Vue.js 3.
    
*   **Gestió d'Estat:** Pinia (per al carret i dades d'usuari).
    
*   **Enrutament:** Vue Router.
    
*   **Estils:** CSS modular per components.
    

### Configuració i Execució

1.  **Instal·lació:** npm install.
    
2.  **Variables:** Crea un .env amb VITE\_API\_URL=https://api.projecte05.ddaw.es/api.
    
3.  **Inici:** npm run dev.
    

### Procés de Build i CI/CD

El workflow (frontend-deploy.yml) genera els fitxers optimitzats (npm run build). Aquests es serveixen mitjançant un servidor web lleuger (Nginx) al contenidor de producció.

### Validació i Operació

*   **Validació:** Els tests unitaris i de funcionalitat es poden executar amb npm test o mitjançant les accions de CI configurades.
    
*   **Manteniment:** Les versions noves es despleguen automàticament en fer push a la branca principal, gràcies a l'automatització del pipeline.
    

### Nota sobre l'operació (Infraestructura AWS)

Per reproduir el sistema en el núvol:

1.  Instància EC2 (Ubuntu).
    
2.  Desactivar serveis web natius (sudo systemctl stop apache2 && sudo systemctl disable apache2) per alliberar el port 80.
    
3.  Configurar secrets en GitHub Actions per a la connexió segura per SSH.