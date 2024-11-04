-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 04-11-2024 a las 17:20:32
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `terapia`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `telefono` varchar(50) DEFAULT NULL,
  `fecha_registro` datetime DEFAULT current_timestamp(),
  `id_presentacion` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `email`, `password`, `telefono`, `fecha_registro`, `id_presentacion`) VALUES
(4, 'Ivan', 'ivanrosendo@gmail.com', '$2y$10$avl92iqWz6rYoQI0DAB1P.oUZ3pZw1IYjWYJo2Z.otHbO3Q9bpaqS', '1139114579', '2024-10-16 09:42:11', NULL),
(5, 'Walter', 'infowss@gmail.com', '$2y$10$DjfdcAql2lXQ0muWrkz0KeX4yTcgkBfYmQ5fxQrBE9iRKtmJGx962', NULL, '2024-10-16 15:08:52', NULL),
(9, 'Diego Armando Maradona', 'diego@gmail.com', '$2y$10$5jYCLG8wcdVu/6AQXBFDJ..aiw3p1qSEfrzhDGor.b1CXwHwY0rx.', '1010', '2024-11-02 19:29:51', 26);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `fk_presentacion_usuario` (`id_presentacion`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `fk_presentacion_usuario` FOREIGN KEY (`id_presentacion`) REFERENCES `presentaciones` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
