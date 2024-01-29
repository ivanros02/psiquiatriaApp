-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 29-01-2024 a las 16:31:46
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
  `descripcion` varchar(1000) NOT NULL,
  `telefono` int(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `presentaciones`
--

INSERT INTO `presentaciones` (`id`, `rutaImagen`, `nombre`, `titulo`, `matricula`, `especialidad`, `descripcion`, `telefono`) VALUES
(1, '../img/Lic. Ana Maria Pinto.jpg', 'Lic. Ana Maria Pinto', 'Lic. en Psicología Terapia Psicoanalitica', 180, 'Ansiedad y estrés. Separación o desarraigo familiar. Sexualidad. Duelo. Problemas vinculares.', 'Mi nombre es Vanesa Pérez. Tengo una familia compuesta por esposo e hijos. Soy Psicóloga egresada de la Universidad de Buenos Aires, tengo posgrado en psicoanálisis de Adultos y Adolescentes y también soy técnica en Cardiología.\r\n\r\nDesarrollo mi labor cómo psicóloga desde el año 2015 en consultorio ', 1139114579),
(2, '../img/Lic. Vanesa Pérez.jpg', 'Lic. Vanesa Pérez', 'Lic. en Psicología Terapia Psicoanalitica', 52084, 'Ansiedad y estrés. Separación o desarraigo familiar. Sexualidad. Duelo. Problemas vinculares.', 'Mi nombre es Vanesa Pérez. Tengo una familia compuesta por esposo e hijos. Soy Psicóloga egresada de la Universidad de Buenos Aires, tengo posgrado en psicoanálisis de Adultos y Adolescentes y también soy técnica en Cardiología.\r\n\r\nDesarrollo mi labor cómo psicóloga desde el año 2015 en consultorio particular. Actualmente me dedico a trabajar solo en consultorio on line, modalidad que a mi parecer le facilita al paciente la posibilidad de acceder a sus sesiones desde la comodidad de su casa o trabajo. Considero que la psicología en los tiempos que corren requieren de una mirada mas integrada y, aunque mi formación esta orientada al psicoanálisis, conformo con mis pacientes un trabajo dinámico que les permite adquirir herramientas basadas en la resolución de las problemáticas o demandas que lo traen a la consulta.\r\n\r\nDesde esta mirada trabajo y acompaño al paciente brindándole un espacio para ser escuchado y para la reflexión.', 1010101010);

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
