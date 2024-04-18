-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 16-04-2024 a las 15:54:05
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
-- Base de datos: `goallink_1`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `favoritos_foro`
--

CREATE TABLE `favoritos_foro` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `foro_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `foro`
--

CREATE TABLE `foro` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(100) NOT NULL,
  `descripcion` varchar(200) DEFAULT NULL,
  `fecha` date NOT NULL,
  `favoritos` int(11) DEFAULT 0,
  `destacado` tinyint(1) NOT NULL DEFAULT 0,
  `imagen` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ligas`
--

CREATE TABLE `ligas` (
  `nombre` varchar(20) NOT NULL,
  `logo` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `likes_mensajes`
--

CREATE TABLE `likes_mensajes` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `mensaje_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `likes_noticias`
--

CREATE TABLE `likes_noticias` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `noticia_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mensaje`
--

CREATE TABLE `mensaje` (
  `id` int(11) NOT NULL,
  `foro_id` int(11) DEFAULT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `text` text NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  `likes` int(11) NOT NULL DEFAULT 0,
  `imagen` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `noticia`
--

CREATE TABLE `noticia` (
  `id` int(11) NOT NULL,
  `titulo` varchar(100) NOT NULL,
  `id_autor` int(11) DEFAULT NULL,
  `contenido` text DEFAULT NULL,
  `fecha` date NOT NULL,
  `likes` int(11) DEFAULT 0,
  `destacado` tinyint(1) NOT NULL DEFAULT 0,
  `imagen1` varchar(255) DEFAULT NULL,
  `liga` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id` int(11) NOT NULL,
  `nombre` varchar(15) NOT NULL,
  `email` varchar(30) NOT NULL,
  `password` varchar(100) NOT NULL,
  `rol` char(1) NOT NULL DEFAULT 'u' COMMENT '(u)suario(default), (a)dmin, (e)ditor, (m)oderador',
  `liga_fav` varchar(20) DEFAULT NULL,
  `imagen` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;


CREATE TABLE `bloqueados` (
  `id_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;
--
-- Índices para tablas volcadas
--
--
ALTER TABLE `bloqueados`
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `favoritos_foro`
--
ALTER TABLE `favoritos_foro`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`),
  ADD KEY `foro_id` (`foro_id`);

--
-- Indices de la tabla `foro`
--
ALTER TABLE `foro`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `ligas`
--
ALTER TABLE `ligas`
  ADD PRIMARY KEY (`nombre`);

--
-- Indices de la tabla `likes_mensajes`
--
ALTER TABLE `likes_mensajes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`,`mensaje_id`),
  ADD KEY `mensaje_id` (`mensaje_id`);

--
-- Indices de la tabla `likes_noticias`
--
ALTER TABLE `likes_noticias`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`),
  ADD KEY `noticia_id` (`noticia_id`);

--
-- Indices de la tabla `mensaje`
--
ALTER TABLE `mensaje`
  ADD PRIMARY KEY (`id`),
  ADD KEY `foro_id` (`foro_id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indices de la tabla `noticia`
--
ALTER TABLE `noticia`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_id_autor` (`id_autor`),
  ADD KEY `liga` (`liga`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`),
  ADD KEY `liga_fav` (`liga_fav`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `favoritos_foro`
--
ALTER TABLE `favoritos_foro`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `likes_mensajes`
--
ALTER TABLE `likes_mensajes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `likes_noticias`
--
ALTER TABLE `likes_noticias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `mensaje`
--
ALTER TABLE `mensaje`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `noticia`
--
ALTER TABLE `noticia`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

ALTER TABLE `bloqueados`
  ADD CONSTRAINT `bloqueados_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id`) ON DELETE CASCADE;
--
-- Filtros para la tabla `favoritos_foro`
--
ALTER TABLE `favoritos_foro`
  ADD CONSTRAINT `favoritos_foro_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `favoritos_foro_ibfk_2` FOREIGN KEY (`foro_id`) REFERENCES `foro` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `likes_mensajes`
--
ALTER TABLE `likes_mensajes`
  ADD CONSTRAINT `likes_mensajes_ibfk_1` FOREIGN KEY (`mensaje_id`) REFERENCES `mensaje` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `likes_mensajes_ibfk_2` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `likes_noticias`
--
ALTER TABLE `likes_noticias`
  ADD CONSTRAINT `fk_noticia_likes` FOREIGN KEY (`noticia_id`) REFERENCES `noticia` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_usuario_likes` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `mensaje`
--
ALTER TABLE `mensaje`
  ADD CONSTRAINT `mensaje_ibfk_1` FOREIGN KEY (`foro_id`) REFERENCES `foro` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `mensaje_ibfk_2` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `noticia`
--
ALTER TABLE `noticia`
  ADD CONSTRAINT `fk_id_autor` FOREIGN KEY (`id_autor`) REFERENCES `usuario` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `noticia_ibfk_1` FOREIGN KEY (`liga`) REFERENCES `ligas` (`nombre`) ON DELETE SET NULL;

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `usuario_ibfk_1` FOREIGN KEY (`liga_fav`) REFERENCES `ligas` (`nombre`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
