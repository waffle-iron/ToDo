CREATE DEFINER=`root`@`localhost` PROCEDURE `persona_consulta`(IN CUIL_IN BIGINT)
BEGIN
	if CUIL_IN is not null then
		select * from persona where CUIL = CUIL_IN;
	else
		select * from persona;
	end if;
END