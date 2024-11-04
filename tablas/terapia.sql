-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 04-11-2024 a las 03:22:23
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
-- Estructura de tabla para la tabla `chats`
--

CREATE TABLE `chats` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `profesional_id` int(11) NOT NULL,
  `fecha_creacion` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `chats`
--

INSERT INTO `chats` (`id`, `usuario_id`, `profesional_id`, `fecha_creacion`) VALUES
(8, 4, 9, '2024-11-03 22:32:39');

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

--
-- Volcado de datos para la tabla `comentarios_presentaciones`
--

INSERT INTO `comentarios_presentaciones` (`id`, `profesional_id`, `comentario`, `nombre`) VALUES
(3, 2, 'Me siento más tranquila después de hablar sobre mis preocupaciones. Creo que estoy empezando a entender mejor cómo gestionar mi ansiedad.', 'Sergio'),
(4, 2, 'Fue útil explorar mis emociones. Me di cuenta de patrones que antes no había notado en mis relaciones.', 'Walter'),
(6, 1, 'Hoy me llevé herramientas concretas para manejar el estrés. Siento que tengo más control sobre mi situación.', 'Sol'),
(7, 1, 'Hablar sobre mis miedos me hizo sentir escuchado, y creo que estoy en el camino correcto para enfrentar mis inseguridades.', 'Francisco'),
(8, 3, 'Hablar sobre mis miedos me hizo sentir escuchado, y creo que estoy en el camino correcto para enfrentar mis inseguridades.', 'Sergio'),
(9, 3, 'La sesión de hoy me ayudó a ver las cosas desde una perspectiva diferente. Me siento más motivado para hacer cambios en mi vida.', 'Walter');

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

--
-- Volcado de datos para la tabla `disponibilidad_turnos`
--

INSERT INTO `disponibilidad_turnos` (`id`, `profesional_id`, `fecha`, `hora`, `disponible`) VALUES
(7, 9, '2024-11-02', '10:00:00', 0);

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
  `usuario_id` int(11) NOT NULL,
  `texto` text NOT NULL,
  `fecha_creacion` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `mensajes`
--

INSERT INTO `mensajes` (`id`, `chat_id`, `usuario_id`, `texto`, `fecha_creacion`) VALUES
(1, 8, 9, 'hola', '2024-11-03 23:21:13');

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
(1, '../img/perfiles/Fondos-11.jpg', 'Psicólogo E', 'Psicología General', 12345678, 87654321, 'En 2009, a los veintidós años, ganó su primer Balón de Oro y el premio al Jugador Mundial de la FIFA del año. Siguieron tres temporadas exitosas, en las que ganó cuatro Balones de Oro de forma consecutiva, hecho que no tenía precedentes. Hasta el momento, su mejor campaña personal fue en 2011-12, cuando estableció el récord de más goles en una temporada, tanto en La Liga como en otras competiciones europeas. Durante las dos siguientes temporadas, también sufrió lesiones y, en 2014, perdió el Balón de Oro frente a Cristiano Ronaldo, a quien se considera su rival. Recuperó su mejor forma durante la campaña 2014-15, en la que superó los registros de máximo goleador absoluto en La Liga y la Liga de Campeones y logró con el Barcelona un histórico segundo triplete, además de ganar su quinto Balón de Oro. Volvería a ganarlo en 2019, 2021 y 2023.', '1122334455', 48, 1000, 10, 'psicologo1@example.com', '1122334455', '@psicologo1', 1, NULL),
(2, '../img/perfiles/Lic. Luciana Ardaiz.jpg', 'Psicólogo 2', 'Psicología Infantil', 12345679, 87654322, 'Descripción de Psicólogo 2', '2233445566', 24, 120, 0, 'psicologo2@example.com', '2233445566', '@psicologo2', 1, NULL),
(3, '../img/perfiles/Lic. Vanesa Pérez.jpg', 'borrar', 'Psicología Clínica', 12345680, 87654323, 'Descripción de Psicólogo 3', '3344556677', 24, 150, 0, 'psicologo3@example.com', '3344556677', '@psicologo3', 0, NULL),
(26, '../img/perfiles/diego.jpg', 'Diego Armando Maradona', 'Genio Del Futbol Mundial', 1010, 1010, 'prueba', '1010', 24, 10000, 100, 'diego@gmail.com', '101010', '101010', 1, NULL);

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
(1, 24),
(1, 27),
(1, 34),
(1, 40),
(2, 24),
(2, 27),
(3, 24),
(3, 27),
(26, 24),
(26, 28);

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
(8, 7, 4, '2024-11-03 00:55:21');

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
(4, 1),
(4, 2),
(5, 1);

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
  ADD UNIQUE KEY `unique_chat` (`usuario_id`,`profesional_id`);

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
  ADD KEY `usuario_id` (`usuario_id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `comentarios_presentaciones`
--
ALTER TABLE `comentarios_presentaciones`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `datos_usuario`
--
ALTER TABLE `datos_usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `disponibilidad_turnos`
--
ALTER TABLE `disponibilidad_turnos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `especialidades`
--
ALTER TABLE `especialidades`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT de la tabla `mensajes`
--
ALTER TABLE `mensajes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `presentaciones`
--
ALTER TABLE `presentaciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT de la tabla `reservas_turnos`
--
ALTER TABLE `reservas_turnos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

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
  ADD CONSTRAINT `datos_usuario_ibfk_1` FOREIGN KEY (`psychologist_id`) REFERENCES `presentaciones` (`id`),
  ADD CONSTRAINT `fk_pago_usuario` FOREIGN KEY (`user`) REFERENCES `usuarios` (`id`);

--
-- Filtros para la tabla `disponibilidad_turnos`
--
ALTER TABLE `disponibilidad_turnos`
  ADD CONSTRAINT `fk_disponibilidad_usuario` FOREIGN KEY (`profesional_id`) REFERENCES `usuarios` (`id`);

--
-- Filtros para la tabla `mensajes`
--
ALTER TABLE `mensajes`
  ADD CONSTRAINT `mensajes_ibfk_1` FOREIGN KEY (`chat_id`) REFERENCES `chats` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `mensajes_ibfk_2` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;

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
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
