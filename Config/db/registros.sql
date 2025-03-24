INSERT INTO banco
    (nombre, estado)
VALUES
    ('BCP', 1),
    ('BBVA', 1),
    ('Interbank', 1),
    ('SCOTIABANK', 1),
    ('Caja Piura', 1),
    ('Banco de la Nacion', 1),
    ('IZIPAY', 1),
    ('PAGO EFECTIVO', 1),
    ('NIUBIZ', 1),
    ('BanBif', 1),
    ('Caja Trujillo', 1),
    ('Mi Banco Dol', 1),
    ('BANCO EXTRANJERO', 1),
    ('Citibank del Perú S.A.', 1),
    ('CAJA HUANCAYO', 1),
    ('CAJA SULLANA', 1),
    ('FALABELLA', 1),
    ('YAPE', 1),
    ('CAJA AREQUIPA', 1),
    ('Santander', 0),
    ('UniCredit Bank', 0),
    ('UBS BANK', 0),
    ('SOUTH AMERICAN INTERNATIONAL BANK', 0),
    ('SATA BANK PLC', 0),
    ('BANCOLOMBIA', 0),
    ('Banco GNB', 1);

INSERT INTO departamento
    (nombre, ubigeo)
VALUES
    ('AMAZONAS', '01'),
    ('ANCASH', '02'),
    ('APURIMAC', '03'),
    ('AREQUIPA', '04'),
    ('AYACUCHO', '05'),
    ('CAJAMARCA', '06'),
    ('CALLAO', '07'),
    ('CUSCO', '08'),
    ('HUANCAVELICA', '09'),
    ('HUANUCO', '10'),
    ('ICA', '11'),
    ('JUNIN', '12'),
    ('LA LIBERTAD', '13'),
    ('LAMBAYEQUE', '14'),
    ('LIMA', '15'),
    ('LORETO', '16'),
    ('MADRE DE DIOS', '17'),
    ('MOQUEGUA', '18'),
    ('PASCO', '19'),
    ('PIURA', '20'),
    ('PUNO', '21'),
    ('SAN MARTIN', '22'),
    ('TACNA', '23'),
    ('TUMBES', '24'),
    ('UCAYALI', '25');

INSERT INTO provincia
    (ubigeo, nombre, departamento_id)
VALUES
    ('01', 'Chachapoyas', 1),
    ('02', 'Bagua', 1),
    ('03', 'Bongará', 1),
    ('04', 'Luya', 1),
    ('05', 'Rodríguez de Mendoza', 1),
    ('06', 'Condorcanqui', 1),
    ('07', 'Utcubamba', 1);


INSERT INTO distrito
    (ubigeo, nombre, provincia_id)
VALUES
    ('01', 'Chachapoyas', 1),
    ('02', 'Asunción', 1),
    ('03', 'Balsas', 1),
    ('04', 'Cheto', 1),
    ('05', 'Chiliquín', 1),
    ('06', 'Chuquibamba', 1),
    ('07', 'Granada', 1),
    ('08', 'Huancas', 1),
    ('09', 'La Jalca', 1),
    ('10', 'Leimebamba', 1),
    ('11', 'Levanto', 1),
    ('12', 'Magdalena', 1),
    ('13', 'Mariscal Castilla', 1),
    ('14', 'Molinopampa', 1),
    ('15', 'Montevideo', 1),
    ('16', 'Olleros', 1),
    ('17', 'Quinjalca', 1),
    ('18', 'San Francisco de Daguas', 1),
    ('19', 'San Isidro de Maino', 1),
    ('20', 'Soloco', 1),
    ('21', 'Sonche', 1),
    ('01', 'La Peca', 2),
    ('02', 'Aramango', 2),
    ('03', 'Copallín', 2),
    ('04', 'El Parco', 2),
    ('05', 'Bagua', 2),
    ('06', 'Imaza', 2),
    ('01', 'Jumbilla', 3),
    ('02', 'Corosha', 3),
    ('03', 'Cuispes', 3),
    ('04', 'Chisquilla', 3),
    ('05', 'Churuja', 3),
    ('06', 'Florida', 3),
    ('07', 'Recta', 3),
    ('08', 'San Carlos', 3),
    ('09', 'Shipasbamba', 3),
    ('10', 'Valera', 3),
    ('11', 'Yambrasbamba', 3),
    ('12', 'Jazan', 3),
    ('01', 'Lamud', 4),
    ('02', 'Camporredondo', 4),
    ('03', 'Cocabamba', 4),
    ('04', 'Colcamar', 4),
    ('05', 'Conila', 4),
    ('06', 'Inguilpata', 4),
    ('07', 'Longuita', 4),
    ('08', 'Lonya Chico', 4),
    ('09', 'Luya', 4),
    ('10', 'Luya Viejo', 4),
    ('11', 'María', 4),
    ('12', 'Ocallí', 4),
    ('13', 'Ocumal', 4),
    ('14', 'Pisuquía', 4),
    ('15', 'San Cristóbal', 4),
    ('16', 'San Francisco del Yeso', 4),
    ('17', 'San Jerónimo', 4),
    ('18', 'San Juan de Lopecancha', 4),
    ('19', 'Santa Catalina', 4),
    ('20', 'Santo Tomás', 4),
    ('21', 'Tingo', 4),
    ('22', 'Trita', 4),
    ('23', 'Providencia', 4),
    ('01', 'San Nicolás', 5),
    ('02', 'Cochamal', 5),
    ('03', 'Chirimoto', 5),
    ('04', 'Huambo', 5),
    ('05', 'Limabamba', 5),
    ('06', 'Longar', 5),
    ('07', 'Milpuc', 5),
    ('08', 'Mariscal Benavides', 5),
    ('09', 'Omia', 5),
    ('10', 'Santa Rosa', 5),
    ('11', 'Totora', 5),
    ('12', 'Vista Alegre', 5),
    ('01', 'Nieva', 6),
    ('02', 'Río Santiago', 6),
    ('03', 'El Cenepa', 6),
    ('01', 'Bagua Grande', 7),
    ('02', 'Cajaruro', 7),
    ('03', 'Cumba', 7),
    ('04', 'El Milagro', 7),
    ('05', 'Jamalca', 7),
    ('06', 'Lonya Grande', 7),
    ('07', 'Yamón', 7);

