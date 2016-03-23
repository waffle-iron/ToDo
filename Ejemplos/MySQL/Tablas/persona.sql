CREATE TABLE `persona` (
  `CUIL` bigint(20) NOT NULL,
  `Nombre` varchar(256) COLLATE latin1_general_ci NOT NULL,
  `Apellido` varchar(256) COLLATE latin1_general_ci NOT NULL,
  `Mail` varchar(256) COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`CUIL`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;
