
--
-- Volcado de datos para la tabla `foro`
--

INSERT INTO `foro` (`id`, `titulo`, `descripcion`, `fecha`, `likes`, `destacado`) VALUES
(1, 'Título del Foro 1', 'Descripción del Foro 1', '2024-04-11', 2, 1),
(2, 'Título del Foro 2', 'Descripción del Foro 2', '2024-03-09', 1, 0);


--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id`, `nombre`, `email`, `password`, `rol`) VALUES
(1,'admin', 'admin@example.com', 'adminpass', 'a'),
(2,'usuario1', 'usuario1@example.com', 'password1', 'e'),
(3,'usuario2', 'usuario2@example.com', 'password2', 'm'),
(4,'usuario3', 'usuario3@example.com', 'password2', 'u');

--
-- Volcado de datos para la tabla `noticia`
--

INSERT INTO `noticia` (`id`, `titulo`, `id_autor`, `contenido`, `fecha`, `likes`, `destacado`) VALUES
(1, 'Título de la Noticia 1', '2', 'Contenido de la Noticia 1', '2024-03-09', 20, 1),
(2, 'Título de la Noticia 2', '3', 'Contenido de la Noticia 2', '2024-03-12', 10, 1);