INSERT INTO moneda
    (nombre, descripcion, simbolo, sigla, predeterminada, estado)
VALUES
    ('Nuevos Soles', 'Moneda Peru', 'S/.', 'PEN', 1, 1),
    ('Dólares Americanos', 'Moneda EEUU', 'US$', 'USD', 0, 1),
    ('Peso Argentino', 'Moneda Argentina', '$', 'ARS', 0, 1),
    ('Euro', 'Eurozona', '€', 'EUR', 0, 1);

INSERT INTO forma_pago
    (nombre, estado)
VALUES
    ('Transferencia Bancaria', 1),
    ('Depósito en Cuenta Bancaria', 1),
    ('Cheque No Negociable', 1);


INSERT INTO area
    (nombre, descripcion, estado)
VALUES
    ('Administracion', 'asdf', 1),
    ('Contabilidad', NULL, 1),
    ('Tesoreria', NULL, 1),
    ('Recursos Humanos', NULL, 1),
    ('Logística', NULL, 1),
    ('Sistemas', NULL, 1),
    ('Desarrollo Tecnologico', NULL, 1),
    ('Finanzas', NULL, 1),
    ('Soporte', NULL, 1),
    ('Soporte Tecnico', NULL, 1),
    ('AREA TEST', NULL, 1),
    ('Cliente', NULL, 1),
    ('SuperUser', NULL, 1),
    ('Comercial', NULL, 1),
    ('Gerencia', NULL, 1),
    ('Auditoria', NULL, 1),
    ('Marketing', NULL, 1),
    ('Bet Bar', NULL, 1),
    ('Diseño Gráfico', NULL, 1),
    ('Operaciones', NULL, 1),
    ('Control Interno', NULL, 1),
    ('Capacitación', NULL, 1),
    ('oper', NULL, 1),
    ('Producto', NULL, 1),
    ('Prevención de Fraude Online', NULL, 1),
    ('Gladcon Group', NULL, 1),
    ('Agentes', NULL, 1),
    ('Prevención de Fraude - Canal Moderno', NULL, 1),
    ('Tesoreria - Canal Moderno', NULL, 1),
    ('Televentas', NULL, 1),
    ('Experiencia del Cliente', NULL, 1),
    ('Legal', NULL, 1),
    ('Control Interno - Teleservicios', NULL, 1),
    ('Estrategia Omnicanal', NULL, 1),
    ('Digital', NULL, 1),
    ('Mantenimiento e Infraestructura - Retail', NULL, 1),
    ('Proyectos', NULL, 1),
    ('Comercial - Marcadores 247', NULL, 1),
    ('Televentas - Marketing', NULL, 1),
    ('Apuestas Deportivas', NULL, 1),
    ('Gobierno de datos', NULL, 1),
    ('Marketing Omnicanal', NULL, 1),
    ('Mejora Continua', NULL, 1),
    ('Comercial - Torito', NULL, 1),
    ('Comunicaciones - Torito', NULL, 1),
    ('Experiencia de cliente - Torito', NULL, 1),
    ('Marketing - Torito', NULL, 1),
    ('Desarrollo de negocios', NULL, 1),
    ('Comunicaciones e Imagen Institucional', NULL, 1),
    ('CCTV', NULL, 1),
    ('Planeamiento Financiero', NULL, 1);

INSERT INTO cargo
    (nombre, descripcion, estado)
VALUES
    ('Administrador', 'Administrador Administrador', 1),
    ('Gerente', NULL, 1),
    ('Supervisor', NULL, 1),
    ('Cajero', NULL, 1),
    ('Soporte', NULL, 1),
    ('Cliente', NULL, 1),
    ('Desarrollador', '', 1),
    ('CARGO TEST', NULL, 1),
    ('nuevo cargo', '', 0),
    ('Ejecutivo de ventas', NULL, 1),
    ('Auditor', NULL, 1),
    ('Asesor', NULL, 1),
    ('Jefe', NULL, 1),
    ('Analista', NULL, 1),
    ('Asistente', NULL, 1),
    ('Coordinador', NULL, 1),
    ('Técnico', NULL, 1),
    ('Validador', NULL, 1),
    ('Gerente Comercial', NULL, 1),
    ('Pagador', NULL, 1),
    ('Digitador', NULL, 1),
    ('Municipal', NULL, 1),
    ('Director', NULL, 1),
    ('Abogado Junior', NULL, 1),
    ('Promotor', NULL, 1),
    ('Sub Gerente', NULL, 1),
    ('Practicante Profesional', NULL, 1),
    ('Contador', NULL, 1),
    ('CCTV', NULL, 1),
    ('Auxiliar', NULL, 1),
    ('Abogado', NULL, 1),
    ('Trabajador Social', NULL, 1),
    ('Comprador', NULL, 1),
    ('Practicante no profesional', NULL, 1);

