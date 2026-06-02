# Proyecto E-Commerce (Laravel + Vue 3)

## Descripción

### ¿Qué es E-Commerce Laravel + Vue?

Es una plataforma de comercio electrónico moderna con una arquitectura desacoplada. Cuenta con una API REST desarrollada en **Laravel** para el backend y una interfaz de usuario dinámica (SPA) construida con **Vue.js 3** en el frontend.

Este proyecto gestiona:

* Catálogo completo de productos.
* Carrito de la compra interactivo y pasarela de pago (Checkout) simulada.
* Historial de pedidos inmutable mediante transacciones de base de datos.
* Gestión de usuarios (registro, login, perfiles) protegida mediante **Laravel Sanctum**.
* Administración e importación de datos desde un sistema legacy en PHP plano.

La finalidad principal es disponer de una tienda online completa que ponga en práctica:

* Patrón MVC en el backend y reactividad en el frontend.
* Autenticación basada en cookies/tokens (SPA Auth).
* Uso de bases de datos relacionales con migraciones y seeders.
* Despliegue estructurado utilizando contenedores Docker (Laravel Sail).
* Gestión de estado global en el cliente (Pinia) y validaciones asíncronas (Yup).

También sirve como demostración práctica del módulo **Despliegue de Aplicaciones Web (DAW)**.

---

## Tabla de Contenidos

* [Tecnologías utilizadas](#tecnologías-utilizadas)
* [Puesta en marcha](#puesta-en-marcha)
* [Entornos](#entornos)
* [Guía de Contribución](#guía-de-contribución)
* [Documentación de desarrollo](#documentación-de-desarrollo)

---

## Tecnologías utilizadas

### Backend (API REST)

* PHP 8.2
* Laravel 12
* Laravel Sanctum (Autenticación SPA)

### Frontend (SPA)

* Vue.js 3 (Composition API)
* Pinia (Gestión del estado global)
* Vue Router (Enrutamiento del lado del cliente)
* Yup (Validación de formularios)
* Vite (Bundler)
* Tailwind CSS
* CSS personalizado

### Base de datos

* MySQL
* Gestionado mediante migraciones de Laravel

### Infraestructura y despliegue

* Docker
* Docker Compose
* Laravel Sail

### Control de versiones

* Git
* GitHub

---

## Puesta en marcha

### Requisitos previos

Antes de comenzar, asegúrate de tener instalado:

* Docker Desktop (o Docker Engine + Docker Compose).
* Composer (opcional si utilizas contenedores para la instalación).
* Node.js y npm.

---

### Instalación

#### 1. Clonar el repositorio

```bash
git clone https://github.com/tu-usuario/laravel-e-commerce.git
cd laravel-e-commerce/laravel
```

#### 2. Instalar dependencias del backend

```bash
composer install
```

#### 3. Configurar variables de entorno

```bash
cp .env.example .env
```

Asegúrate de configurar correctamente:

* Credenciales de la base de datos.
* `SANCTUM_STATEFUL_DOMAINS`.
* URLs del frontend y backend.

#### 4. Levantar los contenedores con Laravel Sail

```bash
./vendor/bin/sail up -d
```

#### 5. Generar clave de aplicación y cargar la base de datos

```bash
./vendor/bin/sail artisan key:generate
./vendor/bin/sail artisan migrate:fresh --seed
```

#### 6. Instalar dependencias del frontend y ejecutar Vite

```bash
npm install
npm run dev
```

La API estará disponible en:

```text
http://localhost/api
```

El frontend se ejecutará normalmente en:

```text
http://localhost:5174
```

---

## Entornos

### Desarrollo

Entorno local para cada desarrollador utilizando Docker y Laravel Sail.

---

## Guía de Contribución

Para contribuir al proyecto:

1. Lee la documentación del flujo de trabajo.
2. Abre un Issue describiendo el error o mejora.
3. Crea una nueva rama desde `main`:

```bash
git checkout -b feature/nombre-de-la-mejora
```

4. Realiza commits lógicos, atómicos y descriptivos.
5. Sube tus cambios y abre un Pull Request.
6. Verifica que todos los tests pasan correctamente:

```bash
./vendor/bin/sail artisan test
```

---

## Documentación de desarrollo

Toda la documentación relacionada con:

* Gantt
* Sprints
* Riesgos Laborales
* Diagramas y análisis

se encuentra en la carpeta:

```text
/Documentació
```
