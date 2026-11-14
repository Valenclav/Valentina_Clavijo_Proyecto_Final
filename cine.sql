CREATE DATABASE IF NOT EXISTS cinecentro CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE cinecentro;

CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL,
    apellido VARCHAR(50) NOT NULL,
    dni VARCHAR(10) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
   rol ENUM('usuario', 'admin') NOT NULL DEFAULT 'usuario',
    fecha_creacion DATETIME DEFAULT CURRENT_TIMESTAMP,
    fecha_archivado DATETIME NULL DEFAULT NULL
);
