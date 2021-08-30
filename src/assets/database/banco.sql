-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 30-08-2021 a las 02:17:06
-- Versión del servidor: 5.7.31
-- Versión de PHP: 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `banco`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cuenta`
--

DROP TABLE IF EXISTS `cuenta`;
CREATE TABLE IF NOT EXISTS `cuenta` (
  `ncuenta` int(11) NOT NULL AUTO_INCREMENT,
  `usuario` int(11) NOT NULL,
  `monto` double NOT NULL,
  `estado` varchar(10) NOT NULL,
  PRIMARY KEY (`ncuenta`)
) ENGINE=MyISAM AUTO_INCREMENT=1003 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `cuenta`
--

INSERT INTO `cuenta` (`ncuenta`, `usuario`, `monto`, `estado`) VALUES
(1000, 1000760127, 98910, 'Activa'),
(1001, 1000760127, 85090, 'Activa'),
(1002, 6784456, 166000, 'Activa');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `terceros`
--

DROP TABLE IF EXISTS `terceros`;
CREATE TABLE IF NOT EXISTS `terceros` (
  `cedula` int(11) NOT NULL,
  `ncuenta` int(11) NOT NULL,
  PRIMARY KEY (`cedula`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `terceros`
--

INSERT INTO `terceros` (`cedula`, `ncuenta`) VALUES
(1000760127, 1002);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `transaccion`
--

DROP TABLE IF EXISTS `transaccion`;
CREATE TABLE IF NOT EXISTS `transaccion` (
  `ntransaccion` int(11) NOT NULL AUTO_INCREMENT,
  `corigen` int(11) NOT NULL,
  `monto` double NOT NULL,
  `cdestino` int(11) NOT NULL,
  `fecha_hora` datetime NOT NULL,
  PRIMARY KEY (`ntransaccion`)
) ENGINE=MyISAM AUTO_INCREMENT=1006 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `transaccion`
--

INSERT INTO `transaccion` (`ntransaccion`, `corigen`, `monto`, `cdestino`, `fecha_hora`) VALUES
(1000, 1000, 15, 1001, '2021-08-29 19:00:15'),
(1001, 1000, 15, 1001, '2021-08-29 19:01:40'),
(1002, 1000, 15, 1001, '2021-08-29 19:13:26'),
(1003, 1000, 15, 1001, '2021-08-29 19:13:51'),
(1004, 1001, 15000, 1002, '2021-08-29 19:40:28'),
(1005, 1000, 1000, 1002, '2021-08-29 19:41:08');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

DROP TABLE IF EXISTS `usuario`;
CREATE TABLE IF NOT EXISTS `usuario` (
  `cedula` bigint(20) NOT NULL,
  `nombres` varchar(50) NOT NULL,
  `apellidos` varchar(50) NOT NULL,
  `clave` varchar(256) NOT NULL,
  PRIMARY KEY (`cedula`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`cedula`, `nombres`, `apellidos`, `clave`) VALUES
(1000760127, 'David Fernando', 'Castrillón Polo', '$2y$12$oPrVYUVTlItaVvod95Rj7.cvz2v3tRyOmKp2iyVZiDV2WYRarZJ/y');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
