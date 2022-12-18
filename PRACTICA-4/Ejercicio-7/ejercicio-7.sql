-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 16-12-2022 a las 01:25:08
-- Versión del servidor: 10.4.27-MariaDB
-- Versión de PHP: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `ejercicio-7`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `equipo`
--

CREATE TABLE `equipo` (
  `nombreEquipo` varchar(255) NOT NULL,
  `puntos` int(11) NOT NULL,
  `pais` varchar(255) NOT NULL,
  `nombreTorneo` varchar(255) NOT NULL,
  `nombrePatro` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `equipo`
--

INSERT INTO `equipo` (`nombreEquipo`, `puntos`, `pais`, `nombreTorneo`, `nombrePatro`) VALUES
('Boston Celtics', 3, 'EEUU', 'NBA', 'Seat'),
('Chicago Bulls', 24, 'EEUU', 'NBA', 'ColaCola'),
('FCBarcelona', 40, 'España', 'Liga Santander', 'Spotify'),
('Los Angeles Lakers', 36, 'EEUU', 'NBA', 'FlyEmirates'),
('Miami Heats', 18, 'EEUU', 'NBA', 'ColaCola'),
('Real Madrid', 57, 'España', 'Liga Santander', 'FlyEmirates');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `jugador`
--

CREATE TABLE `jugador` (
  `id` varchar(255) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `apellidos` varchar(255) NOT NULL,
  `anotaciones` int(11) NOT NULL,
  `nombreEquipo` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `jugador`
--

INSERT INTO `jugador` (`id`, `nombre`, `apellidos`, `anotaciones`, `nombreEquipo`) VALUES
('1', 'Lionel', 'Messi', 30, 'FCBarcelona'),
('2', 'Cristiano', 'Ronaldo', 22, 'Real Madrid'),
('3', 'Pau', 'Gasol', 190, 'Los Angeles Lakers'),
('4', 'J.', 'Tatum', 78, 'Boston Celtics'),
('5', 'D.', 'DeRozan', 98, 'Chicago Bulls');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `partido`
--

CREATE TABLE `partido` (
  `equipoLocal` varchar(255) NOT NULL,
  `equipoVisitante` varchar(255) NOT NULL,
  `resultado` varchar(255) NOT NULL,
  `fecha` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `partido`
--

INSERT INTO `partido` (`equipoLocal`, `equipoVisitante`, `resultado`, `fecha`) VALUES
('Boston Celtics', 'Chicago Bulls', '65-88', '2022-11-01'),
('FCBarcelona', 'Real Madrid', '1-1', '2022-12-12'),
('Los Angeles Lakers', 'Boston Celtics', '126-112', '2022-09-10'),
('Miami Heats', 'Boston Celtics', '88-96', '2022-10-01'),
('Miami Heats', 'Los Angeles Lakers', '101-130', '2022-10-15'),
('Real Madrid', 'FCBarcelona', '2-1', '2023-03-24');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `patrocinador`
--

CREATE TABLE `patrocinador` (
  `nombreEmpresa` varchar(255) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `paisFacturacion` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `patrocinador`
--

INSERT INTO `patrocinador` (`nombreEmpresa`, `cantidad`, `paisFacturacion`) VALUES
('ColaCola', 100000, 'EEUU'),
('FlyEmirates', 9999999, 'Qatar'),
('Seat', 5000, 'España'),
('Spotify', 500000, 'Bélgica');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `torneo`
--

CREATE TABLE `torneo` (
  `nombreTorneo` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `torneo`
--

INSERT INTO `torneo` (`nombreTorneo`) VALUES
('Champions League'),
('Liga Santander'),
('NBA');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `equipo`
--
ALTER TABLE `equipo`
  ADD PRIMARY KEY (`nombreEquipo`),
  ADD KEY `fk_equipo_torneo` (`nombreTorneo`),
  ADD KEY `fk_equipo_patrocinador` (`nombrePatro`);

--
-- Indices de la tabla `jugador`
--
ALTER TABLE `jugador`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_equipo_jugador` (`nombreEquipo`);

--
-- Indices de la tabla `partido`
--
ALTER TABLE `partido`
  ADD PRIMARY KEY (`equipoLocal`,`equipoVisitante`),
  ADD KEY `fk_equipoL` (`equipoLocal`),
  ADD KEY `fk_equipoV` (`equipoVisitante`);

--
-- Indices de la tabla `patrocinador`
--
ALTER TABLE `patrocinador`
  ADD PRIMARY KEY (`nombreEmpresa`);

--
-- Indices de la tabla `torneo`
--
ALTER TABLE `torneo`
  ADD PRIMARY KEY (`nombreTorneo`);

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `equipo`
--
ALTER TABLE `equipo`
  ADD CONSTRAINT `fk_equipo_patrocinador` FOREIGN KEY (`nombrePatro`) REFERENCES `patrocinador` (`nombreEmpresa`),
  ADD CONSTRAINT `fk_equipo_torneo` FOREIGN KEY (`nombreTorneo`) REFERENCES `torneo` (`nombreTorneo`);

--
-- Filtros para la tabla `jugador`
--
ALTER TABLE `jugador`
  ADD CONSTRAINT `fk_equipo_jugador` FOREIGN KEY (`nombreEquipo`) REFERENCES `equipo` (`nombreEquipo`);

--
-- Filtros para la tabla `partido`
--
ALTER TABLE `partido`
  ADD CONSTRAINT `fk_equipoL` FOREIGN KEY (`equipoLocal`) REFERENCES `equipo` (`nombreEquipo`),
  ADD CONSTRAINT `fk_equipoV` FOREIGN KEY (`equipoVisitante`) REFERENCES `equipo` (`nombreEquipo`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
