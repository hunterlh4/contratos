-- borrar

-- DROP TABLE IF EXISTS distrito;
-- DROP TABLE IF EXISTS provincia;
-- DROP TABLE IF EXISTS departamento;
-- DROP TABLE IF EXISTS cargo;
-- DROP TABLE IF EXISTS area;
-- DROP TABLE IF EXISTS forma_pago;
-- DROP TABLE IF EXISTS moneda;

-- DROP TABLE IF EXISTS log;
-- DROP TABLE IF EXISTS usuario;

-- DROP TABLE IF EXISTS personal;

-- DROP TABLE IF EXISTS rol_permiso;
-- DROP TABLE IF EXISTS permiso;
-- DROP TABLE IF EXISTS submenu;
-- DROP TABLE IF EXISTS menu;
-- DROP TABLE IF EXISTS rol;
-- a

CREATE TABLE banco (
    id INT AUTO_INCREMENT PRIMARY KEY,  -- ID autoincrementable
    nombre VARCHAR(100) NOT NULL,
     estado BOOLEAN DEFAULT 1
);


CREATE TABLE departamento (
    id INT AUTO_INCREMENT PRIMARY KEY,  -- ID autoincrementable
    ubigeo varchar(2) not null,
    nombre VARCHAR(100) NOT NULL
);

-- 🌆 Tabla de Provincias
CREATE TABLE provincia (
    id INT AUTO_INCREMENT PRIMARY KEY,  -- ID autoincrementable
    nombre VARCHAR(100) NOT NULL,
    ubigeo VARCHAR(2) not null,
    departamento_id INT NOT NULL,
    FOREIGN KEY (departamento_id) REFERENCES departamento(id)
);
-- 🏠 Tabla de Distritos
CREATE TABLE distrito (
    id INT AUTO_INCREMENT PRIMARY KEY,  -- ID autoincrementable
    nombre VARCHAR(100) NOT NULL,
    ubigeo VARCHAR(2) not null,
    provincia_id INT NOT NULL,
    FOREIGN KEY (provincia_id) REFERENCES provincia(id)
);

CREATE TABLE moneda (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    descripcion TEXT NULL,
    simbolo VARCHAR(10) NOT NULL,
    sigla VARCHAR(10) NOT NULL,
    predeterminada BOOLEAN DEFAULT 0,
    estado BOOLEAN DEFAULT 1
);

CREATE TABLE forma_pago (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    estado BOOLEAN DEFAULT 1
);

CREATE TABLE area (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    descripcion TEXT NULL,
    estado BOOLEAN DEFAULT 1
);

CREATE TABLE cargo (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    descripcion TEXT NULL,
    estado BOOLEAN DEFAULT 1
);

CREATE TABLE persona (
    id INT AUTO_INCREMENT PRIMARY KEY,
    tipo_persona INT  NULL,
    tipo_documento_identidad INT  NULL,
    numero_documento VARCHAR(12) NOT NULL,
    numero_ruc VARCHAR(11) NULL DEFAULT NULL,
    nombre VARCHAR(100) NOT NULL,
    direccion VARCHAR(100) NOT NULL,
    ubigeo VARCHAR(50) NULL DEFAULT NULL,
    representante_legal VARCHAR(100) NULL DEFAULT NULL,
    numero_partida_registral VARCHAR(100) NULL DEFAULT NULL,
    numero_partida_registral_sede VARCHAR(255) NULL DEFAULT NULL,
    contacto_nombre VARCHAR(100) NULL DEFAULT NULL,
    contacto_telefono VARCHAR(100) NULL DEFAULT NULL,
    contacto_email VARCHAR(100) NULL DEFAULT NULL,
    estado BOOLEAN DEFAULT 1,
    user_created_id INT  NULL,
    created_at DATETIME  NULL,
    user_updated_id INT NULL DEFAULT NULL,
    updated_at DATETIME NULL DEFAULT NULL
);

