Proyecto E-Commerce (Laravel)
(Insertar aquí imagen de la vista previa de la aplicación)

Descripción
¿Qué es E-Commerce Laravel?
Es una plataforma de comercio electrónico desarrollada íntegramente con el framework Laravel. Este proyecto gestiona un catálogo completo de productos, la gestión de usuarios (registro, login, perfiles), administración de productos e importación de datos desde un sistema legacy en PHP plano.

¿Por qué lo usamos/desarrollamos?
Este proyecto se desarrolla para establecer una arquitectura robusta, escalable y mantenible utilizando metodologías ágiles. La finalidad principal es disponer de una tienda en línea completa que ponga en práctica el patrón MVC, protección de rutas mediante middleware (como el panel de administrador), uso de bases de datos relacionales con migraciones/seeders y un despliegue estructurado utilizando contenedores (Docker). Sirve a su vez como demostración práctica del módulo de Despliegue de Aplicaciones Web (DAW).

Tabla de Contenidos


Tecnologías utilizadas

Puesta en marcha
Entornos
Guía de Contribución
Documentación de desarrollo
Lista de Contribuidores
Inspiración
Licencia

Tecnologías utilizadas
Descripción de las tecnologías utilizadas para la construcción del proyecto:

Backend: PHP 8.x, Laravel 11.x
Frontend: Blade, TailwindCSS, Vite, JavaScript
Base de datos: MySQL / SQLite (gestionado con migraciones de Laravel)
Testing: Pest / PHPUnit

Infraestructura y Despliegue: Docker, Docker Compose (incluye el entorno de desarrollo con compose.yaml)
Control de versiones: Git y GitHub

Puesta en Marcha
Para ejecutar este proyecto en tu entorno de desarrollo local, sigue los siguientes comandos y requisitos:

Requisitos previos:

PHP >= 8.2

Composer

Node.js y npm

Docker (opcional, pero recomendado para levantar el entorno completo)

Pasos de instalación:

Clona el repositorio:

git clone https://github.com/tu-usuario/laravel-e-commerce.git
cd laravel-e-commerce/laravel
Instala las dependencias de backend y frontend:

composer install
npm install
Configura las variables de entorno:

cp .env.example .env
php artisan key:generate
Levanta el entorno de la base de datos (y la app si usas Laravel Sail/Docker):

docker-compose up -d
Ejecuta las migraciones y rellena la base de datos con información de prueba:

php artisan migrate --seed
Compila los assets del frontend e inicia el servidor local:

npm run dev
php artisan serve

Entornos
Desarrollo: Entorno local en la máquina de cada desarrollador ejecutándose en http://localhost:8000

Producción: (Añadir URL de la plataforma desplegada, ej: https://ecommerce-ejemplo.com)

Guía de Contribución
Cualquier contribución al proyecto deberá seguir las siguientes normas de contribución:

Asegúrate de leer la documentación del flujo de trabajo acordado antes de subir código.

Abre un Issue describiendo el bug o la nueva característica.

Crea una rama específica para tu tarea a partir de la rama principal (git checkout -b feature/nombre-de-la-mejora).

Haz commits lógicos, atómicos y descriptivos.

Sube tus cambios a tu fork o repositorio y abre un Pull Request.

El código debe pasar correctamente los tests automatizados (php artisan test) antes de ser aceptado.

Documentación de desarrollo
Toda la documentación relacionada con la planificación (Gantt, Sprints, Riesgos Laborales) se encuentra almacenada en la carpeta de /Documentació del propio repositorio.

Enlace a la Wiki del proyecto

Licencia
Este proyecto se desarrolla y distribuye de acuerdo a los términos de la Licencia MIT incluida.
