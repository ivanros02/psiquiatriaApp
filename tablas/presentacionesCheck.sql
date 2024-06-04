-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 18-03-2024 a las 10:58:23
-- Versión del servidor: 10.6.17-MariaDB-cll-lve-log
-- Versión de PHP: 8.1.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `terapial_terapia`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `presentacionesCheck`
--

CREATE TABLE `presentacionesCheck` (
  `id` int(11) NOT NULL,
  `rutaImagen` varchar(200) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `titulo` varchar(100) NOT NULL,
  `matricula` int(100) NOT NULL,
  `matriculaP` int(255) NOT NULL,
  `especialidad` varchar(100) NOT NULL,
  `descripcion` varchar(1000) NOT NULL,
  `telefono` int(50) NOT NULL,
  `disponibilidad` int(11) NOT NULL,
  `valor` int(255) NOT NULL,
  `mail` varchar(255) NOT NULL,
  `whatsapp` int(255) NOT NULL,
  `instagram` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `presentacionesCheck`
--
ALTER TABLE `presentacionesCheck`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `presentacionesCheck`
--
ALTER TABLE `presentacionesCheck`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
