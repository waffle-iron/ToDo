CREATE DEFINER=`root`@`localhost` PROCEDURE `persona_alta`(
IN CUIL_IN BIGINT,
IN Nombre_IN varchar(256),
IN Apellido_IN varchar(256),
IN Mail_IN varchar(256)
)
BEGIN
	insert into persona (CUIL, Nombre, Apellido, Mail) values (CUIL_IN, Nombre_IN, Apellido_IN, Mail_IN);
END