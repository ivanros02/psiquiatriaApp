-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 22-10-2024 a las 15:19:07
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

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `comentarios_presentaciones`
--
ALTER TABLE `comentarios_presentaciones`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_comentario_prof` (`profesional_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `comentarios_presentaciones`
--
ALTER TABLE `comentarios_presentaciones`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `comentarios_presentaciones`
--
ALTER TABLE `comentarios_presentaciones`
  ADD CONSTRAINT `fk_comentario_prof` FOREIGN KEY (`profesional_id`) REFERENCES `presentaciones` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
