DROP TABLE IF EXISTS usuarios;
DROP TABLE IF EXISTS roles;
DROP TABLE IF EXISTS historial_direcciones;
DROP TABLE IF EXISTS clientes;
DROP TABLE IF EXISTS listados_telefonos;
DROP TABLE IF EXISTS viviendas;
DROP TABLE IF EXISTS tipos_vivienda;
DROP TABLE IF EXISTS calles;
DROP TABLE IF EXISTS avenidas;
DROP TABLE IF EXISTS parroquias;
DROP TABLE IF EXISTS municipios;
DROP TABLE IF EXISTS estados;

CREATE TABLE estados (
  id INTEGER PRIMARY KEY AUTO_INCREMENT,
  nombre VARCHAR(255) NOT NULL UNIQUE,
  iso VARCHAR(255) NOT NULL UNIQUE
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
  id_parroquia INTEGER NOT NULL,
  nombre VARCHAR(255) NOT NULL,

  FOREIGN KEY (id_avenida) REFERENCES avenidas (id),
  FOREIGN KEY (id_parroquia) REFERENCES parroquias (id),
  UNIQUE (id_avenida, nombre)
);

CREATE TABLE tipos_vivienda (
  id INTEGER PRIMARY KEY AUTO_INCREMENT,
  tipo VARCHAR(255) NOT NULL UNIQUE
);

CREATE TABLE viviendas (
  id INTEGER PRIMARY KEY AUTO_INCREMENT,
  id_calle INTEGER NOT NULL,
  id_tipo INTEGER NOT NULL,
  numero VARCHAR(255),

  FOREIGN KEY (id_calle) REFERENCES calles (id),
  FOREIGN KEY (id_tipo) REFERENCES tipos_vivienda (id),
  UNIQUE (id_calle, numero)
);

CREATE TABLE listados_telefonos (
  id INTEGER PRIMARY KEY AUTO_INCREMENT,
  personal
    VARCHAR(255)
    NOT NULL
    UNIQUE
    CHECK (
      personal LIKE '___________'
      OR personal LIKE '+%'
    ),
  fijo
    VARCHAR(255)
    NOT NULL
    UNIQUE
    CHECK (
      fijo LIKE '___________'
      OR fijo LIKE '+%'
    ),
  opcional
    VARCHAR(255)
    UNIQUE
    CHECK (
      opcional LIKE '___________'
      OR opcional LIKE '+%'
    ),

  CHECK (
    personal != fijo
    AND personal != opcional
    AND fijo != opcional
  )
);

CREATE TABLE clientes (
  id INTEGER PRIMARY KEY AUTO_INCREMENT,
  id_telefonos INTEGER NOT NULL,
  nacionalidad ENUM('V', 'E') NOT NULL,
  cedula INTEGER NOT NULL UNIQUE CHECK (cedula > 0),
  primer_nombre VARCHAR(255) NOT NULL,
  segundo_nombre VARCHAR(255),
  primer_apellido VARCHAR(255) NOT NULL,
  segundo_apellido VARCHAR(255),

  FOREIGN KEY (id_telefonos) REFERENCES listados_telefonos (id),
  UNIQUE (primer_nombre, segundo_nombre, primer_apellido, segundo_apellido)
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
  id_rol INTEGER NOT NULL,
  cedula INTEGER NOT NULL UNIQUE CHECK (cedula > 0),
  nacionalidad ENUM('V', 'E') NOT NULL,
  primer_nombre VARCHAR(255) NOT NULL,
  segundo_nombre VARCHAR(255),
  primer_apellido VARCHAR(255) NOT NULL,
  segundo_apellido VARCHAR(255),
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
  usuario VARCHAR(255) NOT NULL UNIQUE,
  clave VARCHAR(255) NOT NULL,

  FOREIGN KEY (id_rol) REFERENCES roles (id),
  UNIQUE (primer_nombre, segundo_nombre, primer_apellido, segundo_apellido)
);

INSERT INTO roles VALUES
(1, 'Administrador', 'Administradora'),
(2, 'Secretario', 'Secretaria');

INSERT INTO tipos_vivienda VALUES
(1, 'Casa'),
(2, 'Apartamento'),
(3, 'Quinta'),
(4, 'Rancho'),
(5, 'Finca'),
(6, 'Parcela');
