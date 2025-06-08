CREATE DATABASE IF NOT EXISTS cuponera;
USE cuponera;

CREATE TABLE administradores(
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);

CREATE TABLE empresas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    nombre_empresa VARCHAR(255),
    nit_empresa VARCHAR(255),
    direccion VARCHAR(255),
    telefono VARCHAR(8),
    correo_electronico VARCHAR(255),
    porcentaje FLOAT,
    aprobado BOOLEAN NOT NULL
);

CREATE TABLE clientes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    correo_electronico VARCHAR(255) NOT NULL,
    nombre_cliente VARCHAR(255) NOT NULL,
    apellido_cliente VARCHAR(255) NOT NULL,
    DUI VARCHAR(10) NOT NULL,
    fecha_nacimiento DATE NOT NULL
);

CREATE TABLE ofertas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(100) NOT NULL,
    precio_regular DECIMAL(10,2) NOT NULL,
    precio_oferta DECIMAL(10,2) NOT NULL,
    fecha_inicio DATE NOT NULL,
    fecha_fin DATE NOT NULL,
    fecha_canje DATE NOT NULL,
    cantidad INT,
    descripcion VARCHAR(255) NOT NULL,
    estado BOOLEAN NOT NULL,
    usuario VARCHAR(50) NOT NULL,
    FOREIGN KEY (usuario) REFERENCES empresas(username)
);

CREATE TABLE compras (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_oferta INT NOT NULL,
    monto DECIMAL(10,2) NOT NULL,
    fecha DATE NOT NULL,
    factura_path VARCHAR(255),
    usuario VARCHAR(50) NOT NULL,
    empresa VARCHAR(50) NOT NULL,
    FOREIGN KEY (id_oferta) REFERENCES ofertas(id),
    FOREIGN KEY (usuario) REFERENCES clientes(username),
    FOREIGN KEY (empresa) REFERENCES empresas(username)
);

-- Usuario de prueba
INSERT INTO administradores (username, password) VALUES ('admin', SHA1('admin123'));