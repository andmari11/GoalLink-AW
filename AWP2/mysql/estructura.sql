SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+01:00";

CREATE TABLE `usuario` (
    `nombre` varchar(15) NOT NULL PRIMARY KEY,
    `email` varchar(30) NOT NULL,
    `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `noticia` (
    `id` int AUTO_INCREMENT PRIMARY KEY,
    `titulo` varchar(100) NOT NULL,
    `autor` varchar(15) NOT NULL,
    `contenido` text,
    `fecha` date NOT NULL,
    `likes` int DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `foro` (
    `id` int AUTO_INCREMENT PRIMARY KEY,
    `titulo` varchar(100) NOT NULL,
    `descripcion` varchar(200),
    `fecha` date NOT NULL,
    `likes` int DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

ALTER TABLE `noticia`
ADD CONSTRAINT `fk_autor_usuario` FOREIGN KEY (`autor`) REFERENCES `usuario`(`nombre`) ON UPDATE CASCADE;
