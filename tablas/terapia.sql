-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 21-10-2024 a las 17:00:24
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
  `mail` varchar(255) NOT NULL,
  `whatsapp` varchar(255) NOT NULL,
  `instagram` varchar(255) NOT NULL,
  `aprobado` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `presentaciones`
--

INSERT INTO `presentaciones` (`id`, `rutaImagen`, `nombre`, `titulo`, `matricula`, `matriculaP`, `descripcion`, `telefono`, `disponibilidad`, `valor`, `mail`, `whatsapp`, `instagram`, `aprobado`) VALUES
(1, '../img/perfiles/Lic. Patricia Candia.jpg', 'Psicólogo 1', 'Psicología General', 12345678, 87654321, 'En 2009, a los veintidós años, ganó su primer Balón de Oro y el premio al Jugador Mundial de la FIFA del año. Siguieron tres temporadas exitosas, en las que ganó cuatro Balones de Oro de forma consecutiva, hecho que no tenía precedentes. Hasta el momento, su mejor campaña personal fue en 2011-12, cuando estableció el récord de más goles en una temporada, tanto en La Liga como en otras competiciones europeas. Durante las dos siguientes temporadas, también sufrió lesiones y, en 2014, perdió el Balón de Oro frente a Cristiano Ronaldo, a quien se considera su rival. Recuperó su mejor forma durante la campaña 2014-15, en la que superó los registros de máximo goleador absoluto en La Liga y la Liga de Campeones y logró con el Barcelona un histórico segundo triplete, además de ganar su quinto Balón de Oro. Volvería a ganarlo en 2019, 2021 y 2023.', '1122334455', 48, 100, 'psicologo1@example.com', '1122334455', '@psicologo1', 1),
(2, '../img/perfiles/Lic. Luciana Ardaiz.jpg', 'Psicólogo 2', 'Psicología Infantil', 12345679, 87654322, 'Descripción de Psicólogo 2', '2233445566', 24, 120, 'psicologo2@example.com', '2233445566', '@psicologo2', 1),
(3, '../img/perfiles/Lic. Vanesa Pérez.jpg', 'Psicólogo 3', 'Psicología Clínica', 12345680, 87654323, 'Descripción de Psicólogo 3', '3344556677', 24, 150, 'psicologo3@example.com', '3344556677', '@psicologo3', 1);

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
(3, 27);

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
  `fecha_registro` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `email`, `password`, `telefono`, `fecha_registro`) VALUES
(4, 'ivan', 'ivanrosendo@gmail.com', '$2y$10$avl92iqWz6rYoQI0DAB1P.oUZ3pZw1IYjWYJo2Z.otHbO3Q9bpaqS', '', '2024-10-16 09:42:11'),
(5, 'Walter', 'infowss@gmail.com', '$2y$10$DjfdcAql2lXQ0muWrkz0KeX4yTcgkBfYmQ5fxQrBE9iRKtmJGx962', NULL, '2024-10-16 15:08:52');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario_profesional`
--

CREATE TABLE `usuario_profesional` (
  `usuario_id` int(11) NOT NULL,
  `profesional_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `usuario_profesional`
--

INSERT INTO `usuario_profesional` (`usuario_id`, `profesional_id`) VALUES
(4, 1),
(4, 2),
(4, 3),
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
-- Indices de la tabla `datos_usuario`
--
ALTER TABLE `datos_usuario`
  ADD PRIMARY KEY (`id`),
  ADD KEY `psychologist_id` (`psychologist_id`),
  ADD KEY `fk_pago_usuario` (`user`);

--
-- Indices de la tabla `especialidades`
--
ALTER TABLE `especialidades`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `presentaciones`
--
ALTER TABLE `presentaciones`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `presentaciones_especialidades`
--
ALTER TABLE `presentaciones_especialidades`
  ADD PRIMARY KEY (`presentacion_id`,`especialidad_id`),
  ADD KEY `especialidad_id` (`especialidad_id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `datos_usuario`
--
ALTER TABLE `datos_usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `especialidades`
--
ALTER TABLE `especialidades`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT de la tabla `presentaciones`
--
ALTER TABLE `presentaciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `datos_usuario`
--
ALTER TABLE `datos_usuario`
  ADD CONSTRAINT `datos_usuario_ibfk_1` FOREIGN KEY (`psychologist_id`) REFERENCES `presentaciones` (`id`),
  ADD CONSTRAINT `fk_pago_usuario` FOREIGN KEY (`user`) REFERENCES `usuarios` (`id`);

--
-- Filtros para la tabla `presentaciones_especialidades`
--
ALTER TABLE `presentaciones_especialidades`
  ADD CONSTRAINT `presentaciones_especialidades_ibfk_1` FOREIGN KEY (`presentacion_id`) REFERENCES `presentaciones` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `presentaciones_especialidades_ibfk_2` FOREIGN KEY (`especialidad_id`) REFERENCES `especialidades` (`id`) ON DELETE CASCADE;

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
