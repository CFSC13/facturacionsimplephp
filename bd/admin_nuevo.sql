-- phpMyAdmin SQL Dump
-- version 2.10.3
-- http://www.phpmyadmin.net
-- 
-- Servidor: localhost
-- Tiempo de generación: 13-10-2022 a las 19:49:29
-- Versión del servidor: 5.0.51
-- Versión de PHP: 5.2.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

-- 
-- Base de datos: `admin_nuevo`
-- 

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `areas`
-- 

CREATE TABLE `areas` (
  `id_area` int(11) NOT NULL auto_increment,
  `nombre_area` varchar(150) character set latin1 default NULL,
  `id_secretaria` int(11) default NULL,
  PRIMARY KEY  (`id_area`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- 
-- Volcar la base de datos para la tabla `areas`
-- 

INSERT INTO `areas` VALUES (1, 'administrador', 1);

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `grupos_menu`
-- 

CREATE TABLE `grupos_menu` (
  `id_grupo` int(11) NOT NULL auto_increment,
  `nombre_grupo` varchar(50) character set latin1 default NULL,
  `orden` int(11) default NULL,
  `icono` varchar(50) NOT NULL,
  PRIMARY KEY  (`id_grupo`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=23 ;

-- 
-- Volcar la base de datos para la tabla `grupos_menu`
-- 

INSERT INTO `grupos_menu` VALUES (1, 'administrar', 0, 'fas fa-cog');
INSERT INTO `grupos_menu` VALUES (3, 'seguridad', 5, 'fas fa-lock');

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `items_interno`
-- 

CREATE TABLE `items_interno` (
  `id_item` int(11) NOT NULL auto_increment,
  `nombre_item` varchar(100) character set latin1 default NULL,
  `url` varchar(100) character set latin1 default NULL,
  `id_grupo` int(11) default NULL,
  PRIMARY KEY  (`id_item`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=80 ;

-- 
-- Volcar la base de datos para la tabla `items_interno`
-- 

INSERT INTO `items_interno` VALUES (1, 'grupos del menu', 'grupos_menu.php', 1);
INSERT INTO `items_interno` VALUES (2, 'items del menu', 'items.php', 1);
INSERT INTO `items_interno` VALUES (5, 'areas', 'areas.php', 1);
INSERT INTO `items_interno` VALUES (7, 'usuarios', 'usuarios.php', 1);
INSERT INTO `items_interno` VALUES (8, 'clave', 'clave.php', 3);

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `items_x_areas`
-- 

CREATE TABLE `items_x_areas` (
  `id_area` int(11) default NULL,
  `id_item` int(11) default NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 
-- Volcar la base de datos para la tabla `items_x_areas`
-- 


-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `items_x_usuario`
-- 

CREATE TABLE `items_x_usuario` (
  `id_item` int(11) default NULL,
  `id_usuario` int(11) default NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 
-- Volcar la base de datos para la tabla `items_x_usuario`
-- 

INSERT INTO `items_x_usuario` VALUES (7, 4);

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `usuarios`
-- 

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL auto_increment,
  `nombre` varchar(100) character set latin1 default NULL,
  `apellido` varchar(100) character set latin1 default NULL,
  `usuario` varchar(100) character set latin1 default NULL,
  `clave` varchar(30) character set latin1 default NULL,
  `telefono` varchar(60) character set latin1 default NULL,
  `correo` varchar(50) character set latin1 default NULL,
  `activo` int(11) default NULL,
  `id_area` int(11) default NULL,
  `responsable_area` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id_usuario`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;

-- 
-- Volcar la base de datos para la tabla `usuarios`
-- 

INSERT INTO `usuarios` VALUES (1, 'admin', 'admin', 'admin', 'admin', 'admin', 'test@test.com', 1, 1, 1);
