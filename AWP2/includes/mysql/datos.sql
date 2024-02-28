SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+01:00";

INSERT INTO usuario (nombre, email, password) VALUES
('admin', 'admin@example.com', 'adminpass'),
('usuario1', 'usuario1@example.com', 'password1'),
('usuario2', 'usuario2@example.com', 'password2');

INSERT INTO noticia (titulo, autor, contenido, fecha) VALUES
('Título de la Noticia 1', 'usuario1', 'Contenido de la Noticia 1','2024-03-09'),
('Título de la Noticia 2', 'usuario2', 'Contenido de la Noticia 2','2024-03-12');

INSERT INTO foro (titulo, descripcion, fecha) VALUES
('Título del Foro 1', 'Descripción del Foro 1','2024-04-11'),
('Título del Foro 2', 'Descripción del Foro 2','2024-03-09');

