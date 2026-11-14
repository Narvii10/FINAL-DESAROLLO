# API REST de Vehículos — Laravel 12 + MySQL

API sin autenticación para registrar vehículos. Todas las respuestas son JSON.

| Campo        | Tipo                        | Obligatorio |
|--------------|-----------------------------|-------------|
| `id`         | entero autoincremental      | automático  |
| `marca`      | texto (máx. 50)             | sí          |
| `modelo`     | texto (máx. 50)             | sí          |
| `anio`       | entero entre 1886 y el año siguiente al actual | sí |
| `color`      | texto (máx. 30)             | sí          |
| `created_at` | fecha de creación           | automático  |
| `updated_at` | fecha de actualización      | automático  |

## Endpoints

| Método | URL                                    | Acción             | Código esperado |
|--------|----------------------------------------|--------------------|-----------------|
| GET    | `http://127.0.0.1:8000/api/vehiculos`      | Listar             | 200 |
| POST   | `http://127.0.0.1:8000/api/vehiculos`      | Crear              | 201 (o 422 si hay datos inválidos) |
| GET    | `http://127.0.0.1:8000/api/vehiculos/{id}` | Consultar por id   | 200 (o 404) |
| PUT    | `http://127.0.0.1:8000/api/vehiculos/{id}` | Actualizar         | 200 (o 422 / 404) |
| DELETE | `http://127.0.0.1:8000/api/vehiculos/{id}` | Eliminar           | 200 (o 404) |

---

## 1. Requisitos

- **PHP 8.2 o superior** y **MySQL**: XAMPP o Laragon traen ambos.
- **Postman**

El proyecto **ya trae todo lo necesario**: las dependencias de Laravel (carpeta `vendor`) y el archivo de
configuración `.env`, con la clave generada y la conexión a MySQL. **No necesita Composer.**

## 2. Cómo ejecutarlo (3 pasos)

1. **Encienda MySQL** (en XAMPP: botón *Start* de MySQL).

2. **Abra una terminal dentro de la carpeta `api-vehiculos`** y cree las tablas:
   ```bash
   php artisan migrate
   ```
   Si pregunta *"The database 'api_vehiculos' does not exist... Would you like to create it?"*, elija **Yes**.
   Laravel crea la base de datos y la tabla `vehiculos`. También puede crear la base de datos antes, en
   phpMyAdmin, con el script `crear_base_de_datos.sql`.

3. **Encienda el servidor** y deje esa terminal abierta mientras hace las pruebas:
   ```bash
   php artisan serve
   ```
   La API queda en **http://127.0.0.1:8000/api/vehiculos**. Para apagarla, presione `Ctrl + C`.

> **En Windows con XAMPP**, si aparece *"'php' no se reconoce como un comando"*, use la ruta completa:
> `C:\xampp\php\php.exe artisan migrate` y `C:\xampp\php\php.exe artisan serve`.
>
> **¿Su MySQL tiene contraseña?** Ábrala en el archivo `.env` (con el Bloc de notas o VS Code) y escríbala en
> `DB_PASSWORD=`. Por defecto, XAMPP y Laragon usan el usuario `root` sin contraseña.

## 2B. Opción sin XAMPP: GitHub Codespaces (todo en el navegador)

Su PC solo necesita un navegador. Codespaces es gratis para cuentas personales de GitHub
(aproximadamente 60 horas al mes en la máquina básica).

1. Entre a **https://github.com/codespaces** (cree una cuenta gratis si no tiene).
2. En *Explore quick start templates*, busque **Blank** y haga clic en **Use this template**.
   En 1 o 2 minutos se abre VS Code en el navegador.
3. **Arrastre `api-vehiculos.zip`** desde su PC al panel izquierdo (Explorer) de ese VS Code.
4. En la terminal de abajo, pegue este comando y presione Enter:
   ```bash
   unzip -q api-vehiculos.zip && cd api-vehiculos && bash iniciar.sh
   ```
   Espere el mensaje **"API lista en: http://127.0.0.1:8000/api/vehiculos"**. La primera vez tarda
   2 o 3 minutos, porque descarga MySQL y PHP.
5. Haga las pruebas con **Thunder Client** (ícono de rayo en la barra izquierda). Si no aparece:
   *Extensions* → busque "Thunder Client" → *Install*.
6. Al terminar, detenga el codespace para no gastar horas: en **https://github.com/codespaces** abra el
   menú **⋯** del codespace y elija **Stop codespace**.

