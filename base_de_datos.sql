CREATE DATABASE db_base;
USE db_base;

CREATE TABLE Productos (
    idProducto INT PRIMARY KEY AUTO_INCREMENT,
    nombreProducto VARCHAR(40) NOT NULL,
    precio DECIMAL(7,2) NOT NULL,
    descripcion VARCHAR(255) NOT NULL,
    cantidad INT NOT NULL
);

CREATE TABLE Usuarios(
    usuario VARCHAR(12) PRIMARY KEY NOT NULL,
    contrasena VARCHAR(255) NOT NULL,
    fechaNacimiento DATE NOT NULL,
    rol VARCHAR(10) DEFAULT 'cliente'
);

CREATE TABLE Cestas(
    idCesta INT PRIMARY KEY AUTO_INCREMENT,
    usuario VARCHAR(12) NOT NULL,
    precioTotal DECIMAL(7,2) NOT NULL,
    FOREIGN KEY (usuario) REFERENCES Usuarios(usuario)
);

CREATE TABLE ProductosCestas(
    idProducto INT NOT NULL,
    idCesta INT NOT NULL,
    cantidad INT NOT NULL,
    PRIMARY KEY (idProducto, idCesta),
    FOREIGN KEY (idProducto) REFERENCES Productos(idProducto),
    FOREIGN KEY (idCesta) REFERENCES Cestas(idCesta)
);

CREATE TABLE Pedidos(
    idPedido INT PRIMARY KEY AUTO_INCREMENT,
    usuario VARCHAR(12) NOT NULL,
    precioTotal DECIMAL(7,2) NOT NULL,
    fechaPedido DATE NOT NULL,
    FOREIGN KEY (usuario) REFERENCES Usuarios(usuario)
);

CREATE TABLE LineasPedidos(
    lineaPedido INT NOT NULL,
    idProducto INT NOT NULL,
    idPedido INT NOT NULL,
    precioUnitario DECIMAL(7,2) NOT NULL,
    cantidad INT NOT NULL,
    FOREIGN KEY (idProducto) REFERENCES Productos(idProducto),
    FOREIGN KEY (idPedido) REFERENCES Pedidos(idPedido)
);