CREATE TABLE personal (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    apellido_paterno VARCHAR(100) NOT NULL,
    apellido_materno VARCHAR(100)  NULL,
    dni CHAR(8) UNIQUE NOT NULL,
    correo VARCHAR(150) UNIQUE NULL,
    telefono VARCHAR(20) NULL,
    celular VARCHAR(20) NULL,
    celular_corporativo VARCHAR(20) NULL,
    operador_corporativo VARCHAR(50) NULL,
    area_id INT NULL,
    cargo_id INT NULL,
    -- empresa_id INT NULL,  -- 
    estado TINYINT(1) DEFAULT 1,  -- 
    FOREIGN KEY (area_id) REFERENCES area(id),
    FOREIGN KEY (cargo_id) REFERENCES cargo(id)
    -- FOREIGN KEY (empresa_id) REFERENCES persona_razon_social(id)  
);


CREATE TABLE rol (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) UNIQUE NOT NULL,
    descripcion TEXT NULL,
    estado BOOLEAN DEFAULT 1
);


CREATE TABLE usuario (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL,
    password VARCHAR(255) NOT NULL, -- Hasheado
    personal_id INT DEFAULT NULL, -- ID del personal asociado (si aplica)
    rol_id INT NOT NULL, -- Rol asignado al usuario
    sistema varchar(100) null, -- ('intranet', 'extranet', 'intranet+extranet') NOT NULL, -- Valores permitidos
    estado BOOLEAN DEFAULT 1, -- 1: Activo, 0: Inactivo
    password_changed TINYINT(1) DEFAULT 0, -- Indica si cambió la contraseña
    ip_restrict BOOLEAN DEFAULT 0, -- Restricción por IP (0: No, 1: Sí)
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP COMMENT 'Fecha de creación del registro',
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Fecha de actualización',
    user_created_id INT DEFAULT NULL COMMENT 'ID del usuario que creó el registro',
    user_updated_id INT DEFAULT NULL COMMENT 'ID del usuario que actualizó el registro',
    FOREIGN KEY (rol_id) REFERENCES rol(id) ON DELETE CASCADE,
     FOREIGN KEY (personal_id) REFERENCES personal(id) ON DELETE CASCADE
);


CREATE TABLE log (
    id INT AUTO_INCREMENT PRIMARY KEY,
    fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    usuario_id INT NOT NULL,
    campo_modificado VARCHAR(100) NOT NULL,
    valor_anterior TEXT NULL,
    valor_ingresado TEXT NULL,
    menu VARCHAR(100) NOT NULL,
    permiso VARCHAR(50) NULL,
    accion VARCHAR(50) NOT NULL,
    ip VARCHAR(45) NOT NULL,
    FOREIGN KEY (usuario_id) REFERENCES usuario(id)
);




-- CREATE TABLE usuario_rol (
--     usuario_id INT NOT NULL,
--     rol_id INT NOT NULL,
--     PRIMARY KEY (usuario_id, rol_id),
--     FOREIGN KEY (usuario_id) REFERENCES usuario(id) ON DELETE CASCADE,
--     FOREIGN KEY (rol_id) REFERENCES rol(id) ON DELETE CASCADE
-- );

CREATE TABLE password_reset (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    password_sha VARCHAR(255) NOT NULL, -- Hasheado
    ip VARCHAR(45) NOT NULL,
    estado BOOLEAN DEFAULT 1,
    FOREIGN KEY (usuario_id) REFERENCES usuario(id) ON DELETE CASCADE
);

CREATE TABLE menu (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    descripcion TEXT NULL
);

CREATE TABLE submenu (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    descripcion TEXT NULL,
    menu_id INT NOT NULL,
    icono VARCHAR(100) NULL,
    estado BOOLEAN DEFAULT 1,
    FOREIGN KEY (menu_id) REFERENCES menu(id) ON DELETE CASCADE
);

