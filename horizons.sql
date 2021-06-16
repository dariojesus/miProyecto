-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 15-06-2021 a las 20:54:12
-- Versión del servidor: 10.4.17-MariaDB
-- Versión de PHP: 8.0.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `horizons`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `billetes`
--

CREATE TABLE `billetes` (
  `cod_billete` int(11) NOT NULL,
  `cod_clase` int(11) NOT NULL,
  `borrado` tinyint(1) NOT NULL DEFAULT 0,
  `cod_vuelo` int(11) NOT NULL,
  `cod_perfil` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `billetes`
--

INSERT INTO `billetes` (`cod_billete`, `cod_clase`, `borrado`, `cod_vuelo`, `cod_perfil`) VALUES
(20, 1, 0, 26, 6),
(21, 2, 0, 25, 6),
(22, 1, 0, 28, 1),
(23, 2, 0, 33, 6);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clases`
--

CREATE TABLE `clases` (
  `cod_clase` int(11) NOT NULL,
  `nombre` varchar(30) COLLATE utf8_spanish2_ci NOT NULL,
  `nombre_en` varchar(50) COLLATE utf8_spanish2_ci NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `caracteristicas` varchar(100) COLLATE utf8_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `clases`
--

INSERT INTO `clases` (`cod_clase`, `nombre`, `nombre_en`, `precio`, `caracteristicas`) VALUES
(1, 'Básica', 'Basic', '699.95', 'Viaje estandar, hibernación simple con estancia normal.'),
(2, 'Preferente', 'Premium', '1399.95', 'Viaje de lujo, hibernación suave con estancia doble.');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `destinos`
--

CREATE TABLE `destinos` (
  `cod_destino` int(11) NOT NULL,
  `nombre` varchar(30) COLLATE utf8_spanish2_ci NOT NULL,
  `nombre_en` varchar(50) COLLATE utf8_spanish2_ci NOT NULL,
  `descripcion` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  `descripcion_en` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  `duracion_viaje` int(11) NOT NULL,
  `clima` varchar(30) COLLATE utf8_spanish2_ci NOT NULL,
  `clima_en` varchar(30) COLLATE utf8_spanish2_ci NOT NULL,
  `foto` varchar(100) COLLATE utf8_spanish2_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `destinos`
--

INSERT INTO `destinos` (`cod_destino`, `nombre`, `nombre_en`, `descripcion`, `descripcion_en`, `duracion_viaje`, `clima`, `clima_en`, `foto`) VALUES
(1, 'Luna', 'Moon', 'Nuestro satélite más cercano, llévate una roca lunar, explora los lagos subterraneos.', 'Our nearest satelite, get a moon\'s rock, explore the undeground lakes.', 9, 'Frío', 'Cold', '/imagenes/luna.jpg'),
(2, 'Marte', 'Mars', 'Descubre el planeta rojo y sus increibles acantilados, tormentas solares aseguradas.', 'Discover the red planet and his incredible clifss, solar storms insured.', 150, 'Desertico', 'Warm', '/imagenes/marte.jpg'),
(3, 'Urano', 'Uranus', 'Ven a visitar nuestras granjas hidropónicas submarinas, descubre nuestra biodiversidad submarina.', 'Come to visit our hydroponic underwater famrs, discover a vast submarine biodiversity.', 352, 'Húmedo', 'Wet', '/imagenes/urano.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `perfiles`
--

CREATE TABLE `perfiles` (
  `cod_perfil` int(11) NOT NULL,
  `email` varchar(50) COLLATE utf8_spanish2_ci NOT NULL,
  `nombre` varchar(30) COLLATE utf8_spanish2_ci NOT NULL,
  `apellidos` varchar(50) COLLATE utf8_spanish2_ci NOT NULL,
  `nif` varchar(10) COLLATE utf8_spanish2_ci NOT NULL,
  `fecha_nacimiento` date NOT NULL,
  `direccion` varchar(50) COLLATE utf8_spanish2_ci NOT NULL,
  `poblacion` varchar(50) COLLATE utf8_spanish2_ci NOT NULL,
  `borrado` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `perfiles`
--

INSERT INTO `perfiles` (`cod_perfil`, `email`, `nombre`, `apellidos`, `nif`, `fecha_nacimiento`, `direccion`, `poblacion`, `borrado`) VALUES
(1, 'dariojesusflores@gmail.com', 'Dario', 'Flores', '12345678D', '1997-07-18', 'Merecillas', 'Antequera', 0),
(6, 'asdf@gmail.com', 'Cliente', 'Primero', '11111111A', '1995-05-15', 'Mancilla n6', 'Antequera', 0),
(7, 'ffff@gmail.com', 'Cliente', 'Borrado', '22222222A', '1997-05-17', 'Inventada n25', 'Mollina', 1),
(8, 'ggg@gmail.com', 'Admin', 'Jefe', '11111111B', '1985-05-25', 'Arpitaste', 'Granada', 0),
(9, 'jejej@gmail.com', 'Gestor', 'Jefe', '22222222B', '1975-05-15', 'Imaginada n8', 'Cordoba', 0),
(10, 'innn@gmail.com', 'Gestor', 'Normal', '11111111C', '1980-07-18', 'Gran via n12', 'Sevilla', 0);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `perfiles_vuelos`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `perfiles_vuelos` (
`nif` varchar(10)
,`nombre_completo` varchar(81)
,`borrado` tinyint(1)
,`codigo` int(11)
,`fecha_salida` date
,`hora_salida` time
,`compannia` varchar(30)
,`clase` varchar(30)
,`clase_en` varchar(50)
,`precio` decimal(10,2)
,`destino` varchar(30)
,`destino_en` varchar(50)
,`duracion_viaje` int(11)
);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `cod_rol` int(11) NOT NULL,
  `nombre_rol` varchar(30) COLLATE utf8_spanish2_ci NOT NULL,
  `permiso1` tinyint(1) NOT NULL DEFAULT 0,
  `permiso2` tinyint(1) NOT NULL DEFAULT 0,
  `permiso3` tinyint(1) NOT NULL DEFAULT 0,
  `permiso4` tinyint(1) NOT NULL DEFAULT 0,
  `permiso5` tinyint(1) NOT NULL DEFAULT 0,
  `permiso6` tinyint(1) NOT NULL DEFAULT 0,
  `permiso7` tinyint(1) NOT NULL DEFAULT 0,
  `permiso8` tinyint(1) NOT NULL DEFAULT 0,
  `permiso9` tinyint(1) NOT NULL DEFAULT 0,
  `permiso10` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`cod_rol`, `nombre_rol`, `permiso1`, `permiso2`, `permiso3`, `permiso4`, `permiso5`, `permiso6`, `permiso7`, `permiso8`, `permiso9`, `permiso10`) VALUES
(1, 'Cliente', 1, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(2, 'Gestor', 1, 1, 0, 0, 0, 0, 0, 0, 0, 0),
(3, 'Gestor Jefe', 1, 1, 1, 0, 0, 0, 0, 0, 0, 0),
(4, 'Admin', 1, 1, 1, 1, 0, 0, 0, 0, 0, 0),
(5, 'Admin (root)', 1, 1, 1, 1, 1, 0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `cod_usuario` int(11) NOT NULL,
  `nif` varchar(10) COLLATE utf8_spanish2_ci NOT NULL,
  `contrasenna` varchar(50) COLLATE utf8_spanish2_ci NOT NULL,
  `borrado` tinyint(1) NOT NULL DEFAULT 0,
  `cod_rol` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`cod_usuario`, `nif`, `contrasenna`, `borrado`, `cod_rol`) VALUES
(1, '12345678D', '0e7cf765ac3483574879f579c5a9c262', 0, 5),
(6, '11111111A', '430accd1483a8957a6f253165818e4a9', 0, 1),
(7, '22222222A', '430accd1483a8957a6f253165818e4a9', 1, 1),
(8, '11111111B', '7550bff57058e76f38bbebc3fad5d8ac', 0, 4),
(9, '22222222B', '7550bff57058e76f38bbebc3fad5d8ac', 0, 3),
(10, '11111111C', '430accd1483a8957a6f253165818e4a9', 0, 2);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `usuarios_roles`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `usuarios_roles` (
`cod_usuario` int(11)
,`nif` varchar(10)
,`borrado` tinyint(1)
,`cod_rol` int(11)
,`nombre_rol` varchar(30)
,`permiso1` tinyint(1)
,`permiso2` tinyint(1)
,`permiso3` tinyint(1)
,`permiso4` tinyint(1)
,`permiso5` tinyint(1)
,`permiso6` tinyint(1)
,`permiso7` tinyint(1)
,`permiso8` tinyint(1)
,`permiso9` tinyint(1)
,`permiso10` tinyint(1)
);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vuelos`
--

CREATE TABLE `vuelos` (
  `cod_vuelo` int(11) NOT NULL,
  `fecha_salida` date NOT NULL,
  `hora_salida` time NOT NULL,
  `fecha_llegada` date NOT NULL,
  `hora_llegada` time NOT NULL,
  `compannia` varchar(30) COLLATE utf8_spanish2_ci NOT NULL,
  `plazas` int(11) NOT NULL,
  `borrado` tinyint(4) NOT NULL DEFAULT 0,
  `cod_destino` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `vuelos`
--

INSERT INTO `vuelos` (`cod_vuelo`, `fecha_salida`, `hora_salida`, `fecha_llegada`, `hora_llegada`, `compannia`, `plazas`, `borrado`, `cod_destino`) VALUES
(25, '2022-08-18', '16:00:00', '2022-08-19', '15:00:00', 'NASA', 9, 0, 1),
(26, '2021-01-01', '14:00:00', '2021-01-03', '16:00:00', 'NASA', 11, 0, 1),
(27, '2021-09-18', '18:00:00', '2021-09-19', '19:00:00', 'Spacex', 4, 0, 2),
(28, '2021-06-11', '21:00:00', '2021-06-13', '15:00:00', 'HyperLoop', 14, 0, 2),
(29, '2021-06-19', '18:15:00', '2021-06-20', '14:12:00', 'NASA', 3, 0, 3),
(30, '2022-07-18', '22:00:00', '2022-07-20', '11:00:00', 'HyperX', 12, 0, 1),
(31, '2021-09-30', '15:15:00', '2021-10-02', '14:00:00', 'Spacex', 21, 0, 1),
(32, '2021-08-15', '18:00:00', '2021-08-18', '19:00:00', 'NASA', 40, 0, 1),
(33, '2021-06-17', '10:30:00', '2021-06-18', '19:00:00', 'Spacex', 9, 0, 1),
(34, '2021-07-25', '21:00:00', '2021-07-29', '09:00:00', 'HyperLoop', 12, 0, 1),
(35, '2021-12-12', '12:00:00', '2021-12-15', '13:00:00', 'NASA', 40, 0, 1);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vuelos_destinos`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vuelos_destinos` (
`cod_vuelo` int(11)
,`fecha_salida` date
,`hora_salida` time
,`compannia` varchar(30)
,`plazas` int(11)
,`borrado` tinyint(4)
,`nombre` varchar(30)
,`nombre_en` varchar(50)
,`descripcion` varchar(100)
,`duracion_viaje` int(11)
,`clima` varchar(30)
);

-- --------------------------------------------------------

--
-- Estructura para la vista `perfiles_vuelos`
--
DROP TABLE IF EXISTS `perfiles_vuelos`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `perfiles_vuelos`  AS SELECT `perfiles`.`nif` AS `nif`, concat(`perfiles`.`nombre`,' ',`perfiles`.`apellidos`) AS `nombre_completo`, `billetes`.`borrado` AS `borrado`, `billetes`.`cod_billete` AS `codigo`, `vuelos`.`fecha_salida` AS `fecha_salida`, `vuelos`.`hora_salida` AS `hora_salida`, `vuelos`.`compannia` AS `compannia`, `clases`.`nombre` AS `clase`, `clases`.`nombre_en` AS `clase_en`, `clases`.`precio` AS `precio`, `destinos`.`nombre` AS `destino`, `destinos`.`nombre_en` AS `destino_en`, `destinos`.`duracion_viaje` AS `duracion_viaje` FROM ((((`perfiles` join `billetes` on(`perfiles`.`cod_perfil` = `billetes`.`cod_perfil`)) join `clases` on(`billetes`.`cod_clase` = `clases`.`cod_clase`)) join `vuelos` on(`billetes`.`cod_vuelo` = `vuelos`.`cod_vuelo`)) join `destinos` on(`vuelos`.`cod_destino` = `destinos`.`cod_destino`)) ;

-- --------------------------------------------------------

--
-- Estructura para la vista `usuarios_roles`
--
DROP TABLE IF EXISTS `usuarios_roles`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `usuarios_roles`  AS SELECT `usuarios`.`cod_usuario` AS `cod_usuario`, `usuarios`.`nif` AS `nif`, `usuarios`.`borrado` AS `borrado`, `roles`.`cod_rol` AS `cod_rol`, `roles`.`nombre_rol` AS `nombre_rol`, `roles`.`permiso1` AS `permiso1`, `roles`.`permiso2` AS `permiso2`, `roles`.`permiso3` AS `permiso3`, `roles`.`permiso4` AS `permiso4`, `roles`.`permiso5` AS `permiso5`, `roles`.`permiso6` AS `permiso6`, `roles`.`permiso7` AS `permiso7`, `roles`.`permiso8` AS `permiso8`, `roles`.`permiso9` AS `permiso9`, `roles`.`permiso10` AS `permiso10` FROM (`usuarios` join `roles` on(`usuarios`.`cod_rol` = `roles`.`cod_rol`)) ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vuelos_destinos`
--
DROP TABLE IF EXISTS `vuelos_destinos`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vuelos_destinos`  AS SELECT `vuelos`.`cod_vuelo` AS `cod_vuelo`, `vuelos`.`fecha_salida` AS `fecha_salida`, `vuelos`.`hora_salida` AS `hora_salida`, `vuelos`.`compannia` AS `compannia`, `vuelos`.`plazas` AS `plazas`, `vuelos`.`borrado` AS `borrado`, `destinos`.`nombre` AS `nombre`, `destinos`.`nombre_en` AS `nombre_en`, `destinos`.`descripcion` AS `descripcion`, `destinos`.`duracion_viaje` AS `duracion_viaje`, `destinos`.`clima` AS `clima` FROM (`vuelos` join `destinos` on(`vuelos`.`cod_destino` = `destinos`.`cod_destino`)) ;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `billetes`
--
ALTER TABLE `billetes`
  ADD PRIMARY KEY (`cod_billete`);

--
-- Indices de la tabla `clases`
--
ALTER TABLE `clases`
  ADD PRIMARY KEY (`cod_clase`);

--
-- Indices de la tabla `destinos`
--
ALTER TABLE `destinos`
  ADD PRIMARY KEY (`cod_destino`),
  ADD UNIQUE KEY `UQ_NOMBRE_DESTINOS` (`nombre`);

--
-- Indices de la tabla `perfiles`
--
ALTER TABLE `perfiles`
  ADD PRIMARY KEY (`cod_perfil`),
  ADD UNIQUE KEY `UQ_EMAIL_PERFILES` (`email`),
  ADD UNIQUE KEY `UQ_NIF_PERFILES` (`nif`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`cod_rol`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`cod_usuario`),
  ADD UNIQUE KEY `UQ_NIF_USUARIOS` (`nif`);

--
-- Indices de la tabla `vuelos`
--
ALTER TABLE `vuelos`
  ADD PRIMARY KEY (`cod_vuelo`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `billetes`
--
ALTER TABLE `billetes`
  MODIFY `cod_billete` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT de la tabla `clases`
--
ALTER TABLE `clases`
  MODIFY `cod_clase` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `destinos`
--
ALTER TABLE `destinos`
  MODIFY `cod_destino` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `perfiles`
--
ALTER TABLE `perfiles`
  MODIFY `cod_perfil` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `cod_rol` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `cod_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `vuelos`
--
ALTER TABLE `vuelos`
  MODIFY `cod_vuelo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