Si vuelve otro día, abra el mismo codespace y ejecute otra vez `cd api-vehiculos && bash iniciar.sh`.

## 3. Pruebas (las 6 capturas)

**Con Thunder Client (Codespaces):** puede crear las 6 solicitudes a mano con la tabla de abajo (*New Request*,
elija el método, escriba la URL y, en *Body → JSON*, pegue el cuerpo). También puede importar la colección:
*Collections* → menú **≡** → *Import* → `postman/API_Vehiculos.postman_collection.json`.

**Con Postman (instalado en su PC):**

1. En Postman: **Import**, y luego elija `postman/API_Vehiculos.postman_collection.json`.
2. Abra la colección **API Vehículos - Laravel** y ejecute las solicitudes **en orden**, de la 1 a la 6.
3. En cada captura deben verse la **URL**, el **Body** enviado (pruebas 1, 4 y 5), la **respuesta JSON** y el
   **código de estado** (esquina superior derecha de la respuesta, por ejemplo `201 Created`).

| # | Solicitud                     | Body enviado | Código esperado |
|---|-------------------------------|--------------|-----------------|
| 1 | POST `/api/vehiculos`         | `{"marca": "Toyota", "modelo": "Corolla", "anio": 2022, "color": "Blanco"}` | **201 Created** |
| 2 | GET `/api/vehiculos`          | —            | **200 OK** |
| 3 | GET `/api/vehiculos/1`        | —            | **200 OK** |
| 4 | PUT `/api/vehiculos/1`        | `{"marca": "Toyota", "modelo": "Corolla Cross", "anio": 2024, "color": "Gris"}` | **200 OK** |
| 5 | POST `/api/vehiculos` (inválido) | `{"marca": "", "modelo": "Hilux", "anio": 1500}` | **422 Unprocessable Content** |
| 6 | DELETE `/api/vehiculos/1`     | —            | **200 OK** |

> **Importante:** si la prueba 1 devuelve un `id` distinto de 1 (por ejemplo, porque ya había creado
> registros antes), cambie el `1` al final de la URL en las pruebas 3, 4 y 6 por ese id.
>
> **Sugerencia:** antes de la prueba 2 puede crear un segundo vehículo con la prueba 1 cambiando el body,
> para que la lista muestre más de un registro.

### Respuesta esperada de la prueba 5 (validación)

```json
{
  "mensaje": "Los datos enviados no son válidos.",
  "errores": {
    "marca": ["El campo marca es obligatorio."],
    "anio": ["El año debe estar entre 1886 y 2027."],
    "color": ["El campo color es obligatorio."]
  }
}
```

## 4. Archivos del proyecto que contienen la API

| Archivo | Qué hace |
|---------|----------|
| `database/migrations/2026_11_14_000000_create_vehiculos_table.php` | Crea la tabla `vehiculos` en MySQL |
| `app/Models/Vehiculo.php` | Modelo Eloquent (campos asignables, formato de fechas) |
| `app/Http/Requests/VehiculoRequest.php` | Validación de campos obligatorios y mensajes en español |
| `app/Http/Controllers/VehiculoController.php` | Métodos listar, crear, consultar, actualizar y eliminar |
| `routes/api.php` | Rutas `/api/vehiculos` |
| `bootstrap/app.php` | Registra las rutas API y devuelve los errores 404 en JSON |

## 5. Problemas comunes

| Error | Solución |
|-------|----------|
| `'php' no se reconoce como un comando` | Use `C:\xampp\php\php.exe artisan ...` en lugar de `php artisan ...`. |
| `could not find driver` | En `C:\xampp\php\php.ini` quite el `;` de `extension=pdo_mysql`, guarde y abra una terminal nueva. |
| `No connection could be made` / `Connection refused` | MySQL está apagado: enciéndalo en XAMPP. |
| `Access denied for user 'root'` | Su MySQL tiene contraseña: póngala en `DB_PASSWORD` del `.env`. |
| `Unknown database 'api_vehiculos'` | Ejecute `php artisan migrate` y responda **Yes**, o use `crear_base_de_datos.sql`. |
| `Composer detected issues in your platform` | Necesita PHP 8.2 o superior (`php -v` muestra su versión). |
| Borró la carpeta `vendor` | Instale Composer y ejecute `composer install` en la carpeta del proyecto. |
| El puerto 8000 está ocupado | `php artisan serve --port=8001` y cambie `8000` por `8001` en las URLs. |
| Cambió el `.env` y no se nota | `php artisan config:clear` y reinicie `php artisan serve`. |