INSERT INTO persona
    (tipo_persona, tipo_documento_identidad, numero_documento, numero_ruc, nombre, direccion, representante_legal, numero_partida_registral,
    contacto_nombre, contacto_telefono, contacto_email, estado, user_created_id, created_at, user_updated_id, updated_at,ubigeo)
VALUES
    (1, 1, '12121212', '12121212111', 'Chano', 'Asoc. Las Begonias Mz A Lote 2', 'La misma persona', '1000', '1232', '12121212', 'adrielgo.mez123@gmail.com', 1, 1, '2025-01-23 17:05:00', NULL, NULL, '010101'),
    (1, 1, '71717171', '71717171711', 'Daniel', 'Asoc. Las Begonias Mz A Lote 2', 'Jose Ishikawa', '1231542351', 'Daniel', '123321321', 'adrielgo.mez123@gmail.com', 1, 1, '2025-01-24 14:06:25', NULL, NULL, '010101'),
    (1, 1, '17171717', '17171717177', 'Soy un propietario', 'Asoc. Las Begonias Mz A Lote 2', 'Sr Curacao', '10000000', 'Soy un propietario', '911911911', 'mail.persona.contacto1@gmail.com', 1, 1, '2025-01-28 17:03:43', NULL, NULL, '010101'),
    (1, 1, '72258059', '10722580597', 'Jean Carlo Gomez', 'Asoc. Las Begonias Mz A Lote 2', 'Chano SAC', '1000', 'Jean Carlo Gomez', '123123123', 'ad@gmail.com', 1, 1, '2025-01-31 09:15:44', NULL, '2025-01-31 09:28:00', '010101'),
    (2, 1, '12345678', '12312313123', 'Yola Polastri', 'Asoc. Las Begonias Mz A Lote 2', 'La misma persona', '1231542351', 'Yola Polastri', '987978987', 'nuevin@gmail.com', 1, 1, '2025-02-18 11:12:20', NULL, NULL, '010101'),
    (2, 1, '00000000', '10000000000', 'Designment & Development', 'Asoc. Las Begonias Mz A Lote 2', 'Jose Ishikawa', '10000000', 'Designment & Development', '987654321', 'jose@gmail.com', 1, 1, '2025-02-19 16:02:53', NULL, '2025-02-19 16:03:19', '010101'),
    (2, 1, '79879879', '79879897898', 'Curacao', 'Asoc. Las Begonias Mz A Lote 2', 'Sr Curacao', '123123123123123', 'Curacao', '123123123', '123@gmail.com', 1, 1, '2025-02-20 09:49:00', NULL, NULL, '010101'),
    (2, 1, '74036539', '10740365393', 'Chano', 'Asoc. Las Begonias Mz A Lote 2', 'Chano SAC', '123456798', 'Chano', '123987987', 'chano@gmail.com', 1, 1, '2025-02-25 11:05:20', NULL, NULL, '010101'),
    (2, 1, '10000000', '10010101010', 'Richard SAC', 'ZofraTacna 123', 'Richard', '10000000', 'Richard SAC', '987654321', 'test@gmail.com', 1, 1, '2025-03-07 16:14:03', NULL, NULL, '010101'),
    (2, 1, '10101001', '01000000000', 'Ana SAC 2', 'Asoc. Jaime', 'Ana', '01123456', 'Ana SAC 2', '987456321', 'test@gmail.com', 1, 1, '2025-03-07 16:20:03', NULL, '2025-03-07 16:20:17', '010101'),
    (2, 1, '12345678', '12313213211', 'Daniel', 'Asoc yaya 123 123', 'Daniel CORP', '1010101', 'Daniel', '987654321', 'test@gmail.com', 1, 1, '2025-03-07 16:25:18', NULL, NULL, '010101'),
    (1, 1, '71205269', '10712052690', 'Alex Arrendador', 'Domicilio asdasdasd', '', '', 'Alex Arrendador', '123456789', 'a@gmail.com', 1, 1, '2025-03-13 10:31:25', NULL, NULL, '010101'),
    (2, 1, '71205268', '10712052690', 'Alex Arrendador 2', 'Ererrrrerererer', 'Alex 3', '123456789', 'Alex Arrendador 2', '123456789', 'a@gmail.com', 1, 1, '2025-03-13 10:34:13', NULL, '2025-03-13 10:34:49', '010101'),
    (1, 1, '77889944', '77889944101', 'Alex12', 'Asdadasdasd', '', '', 'Alex12', '123456789', 'alñlwe@gmail.com', 1, 28, '2025-03-13 15:44:37', NULL, NULL, '010101'),
    (1, 1, '12122221', '21212121212', 'Asss', 'Qwqwqwwwqwqwqw', '', '', 'Asss', '121212212', '', 1, 28, '2025-03-13 15:45:47', NULL, NULL, '010101'),
    (1, 1, '11223344', '11223344556', 'Prueba001', 'Sdasdsadadasdasda', '', '', 'Prueba001', '121212121', '1212121212@gmail.com', 1, 1, '2025-03-13 16:41:07', NULL, NULL, '010101'),
    (2, 1, '11223345', '11223344563', 'Prueba006', 'Asdad1as2dasdad', 'Qwqwq', '211212122', 'Prueba006', '121212212', 'asdasdda@gmail.com', 1, 1, '2025-03-13 16:42:15', NULL, '2025-03-13 16:42:34', '010101');