CREATE TABLE permiso (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL UNIQUE, -- Ej: agregar, modificar, eliminar
    estado BOOLEAN DEFAULT 1
);

CREATE TABLE rol_permiso (
	id int AUTO_INCREMENT PRIMARY KEY,
    rol_id INT NOT NULL,
    permiso_id INT NOT NULL,
    menu_id INT  NULL,
    submenu_id INT  NULL,
    estado BOOLEAN DEFAULT 1,
    visible BOOLEAN DEFAULT 1,
    FOREIGN KEY (rol_id) REFERENCES rol(id) ON DELETE CASCADE,
    FOREIGN KEY (permiso_id) REFERENCES permiso(id) ON DELETE CASCADE,
    FOREIGN KEY (menu_id) REFERENCES menu(id) ON DELETE CASCADE,
    FOREIGN KEY (submenu_id) REFERENCES submenu(id) ON DELETE CASCADE
);

CREATE TABLE usuario_permiso (
	id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    permiso_id INT NOT NULL,
    menu_id INT  NULL,
    submenu_id INT  NULL,
    estado BOOLEAN DEFAULT 1,
    visible BOOLEAN DEFAULT 1,
    FOREIGN KEY (usuario_id) REFERENCES usuario(id) ON DELETE CASCADE,
    FOREIGN KEY (permiso_id) REFERENCES permiso(id) ON DELETE CASCADE,
    FOREIGN KEY (menu_id) REFERENCES menu(id) ON DELETE CASCADE,
    FOREIGN KEY (submenu_id) REFERENCES submenu(id) ON DELETE CASCADE
);



CREATE TABLE tipo_contrato (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(255) NOT NULL,
    descripcion TEXT NULL,
    orden INT NOT NULL DEFAULT 0, -- Orden de prioridad
    estado BOOLEAN  NULL DEFAULT 1, -- 1 = Activo, 0 = Inactivo
    sigla VARCHAR(50) NOT NULL UNIQUE,
    user_created_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    user_updated_id INT NULL,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    FOREIGN KEY (user_created_id) REFERENCES usuario(id) ON DELETE CASCADE,
    FOREIGN KEY (user_updated_id) REFERENCES usuario(id) ON DELETE SET NULL
);

CREATE TABLE formato_contrato (
    id INT AUTO_INCREMENT PRIMARY KEY,
    tipo_contrato_id INT NOT NULL,
    nombre VARCHAR(255) NOT NULL,
    version INT NOT NULL DEFAULT 1,
    descripcion TEXT NULL,
    contenido TEXT NULL, -- Contenido del contrato
    estado BOOLEAN NOT NULL DEFAULT 1, -- 1 = Activo, 0 = Inactivo
    user_created_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    user_updated_id INT NULL,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    FOREIGN KEY (tipo_contrato_id) REFERENCES tipo_contrato(id) ON DELETE CASCADE,
    FOREIGN KEY (user_created_id) REFERENCES usuario(id) ON DELETE CASCADE,
    FOREIGN KEY (user_updated_id) REFERENCES usuario(id) ON DELETE SET NULL
);



CREATE TABLE etapa_contrato (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(255) NOT NULL,
    descripcion TEXT NULL,
    orden INT NOT NULL DEFAULT 0,
    descripcion_orden TEXT NULL,
    area_id INT NULL,
    situacion VARCHAR(100)  NULL, 
    estado BOOLEAN NULL DEFAULT 1, -- Usando BOOLEAN en lugar de TINYINT(1)
    
    FOREIGN KEY (area_id) REFERENCES area(id) ON DELETE CASCADE
);




