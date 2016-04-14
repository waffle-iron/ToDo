CREATE DEFINER=`root`@`localhost` PROCEDURE `persona_baja`(IN CUIL_IN bigint)
BEGIN
	DELETE FROM persona WHERE cuil = CUIL_IN;
END