-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 05-11-2024 a las 14:18:12
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
  `payment_id` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `presentaciones_especialidades`
--

CREATE TABLE `presentaciones_especialidades` (
  `presentacion_id` int(11) NOT NULL,
  `especialidad_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario_profesional`
--

CREATE TABLE `usuario_profesional` (
  `usuario_id` int(255) NOT NULL,
  `profesional_id` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
  `fecha_creacion` datetime DEFAULT current_timestamp(),
  `estado_pago` enum('pendiente','completado') DEFAULT 'pendiente'
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
-- AUTO_INCREMENT de la tabla `comentarios_presentaciones`
--
ALTER TABLE `comentarios_presentaciones`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `datos_usuario`
--
ALTER TABLE `datos_usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `disponibilidad_turnos`
--
ALTER TABLE `disponibilidad_turnos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `especialidades`
--
ALTER TABLE `especialidades`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT de la tabla `presentaciones`
--
ALTER TABLE `presentaciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT de la tabla `reservas_turnos`
--
ALTER TABLE `reservas_turnos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `videollamadas`
--
ALTER TABLE `videollamadas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Restricciones para tablas volcadas
--

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
