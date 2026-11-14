-- Ejecute este script en phpMyAdmin, MySQL Workbench o la consola de MySQL
-- ANTES de correr "php artisan migrate". La tabla "vehiculos" la crea la migración.

CREATE DATABASE IF NOT EXISTS api_vehiculos
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;
