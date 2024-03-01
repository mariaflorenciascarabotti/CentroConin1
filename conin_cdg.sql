-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 26-02-2024 a las 21:40:33
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
-- Base de datos: `conin_cdg`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alimentos`
--

CREATE TABLE `alimentos` (
  `grupo_alimenticio` int(11) NOT NULL,
  `tipo_alimenticio` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `alimentos`
--

INSERT INTO `alimentos` (`grupo_alimenticio`, `tipo_alimenticio`) VALUES
(1, 'Lacteos'),
(2, 'Cereales / Legumbre'),
(3, 'Frutas / Verdura'),
(4, 'Otro');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bolson`
--

CREATE TABLE `bolson` (
  `id_bolson` int(11) NOT NULL,
  `id_tutor` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `fecha` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `bolson`
--

INSERT INTO `bolson` (`id_bolson`, `id_tutor`, `id_usuario`, `fecha`) VALUES
(1, 1, 1, '2024-02-13 20:31:42'),
(2, 1, 1, '2024-02-20 18:36:04'),
(3, 1, 1, '2024-02-20 18:39:35'),
(4, 1, 1, '2024-02-20 18:39:56'),
(5, 1, 1, '2024-02-20 19:01:57'),
(6, 1, 1, '2024-02-20 19:03:08'),
(7, 1, 1, '2024-02-20 19:03:27'),
(8, 1, 1, '2024-02-26 16:48:29'),
(9, 1, 1, '2024-02-26 17:24:40');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `desnutricion`
--

CREATE TABLE `desnutricion` (
  `grado_desnutricion` int(11) NOT NULL,
  `tipo_desnutricion` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `desnutricion`
--

INSERT INTO `desnutricion` (`grado_desnutricion`, `tipo_desnutricion`) VALUES
(1, 'Leve'),
(2, 'Moderada'),
(3, 'Grave');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `familia`
--

CREATE TABLE `familia` (
  `id_tutor` int(11) NOT NULL,
  `dni_tutor` int(11) NOT NULL,
  `nombre_tutor` varchar(50) NOT NULL,
  `apellido_tutor` varchar(50) NOT NULL,
  `domicilio` varchar(100) NOT NULL,
  `telefono_tutor` varchar(15) NOT NULL,
  `vinculo` varchar(20) NOT NULL,
  `infantes_hasta6` int(11) NOT NULL,
  `infantes_mayores6` int(11) NOT NULL,
  `fecha_ingreso` datetime NOT NULL DEFAULT current_timestamp(),
  `grado_desnutricion` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `familia`
--

INSERT INTO `familia` (`id_tutor`, `dni_tutor`, `nombre_tutor`, `apellido_tutor`, `domicilio`, `telefono_tutor`, `vinculo`, `infantes_hasta6`, `infantes_mayores6`, `fecha_ingreso`, `grado_desnutricion`) VALUES
(1, 12345678, 'Maria', 'Rodriguez', 'Av. Libertad 1245', '3471554236', 'madre', 2, 1, '2024-02-13 19:14:49', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `id_prod` int(11) NOT NULL,
  `nombre` varchar(75) NOT NULL,
  `marca` varchar(75) NOT NULL,
  `unidad_medida` varchar(10) NOT NULL,
  `lote` varchar(50) NOT NULL,
  `fecha_vencimiento` date NOT NULL,
  `cantidad` float NOT NULL,
  `alerta_vencimiento` date NOT NULL,
  `precio` float NOT NULL,
  `grupo_alimenticio` int(11) NOT NULL,
  `observaciones` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`id_prod`, `nombre`, `marca`, `unidad_medida`, `lote`, `fecha_vencimiento`, `cantidad`, `alerta_vencimiento`, `precio`, `grupo_alimenticio`, `observaciones`) VALUES
(1, 'Harina 0000        ', 'Blancaflor        ', '1 kg      ', 'MC44148', '2024-05-22', 26, '2024-05-02', 0, 2, ''),
(2, 'leche    ', 'sancor    ', '1 ltr    ', '541lo', '2024-10-10', 15, '2024-09-10', 850, 1, ''),
(3, 'mermelada', 'marolio', '250gr', '456lp', '2024-10-20', 36, '2024-09-10', 500, 3, '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `prod_selecionados`
--

CREATE TABLE `prod_selecionados` (
  `id_selec` int(11) NOT NULL,
  `id_bolson` int(11) NOT NULL,
  `id_prod` int(11) NOT NULL,
  `cantidad_selec` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `prod_selecionados`
--

INSERT INTO `prod_selecionados` (`id_selec`, `id_bolson`, `id_prod`, `cantidad_selec`) VALUES
(1, 1, 1, 2),
(2, 2, 1, 1),
(3, 3, 1, 1),
(4, 4, 1, 1),
(5, 5, 1, 1),
(6, 6, 1, 1),
(7, 7, 1, 1),
(8, 8, 1, 18),
(9, 9, 2, 21);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--

CREATE TABLE `rol` (
  `id_rol` int(11) NOT NULL,
  `rol` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `rol`
--

INSERT INTO `rol` (`id_rol`, `rol`) VALUES
(1, 'Administrador'),
(2, 'Voluntario'),
(3, 'Invitado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id_usuario` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellido` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `usuario` varchar(25) NOT NULL,
  `clave` varchar(100) NOT NULL,
  `id_rol` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id_usuario`, `nombre`, `apellido`, `email`, `usuario`, `clave`, `id_rol`) VALUES
(1, 'admin', 'admin', 'admin@dominio.com', 'admin', '21232f297a57a5a743894a0e4a801fc3', 1),
(2, 'Ines', 'Hernandez', 'ines_h@dominio.com', 'ine_h', '202cb962ac59075b964b07152d234b70', 2),
(3, 'Pedro', 'Suarez', 'psuarez@dominio.com', 'pedro_s', '202cb962ac59075b964b07152d234b70', 3),
(6, 'Hugo', 'Alvarez', 'hugo@gmail.com', 'hugo', '202cb962ac59075b964b07152d234b70', 3);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `alimentos`
--
ALTER TABLE `alimentos`
  ADD PRIMARY KEY (`grupo_alimenticio`);

--
-- Indices de la tabla `bolson`
--
ALTER TABLE `bolson`
  ADD PRIMARY KEY (`id_bolson`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `id_tutor` (`id_tutor`);

--
-- Indices de la tabla `desnutricion`
--
ALTER TABLE `desnutricion`
  ADD PRIMARY KEY (`grado_desnutricion`);

--
-- Indices de la tabla `familia`
--
ALTER TABLE `familia`
  ADD PRIMARY KEY (`id_tutor`),
  ADD KEY `grado_desnutricion` (`grado_desnutricion`);

--
-- Indices de la tabla `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`id_prod`),
  ADD KEY `grupo_alimenticio` (`grupo_alimenticio`);

--
-- Indices de la tabla `prod_selecionados`
--
ALTER TABLE `prod_selecionados`
  ADD PRIMARY KEY (`id_selec`),
  ADD KEY `id_prod` (`id_prod`),
  ADD KEY `id_bolson` (`id_bolson`);

--
-- Indices de la tabla `rol`
--
ALTER TABLE `rol`
  ADD PRIMARY KEY (`id_rol`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id_usuario`),
  ADD KEY `rol` (`id_rol`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `alimentos`
--
ALTER TABLE `alimentos`
  MODIFY `grupo_alimenticio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `bolson`
--
ALTER TABLE `bolson`
  MODIFY `id_bolson` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `desnutricion`
--
ALTER TABLE `desnutricion`
  MODIFY `grado_desnutricion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `familia`
--
ALTER TABLE `familia`
  MODIFY `id_tutor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `producto`
--
ALTER TABLE `producto`
  MODIFY `id_prod` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `prod_selecionados`
--
ALTER TABLE `prod_selecionados`
  MODIFY `id_selec` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `rol`
--
ALTER TABLE `rol`
  MODIFY `id_rol` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `bolson`
--
ALTER TABLE `bolson`
  ADD CONSTRAINT `bolson-familia` FOREIGN KEY (`id_tutor`) REFERENCES `familia` (`id_tutor`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `bolson-usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `familia`
--
ALTER TABLE `familia`
  ADD CONSTRAINT `familia_ibfk_1` FOREIGN KEY (`grado_desnutricion`) REFERENCES `desnutricion` (`grado_desnutricion`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Filtros para la tabla `producto`
--
ALTER TABLE `producto`
  ADD CONSTRAINT `producto_ibfk_1` FOREIGN KEY (`grupo_alimenticio`) REFERENCES `alimentos` (`grupo_alimenticio`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `prod_selecionados`
--
ALTER TABLE `prod_selecionados`
  ADD CONSTRAINT `prod_selecionados_ibfk_1` FOREIGN KEY (`id_prod`) REFERENCES `producto` (`id_prod`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `prod_selecionados_ibfk_2` FOREIGN KEY (`id_bolson`) REFERENCES `bolson` (`id_bolson`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `usuario_ibfk_1` FOREIGN KEY (`id_rol`) REFERENCES `rol` (`id_rol`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
