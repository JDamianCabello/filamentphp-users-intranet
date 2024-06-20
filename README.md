# Proyecto de Intranet Empresarial con Laravel y FilamentPHP

## Descripción

Este proyecto es una intranet empresarial desarrollada utilizando Laravel y FilamentPHP. La intranet permite gestionar usuarios, roles, permisos y proporciona una plataforma segura para la comunicación y colaboración dentro de la empresa.

## Requisitos Previos

- PHP >= 8.2
- Composer
- MySQL
- Node.js & NPM/Yarn

## Instalación

1. **Clonar el Repositorio**

    ```bash
    git clone https://github.com/JDamianCabello/filamentphp-users-intranet.git
    cd filamentphp-users-intranet
    ```

2. **Instalar Dependencias**

    ```bash
    composer install
    npm install
    npm run dev
    ```

3. **Configuración del Entorno**

    Copia el archivo `.env.example` a `.env` y actualiza las variables de entorno necesarias, como la configuración de la base de datos.

    ```bash
    cp .env.example .env
    php artisan key:generate
    ```

4. **Migrar Base de Datos**

    ```bash
    php artisan migrate --seed
    ```

5. **Iniciar el Servidor de Desarrollo**

    ```bash
    php artisan serve
    ```

## Uso

1. **Acceder a la Intranet**

    Abre tu navegador y ve a `http://localhost:8000`.

2. **Acceso al Panel de Administración**

    FilamentPHP proporciona un panel de administración integrado. Puedes acceder al panel administrativo en `http://localhost:8000/admin`.

3. **Usuarios y Roles**

    Desde el panel de administración, puedes gestionar usuarios, roles y permisos para controlar el acceso a diferentes partes de la intranet.

## Características

- **Gestión de Usuarios:** Registro, edición, y eliminación de usuarios.
- **Roles y Permisos:** Control granular de acceso mediante roles y permisos.
- **Panel Administrativo:** Interfaz intuitiva proporcionada por FilamentPHP para la administración del sistema.
- **Seguridad:** Autenticación y autorización para proteger los datos de la empresa.
- **Comunicación Interna:** Herramientas para facilitar la colaboración y comunicación entre empleados.

## Estructura del Proyecto

- **app/**: Contiene el código fuente de la aplicación.
- **config/**: Archivos de configuración.
- **database/**: Migraciones, fábricas y seeders para la base de datos.
- **public/**: Archivos públicos como imágenes, scripts y estilos.
- **resources/**: Vistas, componentes y assets.
- **routes/**: Definición de rutas de la aplicación.
- **storage/**: Logs, caché y otros archivos generados.
- **tests/**: Pruebas automáticas.

## Dependencias

### Requeridas

- `php`: ^8.2
- `laravel/framework`: ^11.9
- `laravel/tinker`: ^2.9

### Desarrollo

- `fakerphp/faker`: ^1.23
- `laravel/pint`: ^1.13
- `laravel/sail`: ^1.26
- `mockery/mockery`: ^1.6
- `nunomaduro/collision`: ^8.0
- `phpunit/phpunit`: ^11.0.1

## Contribuir

1. Haz un fork del repositorio.
2. Crea una rama para tu característica o arreglo (`git checkout -b feature/nueva-caracteristica`).
3. Realiza tus cambios y haz commit (`git commit -am 'Agrega nueva característica'`).
4. Sube la rama (`git push origin feature/nueva-caracteristica`).
5. Abre un Pull Request.

## Licencia

Este proyecto está bajo la licencia MIT. Consulta el archivo [LICENSE](LICENSE) para más detalles.
