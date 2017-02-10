-- phpMyAdmin SQL Dump
-- version 2.11.9.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 01, 2015 at 09:45 AM
-- Server version: 5.0.67
-- PHP Version: 5.2.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `sisplus_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `teachers`
--

CREATE TABLE IF NOT EXISTS `teachers` (
  `id` int(10) NOT NULL auto_increment,
  `group` varchar(50) NOT NULL,
  `fname` varchar(50) NOT NULL,
  `mname` char(1) NOT NULL,
  `lname` varchar(50) NOT NULL,
  `ext` varchar(10) default '',
  `uname` varchar(25) default NULL,
  `pword` varchar(255) default NULL,
  `permanent_address` text,
  `city_address` text,
  `position` varchar(100) default NULL,
  `sex` char(1) default NULL,
  `civil_status` char(1) default NULL,
  `email_address` varchar(50) default NULL,
  `cellphone_no` varchar(25) default NULL,
  `bday` date default '0000-00-00',
  `bplace` varchar(25) default NULL,
  `date_hired` date default '0000-00-00',
  `pic_filename` varchar(50) default '',
  `log_count` int(11) NOT NULL,
  `last_login` datetime NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=272 ;

--
-- Dumping data for table `teachers`
--

INSERT INTO `teachers` (`id`, `group`, `fname`, `mname`, `lname`, `ext`, `uname`, `pword`, `permanent_address`, `city_address`, `position`, `sex`, `civil_status`, `email_address`, `cellphone_no`, `bday`, `bplace`, `date_hired`, `pic_filename`, `log_count`, `last_login`) VALUES
(30, 'Adviser', 'Joseph Rey', 'B', 'Gerundio', '', 'gerundio.jb', '84506646edf3a5593f806091490dc33568a636f2', '319 Acacia St. Bucal Calamba City', '319 Acacia St. Bucal Calamba City', 'Applications Programmer', '2', '1', 'elearningcentral@dualtech.org', '09166630141', '1971-02-25', 'hawaii', '0000-00-00', 'the.chase.jpg', 68, '2015-10-16 10:19:02'),
(160, 'CSF', 'Ruben ', 'A', 'Laraya', '', 'laraya.ra', '2f4d37ad816650bc4c7e4613fa7418c232221418', NULL, NULL, 'Executive Director', '2', NULL, 'laraya.ra@cite.edu.ph', NULL, '0000-00-00', NULL, '0000-00-00', '', 0, '0000-00-00 00:00:00'),
(162, 'CSD', 'Jundryl', 'S', 'Oplado', '', 'opladojs', '0a20b11e8c42dea4458ac26188e9d2fc27f4b684', NULL, NULL, 'Staff Assistant', '2', NULL, 'oplado.js@cite.edu.ph', NULL, '0000-00-00', NULL, '0000-00-00', '', 213, '2015-10-31 10:11:51'),
(163, 'Adviser', 'Mariano Francis Xavier', 'A', 'Hamoy', '', 'hamoyma', 'b971d880df18e7370c9961563cd51d4f27eb7acd', NULL, NULL, 'Director for Formation', '2', NULL, 'hamoy.ma@cite.edu.ph', NULL, '0000-00-00', NULL, '0000-00-00', '', 1, '2015-08-11 21:30:10'),
(164, 'Adviser', 'Benjie', 'L', 'Wong', '', 'wongbl', '9bf89c8e72ed056ae9d63c941c070d1679ead5b3', NULL, NULL, 'Staff Assistant', '2', NULL, 'wong.bl@cite.edu.ph', NULL, '0000-00-00', NULL, '0000-00-00', '', 12, '2015-06-22 16:39:24'),
(165, '', 'Rev. Fr. Carlo', '', 'Cuaresma', '', 'cuaresmar', 'c4ca4238a0b923820dcc509a6f75849b', NULL, NULL, 'Chaplain', '2', NULL, 'cuaresma.cf@cite.edu.ph', NULL, '0000-00-00', NULL, '0000-00-00', '', 0, '0000-00-00 00:00:00'),
(166, '', 'Rev. Fr. Roy', '', 'Cimagala', '', 'cimagalar', 'c4ca4238a0b923820dcc509a6f75849b', NULL, NULL, 'Chaplain', '2', NULL, 'cimagala.ra@cite.edu.ph', NULL, '0000-00-00', NULL, '0000-00-00', '', 0, '0000-00-00 00:00:00'),
(167, '', 'Armand Simeon', 'L', 'Millan', 'III', 'millanal', 'c4ca4238a0b923820dcc509a6f75849b', NULL, NULL, 'Development Office Director', '2', NULL, 'millan.al@cite.edu.ph', NULL, '0000-00-00', NULL, '0000-00-00', '', 0, '0000-00-00 00:00:00'),
(168, 'Administrator', 'Wildonis', 'C', 'GO', '', 'go.wc', '2a6d6a9de222c964138213909309a9fe92465212', NULL, NULL, 'Communications Officer', '2', NULL, 'GO.wc@cite.edu.ph', NULL, '0000-00-00', NULL, '0000-00-00', '', 48, '2015-10-10 08:52:28'),
(173, 'Adviser', 'Junee Mar', 'C', 'Aguilar', '', 'aguilar.jc', 'c1fc5ba1ded98fb324e6ad989cba4f6e6830b21f', NULL, NULL, 'Information Assistant', '2', NULL, 'agular.jc@cite.edu.ph', NULL, '0000-00-00', NULL, '0000-00-00', '', 2, '2015-10-10 14:55:37'),
(176, 'Adviser', 'Jessie', 'B', 'Ponce', '', 'poncejb', '48b2423356e5a77020d43e4e866786cb02d21076', NULL, NULL, '', '2', NULL, 'ponce.jb@cite.edu.ph', NULL, '0000-00-00', NULL, '0000-00-00', '', 0, '0000-00-00 00:00:00'),
(177, 'Adviser', 'Reynaldo', 'D', 'Gimena', '', 'gimena.rd', 'a4874cedfd0931b4ba2931e05a8c2086756dbed5', NULL, NULL, 'General Services Officer', '2', NULL, 'gimena.rd@cite.edu.ph', NULL, '0000-00-00', NULL, '0000-00-00', '', 52, '2015-08-26 22:06:00'),
(179, 'CAS', 'Marcial', 'C', 'Geraldo', '', 'balatayo', '84506646edf3a5593f806091490dc33568a636f2', NULL, NULL, 'General Services Staff', NULL, NULL, 'geraldo.mc@cite.edu.ph', NULL, '0000-00-00', NULL, '0000-00-00', '', 36, '2015-03-11 17:34:53'),
(180, '', 'Ronald', 'C', 'Gerona', '', 'geronarc', 'c4ca4238a0b923820dcc509a6f75849b', NULL, NULL, 'General Services Staff', NULL, NULL, 'gerona.rc@cite.edu.ph', NULL, '0000-00-00', NULL, '0000-00-00', '', 0, '0000-00-00 00:00:00'),
(182, 'Administrator', 'Julieto', 'B', 'Ardiente', '', 'ardientejb', '1525176c5fdaa09d106a887e5d44b84ecbfc195f', NULL, '', 'Purchasing & Property Control Officer', '0', '0', 'ardiente.jb@cite.edu.ph', '', '0000-00-00', NULL, '0000-00-00', '', 32, '2015-08-26 19:01:24'),
(183, 'Adviser', 'Ronan', 'L', 'Cabahug', '', 'cabahug.rl', '57b2913abc5e5e4ad4d2f21c84eb5a5c8abb8fda', NULL, NULL, 'School Nurse', NULL, NULL, 'cabahug.rl@cite.edu.ph', NULL, '0000-00-00', NULL, '0000-00-00', '', 11, '2015-08-14 21:31:40'),
(184, '', 'Dr. Jason', '', 'Cabahug', '', 'cabahugd', 'c4ca4238a0b923820dcc509a6f75849b', NULL, NULL, 'Company Doctor', NULL, NULL, 'cabahug.jb@cite.edu.ph', NULL, '0000-00-00', NULL, '0000-00-00', '', 0, '0000-00-00 00:00:00'),
(187, 'Administrator', 'Neil', 'N', 'Agbay', '', 'agbay.nn', 'c1fc5ba1ded98fb324e6ad989cba4f6e6830b21f', 'Cebu City', '', 'Systems Administrator', '1', '1', 'agbay.nn@cite.edu.ph', '09161234567', '1899-11-30', 'Cebu City', '0000-00-00', '', 94, '2015-10-12 09:36:27'),
(188, 'Adviser', 'Jorge', 'R', 'Larobis', '', 'larobis.jr', '565da0f1999174b074946800c2e472486d9816f4', NULL, NULL, 'Computer Technician', NULL, NULL, 'larobis.jr@cite.edu.ph', NULL, '0000-00-00', NULL, '0000-00-00', '', 30, '2015-10-06 12:17:13'),
(189, 'Adviser', 'Archie', 'M', 'Gonzales', '', 'gonzales.am', '3da57fd14866ae813adc688972ba6d7442939587', NULL, NULL, 'Systems Administrator Staff', NULL, NULL, '', NULL, '0000-00-00', NULL, '0000-00-00', '', 51, '2015-09-25 08:09:18'),
(190, 'Administrator', 'Reuel Jose', 'V', 'Zapata', '', 'qmr', 'ec56d405d8695ffa820f4d76cb412c2dc8f68303', NULL, NULL, 'Business Manager', NULL, NULL, 'zapata.rv@cite.edu.ph', NULL, '0000-00-00', NULL, '0000-00-00', '', 1, '2015-05-07 17:51:00'),
(192, '', 'Carlos', 'V', 'Cornejo', '', 'cornejocv', 'c4ca4238a0b923820dcc509a6f75849b', NULL, NULL, 'Academic Director', NULL, NULL, 'cornejo.cv@cite.edu.ph', NULL, '0000-00-00', NULL, '0000-00-00', '', 0, '0000-00-00 00:00:00'),
(194, 'Registrar', 'Perpetuo', 'C', 'Echavez', '', 'echavez.pc', 'c1fc5ba1ded98fb324e6ad989cba4f6e6830b21f', NULL, NULL, 'Registrar', NULL, NULL, 'echavez.pc@cite.edu.ph', NULL, '0000-00-00', NULL, '0000-00-00', '', 8, '2015-09-21 06:45:12'),
(196, 'Adviser', 'Mark', 'L', 'Grondiano', '', 'grondianoml', '6064726eba13aaaddff1430cd227a105094f00ea', NULL, NULL, 'Staff Assistant', NULL, NULL, 'grondanio.ml@cite.edu.ph', NULL, '0000-00-00', NULL, '0000-00-00', '', 38, '2015-10-09 10:21:40'),
(197, 'Administrator', 'Marlon', 'C', 'Valencia', '', 'valencia.mc', '2497190dbe8534344ecb0e9326b4b1ccf7d3609c', NULL, NULL, 'Industry Coordination Officer', NULL, NULL, 'valencia.mc@cite.edu.ph', NULL, '0000-00-00', NULL, '0000-00-00', '', 0, '0000-00-00 00:00:00'),
(200, 'Adviser', 'Alan Hendric', 'F', 'Buena', '', 'buenaaf', '948e781599cd7aba0ef5d8bcaeb360fe7ea4abaa', NULL, NULL, '', NULL, NULL, 'buena.af@cite.edu.ph', NULL, '0000-00-00', NULL, '0000-00-00', 'Buena, Alan Henric F copy.jpg', 0, '0000-00-00 00:00:00'),
(203, 'CSD', 'Jose Roland', 'M', 'Flores', '', 'flores.jm', '7c97d999c96d28206cf34efee8ac1b6aaf4438e7', NULL, NULL, '', NULL, NULL, 'flores.jm@cite.edu.ph', NULL, '0000-00-00', NULL, '0000-00-00', '', 5, '2015-09-19 06:57:26'),
(204, '', 'Karlo Mark', 'C', 'Rabanes', '', 'rabaneskc', 'c4ca4238a0b923820dcc509a6f75849b', NULL, NULL, '', NULL, NULL, 'rabanes.kc@cite.edu.ph', NULL, '0000-00-00', NULL, '0000-00-00', '', 0, '0000-00-00 00:00:00'),
(205, 'Administrator', 'Romero', 'A', 'Enoc', '', 'enoc.ra', '4a19446c84e07552124acf59f2c8928a6f8aae1d', NULL, NULL, '', NULL, NULL, 'enoc.ra@cite.edu.ph', NULL, '0000-00-00', NULL, '0000-00-00', '', 111, '2015-10-11 07:46:55'),
(210, 'CSD', 'Abraham', 'B', 'Geraldez', '', 'geraldez.ab', '7dc78f69ed4e38d5425952babfffaa35f2485b3c', NULL, NULL, '', NULL, NULL, 'geraldez.ab@cite.edu.ph', NULL, '0000-00-00', NULL, '0000-00-00', '', 46, '2015-09-14 08:09:36'),
(212, 'Adviser', 'Neil Ryan', 'G', 'Laspinas', '', 'laspinasng', '27f3ef27c80c0794eafc14414e4c777038d4c5f6', NULL, NULL, '', NULL, NULL, 'laspinas.ng@cite.edu.ph', NULL, '0000-00-00', NULL, '0000-00-00', '', 27, '2015-08-20 14:27:48'),
(217, 'Adviser', 'Brendon', 'G', 'Baclaan', '', 'baclaanbg', '1d77ee76de09d1a04a0070f29c82dfc2e7b89367', 'Danao, Cebu City', '', 'Multimedia Supervisor', '1', '1', 'baclaan.bg@cite.edu.ph', '123654', '2008-01-09', 'Cebu City', '0000-00-00', '', 10, '2015-10-12 07:35:23'),
(218, 'Administrator', 'Faustino', 'A', 'Langahin', 'JR', 'langahin.fa', '709857f2d10c5e1fb87d5b969aa16768530296cc', '', '', 'Student Affairs Officer', '1', '1', 'langahin.fa@cite.edu.ph', '0', '0000-00-00', '', '0000-00-00', '', 105, '2015-10-20 10:12:25'),
(221, 'Adviser', 'Ian', 'B', 'Alfornon', '', 'alfornon.ib', 'ca6f4fce42233fe380322d84c058db4476d48c57', 'Cebu City', '', 'Finance Officer', '1', '1', 'alfornon.ib@cite.edu.ph', '0', '1978-04-09', 'Cebu City', '0000-00-00', '', 9, '2015-09-26 12:04:23'),
(223, 'Administrator', 'Armand', 'C', 'Manatad', '', 'manatad.ac', 'e2cf30c4c016051925ee5c1afb1300272e261da2', 'Dasd', '', 'Graphic Designer', '1', '1', 'adad@gmail.com', '0', '2008-10-01', 'Cebu', '0000-00-00', '', 160, '2015-11-01 07:06:54'),
(225, 'Adviser', 'Bonifacio Jr.', 'N', 'Mercado', 'JR', 'mercadobn', 'ae1c2106e1ac1212b6c4ef655a263301851ea8d4', 'Villa Leyson', '', 'Public Employment Service Office Manager', '1', '1', 'mercado.bn@cite.edu.ph', '0', '2008-10-01', 'Cebu City', '0000-00-00', '', 4, '2015-07-08 18:40:42'),
(228, 'Administrator', 'System', 'C', 'Administrator', '', 'admin', '3e017ea65e637456a7fe0a8b9149574325127a62', 'N/a', '', 'N/a', '1', '1', 'none@update.me', '0', '1984-08-26', 'N/a', '0000-00-00', '', 262, '2015-11-01 06:40:18'),
(229, 'Administrator', 'Dennis', 'E', 'Barlas', '', 'barlasde', '71526e386188781379670bd17042a652a168933f', 'N/a', '', 'N/a', '1', '1', 'none@update.me', '0', '1986-08-28', 'N/a', '0000-00-00', '', 1, '2015-09-18 09:01:26'),
(230, 'Adviser', 'Filadelfo', 'A', 'Bajenting', 'JR', 'bajenting.fa', 'fa9481d9ca0f93e751d6842426c482d8f349e748', 'N/a', '', 'N/a', '1', '1', 'none@update.me', '0', '1981-08-11', 'N/a', '0000-00-00', '', 0, '0000-00-00 00:00:00'),
(232, 'CSD', 'Rhiane', 'M', 'Matas', '', 'matas.rm', '8bd3c0bef0e18d52f583c28c0e9cbe554ee9d4f3', 'N/a', '', 'N/a', '1', '1', 'none@update.me', '0', '1986-06-09', 'N/a', '0000-00-00', '', 23, '2015-10-04 07:16:37'),
(235, '', 'Leonardo', '', 'Arriesgado', '', 'arriesgadol', 'c4ca4238a0b923820dcc509a6f75849b', NULL, '', '', '0', '0', '', '', '0000-00-00', NULL, '0000-00-00', '', 0, '0000-00-00 00:00:00'),
(236, 'CSD', 'Jhufil', '', 'Canedo', '', 'canedo.jm', 'e6e32458f779448c4ebe0053e9b6d6fe51a3e3f8', NULL, '', '', '0', '0', '', '', '0000-00-00', NULL, '0000-00-00', '', 7, '2015-10-04 13:34:37'),
(237, 'Adviser', 'Michael', '', 'Guaca', '', 'guaca.mm', 'aff0c82b3c923179ab59bf66a754307db212bf23', NULL, '', '', '0', '0', '', '', '0000-00-00', NULL, '0000-00-00', '', 19, '2015-10-12 10:35:41'),
(238, 'Adviser', 'Josemari', '', 'Quijada', '', 'quijadaj', '41b705626fee436ce646254414f97c6f4042d06e', NULL, '', '', '0', '0', '', '', '0000-00-00', NULL, '0000-00-00', '', 1, '2015-01-24 20:38:16'),
(240, 'CSD', 'Johnry', '', 'Gac-ang', '', 'gac-ang.jt', '11f25e848ff6848447d963675adb1749d0d208ad', NULL, '', '', '0', '0', '', '', '0000-00-00', NULL, '0000-00-00', '', 83, '2015-10-18 10:36:16'),
(242, 'Adviser', 'Allan', 'M', 'Munez', NULL, 'muneza', 'db6288767656206f7846a18338f5fb3171adadc3', NULL, NULL, 'Development Office Staff', '2', NULL, NULL, NULL, '0000-00-00', NULL, '0000-00-00', NULL, 0, '0000-00-00 00:00:00'),
(243, 'Administrator', 'Rene', 'C', 'Cavales', NULL, 'cavales.rt', '08efa6391d05ad5433c93b1ea23d8655d4aa6ab9', NULL, NULL, 'HRD Personnel', '2', NULL, NULL, NULL, '0000-00-00', NULL, '0000-00-00', NULL, 18, '2015-09-15 12:43:44'),
(249, 'Adviser', 'Gene', '', 'Eyas', '', 'eyas.ga', '1583cbc84d6de9f3528a595d926801ea52d7a0bf', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0000-00-00', NULL, '0000-00-00', '', 57, '2015-11-01 05:08:09'),
(250, 'Adviser', 'Michael', '', 'Mingo', '', 'mingo.mc', '6753eae402b582e1fbe0a5f4ffcbd1bc76ecb74e', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0000-00-00', NULL, '0000-00-00', '', 20, '2015-09-13 11:19:41'),
(252, 'Administrator', 'Johnrell', '', 'Estiva', '', 'estiva.jo', 'c1fc5ba1ded98fb324e6ad989cba4f6e6830b21f', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0000-00-00', NULL, '0000-00-00', '', 127, '2015-10-10 04:50:30'),
(264, 'CSD', 'Kalel NiÃ±o', '', 'Mascardo', '', 'mascardo.k', '30ed17de340405b614ce519e6ef1a20a13d74052', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0000-00-00', NULL, '0000-00-00', '', 81, '2015-11-01 07:22:24'),
(253, 'Adviser', 'Darel', '', 'Lauron', '', 'lauron.dv', '2943668033729e80d371c5a9377565d6da4c8f5b', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0000-00-00', NULL, '0000-00-00', '', 40, '2015-10-18 10:08:18'),
(254, 'Adviser', 'Glenn', '', 'Osigan', '', 'osigan.rd', '54e3934ae20c5f8636eeb32ec6fdb9ded327df8e', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0000-00-00', NULL, '0000-00-00', '', 18, '2015-10-11 05:16:59'),
(265, 'CSD', 'Warren', '', 'Capitan', '', 'capitan.w', 'c3505bd279adffbde7a6de37b98299dfd92ed11c', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0000-00-00', NULL, '0000-00-00', '', 358, '2015-08-04 21:46:53'),
(256, 'Adviser', 'Amille Rey', '', 'Cabasag', '', 'cabasag.as', '93403cef16ac3beb5c6fbc3ed973ffac47719319', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0000-00-00', NULL, '0000-00-00', '', 260, '2015-11-01 08:31:57'),
(257, 'Adviser', 'Richard ', '', 'Bonghanoy', '', 'bonghanoy.rm', 'c1fc5ba1ded98fb324e6ad989cba4f6e6830b21f', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0000-00-00', NULL, '0000-00-00', '', 59, '2015-10-31 09:08:07'),
(266, 'Adviser', 'JOMAR', '', 'BONGCO', '', 'bongco.jd', '95bd010f7aa9d6ec1ee00369df8cba3d7ae2fef2', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0000-00-00', NULL, '0000-00-00', '', 61, '2015-09-14 11:50:30'),
(259, 'Adviser', 'Eljon', '', 'Lauria', '', 'lauria.et', '3e84ca3233814f667916db68912f225928c13fab', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0000-00-00', NULL, '0000-00-00', '', 55, '2015-09-25 09:37:22'),
(260, 'Adviser', 'Joebert', '', 'Elivera', '', 'eliverajt', '61b9cfc279cc240d660be31c7e575242d7c1bc7d', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0000-00-00', NULL, '0000-00-00', '', 51, '2015-09-28 12:22:53'),
(261, 'Adviser', 'Jonathan', '', 'Marturillas', '', 'marturillas.jb', '180d745dbf5abf7fa85a36237980e7afb94af5c9', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0000-00-00', NULL, '0000-00-00', '', 68, '2015-09-19 08:45:12'),
(262, 'Adviser', 'Paul Bernard', '', 'Rodrigo', '', 'rodrigo.ps', '3850ba231947f2ae9fa958c59ac5120d128b31f2', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0000-00-00', NULL, '0000-00-00', '', 24, '2015-05-11 21:38:55'),
(263, 'Adviser', 'Carlo', '', 'Erana', '', 'erana.cp', '83569d7b759232c7985e0f5f5d614fe9fb9bbf94', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0000-00-00', NULL, '0000-00-00', '', 12, '2015-04-14 22:44:30'),
(267, 'Adviser', 'Fernando', '', 'Arendain', '', 'arendain', 'ffe72367c1d87350223463dd4f668fbeaf987d50', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0000-00-00', NULL, '0000-00-00', '', 10, '2015-09-05 08:26:12'),
(268, 'Adviser', 'WAYNE', '', 'COMENDADOR', '', 'comendador.cw', 'a8abb075bdacfbdee98974bd5f841578408036cb', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0000-00-00', NULL, '0000-00-00', '', 21, '2015-10-16 06:50:52'),
(269, 'Adviser', 'CHARLES', '', 'VILLAROSA', '', 'villarosa.c', '2382bdbc16cbe5d632e49deca434c8f38c0a344e', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0000-00-00', NULL, '0000-00-00', '', 0, '0000-00-00 00:00:00'),
(270, 'Adviser', 'ERIBERTO', '', 'TABADA JR.', '', 'tabada.e', 'b04d59a98d8b695ddc0de1c22dfaf88a6bf09a04', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0000-00-00', NULL, '0000-00-00', '', 5, '2015-11-01 06:52:16'),
(271, 'CSF', 'Israel', '', 'Falcis', '', 'falcis.i', '8e199d17bca3ba252d20fcf35f092922f7b7f26a', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0000-00-00', NULL, '0000-00-00', '', 3, '2015-10-16 10:25:11');
