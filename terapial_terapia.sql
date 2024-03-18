-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 18-03-2024 a las 11:03:00
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
-- Estructura de tabla para la tabla `datos_usuario`
--

CREATE TABLE `datos_usuario` (
  `id` int(11) NOT NULL,
  `user_email` varchar(200) NOT NULL,
  `psychologist_id` int(200) NOT NULL,
  `payment_id` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `datos_usuario`
--

INSERT INTO `datos_usuario` (`id`, `user_email`, `psychologist_id`, `payment_id`) VALUES
(81, 'ivanrosendo1102@gmail.com', 1, 1004358627),
(82, 'ivanrosendo1102@gmail.com', 1, 1004358627),
(83, 'ivanrosendo1102@gmail.com', 1, 1004358627),
(84, 'ivanrosendo1102@gmail.com', 1, 1004358627),
(85, 'ivanrosendo1102@gmail.com', 1, 1004358627),
(86, 'ivanrosendo1102@gmail.com', 1, 1004358627),
(87, 'ivanrosendo1102@gmail.com', 1, 1004358627),
(88, 'ivanrosendo1102@gmail.com', 1, 1004358627),
(89, 'ivanrosendo1102@gmail.com', 1, 1004358627),
(90, 'ivanrosendo1102@gmail.com', 1, 1004358627),
(91, 'ivanrosendo1102@gmail.com', 1, 1004358627),
(92, 'ivanrosendo1102@gmail.com', 1, 1004358627),
(93, 'ivanrosendo1102@gmail.com', 1, 1004358627),
(94, 'ivanrosendo1102@gmail.com', 1, 1004358627),
(95, 'ivanrosendo1102@gmail.com', 1, 1004358627),
(96, 'ivanrosendo1102@gmail.com', 1, 1004358627),
(97, 'ivanrosendo1102@gmail.com', 1, 1004358627),
(98, 'ivanrosendo1102@gmail.com', 1, 1004358627),
(99, 'ivanrosendo1102@gmail.com', 1, 1004358627),
(100, 'ivanrosendo1102@gmail.com', 1, 1004358627),
(101, 'ivanrosendo1102@gmail.com', 1, 1004358627),
(102, 'ivanrosendo1102@gmail.com', 1, 1004358627),
(103, 'ivanrosendo1102@gmail.com', 1, 1004358627),
(104, 'paginaswebs2002@gmail.com', 3, 1004358627),
(105, 'ivanrosendo1102@gmail.com', 1, 1004358627),
(106, 'ivanrosendo1102@gmail.com', 1, 1004358627),
(107, 'ivanrosendo1102@gmail.com', 1, 1004358627),
(108, 'ivanrosendo1102@gmail.com', 1, 1004358627),
(109, 'wfrosendo@gmail.com', 1, 1004358627),
(110, 'ivanrosendo1102@gmail.com', 1, 1004358627),
(111, 'ivanrosendo1102@gmail.com', 1, 1004358627),
(112, 'ivanrosendo1102@gmail.com', 3, 1004358627),
(113, 'paginaswebs2002@gmail.com', 1, 1004358627),
(114, 'ivanrosendo1102@gmail.com', 3, 1004358627),
(115, 'paginaswebs2002@gmail.com', 3, 1004358627);

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
-- Volcado de datos para la tabla `presentaciones`
--

INSERT INTO `presentaciones` (`id`, `rutaImagen`, `nombre`, `titulo`, `matricula`, `matriculaP`, `especialidad`, `descripcion`, `telefono`, `disponibilidad`, `valor`, `mail`, `whatsapp`, `instagram`) VALUES
(1, '../img/Lic. Ana Maria Pinto.jpg', 'Lic. Ana Maria Pinto', 'Lic. en Psicología Terapia Psicoanalitica', 180, 0, 'Ansiedad y estrés. Separación o desarraigo familiar. Sexualidad. Duelo. Problemas vinculares.', 'Mi nombre es Vanesa Pérez. Tengo una familia compuesta por esposo e hijos. Soy Psicóloga egresada de la Universidad de Buenos Aires, tengo posgrado en psicoanálisis de Adultos y Adolescentes y también soy técnica en Cardiología.\r\n\r\nDesarrollo mi labor cómo psicóloga desde el año 2015 en consultorio ', 1139114579, 24, 1, 'paginaswebs2002@gmail.com', 1139114579, 'rosendo_ivann'),
(2, '../img/Lic. Vanesa Pérez.jpg', 'Lic. Vanesa Perez', 'Lic. en Psicología Terapia Psicoanalitica', 52084, 0, 'Ansiedad y estrés. Separación o desarraigo familiar. Sexualidad. Duelo. Problemas vinculares.', 'Mi nombre es Vanesa Pérez. Tengo una familia compuesta por esposo e hijos. Soy Psicóloga egresada de la Universidad de Buenos Aires, tengo posgrado en psicoanálisis de Adultos y Adolescentes y también soy técnica en Cardiología.\r\n\r\nDesarrollo mi labor cómo psicóloga desde el año 2015 en consultorio particular. Actualmente me dedico a trabajar solo en consultorio on line, modalidad que a mi parecer le facilita al paciente la posibilidad de acceder a sus sesiones desde la comodidad de su casa o trabajo. Considero que la psicología en los tiempos que corren requieren de una mirada mas integrada y, aunque mi formación esta orientada al psicoanálisis, conformo con mis pacientes un trabajo dinámico que les permite adquirir herramientas basadas en la resolución de las problemáticas o demandas que lo traen a la consulta.\r\n\r\nDesde esta mirada trabajo y acompaño al paciente brindándole un espacio para ser escuchado y para la reflexión.', 1010101010, 48, 10, 'paginaswebs2002@gmail.com', 0, ''),
(3, '../img/Lic. Luciana Ardaiz.jpg\r\n', 'Lic. Luciana Ardaiz', 'Lic. en Psicología\r\nTerapia Psicoanalítica', 52084, 0, 'Desarrollo personal\r\n', 'Mi nombre es Vanesa Pérez. Tengo una familia compuesta por esposo e hijos. Soy Psicóloga egresada de la Universidad de Buenos Aires, tengo posgrado en psicoanálisis de Adultos y Adolescentes y también soy técnica en Cardiología.\r\n\r\nDesarrollo mi labor cómo psicóloga desde el año 2015 en consultorio particular. Actualmente me dedico a trabajar solo en consultorio on line, modalidad que a mi parecer le facilita al paciente la posibilidad de acceder a sus sesiones desde la comodidad de su casa o trabajo. Considero que la psicología en los tiempos que corren requieren de una mirada mas integrada y, aunque mi formación esta orientada al psicoanálisis, conformo con mis pacientes un trabajo dinámico que les permite adquirir herramientas basadas en la resolución de las problemáticas o demandas que lo traen a la consulta.\r\n\r\nDesde esta mirada trabajo y acompaño al paciente brindándole un espacio para ser escuchado y para la reflexión.', 1010101010, 24, 10, '', 0, ''),
(4, '../img/Lic. Patricia Candia.jpg\n', 'Lic. Patricia Candia', 'Lic. en Psicología\r\nTerapia Psicoanalitica', 52084, 0, 'Miedos al COVID-19\n', 'Me gusta escucharlos, contenerlos, pero por sobre todo respetarlos, donde los miedos, ansiedades, angustias y otras dolencias dan paso a los... (continúa)\r\n\r\nDesarrollo mi labor cómo psicóloga desde el año 2015 en consultorio particular. Actualmente me dedico a trabajar solo en consultorio on line, modalidad que a mi parecer le facilita al paciente la posibilidad de acceder a sus sesiones desde la comodidad de su casa o trabajo. Considero que la psicología en los tiempos que corren requieren de una mirada mas integrada y, aunque mi formación esta orientada al psicoanálisis, conformo con mis pacientes un trabajo dinámico que les permite adquirir herramientas basadas en la resolución de las problemáticas o demandas que lo traen a la consulta.\r\n\r\nDesde esta mirada trabajo y acompaño al paciente brindándole un espacio para ser escuchado y para la reflexión.', 1010101010, 24, 10, '', 0, '');

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
-- Indices de la tabla `datos_usuario`
--
ALTER TABLE `datos_usuario`
  ADD PRIMARY KEY (`id`),
  ADD KEY `psychologist_id` (`psychologist_id`);

--
-- Indices de la tabla `presentaciones`
--
ALTER TABLE `presentaciones`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `presentacionesCheck`
--
ALTER TABLE `presentacionesCheck`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `datos_usuario`
--
ALTER TABLE `datos_usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=116;

--
-- AUTO_INCREMENT de la tabla `presentaciones`
--
ALTER TABLE `presentaciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `presentacionesCheck`
--
ALTER TABLE `presentacionesCheck`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `datos_usuario`
--
ALTER TABLE `datos_usuario`
  ADD CONSTRAINT `datos_usuario_ibfk_1` FOREIGN KEY (`psychologist_id`) REFERENCES `presentaciones` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
