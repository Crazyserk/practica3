CREATE DATABASE PRODUCTO;
USE PRODUCTO;
CREATE TABLE productos (
    idProducto INT(8) AUTO_INCREMENT PRIMARY KEY,
    nombreProducto VARCHAR(40) CHECK (nombreProducto REGEXP '^[A-Za-z0-9 ]+$'),
    Precio NUMERIC(7,2) NOT NULL,
    descripcion VARCHAR(255) NOT NULL, 
    Cantidad INT (5) NOT NULL
);
CREATE TABLE Usuarios(
usuario VARCHAR(12) NOT NULL PRIMARY KEY,
contrasena VARCHAR(255) NOT NULL,
fechaNacimiento DATE NOT NULL
);

CREATE TABLE Cestas(
idCesta INT (8) NOT NULL PRIMARY KEY,
usuario VARCHAR(255) NOT NULL,
FOREIGN KEY (usuario) REFERENCES Usuarios(usuario),
precioTotal NUMERIC(7,2) NOT NULL
);

CREATE TABLE ProductosCestas(
idProducto INT NOT NULL,
FOREIGN KEY (idProducto) REFERENCES productos(idProducto),
idCesta INT NOT NULL,
FOREIGN KEY (idCesta) REFERENCES Cestas(idCesta),
idCantidad INT (2) NOT NULL,
PRIMARY KEY (idProducto, idCesta)
);