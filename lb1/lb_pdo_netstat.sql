SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

CREATE DATABASE IF NOT EXISTS `lb_pdo_netstat`;
USE `lb_pdo_netstat`;

DROP TABLE IF EXISTS `seanse`;
DROP TABLE IF EXISTS `client`;

CREATE TABLE `client` (
  `id_client` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `login` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `ip` varchar(255) NOT NULL,
  `balance` int(11) NOT NULL,
  PRIMARY KEY (`id_client`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `client` (`id_client`, `name`, `login`, `password`, `ip`, `balance`) VALUES
(0, 'Admin', 'admin', 'admin', '0.0.0.0', 34122),
(1, 'admln', 'admln', 'hack', '0.0.0.1', 999999),
(123, 'Victor', 'vic123', '123', '62.16.64.0', 12231),
(231, 'Igor', 'Igor231', '231', '62.16.95.255', -412),
(789, 'Max', 'Max789', '789', '178.219.184.0', 0),
(456, 'Anna', 'anna456', '456', '192.168.0.10', 5000),
(567, 'Oleg', 'oleg567', '567', '10.0.0.5', 1200),
(678, 'Nina', 'nina678', '678', '172.16.5.2', 300);

CREATE TABLE `seanse` (
  `id_seanse` int(11) NOT NULL,
  `start` time NOT NULL,
  `stop` time NOT NULL,
  `in_traffic` int(11) NOT NULL,
  `out_traffic` int(11) NOT NULL,
  `fid_client` int(11) NOT NULL,
  PRIMARY KEY (`id_seanse`),
  KEY `id_seanse` (`id_seanse`),
  CONSTRAINT `fk_client` FOREIGN KEY (`fid_client`) REFERENCES `client` (`id_client`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `seanse` (`id_seanse`, `start`, `stop`, `in_traffic`, `out_traffic`, `fid_client`) VALUES
(0, '13:22:26', '15:06:00', 563, 1231, 0),
(1, '12:22:26', '13:06:00', 1231, 1341, 1),
(2, '02:22:26', '07:06:00', 14231, 13411, 123),
(3, '10:22:26', '17:06:00', 1231, 1341, 231),
(4, '00:22:26', '08:06:00', 19731, 13341, 789),
(5, '09:10:00', '11:45:00', 2048, 4096, 456),
(6, '14:00:00', '16:30:00', 5120, 1024, 567),
(7, '18:20:00', '19:10:00', 800, 600, 678),
(8, '21:00:00', '22:15:00', 1500, 1700, 123),
(9, '06:30:00', '07:45:00', 950, 1100, 1);

COMMIT;