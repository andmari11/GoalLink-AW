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
(1, 'El estadio Santiago BernabÃ©u, hogar del Real Madrid', 1, 'El estadio Santiago BernabÃ©u, hogar del Real Madrid, estÃ¡ experimentando una transformaciÃ³n radical que promete convertirlo en uno de los estadios mÃ¡s avanzados del mundo. Las obras de remodelaciÃ³n, que comenzaron a finales de mayo, tienen un coste estimado de 575 millones de euros y aumentarÃ¡n la capacidad del estadio en 3.000 espectadores. AdemÃ¡s de incrementar el aforo, el nuevo BernabÃ©u contarÃ¡ con tecnologÃ­a de punta en la fachada exterior, una cubierta retrÃ¡ctil y un videomarcador de 360 grados.\r\n\r\nUno de los aspectos mÃ¡s destacados del nuevo BernabÃ©u es su sistema wifi de alta velocidad, diseÃ±ado para ofrecer una experiencia inigualable a los 80.000 espectadores. Este sistema permitirÃ¡ a los aficionados disfrutar de una conectividad sin precedentes durante los partidos. A pesar de los avances significativos, las obras de remodelaciÃ³n aÃºn no han terminado y se prevÃ©n tres aÃ±os mÃ¡s de trabajos en los alrededores hasta 2027. Sin embargo, cada rincÃ³n del nuevo BernabÃ©u estÃ¡ en ebulliciÃ³n gracias al esfuerzo de todos los equipos involucrados en el proyecto.\r\n\r\nLa transformaciÃ³n del BernabÃ©u ha generado un gran impacto en la zona de ChamartÃ­n, con un aumento del 46% en el precio del alquiler desde que se anunciÃ³ la reforma del estadio. Esta reforma ha convertido a la zona en el \"distrito Real Madrid\", un lugar que promete ser un punto de referencia para los aficionados al fÃºtbol de todo el mundo. En resumen, el nuevo Santiago BernabÃ©u promete ser mucho mÃ¡s que un estadio. Con su diseÃ±o innovador y su tecnologÃ­a de vanguardia, se estÃ¡ convirtiendo en un sÃ­mbolo del futuro del fÃºtbol.', '2024-04-08', 0, 1, 'img/noticias/berna.jpg', 'LaLiga'),
(2, 'Manchester United: El Gigante HistÃ³rico de la Premier League', 1, 'La primera encarnaciÃ³n del Manchester United, conocida como Newton Heath LYR Football Club, comenzÃ³ a jugar partidos amistosos en 1878. En enero de 1902, el club fue puesto en liquidaciÃ³n y el capitÃ¡n Harry Stafford consiguiÃ³ el apoyo de 4 empresarios britÃ¡nicos para darle nueva vida al equipo. En 1907, el club, ahora conocido como Manchester United, ganÃ³ su primer tÃ­tulo de liga y ascendiÃ³ a la First Division.\r\n\r\nEl Manchester United ha ganado la liga inglesa en 20 ocasiones, desde 1907 hasta el 2013, siendo el club que mÃ¡s veces la ha ganado, superando por un tÃ­tulo al Liverpool. Si vemos solo los tÃ­tulos del Manchester United en la Premier League (a partir de 1992), encontramos que se mantiene en la punta con 13 campeonatos. Asimismo, el Manchester consiguiÃ³ 12 Copas FA, 5 Copas de la Liga, 21 Community Shield (nuevamente lÃ­der histÃ³rico) y 2 de la Segunda DivisiÃ³n de Inglaterra.\r\n\r\nEl historial de tÃ­tulos del Manchester United no se remite solo al Ã¡mbito local ya que son uno de los clubes ingleses con mayor cantidad de campeonatos internacionales. En ese sentido, encontramos 3 Champions League, una Liga de Europa, una Supercopa de Europa, una Recopa de Europa, una Copa Intercontinental y un Mundial de Clubes.\r\n\r\nHablar del Manchester United en la Premier League es como hablar de Rafael Nadal en Roland Garros o Titanic en los Premios Oscar, simplemente el referente mÃ¡ximo en su espacio natural.', '2024-04-11', 0, 1, 'img/noticias/United.jpeg', 'Premier League'),
(3, 'Xavi Alonso: Un paso hacia la gloria', 1, 'El Bayer Leverkusen de Xabi Alonso estÃ¡ a un paso de acabar con la leyenda del Vicekusen, que surgiÃ³ en el cambio de siglo cuando el equipo de las aspirinas acumulÃ³ segundos lugares sin llegar a ganar la Bundesliga que esta ocasiÃ³n sÃ³lo difÃ­cilmente puede escapÃ¡rsele.\r\n\r\nEl camino mÃ¡s claro para el tÃ­tulo serÃ­a derrotar al Werder Bremen el domingo, pero el Leverkusen podrÃ­a ser campeÃ³n incluso el sÃ¡bado si el Bayern pierde contra el Colonia y el Stuttgart contra el Eintracht FrÃ¡ncfort.\r\n\r\nSi el Bayern y el Stuttgart se dejan los puntos -ambos 16 por debajo- al Leverkusen le bastarÃ­a empatar contra el Bremen para coronarse campeÃ³n alemÃ¡n por primera vez en su historia.\r\n\r\nEl tÃ­tulo podrÃ­a llevar incluso a que se modificara el texto del himno del club. \"Tenemos la Copa de la UEFA, tenemos la Copa de Alemania y la Bundesliga la ganaremos la prÃ³xima vez\", dice el texto.\r\n\r\nEsa invocaciÃ³n de \"la prÃ³xima vez\" fue durante un tiempo objeto de sarcasmo por parte de los seguidores de otros clubes que veÃ­a como el Leverkusen tendÃ­a a quedarse a las puertas del tÃ­tulo.\r\n\r\nLa situaciÃ³n mÃ¡s dramÃ¡tica se dio en 2000, cuando el Leverkusen le bastaba en la Ãºltima jornada un empate a domicilio contra el Unterhaching, un equipo que ya habÃ­a descendido, para coronarse campeÃ³n.\r\n\r\nEl Leverkusen perdiÃ³ por 2-0 y la ensaladera -el trofeo de la Bundesliga- tuvo que ser trasladada en helicÃ³ptero de Unterhaching a MÃºnich donde el Bayern, que ya habÃ­a felicitado anticipadamente el rival por el tÃ­tulo, se coronÃ³ campeÃ³n contra todo pronÃ³stico.\r\n\r\nDos aÃ±os despuÃ©s, en la temporada 2001/2002, el Leverkusen -dirigido por Klaus TopmÃ¶ller-, jugÃ³ un fÃºtbol que sedujo a toda Europa. DominÃ³ la Bundesliga casi de principio a fin y llegÃ³ a la final de la Copa de Alemania y de la Liga de Campeones.\r\n\r\nUn bajÃ³n en las Ãºltimas tres jornadas le permitiÃ³ al Borussia Dortmund arrebatarle el tÃ­tulo de la Bundesliga. La final de la Copa de Alemania -a la que llegaba como favorito- la perdiÃ³ con el Schalke y la final de la Liga de Campeones la perdiÃ³ con el Real Madrid.\r\n\r\nAquella ocasiÃ³n fue la Ãºltima en la que el Leverkusen rozÃ³ el tÃ­tulo de la Bundesliga que ahora no parece posible que se le escape en medio de una temporada casi perfecta.\r\n\r\nLos tres puntos que le falta para asegurarse el tÃ­tulo, a falta de seis jornadas para que termine la Bundesliga, parecen sÃ³lo cuestiÃ³n de trÃ¡mite.\r\n\r\nDentro de las cosas que le ha dado Xabi Alonso al Leverkusen, muchos comentaristas han resaltado una mentalidad ganadora muy fuerte que los diferencia de los equipos de 2000 y 2002.\r\n\r\nA lo largo de la temporada el Leverkusen no sÃ³lo ha ganado partidos en los que el control que suele tener el campo le da frutos desde el comienzo sino tambiÃ©n otros en los que ha tenido viento en contra y ha logrado varias veces darle vuelta a compromisos en los minutos finales.\r\n\r\nEl Leverkusen puede estar por debajo el marcador, los minutos pueden ir pasando de manera inexorable, pero el estilo se mantiene como guiado por una convicciÃ³n de hierro de que el final darÃ¡ resultado.\r\n\r\nUn 3-4-3 flexible -que a veces que convierte en un 3-4-2-1 y a veces en un 3-4-5 con Jeremie Frimpong y Alejandro Grimaldo jugando de extremos- es el esquema mÃ¡s habitual que ha utilizado el Leverkusen en esta temporada.\r\n\r\nNo obstante, en la victoria por 3-0 ante el Bayern -con la que ya no quedaron dudas de las posibilidades del tÃ­tulo- Xabi Alonso variÃ³ el esquema y jugÃ³ con la defensa de cuatro, con Josip Stasinic y el ecuatoriano Piero HincapiÃ© como laterales.\r\n\r\nAdemÃ¡s de la Bundesliga, que parece cuestiÃ³n de trÃ¡mite, queda por delante la final de la Copa de Alemania -en la que el Leverkusen parte como favorito ante el Kaiserslautern- y el recorrido que le pueda quedar en la Liga Europa.', '2024-04-11', 0, 1, 'img/noticias/Xavi.jpg', 'Bundesliga');

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
