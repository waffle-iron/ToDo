CREATE DEFINER=`root`@`localhost` PROCEDURE `persona_editar`(
IN CUIL_IN BIGINT,
IN Nombre_IN varchar(256),
IN Apellido_IN varchar(256),
IN Mail_IN varchar(256)
)
BEGIN
	UPDATE persona 
    SET  
		nombre = Nombre_IN,
		apellido = Apellido_IN,
		mail = Mail_IN
    WHERE CUIL = CUIL_IN;
END