INSERT INTO personal
    (
    nombre,apellido_paterno,apellido_materno,dni,
    correo,
    telefono,
    celular,
    celular_corporativo,
    operador_corporativo,
    area_id,
    cargo_id,
    estado
    )
VALUES
    ( 'Sistema', 'Test', NULL, '70359383', 'adrielgo.mez123@gmail.com', NULL, NULL, NULL, NULL, 6, 9, 1),
    ( 'Legal', 'Test', NULL, '00000000', 'bluemotion.rose@gmail.com', NULL, NULL, NULL, NULL, 33, 34, 1),
    ( 'QA', 'Test', NULL, '72657740', 'adrielgo2.mez123@gmail.com', NULL, '914694117', NULL, NULL, 6, 17, 1),
    ( 'Tania', 'Carpio', NULL, '47022917', 'adrielgo3.mez123@gmail.com', NULL, NULL, NULL, NULL, 9, 19, 1),
    ( 'Gerente', 'Legal', NULL, '10000000', 'adrielgo4.mez123@gmail.com', NULL, NULL, NULL, NULL, 33, 3, 1),
    ( 'Jefe', 'Legal', NULL, '11000000', 'adrielgo5.mez123@gmail.com', NULL, NULL, NULL, NULL, 33, 16, 1),
    ( 'Abogado', 'Abogado', NULL, '12000000', 'adrielgo6.mez123@gmail.com', NULL, NULL, NULL, NULL, 33, 34, 1),
    ( 'Director', 'Producto', NULL, '13000000', 'adrielgo7.mez123@gmail.com', NULL, NULL, NULL, NULL, 25, 26, 1),
    ( 'Subgerente', 'Producto', NULL, '14000000', 'adrielgo8.mez123@gmail.com', NULL, NULL, NULL, NULL, 25, 29, 1),
    ( 'Jefe', 'Producto', NULL, '15000000', 'adrielgo9.mez123@gmail.com', NULL, NULL, NULL, NULL, 25, 16, 1),
    ( 'Gerente', 'Producto', NULL, '16000000', 'adrielgo10.mez123@gmail.com', NULL, NULL, NULL, NULL, 25, 3, 1),
    ( 'Contador', 'General', NULL, '17000000', 'adrielgo11.mez123@gmail.com', NULL, NULL, NULL, NULL, 2, 31, 1);

INSERT INTO rol
    (nombre, descripcion, estado)
VALUES
    ('Asesor Comercial', NULL, 1),
    ('at-sistemas', '', 1),
    ('ci-analista', 'Control Interno - Analista', 1),
    ('operaciones-jefe', 'Jefes Comerciales/Operaciones', 1),
    ('operaciones-cajero', 'Cajeros de Tienda', 1),
    ('operaciones-supervisor', 'SOP', 1),
    ('tesoreria-jefe', 'Tesoreria/Jefes', 1),
    ('tesoreria-asistente', 'Tesoreria/Asistentes', 1),
    ('contabilidad-jefe', 'Contabilidad/Jefe', 1),
    ('contabilidad-asistente', 'Contabilidad/Asistente', 1),
    ('ci-auditor', 'Control Interno - Auditor', 1),
    ('ci-jefe', 'Control Interno - Jefe', 1),
    ('ci-auditorjr', 'Control Interno - Auditor Junior', 1),
    ('Soporte-Asistente', 'Asistente de Soporte', 1),
    ('cys-lideres', 'cys lideres ', 1),
    ('Tercero-agentes', 'Soporte/Agentes', 1),
    ('televentas-cajero', 'Permiso para recargas desde gestión', 1),
    ('Agentes - cajero', 'Permisos para cajero', 1),
    ('Televentas-validar', 'validador', 1),
    ('televentas-pagador', 'Pagador', 1),
    ('televentas-supervisor', 'Supervisor teleservicios', 1),
    ('televentas-digitar', 'Digitador', 1),
    ('Legal - municipal', 'Permisos de contratos', 1),
    ('Exp_Cliente', 'AAC', 1),
    ('aac-asesor', 'Permisos de asesor', 1),
    ('Analista-Soporte', 'Analista de Soporte', 1),
    ('televentas-capacitador', 'capacitador ts', 1),
    ('agentes-admin', 'Permiso para administradores.', 1),
    ('agentes-supervisor', 'Permiso para supervisores de agentes', 1),
    ('promotores-tambo', 'Permisos para los promotores de Tambo', 1),
    ('operaciones-subgerente', 'Permisos para el SubGerente Comercial', 1),
    ('teleservicio-cajero-OK', 'Nuevo Perfil Cajero Teleservicios', 1),
    ('mantenimiento-serviciotecnico', 'Técnicos de mantenimiento', 1),
    ('Torito', 'Permisos para contratos - Torito', 1),
    ('televentas-sup-chat', 'Supervisar chats', 1),
    ('teleservicios-controlinterno', 'Prevención de fraude de Teleservicios', 1),
    ('IGH-Contable', 'IGH - Contable', 1),
    ('Legal-full', 'Permisos para Legal', 1),
    ('proyectos-asist', 'Permisos para task manager', 1),
    ('IGH-Tesorería', 'Permisos para el área de tesorería', 1),
    ('IGH-Contable-asist', 'Asistente contable IGH', 1),
    ('Rol_D&D', 'Rol para testear', 1);



