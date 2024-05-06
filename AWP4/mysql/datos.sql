-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 06-05-2024 a las 12:52:07
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
-- Volcado de datos para la tabla `bloqueados`
--

INSERT INTO `bloqueados` (`id_usuario`) VALUES
(5);

--
-- Volcado de datos para la tabla `favoritos_foro`
--

INSERT INTO `favoritos_foro` (`id`, `usuario_id`, `foro_id`) VALUES
(2, 1, 1),
(3, 2, 2),
(4, 3, 2),
(5, 3, 1),
(6, 4, 2);

--
-- Volcado de datos para la tabla `foro`
--

INSERT INTO `foro` (`id`, `titulo`, `descripcion`, `fecha`, `favoritos`, `destacado`, `imagen`) VALUES
(1, 'Nuevo Estadio Santiago Bernabéu', '¡Únete al debate sobre el Nuevo Estadio Santiago Bernabéu! Comparte tus opiniones y expectativas sobre esta emblemática renovación.', '2024-02-15', 4, 1, 'img/foros/GGxMokmX0AAKRwk.jpg'),
(2, 'Cesión de Arda Güler??', '¡Comparte tus ideas sobre la posible cesión de Arda Güler! Debate sobre su papel en el equipo y las implicaciones de esta decisión para el futuro del club.', '2024-03-15', 23, 1, 'img/foros/Arda-Guler-point-sky.jpg');

--
-- Volcado de datos para la tabla `ligas`
--

INSERT INTO `ligas` (`nombre`, `logo`) VALUES
('Bundesliga', 'img/ligas/Bundesliga_logo_(2017).svg.png'),
('LaLiga', 'img/ligas/laliga.png'),
('PremierLeague', 'img/ligas/prem.jpg');

--
-- Volcado de datos para la tabla `likes_mensajes`
--

INSERT INTO `likes_mensajes` (`id`, `usuario_id`, `mensaje_id`) VALUES
(1, 1, 7),
(4, 2, 6),
(6, 2, 7),
(3, 2, 8),
(5, 2, 11),
(10, 3, 6),
(9, 3, 8),
(7, 3, 12),
(8, 3, 13),
(2, 4, 8);

--
-- Volcado de datos para la tabla `likes_noticias`
--

INSERT INTO `likes_noticias` (`id`, `usuario_id`, `noticia_id`) VALUES
(1, 1, 3),
(2, 4, 1),
(3, 2, 1),
(4, 2, 2),
(5, 3, 1);

--
-- Volcado de datos para la tabla `mensaje`
--

INSERT INTO `mensaje` (`id`, `foro_id`, `usuario_id`, `text`, `fecha`, `hora`, `likes`, `imagen`) VALUES
(6, 2, 1, 'Gran jugador, el Real Madrid tiene la suerte de tener demasiados jugadores con talento!!', '2024-05-06', '11:55:48', 2, 'img/mensajes/arda-güler.gif'),
(7, 1, 1, 'Echo de menos el carisma del antiguo...', '2024-05-06', '12:02:08', 2, 'img/mensajes/14491521435015.gif'),
(8, 2, 4, 'Está demostrando que tiene calidad de sobra para el Madrid!!!', '2024-05-06', '12:12:23', 3, ''),
(9, 1, 4, 'PARECE UNA LATA DE SARDINAS ', '2024-05-06', '12:18:56', 0, 'img/mensajes/lata-de-sardinas-barbara-pozi-1629737107.gif'),
(10, 2, 2, 'No me convence... Además teniendo a Endrick a la vuelta de la esquina, enviarlo a la Liga italiana como a Brahim me parece una buena idea', '2024-05-06', '12:37:22', 0, ''),
(11, 1, 2, 'ME ENCANTA!! En persona impresiona muucho', '2024-05-06', '12:40:32', 1, 'img/mensajes/cristiano-ronaldo.jpg'),
(12, 1, 3, 'El mejor estadio del mundo!!!!', '2024-05-06', '12:41:58', 1, ''),
(13, 2, 3, 'Me da pena verle en el banquillo del madrid... tanto potencial.....', '2024-05-06', '12:43:29', 1, ''),
(17, 2, 5, '(usuario bloqueado, sólo verá este mensaje los moderadores y admin)', '2024-05-06', '12:49:00', 0, ''),
(18, 2, 5, 'Mensaje de ejemplo (este usuario bloqueado y sólo verá este mensaje los moderadores y admin)\r\n\r\n', '2024-05-06', '12:49:30', 0, ''),
(19, 1, 5, 'Mensaje de ejemplo (este usuario bloqueado y sólo verá este mensaje los moderadores y admin)\r\n\r\n', '2024-05-06', '12:50:09', 0, '');

--
-- Volcado de datos para la tabla `noticia`
--

