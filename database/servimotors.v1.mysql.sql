CREATE TABLE estados (
  estadoId int(11) PRIMARY KEY AUTO_INCREMENT,
  nombreEstado varchar(50) NOT NULL UNIQUE
);

CREATE TABLE municipios (
  municipioId int(11) PRIMARY KEY AUTO_INCREMENT,
  nombreMunicipio varchar(50) NOT NULL,
  estadoId int(11) NOT NULL,

  UNIQUE (nombreMunicipio, estadoId),
  FOREIGN KEY (estadoId) REFERENCES estados (estadoId)
);

CREATE TABLE parroquias (
  parroquiaId int(11) PRIMARY KEY AUTO_INCREMENT,
  nombreParroquia varchar(50) NOT NULL,
  municipioId int(11) NOT NULL,

  UNIQUE (nombreParroquia, municipioId),
  FOREIGN KEY (municipioId) REFERENCES municipios (municipioId)
);

CREATE TABLE avenidas (
  avenidaId int(11) PRIMARY KEY AUTO_INCREMENT,
  nombreAvenida varchar(50) NOT NULL,
  parroquiaId int(11) NOT NULL,

  UNIQUE (nombreAvenida, parroquiaId),
  FOREIGN KEY (parroquiaId) REFERENCES parroquias (parroquiaId)
);

CREATE TABLE calles (
  calleId int(11) PRIMARY KEY AUTO_INCREMENT,
  nombreCalle varchar(50) NOT NULL,
  avenidaId int(11) NOT NULL,

  UNIQUE (nombreCalle, avenidaId),
  FOREIGN KEY (avenidaId) REFERENCES avenidas (avenidaId)
);

CREATE TABLE casasapartamentos (
  casaApartamentoId int(11) PRIMARY KEY AUTO_INCREMENT,
  calleId int(11) NOT NULL,
  detalleCasaApartamento varchar(50) NOT NULL,

  UNIQUE (detalleCasaApartamento, calleId),
  FOREIGN KEY (calleId) REFERENCES calles (calleId)
);

CREATE TABLE clientes (
  cedula varchar(8) PRIMARY KEY,
  primerNombre varchar(30) NOT NULL,
  segundoNombre varchar(30) DEFAULT NULL,
  primerApellido varchar(30) NOT NULL,
  segundoApellido varchar(30) DEFAULT NULL
);

CREATE TABLE rolusuario (
  idRol int(11) PRIMARY KEY AUTO_INCREMENT,
  nombreRol varchar(255) NOT NULL UNIQUE
);

CREATE TABLE usuarios (
  cedula varchar(8) PRIMARY KEY,
  idRol int(11) NOT NULL,
  nombreUsuario varchar(50) NOT NULL UNIQUE,
  contrasena varchar(255) NOT NULL,

  FOREIGN KEY (idRol) REFERENCES rolusuario (idRol)
);

CREATE TABLE contactosusuario (
  cedula varchar(8) NOT NULL,
  telefono varchar(11) NOT NULL UNIQUE,
  correo varchar(254) NOT NULL UNIQUE,

  FOREIGN KEY (cedula) REFERENCES usuarios (cedula)
);

CREATE TABLE datosusuario (
  cedula varchar(8) DEFAULT NULL,
  primerNombre varchar(30) NOT NULL,
  segundoNombre varchar(30) NOT NULL,
  primerApellido varchar(30) NOT NULL,
  segundoApellido varchar(30) DEFAULT NULL,

  FOREIGN KEY (cedula) REFERENCES usuarios (cedula)
);

CREATE TABLE direcciones (
  cedulaCliente varchar(8) NOT NULL,
  casaApartamentoId int(11) NOT NULL,

  FOREIGN KEY (cedulaCliente) REFERENCES clientes (cedula),
  FOREIGN KEY (casaApartamentoId) REFERENCES casasapartamentos (casaApartamentoId)
);

CREATE TABLE telefonos (
  cedulaCliente varchar(8) NOT NULL,
  telefonoPersonal varchar(255) DEFAULT NULL,
  telefonoFijo varchar(255) DEFAULT NULL,
  telefonoOpcional varchar(255) DEFAULT NULL,

  FOREIGN KEY (cedulaCliente) REFERENCES clientes (cedula)
);

INSERT INTO rolusuario (idRol, nombreRol) VALUES
(1, 'Administrador'),
(2, 'Secretaría');

INSERT INTO usuarios (cedula, idRol, nombreUsuario, contrasena) VALUES
(
  '29634134',
  1,
  'Ander',
  /* 12345678 */ '$2y$10$8SM1F2hEGucr9BZ94u5k1.SADFHs9du0XwEJST8mWuDHKHuChbTEO'
);

INSERT INTO `contactosusuario` (`cedula`, `telefono`, `correo`) VALUES
('29634134', '04147510509', 'andersonlobo20@hotmail.com');

INSERT INTO `datosusuario` (`cedula`, `primerNombre`, `segundoNombre`, `primerApellido`, `segundoApellido`) VALUES
('29634134', 'Anderson', 'Alejandro', 'lobo', 'uzcategui');
