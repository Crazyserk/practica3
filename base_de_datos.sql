CREATE SCHEMA db_tienda;
USE  db_tienda;
CREATE TABLE Productos (
    idProducto int(8) auto_increment PRIMARY KEY,
    nombreProducto VARCHAR(40) NOT NULL,
    precio NUMERIC(7,2) NOT NULL,
    descripcion VARCHAR(255) NOT NULL,
    cantidad INT(5) NOT NULL
);

CREATE TABLE Usuarios(
	usuario VARCHAR(12) NOT NULL PRIMARY KEY,
    contrasena VARCHAR(255) NOT NULL,
    fechaNacimiento DATE NOT NULL
);

CREATE TABLE Cestas(
	idCesta INT(8) auto_increment PRIMARY KEY,
    usuario VARCHAR(255) NOT NULL,
    foreign key(usuario) references Usuarios(usuario),
    precioTotal NUMERIC(7,2) NOT NULL
);

CREATE TABLE ProductosCestas(
	idProducto INT NOT NULL,
    foreign key(idProducto) references Productos(idProducto),
    idCesta INT NOT NULL,
    foreign key(idCesta) references Cestas(idCesta),
    cantidad INT(2) NOT NULL,
    PRIMARY KEY (idProducto, idCesta)
);