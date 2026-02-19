# 🛒 Proyecto E-Commerce (Laravel)

![Vista previa de la aplicación](./preview.png)

## 📄 Descripción

### ¿Qué es E-Commerce Laravel?

Es una plataforma de comercio electrónico desarrollada íntegramente con el framework Laravel. Este proyecto gestiona:

* Catálogo completo de productos
* Gestión de usuarios (registro, login, perfiles)
* Administración de productos
* Importación de datos desde un sistema legacy en PHP plano

### ¿Por qué lo usamos/desarrollamos?

Este proyecto se desarrolla para establecer una **arquitectura robusta, escalable y mantenible** utilizando metodologías ágiles.

La finalidad principal es disponer de una tienda online completa que ponga en práctica:

* Patrón MVC
* Protección de rutas mediante middleware (ej. panel de administrador)
* Uso de bases de datos relacionales con migraciones y seeders
* Despliegue estructurado utilizando contenedores Docker

También sirve como demostración práctica del módulo **Despliegue de Aplicaciones Web (DAW)**.

---

## 📚 Tabla de Contenidos

* Tecnologías utilizadas
* Puesta en marcha
* Entornos
* Guía de Contribución
* Documentación de desarrollo
* Lista de Contribuidores
* Inspiración
* Licencia

---

## 🧰 Tecnologías utilizadas

### Backend

* PHP 8.x
* Laravel 11.x

### Frontend

* Blade
* TailwindCSS
* Vite
* JavaScript

### Base de datos

* MySQL / SQLite
* Gestionado con migraciones de Laravel

### Testing

* Pest
* PHPUnit

### Infraestructura y despliegue

* Docker
* Docker Compose (incluye entorno de desarrollo con `compose.yaml`)

### Control de versiones

* Git
* GitHub

---

## 🚀 Puesta en marcha

Para ejecutar este proyecto en tu entorno local:

### ✅ Requisitos previos

* PHP >= 8.2
* Composer
* Node.js y npm
* Docker (opcional pero recomendado)

---

### 📥 Instalación

#### 1. Clona el repositorio

```bash
git clone https://github.com/tu-usuario/laravel-e-commerce.git
cd laravel-e-commerce/laravel
```

#### 2. Instala dependencias

```bash
composer install
npm install
```

#### 3. Configura variables de entorno

```bash
cp .env.example .env
php artisan key:generate
```

#### 4. Levanta base de datos y servicios (Docker)

```bash
docker-compose up -d
```

#### 5. Ejecuta migraciones y seeders

```bash
php artisan migrate --seed
```

#### 6. Compila assets e inicia servidor

```bash
npm run dev
php artisan serve
```

---

## 🌍 Entornos

### Desarrollo

Entorno local en la máquina de cada desarrollador:

```
http://localhost:8000
```

### Producción

Añadir URL de la plataforma desplegada, por ejemplo:

```
https://ecommerce-ejemplo.com
```

---

## 🤝 Guía de Contribución

Para contribuir al proyecto:

1. Lee la documentación del flujo de trabajo antes de subir código
2. Abre un **Issue** describiendo el bug o mejora
3. Crea una rama desde main:

```bash
git checkout -b feature/nombre-de-la-mejora
```

4. Haz commits lógicos, atómicos y descriptivos
5. Sube tus cambios y abre un Pull Request
6. El código debe pasar los tests:

```bash
php artisan test
```

---

## 📖 Documentación de desarrollo

Toda la documentación relacionada con:

* Gantt
* Sprints
* Riesgos Laborales

se encuentra en la carpeta:

```
/Documentació
```

También disponible en la **Wiki del proyecto**.

---

## 👥 Lista de Contribuidores

*(Añadir aquí los colaboradores del proyecto)*

---

## 💡 Inspiración

*(Añadir referencias o proyectos similares si procede)*

---

## 📜 Licencia

Este proyecto se distribuye bajo los términos de la **Licencia MIT** incluida en el repositorio.
