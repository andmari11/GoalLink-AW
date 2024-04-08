-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 08-04-2024 a las 13:01:47
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

--
-- Volcado de datos para la tabla `ligas`
--

INSERT INTO `ligas` (`nombre`, `logo`) VALUES
('Bundesliga', 'img/ligas/Bundesliga_logo_(2017).svg.png'),
('LaLiga', 'img/ligas/laliga.png'),
('Premier League', 'img/ligas/prem.jpg');

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id`, `nombre`, `email`, `password`, `rol`, `liga_fav`) VALUES
(1, 'admin', 'admin@example.com', '$2y$10$oOCBvgnbpvzucFWYeNHGK.xvDcQACGmtnQydrEc8GRHjce9BbERtW', 'a', 'Bundesliga'),
(2, 'usuario1', 'usuario1@ucm.es', '$2y$10$ucxAK35V8Ly494b2DPPjt.tWfnFo3aBET8LFslLzWLaPQNmmzra.G', 'e', 'Bundesliga'),
(3, 'usuario2', 'usuario2@ucm.es', '$2y$10$r1YkRh6g0z3chIW/PCY58.KY8amuJxpB7Ufh5h2iRgw//gOBimIaG', 'u', 'LaLiga');


--
-- Volcado de datos para la tabla `noticia`
--

INSERT INTO `noticia` (`id`, `titulo`, `id_autor`, `contenido`, `fecha`, `likes`, `destacado`, `imagen1`, `liga`) VALUES
(1, 'El estadio Santiago Bernabéu, hogar del Real Madrid', 1, 'El estadio Santiago Bernabéu, hogar del Real Madrid, está experimentando una transformación radical que promete convertirlo en uno de los estadios más avanzados del mundo. Las obras de remodelación, que comenzaron a finales de mayo, tienen un coste estimado de 575 millones de euros y aumentarán la capacidad del estadio en 3.000 espectadores. Además de incrementar el aforo, el nuevo Bernabéu contará con tecnología de punta en la fachada exterior, una cubierta retráctil y un videomarcador de 360 grados.\r\n\r\nUno de los aspectos más destacados del nuevo Bernabéu es su sistema wifi de alta velocidad, diseñado para ofrecer una experiencia inigualable a los 80.000 espectadores. Este sistema permitirá a los aficionados disfrutar de una conectividad sin precedentes durante los partidos. A pesar de los avances significativos, las obras de remodelación aún no han terminado y se prevén tres años más de trabajos en los alrededores hasta 2027. Sin embargo, cada rincón del nuevo Bernabéu está en ebullición gracias al esfuerzo de todos los equipos involucrados en el proyecto.\r\n\r\nLa transformación del Bernabéu ha generado un gran impacto en la zona de Chamartín, con un aumento del 46% en el precio del alquiler desde que se anunció la reforma del estadio. Esta reforma ha convertido a la zona en el \"distrito Real Madrid\", un lugar que promete ser un punto de referencia para los aficionados al fútbol de todo el mundo. En resumen, el nuevo Santiago Bernabéu promete ser mucho más que un estadio. Con su diseño innovador y su tecnología de vanguardia, se está convirtiendo en un símbolo del futuro del fútbol.', '2024-04-08', 0, 1, 'img/noticias/berna.jpg', 'LaLiga');

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
