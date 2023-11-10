-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 10-11-2023 a las 16:34:06
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `pt05_marc_jornet`
--
DROP DATABASE IF EXISTS `pt05_marc_jornet`;
CREATE DATABASE IF NOT EXISTS `pt05_marc_jornet` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `pt05_marc_jornet`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `articles`
--

DROP TABLE IF EXISTS `articles`;
CREATE TABLE `articles` (
  `id` int(11) NOT NULL,
  `article` text NOT NULL,
  `id_usuaris` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `articles`
--

INSERT INTO `articles` (`id`, `article`, `id_usuaris`) VALUES
(1, 'Descubrimiento de exoplanetas mediante inteligencia artificial.', 1),
(3, 'Cómo la realidad virtual está transformando la educación.', 1),
(4, 'La importancia de la diversidad en el lugar de trabajo.', 1),
(5, 'Avances en la edición genética para tratar enfermedades.', 1),
(7, 'Nuevas terapias para la enfermedad de Alzheimer.', 1),
(9, 'La neurociencia detrás de la toma de decisiones.', 1),
(10, 'La ciberseguridad en la era de la Internet de las cosas.', 1),
(11, 'La economía de las criptomonedas y el blockchain.', 1),
(12, 'Cómo la inteligencia artificial está revolucionando la atención médica.', 5),
(13, 'La conservación de la biodiversidad en peligro.', 6),
(14, 'El futuro de la movilidad eléctrica.', 1),
(15, 'El auge de la carne cultivada en laboratorio.', 1),
(16, 'Los desafíos éticos de la inteligencia artificial.', 1),
(17, 'La psicología de la felicidad y el bienestar.', 1),
(18, 'Innovaciones en la energía solar y eólica.', 1),
(19, 'La importancia de la educación STEM.', 1),
(20, 'Los efectos de la contaminación del aire en la salud.', 1),
(21, 'La conexión entre la dieta y la longevidad.', 1),
(22, 'La lucha contra la desinformación en línea.', 1),
(23, 'Nuevas terapias para el cáncer.', 1),
(24, 'La neuroplasticidad y la rehabilitación cerebral.', 1),
(25, 'Avances en la exploración espacial.', 1),
(26, 'La inteligencia artificial en la industria automotriz.', 1),
(27, 'La crisis global del agua y la sostenibilidad.', 1),
(28, 'El impacto de la inteligencia artificial en el arte.', 1),
(29, 'Los desafíos de la adopción de energía renovable.', 1),
(30, 'El microbioma intestinal y la salud digestiva.', 1),
(31, 'El futuro de la realidad aumentada en la medicina.', 1),
(32, 'La ética de la edición genética en humanos.', 1),
(33, 'La inteligencia artificial en la atención al cliente.', 1),
(34, 'La neurociencia del aprendizaje en línea.', 1),
(35, 'Avances en la impresión 3D de órganos humanos.', 1),
(36, 'Descubrimiento de exoplanetas mediante inteligencia artificial.La exploración de exoplanetas en busca de vida extraterrestre.', 1),
(52, 'Hola xavi, que tal', 5),
(55, 'Que tal', 5),
(56, 'coche rojo', 5),
(58, 'Hola benito', 6),
(59, 'Me llamo Juan', 6),
(66, 'Los lagos de mariposas', 8);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuaris`
--

DROP TABLE IF EXISTS `usuaris`;
CREATE TABLE `usuaris` (
  `id` int(10) UNSIGNED NOT NULL,
  `nom` text NOT NULL,
  `contrasenya` text NOT NULL,
  `email` text NOT NULL,
  `reset_token` text DEFAULT NULL,
  `social_provider` enum('Twitter','Google','Facebook','') DEFAULT NULL,
  `time_token` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `nom_provisional_oauth` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuaris`
--

INSERT INTO `usuaris` (`id`, `nom`, `contrasenya`, `email`, `reset_token`, `social_provider`, `time_token`, `nom_provisional_oauth`) VALUES
(1, 'admin', '$2y$10$G9R4d5ZldoGB1QzgGO1VcOo3zgYUIbsb9qsMOcvsBfnnrsxPmOo42', 'm.jornet@sapalomera.cat', '399bbf4c42ef4a5ddb627421fe30a93f', NULL, '2023-11-10 14:24:26', NULL),
(2, 'Benito04', '$2y$10$tz9la0EdG/TLRtUqaT7R7u6ioEP25nfS3L/qMi/9EwjIs.eiSxTRK', 'fwewfe@fwefwfefwfe.com', NULL, NULL, NULL, NULL),
(5, 'MarcGuapo', '$2y$10$6dQK67h/xezpmjaeQK3PU.fosJFQFBOKz5KbZ36CjtxR3iZZJF3y6', 'gwegwg@gwegwe.com', NULL, NULL, NULL, NULL),
(6, 'Rodrigo', '$2y$10$poq2PR1D7qFKIavSjxepLupIc4a.7Q4RBJO/whznQL/DeMstDPb4a', 'vsdvsd@hotmail.com', NULL, NULL, NULL, NULL),
(7, 'Daweros', '$2y$10$7IeTYHerJJv.m2a.krbUe.FcZlD.iraWZCTAsz2Ar1VWcmmd1feHW', 'daw1234@gmail.com', NULL, NULL, NULL, NULL),
(8, '', '', 'marcjornet96@gmail.com', NULL, 'Google', NULL, 'Marc Jornet');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `articles`
--
ALTER TABLE `articles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_articles_usuaris` (`id_usuaris`);

--
-- Indices de la tabla `usuaris`
--
ALTER TABLE `usuaris`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `IDX_usuaris_email` (`email`) USING HASH;

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `articles`
--
ALTER TABLE `articles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT de la tabla `usuaris`
--
ALTER TABLE `usuaris`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `articles`
--
ALTER TABLE `articles`
  ADD CONSTRAINT `fk_articles_usuaris` FOREIGN KEY (`id_usuaris`) REFERENCES `usuaris` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
