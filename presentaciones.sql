-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 17-01-2024 a las 01:18:32
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `comentariosphp`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `presentaciones`
--

CREATE TABLE `presentaciones` (
  `id` int(11) NOT NULL,
  `rutaImagen` varchar(200) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `titulo` varchar(100) NOT NULL,
  `matricula` int(100) NOT NULL,
  `especialidad` varchar(100) NOT NULL,
  `descripcion` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `presentaciones`
--

INSERT INTO `presentaciones` (`id`, `rutaImagen`, `nombre`, `titulo`, `matricula`, `especialidad`, `descripcion`) VALUES
(1, '../img/modelo.jpg', 'Lic. Ana Maria Pinto', 'Lic. en Psicología Terapia Psicoanalitica', 46489, 'Ansiedad y estrés. Separación o desarraigo familiar. Sexualidad. Duelo. Problemas vinculares.', 'No existen recetas ni soluciones mágicas, pero sí un trabajo que juntos podemos recorrer, a través de un acompañamiento respetuoso que'),
(2, '../img/modeloDos.jpg', 'Lic. Vanesa Pérez', 'Lic. en Psicología Terapia Psicoanalitica', 46489, 'Ansiedad y estrés. Separación o desarraigo familiar. Sexualidad. Duelo. Problemas vinculares.', 'No existen recetas ni soluciones mágicas, pero sí un trabajo que juntos podemos recorrer, a través de un acompañamiento respetuoso que');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `presentaciones`
--
ALTER TABLE `presentaciones`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `presentaciones`
--
ALTER TABLE `presentaciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
