CREATE SCHEMA `rec_face`;
USE `rec_face`;
CREATE TABLE `adminlog` (
  `idadmin_log` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) DEFAULT NULL,
  `apellidos` varchar(45) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`idadmin_log`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8 

CREATE TABLE `alumno` (
  `idalumno` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) DEFAULT NULL,
  `paterno` varchar(45) DEFAULT NULL,
  `materno` varchar(45) DEFAULT NULL,
  `dni` varchar(8) DEFAULT NULL,
  `password` varchar(45) DEFAULT NULL,
  `aula_idaula` int(11) NOT NULL,
  `foto_64` longtext CHARACTER SET ascii,
  `id_azure_persona` varchar(45) DEFAULT NULL,
  `id_azure_rostro` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`idalumno`),
  KEY `fk_alumno_aula_idx` (`aula_idaula`),
  CONSTRAINT `fk_alumno_aula` FOREIGN KEY (`aula_idaula`) REFERENCES `aula` (`idaula`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=71 DEFAULT CHARSET=utf8 

CREATE TABLE `aula` (
  `idaula` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`idaula`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8
