-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 09-01-2025 a las 18:04:10
-- Versión del servidor: 10.6.20-MariaDB-cll-lve-log
-- Versión de PHP: 8.3.14

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
-- Estructura de tabla para la tabla `administradores`
--

CREATE TABLE `administradores` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `administradores`
--

INSERT INTO `administradores` (`id`, `username`, `password`) VALUES
(1, 'admin', '$2y$10$oj/vo.EBl5JLTi2dQSLA0O0wVBCn/wFCjCLc5NlTLzGOUSf8/94ta');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `chats`
--

CREATE TABLE `chats` (
  `id` int(11) NOT NULL,
  `usuario_id_1` int(11) NOT NULL,
  `usuario_id_2` int(11) NOT NULL,
  `fecha_creacion` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `chats`
--

INSERT INTO `chats` (`id`, `usuario_id_1`, `usuario_id_2`, `fecha_creacion`) VALUES
(6, 21, 20, '2024-12-03 12:38:09'),
(7, 20, 23, '2024-12-12 16:45:24');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comentarios_presentaciones`
--

CREATE TABLE `comentarios_presentaciones` (
  `id` int(255) NOT NULL,
  `profesional_id` int(255) NOT NULL,
  `comentario` varchar(255) NOT NULL,
  `nombre` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `datos_usuario`
--

CREATE TABLE `datos_usuario` (
  `id` int(11) NOT NULL,
  `user` int(255) NOT NULL,
  `psychologist_id` int(200) NOT NULL,
  `payment_id` int(255) NOT NULL,
  `pago_nacional` tinyint(1) NOT NULL DEFAULT 1,
  `fecha` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `datos_usuario`
--

INSERT INTO `datos_usuario` (`id`, `user`, `psychologist_id`, `payment_id`, `pago_nacional`, `fecha`) VALUES
(20, 21, 20, 2147483647, 1, '2024-12-03 12:34:00'),
(21, 21, 20, 2147483647, 1, '2024-12-03 12:37:54'),
(22, 21, 20, 2147483647, 1, '2024-12-21 14:03:00'),
(23, 21, 20, 2147483647, 1, '2024-12-21 17:41:43'),
(24, 21, 20, 2, 0, '2025-01-09 16:36:41'),
(25, 21, 20, 8, 0, '2025-01-09 16:39:54'),
(26, 21, 20, 13238987, 0, '2025-01-09 16:40:44');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `disponibilidad_turnos`
--

CREATE TABLE `disponibilidad_turnos` (
  `id` int(11) NOT NULL,
  `profesional_id` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  `disponible` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `disponibilidad_turnos`
--

INSERT INTO `disponibilidad_turnos` (`id`, `profesional_id`, `fecha`, `hora`, `disponible`) VALUES
(36, 20, '2024-12-03', '12:30:00', 0),
(37, 20, '2024-12-10', '12:30:00', 0),
(38, 20, '2024-12-17', '12:30:00', 1),
(39, 20, '2024-12-24', '12:30:00', 1),
(40, 20, '2024-12-31', '12:30:00', 0),
(41, 20, '2024-12-31', '16:00:00', 0),
(42, 20, '2024-12-31', '15:00:00', 0),
(44, 20, '2024-12-31', '17:00:00', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `especialidades`
--

CREATE TABLE `especialidades` (
  `id` int(11) NOT NULL,
  `especi` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `especialidades`
--

INSERT INTO `especialidades` (`id`, `especi`) VALUES
(21, 'Psicología Clínica'),
(22, 'Psicología Infantil'),
(23, 'Psicología Organizacional'),
(24, 'Psicología Educativa'),
(25, 'Neuropsicología'),
(26, 'Psicología Forense'),
(27, 'Psicología de la Salud'),
(28, 'Psicología del Deporte'),
(29, 'Psicología Ambiental'),
(30, 'Psicología Transpersonal'),
(31, 'Psicología del Desarrollo'),
(32, 'Psicología del Trabajo y de las Organizaciones'),
(33, 'Psicología Comunitaria'),
(34, 'Psicología del Consumidor'),
(35, 'Psicología del Color'),
(36, 'Psicología del Deporte y del Ejercicio'),
(37, 'Psicología Positiva'),
(38, 'Psicología Forense'),
(39, 'Psicología Intercultural'),
(40, 'Psicología Gerontológica');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mensajes`
--

CREATE TABLE `mensajes` (
  `id` int(11) NOT NULL,
  `chat_id` int(11) NOT NULL,
  `id_remitente` int(11) NOT NULL,
  `mensaje` text NOT NULL,
  `fecha` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `mensajes`
--

INSERT INTO `mensajes` (`id`, `chat_id`, `id_remitente`, `mensaje`, `fecha`) VALUES
(20, 6, 21, 'Hola Agustin!', '2024-12-03 12:38:16'),
(21, 6, 20, 'Hola  moni!', '2024-12-03 12:39:24'),
(22, 6, 21, 'Hola  ivanchu ', '2024-12-03 12:39:48'),
(23, 6, 20, 'TAKA TAKA', '2024-12-03 12:39:56'),
(24, 6, 21, 'Hola', '2024-12-03 13:05:23'),
(25, 7, 20, 'Hola', '2024-12-12 16:45:27'),
(26, 7, 23, 'Buenas tardes', '2024-12-12 16:46:20'),
(27, 7, 23, 'Buenas tardes', '2024-12-12 16:46:21'),
(28, 7, 23, 'Buenas tardes', '2024-12-12 16:46:21'),
(29, 7, 23, 'Buenas tardes', '2024-12-12 16:46:22'),
(30, 7, 23, 'me siento mal', '2024-12-12 16:46:33');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `presentaciones`
--

CREATE TABLE `presentaciones` (
  `id` int(11) NOT NULL,
  `rutaImagen` varchar(200) NOT NULL DEFAULT '../img/por_defecto.png',
  `nombre` varchar(100) NOT NULL,
  `titulo` varchar(100) NOT NULL,
  `matricula` bigint(100) NOT NULL,
  `matriculaP` bigint(255) NOT NULL,
  `descripcion` varchar(1000) NOT NULL,
  `telefono` varchar(255) NOT NULL,
  `disponibilidad` int(11) NOT NULL,
  `valor` bigint(255) NOT NULL,
  `valor_internacional` bigint(255) NOT NULL,
  `mail` varchar(255) NOT NULL,
  `whatsapp` varchar(255) NOT NULL,
  `instagram` varchar(255) NOT NULL,
  `aprobado` tinyint(1) NOT NULL DEFAULT 0,
  `id_usuario` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `presentaciones`
--

INSERT INTO `presentaciones` (`id`, `rutaImagen`, `nombre`, `titulo`, `matricula`, `matriculaP`, `descripcion`, `telefono`, `disponibilidad`, `valor`, `valor_internacional`, `mail`, `whatsapp`, `instagram`, `aprobado`, `id_usuario`) VALUES
(34, '../img/perfiles/forbitoTerapia.jpeg', 'Agustin Forbito', 'Lic. en Psicología Terapia Psicoanalitica', 123, 345, 'test', '1139114579', 24, 100, 1, 'ivanrosendo1102@gmail.com', '1139114579', 'rosendo_ivann', 1, 20),
(35, '../img/perfiles/imagen_1733870691000.jpg', 'test', 'test', 123, 345, 'test', '1139114579', 24, 2, 3, 'paginaswebs2002@gmail.com', '1139114579', 'rosendo_ivann', 1, 22);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `presentaciones_especialidades`
--

CREATE TABLE `presentaciones_especialidades` (
  `presentacion_id` int(11) NOT NULL,
  `especialidad_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `presentaciones_especialidades`
--

INSERT INTO `presentaciones_especialidades` (`presentacion_id`, `especialidad_id`) VALUES
(34, 21),
(35, 21);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reservas_turnos`
--

CREATE TABLE `reservas_turnos` (
  `id` int(11) NOT NULL,
  `turno_id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `fecha_reserva` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `reservas_turnos`
--

INSERT INTO `reservas_turnos` (`id`, `turno_id`, `usuario_id`, `fecha_reserva`) VALUES
(21, 37, 21, '2024-12-03 15:37:54'),
(22, 40, 21, '2025-01-09 19:36:41'),
(23, 42, 21, '2025-01-09 19:39:54'),
(24, 41, 21, '2025-01-09 19:40:44');

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
  `id_presentacion` int(11) DEFAULT NULL,
  `reset_token` varchar(255) DEFAULT NULL,
  `reset_token_expiry` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `email`, `password`, `telefono`, `fecha_registro`, `id_presentacion`, `reset_token`, `reset_token_expiry`) VALUES
(20, 'Agustin Forbito', 'ivanrosendo1102@gmail.com', '$2y$10$fFTfAR/dXpT13VIgz/bvxen8Zdaotnjvksv8knXgHsBppYXPydvAq', '1139114579', '2024-12-03 11:48:21', 34, NULL, NULL),
(21, 'Test', 'test@gmail.com', '$2y$10$NpnqImi3vrxTuw3lNyC5IO3KZK7dt4RVjJvO6/Ub3jxthrUVssQRS', '1139114579', '2024-12-03 12:31:49', NULL, NULL, NULL),
(22, 'test', 'paginaswebs2002@gmail.com', '$2y$10$e61/K..qbagVkV/7BpG42OsflXG46rOXsDnU3W8TZ8DqQzYGlal1m', '1139114579', '2024-12-10 19:45:23', 35, NULL, NULL),
(23, 'Sergio Stupis', 'sergiostupis@gmail.com', '$2y$10$1PGCtHxHvzwzRsQ7mA0le.lBMNMPqGsIdbziwb72RkCUoUvcdXv3e', NULL, '2024-12-12 16:25:11', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario_profesional`
--

CREATE TABLE `usuario_profesional` (
  `usuario_id` int(255) NOT NULL,
  `profesional_id` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `usuario_profesional`
--

INSERT INTO `usuario_profesional` (`usuario_id`, `profesional_id`) VALUES
(21, 34);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `videollamadas`
--

CREATE TABLE `videollamadas` (
  `id` int(11) NOT NULL,
  `profesional_id` int(11) NOT NULL,
  `paciente_id` int(11) NOT NULL,
  `fecha_hora` datetime NOT NULL,
  `enlace` varchar(255) NOT NULL,
  `fecha_creacion` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `administradores`
--
ALTER TABLE `administradores`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `chats`
--
ALTER TABLE `chats`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_usuario_1` (`usuario_id_1`),
  ADD KEY `fk_usuario_2` (`usuario_id_2`);

--
-- Indices de la tabla `comentarios_presentaciones`
--
ALTER TABLE `comentarios_presentaciones`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_comentario_prof` (`profesional_id`);

--
-- Indices de la tabla `datos_usuario`
--
ALTER TABLE `datos_usuario`
  ADD PRIMARY KEY (`id`),
  ADD KEY `psychologist_id` (`psychologist_id`),
  ADD KEY `fk_pago_usuario` (`user`);

--
-- Indices de la tabla `disponibilidad_turnos`
--
ALTER TABLE `disponibilidad_turnos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_disponibilidad_usuario` (`profesional_id`);

--
-- Indices de la tabla `especialidades`
--
ALTER TABLE `especialidades`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `mensajes`
--
ALTER TABLE `mensajes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `chat_id` (`chat_id`),
  ADD KEY `id_remitente` (`id_remitente`);

--
-- Indices de la tabla `presentaciones`
--
ALTER TABLE `presentaciones`
  ADD PRIMARY KEY (`id`),
  ADD KEY `presentacion_usuario` (`id_usuario`);

--
-- Indices de la tabla `presentaciones_especialidades`
--
ALTER TABLE `presentaciones_especialidades`
  ADD PRIMARY KEY (`presentacion_id`,`especialidad_id`),
  ADD KEY `especialidad_id` (`especialidad_id`);

--
-- Indices de la tabla `reservas_turnos`
--
ALTER TABLE `reservas_turnos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `turno_id` (`turno_id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `fk_presentacion_usuario` (`id_presentacion`);

--
-- Indices de la tabla `usuario_profesional`
--
ALTER TABLE `usuario_profesional`
  ADD PRIMARY KEY (`usuario_id`,`profesional_id`),
  ADD KEY `profesional_id` (`profesional_id`);

--
-- Indices de la tabla `videollamadas`
--
ALTER TABLE `videollamadas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unico_profesional_paciente` (`profesional_id`,`paciente_id`),
  ADD KEY `profesional_id` (`profesional_id`),
  ADD KEY `paciente_id` (`paciente_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `administradores`
--
ALTER TABLE `administradores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `chats`
--
ALTER TABLE `chats`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `comentarios_presentaciones`
--
ALTER TABLE `comentarios_presentaciones`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `datos_usuario`
--
ALTER TABLE `datos_usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT de la tabla `disponibilidad_turnos`
--
ALTER TABLE `disponibilidad_turnos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT de la tabla `especialidades`
--
ALTER TABLE `especialidades`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT de la tabla `mensajes`
--
ALTER TABLE `mensajes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT de la tabla `presentaciones`
--
ALTER TABLE `presentaciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT de la tabla `reservas_turnos`
--
ALTER TABLE `reservas_turnos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT de la tabla `videollamadas`
--
ALTER TABLE `videollamadas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `chats`
--
ALTER TABLE `chats`
  ADD CONSTRAINT `fk_usuario_1` FOREIGN KEY (`usuario_id_1`) REFERENCES `usuarios` (`id`),
  ADD CONSTRAINT `fk_usuario_2` FOREIGN KEY (`usuario_id_2`) REFERENCES `usuarios` (`id`);

--
-- Filtros para la tabla `comentarios_presentaciones`
--
ALTER TABLE `comentarios_presentaciones`
  ADD CONSTRAINT `fk_comentario_prof` FOREIGN KEY (`profesional_id`) REFERENCES `presentaciones` (`id`);

--
-- Filtros para la tabla `datos_usuario`
--
ALTER TABLE `datos_usuario`
  ADD CONSTRAINT `fk_pago_usuario` FOREIGN KEY (`user`) REFERENCES `usuarios` (`id`),
  ADD CONSTRAINT `fk_teraputa` FOREIGN KEY (`psychologist_id`) REFERENCES `usuarios` (`id`);

--
-- Filtros para la tabla `disponibilidad_turnos`
--
ALTER TABLE `disponibilidad_turnos`
  ADD CONSTRAINT `fk_disponibilidad_usuario` FOREIGN KEY (`profesional_id`) REFERENCES `usuarios` (`id`);

--
-- Filtros para la tabla `mensajes`
--
ALTER TABLE `mensajes`
  ADD CONSTRAINT `mensajes_ibfk_1` FOREIGN KEY (`chat_id`) REFERENCES `chats` (`id`),
  ADD CONSTRAINT `mensajes_ibfk_2` FOREIGN KEY (`id_remitente`) REFERENCES `usuarios` (`id`);

--
-- Filtros para la tabla `presentaciones`
--
ALTER TABLE `presentaciones`
  ADD CONSTRAINT `presentacion_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`);

--
-- Filtros para la tabla `presentaciones_especialidades`
--
ALTER TABLE `presentaciones_especialidades`
  ADD CONSTRAINT `presentaciones_especialidades_ibfk_1` FOREIGN KEY (`presentacion_id`) REFERENCES `presentaciones` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `presentaciones_especialidades_ibfk_2` FOREIGN KEY (`especialidad_id`) REFERENCES `especialidades` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `reservas_turnos`
--
ALTER TABLE `reservas_turnos`
  ADD CONSTRAINT `reservas_turnos_ibfk_1` FOREIGN KEY (`turno_id`) REFERENCES `disponibilidad_turnos` (`id`),
  ADD CONSTRAINT `reservas_turnos_ibfk_2` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`);

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `fk_presentacion_usuario` FOREIGN KEY (`id_presentacion`) REFERENCES `presentaciones` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Filtros para la tabla `usuario_profesional`
--
ALTER TABLE `usuario_profesional`
  ADD CONSTRAINT `usuario_profesional_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `usuario_profesional_ibfk_2` FOREIGN KEY (`profesional_id`) REFERENCES `presentaciones` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `videollamadas`
--
ALTER TABLE `videollamadas`
  ADD CONSTRAINT `videollamadas_ibfk_1` FOREIGN KEY (`profesional_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `videollamadas_ibfk_2` FOREIGN KEY (`paciente_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
