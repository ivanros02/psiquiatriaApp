-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 17-01-2024 a las 01:18:21
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
-- Estructura de tabla para la tabla `comentarios`
--

CREATE TABLE `comentarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `comentario` varchar(100) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `psychologist_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `comentarios`
--

INSERT INTO `comentarios` (`id`, `nombre`, `comentario`, `fecha`, `psychologist_id`) VALUES
(28, 'Ivan', 'prueba', '2024-01-16 21:46:06', 1),
(29, 'test', 'test', '2024-01-16 21:47:31', 2),
(30, 'Neo', 'test', '2024-01-16 21:47:43', 2),
(31, 'Ivan', 'prueba vanesa', '2024-01-16 21:52:27', 2),
(32, 'Neo', 'prueba ana', '2024-01-16 21:53:18', 1),
(33, 'Ivan', 'comentario', '2024-01-16 21:55:03', 1),
(34, 'Ivan', 'prueba', '2024-01-16 22:00:01', 1),
(35, 'Ivan', 'prueba', '2024-01-16 22:05:08', 1),
(36, 'Test', 'test', '2024-01-16 22:05:39', 1),
(37, 'Ivan', '2', '2024-01-16 22:09:02', 1),
(38, 'Ivan', '2', '2024-01-16 22:09:22', 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `comentarios`
--
ALTER TABLE `comentarios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `psychologist_id` (`psychologist_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `comentarios`
--
ALTER TABLE `comentarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