INSERT INTO usuario
    (
    username,
    password,
    personal_id,
    rol_id,
    sistema,
    estado,
    password_changed,
    ip_restrict,
    created_at,
    updated_at,
    user_created_id,
    user_updated_id
    )
VALUES

    ('legal.test', '4badaee57fed5610012a296273158f5f', 1, 10, 'intranet+extranet', 1, 1, 1, '2025-02-12 13:50:10', NULL, 1, NULL),
    ('qa.test', '4badaee57fed5610012a296273158f5f', 4, 10, 'intranet+extranet', 1, 1, 1, '2024-09-26 09:55:27', NULL, 1, 4),
    ('tania.carpio', '4badaee57fed5610012a296273158f5f', 9, 1, 'intranet+extranet', 1, 1, 1, '2024-10-01 14:17:42', NULL, 1, 1),
    ('gerente.legal', 'eb65bf2d2cb7eda01000d764afd0d695', 10, 10, 'intranet+extranet', NULL, 1, 0, '2024-12-13 18:46:18', '2024-12-13 18:46:18', NULL, 7),
    ('jefe.legal', '6b1fb404a55c347e8de42a232e2183f5', 11, 10, 'intranet', 1, 1, 1, '2025-01-06 12:55:59', NULL, 7, 7),
    ('abogado.abogado', '9bf6263dc93d0e8102080a8733456c7e', 12, 10, NULL, 1, 0, NULL, '2024-12-13 18:46:18', '2024-12-13 18:46:18', NULL, 7),
    ('director.producto', 'a410aad669b53816d1df5a6c25d6e26d', 10, 10, NULL, 1, 0, NULL, '2024-12-13 18:46:18', '2024-12-13 18:46:18', NULL, 7),
    ('subgerente.producto', '15aef49501a16c24122d24e81bfafcb7', 11, 1, NULL, 1, 0, NULL, '2024-12-13 18:46:18', '2024-12-13 18:46:18', NULL, 7),
    ('jefe.producto', '65eddb5d804084a5e563ad77acb7c122', 11, 10, NULL, 1, 0, NULL, '2024-12-13 18:46:18', '2024-12-13 18:46:18', NULL, 7),
    ('gerente.producto', '6ed33fa677321a166da7f685bc95c5d6', 10, 10, NULL, 1, 0, NULL, '2024-12-13 18:46:18', '2024-12-13 18:46:18', NULL, 7),
    ('contador.general', '4badaee57fed5610012a296273158f5f', 1, 10, 'intranet', 1, 1, 1, '2025-01-22 14:52:28', NULL, 1, 0),
    ('director.administracion', '7a94628d91af604197258c4ad4478543', 2, 10, NULL, 1, 0, NULL, '2024-12-13 18:46:18', '2024-12-13 18:46:18', NULL, 7),
    ('gerente.finanzas', 'f94ae5280483ba3efd147c87353703da', 2, 10, NULL, 1, 0, NULL, '2024-12-13 18:46:18', '2024-12-13 18:46:18', NULL, 7),
    ('anamaria.huaman', 'c7dc6fd3ee8f1c17cf71acc380599577', 3, 10, NULL, 1, 0, NULL, '2024-12-13 18:46:18', '2024-12-13 18:46:18', NULL, 7),
    ('yesseÑa.collantes', '0745dfd45a9555987d3ef22938c393d3', 4, 10, NULL, 1, 0, NULL, '2024-12-13 18:46:18', '2024-12-13 18:46:18', NULL, 7),
    ('anamariaivonne.garate', '0a36c4b233913e80255c799df3c2d724', 5, 10, NULL, 1, 0, NULL, '2024-12-13 18:46:18', '2024-12-13 18:46:18', NULL, 7),
    ('karinarosalba.caycho', 'b484adbeb61bcb711678f927358cd703', 6, 10, NULL, 1, 0, NULL, '2024-12-13 18:46:18', '2024-12-13 18:46:18', NULL, 7),
    ('karlacecilia.torrejon', '31434810d870a78ddca7a62cd1b5f4f1', 7, 10, NULL, 1, 0, NULL, '2024-12-13 18:46:18', '2024-12-13 18:46:18', NULL, 7),
    ('test', 'test', 10, 10, 'intranet', 8, 1, 0, NULL, NULL, NULL, NULL);

INSERT INTO tipo_contrato
    (nombre, descripcion, orden, estado, sigla, user_created_id)
VALUES
    ('Contrato de Arrendamiento', 'Contrato de arrendamiento de bienes muebles o inmuebles.', 1, 1, 'A', 1),
    ('Contrato de Locación de Servicio', 'Contrato de prestación de servicios profesionales o técnicos.', 1, 1, 'LS', 1),
    ('Contrato de Mutuo de Dinero', 'Contrato de préstamo de dinero con devolución pactada.', 1, 1, 'MD', 1),
    ('Contrato de Mandato', 'Contrato mediante el cual una persona confiere poder a otra para actuar en su nombre.', 1, 1, 'M', 1),

    ('Adenda de Arrendamiento', 'Modificación o ampliación del contrato de arrendamiento.', 2, 1, 'AA', 1),
    ('Adenda de Locación de Servicio', 'Modificación o ampliación del contrato de locación de servicio.', 2, 1, 'ALS', 1),
    ('Adenda de Mutuo de Dinero', 'Modificación o ampliación del contrato de mutuo de dinero.', 2, 1, 'AMD', 1),
    ('Adenda de Mandato', 'Modificación o ampliación del contrato de mandato.', 2, 1, 'AM', 1);