CREATE TABLE contrato (
    id INT AUTO_INCREMENT PRIMARY KEY,
    tipo_contrato_id INT  NULL, -- Relacionado con el tipo de contrato
    codigo_correlativo VARCHAR(50)  NULL, -- Ejemplo: A1, L1, M1, etc.
    personal_abogado_id INT NULL, -- (personal) cargo abogado
	persona_emisor_id INT NULL, -- Arrendador
	persona_receptor_id INT NULL, -- Arrendatario (si aplica)
  	etapa_contrato_id INT NULL default 1 ,  -- 'Aprobado', 'Rechazado', 'Vigente', 'Finalizado'
	-- estado
	fecha_suscripcion DATE NULL, -- Fecha en la que se ponen de acuerdo
-- GENERALES
	fecha_aprobacion DATE NULL, -- Fecha de aprobación en el sistema
	personal_aprobador_id INT NULL, -- Usuario que aprueba
		
-- ALERTAS Y PLAZOS
    alerta_dia INT NULL, -- Días antes de que se active la alerta
	plazo INT NULL, -- Plazo en meses
    fecha_inicio DATE NULL, -- Inicio del contrato
    fecha_fin DATE NULL, -- Fin del contrato
    alerta_activa BOOLEAN default 0,

-- FINANCIERTO
 	monto DECIMAL(10,2) NULL, -- Monto del contrato (si aplica)
    moneda_id INT NULL, -- Tipo de moneda (USD, PEN, etc.)
    banco_id INT NULL, -- Banco donde se pagará (si aplica)
    cuenta_bancaria VARCHAR(50) NULL, -- Número de cuenta

-- 🏠 CAMPOS SOLO PARA ARRENDAMIENTO
 	ubigeo varchar(6) NULL, -- **Reemplazo de ubigeo**
    direccion TEXT NULL, 
    numero_partida_registral VARCHAR(50) NULL,
    sede VARCHAR(100) NULL,
    latitud DECIMAL(10,6) NULL, -- Si se usa mapa
    longitud DECIMAL(10,6) NULL,
    observaciones_mueble TEXT NULL, 
    inmueble_destinado TEXT NULL, -- Destino del inmueble

-- 👨‍🔧 CAMPOS SOLO PARA LOCACIÓN DE SERVICIOS
    nombre_servicio TEXT NULL, -- Ej: "Mantenimiento de software"

-- 📝 CAMPOS SOLO PARA MANDATO (revisar)
    -- mandante_id INT NULL, -- Persona que delega
    -- mandatario_id INT NULL, -- Persona que recibe el mandato

 -- 💵 CAMPOS SOLO PARA MUTUO DE DINERO
    interes DECIMAL(5,2) NULL, -- Porcentaje de interés

-- GENERAL EDIT

	user_created_id INT  NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    user_updated_id INT NULL,
    updated_at TIMESTAMP NULL ON UPDATE CURRENT_TIMESTAMP,

     FOREIGN KEY (tipo_contrato_id) REFERENCES tipo_contrato(id),
    FOREIGN KEY (personal_abogado_id) REFERENCES personal(id),
    FOREIGN KEY (persona_emisor_id) REFERENCES persona(id),
    FOREIGN KEY (persona_receptor_id) REFERENCES persona(id),
    FOREIGN KEY (personal_aprobador_id) REFERENCES personal(id),
    FOREIGN KEY (banco_id) REFERENCES banco(id) ON DELETE SET NULL,
    FOREIGN KEY (moneda_id) REFERENCES moneda(id) ON DELETE SET NULL,
    FOREIGN KEY (etapa_contrato_id) REFERENCES etapa_contrato(id) ON DELETE SET NULL
    -- FOREIGN KEY (distrito_id) REFERENCES distrito(id) -- NUEVO
);

CREATE TABLE tipo_archivo (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(255) NOT NULL,
    tipo_contrato_id int NOT NULL,
    estado BOOLEAN NOT NULL DEFAULT TRUE, -- Usando BOOLEAN
    user_created_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    user_updated_id INT NULL,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
     FOREIGN KEY (tipo_contrato_id) REFERENCES contrato(id) ON DELETE CASCADE,
    FOREIGN KEY (user_created_id) REFERENCES usuario(id) ON DELETE CASCADE,
    FOREIGN KEY (user_updated_id) REFERENCES usuario(id) ON DELETE SET NULL
);