INSERT INTO `noticia` (`id`, `titulo`, `id_autor`, `contenido`, `fecha`, `likes`, `destacado`, `imagen1`, `liga`) VALUES
(1, 'El estadio Santiago Bernabéu, hogar del Real Madrid', 1, 'El estadio Santiago Bernabéu, hogar del Real Madrid, está experimentando una transformación radical que promete convertirlo en uno de los estadios más avanzados del mundo. Las obras de remodelación, que comenzaron a finales de mayo, tienen un coste estimado de 575 millones de euros y aumentarán la capacidad del estadio en 3.000 espectadores. Además de incrementar el aforo, el nuevo Bernabéu contará con tecnologí­a de punta en la fachada exterior, una cubierta retráctil y un videomarcador de 360 grados.\r\n\r\nUno de los aspectos más destacados del nuevo Bernabéu es su sistema wifi de alta velocidad, diseñado para ofrecer una experiencia inigualable a los 80.000 espectadores. Este sistema permitirá a los aficionados disfrutar de una conectividad sin precedentes durante los partidos. A pesar de los avances significativos, las obras de remodelación aún no han terminado y se preveen tres años más de trabajos en los alrededores hasta 2027. Sin embargo, cada rincón del nuevo Bernabéu está en ebullición gracias al esfuerzo de todos los equipos involucrados en el proyecto.\r\n\r\nLa transformación del Bernabéu ha generado un gran impacto en la zona de Chamartí­n, con un aumento del 46% en el precio del alquiler desde que se anunció la reforma del estadio. Esta reforma ha convertido a la zona en el \"distrito Real Madrid\", un lugar que promete ser un punto de referencia para los aficionados al fútbol de todo el mundo. En resumen, el nuevo Santiago Bernabéu promete ser mucho más que un estadio. Con su diseño innovador y su tecnologí­a de vanguardia, se está convirtiendo en un sí­mbolo del futuro del fútbol.', '2024-04-08', 15, 1, 'img/noticias/berna.jpg', 'LaLiga'),
(2, 'Manchester United: El Gigante Histórico de la PremierLeague', 1, 'La primera encarnación del Manchester United, conocida como Newton Heath LYR Football Club, comenzó a jugar partidos amistosos en 1878. En enero de 1902, el club fue puesto en liquidación y el capitán Harry Stafford consiguió el apoyo de 4 empresarios británicos para darle nueva vida al equipo. En 1907, el club, ahora conocido como Manchester United, ganó su primer tí­tulo de liga y ascendió a la First Division.\r\n\r\nEl Manchester United ha ganado la liga inglesa en 20 ocasiones, desde 1907 hasta el 2013, siendo el club que más veces la ha ganado, superando por un tí­tulo al Liverpool. Si vemos solo los tí­tulos del Manchester United en la PremierLeague (a partir de 1992), encontramos que se mantiene en la punta con 13 campeonatos. Asimismo, el Manchester consiguió 12 Copas FA, 5 Copas de la Liga, 21 Community Shield (nuevamente lí­der histórico) y 2 de la Segunda División de Inglaterra.\r\n\r\nEl historial de tí­tulos del Manchester United no se remite solo al ámbito local ya que son uno de los clubes ingleses con mayor cantidad de campeonatos internacionales. En ese sentido, encontramos 3 Champions League, una Liga de Europa, una Supercopa de Europa, una Recopa de Europa, una Copa Intercontinental y un Mundial de Clubes.\r\n\r\nHablar del Manchester United en la PremierLeague es como hablar de Rafael Nadal en Roland Garros o Titanic en los Premios Oscar, simplemente el referente máximo en su espacio natural.', '2024-04-11', 21, 1, 'img/noticias/United.jpeg', 'PremierLeague'),
(3, 'Xabi Alonso: Un paso hacia la gloria', 1, 'El Bayer Leverkusen de Xabi Alonso está a un paso de acabar con la leyenda del Vicekusen, que surgió en el cambio de siglo cuando el equipo de las aspirinas acumuló segundos lugares sin llegar a ganar la Bundesliga que esta ocasión sólo difícilmente puede escapársele.\r\n\r\nEl camino más claro para el tí­tulo serí­a derrotar al Werder Bremen el domingo, pero el Leverkusen podrí­a ser campeón incluso el sábado si el Bayern pierde contra el Colonia y el Stuttgart contra el Eintracht Frankfort.\r\n\r\nSi el Bayern y el Stuttgart se dejan los puntos -ambos 16 por debajo- al Leverkusen le bastarí­a empatar contra el Bremen para coronarse campeón alemán por primera vez en su historia.\r\n\r\nEl tí­tulo podrí­a llevar incluso a que se modificara el texto del himno del club. \"Tenemos la Copa de la UEFA, tenemos la Copa de Alemania y la Bundesliga la ganaremos la próxima vez\", dice el texto.\r\n\r\nEsa invocación de \"la próxima vez\" fue durante un tiempo objeto de sarcasmo por parte de los seguidores de otros clubes que veía como el Leverkusen tendí­a a quedarse a las puertas del tí­tulo.\r\n\r\nLa situación más dramática se dio en 2000, cuando el Leverkusen le bastaba en la última jornada un empate a domicilio contra el Unterhaching, un equipo que ya habí­a descendido, para coronarse campeón.\r\n\r\nEl Leverkusen perdió por 2-0 y la ensaladera -el trofeo de la Bundesliga- tuvo que ser trasladada en helicóptero de Unterhaching a Munich donde el Bayern, que ya habí­a felicitado anticipadamente el rival por el tí­tulo, se coronó campeón contra todo pronóstico.\r\n\r\nDos años después, en la temporada 2001/2002, el Leverkusen -dirigido por Klaus Topmaller-, jugó un fútbol que sedujo a toda Europa. Dominó la Bundesliga casi de principio a fin y llegó a la final de la Copa de Alemania y de la Liga de Campeones.\r\n\r\nUn bajón en las últimas tres jornadas le permitió al Borussia Dortmund arrebatarle el tí­tulo de la Bundesliga. La final de la Copa de Alemania -a la que llegaba como favorito- la perdió con el Schalke y la final de la Liga de Campeones la perdió con el Real Madrid.\r\n\r\nAquella ocasión fue la última en la que el Leverkusen rozó³ el tí­tulo de la Bundesliga que ahora no parece posible que se le escape en medio de una temporada casi perfecta.\r\n\r\nLos tres puntos que le falta para asegurarse el tí­tulo, a falta de seis jornadas para que termine la Bundesliga, parecen sólo cuestión de trámite.\r\n\r\nDentro de las cosas que le ha dado Xabi Alonso al Leverkusen, muchos comentaristas han resaltado una mentalidad ganadora muy fuerte que los diferencia de los equipos de 2000 y 2002.\r\n\r\nA lo largo de la temporada el Leverkusen no sólo ha ganado partidos en los que el control que suele tener el campo le da frutos desde el comienzo sino también otros en los que ha tenido viento en contra y ha logrado varias veces darle vuelta a compromisos en los minutos finales.\r\n\r\nEl Leverkusen puede estar por debajo el marcador, los minutos pueden ir pasando de manera inexorable, pero el estilo se mantiene como guiado por una convicción de hierro de que el final dará resultado.\r\n\r\nUn 3-4-3 flexible -que a veces que convierte en un 3-4-2-1 y a veces en un 3-4-5 con Jeremie Frimpong y Alejandro Grimaldo jugando de extremos- es el esquema más habitual que ha utilizado el Leverkusen en esta temporada.\r\n\r\nNo obstante, en la victoria por 3-0 ante el Bayern -con la que ya no quedaron dudas de las posibilidades del tí­tulo- Xabi Alonso varió el esquema y jugó con la defensa de cuatro, con Josip Stasinic y el ecuatoriano Piero Hincapié como laterales.\r\n\r\nAdemás de la Bundesliga, que parece cuestión de trámite, queda por delante la final de la Copa de Alemania -en la que el Leverkusen parte como favorito ante el Kaiserslautern- y el recorrido que le pueda quedar en la Liga Europa.', '2024-04-11', 35, 1, 'img/noticias/Xavi.jpg', 'Bundesliga');

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id`, `nombre`, `email`, `password`, `rol`, `liga_fav`, `imagen`, `salt`) VALUES
(1, 'admin', 'admin@example.com', '$2y$10$xoDmWOinxwlyAYxlnXo5JeM1n1mQoKK6z4UaAKtT7CziCrJaoQKX2', 'a', 'Bundesliga', NULL, 580752289),
(2, 'usuario1', 'usuario1@ucm.es', '$2y$10$5y9eFMhVow9hiodyqvn3Ye4mOHeau4AXPN/d3xLMTtazrM/H1PVTW', 'e', 'Bundesliga', 'img/usuarios/000_DV779097-1-scaled.jpg', 1184907616),
(3, 'usuario2', 'usuario2@ucm.es', '$2y$10$wgeKrGaME5saF6AtoYghvuO8liMr6ZiM/6Aw/dPxRzVVdQmgPkYsm', 'm', 'LaLiga', 'img/usuarios/images (1).jpeg', 447971337),
(4, 'usuario3', 'usuario3@ucm.es', '$2y$10$bk8GeyJhf3ZNcl3tM0sixuYYEqhwR7KdE1P86SOnZczXF01S0JWOS', 'u', 'LaLiga', 'img/usuarios/images.jpeg', 127964501),
(5, 'usuario4', 'usuario4@ucm.es', '$2y$10$M3C5p5wc1RHL/G4tAESOR.2A73mBDzvB9kk3nCS8dNW2Y.rgEIVa6', 'u', 'PremierLeague', NULL, 1422777224);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
