¡Perfecto! Vamos a hacer un **README profesional y completo** para tu proyecto Laravel de gestión de salas (`UNAEVENT`), listo para GitHub.

---

# `README.md`

````markdown
# UNAEVENT - Sistema de Gestión de Salas

UNAEVENT es un proyecto desarrollado en **Laravel** que permite gestionar salas dentro de una institución. El sistema incluye funcionalidades CRUD (Crear, Leer, Actualizar, Eliminar) para salas y está preparado para extenderse a otras entidades como eventos, usuarios y empleados.

## Tecnologías

- PHP 8.x
- Laravel 12.x
- MySQL / SQLite (según configuración)
- Bootstrap 5 para el frontend
- Git para control de versiones

## Características

- Gestión de salas:
  - Crear, editar y eliminar salas.
  - Registrar la capacidad y estado de habilitación.
- Estructura MVC clara con Eloquent.
- Validaciones integradas en formularios.
- Plantillas Blade reutilizables para formularios y listados.
- Historial de cambios y control de versiones con Git.

## Instalación

1. Clonar el repositorio:

```bash
git clone https://github.com/baezsoft/UNAEVENT.git
cd UNAEVENT
````

2. Instalar dependencias:

```bash
composer install
npm install
npm run dev
```

3. Configurar el entorno:

```bash
cp .env.example .env
```

Editar `.env` con tus datos de base de datos:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=unaevent
DB_USERNAME=root
DB_PASSWORD=
```

4. Ejecutar migraciones:

```bash
php artisan migrate
```

5. (Opcional) Llenar con datos de prueba:

```bash
php artisan db:seed
```

6. Ejecutar el servidor local:

```bash
php artisan serve
```

---

## Uso

* Accede al sistema en `http://127.0.0.1:8000/salas`.
* Crea nuevas salas desde el botón "Crear Sala".
* Edita y elimina salas desde la tabla de listado.
* Los formularios incluyen validación y control de errores.

---