CREATE TABLE adenda (
    id INT AUTO_INCREMENT PRIMARY KEY,
    contrato_id INT NOT NULL, -- Relacionado con el contrato original
    numero VARCHAR(50) NOT NULL, -- Ejemplo: "Adenda N°1"
    descripcion TEXT NOT NULL, -- Breve descripción de la modificación
    fecha DATE NOT NULL, -- Fecha de la adenda
    proceso varchar(100) null,
    estado BOOLEAN NOT NULL DEFAULT TRUE, -- Activo/Inactivo
    user_created_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    user_updated_id INT NULL,
    updated_at TIMESTAMP NULL ON UPDATE CURRENT_TIMESTAMP,

    FOREIGN KEY (contrato_id) REFERENCES contrato(id) ON DELETE CASCADE
);

CREATE TABLE adenda_detalle (
    id INT AUTO_INCREMENT PRIMARY KEY,
    adenda_id INT NOT NULL, -- Relación con la adenda
    campo_modificado VARCHAR(50) NOT NULL, -- Ejemplo: "monto", "fecha_fin"
    valor_anterior TEXT NULL, -- Valor original del contrato
    valor_nuevo TEXT NOT NULL, -- Nuevo valor definido en la adenda
    user_created_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (adenda_id) REFERENCES adenda(id) ON DELETE CASCADE
);


CREATE TABLE observacion (
    id INT AUTO_INCREMENT PRIMARY KEY,
    contrato_id INT NOT NULL,
    adenda_id INT NULL,
    observacion TEXT NOT NULL,
    estado BOOLEAN NOT NULL DEFAULT TRUE,
    user_created_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    user_updated_id INT NULL,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    FOREIGN KEY (contrato_id) REFERENCES contrato(id) ON DELETE CASCADE,
    FOREIGN KEY (adenda_id) REFERENCES adenda(id) ON DELETE SET NULL,
    FOREIGN KEY (user_created_id) REFERENCES usuario(id) ON DELETE CASCADE,
    FOREIGN KEY (user_updated_id) REFERENCES usuario(id) ON DELETE SET NULL
);



CREATE TABLE archivo (
    id INT AUTO_INCREMENT PRIMARY KEY,
    contrato_id INT NOT NULL,
    -- adenda_id INT NULL,
    adenda_detalle_id INT NULL,
    tipo_archivo_id INT NOT NULL,
    nombre VARCHAR(255) NOT NULL,
    extension VARCHAR(10) NOT NULL,
    ruta VARCHAR(500) NOT NULL,
    size INT NOT NULL, -- En bytes
    estado BOOLEAN NOT NULL DEFAULT TRUE,
    user_created_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    user_updated_id INT NULL,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    FOREIGN KEY (contrato_id) REFERENCES contrato(id) ON DELETE CASCADE,
    -- FOREIGN KEY (adenda_id) REFERENCES adenda(id) ON DELETE SET NULL,
     FOREIGN KEY (adenda_detalle_id) REFERENCES adenda_detalle(id) ON DELETE CASCADE,
    FOREIGN KEY (tipo_archivo_id) REFERENCES tipo_archivo(id) ON DELETE CASCADE,
    FOREIGN KEY (user_created_id) REFERENCES usuario(id) ON DELETE CASCADE,
    FOREIGN KEY (user_updated_id) REFERENCES usuario(id) ON DELETE SET NULL
);




contrato_detalle
contrato_adelanto
contrato_adenda
contrato_adenda_detalle
contrato_auditoria (revisar)
contrato_condicion_economica (revisar)
contrato_contraprestacion (revisar)
contrato_declaracion_jurada (revisar)

contrato_beneficiario
contrato_adenda_detalle
contrato_archivo (subida de documento)
contrato_inmueble
contrato_inmueble (suministro)




-- tareas progradas para notificaciones (job de windows)