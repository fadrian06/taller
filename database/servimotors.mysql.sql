DROP TABLE IF EXISTS usuarios;
DROP TABLE IF EXISTS roles;
DROP TABLE IF EXISTS historial_direcciones;
DROP TABLE IF EXISTS clientes;
DROP TABLE IF EXISTS listados_telefonos;
DROP TABLE IF EXISTS viviendas;
DROP TABLE IF EXISTS calles;
DROP TABLE IF EXISTS avenidas;
DROP TABLE IF EXISTS parroquias;
DROP TABLE IF EXISTS municipios;
DROP TABLE IF EXISTS estados;

CREATE TABLE estados (
  id INTEGER PRIMARY KEY AUTO_INCREMENT,
  nombre VARCHAR(255) NOT NULL UNIQUE,
  `iso_3166-2` VARCHAR(255) NOT NULL UNIQUE
);

CREATE TABLE municipios (
  id INTEGER PRIMARY KEY AUTO_INCREMENT,
  id_estado INTEGER NOT NULL,
  nombre VARCHAR(255) NOT NULL,

  FOREIGN KEY (id_estado) REFERENCES estados (id),
  UNIQUE (id_estado, nombre)
);

CREATE TABLE parroquias (
  id INTEGER PRIMARY KEY AUTO_INCREMENT,
  id_municipio INTEGER NOT NULL,
  nombre VARCHAR(255) NOT NULL,

  FOREIGN KEY (id_municipio) REFERENCES municipios (id),
  UNIQUE (id_municipio, nombre)
);

CREATE TABLE avenidas (
  id INTEGER PRIMARY KEY AUTO_INCREMENT,
  id_parroquia INTEGER NOT NULL,
  nombre VARCHAR(255) NOT NULL,

  FOREIGN KEY (id_parroquia) REFERENCES parroquias (id),
  UNIQUE (id_parroquia, nombre)
);

CREATE TABLE calles (
  id INTEGER PRIMARY KEY AUTO_INCREMENT,
  id_avenida INTEGER NOT NULL,
  nombre VARCHAR(255) NOT NULL,

  FOREIGN KEY (id_avenida) REFERENCES avenidas (id),
  UNIQUE (id_avenida, nombre)
);

CREATE TABLE viviendas (
  id INTEGER PRIMARY KEY AUTO_INCREMENT,
  id_calle INTEGER NOT NULL,
  numero VARCHAR(255),

  FOREIGN KEY (id_calle) REFERENCES calles (id),
  UNIQUE (id_calle, numero)
);

CREATE TABLE listados_telefonos (
  id INTEGER PRIMARY KEY AUTO_INCREMENT,
  telefonoPersonal
    VARCHAR(255)
    NOT NULL
    UNIQUE
    CHECK (
      telefonoPersonal LIKE '___________'
      OR telefonoPersonal LIKE '+%'
    ),
  telefonoFijo
    VARCHAR(255)
    NOT NULL
    UNIQUE
    CHECK (
      telefonoFijo LIKE '___________'
      OR telefonoFijo LIKE '+%'
    ),
  telefonoOpcional
    VARCHAR(255)
    UNIQUE
    CHECK (
      telefonoOpcional LIKE '___________'
      OR telefonoOpcional LIKE '+%'
    ),

  CHECK (
    telefonoPersonal != telefonoFijo
    AND telefonoPersonal != telefonoOpcional
    AND telefonoFijo != telefonoOpcional
  )
);

CREATE TABLE clientes (
  id INTEGER PRIMARY KEY AUTO_INCREMENT,
  cedula INTEGER NOT NULL UNIQUE CHECK (cedula > 0),
  nacionalidad ENUM('V', 'E') NOT NULL,
  primerNombre VARCHAR(255) NOT NULL,
  segundoNombre VARCHAR(255),
  primerApellido VARCHAR(255) NOT NULL,
  segundoApellido VARCHAR(255) NOT NULL,
  id_telefonos INTEGER NOT NULL,

  FOREIGN KEY (id_telefonos) REFERENCES listados_telefonos (id),
  UNIQUE (primerNombre, segundoNombre, primerApellido, segundoApellido)
);

CREATE TABLE historial_direcciones (
  id INTEGER PRIMARY KEY AUTO_INCREMENT,
  id_cliente INTEGER NOT NULL,
  id_vivienda INTEGER NOT NULL,

  FOREIGN KEY (id_cliente) REFERENCES clientes (id),
  FOREIGN KEY (id_vivienda) REFERENCES viviendas (id)
);

CREATE TABLE roles (
  id INTEGER PRIMARY KEY AUTO_INCREMENT,
  nombre_masculino VARCHAR(255) NOT NULL UNIQUE,
  nombre_femenino VARCHAR(255) UNIQUE
);

CREATE TABLE usuarios (
  id INTEGER PRIMARY KEY AUTO_INCREMENT,
  cedula INTEGER NOT NULL UNIQUE CHECK (cedula > 0),
  nacionalidad ENUM('V', 'E') NOT NULL,
  primerNombre VARCHAR(255) NOT NULL,
  segundoNombre VARCHAR(255),
  primerApellido VARCHAR(255) NOT NULL,
  segundoApellido VARCHAR(255) NOT NULL,
  genero ENUM('Masculino', 'Femenino') NOT NULL,
  telefono
    VARCHAR(255)
    NOT NULL
    UNIQUE
    CHECK (
      telefono LIKE '___________'
      OR telefono LIKE '+%'
    ),
  correo VARCHAR(255) NOT NULL UNIQUE CHECK (correo LIKE '%@%'),
  id_rol INTEGER NOT NULL,

  FOREIGN KEY (id_rol) REFERENCES roles (id),
  UNIQUE (primerNombre, segundoNombre, primerApellido, segundoApellido)
);