INSERT INTO formato_contrato
    (tipo_contrato_id, nombre, version, contenido, estado, user_created_id)
VALUES
    (1, 'Formato Contrato de Arrendamiento', 1, '', 1, 1),
    (2, 'Formato Contrato de Locación de Servicio', 1, '', 1, 1),
    (3, 'Formato Contrato de Mutuo de Dinero', 1, '', 1, 1),
    (4, 'Formato Contrato de Mandato', 1, '', 1, 1),
    (1, 'Formato Contrato de Arrendamiento', 2, '<h2 style="margin-left:0px;text-align:center;"><span style="color:#0f0f0f;font-family:Arial, Helvetica, sans-serif;font-size:18.67px;"><strong><u>CONTRATO DE ARRENDAMIENTO</u></strong>&nbsp;</span></h2><p style="text-align:justify;"><span style="color:#0f0f0f;font-family:Arial, Helvetica, sans-serif;font-size:16px;">Conste por el presente documento el <strong>CONTRATO DE ARRENDAMIENTO</strong> que celebran:&nbsp;</span></p><h2 style="margin-left:0px;"><span style="color:#0f0f0f;font-family:Arial, Helvetica, sans-serif;font-size:16px;"><strong><u>EL ARRENDADOR</u></strong>&nbsp;</span></h2><p style="text-align:justify;"><span style="color:#0f0f0f;font-family:Arial, Helvetica, sans-serif;font-size:16px;">@ARRENDADOR_NOMBRE, identificado con RUC N° @ARRENDADOR_RUC, con domicilio en @ARRENDADOR_DIRECCION, representada por su Gerente General, @ARRENDADOR_NOMBRE_COMPLETO, identificada con DNI Nº @ARRENDADOR_DNI, con poderes inscritos en la Partida Electrónica Nº @ARRENDADOR_PARTIDA_ELECTRONICA del Registro de Personas Jurídicas de @ARRENDADOR_SEDE_PARTIDA_ELECTRONICA&nbsp;, quien en adelante se le denominará “EL ARRENDADOR”.&nbsp;</span></p><h2 style="margin-left:0px;"><span style="color:#0f0f0f;font-family:Arial, Helvetica, sans-serif;font-size:16px;"><strong><u>EL ARRENDATARIO</u></strong>&nbsp;</span></h2><p style="text-align:justify;"><span style="color:#0f0f0f;font-family:Arial, Helvetica, sans-serif;font-size:16px;">@ARRENDATARIO_DENOMINACION_SOCIAL, con RUC N° @ARRENDATARIO_RUC, con domicilio en @ARRENDATARIO_DIRECCION, representada por su Gerente General, @ARRENDATARIO_NOMBRE_COMPLETO, identificada con DNI Nº @ARRENDATARIO_DNI, con poderes inscritos en la Partida Electrónica Nº @ARRENDATARIO_PARTIDA_REGISTRO del Registro de Personas Jurídicas de Lima, a quién en adelante se le denominará "EL ARRENDATARIO".&nbsp;</span></p><h2 style="margin-left:0px;"><span style="color:#0f0f0f;font-family:Arial, Helvetica, sans-serif;font-size:16px;"><strong><u>PRIMERA: DEL INMUEBLE A ARRENDARSE</u></strong>&nbsp;</span></h2><p style="text-align:justify;"><span style="color:#0f0f0f;font-family:Arial, Helvetica, sans-serif;font-size:16px;">EL ARRENDADOR es propietario del siguiente inmueble:&nbsp;</span></p><p style="text-align:justify;"><span style="color:#0f0f0f;font-family:Arial, Helvetica, sans-serif;font-size:16px;">1.1 [DIRECCIÓN, DISTRITO, PROVINCIA Y DEPARTAMENTO], inscrito en la Partida Electrónica N° [XXXXXXX] del Registro de la Predios de [DEPARTAMENTO]. [OBSERVACIONES DE SER EL CASO, POR EJEMPLO, CARGAS].&nbsp;</span></p><h2 style="margin-left:0px;"><span style="color:#0f0f0f;font-family:Arial, Helvetica, sans-serif;font-size:16px;"><strong><u>SEGUNDA: DEL ACUERDO</u></strong>&nbsp;</span></h2><p style="text-align:justify;"><span style="color:#0f0f0f;font-family:Arial, Helvetica, sans-serif;font-size:16px;">Por el presente contrato, EL ARRENDADOR da en arrendamiento a favor de EL ARRENDATARIO el inmueble descrito en la cláusula primera del presente contrato.&nbsp;</span></p><h2 style="margin-left:0px;"><span style="color:#0f0f0f;font-family:Arial, Helvetica, sans-serif;font-size:16px;"><strong><u>TERCERA: DEL PLAZO</u></strong>&nbsp;</span></h2><p style="text-align:justify;"><span style="color:#0f0f0f;font-family:Arial, Helvetica, sans-serif;font-size:16px;">El arrendamiento tendrá una duración de @PLAZO la misma que iniciará el día @FECHA_INICIO y terminará el día @FECHA_FIN. AI vencimiento del plazo del arrendamiento las partes podrán negociar un nuevo contrato de arrendamiento donde establecerán los términos y condiciones aplicables. Al vencimiento del plazo de vigencia del presente contrato, EL ARRENDATARIO deberá entregar el inmueble en condiciones similares a las que recibió, salvo el deterioro que haya resultado del uso ordinario. En aquella oportunidad ambas partes suscribieron un Acta de Entrega en la cual se detalla el estado en que se entrega el inmueble y la recepción del mismo por parte de EL ARRENDADOR a su entera satisfacción.&nbsp;</span></p><h2 style="margin-left:0px;"><span style="color:#0f0f0f;font-family:Arial, Helvetica, sans-serif;font-size:16px;"><strong><u>CUARTA: DE LA RENTA</u></strong>&nbsp;</span></h2><p style="text-align:justify;"><span style="color:#0f0f0f;font-family:Arial, Helvetica, sans-serif;font-size:16px;">Las partes acuerdan fijar en @MONEDA_SIGLA @MONTO ([MONTO EN LETRAS] y 00/100 @MONEDA) mensual, incluido el impuesto a la Renta, por el estacionamiento materia del presente contrato. La renta será pagada por adelantado, dentro de los diez (10) primeros días útiles de cada mes, mediante un depósito bancario en la cuenta que se describe a continuación N° @CUENTA_BANCARIA del @NOMBRE_BANCO, cuenta que corresponde a EL ARRENDADOR. La falta de pago de dos (2) mensualidades dará lugar a la resolución automática del contrato de acuerdo a lo señalado en la cláusula novena. Es suficiente constancia de la recepción del pago a entera satisfacción de EL ARRENDADOR, la firma de ésta al final del presente contrato. EL ARRENDATARIO entregará a EL ARRENDADOR una garantía de [monto en números y letras], que será devuelta al finalizar el contrato, siempre y cuando el inmueble se encuentre en las mismas condiciones en que fue recibido, salvo el deterioro producto del uso ordinario.&nbsp;</span></p><p style="text-align:justify;">&nbsp;</p><p style="text-align:justify;">&nbsp;</p><p style="text-align:justify;">&nbsp;</p><p style="text-align:justify;">&nbsp;</p><p style="text-align:justify;">&nbsp;</p><p style="text-align:justify;">&nbsp;</p><h2 style="margin-left:0px;"><span style="color:#0f0f0f;font-family:Arial, Helvetica, sans-serif;font-size:16px;"><strong><u>QUINTA: DE LA CONDICIÓN, DEL DESTINO Y DE LAS MEJORAS INTRODUCIDAS AL INMUEBLE</u></strong>&nbsp;</span></h2><p style="text-align:justify;"><span style="color:#0f0f0f;font-family:Arial, Helvetica, sans-serif;font-size:16px;">EL ARRENDADOR entrega a EL ARRENDATARIO el inmueble materia de arrendamiento en buen estado. El inmueble arrendado será destinado a [XXXXXXX].&nbsp;</span></p><h2 style="margin-left:0px;"><span style="color:#0f0f0f;font-family:Arial, Helvetica, sans-serif;font-size:16px;"><strong><u>SEXTA: DE LOS SERVICIOS Y ARBITRIOS MUNICIPALES</u></strong>&nbsp;</span></h2><p style="text-align:justify;"><span style="color:#0f0f0f;font-family:Arial, Helvetica, sans-serif;font-size:16px;">Serán de cargo exclusivo de EL ARRENDATARIO el pago de los servicios de mantenimiento, así como el pago de los arbitrios municipales creados a por crearse que correspondan al arrendatario de un inmueble, con excepción del impuesto Predial que correrá por cuenta de EL ARRENDADOR.&nbsp;</span></p><h2 style="margin-left:0px;"><span style="color:#0f0f0f;font-family:Arial, Helvetica, sans-serif;font-size:16px;"><strong><u>SETIMA: DE LA PROHIBICIÓN DE SUBARRENDAR O CEDER</u></strong>&nbsp;</span></h2><p style="text-align:justify;"><span style="color:#0f0f0f;font-family:Arial, Helvetica, sans-serif;font-size:16px;">EL ARRENDATARIO no podrá subarrendar, ceder, ni traspasar en todo o en parte los bienes arrendados, sin autorización previa y por escrito de EL ARRENDADOR.&nbsp;</span></p><h2 style="margin-left:0px;"><span style="color:#0f0f0f;font-family:Arial, Helvetica, sans-serif;font-size:16px;"><u>OCTAVA: DE LA TERMINACION ANTICIPADA</u>&nbsp;</span></h2><p style="text-align:justify;"><span style="color:#0f0f0f;font-family:Arial, Helvetica, sans-serif;font-size:16px;">Sin perjuicio de lo señalado en la cláusula tercera, cualesquiera de las partes contratantes podrán dar por terminado el presente contrato en cualquier momento y sin justificación alguna, mediante aviso previo con sesenta (60) días calendario de anticipación. Se deja expresa constancia que las partes renuncian en forma expresa a cualquier reclamo futuro que puedan hacerse desde la fecha en que se nace efectiva la desocupación y la terminación del período anual o del plazo contractual.&nbsp;</span></p><h2 style="margin-left:0px;"><span style="color:#0f0f0f;font-family:Arial, Helvetica, sans-serif;font-size:16px;"><u>NOVENA: DE LA RESOLUCIÓN DEL CONTRATO</u>&nbsp;</span></h2><p style="text-align:justify;"><span style="color:#0f0f0f;font-family:Arial, Helvetica, sans-serif;font-size:16px;">El incumplimiento de cualquiera de las obligaciones establecidas en el presente contrato constituirá causal de resolución al amparo del artículo 1430º del Código Civil Peruano. En consecuencia, la resolución se producirá de pleno derecho bastando para ello una comunicación vía carta notarial.&nbsp;</span></p><h2 style="margin-left:0px;"><span style="color:#0f0f0f;font-family:Arial, Helvetica, sans-serif;font-size:16px;"><u>DECIMA: DE LA COMPETENCIA JURISDICCIONAL</u>&nbsp;</span></h2><p style="text-align:justify;"><span style="color:#0f0f0f;font-family:Arial, Helvetica, sans-serif;font-size:16px;">Para efectos de cualquier controversia que se genere con motivo de la celebración y ejecución de este contrato, las partes se someten a la competencia territorial de los jueces y tribunales de la ciudad de Lima.&nbsp;</span></p><h2 style="margin-left:0px;"><span style="color:#0f0f0f;font-family:Arial, Helvetica, sans-serif;font-size:16px;"><u>DECIMA PRIMERA: DE LOS DOMICILIOS</u>&nbsp;</span></h2><p style="text-align:justify;"><span style="color:#0f0f0f;font-family:Arial, Helvetica, sans-serif;font-size:16px;">Todas las comunicaciones y notificaciones que deban transmitirse las partes entre sí, con motivo de la ejecución de este contrato, serán efectuadas a los domicilios indicados en la introducción de este documento. El cambio de domicilio de cualquiera de las partes surtirá efecto a partir del primer día de efectuada la comunicación correspondiente a la otra parte, por cualquier medio escrito con cargo de recepción.&nbsp;</span></p><h2 style="margin-left:0px;"><span style="color:#0f0f0f;font-family:Arial, Helvetica, sans-serif;font-size:16px;"><u>DECIMA SEGUNDA: DE LAS NORMAS SUPLETORIAS</u>&nbsp;</span></h2><p style="text-align:justify;"><span style="color:#0f0f0f;font-family:Arial, Helvetica, sans-serif;font-size:16px;">En lo no previsto en el presente contrato, ambas partes se someten a lo establecido en los artículos 1666 y siguientes del Código Civil, así como en las demás normas aplicables.&nbsp;</span></p><h2 style="margin-left:0px;"><span style="color:#0f0f0f;font-family:Arial, Helvetica, sans-serif;font-size:16px;"><u>DECIMA TERCERA: DE LA CLÁUSULA DE ALLANAMIENTO FUTURO</u>&nbsp;</span></h2><p style="text-align:justify;"><span style="color:#0f0f0f;font-family:Arial, Helvetica, sans-serif;font-size:16px;">Las partes declaran que EL ARRENDATARIO se somete a la cláusula de allanamiento a futuro, prevista en el artículo 594 del Código Procesal Civil. En consecuencia, en caso de incurrir en más de dos meses y quince días de incumplimiento en el pago de la renta convenida o de haberse concluido el plazo del contrato, EL ARRENDATARIO deberá desocupar y restituir inmediatamente el bien a EL ARRENDADOR, conforme a los términos del mencionado artículo. En ese sentido, EL ARRENDATARIO se compromete a contradecir dicha demanda sólo si ha pagado las rentas convenidas o el contrato aún sigue vigente.&nbsp;</span></p><p><span style="color:#0f0f0f;font-family:Arial, Helvetica, sans-serif;font-size:16px;">[Fecha]&nbsp;</span></p><p style="text-align:center;">&nbsp;</p><p style="text-align:center;">&nbsp;</p><p style="text-align:center;">&nbsp;</p><p style="text-align:center;"><span style="color:#0f0f0f;font-family:Arial, Helvetica, sans-serif;font-size:12px;"><strong>EL ARRENDADOR &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; EL ARRENDATARIO&nbsp;</strong></span></p>', 1, 1);


INSERT INTO etapa_contrato
    (nombre, descripcion, orden, descripcion_orden, area_id, estado)
VALUES
    ('Pendiente', 'El contrato ha sido creado y está en espera de revisión.', 1, 'Primera etapa', NULL, 1),
    ('En revisión', 'Se está evaluando el contrato.', 2, 'Segunda etapa', NULL, 1),
    ('Observado', 'Se han encontrado observaciones y debe corregirse.', 3, 'Tercera etapa', NULL, 1),
    ('Aprobado - Listo para firma', 'El contrato ha sido aprobado, pero aún no firmado.', 4, 'Cuarta etapa', NULL, 1),
    ('Firmado', 'El contrato ha sido firmado por todas las partes.', 5, 'Quinta etapa', NULL, 1),
    ('Cerrado', 'El proceso del contrato ha concluido correctamente.', 6, 'Sexta etapa', NULL, 1),
    ('Rechazado', 'El contrato ha sido rechazado y no continuará.', 7, 'Séptima etapa', NULL, 1);