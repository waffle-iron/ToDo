CREATE TABLE `persona` (
  `cuil` bigint(20) NOT NULL,
  `nombre` varchar(256) COLLATE latin1_general_ci NOT NULL,
  `apellido` varchar(256) COLLATE latin1_general_ci NOT NULL,
  `mail` varchar(256) COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`CUIL`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;
