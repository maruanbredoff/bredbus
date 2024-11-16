-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Tempo de geração: 21-Abr-2021 às 17:04
-- Versão do servidor: 10.3.28-MariaDB
-- versão do PHP: 7.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `michella_michella`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `agenda`
--

CREATE TABLE `agenda` (
  `id` int(11) NOT NULL,
  `title` varchar(50) NOT NULL,
  `start` datetime NOT NULL,
  `end` datetime NOT NULL,
  `idcliente` int(11) DEFAULT NULL,
  `resp_agenda` varchar(20) NOT NULL,
  `color` varchar(10) NOT NULL,
  `tipo` varchar(25) NOT NULL,
  `iddentista` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `agenda`
--

INSERT INTO `agenda` (`id`, `title`, `start`, `end`, `idcliente`, `resp_agenda`, `color`, `tipo`, `iddentista`) VALUES
(3, 'Consulta Nickolas', '2019-04-04 10:00:00', '2019-04-04 11:00:00', NULL, 'Admin', '#228B22', 'Normal', 5),
(4, 'Josiane', '2019-04-23 14:30:00', '2019-04-23 15:00:00', NULL, 'Jade Costa', '#0071c5', 'Normal', 5),
(5, 'Gecilaine ', '2019-04-22 15:00:00', '2019-04-22 16:00:00', NULL, 'Jade Costa', '#BB9999', 'Normal', 5),
(6, 'Edna', '2019-04-23 15:00:00', '2019-04-23 15:59:00', NULL, 'Jade Costa', '#0071c5', 'Normal', 5),
(7, 'Luciene', '2019-04-23 16:00:00', '2019-04-23 16:59:00', NULL, 'Jade Costa', '#0071c5', 'Normal', 5),
(8, 'Lucimar', '2019-04-23 17:00:00', '2019-04-23 18:00:00', NULL, 'Jade Costa', '#0071c5', 'Normal', 5),
(9, 'Leiliane', '2019-04-23 11:30:00', '2019-04-23 12:00:00', NULL, 'Jade Costa', '#BB9999', 'Normal', 5),
(10, 'JoÃ£o ', '2019-04-23 12:00:00', '2019-04-23 12:30:00', NULL, 'Jade Costa', '#0071c5', 'Normal', 5),
(11, 'Teste Nickolas', '2019-07-18 07:00:00', '2019-07-18 07:30:00', NULL, 'Dionisio', '#228B22', 'Normal', 5);

-- --------------------------------------------------------

--
-- Estrutura da tabela `anamnese`
--

CREATE TABLE `anamnese` (
  `idanamnese` int(11) NOT NULL,
  `idcliente` int(10) NOT NULL,
  `idade` int(11) NOT NULL,
  `peso` varchar(5) DEFAULT NULL,
  `altura` varchar(5) DEFAULT NULL,
  `imc` float DEFAULT NULL,
  `igc` float DEFAULT NULL,
  `uvisitamedico` date DEFAULT NULL,
  `hospitalizado` varchar(5) NOT NULL,
  `hmotivo` varchar(40) DEFAULT NULL,
  `tpsanguineo` varchar(5) DEFAULT NULL,
  `tratamento_medico` varchar(5) DEFAULT NULL,
  `qtratamento_m` varchar(30) NOT NULL,
  `medicacao` varchar(5) DEFAULT NULL,
  `procedcirurgico` varchar(5) DEFAULT NULL,
  `qprocedcirurgico` varchar(30) NOT NULL,
  `qmedicacao` varchar(30) NOT NULL,
  `complicacao_cirurgica` varchar(10) DEFAULT NULL,
  `tendencia_cicatriz` varchar(5) DEFAULT NULL,
  `asp_ou_aas` varchar(5) NOT NULL,
  `ansiolitico_trat_snerv` varchar(5) NOT NULL,
  `qansiolitico_trat_snerv` varchar(30) NOT NULL,
  `tox_botulinica` varchar(5) NOT NULL,
  `qtox_botulinica` varchar(30) DEFAULT NULL,
  `preenchimento` varchar(50) NOT NULL,
  `qpreenchimento` varchar(30) NOT NULL,
  `antitetanica` varchar(5) NOT NULL,
  `alerg_ovo` varchar(5) NOT NULL,
  `alerg_medic` varchar(5) NOT NULL,
  `qalerg_medic` varchar(30) NOT NULL,
  `restri_anestesico` varchar(40) NOT NULL,
  `qrestri_anestesico` varchar(30) NOT NULL,
  `doencas` varchar(100) NOT NULL,
  `doencas_autoimune` varchar(5) NOT NULL,
  `qdoencas_autoimune` varchar(40) NOT NULL,
  `data_cadastro` datetime NOT NULL,
  `atendente` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `anamnese`
--

INSERT INTO `anamnese` (`idanamnese`, `idcliente`, `idade`, `peso`, `altura`, `imc`, `igc`, `uvisitamedico`, `hospitalizado`, `hmotivo`, `tpsanguineo`, `tratamento_medico`, `qtratamento_m`, `medicacao`, `procedcirurgico`, `qprocedcirurgico`, `qmedicacao`, `complicacao_cirurgica`, `tendencia_cicatriz`, `asp_ou_aas`, `ansiolitico_trat_snerv`, `qansiolitico_trat_snerv`, `tox_botulinica`, `qtox_botulinica`, `preenchimento`, `qpreenchimento`, `antitetanica`, `alerg_ovo`, `alerg_medic`, `qalerg_medic`, `restri_anestesico`, `qrestri_anestesico`, `doencas`, `doencas_autoimune`, `qdoencas_autoimune`, `data_cadastro`, `atendente`) VALUES
(3, 29, 53, '60', '1.,67', 0, 0, '0000-00-00', 'Nao', '', 'o+', 'Nao', '', 'Nao', 'Sim', '', '', '', 'Sim', 'Nao', 'Nao', '', 'Sim', NULL, 'Sim', 'rosto', 'Nao', 'Nao', 'Nao', '', 'Nao', '', '', 'Nao', '', '2019-04-03 17:15:00', 'Samuel'),
(4, 30, 29, '', '', 0, 0, '2018-05-01', 'Sim', 'parto', 'A+', 'Nao', '', 'Nao', 'Sim', '', '', 'nÃ£o', 'Sim', 'Nao', 'Nao', '', 'Nao', NULL, 'Nao', '', 'Nao', 'Nao', 'Sim', 'Plasil ', 'Nao', '', '', 'Nao', '', '2019-04-04 13:44:00', 'Samuel'),
(5, 31, 28, '65', '', 1, 13, '2018-10-01', 'Nao', '', 'o+', 'Nao', '', 'Nao', 'Nao', '', '', '', 'Sim', 'Nao', 'Nao', '', 'Nao', NULL, 'Nao', '', 'Nao', 'Nao', 'Nao', '', 'Nao', '', '', 'Nao', '', '2019-04-04 14:17:00', 'Samuel'),
(6, 32, 44, '64', '1.,66', 0, 0, '0000-00-00', 'Nao', '', '', 'Nao', '', 'Nao', 'Nao', '', '', '', 'Nao', 'Nao', 'Nao', '', 'Sim', NULL, 'Nao', '', 'Nao', 'Nao', 'Nao', '', 'Nao', '', '', 'Nao', '', '2019-04-04 14:44:00', 'Samuel'),
(7, 33, 20, '57', '', 0, 0, '0000-00-00', 'Nao', '', '', 'Nao', '', 'Sim', 'Nao', '', '', '', 'Nao', 'Nao', 'Nao', '', 'Nao', NULL, 'Sim', 'boca', 'Nao', 'Nao', 'Nao', '', 'Nao', '', '', 'Nao', '', '2019-04-04 14:57:00', 'Samuel'),
(8, 34, 45, '80', '1.,60', 0, 0, '2018-10-01', 'Nao', '', 'o+', 'Nao', '', 'Nao', 'Sim', '', '', 'nÃ£o', 'Nao', 'Nao', 'Nao', '', 'Sim', NULL, 'Nao', '', 'Nao', 'Nao', 'Nao', '', 'Nao', '', '', 'Nao', '', '2019-04-04 15:08:00', 'Samuel'),
(9, 35, 32, '', '', 0, 0, '0000-00-00', 'Sim', 'Cirurgia PlÃ¡stica ', '', 'Nao', '', 'Sim', 'Sim', 'Casariana', 'Anticoncepcional ', 'nÃ£o', 'Nao', 'Nao', 'Nao', '', 'Sim', NULL, 'Nao', '', 'Nao', 'Nao', 'Nao', '', 'Nao', '', '', 'Nao', '', '2019-04-04 15:24:00', 'Samuel'),
(10, 36, 48, '72', '1.,75', 0, 0, '0000-00-00', 'Nao', '', 'o+', 'Nao', '', 'Nao', 'Sim', '', '', '', 'Nao', 'Nao', 'Nao', '', 'Sim', NULL, 'Nao', '', 'Nao', 'Nao', 'Nao', '', 'Nao', '', '', 'Nao', '', '2019-04-04 15:37:00', 'Samuel'),
(11, 37, 35, '74', '1.,69', 0, 0, '2018-07-01', 'Nao', '', '', 'Nao', '', 'Nao', 'Nao', '', '', '', 'Sim', 'Nao', 'Nao', '', 'Nao', NULL, 'Sim', 'Bigode', 'Nao', 'Nao', 'Sim', 'Amoxilina ', 'Nao', '', '', 'Nao', '', '2019-04-04 15:48:00', 'Samuel'),
(12, 38, 33, '69', '1.,69', 0, 0, '2019-02-22', 'Nao', '', 'o+', 'Nao', '', 'Nao', 'Sim', 'mamoplastia', '', 'nÃ£o', 'Nao', 'Nao', 'Nao', '', 'Sim', NULL, 'Sim', 'boca', 'Nao', 'Nao', 'Nao', '', 'Nao', '', '', 'Nao', '', '2019-04-04 16:00:00', 'Samuel'),
(13, 39, 28, '52', '1.,56', 0, 0, '0000-00-00', 'Nao', '', 'A+', 'Nao', '', 'Sim', 'Nao', '', 'Anticoncepcional ', '', 'Sim', 'Nao', 'Nao', '', 'Nao', NULL, 'Nao', '', 'Nao', 'Nao', 'Sim', 'Hidroquinona ', 'Nao', '', '', 'Nao', '', '2019-04-04 16:21:00', 'Samuel'),
(14, 40, 54, '60', '1.,67', 0, 0, '0000-00-00', 'Nao', '', 'A+', 'Sim', 'Psiquiatra ', 'Sim', 'Sim', 'cesaria', '', 'nÃ£o', 'Nao', 'Nao', 'Sim', '', 'Nao', NULL, 'Nao', '', 'Nao', 'Nao', 'Nao', '', 'Nao', '', '', 'Nao', '', '2019-04-04 16:49:00', 'Samuel'),
(15, 41, 44, '44', '1.58', 0, 0, '0000-00-00', 'Nao', '', '', 'Nao', '', 'Nao', 'Sim', 'FÃªmur, abdominoplastia ', '', 'nÃ£o', 'Nao', 'Nao', 'Nao', '', 'Sim', NULL, 'Sim', 'face', 'Nao', 'Nao', 'Nao', '', 'Nao', '', '', 'Nao', '', '2019-04-04 17:00:00', 'Samuel'),
(16, 42, 48, '55', '1,53', 0, 0, '2019-02-01', 'Nao', '', 'o+', 'Nao', '', 'Sim', 'Sim', 'Cirurgia PlÃ¡stica ', 'Anticoncepcional ', '', 'Nao', 'Nao', 'Nao', '', 'Sim', NULL, 'Sim', 'boca', 'Nao', 'Nao', 'Nao', '', 'Nao', '', '', 'Nao', '', '2019-04-04 17:26:00', 'Samuel'),
(17, 43, 58, '65', '1.66', 0, 0, '2018-10-01', 'Nao', '', 'A+', 'Sim', '', 'Sim', 'Sim', 'cirurgia de hÃ©rnia e perineo ', 'cloridrato de duloxetina ', '', 'Nao', 'Nao', 'Nao', '', 'Nao', NULL, 'Nao', '', 'Nao', 'Nao', 'Nao', '', 'Nao', '', '', 'Nao', '', '2019-04-08 13:57:00', 'Samuel'),
(18, 44, 37, '58', '1.,56', 0, 0, '2018-01-31', 'Nao', '', '', 'Sim', '', 'Sim', 'Nao', '', 'sentralina ', '', 'Nao', 'Nao', 'Nao', '', 'Nao', NULL, 'Nao', '', 'Nao', 'Nao', 'Nao', '', 'Nao', '', '', 'Sim', 'InflamaÃ§Ã£o no sangue ', '2019-04-08 14:15:00', 'Samuel'),
(19, 45, 41, '52', '1,54', 0, 0, '2019-12-01', 'Nao', '', '', 'Sim', '', 'Nao', 'Nao', '', '', '', 'Nao', 'Nao', 'Sim', 'APRAZOLAN', 'Sim', NULL, 'Nao', '', 'Nao', 'Nao', 'Sim', 'Aspirina sulfa', 'Nao', '', '', 'Nao', '', '2019-04-08 14:31:00', 'Samuel'),
(20, 46, 56, '60', '1.,56', 0, 0, '0000-00-00', 'Nao', '', 'o+', 'Nao', '', 'Sim', 'Sim', 'plÃ¡stica ', 'saxenda ', 'sim', 'Nao', 'Nao', 'Nao', '', 'Sim', NULL, 'Sim', 'lÃ¡bios', 'Nao', 'Nao', 'Nao', '', 'Nao', '', '', 'Nao', '', '2019-04-08 14:51:00', 'Samuel'),
(21, 47, 40, '67', '1.64', 0, 0, '0000-00-00', 'Nao', '', 'A+', 'Nao', '', 'Nao', 'Nao', '', '', '', 'Sim', 'Nao', 'Nao', '', 'Sim', NULL, 'Sim', 'Bigode', 'Nao', 'Nao', 'Nao', '', 'Nao', '', '', 'Nao', '', '2019-04-08 16:17:00', 'Samuel'),
(22, 48, 44, '73', '1..72', 0, 0, '0000-00-00', 'Nao', '', 'o+', 'Nao', '', 'Nao', 'Sim', 'CesÃ¡ria, ApÃªndice, Plastica', '', 'nÃ£o', 'Sim', 'Nao', 'Nao', '', 'Nao', NULL, 'Sim', 'rosto', 'Nao', 'Nao', 'Nao', '', 'Nao', '', '', 'Nao', '', '2019-04-08 16:50:00', 'Samuel'),
(23, 49, 31, '51', '1.53', 0, 0, '0000-00-00', 'Nao', '', '', 'Sim', 'Neuro', 'Sim', 'Nao', '', 'serenata e serezete ', '', 'Nao', 'Nao', 'Sim', 'serenata ', 'Nao', NULL, 'Nao', '', 'Nao', 'Nao', 'Nao', '', 'Nao', '', '', 'Nao', '', '2019-04-08 17:05:00', 'Samuel'),
(24, 50, 48, '60', '1.,70', 0, 0, '0000-00-00', 'Nao', '', '', 'Nao', '', 'Sim', 'Sim', '', '', '', 'Nao', 'Nao', 'Nao', '', 'Nao', NULL, 'Nao', '', 'Nao', 'Sim', 'Nao', '', 'Nao', '', '', 'Nao', '', '2019-04-08 17:21:00', 'Samuel'),
(25, 51, 30, '80', '1.,70', 0, 0, '0000-00-00', 'Nao', '', '', 'Nao', '', 'Sim', 'Sim', 'Retirada de ciso', 'Diclin', '', 'Nao', 'Nao', 'Nao', '', 'Sim', NULL, 'Nao', '', 'Nao', 'Nao', 'Nao', '', 'Nao', '', '', 'Nao', '', '2019-04-09 09:15:00', 'Samuel'),
(26, 53, 40, '69', '1.63', 25.97, 34.96, '2019-01-13', 'Sim', 'Cirurgia no joelho ', 'o+', 'Nao', '', 'Sim', 'Sim', 'CesÃ¡ria e joelho ', 'Euthirox', 'nÃ£o', 'Sim', 'Nao', 'Nao', '', 'Sim', NULL, 'Sim', '', 'Nao', 'Nao', 'Nao', '', 'Nao', '', '', 'Nao', '', '2019-04-09 09:44:00', 'Samuel'),
(27, 54, 47, '56', '1.60', 21.87, 31.65, '2018-09-01', 'Nao', '', '', 'Nao', '', 'Sim', 'Nao', '', 'AnsiolÃ­tico', '', 'Nao', 'Nao', 'Sim', '', 'Sim', NULL, 'Sim', 'lÃ¡bios', 'Nao', 'Nao', 'Nao', '', 'Nao', '', '', 'Nao', '', '2019-04-09 10:06:00', 'Samuel'),
(28, 55, 56, '48', '1.54', 20.24, 31.77, '2018-01-01', 'Nao', '', '0-', 'Nao', '', 'Sim', 'Sim', 'laqueadeira', 'Angelic hormÃ´nio ', '', 'Nao', 'Nao', 'Nao', '', 'Sim', NULL, 'Sim', 'Bigode', 'Nao', 'Nao', 'Nao', '', 'Nao', '', '', 'Nao', '', '2019-04-09 10:15:00', 'Samuel'),
(29, 56, 38, '57', '1.52', 24.67, 32.94, '2018-12-20', 'Nao', '', 'A+', 'Nao', '', 'Sim', 'Nao', '', 'Anticoncepcional ', '', 'Nao', 'Nao', 'Nao', '', 'Sim', NULL, 'Sim', 'face', 'Nao', 'Nao', 'Nao', '', 'Nao', '', '', 'Nao', '', '2019-04-09 10:27:00', 'Samuel'),
(30, 57, 39, '62', '1.63', 23.34, 31.58, '0000-00-00', 'Nao', '', 'A+', 'Nao', '', 'Nao', 'Sim', 'cesaria', '', 'nÃ£o', 'Nao', 'Nao', 'Nao', '', 'Sim', NULL, 'Nao', '', 'Nao', 'Nao', 'Nao', '', 'Nao', '', '', 'Nao', '', '2019-04-09 10:49:00', 'Samuel'),
(31, 99, 31, '68', '1.66', 0, 0, '0000-00-00', 'Nao', '', '', 'Nao', '', 'Nao', 'Nao', '', '', '', 'Sim', 'Nao', 'Nao', '', 'Nao', NULL, 'Sim', 'boca', 'Nao', 'Nao', 'Nao', '', 'Nao', '', '', 'Nao', '', '2019-04-17 16:03:00', 'Jade Costa'),
(32, 138, 46, '80', '1.70', 0, 0, '0000-00-00', 'Sim', 'Cirurgia na coluna', '', 'Sim', 'Diabetes', 'Sim', 'Sim', '', 'Metformina, Januvia', '', 'Nao', 'Sim', 'Nao', '', 'Nao', NULL, 'Nao', '', 'Nao', 'Nao', 'Nao', '', 'Nao', '', '5', 'Nao', '', '2019-04-17 16:54:00', 'Jade Costa'),
(33, 139, 31, '60', '1.60', 0, 0, '2018-05-15', 'Sim', 'Cirurgia no Nariz', '', 'Nao', '', 'Nao', 'Sim', 'Nariz', '', '', 'Sim', 'Nao', 'Nao', '', 'Nao', NULL, 'Nao', '', 'Nao', 'Nao', 'Nao', '', 'Nao', '', '', 'Nao', '', '2019-04-17 17:06:00', 'Jade Costa'),
(34, 125, 29, '50', '1.48', 0, 0, '0000-00-00', 'Nao', '', 'A+', 'Nao', '', 'Nao', 'Nao', '', '', '', 'Sim', 'Nao', 'Nao', '', 'Nao', NULL, 'Nao', '', 'Nao', 'Nao', 'Nao', '', 'Nao', '', '', 'Nao', '', '2019-04-17 17:11:00', 'Jade Costa'),
(35, 130, 30, '54', '1.57', 0, 0, '0000-00-00', 'Nao', '', '', 'Nao', '', 'Sim', 'Nao', '', 'Anticoncepcional ', '', 'Nao', 'Nao', 'Nao', '', 'Sim', NULL, 'Sim', 'Boca', 'Nao', 'Nao', 'Nao', '', 'Nao', '', '8', 'Nao', '', '2019-04-17 17:17:00', 'Jade Costa'),
(36, 85, 34, '79', '1.66', 0, 0, '0000-00-00', 'Nao', '', 'O+', 'Nao', '', 'Nao', 'Nao', '', '', '', 'Nao', 'Nao', 'Nao', '', 'Nao', NULL, 'Nao', '', 'Nao', 'Nao', 'Nao', '', 'Nao', '', '8', 'Nao', '', '2019-04-17 17:22:00', 'Jade Costa'),
(37, 86, 27, '49', '', 0, 0, '0000-00-00', 'Nao', '', '', 'Nao', '', 'Nao', 'Nao', '', '', '', 'Nao', 'Nao', 'Nao', '', 'Sim', NULL, 'Sim', '', 'Nao', 'Sim', 'Nao', '', 'Nao', '', '', 'Nao', '', '2019-04-17 17:25:00', 'Jade Costa'),
(38, 87, 21, '82', '1.88', 0, 0, '0000-00-00', 'Nao', '', '', 'Nao', '', 'Nao', 'Nao', '', '', '', 'Nao', 'Nao', 'Nao', '', 'Nao', NULL, 'Nao', '', 'Nao', 'Nao', 'Nao', '', 'Nao', '', '', 'Nao', '', '2019-04-17 17:28:00', 'Jade Costa'),
(39, 88, 39, '62', '1.60', 0, 0, '0000-00-00', 'Sim', 'Cirurgia', 'O+', 'Nao', '', 'Nao', 'Sim', '', '', '', 'Nao', 'Nao', 'Nao', '', 'Nao', NULL, 'Sim', '', 'Nao', 'Nao', 'Nao', '', 'Nao', '', '', 'Nao', '', '2019-04-17 17:31:00', 'Jade Costa'),
(40, 58, 47, '', '1.76', 0, 0, '0000-00-00', 'Nao', '', '', 'Nao', '', 'Nao', 'Sim', '', '', '', 'Nao', 'Nao', 'Nao', '', 'Nao', NULL, 'Nao', '', 'Nao', 'Nao', 'Nao', '', 'Nao', '', '', 'Nao', '', '2019-04-17 17:34:00', 'Jade Costa'),
(41, 66, 39, '', '', 0, 0, '0000-00-00', 'Sim', 'GestaÃ§Ã£o molar', 'A+', 'Sim', '', 'Sim', 'Sim', 'Cesariana', 'Efexor', '', 'Nao', 'Nao', 'Sim', '', 'Nao', NULL, 'Nao', '', 'Nao', 'Nao', 'Nao', '', 'Nao', '', '', 'Nao', '', '2019-04-17 17:37:00', 'Jade Costa'),
(42, 68, 22, '50', '1.68', 0, 0, '0000-00-00', 'Nao', '', 'A+', 'Nao', '', 'Nao', 'Nao', '', '', '', 'Nao', 'Nao', 'Nao', '', 'Nao', NULL, 'Sim', 'Nariz', 'Nao', 'Nao', 'Nao', '', 'Nao', '', '', 'Nao', '', '2019-04-18 13:36:00', 'Jade Costa'),
(43, 67, 52, '78', '1.75', 0, 0, '0000-00-00', 'Nao', '', '', 'Nao', '', 'Sim', 'Sim', 'Laqueadura', 'Atelonol, Enalapril', '', 'Nao', 'Nao', 'Nao', '', 'Nao', NULL, 'Nao', '', 'Sim', 'Nao', 'Sim', 'Dipirona, Anador, AAS', 'Nao', '', '', 'Nao', '', '2019-04-18 00:00:00', 'Jade Costa'),
(44, 69, 31, '83', '1.63', 0, 0, '0000-00-00', 'Nao', '', 'O+', 'Nao', '', 'Sim', 'Sim', 'Cesaria', 'Anticoncepcional ', '', 'Nao', 'Nao', 'Nao', '', 'Nao', NULL, 'Nao', '', 'Nao', 'Nao', 'Nao', '', 'Nao', '', '', 'Sim', 'FAN', '2019-04-18 13:46:00', 'Jade Costa'),
(45, 65, 31, '60', '1.74', 0, 0, '0000-00-00', 'Nao', '', 'A+', 'Sim', 'Hipertireoidismo e Colesterol ', 'Sim', 'Nao', '', 'Tapazol, rosuvastatina', '', 'Sim', 'Nao', 'Nao', '', 'Sim', NULL, 'Sim', 'Olheiras', 'Nao', 'Nao', 'Nao', '', 'Nao', '', '', 'Nao', '', '2019-04-18 13:50:00', 'Jade Costa'),
(46, 64, 35, '61', '1.58', 0, 0, '2018-12-12', 'Nao', '', 'B-', 'Nao', '', 'Sim', 'Sim', '', 'Venlafaxina', '', 'Sim', 'Nao', 'Sim', 'Venlafaxina', 'Nao', NULL, 'Nao', '', 'Nao', 'Nao', 'Sim', 'Plasil ', 'Nao', '', '8', 'Nao', '', '2019-04-18 13:56:00', 'Jade Costa'),
(47, 59, 57, '56', '1.59', 0, 0, '0000-00-00', 'Nao', '', '', 'Sim', 'Diabetes e Terapia', 'Sim', 'Sim', '', '', '', 'Sim', 'Nao', 'Nao', '', 'Sim', NULL, 'Sim', 'Bigode Chines ', 'Nao', 'Nao', 'Nao', '', 'Nao', '', '3, 10', 'Nao', '', '2019-04-18 14:14:00', 'Jade Costa'),
(48, 62, 44, '60', '', 0, 0, '0000-00-00', 'Nao', '', '', 'Sim', 'Psiquiatra ', 'Sim', 'Sim', 'Nasal', 'Frontal', '', 'Nao', 'Nao', 'Nao', '', 'Nao', NULL, 'Nao', '', 'Nao', 'Nao', 'Nao', '', 'Nao', '', '12', 'Nao', '', '2019-04-18 14:19:00', 'Jade Costa'),
(49, 61, 42, '56', '1.54', 0, 0, '0000-00-00', 'Nao', '', '', 'Nao', '', 'Nao', 'Sim', 'Cesariana', '', '', 'Nao', 'Nao', 'Nao', '', 'Sim', NULL, 'Sim', 'Bigode Chines ', 'Nao', 'Nao', 'Nao', '', 'Nao', '', '', 'Nao', '', '2019-04-18 14:25:00', 'Jade Costa'),
(50, 140, 35, '63', '1.59', 0, 0, '0000-00-00', 'Nao', '', '', 'Nao', '', 'Sim', 'Nao', '', 'Amato, Escilex', '', 'Nao', 'Nao', 'Nao', '', 'Nao', NULL, 'Sim', 'Olho, Nariz', 'Nao', 'Nao', 'Nao', '', 'Nao', '', '', 'Nao', '', '2019-04-22 10:33:00', 'Jade Costa'),
(51, 141, 29, '70', '1.73', 0, 0, '0000-00-00', 'Nao', '', 'O+', 'Nao', '', 'Nao', 'Sim', 'Lipo, Silicone', '', '', 'Sim', 'Nao', 'Nao', '', 'Nao', NULL, 'Nao', '', 'Nao', 'Nao', 'Nao', '', 'Nao', '', '', 'Nao', '', '2019-04-22 10:40:00', 'Jade Costa'),
(52, 142, 39, '67', '1.75', 0, 0, '0000-00-00', 'Nao', '', '', 'Nao', '', 'Nao', 'Nao', '', '', '', 'Sim', 'Nao', 'Nao', '', 'Sim', NULL, 'Nao', '', 'Nao', 'Nao', 'Nao', '', 'Nao', '', '', 'Nao', '', '2019-04-22 10:56:00', 'Jade Costa'),
(53, 143, 29, '60', '1.67', 0, 0, '0000-00-00', 'Sim', 'Parto', 'A+', 'Nao', '', 'Nao', 'Sim', 'Cesariana e ApÃªndice ', '', '', 'Sim', 'Nao', 'Nao', '', 'Nao', NULL, 'Nao', '', 'Nao', 'Nao', 'Sim', 'Polaramine', 'Nao', '', '', 'Nao', '', '2019-04-22 11:04:00', 'Jade Costa'),
(54, 144, 38, '64', '1.54', 0, 0, '0000-00-00', 'Nao', '', 'A+', 'Nao', '', 'Nao', 'Sim', 'Hernia ', '', '', 'Nao', 'Nao', 'Nao', '', 'Sim', NULL, 'Sim', 'Rosto', 'Nao', 'Nao', 'Nao', '', 'Nao', '', '', 'Nao', '', '2019-04-22 11:09:00', 'Jade Costa'),
(55, 145, 41, '61', '1.70', 0, 0, '0000-00-00', 'Nao', '', '', 'Sim', 'Dor Lombar', 'Sim', 'Sim', 'Hernia Ignal', 'Meloxican', '', 'Nao', 'Nao', 'Nao', '', 'Nao', NULL, 'Nao', '', 'Nao', 'Nao', 'Nao', '', 'Nao', '', '', 'Nao', '', '2019-04-22 11:20:00', 'Jade Costa'),
(56, 146, 24, '65', '1.60', 0, 0, '0000-00-00', 'Nao', '', '', 'Nao', '', 'Sim', 'Nao', '', 'Anticoncepcional ', '', 'Nao', 'Nao', 'Nao', '', 'Nao', NULL, 'Nao', '', 'Nao', 'Nao', 'Nao', '', 'Nao', '', '', 'Nao', '', '2019-04-22 11:26:00', 'Jade Costa'),
(57, 147, 48, '73', '1.60', 0, 0, '0000-00-00', 'Nao', '', 'O+', 'Nao', '', 'Sim', 'Sim', 'Cesariana', 'Atenolol ', '', 'Nao', 'Nao', 'Nao', '', 'Sim', NULL, 'Sim', '', 'Nao', 'Nao', 'Nao', '', 'Nao', '', '3', 'Nao', '', '2019-04-22 11:30:00', 'Jade Costa'),
(58, 148, 39, '51', '1.60', 0, 0, '0000-00-00', 'Nao', '', 'A+', 'Nao', '', 'Nao', 'Sim', 'Cesariana', '', '', 'Sim', 'Nao', 'Nao', '', 'Sim', NULL, 'Sim', 'Bigode Chines ', 'Nao', 'Nao', 'Nao', '', 'Nao', '', '2', 'Sim', '', '2019-04-22 11:35:00', 'Jade Costa'),
(59, 149, 29, '55', '1.54', 0, 0, '0000-00-00', 'Sim', 'Cirurgia', 'O+', 'Sim', 'Endocrinologista ', 'Sim', 'Sim', '', 'Euthirox', '', 'Nao', 'Nao', 'Nao', '', 'Sim', NULL, 'Sim', 'Olheiras', 'Nao', 'Nao', 'Nao', '', 'Nao', '', '4', 'Nao', '', '2019-04-22 13:44:00', 'Jade Costa'),
(60, 150, 25, '62', '1.60', 0, 0, '0000-00-00', 'Nao', '', 'A+', 'Nao', '', 'Nao', 'Sim', 'Cesariana', '', '', 'Sim', 'Nao', 'Nao', '', 'Nao', NULL, 'Nao', '', 'Nao', 'Nao', 'Nao', '', 'Nao', '', '', 'Nao', '', '2019-04-22 13:58:00', 'Jade Costa'),
(61, 152, 38, '62', '1.70', 0, 0, '0000-00-00', 'Sim', 'Silicone mama', 'O+', 'Nao', '', 'Nao', 'Sim', '', '', '', 'Sim', 'Nao', 'Nao', '', 'Sim', NULL, 'Nao', '', 'Nao', 'Nao', 'Nao', '', 'Nao', '', '', 'Nao', '', '2019-04-22 14:06:00', 'Jade Costa'),
(62, 153, 34, '89', '1.78', 0, 0, '0000-00-00', 'Nao', '', 'O+', 'Nao', '', 'Nao', 'Nao', '', '', '', 'Nao', 'Nao', 'Nao', '', 'Nao', NULL, 'Nao', '', 'Nao', 'Nao', 'Nao', '', 'Nao', '', '', 'Nao', '', '2019-04-22 14:14:00', 'Jade Costa'),
(63, 154, 53, '62', '1.65', 0, 0, '0000-00-00', 'Sim', 'Stress', 'O+', 'Nao', '', 'Nao', 'Sim', 'Cesariana', '', '', 'Nao', 'Nao', 'Nao', '', 'Sim', NULL, 'Nao', '', 'Nao', 'Nao', 'Nao', '', 'Nao', '', '2', 'Nao', '', '2019-04-22 14:31:00', 'Jade Costa'),
(64, 155, 21, '47', '1.50', 0, 0, '0000-00-00', 'Nao', '', 'O+', 'Nao', '', 'Nao', 'Nao', '', '', '', 'Nao', 'Nao', 'Nao', '', 'Nao', NULL, 'Nao', '', 'Nao', 'Nao', 'Nao', '', 'Nao', '', '', 'Nao', '', '2019-04-22 14:35:00', 'Jade Costa'),
(65, 156, 35, '70', '1.68', 0, 0, '0000-00-00', 'Sim', '', '', 'Nao', '', 'Nao', 'Nao', '', '', '', 'Sim', 'Nao', 'Nao', '', 'Sim', NULL, 'Sim', '', 'Nao', 'Nao', 'Nao', '', 'Nao', '', '', 'Nao', '', '2019-04-22 14:40:00', 'Jade Costa'),
(66, 157, 29, '49', '1.53', 0, 0, '0000-00-00', 'Nao', '', 'A+', 'Nao', '', 'Nao', 'Sim', 'Silicone ', '', '', 'Nao', 'Nao', 'Nao', '', 'Nao', NULL, 'Nao', '', 'Nao', 'Nao', 'Nao', '', 'Nao', '', '', 'Nao', '', '2019-04-22 14:51:00', 'Jade Costa'),
(67, 158, 0, '', '', 0, 0, '0000-00-00', 'Nao', '', '', 'Sim', 'Hipertireoidismo ', 'Sim', 'Sim', 'ReduÃ§Ã£o de mamas', 'Euthirox', '', 'Sim', 'Nao', 'Nao', '', 'Sim', NULL, 'Sim', 'Rosto', 'Nao', 'Nao', 'Nao', '', 'Nao', '', '4', 'Nao', '', '2019-04-22 15:04:00', 'Jade Costa'),
(68, 159, 25, '66,9', '', 0, 0, '0000-00-00', 'Nao', '', '', 'Nao', '', 'Sim', 'Nao', '', 'Anticoncepcional ', '', 'Nao', 'Nao', 'Nao', '', 'Nao', NULL, 'Nao', '', 'Nao', 'Nao', 'Nao', '', 'Nao', '', '', 'Nao', '', '2019-04-22 15:16:00', 'Jade Costa'),
(69, 160, 53, '', '', 0, 0, '0000-00-00', 'Nao', '', '', 'Nao', '', 'Nao', 'Sim', 'Cesariana', '', '', 'Nao', 'Nao', 'Nao', '', 'Sim', NULL, 'Nao', '', 'Nao', 'Nao', 'Nao', '', 'Nao', '', '', 'Nao', '', '2019-04-22 15:28:00', 'Jade Costa'),
(70, 129, 29, '55', '', 0, 0, '0000-00-00', 'Nao', '', '', 'Nao', '', 'Nao', 'Nao', '', '', '', 'Nao', 'Nao', 'Nao', '', 'Nao', NULL, 'Nao', '', 'Nao', 'Nao', 'Nao', '', 'Nao', '', '', 'Nao', '', '2019-04-22 15:31:00', 'Jade Costa'),
(71, 127, 31, '65', '1.65', 0, 0, '0000-00-00', 'Nao', '', 'O-', 'Nao', '', 'Nao', 'Sim', '', '', '', 'Sim', 'Nao', 'Sim', '', 'Nao', NULL, 'Sim', 'Nariz', 'Nao', 'Nao', 'Nao', '', 'Nao', '', '8', 'Nao', '', '2019-04-22 15:34:00', 'Jade Costa'),
(72, 131, 27, '77', '1.80', 0, 0, '0000-00-00', 'Nao', '', '', 'Nao', '', 'Nao', 'Sim', 'Siso, Bichectomia ', '', '', 'Nao', 'Nao', 'Nao', '', 'Nao', NULL, 'Nao', '', 'Sim', 'Nao', 'Nao', '', 'Nao', '', '', 'Nao', '', '2019-04-22 15:39:00', 'Jade Costa'),
(73, 63, 36, '58,5', '1.62', 0, 0, '0000-00-00', 'Nao', '', 'O+', 'Nao', '', 'Nao', 'Sim', 'Cesariana', '', '', 'Nao', 'Nao', 'Nao', '', 'Nao', NULL, 'Nao', '', 'Nao', 'Nao', 'Nao', '', 'Nao', '', '2', 'Nao', '', '2019-04-22 15:42:00', 'Jade Costa'),
(74, 128, 44, '57', '1.57', 0, 0, '0000-00-00', 'Nao', '', '', 'Nao', '', 'Nao', 'Sim', 'Rinoplastia ', '', '', 'Nao', 'Nao', 'Nao', '', 'Nao', NULL, 'Nao', '', 'Nao', 'Nao', 'Nao', '', 'Nao', '', '', 'Nao', '', '2019-04-22 15:51:00', 'Jade Costa'),
(75, 132, 71, '63', '1.52', 0, 0, '0000-00-00', 'Nao', '', 'A+', 'Nao', '', 'Sim', 'Sim', 'Cesariana, variz ', 'Sertralina', '', 'Nao', 'Nao', 'Sim', '', 'Nao', NULL, 'Nao', '', 'Nao', 'Nao', 'Sim', 'Vermifugo ', 'Nao', '', '10', 'Nao', '', '2019-04-22 15:53:00', 'Jade Costa'),
(76, 133, 28, '58', '1.55', 0, 0, '0000-00-00', 'Nao', '', 'A+', 'Nao', '', 'Nao', 'Nao', '', '', '', 'Nao', 'Nao', 'Nao', '', 'Nao', NULL, 'Nao', '', 'Nao', 'Nao', 'Nao', '', 'Nao', '', '', 'Nao', '', '2019-04-22 15:56:00', 'Jade Costa'),
(77, 134, 58, '69', '1.59', 0, 0, '0000-00-00', 'Nao', '', '', 'Nao', '', 'Nao', 'Nao', '', '', '', 'Nao', 'Nao', 'Nao', '', 'Sim', NULL, 'Sim', 'Rosto', 'Nao', 'Nao', 'Nao', '', 'Nao', '', '', 'Nao', '', '2019-04-22 15:58:00', 'Jade Costa'),
(78, 135, 54, '79', '1.56', 0, 0, '0000-00-00', 'Sim', 'Cirurgia de Varizes', 'B+', 'Nao', '', 'Sim', 'Sim', 'VesÃ­cula ', 'Omeprazol, Lozartana', '', 'Sim', 'Sim', 'Nao', '', 'Sim', NULL, 'Sim', '', 'Nao', 'Nao', 'Nao', '', 'Nao', '', '3', 'Nao', '', '2019-04-22 16:00:00', 'Jade Costa'),
(79, 136, 48, '', '1.57', 0, 0, '0000-00-00', 'Nao', '', '', 'Nao', '', 'Nao', 'Nao', '', '', '', 'Nao', 'Nao', 'Nao', '', 'Sim', NULL, 'Nao', '', 'Nao', 'Nao', 'Nao', '', 'Nao', '', '', 'Nao', '', '2019-04-22 16:03:00', 'Jade Costa'),
(80, 137, 2017, '65', '1.69', 0, 0, '0000-00-00', 'Nao', '', 'O-', 'Nao', '', 'Nao', 'Sim', 'Silicone ', '', '', 'Sim', 'Nao', 'Nao', '', 'Sim', NULL, 'Sim', '', 'Nao', 'Nao', 'Nao', '', 'Nao', '', '', 'Nao', '', '2019-04-22 16:04:00', 'Jade Costa'),
(81, 161, 35, '72', '1.64', 0, 0, '2018-11-14', 'Nao', '', '', 'Sim', '', 'Sim', 'Sim', '', '', '', 'Sim', 'Nao', 'Nao', '', 'Sim', NULL, 'Nao', '', 'Nao', 'Nao', 'Nao', '', 'Nao', '', '', 'Nao', '', '2019-04-22 16:13:00', 'Jade Costa'),
(82, 123, 22, '58', '1.60', 0, 0, '0000-00-00', 'Nao', '', '', 'Nao', '', 'Nao', 'Nao', '', '', '', 'Nao', 'Nao', 'Nao', '', 'Nao', NULL, 'Nao', '', 'Nao', 'Nao', 'Nao', '', 'Nao', '', '', 'Nao', '', '2019-04-22 16:15:00', 'Jade Costa'),
(83, 122, 22, '64', '1.69', 0, 0, '0000-00-00', 'Nao', '', 'O+', 'Nao', '', 'Nao', 'Sim', 'Mamoplastia', '', '', 'Nao', 'Nao', 'Nao', '', 'Nao', NULL, 'Nao', '', 'Nao', 'Nao', 'Nao', '', 'Nao', '', '', 'Nao', '', '2019-04-22 16:18:00', 'Jade Costa'),
(84, 121, 50, '68', '', 0, 0, '0000-00-00', 'Nao', '', '', 'Nao', '', 'Nao', 'Sim', 'Cisto no ovÃ¡rio ', '', '', 'Nao', 'Nao', 'Nao', '', 'Nao', NULL, 'Nao', '', 'Nao', 'Nao', 'Nao', '', 'Nao', '', '', 'Nao', '', '2019-04-22 16:19:00', 'Jade Costa'),
(85, 120, 32, '68', '1.65', 0, 0, '0000-00-00', 'Nao', '', 'O+', 'Nao', '', 'Nao', 'Sim', 'Cesariana', '', '', 'Nao', 'Nao', 'Nao', '', 'Sim', NULL, 'Sim', '', 'Nao', 'Nao', 'Nao', '', 'Nao', '', '', 'Nao', '', '2019-04-22 16:21:00', 'Jade Costa'),
(86, 119, 66, '', '1.56', 0, 0, '0000-00-00', 'Nao', '', '', 'Nao', '', 'Sim', 'Nao', '', '', '', 'Nao', 'Nao', 'Sim', 'Sertralina ', 'Nao', NULL, 'Nao', '', 'Nao', 'Nao', 'Nao', '', 'Nao', '', '4', 'Nao', '', '2019-04-22 16:23:00', 'Jade Costa'),
(87, 118, 28, '82', '1.80', 0, 0, '0000-00-00', 'Nao', '', '', 'Nao', '', 'Nao', 'Nao', '', '', '', 'Nao', 'Nao', 'Nao', '', 'Sim', NULL, 'Sim', '', 'Nao', 'Nao', 'Nao', '', 'Nao', '', '2', 'Nao', '', '2019-04-22 16:28:00', 'Jade Costa'),
(88, 117, 24, '68', '1.69', 0, 0, '0000-00-00', 'Sim', 'Ataque de ansiedade', 'O+', 'Nao', '', 'Sim', 'Nao', '', 'Melatonina', '', 'Nao', 'Nao', 'Nao', '', 'Nao', NULL, 'Nao', '', 'Nao', 'Nao', 'Sim', 'Dipirona ', 'Nao', '', '12', 'Nao', '', '2019-04-22 16:40:00', 'Jade Costa'),
(89, 116, 34, '80', '1.60', 0, 0, '0000-00-00', 'Nao', '', 'O+', 'Nao', '', 'Nao', 'Sim', 'Cesariana', '', '', 'Sim', 'Nao', 'Nao', '', 'Nao', NULL, 'Nao', '', 'Nao', 'Nao', 'Nao', '', 'Nao', '', '', 'Nao', '', '2019-04-22 16:44:00', 'Jade Costa'),
(90, 115, 40, '57', '1.64', 0, 0, '2019-03-15', 'Sim', 'Cirurgia', 'O+', 'Sim', 'Coluna', 'Nao', 'Sim', 'Endometriose, cesariana ', '', '', 'Nao', 'Nao', 'Nao', '', 'Sim', NULL, 'Sim', 'Olheira', 'Nao', 'Nao', 'Nao', '', 'Nao', '', '', 'Nao', '', '2019-04-22 16:46:00', 'Jade Costa'),
(91, 104, 41, '70', '1.69', 0, 0, '0000-00-00', 'Nao', '', 'A-', 'Sim', 'Implante Hormonal', 'Sim', 'Sim', 'PlÃ¡stica, cerariana', 'Welbutrin ', '', 'Nao', 'Nao', 'Sim', 'Welbutrin', 'Sim', NULL, 'Sim', 'LÃ¡bio ', 'Nao', 'Nao', 'Nao', '', 'Nao', '', '', 'Nao', '', '2019-04-22 17:48:00', 'Jade Costa'),
(92, 162, 43, '', '', 0, 0, '0000-00-00', 'Nao', '', 'B+', 'Nao', '', 'Nao', 'Sim', 'ReduÃ§Ã£o de mamas e Abdominop', '', '', 'Sim', 'Nao', 'Nao', '', 'Nao', NULL, 'Nao', '', 'Nao', 'Nao', 'Sim', 'Torajesik ', 'Nao', '', '', 'Nao', '', '2019-04-24 10:30:00', 'Jade Costa'),
(93, 163, 42, '50', '1.60', 0, 0, '2019-02-13', 'Nao', '', '', 'Nao', '', 'Nao', 'Sim', 'Botox', '', '', 'Nao', 'Nao', 'Nao', '', 'Sim', NULL, 'Sim', 'Bigode Chines ', 'Nao', 'Nao', 'Nao', '', 'Nao', '', '', 'Nao', '', '2019-04-25 10:32:00', 'Jade Costa'),
(94, 164, 51, '70', '1.63', 0, 0, '0000-00-00', 'Nao', '', 'A+', 'Nao', '', 'Sim', 'Sim', 'Cesariana, varizes', 'Rivotril', '', 'Nao', 'Nao', 'Sim', 'Lexapro', 'Nao', NULL, 'Nao', '', 'Nao', 'Nao', 'Nao', '', 'Nao', '', '', 'Nao', '', '2019-04-25 17:48:00', 'Jade Costa'),
(95, 165, 30, '69.8', '1.70', 0, 0, '0000-00-00', 'Nao', '', '', 'Nao', '', 'Nao', 'Nao', '', '', '', 'Nao', 'Nao', 'Nao', '', 'Nao', NULL, 'Nao', '', 'Nao', 'Nao', 'Nao', '', 'Nao', '', '', 'Nao', '', '2019-04-25 18:41:00', 'Jade Costa'),
(96, 166, 57, '68', '1.52', 0, 0, '0000-00-00', 'Nao', '', '', 'Nao', '', 'Sim', 'Sim', 'Laparoscopia e PlÃ¡stica ', 'Atenolol, Captopril, Rivotril,', '', 'Nao', 'Nao', 'Sim', 'Rivotril', 'Sim', NULL, 'Nao', '', 'Nao', 'Nao', 'Nao', '', 'Nao', '', '', 'Sim', 'Sinusite', '2019-04-26 10:29:00', 'Jade Costa'),
(97, 91, 63, '67', '1.56', 0, 0, '0000-00-00', 'Nao', '', 'O+', 'Sim', '', 'Sim', 'Sim', 'VesÃ­cula ', 'Alprazolan, celosoque ', '', 'Nao', 'Nao', 'Sim', 'Alprazolan', 'Sim', NULL, 'Nao', '', 'Nao', 'Nao', 'Nao', '', 'Sim', 'Anestesia com vasos', '3, 4, 10', 'Nao', '', '2019-04-29 11:35:00', 'Jade Costa'),
(98, 167, 57, '', '1.55', 0, 0, '0000-00-00', 'Nao', '', 'O+', 'Nao', '', 'Sim', 'Sim', 'ApÃªndice ', 'Ablok Plus', '', 'Sim', 'Nao', 'Nao', '', 'Sim', NULL, 'Nao', '', 'Nao', 'Nao', 'Nao', '', 'Nao', '', '', 'Nao', '', '2019-04-29 11:46:00', 'Jade Costa'),
(99, 168, 36, '59', '1.60', 0, 0, '0000-00-00', 'Nao', '', '', 'Nao', '', 'Nao', 'Nao', '', '', '', 'Nao', 'Nao', 'Nao', '', 'Sim', NULL, 'Sim', '', 'Nao', 'Nao', 'Nao', '', 'Nao', '', '', 'Nao', '', '2019-04-29 14:58:00', 'Jade Costa'),
(100, 169, 43, '65', '1.71', 0, 0, '0000-00-00', 'Nao', '', 'O+', 'Sim', 'Stress/DepressÃ£o', 'Sim', 'Sim', 'Cesariana', 'Rivotril, Zetron, Paroxetina ', '', 'Nao', 'Nao', 'Sim', 'Rivotril', 'Sim', NULL, 'Sim', 'Bigode Chines ', 'Sim', 'Nao', 'Nao', '', 'Nao', '', '3', 'Nao', '', '2019-04-30 14:54:00', 'Jade Costa'),
(101, 103, 26, '69.00', '1.63', 0, 0, '0000-00-00', 'Nao', '', 'A+', 'Nao', '', 'Nao', 'Sim', 'Mamoplastia', '', '', 'Sim', 'Nao', 'Nao', '', 'Sim', NULL, 'Sim', '', 'Nao', 'Nao', 'Nao', '', 'Nao', '', '', 'Nao', '', '2019-04-30 19:30:00', 'Jade Costa'),
(102, 171, 34, '76', '1.69', 0, 0, '0000-00-00', 'Sim', '', '', 'Nao', '', 'Nao', 'Sim', 'LipoaspiraÃ§Ã£o ', '', '', 'Nao', 'Nao', 'Nao', '', 'Nao', NULL, 'Nao', '', 'Nao', 'Nao', 'Nao', '', 'Nao', '', '', 'Nao', '', '2019-05-03 09:55:00', 'Jade Costa'),
(103, 170, 25, '58', '1.63', 0, 0, '0000-00-00', 'Nao', '', 'O+', 'Nao', '', 'Nao', 'Nao', '', '', '', 'Nao', 'Nao', 'Nao', '', 'Nao', NULL, 'Sim', '', 'Nao', 'Nao', 'Sim', 'Dipirona ', 'Nao', '', '3', 'Nao', '', '2019-05-03 09:59:00', 'Jade Costa'),
(104, 172, 0, '55', '1.34', 30.63, 20.56, '2019-05-02', 'Nao', '', 'O-', 'Nao', '', 'Nao', 'Nao', '', '', '', 'Nao', 'Nao', 'Nao', '', 'Nao', NULL, 'Nao', '', 'Nao', 'Nao', 'Nao', '', 'Nao', '', '2', 'Nao', '', '2019-05-03 14:04:00', 'Admin'),
(105, 173, 33, '59', '1.69', 0, 0, '0000-00-00', 'Nao', '', 'O+', 'Nao', '', 'Nao', 'Sim', 'Cesariana', '', '', 'Nao', 'Nao', 'Nao', '', 'Nao', NULL, 'Nao', '', 'Nao', 'Nao', 'Nao', '', 'Nao', '', '', 'Nao', '', '2019-05-03 16:24:00', 'Jade Costa'),
(106, 174, 49, '67', '1.58', 0, 0, '0000-00-00', 'Nao', '', 'A+', 'Sim', 'OdontolÃ³gico ', 'Sim', 'Sim', 'Cirurgia plÃ¡stica e VesÃ­cula', 'Vitaminas', '', 'Sim', 'Nao', 'Nao', '', 'Nao', NULL, 'Nao', '', 'Nao', 'Nao', 'Nao', '', 'Nao', '', '', 'Nao', '', '2019-05-06 15:50:00', 'Jade Costa'),
(107, 176, 63, '69,00', '1.70', 0, 0, '0000-00-00', 'Nao', '', 'B+', 'Nao', '', 'Nao', 'Sim', 'VesÃ­cula ', '', '', 'Nao', 'Nao', 'Nao', '', 'Sim', NULL, 'Sim', 'Bigode Chines ', 'Nao', 'Nao', 'Nao', '', 'Nao', '', '', 'Nao', '', '2019-05-13 10:19:00', 'Jade Costa'),
(108, 177, 32, '64', '1.66', 0, 0, '0000-00-00', 'Nao', '', '', 'Nao', '', 'Nao', 'Nao', '', '', '', 'Nao', 'Nao', 'Nao', '', 'Sim', NULL, 'Nao', '', 'Nao', 'Nao', 'Nao', '', 'Nao', '', '', 'Nao', '', '2019-05-14 16:49:00', 'Jade Costa'),
(109, 178, 48, '65', '1.40', 0, 0, '0000-00-00', 'Nao', '', 'B+', 'Nao', '', 'Nao', 'Sim', 'Cesariana', '', '', 'Nao', 'Nao', 'Nao', '', 'Nao', NULL, 'Nao', '', 'Nao', 'Nao', 'Nao', '', 'Nao', '', '', 'Nao', '', '2019-05-17 15:02:00', 'Jade Costa'),
(110, 179, 56, '66', '1.55', 0, 0, '2019-04-01', 'Nao', '', 'O+', 'Nao', '', 'Sim', 'Nao', '', 'Clorana, lozartana e vitaminas', '', 'Nao', 'Nao', 'Nao', '', 'Nao', NULL, 'Nao', '', 'Nao', 'Nao', 'Nao', '', 'Nao', '', '3', 'Nao', '', '2019-05-20 14:07:00', 'Jade Costa'),
(111, 180, 28, '58', '1.60', 22.66, 28.23, '0000-00-00', 'Nao', '', 'A+', 'Nao', '', 'Nao', 'Sim', 'Rinoplastia ', '', '', 'Nao', 'Nao', 'Nao', '', 'Sim', NULL, 'Nao', '', 'Nao', 'Nao', 'Nao', '', 'Nao', '', '', 'Nao', '', '2019-06-06 16:58:00', 'Jade Costa');

-- --------------------------------------------------------

--
-- Estrutura da tabela `atendimento`
--

CREATE TABLE `atendimento` (
  `idatendimento` int(11) NOT NULL,
  `idtratamento` int(11) NOT NULL,
  `idcliente` int(11) NOT NULL,
  `data_atendimento` datetime NOT NULL,
  `resp_atendimento` varchar(30) NOT NULL,
  `status_atendimento` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `atendimento`
--

INSERT INTO `atendimento` (`idatendimento`, `idtratamento`, `idcliente`, `data_atendimento`, `resp_atendimento`, `status_atendimento`) VALUES
(1, 4, 18, '2019-03-25 00:00:00', '2', 1),
(2, 12, 18, '2019-03-26 00:00:00', 'Admin', 0),
(3, 200, 18, '2019-04-02 20:41:00', '', 0),
(4, 201, 18, '2019-04-03 18:27:00', '', 1),
(5, 203, 99, '2019-04-18 13:10:00', '', 1),
(6, 209, 149, '2019-04-22 16:52:00', '', 1),
(7, 213, 104, '2019-04-22 21:16:00', '', 1),
(8, 213, 104, '2019-04-23 12:20:00', '', 1),
(9, 203, 99, '2019-04-23 17:26:00', '', 1),
(10, 221, 43, '2019-04-23 19:17:00', '', 1),
(11, 213, 104, '2019-04-23 21:30:00', '', 1),
(12, 223, 162, '2019-04-24 13:37:00', '', 0),
(13, 224, 163, '2019-04-25 18:43:00', '', 0),
(14, 226, 165, '2019-04-26 13:01:00', '', 0),
(15, 228, 167, '2019-04-29 14:50:00', '', 0),
(16, 233, 169, '2019-04-30 22:02:00', '', 0),
(17, 235, 42, '2019-05-02 18:53:00', '', 0),
(18, 236, 171, '2019-05-03 13:10:00', '', 0),
(19, 237, 170, '2019-05-03 13:12:00', '', 0),
(20, 238, 164, '2019-05-03 14:15:00', '', 0),
(28, 243, 174, '2019-05-06 18:25:00', '', 0),
(29, 246, 173, '2019-05-08 12:54:00', '', 0),
(30, 218, 104, '2019-05-10 12:02:00', '', 0),
(31, 247, 176, '2019-05-13 10:18:00', '', 0),
(32, 227, 166, '2019-05-16 14:25:00', '', 0),
(33, 250, 179, '2019-05-20 15:18:00', '', 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `atestado`
--

CREATE TABLE `atestado` (
  `idatestado` int(11) NOT NULL,
  `dataatestado` datetime DEFAULT NULL,
  `qtd` int(3) DEFAULT NULL,
  `respatestado` varchar(20) DEFAULT NULL,
  `idcliente` int(11) DEFAULT NULL,
  `cid` varchar(15) NOT NULL,
  `finalidade` varchar(12) DEFAULT NULL,
  `tipo` varchar(9) NOT NULL,
  `iddentista` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `atestado`
--

INSERT INTO `atestado` (`idatestado`, `dataatestado`, `qtd`, `respatestado`, `idcliente`, `cid`, `finalidade`, `tipo`, `iddentista`) VALUES
(2, '2019-02-13 11:25:00', 20, '', 0, 'A-45', NULL, '', NULL),
(3, '2019-02-13 12:48:00', 5, '', 0, '', NULL, '', NULL),
(4, '2019-02-13 12:50:00', 5, '', 0, '345', NULL, '', NULL),
(8, '2019-02-13 13:06:00', 5, 'Admin', 21, '123', NULL, '', NULL),
(9, '2019-02-21 18:57:00', 6, 'Michella', 26, 'c45', NULL, '', NULL),
(11, '2019-02-28 14:53:00', 5, 'Admin', 18, 'B32', 'Trabalhista', 'Hora', NULL),
(12, '2019-03-22 13:58:00', 4, 'Admin', 18, 'C88', 'Trabalhista', 'Dia', NULL),
(13, '2019-04-30 17:55:00', 1, 'Michella', 169, '-', 'Trabalhista', 'Dia', 5);

-- --------------------------------------------------------

--
-- Estrutura da tabela `cidade`
--

CREATE TABLE `cidade` (
  `idcidade` int(11) UNSIGNED NOT NULL,
  `nome` varchar(40) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `clientes`
--

CREATE TABLE `clientes` (
  `idcliente` int(10) NOT NULL,
  `nome` varchar(70) NOT NULL,
  `cpf` varchar(15) DEFAULT NULL,
  `rg` varchar(15) DEFAULT NULL,
  `sexo` varchar(9) NOT NULL,
  `nascimento` date NOT NULL,
  `endereco` varchar(150) NOT NULL,
  `numero` varchar(6) NOT NULL,
  `bairro` varchar(30) NOT NULL,
  `estado` varchar(3) NOT NULL,
  `cidade` varchar(25) NOT NULL,
  `cep` varchar(11) DEFAULT NULL,
  `celular` varchar(15) NOT NULL,
  `telefone` varchar(15) DEFAULT NULL,
  `email` varchar(60) DEFAULT NULL,
  `data_cadastro` datetime NOT NULL,
  `obs` varchar(150) DEFAULT NULL,
  `convenio` int(2) UNSIGNED DEFAULT NULL,
  `matricula` varchar(15) DEFAULT NULL,
  `titular` varchar(40) DEFAULT NULL,
  `validade` varchar(15) DEFAULT NULL,
  `foto` varchar(40) DEFAULT NULL,
  `atendente` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `clientes`
--

INSERT INTO `clientes` (`idcliente`, `nome`, `cpf`, `rg`, `sexo`, `nascimento`, `endereco`, `numero`, `bairro`, `estado`, `cidade`, `cep`, `celular`, `telefone`, `email`, `data_cadastro`, `obs`, `convenio`, `matricula`, `titular`, `validade`, `foto`, `atendente`) VALUES
(29, 'Maria Aparecida Bartilotti Langbhn', '567.915.936-87', 'M3231310', 'Feminino', '1965-12-19', 'Rua Cel Bento Ladeira ', '47', 'Vila SÃ£o JoÃ£o ', 'MG', 'TeÃ³filo Otoni', '398000000', '98-82341-98', '', 'a@a', '2019-04-03 15:49:00', '', NULL, NULL, NULL, NULL, NULL, 'Samuel'),
(30, 'Ana LuÃ­za Bartilotti Langbehn', '100.193.556-02', 'MG15957495', 'Feminino', '1990-04-03', 'Rua Coronel Bento Ladeira', '47', 'Vila SÃ£o JoÃ£o ', 'MG', 'TeÃ³filo Otoni', '', '33-988234203', '', 'a@a', '2019-04-04 13:42:00', '', NULL, NULL, NULL, NULL, NULL, 'Samuel'),
(31, 'Camila de Oliveira Lorenz', '112.346.636-00', 'MG 17738460', 'Feminino', '1990-12-13', 'Rua OlegÃ¡rio Lima ', '120', 'Centro', 'MG', 'TeÃ³filo Otoni', '39800013', '9928327', '', 'A@A', '2019-04-04 13:53:00', '', NULL, NULL, NULL, NULL, NULL, 'Samuel'),
(32, 'ClÃ¡udia da Silva Braga ', '842.575.636-72', 'MG 7156035', 'Feminino', '1974-04-24', 'Ana Amalia', '331', 'Centro', 'MG', 'TeÃ³filo Otoni', '39800013', '98-87478-47', '', '......', '2019-04-04 14:25:00', '', NULL, NULL, NULL, NULL, NULL, 'Samuel'),
(33, 'Emanuelle Batista Moreira ', '381.883.858-59', '', 'Feminino', '1999-03-01', 'Rua ArmÃªnia Laender ', '48 ap ', '', 'MG', 'TeÃ³filo Otoni', '', '98-70990-59', '', 'a@a', '2019-04-04 14:51:00', '', NULL, NULL, NULL, NULL, NULL, 'Samuel'),
(34, 'ElisÃ¢ngela Pena ', '005.603.376-12', 'MG 6571951', 'Feminino', '1973-11-12', 'Rua VirgÃ­lio Rodrigues ', '', 'Centro', 'MG', 'Ladainha ', '39825000', '98-80561-88', '', 'a@a', '2019-04-04 15:05:00', '', NULL, NULL, NULL, NULL, NULL, 'Samuel'),
(35, 'FabrÃ­cia Soares Oliveira ', '085.763.426-77', 'MG15370557', 'Feminino', '1986-04-17', 'Rua Dr Bruno Fernandes Da Silva ', '133', '......', 'MG', '........', '', '33988273199', '', '', '2019-04-04 15:16:00', '', NULL, NULL, NULL, NULL, NULL, 'Samuel'),
(36, 'Gilson Duque Silva ', '834.151.816-34', 'M 5824377', 'Masculino', '1971-02-14', 'Rua Epaminondas Otoni', '1260', 'Centro', 'MG', 'TeÃ³filo Otoni', '', '98-86548-00', '', 'a@a', '2019-04-04 15:30:00', '', NULL, NULL, NULL, NULL, NULL, 'Samuel'),
(37, 'Helaine Pereira Santos ', '064.440.526-02', 'MG 12795653', 'Feminino', '1983-07-07', 'Rua Miro Ferreira De Oliveira ', '', '', 'MG', 'Itambacuri ', '', '99-97817-13', '', 'a@a', '2019-04-04 15:42:00', '', NULL, NULL, NULL, NULL, NULL, 'Samuel'),
(38, 'Hauanny B. Guedes ', '067.794.266-44', 'MG 11771395', 'Feminino', '1985-06-04', 'Rua Oito', '107 ap', '', 'MG', 'Governador Valadares ', '', '984250616', '', '.........', '2019-04-04 15:51:00', '', NULL, NULL, NULL, NULL, NULL, 'Samuel'),
(39, 'Josiane Pereira Dos Santos ', '103.704.886-52', 'MG 16652970', 'Feminino', '1990-08-31', 'Rua SÃ£o Vicente ', '565', 'Jardim SÃ£o Paulo ', 'MG', 'TeÃ³filo Otoni ', '', '98-8016216', '', 'a@a', '2019-04-04 16:03:00', '', NULL, NULL, NULL, NULL, NULL, 'Samuel'),
(40, 'Juliene Blanc Coelho ', '060.315.386-15', 'M 8745602', 'Masculino', '1964-12-09', 'Av Luiz Boali ', '895', 'Centro', 'MG', 'TeÃ³filo Otoni', '398000000', '98-84140-18', '', 'a@a', '2019-04-04 16:25:00', '', NULL, NULL, NULL, NULL, NULL, 'Samuel'),
(41, 'Joziane Camargo Silva ', '024.075.046-23', 'M8559983', 'Feminino', '1974-04-20', 'Rua Beira Rio ', '66', 'Jardim das AcÃ¡cias ', 'MG', 'TeÃ³filo Otoni', '', '991170561', '', 'a@a', '2019-04-04 16:56:00', '', NULL, NULL, NULL, NULL, NULL, 'Samuel'),
(42, 'Jussara Costa GuimarÃ£es ', '669.589.546-53', 'M4480108', 'Feminino', '1970-05-17', 'Rua Ottomar Bamberg ', '185', 'Jardim Iracema ', 'MG', 'TeÃ³filo  Otoni ', '', '988567834', '', '', '2019-04-04 17:13:00', '', NULL, NULL, NULL, NULL, NULL, 'Samuel'),
(43, ' Luciene Kretli Winkelstroter', '388.727.066-53', 'MG 2235229', 'Feminino', '1960-08-14', 'Rua Marcos JosÃ© Gazzinelli ', '178', 'Jardim Iracema ', 'MG', 'TeÃ³filo Otoni', '', '33-98851-0323', '', 'a@a', '2019-04-08 13:44:00', '', NULL, NULL, NULL, NULL, NULL, 'Samuel'),
(44, 'Lerlania Gomes GonÃ§alves ', '088.816.276-63', 'MG12236585', 'Feminino', '1981-11-18', 'Rua Prefeito NIlson Dutra ', '81', '', 'mg', 'Padre ParaÃ­so ', '', '33-98460-1293', '', '', '2019-04-08 14:08:00', '', NULL, NULL, NULL, NULL, NULL, 'Samuel'),
(45, 'LeticÃ­a Do Socorro Esteves Sena ', '047.479.536-55', 'MG13784755', 'Feminino', '1977-05-23', 'Av JoÃ£o Bastos CaiÃ´', '105', 'Centro', 'MG', 'Ladainha', '39825000', '33-98710-3044', '', 'a@a', '2019-04-08 14:24:00', '', NULL, NULL, NULL, NULL, NULL, 'Samuel'),
(46, 'Milania Ramalho Viana Figueiredo ', '466.565.536-72', 'M1824631', 'Feminino', '1962-08-01', 'Rua Miguel Penchel ', '370', 'Ipiranga ', 'mg', 'TeÃ³filo Otoni', '', '33-99907-3384', '', '', '2019-04-08 14:42:00', '', NULL, NULL, NULL, NULL, NULL, 'Samuel'),
(47, 'Missiely Luiz Dos Santos ', '031.539.136-76', 'MG 10068641', 'Feminino', '1978-11-25', 'Rua Belo Horizonte ', '16', '', 'Mg', '...', '', '33-98526-2549', '', '', '2019-04-08 14:56:00', '', NULL, NULL, NULL, NULL, NULL, 'Samuel'),
(48, 'Marcelle Condessa Marques', '990.996.166-00', 'M7605456', 'Feminino', '1975-02-15', 'Rua Brasilia ', '293', 'centro', 'MG', 'TeÃ³filo Otoni', '', '33-991752701', '', 'a@a', '2019-04-08 16:25:00', '', NULL, NULL, NULL, NULL, NULL, 'Samuel'),
(49, 'Laura Roberta Rosa SalomÃ£o ', '089.345.626-84', 'MG16141563', 'Feminino', '1987-04-25', 'Rua Benjamim Constant', '80', 'ConcÃ³rdia ', 'MG', 'TeÃ³filo Otoni', '', '33-98810-5531', '', 'a@a', '2019-04-08 16:54:00', '', NULL, NULL, NULL, NULL, NULL, 'Samuel'),
(50, 'Marcele Ferreira Otoni', '...........', '.........', 'Feminino', '1971-03-22', 'Rua Romeu Gazzineli ', '84', '', 'mg', 'TeÃ³filo Otoni ', '', '33-98811-7606', '', '', '2019-04-08 17:10:00', '', NULL, NULL, NULL, NULL, NULL, 'Samuel'),
(51, 'Priscila Brun Valadares ', '086.862.916-27', 'MG15368768', 'Feminino', '1989-03-15', 'Rua Francisco Serafim ', '250', '', 'MG', 'TeÃ³filo Otoni', '', '31-98734-0696', '', 'a@a', '2019-04-09 09:07:00', '', NULL, NULL, NULL, NULL, NULL, 'Samuel'),
(52, 'Juliene Masculino Coelho', '048.381.556-03', 'MG18519093', 'Feminino', '1978-12-12', 'Rua Mozart Santa Luzia Da ConceiÃ§Ã£o ', '47', '', 'MG', 'TeÃ³filo Otoni', '398000000', '988414018', '', 'a@a', '2019-04-09 09:27:00', '', NULL, NULL, NULL, NULL, NULL, 'Samuel'),
(53, 'Sheila Fernandes Cardoso Morais ', '048.381.556-03', 'MG18519093', 'Feminino', '1978-12-12', 'Rua Mozart Santa Luzia Da ConceiÃ§Ã£o ', '47', '', 'MG', 'TeÃ³filo Otoni', '398000000', '31-99158-3685', '', 'a@a', '2019-04-09 09:42:00', '', NULL, NULL, NULL, NULL, NULL, 'Samuel'),
(54, 'SilvÃ¢nia Rihs Grateki ', '057.637.646-92', 'M6296616', 'Feminino', '1971-07-21', 'Rua AntÃ´nio Alves Benjamim ', '214 ap', 'Centro ', 'MG', 'TeÃ³filo Otoni', '398000000', '19-99686-9898', '', 'a@a', '2019-04-09 09:58:00', '', NULL, NULL, NULL, NULL, NULL, 'Samuel'),
(55, 'Soraia Maria Laender Barreiros ', '002.547.356-57', 'M8489160', 'Feminino', '1962-05-31', 'Rua JosÃ© Augusto Farias', '804e', 'Castro Pires', 'MG', 'TeÃ³filo Otoni', '', '33-98862-8890', '', 'a@a', '2019-04-09 10:10:00', '', NULL, NULL, NULL, NULL, NULL, 'Samuel'),
(56, 'Tatiane Silva De Oliveira ', '101.861.216-52', 'mg16015809', 'Feminino', '1981-04-09', 'Rua Kurt Hollerbach ', '81', 'Matinha', 'MG', 'TeÃ³filo Otoni', '', '33-98812-1715', '', 'a@a', '2019-04-09 10:23:00', '', NULL, NULL, NULL, NULL, NULL, 'Samuel'),
(57, 'TÃ¢nia Keller De Oliveira ', '046.874.336-77', '11879958', 'Feminino', '1979-05-28', 'Rua 55', '100', 'Matinha', 'MG', 'TeÃ³filo Otoni ', '', '33-98819-3406', '', '', '2019-04-09 10:46:00', '', NULL, NULL, NULL, NULL, NULL, 'Samuel'),
(58, 'Adalcio Ferreira Dutra', '827.064.176-68', 'MG5754959', 'Masculino', '1972-03-27', 'Rua Miriam', '442', 'SÃ£o CristovÃ£o', 'MG', 'TeÃ³filo Otoni', '', '33-98809-6845', '', '', '2019-04-16 13:13:00', '', NULL, NULL, NULL, NULL, NULL, 'Jade'),
(59, 'Aleti Francisca dos Santos ', '976.362.906', 'MG15994416', 'Feminino', '1961-10-09', 'Rua Gustavo Leonardo', '579', 'SÃ£o Jacinto ', 'MG', 'TeÃ³filo Otoni', '', '33-98710-1011', '', '', '2019-04-16 13:21:00', '', NULL, NULL, NULL, NULL, NULL, 'Jade Costa'),
(60, 'Adriana Ribeiro Pinto ', '050.333.486-39', 'MG8910915', 'Feminino', '1978-01-24', 'Rua Helmut Dorr', '171', 'Castro Pires', 'Min', 'TeÃ³filo Otoni', '', '61-98253-6552', '', '', '2019-04-16 13:26:00', '', NULL, NULL, NULL, NULL, NULL, 'Jade'),
(61, 'Andreia de Souza Coimbra', '035.251.496-54', 'MG10593141', 'Feminino', '1976-05-18', 'Rua Gil do Val', '175', 'Vila VitÃ³ria ', 'MG', 'TeÃ³filo Otoni', '', '33-98803-6681', '', '', '2019-04-16 13:31:00', '', NULL, NULL, NULL, NULL, NULL, 'Viviane'),
(62, 'Alexsandra Serafim Baleeiro', '007.835.546-05', 'MG8092462', 'Feminino', '1974-09-14', 'Avenida Aguinaldo Neiva ', '810', 'Jardim das AcÃ¡cias ', 'MG', 'TeÃ³filo Otoni', '', '33-98401-0866', '', '', '2019-04-16 13:37:00', '', NULL, NULL, NULL, NULL, NULL, 'Jade Costa'),
(63, 'Marli Aparecida Alves de Souza ', '058.621.986-28', 'MG12778482', 'Feminino', '1982-11-16', 'Rua Nerval Figueiredo ', '246', 'Centro', 'MG', 'Ladainha', '', '33-98823-1650', '', '', '2019-04-16 13:55:00', '', NULL, NULL, NULL, NULL, NULL, 'Viviane'),
(64, 'Alyne Rachid Ali Scofield', '058.379.696-67', 'MG10846261', 'Feminino', '1984-03-07', 'Rua Doutor Otloma Bambeg', '190', '', 'MG', 'TeÃ³filo Otoni ', '', '33-98832-6418', '', '', '2019-04-16 14:08:00', '', NULL, NULL, NULL, NULL, NULL, 'Viviane'),
(65, 'Adriana Oliveira Duarte', '084.844.986-03', 'MG15714233', 'Feminino', '1988-01-11', 'Rua Lair Barata Godinho', '197', 'Ipiranga', 'MG', 'TeÃ³filo Otoni', '', '33-98804-0452', '', '', '2019-04-16 14:12:00', '', NULL, NULL, NULL, NULL, NULL, 'Jade'),
(66, 'Ana Luiza Figueiredo Porto Kern ', '043.759.866-70', 'MG11487288', 'Feminino', '1979-05-21', 'Rua Antonio Onofre ', '88', '', 'MG', 'TeÃ³filo Otoni', '', '33-98805-7001', '', '', '2019-04-16 14:15:00', '', NULL, NULL, NULL, NULL, NULL, 'Jade Costa'),
(67, 'Adria Rodrigues Silva', '836.164.116-53', 'MG21497984', 'Feminino', '1967-03-12', 'Rua Jequitinhonha ', '107', 'FiladÃ©lfia ', 'MG', 'TeÃ³filo Otoni ', '', '33-98839-8371', '', '', '2019-04-16 14:18:00', '', NULL, NULL, NULL, NULL, NULL, 'Jade'),
(68, 'Aderbal GonÃ§alves Soares Neto ', '132.516.716-96', '', 'Masculino', '1996-07-15', 'Rua Conselheiro Mayrink', '', 'Centro', 'MG', 'TeÃ³filo Otoni', '', '33-98838-0660', '', '', '2019-04-16 14:23:00', '', NULL, NULL, NULL, NULL, NULL, 'Jade'),
(69, 'Ana ClÃ¡udia Farias Viana', '042.262.306-71', 'MG15961210', 'Feminino', '1987-10-16', 'Rua JosÃ© Vicente Coimbra', '87', 'Centro', 'MG', 'TeÃ³filo Otoni', '', '33-99932-6005', '', '', '2019-04-16 14:26:00', '', NULL, NULL, NULL, NULL, NULL, 'Viviane'),
(70, 'Bruna Doehler Santos ', '103.655.376-08', 'MG12904351', 'Feminino', '1990-03-12', 'Rua Gustavo Doehler', '73', 'SÃ£o Jacinto ', 'MG', 'TeÃ³filo Otoni ', '', '33-98822-0830', '', '', '2019-04-16 14:36:00', '', NULL, NULL, NULL, NULL, NULL, 'Viviane'),
(71, 'Bruna Moreira da Silva Van Der Maas', '039.261.146-57', 'MG10989315', 'Feminino', '1980-05-01', 'Rua Gustavo Pechir', '66', 'Ipiranga', 'MG', 'TeÃ³filo Otoni ', '', '33-98819-6185', '', '', '2019-04-16 14:39:00', '', NULL, NULL, NULL, NULL, NULL, 'Viviane'),
(72, 'Bruna Ferreira da Cruz', '094.657.646-71', 'MG16160398', 'Feminino', '1989-01-05', 'Rua Coronel Ramos ', '335/Ap', 'FÃ¡tima ', 'MG', 'TeÃ³filo Otoni ', '', '33-98865-7977', '', '', '2019-04-16 14:42:00', '', NULL, NULL, NULL, NULL, NULL, 'Viviane'),
(73, 'Bennaya Almeida de Souza', '086.943.846-80', 'MG15599604', 'Feminino', '1986-12-14', 'Avenida GetÃºlio Vargas ', '1049', 'Centro', 'MG', 'TeÃ³filo Otoni', '', '33-98877-1605', '', '', '2019-04-16 14:45:00', '', NULL, NULL, NULL, NULL, NULL, 'Viviane'),
(74, 'Bianca Xavier de Figueiredo ', '138.599.026-01', 'MG15989539', 'Feminino', '1997-02-22', 'Travessa SÃ£o Vicente ', '58', 'Centro ', 'MG', 'TeÃ³filo Otoni ', '', '33-99157-9269', '', '', '2019-04-16 14:47:00', '', NULL, NULL, NULL, NULL, NULL, 'Viviane'),
(75, 'Bedma Carolina Silva Costa', '006.781.991-59', 'MG13008195', 'Feminino', '1982-11-19', 'Rua JosÃ© Arthur Serafim ', '122', '', 'MG', 'TeÃ³filo Otoni ', '', '33-98433-1645', '', '', '2019-04-16 14:51:00', '', NULL, NULL, NULL, NULL, NULL, 'Viviane'),
(76, 'Clide Pereira Viana', '081.580.566-79', 'MG15069307', 'Feminino', '1988-09-03', 'Rua Cabo Edson', '150', 'SÃ£o Francisco', 'MG', 'TeÃ³filo Otoni', '', '33-98812-1525', '', '', '2019-04-16 14:57:00', '', NULL, NULL, NULL, NULL, NULL, 'Viviane'),
(77, 'ClÃ¡udia Aline Dilly', '014.214.156-90', 'MG10561358', 'Feminino', '1980-03-10', 'Rua Francisco Ricardo de Souza', '247', 'Castro Pires', 'MG', 'TeÃ³filo Otoni', '', '32-99193-2363', '', '', '2019-04-16 15:08:00', '', NULL, NULL, NULL, NULL, NULL, 'Viviane'),
(78, 'Camila Souza Silva ', '106.029.166-58', 'MG17151797', 'Feminino', '1991-05-21', 'Rua Frei HilÃ¡rio ', '200', 'Joaquim Pedrosa', 'MG', 'TeÃ³filo Otoni', '', '33-98417-0007', '', '', '2019-04-16 15:12:00', '', NULL, NULL, NULL, NULL, NULL, 'Viviane'),
(79, 'Cleide Regina Pedroso Silva', '077.425.836-58', 'MG13930055', 'Feminino', '1986-05-24', 'Rua Presidente Bernardes ', '175', 'Centro', 'MG', 'Padre ParaÃ­so ', '', '33-98405-7849', '', '', '2019-04-16 15:15:00', '', NULL, NULL, NULL, NULL, NULL, 'Viviane'),
(80, 'Carine Souto de Almeida', '049.450.586-95', 'MG11904950', 'Feminino', '1982-01-31', 'Rua JosÃ© Carlos Laender', '50/Ap ', 'Marajoara', 'MG', 'TeÃ³filo Otoni', '', '33-99127-7226', '', '', '2019-04-16 15:19:00', '', NULL, NULL, NULL, NULL, NULL, 'Viviane'),
(81, 'Caroline Lopes Colen Martins ', '121.844.876-86', 'MG12366400', 'Feminino', '1993-08-12', 'Rua Antonio Ottoni de Castro', '116', 'FÃ¡tima', 'MG', 'TeÃ³filo Otoni', '', '33-99136-5740', '', '', '2019-04-16 15:22:00', '', NULL, NULL, NULL, NULL, NULL, 'Viviane'),
(82, 'Clesia Zucalatto Salvadini', '000.791.477-63', 'MG107069163', 'Feminino', '1970-03-05', 'Rua Alamida ', '82', 'Bela Vista ', 'MG', 'TeÃ³filo Otoni ', '', '33-98874-6782', '', '', '2019-04-16 15:24:00', '', NULL, NULL, NULL, NULL, NULL, 'Viviane'),
(83, 'ClÃ¡udia Jussara Constantin ', '004.051.616-46', 'MG628440', 'Feminino', '1975-05-23', 'Rua Julio Hauseim ', '167', 'SÃ£o Jacinto ', 'MG', 'TeÃ³filo Otoni', '', '33-99806-2305', '', '', '2019-04-16 15:39:00', '', NULL, NULL, NULL, NULL, NULL, 'Viviane'),
(84, 'Cecilia Rodrigues Vieira de Matos', '836.252.206-06', 'MG4981127', 'Feminino', '1968-06-23', 'Rua Victorn Renault', '812/Ap', 'Mara', 'MG', 'TeÃ³filo Otoni', '', '33-98888-1331', '', '', '2019-04-16 15:44:00', '', NULL, NULL, NULL, NULL, NULL, 'Viviane'),
(85, 'Daniel Souza Santos', '054.960.906-79', 'MG11793714', 'Masculino', '1984-05-06', 'Rua Doutor Onofre', '525', 'Centro', 'MG', 'TeÃ³filo Otoni', '', '33-98849-0089', '', '', '2019-04-16 15:53:00', '', NULL, NULL, NULL, NULL, NULL, 'Viviane'),
(86, 'Diana Sofia Piechocki Wanderley', '010.849.344-00', 'MG6099652', 'Feminino', '1991-07-14', 'Rua D', '37', 'Castro Pires', 'MG', 'TeÃ³filo Otoni', '', '31-98832-5713', '', '', '2019-04-16 15:57:00', '', NULL, NULL, NULL, NULL, NULL, 'Viviane'),
(87, 'Davi Dutra de Carvalho', '137.728.606-13', 'MG17606171', 'Masculino', '1998-03-12', 'Rua Bertulina Barbosa', '06', 'Solidariedade ', 'MG', 'TeÃ³filo Otoni', '', '33-98811-3030', '', '', '2019-04-16 16:00:00', '', NULL, NULL, NULL, NULL, NULL, 'Viviane'),
(88, 'Deborah Kelly Teixeira', '045.077.196-23', 'MG11440942', 'Feminino', '1979-11-30', 'Rua Carlos Leonardt', '621/Ap', 'Ipiranga', 'MG', 'TeÃ³filo Otoni', '', '33-98809-3718', '', '', '2019-04-16 16:02:00', '', NULL, NULL, NULL, NULL, NULL, 'Viviane'),
(89, 'Eliel GonÃ§alves Silva', '882.398.536-68', 'MG6281878', 'Masculino', '1974-08-19', 'Rua Arthur Achitchin', '36', 'Marajoara', 'MG', 'TeÃ³filo Otoni', '', '33-98811-6348', '', '', '2019-04-16 16:08:00', '', NULL, NULL, NULL, NULL, NULL, 'Viviane'),
(90, 'Eliete Lima', '513.233.036-34', 'MG2832957', 'Feminino', '1955-06-15', 'Rua Daniel Freire', '137', 'Novo Horizonte', 'MG', 'TeÃ³filo Otoni', '', '33-98862-9676', '', '', '2019-04-16 16:17:00', '', NULL, NULL, NULL, NULL, NULL, 'Viviane'),
(91, 'Ednalva Fulgencio Costa Santana', '703.474.926-49', 'MG13703594', 'Feminino', '1955-12-15', 'Rua AristÃ³teles Dantas GuimarÃ£es ', '256', 'Castro Pires', 'MG', 'TeÃ³filo Otoni', '', '33-98701-2142', '3522-6336', '', '2019-04-16 16:28:00', '', NULL, NULL, NULL, NULL, NULL, 'Viviane'),
(92, 'Edima Elvira Petzold Fonseca', '689.694.906-63', 'MG206472', 'Feminino', '1968-07-19', 'Avenida SidÃ´nio Otoni', '1945', 'SÃ£o Jacinto ', 'MG', 'TeÃ³filo Otoni', '', '33-98823-9100', '', '', '2019-04-16 16:31:00', '', NULL, NULL, NULL, NULL, NULL, 'Viviane'),
(93, 'Emilio Paschke Neto', '068.778.766-10', 'MG13346215', 'Masculino', '1986-02-10', 'Rua Gustavo Leonardo', '951', 'SÃ£o CristovÃ£o', 'MG', 'TeÃ³filo Otoni', '', '33-99167-9321', '', '', '2019-04-16 16:34:00', '', NULL, NULL, NULL, NULL, NULL, 'Viviane'),
(94, 'Fabricia Pereira Silva', '072.236.986-75', 'MG14451960', 'Feminino', '1984-06-10', 'Rua dos Romanos', '140', '', 'MG', 'TeÃ³filo Otoni', '', '33-98850-1692', '', '', '2019-04-16 16:38:00', '', NULL, NULL, NULL, NULL, NULL, 'Viviane'),
(95, 'Erica Almeida Lima', '046.264.636-06', 'MG11822536', 'Feminino', '1981-11-10', 'Rua Gustavo Leonardo ', '608', 'SÃ£o Jacinto', 'MG', 'TeÃ³filo Otoni', '', '33-98866-5774', '', '', '2019-04-16 16:57:00', '', NULL, NULL, NULL, NULL, NULL, 'Viviane'),
(96, 'Gilvania Bezerra', '824.521.046-00', '', 'Feminino', '1972-04-23', 'Rua JosÃ© Carvalho do Delajvente', '89', 'Jardim Iracema', 'MG', 'TeÃ³filo Otoni', '', '33-98819-0070', '', '', '2019-04-16 17:04:00', '', NULL, NULL, NULL, NULL, NULL, 'Viviane'),
(97, 'Geovana Rodrigues Ferreira Neves', '141.005.866-20', 'MG20447332', 'Feminino', '2002-02-17', 'Rua JoÃ£o Silvestre Pessoa ', '150/Ap', '', 'MG', 'TeÃ³filo Otoni', '', '33-99995-1254', '', '', '2019-04-16 17:13:00', '', NULL, NULL, NULL, NULL, NULL, 'Viviane'),
(98, 'Gabriel Murta de MagalhÃ£es ', '036.928.209-41', 'MG89404460', 'Masculino', '1982-04-18', 'Rua Tupis ', '10', 'FiladÃ©lfia ', 'MG', 'TeÃ³filo Otoni', '', '33-98805-3115', '', '', '2019-04-16 17:17:00', '', NULL, NULL, NULL, NULL, NULL, 'Viviane'),
(99, 'Leiliane Oliveira Soares ', '066.579.276-00', 'MG13881449', 'Feminino', '1987-09-23', 'Rua JosÃ© Carlos', '51', 'SÃ£o Diogo', 'MG', 'TeÃ³filo Otoni', '', '3335216379', '', '', '2019-04-16 17:23:00', '', NULL, NULL, NULL, NULL, NULL, 'Viviane'),
(100, 'Giovani AurÃ©lio Silva ', '880.995.126-34', 'MG743242', 'Masculino', '1975-04-26', 'Rua JosÃ© Carlos Leme ', '50/Ap ', '', 'MG', 'TeÃ³filo Otoni', '', '33-99197-7646', '', '', '2019-04-16 17:27:00', '', NULL, NULL, NULL, NULL, NULL, 'Viviane'),
(101, 'Gilvete Santos do Valle', '834.114.886-20', 'MG6172077', 'Feminino', '1972-09-04', 'Rua Benjamim Constant', '115', 'Soares da Costa', 'MG', 'TeÃ³filo Otoni ', '', '33-98875-2996', '', '', '2019-04-16 17:33:00', '', NULL, NULL, NULL, NULL, NULL, 'Viviane'),
(102, 'Georges Dalivio Prates', '089.925.106-40', 'MG14942756', 'Masculino', '1988-08-10', 'Rua Henrique Arruda ', '65', 'SÃ£o CristovÃ£o ', 'MG', 'TeÃ³filo Otoni', '', '33-98833-7575', '', '', '2019-04-16 17:39:00', '', NULL, NULL, NULL, NULL, NULL, 'Viviane'),
(103, 'Gabriela Costa Duarte ', '112.552.456-11', '', 'Feminino', '1992-08-11', 'Rua Prates', '64', 'Tabajaras', 'MG', 'TeÃ³filo Otoni', '', '33-99972-7942', '', '', '2019-04-16 17:42:00', '', NULL, NULL, NULL, NULL, NULL, 'Viviane'),
(104, 'Gecilaine Vieira Souza Pereira', '038.694.836-44', 'MG10971172', 'Feminino', '1977-11-18', 'Rua ArmÃªnia Laender ', '112/Ap', 'Marajoara', 'MG', 'TeÃ³filo Otoni', '', '33-98861-7636', '', '', '2019-04-16 17:45:00', '', NULL, NULL, NULL, NULL, NULL, 'Viviane'),
(105, 'Ingride Quintana de Souza ', '727.905.986-49', 'MG5756761', 'Feminino', '1970-02-22', 'Avenida GetÃºlio Vargas', '867', 'Centro', 'MG', 'TeÃ³filo Otoni', '', '33-98431-7442', '', '', '2019-04-16 17:55:00', '', NULL, NULL, NULL, NULL, NULL, 'Viviane'),
(106, 'Irislandia Rodrigues Caldeira', '837.185.326-20', 'MG8082834', 'Feminino', '1973-10-13', 'Rua JosÃ© de Souza Neves ', '150/Ap', 'Marajoara', 'MG', 'TeÃ³filo Otoni', '', '33-98855-9518', '', '', '2019-04-16 17:58:00', '', NULL, NULL, NULL, NULL, NULL, 'Viviane'),
(107, 'Jacinira Chaves Metzker', '026.880.806-60', 'MG-8211380', 'Feminino', '1975-02-20', 'Rua Nossa Senhora da Penha', '15', '', 'MG', 'TeÃ³filo Otoni', '', '33-98821-9753', '', '', '2019-04-16 18:06:00', '', NULL, NULL, NULL, NULL, NULL, 'Viviane'),
(108, 'Juliene Chacara Miguez Colen ', '048.521.326-58', 'MG5345223', 'Feminino', '1980-09-11', 'Rua Joaquim Ananias de Toledo', '102', '', 'MG', 'TeÃ³filo Otoni', '', '33-99969-1109', '', '', '2019-04-16 18:16:00', '', NULL, NULL, NULL, NULL, NULL, 'Viviane'),
(109, 'Jaqueline Braga Moreira', '029.917.356-94', 'MG8244561', 'Feminino', '1976-04-14', 'Rua Ruy Prates', '142', 'Tabajaras', 'MG', 'TeÃ³filo Otoni', '', '33-98806-0637', '', '', '2019-04-16 18:19:00', '', NULL, NULL, NULL, NULL, NULL, 'Viviane'),
(110, 'Jesuina Mendes Brito', '304.404.916-49', 'MG3876175', 'Feminino', '1953-06-07', 'Rua Vista Alegre', '81', 'Matinha', 'MG', 'TeÃ³filo Otoni', '', '33-88433-084', '', '', '2019-04-16 18:21:00', '', NULL, NULL, NULL, NULL, NULL, 'Viviane'),
(111, 'Julia Carla Nonato Araujo ', '061.507.346-84', 'MG11829327', 'Feminino', '1978-05-09', 'Rua Alfredo SÃ¡', '2843', 'Centro', 'MG', 'TeÃ³filo Otoni', '', '33-98821-7974', '', '', '2019-04-16 18:23:00', '', NULL, NULL, NULL, NULL, NULL, 'Viviane'),
(112, 'Kissila Pacheco Oliveira ', '041.165.026-26', 'MG11224384', 'Feminino', '1980-10-31', 'Rua JosÃ© Caires', '15', 'Castro Pires', 'MG', 'TeÃ³filo Otoni', '', '33-98872-8339', '', '', '2019-04-17 09:39:00', '', NULL, NULL, NULL, NULL, NULL, 'Viviane'),
(113, 'Karla SimÃµes Guedes Loesch', '090.323.246-40', 'MG15421004', 'Feminino', '1998-12-05', 'Avenida Santana', '5/Ap 1', 'SÃ£o Jacinto', 'MG', 'TeÃ³filo Otoni', '', '33-99110-9344', '', '', '2019-04-17 09:42:00', '', NULL, NULL, NULL, NULL, NULL, 'Viviane'),
(114, 'Katia Trega Rihs', '065.882.726-00', 'MG10963500', 'Feminino', '1983-03-23', 'Rua Joseph Gleber ', '145', 'FÃ¡tima', 'MG', 'TeÃ³filo Otoni', '', '33-98853-0606', '', '', '2019-04-17 09:45:00', '', NULL, NULL, NULL, NULL, NULL, 'Viviane'),
(115, 'Ludmyla Lauar Schocper', '039.818.206-06', 'MG11227697', 'Feminino', '1978-12-05', 'Rua Tanrovos', '148', 'FiladÃ©lfia ', 'MG', 'TeÃ³filo Otoni', '', '33-88945-687', '33-3523-7563', '', '2019-04-17 10:12:00', '', NULL, NULL, NULL, NULL, NULL, 'Jade Costa'),
(116, 'Luciene de Souza Santos', '070.981.396-10', 'MG15947743', 'Feminino', '1984-08-31', 'Rua Cassiano Terra', '273', 'Nossa Senhora das GraÃ§as', 'MG', 'Malacacheta', '', '33-99147-4430', '', '', '2019-04-17 10:35:00', '', NULL, NULL, NULL, NULL, NULL, 'Jade Costa'),
(117, 'Leonam de Oliveira Araujo ', '117.723.715-45', 'MG18191460', 'Masculino', '1994-06-18', 'Rua Ana AmÃ¡lia ', '380/Ap', 'Altino Barbosa', 'MG', 'TeÃ³filo Otoni', '', '33-99961-7420', '', '', '2019-04-17 10:39:00', '', NULL, NULL, NULL, NULL, NULL, 'Jade Costa'),
(118, 'Luan Dias Almeida', '103.426.986-05', 'MG12918034', 'Masculino', '1990-12-26', 'Rua Jader Ferreira Barrancos', '500', 'Ipiranga', 'MG', 'TeÃ³filo Otoni ', '', '33-98889-9600', '', '', '2019-04-17 10:42:00', '', NULL, NULL, NULL, NULL, NULL, 'Jade Costa'),
(119, 'Leir Souza Santos', '573.293.896-68', 'MG5755198', 'Feminino', '1953-03-26', 'Rua Doutor Onofre', '519', 'Centro', 'MG', 'TeÃ³filo Otoni', '', '33-98837-0647', '', '', '2019-04-17 10:44:00', '', NULL, NULL, NULL, NULL, NULL, 'Jade Costa'),
(120, 'LuÃ­za Jorge Andrade Ottoni', '086.492.546-83', 'MG13257115', 'Feminino', '1986-12-05', 'Rua ConcÃ³rdia ', '185', 'ConcÃ³rdia', ' MG', 'TeÃ³filo Otoni', '', '33-98800-1019', '33-3522-4317', '', '2019-04-17 11:49:00', '', NULL, NULL, NULL, NULL, NULL, 'Jade Costa'),
(121, 'Leila Maria Caldeira dos Santos', '006.186.536-27', 'MG3449790', 'Feminino', '1968-08-29', 'Rua Joaquim de Paulo', '170', 'Matinha', 'MG', 'TeÃ³filo Otoni', '', '33-98827-2208', '', '', '2019-04-17 11:53:00', '', NULL, NULL, NULL, NULL, NULL, 'Jade Costa'),
(122, 'Luiza Pena Esteves Sena', '106.018.946-18', 'MG15593588', 'Feminino', '1996-05-23', 'Rua VirgÃ­lio Rodrigues ', '190', 'Centro', 'MG', 'TeÃ³filo Otoni', '', '33-98822-1900', '', '', '2019-04-17 11:56:00', '', NULL, NULL, NULL, NULL, NULL, 'Jade Costa'),
(123, 'Lorena Gabriela Alves e Silva', '135.108.676-61', 'MG19258330', 'Feminino', '1997-03-10', 'Rua JoÃ£o Burman', '290', 'SÃ£o Jacinto', 'MG', 'TeÃ³filo Otoni', '', '33-99122-9994', '', '', '2019-04-17 12:01:00', '', NULL, NULL, NULL, NULL, NULL, 'Jade Costa'),
(124, 'Lucimar Barrozo Alves', '039.236.056-09', 'MG1107794', 'Feminino', '1971-05-11', 'Rua Hermut Door', '250', 'Castro Pires', 'MG', 'TeÃ³filo Otoni', '', '33-98899-6265', '', '', '2019-04-17 12:04:00', '', NULL, NULL, NULL, NULL, NULL, 'Jade Costa'),
(125, 'Lucilene Carvalho dos Santos ', '101.701.656-98', 'MG16742202', 'Feminino', '1990-02-04', 'Rua Francisco Soares de SÃ¡', '88', 'GrÃ£o Para', 'MG', 'TeÃ³filo Otoni', '', '33-98878-2306', '', '', '2019-04-17 12:06:00', '', NULL, NULL, NULL, NULL, NULL, 'Jade Costa'),
(126, 'Maria Laurinda Murta e Silva', '---.---.------', 'MG3588405', 'Feminino', '1963-06-03', '-', '', '', '', '-', '', '', '', '', '2019-04-17 14:28:00', '', NULL, NULL, NULL, NULL, NULL, 'Jade Costa'),
(127, 'Marcela LeÃ£o SimÃµes ', '094.719.236-03', 'MG15237008', 'Feminino', '1988-04-11', 'Rua Araguaia', '202', '', 'MG', 'TeÃ³filo Otoni', '', '33-98868-9744', '', '', '2019-04-17 14:30:00', '', NULL, NULL, NULL, NULL, NULL, 'Jade Costa'),
(128, 'Maria JosÃ© da Silva Parisi', '011.712.466-41', 'MG6932417', 'Feminino', '1974-07-09', 'Rua Numo Cunha Melo', '284', 'Centro', 'MG', 'TeÃ³filo Otoni', '', '33-98812-2676', '', '', '2019-04-17 14:32:00', '', NULL, NULL, NULL, NULL, NULL, 'Jade Costa'),
(129, 'MÃ­rian Souza Teixeira Chaves', '102.590.836-82', 'MG16820355', 'Feminino', '1990-03-22', 'Travessa Domingos Ferreira Froes', '50', 'Jardim Iracema', 'MG', 'TeÃ³filo Otoni', '', '33-99100-1898', '', '', '2019-04-17 14:34:00', '', NULL, NULL, NULL, NULL, NULL, 'Jade Costa'),
(130, 'Marilene Carvalho dos Santos', '088.050.206-13', 'MG15173695', 'Feminino', '1988-10-16', 'Rua Engenheiro Lindemberg', '89', 'Centro', 'MG', 'TeÃ³filo Otoni', '', '33-98812-5967', '', '', '2019-04-17 14:36:00', '', NULL, NULL, NULL, NULL, NULL, 'Jade Costa'),
(131, 'Marcos Vinicios Silva Pereira', '---.---.------', 'MG17110856', 'Masculino', '1992-01-04', 'Rua Jorge Mattar', '68', 'Centro', 'MG', 'TeÃ³filo Otoni', '', '33-98836-9411', '', '', '2019-04-17 14:38:00', '', NULL, NULL, NULL, NULL, NULL, 'Jade Costa'),
(132, 'Maria do Socorro Coelho de Almeida', '945.712.366-20', 'MG3341623', 'Feminino', '1948-01-12', 'Rua 30 de Janeiro ', '249', 'GrÃ£o Duquesa', 'MG', 'TeÃ³filo Otoni', '', '33-99913-8419', '', '', '2019-04-17 14:40:00', '', NULL, NULL, NULL, NULL, NULL, 'Jade Costa'),
(133, 'Mayana Gomes Mattar', '098.972.896-07', 'MG14925547', 'Feminino', '1990-06-20', 'Avenida Brasil ', '477', 'Santa EfigÃªnia ', 'MG', 'Belo Horizonte', '', '31-99990-0430', '', '', '2019-04-17 14:42:00', '', NULL, NULL, NULL, NULL, NULL, 'Jade Costa'),
(134, 'Marli da Silva Caetano ', '630.519.156-53', 'MG4987426', 'Feminino', '1960-06-02', 'Rua Antonio Sales GuimarÃ£es', '121', 'Jardim das AcÃ¡cias ', 'MG', 'TeÃ³filo Otoni', '', '33-98802-3888', '33-3523-6121', '', '2019-04-17 14:46:00', '', NULL, NULL, NULL, NULL, NULL, 'Jade Costa'),
(135, 'Maria D\'Ajuda Chaves Metzker', '761.433.847-20', 'MG22325902', 'Feminino', '1964-09-18', 'Rua Nossa Senhora da Penha', '15', 'Centro', 'MG', 'TeÃ³filo Otoni', '', '33-98849-4644', '', '', '2019-04-17 14:49:00', '', NULL, NULL, NULL, NULL, NULL, 'Jade Costa'),
(136, 'Maria Edna Ribeiro dos Santos', '982.258.556-04', 'MG7774583', 'Feminino', '1970-11-25', 'Rua SebastiÃ£o Vieira Collen', '193/Ap', '', 'MG', 'TeÃ³filo Otoni', '', '33-98826-2829', '', '', '2019-04-17 14:56:00', '', NULL, NULL, NULL, NULL, NULL, 'Jade Costa'),
(137, 'Marizete Aparecida', '013.403.456-25', 'MG12309619', 'Feminino', '0001-10-15', 'Rua ArmÃªnia Laender ', '48', 'Marajoara', 'MG', 'TeÃ³filo Otoni', '', '33-98886-7803', '', '', '2019-04-17 14:58:00', '', NULL, NULL, NULL, NULL, NULL, 'Jade Costa'),
(138, 'JoÃ£o Paulo Ferreira da Cost', '231.101.068-92', '', 'Masculino', '1972-12-22', 'Rua JosÃ© Carlos', '', 'SÃ£o Diogo', 'MG', 'TeÃ³filo Otoni ', '', '33-35216-379', '33-3521-6379', '', '2019-04-17 16:48:00', '', NULL, NULL, NULL, NULL, NULL, 'Jade Costa'),
(139, 'Ocirema Schirmer Neves', '083.251.483-16', 'MG15284825', 'Feminino', '1988-03-14', 'Rua Americo Taipina', '323', '', 'MG', 'TeÃ³filo Otoni', '', '33-98864-4865', '', '', '2019-04-17 17:02:00', '', NULL, NULL, NULL, NULL, NULL, 'Jade Costa'),
(140, 'PatrÃ­cia Vilela dos Santos', '066.836.716-48', 'MG12537241', 'Feminino', '1983-09-30', 'Avenida GetÃºlio Vargas', '1263/A', 'Centro', 'MG', 'TeÃ³filo Otoni', '', '33-98801-7243', '', '', '2019-04-22 10:29:00', '', NULL, NULL, NULL, NULL, NULL, 'Jade Costa'),
(141, 'PatrÃ­cia Lages Batista', '094.439.376-46', 'MG16618874', 'Feminino', '1989-09-04', 'Rua ArmÃªnia Laender ', '48', 'Marajoara', 'MG', 'TeÃ³filo Otoni', '', '33-98762-4369', '', '', '2019-04-22 10:36:00', '', NULL, NULL, NULL, NULL, NULL, 'Jade Costa'),
(142, 'Roberta Viana Lorentz', '043.801.326-33', 'MG11541219', 'Feminino', '1979-09-29', 'Avenida GetÃºlio Vargas ', '1723/ ', 'Centro', 'MG', 'TeÃ³filo Otoni', '', '33-98862-9010', '', '', '2019-04-22 10:52:00', '', NULL, NULL, NULL, NULL, NULL, 'Jade Costa'),
(143, 'Raquel Drumond Domingues Bianco ', '104.645.526-56', 'MG22036874', 'Feminino', '1990-03-02', 'Rua Aniceto Alves de Souza', '373/Ap', 'Marajoara', 'MG', 'TeÃ³filo Otoni', '', '31-99165-2770', '', '', '2019-04-22 10:58:00', '', NULL, NULL, NULL, NULL, NULL, 'Jade Costa'),
(144, 'Rosane Carvalho Campos', '149.129.376-30', 'MG11129395', 'Feminino', '1980-12-13', 'Rua Valigato', '18', '', 'MG', 'TeÃ³filo Otoni', '', '00-35191-463781', '', '', '2019-04-22 11:06:00', '', NULL, NULL, NULL, NULL, NULL, 'Jade Costa'),
(145, 'Sirani Rodrigues de Oliveira', '975.802.876-68', 'MG8677360', 'Masculino', '1977-05-15', 'Rua C', '46', 'Matinha', 'MG', 'TeÃ³filo Otoni', '', '33-98835-7175', '', '', '2019-04-22 11:14:00', '', NULL, NULL, NULL, NULL, NULL, 'Jade Costa'),
(146, 'Sara Pinheiro Guedes', '125.097.436-43', 'MG17677395', 'Feminino', '1995-03-21', 'Rua Pastor Hollerbach', '11', 'GrÃ£o ParÃ¡', 'MG', 'TeÃ³filo Otoni', '', '33-98842-7000', '', '', '2019-04-22 11:24:00', '', NULL, NULL, NULL, NULL, NULL, 'Jade Costa'),
(147, 'Sandra de Jesus Almeida', '059.361.196-96', 'MG13316904', 'Feminino', '1970-10-21', 'Travessa Sapucaia', '59', '', 'MG', 'TeÃ³filo Otoni', '', '33-98898-3285', '', '', '2019-04-22 11:28:00', '', NULL, NULL, NULL, NULL, NULL, 'Jade Costa'),
(148, 'Suely Tavares Ferreira', '072.592.696-18', 'MG508253937', 'Feminino', '1980-04-10', 'Rua Enfermeira Dona Nana', '83', '', 'MG', 'TeÃ³filo Otoni', '', '33-99989-5466', '', '', '2019-04-22 11:32:00', '', NULL, NULL, NULL, NULL, NULL, 'Jade Costa'),
(149, 'Tereza Luiza Barbosa Coelho', '047.873.196-55', 'MG10994996', 'Feminino', '1989-05-21', 'Rua JK', '440', '', 'MG', 'Padre ParaÃ­so ', '', '33-98402-6958', '', '', '2019-04-22 13:38:00', '', NULL, NULL, NULL, NULL, NULL, 'Jade Costa'),
(150, 'Thauane Almeida', '119.970.206-45', 'MG18358231', 'Feminino', '1993-08-21', 'Rua InÃ¡cio Zacarias', '31', 'Esplanada ', 'MG', 'Ladainha ', '', '33-98859-1908', '', '', '2019-04-22 13:56:00', '', NULL, NULL, NULL, NULL, NULL, 'Jade Costa'),
(151, 'Teonilia Darlete Ramalho Mota', '053.453.386-80', 'MG323291405', 'Feminino', '1975-03-13', 'Rua Bento Caldeira Brante', '95/ Ap', 'Castro Pires', 'MG', 'TeÃ³filo Otoni', '', '33-98859-6095', '', '', '2019-04-22 14:00:00', '', NULL, NULL, NULL, NULL, NULL, 'Jade Costa'),
(152, 'Tatiana Alves de Souza Reis Bonelli', '047.792.356-36', 'MG11399199', 'Feminino', '1980-05-16', 'Rua Renno Hollerbach', '50 A', 'Castro Pires', 'MG', 'TeÃ³filo Otoni', '', '33-98832-0736', '', '', '2019-04-22 14:04:00', '', NULL, NULL, NULL, NULL, NULL, 'Jade Costa'),
(153, 'Talvane Duarte de Souza', '069.223.386-50', 'MG13094868', 'Masculino', '1985-02-13', 'Rua Governador Valares ', '489', 'Varzea', 'MG', 'Itambacuri ', '', '33-99955-8035', '', '', '2019-04-22 14:11:00', '', NULL, NULL, NULL, NULL, NULL, 'Jade Costa'),
(154, 'Vanusa Guedes Otoni', '627.344.236-34', 'MG3748355', 'Feminino', '1965-08-23', 'Avenida GetÃºlio Vargas', '1755/ ', 'Centro', 'MG', 'TeÃ³filo Otoni', '', '33-99983-1647', '', '', '2019-04-22 14:28:00', '', NULL, NULL, NULL, NULL, NULL, 'Jade Costa'),
(155, 'VittÃ³ria Oliveira Sena Pontes', '091.607.676-85', 'MG13422927', 'Feminino', '1998-03-16', 'Rua AntÃ´nio Otoni de Castro', '', '', 'MG', 'TeÃ³filo Otoni', '', '33-99100-0189', '', '', '2019-04-22 14:33:00', '', NULL, NULL, NULL, NULL, NULL, 'Jade Costa'),
(156, 'Vanessa Macedo Nascimento', '085.367.026-99', 'MG14276124', 'Feminino', '1983-09-07', 'Avenida Julio Campos ', '533', 'Centro', 'MG', 'Novo Cruzeiro', '', '33-98719-2376', '', '', '2019-04-22 14:37:00', '', NULL, NULL, NULL, NULL, NULL, 'Jade Costa'),
(157, 'Wanessa Schutte Ribeiro ', '012.031.436-30', 'MG17298102', 'Feminino', '1990-02-12', 'Rua Julio Laender', '197', 'Ipiranga', 'MG', 'TeÃ³filo Otoni', '', '33-99945-3493', '', '', '2019-04-22 14:49:00', '', NULL, NULL, NULL, NULL, NULL, 'Jade Costa'),
(158, 'Wilza Carla Doehler Ferreira', '405.147.656-15', 'MG1651505', 'Feminino', '2019-01-01', 'Rua Arthur RachinAtchina', '100', 'Marajoara', 'MG', 'TeÃ³filo Otoni', '', '33-98836-7904', '', '', '2019-04-22 14:54:00', '', NULL, NULL, NULL, NULL, NULL, 'Jade Costa'),
(159, 'Wilane Couto MendonÃ§a', '119.856.066-58', 'MG17259544', 'Feminino', '1994-04-18', 'Rua Matilde Borges da Rocha ', '135', 'SÃ£o CristovÃ£o ', 'MG', 'TeÃ³filo Otoni', '', '33-98809-1407', '', '', '2019-04-22 15:08:00', '', NULL, NULL, NULL, NULL, NULL, 'Jade Costa'),
(160, 'Zilva Torres Barroso', '671.486.546-53', 'MG5755992', 'Feminino', '1965-09-25', 'Rua Jurema ', '80', 'Centro', 'MG', 'TeÃ³filo Otoni', '', '33-98876-6815', '', '', '2019-04-22 15:24:00', '', NULL, NULL, NULL, NULL, NULL, 'Jade Costa'),
(161, 'Marcela Souza Tanzarela Ferreira', '---.---.------', 'MG12502016', 'Feminino', '1984-03-16', '-------', '', '', 'MG', 'TeÃ³filo Otoni', '', '33-99807-2024', '', '', '2019-04-22 16:10:00', '', NULL, NULL, NULL, NULL, NULL, 'Jade Costa'),
(162, 'Ana Paula Barreto de Souza', '733.701.851-72', '', 'Feminino', '1975-09-26', 'EUA', '---', '-------', 'MG', 'Governador Valadares ', '', '----------', '', '', '2019-04-24 10:26:00', '', NULL, NULL, NULL, NULL, NULL, 'Jade Costa'),
(163, 'NÃ¡dia Costa Ribeiro ', '032.791.366-52', 'MG6914993', 'Feminino', '1976-07-23', 'Rua Presidente Bernardes ', '288/Ap', 'Centro', 'Mg', 'Padre ParaÃ­so ', '39818001', '33-98402-1355', '', '', '2019-04-25 10:30:00', '', NULL, NULL, NULL, NULL, NULL, 'Jade Costa'),
(164, 'Cleide Braga Cordeiro dos Santos', '654.509.816-00', 'MG3693382', 'Feminino', '1968-01-19', 'Rua Sagrada FamÃ­lia ', '350', 'Ipiranga', 'MG', 'TeÃ³filo Otoni', '', '33-98809-0252', '', '', '2019-04-25 17:45:00', '', NULL, NULL, NULL, NULL, NULL, 'Jade Costa'),
(165, 'Stefanie de Souza Coelho', '088.274.166-76', 'MG15727944', 'Feminino', '1988-09-09', 'Rua Doutor Alaor Lins ', '156', 'GrÃ£o ParÃ¡', 'MG', 'TeÃ³filo Otoni', '', '33-99121-4603', '', '', '2019-04-25 18:40:00', '', NULL, NULL, NULL, NULL, NULL, 'Jade Costa'),
(166, 'Rosilene Souza Murta', '734.829.356-53', 'MG16627556', 'Feminino', '1962-04-05', '-------------------------------', '------', '', 'MG', 'Ladainha', '', '33-98857-2650', '', '', '2019-04-26 10:22:00', '', NULL, NULL, NULL, NULL, NULL, 'Jade Costa'),
(167, 'Selma GonÃ§alves Dutra', '615.391.206-00', 'MG2371061', 'Feminino', '1961-09-19', 'Rua Prefeito Orlando Tavares', '108', 'Centro', 'MG', 'Padre ParaÃ­so ', '', '33-98420-1770', '', '', '2019-04-26 17:18:00', '', NULL, NULL, NULL, NULL, NULL, 'Jade Costa'),
(168, 'Julyana Soares Ferreira', '055.777.746-16', 'MG12029588', 'Feminino', '1982-07-09', 'Rua GetÃºlio Vargas', '74', 'Centro', 'MG', 'FranciscÃ³polis ', '', '33-98800-6442', '', '', '2019-04-29 14:56:00', '', NULL, NULL, NULL, NULL, NULL, 'Jade Costa'),
(169, 'Fabiana EspÃ­nola da Pieve', '013.321.516-47', 'MG9088511', 'Feminino', '1975-11-18', 'Rua SÃ£o Paulo', '282/Ap', 'Centro', 'MG', 'Itambacuri', '', '33-99975-6643', '', '', '2019-04-30 14:51:00', '', NULL, NULL, NULL, NULL, NULL, 'Jade Costa'),
(170, 'Ingrid Alexandra Ribeiro Leite Gratek', '119.763.056-24', 'MG18332649', 'Feminino', '1993-06-24', 'Rua EsmÃ©ria Florisbela ', '41', 'SÃ£o Francisco', 'MG', 'TeÃ³filo Otoni', '', '33-99136-8429', '', '', '2019-05-02 16:46:00', '', NULL, NULL, NULL, NULL, NULL, 'Jade Costa'),
(171, 'Rodrigo Leoncio Zaniboni Pita', '008.544.935-06', 'BA0753864703', 'Masculino', '1984-06-05', 'Avenida BH', '233', 'Centro', 'MG', 'Ãguas Formosas', '', '33-98876-2690', '', '', '2019-05-03 09:47:00', '', NULL, NULL, NULL, NULL, NULL, 'Jade Costa'),
(172, 'teste', '307.335.850-19', 'mg18364736', 'Masculino', '2019-05-02', 'PraÃ§a Tiradentes', '234', 'Centro', 'MG', 'TeÃ³filo Otoni', '39800001', '33987146337', '33-9885-6965', '', '2019-05-03 14:03:00', '', NULL, NULL, NULL, NULL, NULL, 'Admin'),
(173, 'Maria Regilane Bezerra Medeiros', '079.877.086-40', 'MG14899587', 'Feminino', '1985-08-19', 'Rua Dr Marcilio Rosa', '241', 'Jardim Iracema', 'MG', 'TeÃ³filo Otoni', '', '33-98701-6325', '', '', '2019-05-03 16:15:00', '', NULL, NULL, NULL, NULL, NULL, 'Jade Costa'),
(174, 'RosÃ¢ngela Maria de Souza', '911.711.216-87', 'MG5756722', 'Feminino', '1969-09-09', 'Avenida Floriano Peixoto', '--', '-----', 'MG', 'TeÃ³filo Otoni', '', '33-98813-7875', '', '', '2019-05-06 15:45:00', '', NULL, NULL, NULL, NULL, NULL, 'Jade Costa'),
(175, 'Fabiane Vieira Sousa Rodrigues', '072.409.816-06', 'MG14096983', 'Feminino', '1983-12-06', 'Rua C', '46', 'Matinha', 'MG', 'TeÃ³filo Otoni', '', '33-99951-0568', '', '', '2019-05-09 11:12:00', '', NULL, NULL, NULL, NULL, NULL, 'Jade Costa'),
(176, 'Beatriz Zegarre Ortiz', '011.988.636-76', 'MG 110494088', 'Feminino', '1956-04-11', 'Epaminondas Otoni', '935', 'Centro', 'MG', 'TeÃ³filo Otoni', '', '33-98885-8683', '', '', '2019-05-13 10:13:00', '', NULL, NULL, NULL, NULL, NULL, 'Jade Costa'),
(177, 'Ayane Domingues ', '100.121.266-59', 'MG15548326', 'Feminino', '1986-12-31', 'Travessa Felipe Ramos', '15', 'Centro', 'MG', 'TeÃ³filo Otoni', '', '33-98760-3242', '', '', '2019-05-14 16:47:00', '', NULL, NULL, NULL, NULL, NULL, 'Jade Costa'),
(178, 'Viviane Barbosa do Nascimento Lameiras', '015.447.666-153', 'M 5189360', 'Feminino', '1971-01-30', 'Rua Coronel Ramos', '210', 'Centro', 'MG', 'TeÃ³filo Otoni', '', '33- 9 88869604', '', '', '2019-05-17 14:57:00', '', NULL, NULL, NULL, NULL, NULL, 'Jade Costa'),
(179, 'Jussara Maria Vieira TameirÃ£o', '501.530.996-15', 'M3167463', 'Feminino', '1962-12-24', 'Rua JosÃ© Luiz Tanure', '215', 'Ipiranga', 'MG', 'TeÃ³filo Otoni', '', '33-98826-2581', '33-9883-62581', '', '2019-05-20 14:04:00', '', NULL, NULL, NULL, NULL, NULL, 'Jade Costa'),
(180, 'Cleisiana Pedroso Silva', '087.593.806-08', 'MG15759441', 'Feminino', '1991-03-17', 'Rua Santa Catarina', '452', '', 'MG', 'Padre Paraiso', '', '33-98439-8000', '', '', '2019-06-06 16:46:00', '', NULL, NULL, NULL, NULL, NULL, 'Jade Costa');

-- --------------------------------------------------------

--
-- Estrutura da tabela `cliente_imagens`
--

CREATE TABLE `cliente_imagens` (
  `idimagem` int(11) NOT NULL,
  `nomeimg` varchar(25) DEFAULT NULL,
  `idcliente` int(11) DEFAULT NULL,
  `foto` varchar(45) DEFAULT NULL,
  `data_upload` datetime DEFAULT NULL,
  `idprocedimento` varchar(6) NOT NULL,
  `idtratamento` int(11) DEFAULT NULL,
  `iddentista` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `cliente_imagens`
--

INSERT INTO `cliente_imagens` (`idimagem`, `nomeimg`, `idcliente`, `foto`, `data_upload`, `idprocedimento`, `idtratamento`, `iddentista`) VALUES
(46, 'Preenchimento Labial', 99, '88cc5df38b6d5fba0b238057747e0175.jpg', '2019-04-22 13:15:22', '', 203, 5),
(47, 'Preenchimento Labial (Ant', 99, '22b30635824896d21f699207da628722.jpg', '2019-04-22 13:15:56', '', 203, 5),
(49, 'RinomodelaÃ§Ã£o (Antes)', 99, '6e94b9e42c6b2e4a3932f65f0cc260a3.jpg', '2019-04-22 13:17:20', '', 203, 5),
(50, 'RinomodelaÃ§Ã£o', 99, 'f58ee8f33d3c651cc0b979d4375eae88.jpg', '2019-04-22 13:17:50', '', 203, 5),
(51, 'Preenchimento Labial', 99, 'b5a6baa3850e3405660f8b3fa1e301bb.jpg', '2019-04-22 13:18:31', '', 203, 5),
(52, 'Preenchimento Labial (Ant', 99, '650fa33e3cfcb724d4433ee08b314c95.jpg', '2019-04-22 13:18:55', '', 203, 5);

-- --------------------------------------------------------

--
-- Estrutura da tabela `contas_pagar`
--

CREATE TABLE `contas_pagar` (
  `idcpagar` int(11) NOT NULL,
  `valor` decimal(10,2) NOT NULL,
  `vencimento` date DEFAULT NULL,
  `parcela` tinyint(4) NOT NULL,
  `idsituacao` tinyint(3) NOT NULL,
  `idmovipagar` int(11) NOT NULL,
  `data_pg` datetime DEFAULT NULL,
  `quem_pagou` varchar(40) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `contas_pagar`
--

INSERT INTO `contas_pagar` (`idcpagar`, `valor`, `vencimento`, `parcela`, `idsituacao`, `idmovipagar`, `data_pg`, `quem_pagou`) VALUES
(85, 222.00, '2019-04-23', 1, 2, 36, '2019-04-22 20:12:24', 'Jade Costa'),
(86, 210.00, '2019-04-29', 1, 2, 37, '2019-04-30 17:51:04', 'Jade Costa'),
(87, 6.88, '2019-04-26', 1, 3, 38, NULL, NULL),
(88, 6881.00, '2019-04-26', 1, 2, 39, '2019-04-29 12:48:31', 'Jade Costa'),
(89, 1078.00, '2019-04-27', 1, 3, 40, NULL, NULL),
(90, 3450.00, '2019-05-10', 1, 2, 41, '2019-05-10 13:57:25', 'Jade Costa'),
(91, 1100.00, '2019-04-28', 1, 2, 42, '2019-04-30 17:50:12', 'Jade Costa'),
(92, 11.00, '2019-04-20', 1, 3, 43, NULL, NULL),
(93, 11.00, '2019-05-20', 2, 3, 43, NULL, NULL),
(94, 11.00, '2019-06-20', 3, 3, 43, NULL, NULL),
(95, 11.00, '2019-07-20', 4, 3, 43, NULL, NULL),
(96, 11.00, '2019-08-20', 5, 3, 43, NULL, NULL),
(97, 11.00, '2019-09-20', 6, 3, 43, NULL, NULL),
(98, 11.00, '2019-10-20', 7, 3, 43, NULL, NULL),
(99, 11.00, '2019-11-20', 8, 3, 43, NULL, NULL),
(100, 11.00, '2019-12-20', 9, 3, 43, NULL, NULL),
(101, 99.00, '2019-04-20', 1, 2, 44, '2019-04-22 20:12:50', 'Jade Costa'),
(102, 99.00, '2019-05-20', 1, 2, 45, '2019-05-21 13:52:29', 'Jade Costa'),
(103, 2000.00, '2019-04-23', 1, 2, 46, '2019-04-29 13:56:34', 'Jade Costa'),
(104, 1200.00, '2019-05-23', 1, 2, 47, '2019-06-10 14:56:22', 'Jade Costa'),
(105, 1200.00, '2019-06-23', 1, 1, 48, NULL, NULL),
(106, 1200.00, '2019-07-23', 1, 1, 49, NULL, NULL),
(107, 1200.00, '2019-08-23', 1, 1, 50, NULL, NULL),
(108, 1200.00, '2019-09-23', 1, 1, 51, NULL, NULL),
(109, 1200.00, '2019-10-23', 1, 1, 52, NULL, NULL),
(110, 1200.00, '2019-11-23', 1, 1, 53, NULL, NULL),
(111, 1200.00, '2019-12-23', 1, 1, 54, NULL, NULL),
(112, 99.90, '2019-06-20', 1, 1, 55, NULL, NULL),
(113, 99.90, '2019-07-24', 1, 1, 56, NULL, NULL),
(114, 99.90, '2019-08-20', 1, 1, 57, NULL, NULL),
(115, 99.90, '2019-09-20', 1, 1, 58, NULL, NULL),
(116, 99.90, '2019-10-20', 1, 1, 59, NULL, NULL),
(117, 99.90, '2019-11-20', 1, 1, 60, NULL, NULL),
(118, 99.90, '2019-12-20', 1, 1, 61, NULL, NULL),
(119, 2083.37, '2019-04-25', 1, 2, 62, '2019-04-24 19:37:26', 'Jade Costa'),
(120, 2083.37, '2019-05-25', 1, 2, 63, '2019-06-05 18:01:45', 'Jade Costa'),
(121, 133.16, '2019-04-25', 1, 2, 64, '2019-04-30 17:50:00', 'Jade Costa'),
(122, 597.80, '2019-05-04', 1, 2, 65, '2019-05-07 17:44:13', 'Jade Costa'),
(123, 49.90, '2019-05-07', 1, 2, 66, '2019-05-07 17:44:24', 'Jade Costa'),
(124, 49.90, '2019-05-07', 1, 2, 67, '2019-05-10 20:48:31', 'Jade Costa'),
(125, 81.00, '2019-05-20', 1, 2, 68, '2019-05-22 17:11:06', 'Jade Costa'),
(126, 962.00, '2019-04-27', 1, 2, 69, '2019-04-30 17:50:23', 'Jade Costa'),
(127, 250.00, '2019-05-09', 1, 3, 70, NULL, NULL),
(128, 1182.26, '2019-05-28', 1, 2, 71, '2019-06-05 17:31:06', 'Jade Costa'),
(129, 1028.30, '2019-05-27', 1, 2, 72, '2019-06-05 17:30:57', 'Jade Costa'),
(130, 255.32, '2019-05-10', 1, 2, 73, '2019-05-10 13:57:48', 'Jade Costa'),
(131, 818.50, '2019-05-17', 1, 2, 74, '2019-05-20 16:44:46', 'Jade Costa'),
(132, 818.50, '2019-06-17', 2, 1, 74, NULL, NULL),
(133, 260.00, '2019-05-02', 1, 2, 75, '2019-05-03 13:17:17', 'Jade Costa'),
(134, 133.81, '2019-05-02', 1, 2, 76, '2019-05-03 13:17:25', 'Jade Costa'),
(136, 42.07, '2019-05-08', 1, 2, 78, '2019-05-10 13:59:16', 'Jade Costa'),
(137, 332.08, '2019-05-09', 1, 2, 79, '2019-05-10 13:59:06', 'Jade Costa'),
(138, 49.99, '2019-05-10', 1, 2, 80, '2019-05-10 21:22:42', 'Jade Costa'),
(139, 150.00, '2019-05-15', 1, 2, 81, '2019-05-22 17:10:53', 'Jade Costa'),
(140, 133.00, '2019-05-25', 1, 2, 82, '2019-06-05 17:30:47', 'Jade Costa'),
(141, 456.66, '2019-05-17', 1, 2, 83, '2019-05-20 16:58:15', 'Jade Costa'),
(142, 6881.99, '2019-05-21', 1, 2, 84, '2019-05-21 13:54:54', 'Jade Costa'),
(143, 49.99, '2019-07-07', 1, 1, 85, NULL, NULL),
(144, 130.00, '2019-07-01', 1, 1, 86, NULL, NULL),
(145, 141.59, '2019-07-08', 1, 1, 87, NULL, NULL),
(146, 39.88, '2019-07-09', 1, 1, 88, NULL, NULL),
(147, 416.67, '2019-07-17', 1, 1, 89, NULL, NULL),
(148, 9990.00, '1969-12-31', 1, 3, 90, NULL, NULL),
(149, 16.65, '2017-07-20', 1, 3, 91, NULL, NULL),
(150, 16.65, '2017-08-20', 2, 3, 91, NULL, NULL),
(151, 16.65, '2017-09-20', 3, 3, 91, NULL, NULL),
(152, 16.65, '2017-10-20', 4, 3, 91, NULL, NULL),
(153, 16.65, '2017-11-20', 5, 3, 91, NULL, NULL),
(154, 16.65, '2017-12-20', 6, 3, 91, NULL, NULL),
(155, 228.75, '2019-07-25', 1, 1, 92, NULL, NULL),
(156, 228.75, '2019-08-25', 2, 1, 92, NULL, NULL),
(157, 228.75, '2019-09-25', 3, 1, 92, NULL, NULL),
(158, 228.75, '2019-10-25', 4, 1, 92, NULL, NULL),
(159, 364.41, '2019-07-10', 1, 1, 93, NULL, NULL),
(160, 100.58, '2019-07-23', 1, 1, 94, NULL, NULL),
(161, 1028.30, '2019-07-27', 1, 1, 95, NULL, NULL),
(162, 1182.26, '2019-07-28', 1, 1, 96, NULL, NULL),
(163, 1042.33, '2019-07-24', 1, 1, 97, NULL, NULL),
(164, 1042.33, '2019-08-24', 2, 1, 97, NULL, NULL),
(165, 1042.33, '2019-09-24', 3, 1, 97, NULL, NULL),
(166, 230.00, '2019-07-29', 1, 1, 98, NULL, NULL),
(167, 1333.33, '2019-08-16', 1, 1, 99, NULL, NULL),
(168, 1333.33, '2019-09-16', 2, 1, 99, NULL, NULL),
(169, 1333.33, '2019-10-16', 3, 1, 99, NULL, NULL),
(170, 718.75, '2019-09-04', 1, 1, 100, NULL, NULL),
(171, 718.75, '2019-10-04', 2, 1, 100, NULL, NULL),
(172, 718.75, '2019-11-04', 3, 1, 100, NULL, NULL),
(173, 718.75, '2019-12-04', 4, 1, 100, NULL, NULL),
(174, 105.19, '2019-08-23', 1, 1, 101, NULL, NULL),
(175, 1182.26, '2019-08-28', 1, 1, 102, NULL, NULL),
(176, 1024.92, '2019-08-27', 1, 1, 103, NULL, NULL),
(177, 261.60, '2019-09-08', 1, 1, 104, NULL, NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `contas_pagar_movi`
--

CREATE TABLE `contas_pagar_movi` (
  `idmovipagar` int(11) NOT NULL,
  `data_movimento` datetime DEFAULT NULL,
  `tipopg` varchar(40) DEFAULT NULL,
  `qtdparcelas` tinyint(3) NOT NULL,
  `valor` decimal(10,2) NOT NULL,
  `idformapg` tinyint(3) NOT NULL,
  `resp_cadastro` varchar(30) NOT NULL,
  `num_doc` varchar(11) DEFAULT NULL,
  `cancelado` int(2) NOT NULL,
  `data_cancelamento` datetime DEFAULT NULL,
  `cancelado_por` varchar(30) DEFAULT NULL,
  `mcancelamento` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `contas_pagar_movi`
--

INSERT INTO `contas_pagar_movi` (`idmovipagar`, `data_movimento`, `tipopg`, `qtdparcelas`, `valor`, `idformapg`, `resp_cadastro`, `num_doc`, `cancelado`, `data_cancelamento`, `cancelado_por`, `mcancelamento`) VALUES
(36, '2019-04-18 00:00:00', '3', 1, 222.00, 1, 'Jade Costa', '', 0, NULL, NULL, NULL),
(37, '2019-04-18 00:00:00', '8', 1, 210.00, 1, 'Jade Costa', '', 0, NULL, NULL, NULL),
(38, '2019-04-18 00:00:00', '9', 1, 6.88, 1, 'Jade Costa', '', 1, '2019-04-18 19:59:00', 'Admin', 'Erro de cadastro'),
(39, '2019-04-18 00:00:00', '9', 1, 6881.00, 1, 'Jade Costa', '', 0, NULL, NULL, NULL),
(40, '2019-04-18 00:00:00', '5', 1, 1078.00, 1, 'Jade Costa', '', 1, '2019-04-24 18:20:00', 'Jade Costa', 'Errado'),
(41, '2019-04-18 00:00:00', '10', 1, 3450.00, 1, 'Jade Costa', '', 0, NULL, NULL, NULL),
(42, '2019-04-18 00:00:00', '5', 1, 1100.00, 1, 'Jade Costa', '', 0, NULL, NULL, NULL),
(43, '2019-04-22 15:22:00', '11', 9, 99.00, 1, 'Jade Costa', '', 1, '2019-04-22 18:23:00', 'Jade Costa', 'Errado'),
(44, '2019-04-22 15:23:00', '11', 1, 99.00, 1, 'Jade Costa', '', 0, NULL, NULL, NULL),
(45, '2019-04-22 15:24:00', '11', 1, 99.00, 1, 'Jade Costa', '', 0, NULL, NULL, NULL),
(46, '2019-04-23 14:04:00', '12', 1, 2000.00, 1, 'Jade Costa', '', 0, NULL, NULL, NULL),
(47, '2019-04-24 15:49:00', '13', 1, 1200.00, 6, 'Jade Costa', '', 0, NULL, NULL, NULL),
(48, '2019-04-24 15:50:00', '12', 1, 1200.00, 6, 'Jade Costa', '', 0, NULL, NULL, NULL),
(49, '2019-04-24 15:51:00', '12', 1, 1200.00, 6, 'Jade Costa', '', 0, NULL, NULL, NULL),
(50, '2019-04-24 15:51:00', '12', 1, 1200.00, 6, 'Jade Costa', '', 0, NULL, NULL, NULL),
(51, '2019-04-24 15:54:00', '12', 1, 1200.00, 6, 'Jade Costa', '', 0, NULL, NULL, NULL),
(52, '2019-04-24 15:55:00', '12', 1, 1200.00, 6, 'Jade Costa', '', 0, NULL, NULL, NULL),
(53, '2019-04-24 15:55:00', '12', 1, 1200.00, 6, 'Jade Costa', '', 0, NULL, NULL, NULL),
(54, '2019-04-24 15:56:00', '12', 1, 1200.00, 6, 'Jade Costa', '', 0, NULL, NULL, NULL),
(55, '2019-04-24 15:59:00', '11', 1, 99.90, 1, 'Jade Costa', '', 0, NULL, NULL, NULL),
(56, '2019-04-24 16:01:00', '11', 1, 99.90, 1, 'Jade Costa', '', 0, NULL, NULL, NULL),
(57, '2019-04-24 16:04:00', '11', 1, 99.90, 1, 'Jade Costa', '', 0, NULL, NULL, NULL),
(58, '2019-04-24 16:05:00', '11', 1, 99.90, 1, 'Jade Costa', '', 0, NULL, NULL, NULL),
(59, '2019-04-24 16:05:00', '11', 1, 99.90, 1, 'Jade Costa', '', 0, NULL, NULL, NULL),
(60, '2019-04-24 16:05:00', '11', 1, 99.90, 1, 'Jade Costa', '', 0, NULL, NULL, NULL),
(61, '2019-04-24 16:06:00', '11', 1, 99.90, 1, 'Jade Costa', '', 0, NULL, NULL, NULL),
(62, '2019-04-24 16:08:00', '15', 1, 2083.37, 6, 'Jade Costa', '', 0, NULL, NULL, NULL),
(63, '2019-04-24 16:08:00', '15', 1, 2083.37, 6, 'Jade Costa', '', 0, NULL, NULL, NULL),
(64, '2019-04-24 16:15:00', '16', 1, 133.16, 1, 'Jade Costa', '', 0, NULL, NULL, NULL),
(65, '2019-04-24 16:18:00', '17', 1, 597.80, 1, 'Jade Costa', '', 0, NULL, NULL, NULL),
(66, '2019-04-24 16:19:00', '18', 1, 49.90, 1, 'Jade Costa', '', 0, NULL, NULL, NULL),
(67, '2019-04-24 16:20:00', '19', 1, 49.90, 1, 'Jade Costa', '', 0, NULL, NULL, NULL),
(68, '2019-04-24 16:21:00', '20', 1, 81.00, 1, 'Jade Costa', '', 0, NULL, NULL, NULL),
(69, '2019-04-24 16:36:00', '22', 1, 962.00, 1, 'Jade Costa', '', 0, NULL, NULL, NULL),
(70, '2019-04-24 17:04:00', '4', 1, 250.00, 1, 'Jade Costa', '', 1, '2019-04-29 13:59:00', 'Jade Costa', 'Errado'),
(71, '2019-04-26 16:38:00', '5', 1, 1182.26, 1, 'Jade Costa', '', 0, NULL, NULL, NULL),
(72, '2019-04-26 16:40:00', '22', 1, 1028.30, 1, 'Jade Costa', '', 0, NULL, NULL, NULL),
(73, '2019-04-29 10:55:00', '4', 1, 255.32, 1, 'Jade Costa', '', 0, NULL, NULL, NULL),
(74, '2019-04-29 17:22:00', '23', 2, 1637.00, 1, 'Jade Costa', '', 0, NULL, NULL, NULL),
(75, '2019-05-03 10:16:00', '8', 1, 260.00, 1, 'Jade Costa', '', 0, NULL, NULL, NULL),
(76, '2019-05-03 10:17:00', '24', 1, 133.81, 1, 'Jade Costa', '', 0, NULL, NULL, NULL),
(78, '2019-05-10 10:58:00', '2', 1, 42.07, 1, 'Jade Costa', '', 0, NULL, NULL, NULL),
(79, '2019-05-10 10:58:00', '3', 1, 332.08, 1, 'Jade Costa', '', 0, NULL, NULL, NULL),
(80, '2019-05-10 18:22:00', '24', 1, 49.99, 1, 'Jade Costa', '', 0, NULL, NULL, NULL),
(81, '2019-05-20 13:56:00', '26', 1, 150.00, 1, 'Jade Costa', '', 0, NULL, NULL, NULL),
(82, '2019-05-20 13:56:00', '16', 1, 133.00, 1, 'Jade Costa', '', 0, NULL, NULL, NULL),
(83, '2019-05-20 13:58:00', '27', 1, 456.66, 1, 'Jade Costa', '', 0, NULL, NULL, NULL),
(84, '2019-05-21 10:54:00', '9', 1, 6881.99, 1, 'Jade Costa', '', 0, NULL, NULL, NULL),
(85, '2019-07-02 14:21:00', '16', 1, 49.99, 1, 'Dionisio', '', 0, NULL, NULL, NULL),
(86, '2019-07-02 14:24:00', '8', 1, 130.00, 1, 'Dionisio', '', 0, NULL, NULL, NULL),
(87, '2019-07-02 14:26:00', '3', 1, 141.59, 1, 'Dionisio', '', 0, NULL, NULL, NULL),
(88, '2019-07-02 14:27:00', '2', 1, 39.88, 1, 'Dionisio', '', 0, NULL, NULL, NULL),
(89, '2019-07-02 14:30:00', '9', 1, 416.67, 1, 'Dionisio', '', 0, NULL, NULL, NULL),
(90, '2019-07-02 14:44:00', '29', 1, 9990.00, 1, 'Dionisio', '', 1, '2019-07-02 17:53:00', 'Dionisio', 'errei'),
(91, '2019-07-02 14:55:00', '29', 6, 99.90, 1, 'Dionisio', '', 1, '2019-07-02 18:00:00', 'Dionisio', 'erro'),
(92, '2019-07-03 14:19:00', '17', 4, 915.00, 6, 'Dionisio', '', 0, NULL, NULL, NULL),
(93, '2019-07-03 15:48:00', '30', 1, 364.41, 6, 'Dionisio', '', 0, NULL, NULL, NULL),
(94, '2019-07-08 18:45:00', '3', 1, 100.58, 6, 'Dionisio', '', 0, NULL, NULL, NULL),
(95, '2019-07-18 14:36:00', '5', 1, 1028.30, 6, 'Dionisio', '', 0, NULL, NULL, NULL),
(96, '2019-07-19 13:37:00', '5', 1, 1182.26, 6, 'Dionisio', '', 0, NULL, NULL, NULL),
(97, '2019-07-19 13:41:00', '10', 3, 3127.00, 6, 'Dionisio', '', 0, NULL, NULL, NULL),
(98, '2019-07-22 20:28:00', '8', 1, 230.00, 6, 'Dionisio', '', 0, NULL, NULL, NULL),
(99, '2019-07-24 18:24:00', '32', 3, 4000.00, 6, 'Dionisio', '', 0, NULL, NULL, NULL),
(100, '2019-08-08 16:48:00', '10', 4, 2875.00, 6, 'Dionisio', '', 0, NULL, NULL, NULL),
(101, '2019-08-08 16:50:00', '3', 1, 105.19, 6, 'Dionisio', '', 0, NULL, NULL, NULL),
(102, '2019-08-14 15:23:00', '5', 1, 1182.26, 6, 'Dionisio', '', 0, NULL, NULL, NULL),
(103, '2019-08-14 15:24:00', '5', 1, 1024.92, 6, 'Dionisio', '', 0, NULL, NULL, NULL),
(104, '2019-08-19 09:59:00', '28', 1, 261.60, 6, 'Dionisio', '', 0, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `contas_receber`
--

CREATE TABLE `contas_receber` (
  `idparcelas` smallint(6) NOT NULL,
  `valor` decimal(10,2) NOT NULL,
  `vencimento` date NOT NULL,
  `parcela` tinyint(4) NOT NULL,
  `mensagem` varchar(38) NOT NULL,
  `idcliente` int(11) NOT NULL,
  `idsituacao` tinyint(3) NOT NULL,
  `idmovimento` int(11) NOT NULL,
  `data_pg` datetime DEFAULT NULL,
  `quem_recebeu` varchar(40) NOT NULL,
  `num_doc` varchar(15) DEFAULT NULL,
  `emitente` varchar(20) DEFAULT NULL,
  `agencia` varchar(10) DEFAULT NULL,
  `banco` varchar(15) DEFAULT NULL,
  `contadeposito` varchar(11) DEFAULT NULL,
  `depositante` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `contas_receber`
--

INSERT INTO `contas_receber` (`idparcelas`, `valor`, `vencimento`, `parcela`, `mensagem`, `idcliente`, `idsituacao`, `idmovimento`, `data_pg`, `quem_recebeu`, `num_doc`, `emitente`, `agencia`, `banco`, `contadeposito`, `depositante`) VALUES
(35, 5700.00, '2019-04-16', 1, '', 99, 2, 93, '2019-04-18 13:13:02', 'Michella', '', '', '', '', '', ''),
(38, 1750.00, '2019-04-17', 1, '', 138, 2, 96, '2019-04-18 16:31:58', 'Jade Costa', '', '', '', '', '', ''),
(39, 250.00, '2019-04-21', 1, '', 149, 2, 97, '2019-04-24 17:37:48', 'Jade Costa', '', '', '', '', '', ''),
(40, 250.00, '2019-05-21', 2, '', 149, 2, 97, '2019-05-21 13:52:15', 'Jade Costa', '', '', '', '', '', ''),
(41, 250.00, '2019-06-21', 3, '', 149, 1, 97, NULL, '', '', '', '', '', NULL, NULL),
(42, 250.00, '2019-07-21', 4, '', 149, 1, 97, NULL, '', '', '', '', '', NULL, NULL),
(43, 237.50, '2019-05-09', 1, '', 149, 2, 98, '2019-05-09 12:27:15', 'Jade Costa', '', '', '', '', '', ''),
(44, 237.50, '2019-06-09', 2, '', 149, 2, 98, '2019-06-10 14:56:37', 'Jade Costa', '', '', '', '', '', ''),
(45, 237.50, '2019-07-09', 3, '', 149, 1, 98, NULL, '', '', '', '', '', NULL, NULL),
(46, 237.50, '2019-08-09', 4, '', 149, 1, 98, NULL, '', '', '', '', '', NULL, NULL),
(47, 5670.00, '2018-11-07', 1, '', 104, 2, 99, '2019-04-24 20:12:08', 'Jade Costa', '', '', '', '', '', ''),
(48, 1760.00, '2018-11-30', 1, '', 104, 2, 100, '2019-04-24 20:12:02', 'Jade Costa', '', '', '', '', '', ''),
(49, 900.00, '2019-10-01', 1, '', 104, 2, 101, '2019-04-24 20:12:26', 'Jade Costa', '', '', '', '', '', ''),
(50, 2100.00, '2019-03-14', 1, '', 104, 2, 102, '2019-04-23 21:39:24', 'Jade Costa', '', '', '', '', '', ''),
(51, 200.00, '2019-05-23', 1, '', 43, 2, 103, '2019-06-05 17:27:49', 'Jade Costa', '498401904467410', '', '', '', '', ''),
(52, 200.00, '2019-06-23', 2, '', 43, 1, 103, NULL, '', '498401904467410', '', '', '', NULL, NULL),
(53, 200.00, '2019-07-23', 3, '', 43, 1, 103, NULL, '', '498401904467410', '', '', '', NULL, NULL),
(54, 200.00, '2019-08-23', 4, '', 43, 1, 103, NULL, '', '498401904467410', '', '', '', NULL, NULL),
(55, 200.00, '2019-09-23', 5, '', 43, 1, 103, NULL, '', '498401904467410', '', '', '', NULL, NULL),
(56, 6950.00, '2019-04-24', 1, '', 162, 2, 104, '2019-05-07 17:49:12', 'Jade Costa', '', '', '', '', '', ''),
(57, 3700.00, '2019-04-25', 1, '', 163, 2, 105, '2019-04-25 18:43:34', 'Jade Costa', '', '', '', '', '', ''),
(58, 237.50, '2019-05-26', 1, '', 165, 2, 106, '2019-06-05 17:29:39', 'Jade Costa', '', '', '', '', '', ''),
(59, 237.50, '2019-06-26', 2, '', 165, 1, 106, NULL, '', '', '', '', '', NULL, NULL),
(60, 237.50, '2019-07-26', 3, '', 165, 1, 106, NULL, '', '', '', '', '', NULL, NULL),
(61, 237.50, '2019-08-26', 4, '', 165, 1, 106, NULL, '', '', '', '', '', NULL, NULL),
(62, 237.50, '2019-09-26', 5, '', 165, 1, 106, NULL, '', '', '', '', '', NULL, NULL),
(63, 237.50, '2019-10-26', 6, '', 165, 1, 106, NULL, '', '', '', '', '', NULL, NULL),
(64, 237.50, '2019-11-26', 7, '', 165, 1, 106, NULL, '', '', '', '', '', NULL, NULL),
(65, 237.50, '2019-12-26', 8, '', 165, 1, 106, NULL, '', '', '', '', '', NULL, NULL),
(66, 600.00, '2019-05-26', 1, '', 166, 2, 107, '2019-06-05 17:29:29', 'Jade Costa', '', '', '', '', '79457-0', 'Jade Costa'),
(67, 600.00, '2019-06-26', 2, '', 166, 1, 107, NULL, '', '', '', '', '', NULL, NULL),
(68, 316.67, '2019-05-05', 1, '', 167, 2, 108, '2019-05-06 21:29:35', 'Jade Costa', '', '', '', '', '', ''),
(69, 316.67, '2019-06-05', 2, '', 167, 2, 108, '2019-06-05 17:30:32', 'Jade Costa', '', '', '', '', '', ''),
(70, 316.67, '2019-07-05', 3, '', 167, 1, 108, NULL, '', '', '', '', '', NULL, NULL),
(71, 1850.00, '2019-04-29', 1, '', 168, 2, 109, '2019-05-08 20:04:50', 'Jade Costa', '', '', '', '', '79457-0', 'Jade Costa'),
(72, 1800.00, '2019-04-30', 1, '', 169, 2, 110, '2019-05-02 17:13:13', 'Jade Costa', '', '', '', '', '', ''),
(73, 200.00, '2019-06-03', 1, '', 42, 2, 111, '2019-06-05 17:30:20', 'Jade Costa', '', 'Jussara Costa Guimar', '', '', '79457-0', 'Jade Costa'),
(74, 200.00, '2019-07-03', 2, '', 42, 1, 111, NULL, '', '', 'Jussara Costa Guimar', '', '', NULL, NULL),
(75, 200.00, '2019-08-03', 3, '', 42, 1, 111, NULL, '', '', 'Jussara Costa Guimar', '', '', NULL, NULL),
(76, 778.57, '2019-06-02', 1, '', 171, 2, 112, '2019-06-05 17:29:49', 'Jade Costa', '', '', '', '', '', ''),
(77, 778.57, '2019-07-02', 2, '', 171, 1, 112, NULL, '', '', '', '', '', NULL, NULL),
(78, 778.57, '2019-08-02', 3, '', 171, 1, 112, NULL, '', '', '', '', '', NULL, NULL),
(79, 778.57, '2019-09-02', 4, '', 171, 1, 112, NULL, '', '', '', '', '', NULL, NULL),
(80, 778.57, '2019-10-02', 5, '', 171, 1, 112, NULL, '', '', '', '', '', NULL, NULL),
(81, 778.57, '2019-11-02', 6, '', 171, 1, 112, NULL, '', '', '', '', '', NULL, NULL),
(82, 778.57, '2019-12-02', 7, '', 171, 1, 112, NULL, '', '', '', '', '', NULL, NULL),
(83, 142.86, '2019-06-02', 1, '', 170, 2, 113, '2019-06-05 17:29:59', 'Jade Costa', '', '', '', '', '', ''),
(84, 142.86, '2019-07-02', 2, '', 170, 1, 113, NULL, '', '', '', '', '', NULL, NULL),
(85, 142.86, '2019-08-02', 3, '', 170, 1, 113, NULL, '', '', '', '', '', NULL, NULL),
(86, 142.86, '2019-09-02', 4, '', 170, 1, 113, NULL, '', '', '', '', '', NULL, NULL),
(87, 142.86, '2019-10-02', 5, '', 170, 1, 113, NULL, '', '', '', '', '', NULL, NULL),
(88, 142.86, '2019-11-02', 6, '', 170, 1, 113, NULL, '', '', '', '', '', NULL, NULL),
(89, 142.86, '2019-12-02', 7, '', 170, 1, 113, NULL, '', '', '', '', '', NULL, NULL),
(90, 666.67, '2019-06-03', 1, '', 164, 2, 114, '2019-06-05 17:30:07', 'Jade Costa', '', '', '', '', '', ''),
(91, 666.67, '2019-07-03', 2, '', 164, 1, 114, NULL, '', '', '', '', '', NULL, NULL),
(92, 666.67, '2019-08-03', 3, '', 164, 1, 114, NULL, '', '', '', '', '', NULL, NULL),
(98, 490.00, '2019-06-06', 1, '', 174, 2, 119, '2019-06-06 19:45:22', 'Jade Costa', '525320059125622', '', '', '', '', ''),
(99, 490.00, '2019-07-06', 2, '', 174, 1, 119, NULL, '', '525320059125622', '', '', '', NULL, NULL),
(100, 490.00, '2019-08-06', 3, '', 174, 1, 119, NULL, '', '525320059125622', '', '', '', NULL, NULL),
(101, 490.00, '2019-09-06', 4, '', 174, 1, 119, NULL, '', '525320059125622', '', '', '', NULL, NULL),
(102, 490.00, '2019-10-06', 5, '', 174, 1, 119, NULL, '', '525320059125622', '', '', '', NULL, NULL),
(103, 50.00, '2019-05-03', 1, '', 173, 2, 120, '2019-05-08 15:54:28', 'Jade Costa', '', '', '', '', '', ''),
(104, 1750.00, '2019-05-08', 1, '', 173, 2, 121, '2019-05-08 15:54:37', 'Jade Costa', '', '', '', '', '', ''),
(105, 1750.00, '2019-05-10', 1, '', 176, 2, 122, '2019-05-13 13:18:39', 'Jade Costa', '', '', '', '', '', ''),
(106, 250.00, '2019-06-14', 1, '', 177, 1, 123, NULL, '', '', '', '', '', NULL, NULL),
(107, 50.00, '2019-05-20', 1, '', 179, 2, 124, '2019-05-20 18:19:11', 'Jade Costa', '', '', '', '', '', '');

-- --------------------------------------------------------

--
-- Estrutura da tabela `contas_receb_movi`
--

CREATE TABLE `contas_receb_movi` (
  `idmovimento` int(11) NOT NULL,
  `idcliente` int(11) NOT NULL,
  `valor` decimal(10,2) NOT NULL,
  `qtdparcelas` tinyint(3) NOT NULL,
  `idtratamento` int(11) NOT NULL,
  `data_movimento` datetime NOT NULL,
  `idformapg` tinyint(3) NOT NULL,
  `num_doc` varchar(30) DEFAULT NULL,
  `desconto` decimal(10,2) DEFAULT NULL,
  `valor_total` decimal(10,2) NOT NULL,
  `cancelado` int(2) NOT NULL,
  `data_cancelamento` datetime DEFAULT NULL,
  `cancelado_por` varchar(30) DEFAULT NULL,
  `mcancelamento` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `contas_receb_movi`
--

INSERT INTO `contas_receb_movi` (`idmovimento`, `idcliente`, `valor`, `qtdparcelas`, `idtratamento`, `data_movimento`, `idformapg`, `num_doc`, `desconto`, `valor_total`, `cancelado`, `data_cancelamento`, `cancelado_por`, `mcancelamento`) VALUES
(93, 99, 5700.00, 1, 203, '2019-04-18 13:10:27', 1, NULL, 650.00, 0.00, 0, NULL, NULL, NULL),
(96, 138, 1750.00, 1, 207, '2019-04-18 16:30:53', 3, NULL, 100.00, 1850.00, 0, NULL, NULL, NULL),
(97, 149, 1000.00, 4, 209, '2019-04-22 16:52:33', 2, NULL, 0.00, 1000.00, 0, NULL, NULL, NULL),
(98, 149, 950.00, 4, 210, '2019-04-22 16:55:01', 2, NULL, 0.00, 950.00, 0, NULL, NULL, NULL),
(99, 104, 5670.00, 1, 213, '2019-04-22 21:07:29', 4, NULL, 630.00, 6300.00, 0, NULL, NULL, NULL),
(100, 104, 1760.00, 1, 214, '2019-04-23 12:28:12', 1, NULL, 40.00, 1800.00, 0, NULL, NULL, NULL),
(101, 104, 900.00, 1, 215, '2019-04-23 12:31:10', 1, NULL, 0.00, 900.00, 0, NULL, NULL, NULL),
(102, 104, 2100.00, 1, 218, '2019-04-23 12:35:19', 1, NULL, 0.00, 2100.00, 0, NULL, NULL, NULL),
(103, 43, 1000.00, 5, 221, '2019-04-23 19:16:46', 2, NULL, 0.00, 1000.00, 0, NULL, NULL, NULL),
(104, 162, 6950.00, 1, 223, '2019-04-24 13:37:33', 6, NULL, 0.00, 6950.00, 0, NULL, NULL, NULL),
(105, 163, 3700.00, 1, 224, '2019-04-25 18:43:04', 1, NULL, 250.00, 3950.00, 0, NULL, NULL, NULL),
(106, 165, 1900.00, 8, 226, '2019-04-26 13:01:48', 2, NULL, 0.00, 1900.00, 0, NULL, NULL, NULL),
(107, 166, 1200.00, 2, 227, '2019-04-26 13:37:45', 4, NULL, 0.00, 1200.00, 0, NULL, NULL, NULL),
(108, 167, 950.00, 3, 228, '2019-04-29 14:49:39', 2, NULL, 0.00, 950.00, 0, NULL, NULL, NULL),
(109, 168, 1850.00, 1, 230, '2019-04-29 20:11:14', 4, NULL, 100.00, 1950.00, 0, NULL, NULL, NULL),
(110, 169, 1800.00, 1, 233, '2019-04-30 22:02:18', 6, NULL, 200.00, 2000.00, 0, NULL, NULL, NULL),
(111, 42, 600.00, 3, 235, '2019-05-02 18:53:16', 4, NULL, 0.00, 600.00, 0, NULL, NULL, NULL),
(112, 171, 5450.00, 7, 236, '2019-05-03 13:10:21', 2, NULL, 0.00, 5450.00, 0, NULL, NULL, NULL),
(113, 170, 1000.00, 7, 237, '2019-05-03 13:12:14', 2, NULL, 0.00, 1000.00, 0, NULL, NULL, NULL),
(114, 164, 2000.00, 3, 238, '2019-05-03 14:14:25', 2, NULL, 0.00, 2000.00, 0, NULL, NULL, NULL),
(119, 174, 2450.00, 5, 243, '2019-05-06 18:25:00', 2, NULL, 500.00, 2950.00, 0, NULL, NULL, NULL),
(120, 173, 50.00, 1, 245, '2019-05-08 12:52:00', 1, NULL, 0.00, 50.00, 0, NULL, NULL, NULL),
(121, 173, 1750.00, 1, 246, '2019-05-08 12:54:00', 1, NULL, 200.00, 1950.00, 0, NULL, NULL, NULL),
(122, 176, 1750.00, 1, 247, '2019-05-13 10:18:00', 1, NULL, 250.00, 2000.00, 0, NULL, NULL, NULL),
(123, 177, 250.00, 1, 248, '2019-05-14 17:24:00', 1, NULL, 0.00, 250.00, 0, NULL, NULL, NULL),
(124, 179, 50.00, 1, 250, '2019-05-20 15:10:00', 1, NULL, 0.00, 50.00, 0, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `contas_recepcao`
--

CREATE TABLE `contas_recepcao` (
  `idcpagar` int(11) NOT NULL,
  `valor` decimal(10,2) NOT NULL,
  `vencimento` date DEFAULT NULL,
  `parcela` tinyint(4) NOT NULL,
  `idsituacao` tinyint(3) NOT NULL,
  `idmovipagar` int(11) NOT NULL,
  `data_pg` datetime DEFAULT NULL,
  `quem_pagou` varchar(40) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `contas_recep_movi`
--

CREATE TABLE `contas_recep_movi` (
  `idmovipagar` int(11) NOT NULL,
  `data_movimento` datetime DEFAULT NULL,
  `tipopg` varchar(40) DEFAULT NULL,
  `qtdparcelas` tinyint(3) NOT NULL,
  `valor` decimal(10,2) NOT NULL,
  `idformapg` tinyint(3) NOT NULL,
  `resp_cadastro` varchar(30) NOT NULL,
  `num_doc` varchar(11) DEFAULT NULL,
  `cancelado` int(2) NOT NULL,
  `data_cancelamento` datetime DEFAULT NULL,
  `cancelado_por` varchar(30) DEFAULT NULL,
  `mcancelamento` varchar(100) DEFAULT NULL,
  `data_edicao` datetime DEFAULT NULL,
  `resp_edicao` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `contas_recep_receita`
--

CREATE TABLE `contas_recep_receita` (
  `idparcelas` smallint(6) NOT NULL,
  `valor` decimal(10,2) NOT NULL,
  `vencimento` date NOT NULL,
  `parcela` tinyint(4) NOT NULL,
  `mensagem` varchar(38) NOT NULL,
  `idcliente` int(11) NOT NULL,
  `idsituacao` tinyint(3) NOT NULL,
  `idmovimento` int(11) NOT NULL,
  `data_pg` datetime DEFAULT NULL,
  `quem_recebeu` varchar(40) NOT NULL,
  `contadeposito` int(10) DEFAULT NULL,
  `depositante` varchar(15) DEFAULT NULL,
  `agencia` int(8) DEFAULT NULL,
  `banco` varchar(15) DEFAULT NULL,
  `num_doc` varchar(15) DEFAULT NULL,
  `emitente` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `contas_recep_receita_movi`
--

CREATE TABLE `contas_recep_receita_movi` (
  `idmovimento` int(11) NOT NULL,
  `valor` decimal(10,2) NOT NULL,
  `qtdparcelas` tinyint(3) NOT NULL,
  `data_movimento` datetime NOT NULL,
  `idformapg` tinyint(3) NOT NULL,
  `num_doc` varchar(30) DEFAULT NULL,
  `desconto` decimal(10,2) DEFAULT NULL,
  `cancelado` int(2) NOT NULL,
  `data_cancelamento` datetime DEFAULT NULL,
  `cancelado_por` varchar(30) DEFAULT NULL,
  `mcancelamento` varchar(100) DEFAULT NULL,
  `tipopg` int(11) NOT NULL,
  `data_edicao` datetime DEFAULT NULL,
  `resp_edicao` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `dentista`
--

CREATE TABLE `dentista` (
  `iddentista` int(3) UNSIGNED NOT NULL,
  `nome` varchar(30) NOT NULL,
  `cpf` varchar(15) NOT NULL,
  `rg` varchar(15) DEFAULT NULL,
  `nascimento` date DEFAULT NULL,
  `endereco` varchar(40) DEFAULT NULL,
  `bairro` varchar(25) DEFAULT NULL,
  `cidade` varchar(40) DEFAULT NULL,
  `estado` varchar(40) DEFAULT NULL,
  `cep` varchar(11) DEFAULT NULL,
  `celular` varchar(15) NOT NULL,
  `telefone` varchar(15) DEFAULT NULL,
  `sexo` varchar(9) NOT NULL,
  `conselho` varchar(15) NOT NULL,
  `idespecialidade` tinyint(3) UNSIGNED NOT NULL,
  `comissao` decimal(10,2) DEFAULT NULL,
  `numero` int(5) DEFAULT NULL,
  `resp_cadastro` varchar(25) NOT NULL,
  `data_cadastro` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `dentista`
--

INSERT INTO `dentista` (`iddentista`, `nome`, `cpf`, `rg`, `nascimento`, `endereco`, `bairro`, `cidade`, `estado`, `cep`, `celular`, `telefone`, `sexo`, `conselho`, `idespecialidade`, `comissao`, `numero`, `resp_cadastro`, `data_cadastro`) VALUES
(5, 'Michella Murta', '000.000.000-00', NULL, '1985-02-05', 'PraÃ§a Tiradentes', 'Centro', 'TeÃ³filo Otoni', 'MG', '39800001', '33-00000-0000', NULL, 'Feminino', '', 4, 100.00, 0, 'Admin', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Estrutura da tabela `doencas`
--

CREATE TABLE `doencas` (
  `iddoencas` int(11) NOT NULL,
  `nome` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `doencas`
--

INSERT INTO `doencas` (`iddoencas`, `nome`) VALUES
(1, 'Cardiaca'),
(2, 'Hepatite'),
(3, 'HipertensÃ£o'),
(4, 'Hipotireoidismo'),
(5, 'Diabetes'),
(6, 'HIV'),
(7, 'Cancer'),
(8, 'Asma'),
(9, 'Epilepsia'),
(10, 'Artrite'),
(11, 'Lupus'),
(12, 'AlteraÃ§Ãµes Nervosas');

-- --------------------------------------------------------

--
-- Estrutura da tabela `especialidade`
--

CREATE TABLE `especialidade` (
  `idespecialidade` tinyint(3) NOT NULL,
  `descricao` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `especialidade`
--

INSERT INTO `especialidade` (`idespecialidade`, `descricao`) VALUES
(1, 'Odontopediatria'),
(2, 'Radiologia Odontológica e Imaginologia'),
(3, 'Endodontia'),
(4, 'Odontologia Estetica/ Dentistica'),
(5, 'Ortopedia Funcional dos Maxilares'),
(6, 'Implantodontia'),
(7, 'Cirurgia e Traumatologia Buco - Maxilo -'),
(8, 'Periodontia'),
(9, 'Prótese Buco - Maxilo - Facial');

-- --------------------------------------------------------

--
-- Estrutura da tabela `evolucao`
--

CREATE TABLE `evolucao` (
  `idevolucao` int(11) NOT NULL,
  `evolucao` varchar(150) NOT NULL,
  `idtratamento` int(11) NOT NULL,
  `foto` varchar(40) DEFAULT NULL,
  `data_evo` datetime DEFAULT NULL,
  `resp_evo` varchar(40) NOT NULL,
  `evo_editado_por` varchar(30) DEFAULT NULL,
  `data_evo_edicao` datetime DEFAULT NULL,
  `idprocedtratamento` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `formapg`
--

CREATE TABLE `formapg` (
  `idformapg` tinyint(3) NOT NULL,
  `tipo` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `formapg`
--

INSERT INTO `formapg` (`idformapg`, `tipo`) VALUES
(1, 'Dinheiro'),
(2, 'CartÃ£o de Credito'),
(3, 'CartÃ£o de Debito'),
(4, 'Cheque'),
(5, 'Nota Promissoria'),
(6, 'Transferencia'),
(7, 'Fiado'),
(8, 'Deposito');

-- --------------------------------------------------------

--
-- Estrutura da tabela `logs`
--

CREATE TABLE `logs` (
  `logid` int(10) UNSIGNED NOT NULL,
  `hora` datetime NOT NULL,
  `login` varchar(15) NOT NULL,
  `mensagem` text CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `relacionamento` varchar(150) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `logs`
--

INSERT INTO `logs` (`logid`, `hora`, `login`, `mensagem`, `relacionamento`) VALUES
(1, '2019-03-08 17:54:07', 'Admin', 'Imagem Excluida', 'Imagem no cliente 22'),
(2, '2019-03-08 14:54:34', 'Admin', 'Imagem Inserida com titulo de teste 2', 'Imagem no cliente 22'),
(3, '2019-03-08 17:54:47', 'Admin', 'Imagem Excluida', 'Imagem no cliente 22'),
(4, '2019-03-08 17:54:50', 'Admin', 'Imagem Excluida', 'Imagem no cliente 22'),
(5, '2019-03-19 18:11:49', 'Admin', 'Receita Cadastrada', 'Receita numero 31 no Paciente 18'),
(6, '2019-03-19 18:12:12', 'Admin', 'Receita Excluida', 'Receita numero 31 no Paciente 18'),
(7, '2019-03-22 16:26:31', '', 'Procedimento de Tratamento Cadastrado', 'Procedimento numero 3'),
(8, '2019-03-22 16:26:44', '', 'Procedimento de Tratamento Cadastrado', 'Procedimento numero 4'),
(9, '2019-03-22 13:29:29', 'Admin', 'Tratamento Cadastrado', 'Tratamento numero 200'),
(10, '2019-03-22 16:32:01', 'Admin', 'Evolucao Editada', 'Evolucao numero 9'),
(11, '2019-03-22 16:36:08', 'Admin', 'Evolucao Editada', 'Evolucao numero 9'),
(12, '2019-03-22 16:50:03', 'Admin', 'Evolucao Editada', 'Evolucao numero 9'),
(13, '2019-03-22 16:50:41', 'Admin', 'Evolucao Editada', 'Evolucao numero 9'),
(14, '2019-03-22 13:51:43', 'Admin', 'Imagem Inserida', 'Imagem numero 45 no cliente 18'),
(15, '2019-03-22 16:58:23', 'Admin', 'Receita Cadastrada', 'Receita numero 33 no Paciente 18'),
(16, '2019-03-22 14:15:15', 'Admin', 'Paciente Editado', 'Cadastro no paciente 18'),
(17, '2019-04-02 20:25:20', 'Admin', 'Procedimento Excluido', 'Procedimento numero 8'),
(18, '2019-04-02 20:41:53', '', 'Atendimento Iniciado', 'Atendimento numero '),
(19, '2019-04-02 18:05:10', 'Admin', 'Paciente Cadastrado', 'Cadastro no paciente '),
(20, '2019-04-02 18:05:10', 'Admin', 'Paciente Cadastrado', 'Cadastro no paciente '),
(21, '2019-04-03 15:22:09', 'Admin', 'Paciente Editado', 'Cadastro no paciente 18'),
(22, '2019-04-03 18:24:34', '', 'Procedimento de Tratamento Cadastrado', 'Procedimento numero 4'),
(23, '2019-04-03 15:26:34', 'Admin', 'Tratamento Cadastrado', 'Tratamento numero 201'),
(24, '2019-04-03 18:27:31', '', 'Atendimento Iniciado', 'Atendimento numero '),
(25, '2019-04-03 18:30:47', '', 'Atendimento Iniciado', 'Atendimento numero 4'),
(26, '2019-04-03 18:31:50', 'Michella', 'Receita Cadastrada', 'Receita numero 34 no Paciente 18'),
(27, '2019-04-03 18:36:50', 'Admin', 'Procedimento Excluido', 'Procedimento numero 9'),
(28, '2019-04-03 18:38:27', 'Admin', 'Parcela Paga', 'Pagamento de parcela numero 33'),
(29, '2019-04-03 18:40:08', 'Admin', 'Tipo de pagamento Cadastrado', 'Tipo de pagamento numero 5'),
(30, '2019-04-03 18:41:41', 'Admin', 'Pagamento de despesas Efetuada', 'Pagamento numero 82'),
(31, '2019-04-03 15:56:47', 'Samuel', 'Paciente Cadastrado', 'Cadastro no paciente '),
(32, '2019-04-04 13:44:46', 'Samuel', 'Paciente Cadastrado', 'Cadastro no paciente '),
(33, '2019-04-04 14:14:22', 'Samuel', 'Paciente Cadastrado', 'Cadastro no paciente '),
(34, '2019-04-04 14:17:38', 'Samuel', 'Paciente Editado', 'Cadastro no paciente 31'),
(35, '2019-04-04 14:43:41', 'Samuel', 'Paciente Cadastrado', 'Cadastro no paciente '),
(36, '2019-04-04 14:54:57', 'Samuel', 'Paciente Cadastrado', 'Cadastro no paciente '),
(37, '2019-04-04 15:08:11', 'Samuel', 'Paciente Cadastrado', 'Cadastro no paciente '),
(38, '2019-04-04 15:23:14', 'Samuel', 'Paciente Cadastrado', 'Cadastro no paciente '),
(39, '2019-04-04 15:36:02', 'Samuel', 'Paciente Cadastrado', 'Cadastro no paciente '),
(40, '2019-04-04 15:47:50', 'Samuel', 'Paciente Cadastrado', 'Cadastro no paciente '),
(41, '2019-04-04 15:58:51', 'Samuel', 'Paciente Cadastrado', 'Cadastro no paciente '),
(42, '2019-04-04 16:21:15', 'Samuel', 'Paciente Cadastrado', 'Cadastro no paciente '),
(43, '2019-04-04 16:48:48', 'Samuel', 'Paciente Cadastrado', 'Cadastro no paciente '),
(44, '2019-04-04 16:59:57', 'Samuel', 'Paciente Cadastrado', 'Cadastro no paciente '),
(45, '2019-04-04 17:19:43', 'Samuel', 'Paciente Cadastrado', 'Cadastro no paciente '),
(46, '2019-04-08 14:07:03', 'Admin', 'Procedimento Editado', 'Procedimento numero 1'),
(47, '2019-04-08 14:07:15', 'Admin', 'Procedimento Editado', 'Procedimento numero 1'),
(48, '2019-04-08 13:52:33', 'Samuel', 'Paciente Cadastrado', 'Cadastro no paciente '),
(49, '2019-04-08 14:14:34', 'Samuel', 'Paciente Cadastrado', 'Cadastro no paciente '),
(50, '2019-04-08 14:31:11', 'Samuel', 'Paciente Cadastrado', 'Cadastro no paciente '),
(51, '2019-04-08 14:45:38', 'Samuel', 'Paciente Cadastrado', 'Cadastro no paciente '),
(52, '2019-04-08 15:06:58', 'Samuel', 'Paciente Cadastrado', 'Cadastro no paciente '),
(53, '2019-04-08 16:49:26', 'Samuel', 'Paciente Cadastrado', 'Cadastro no paciente '),
(54, '2019-04-08 17:01:09', 'Samuel', 'Paciente Cadastrado', 'Cadastro no paciente '),
(55, '2019-04-08 17:19:48', 'Samuel', 'Paciente Cadastrado', 'Cadastro no paciente '),
(56, '2019-04-09 09:12:33', 'Samuel', 'Paciente Cadastrado', 'Cadastro no paciente '),
(57, '2019-04-09 09:32:43', 'Samuel', 'Paciente Cadastrado', 'Cadastro no paciente '),
(58, '2019-04-09 09:44:08', 'Samuel', 'Paciente Cadastrado', 'Cadastro no paciente '),
(59, '2019-04-09 10:02:13', 'Samuel', 'Paciente Cadastrado', 'Cadastro no paciente '),
(60, '2019-04-09 10:13:49', 'Samuel', 'Paciente Cadastrado', 'Cadastro no paciente '),
(61, '2019-04-09 10:27:45', 'Samuel', 'Paciente Cadastrado', 'Cadastro no paciente '),
(62, '2019-04-09 10:49:23', 'Samuel', 'Paciente Cadastrado', 'Cadastro no paciente '),
(63, '2019-04-16 13:11:55', 'Viviane', 'Paciente Editado', 'Cadastro no paciente 30'),
(64, '2019-04-16 13:20:52', 'Viviane', 'Paciente Cadastrado', 'Cadastro no paciente '),
(65, '2019-04-16 13:26:14', 'Viviane', 'Paciente Cadastrado', 'Cadastro no paciente '),
(66, '2019-04-16 13:31:29', 'Viviane', 'Paciente Cadastrado', 'Cadastro no paciente '),
(67, '2019-04-16 13:35:44', 'Viviane', 'Paciente Cadastrado', 'Cadastro no paciente '),
(68, '2019-04-16 13:36:30', 'Viviane', 'Paciente Editado', 'Cadastro no paciente 58'),
(69, '2019-04-16 13:36:49', 'Viviane', 'Paciente Editado', 'Cadastro no paciente 59'),
(70, '2019-04-16 13:37:10', 'Viviane', 'Paciente Editado', 'Cadastro no paciente 61'),
(71, '2019-04-16 13:44:44', 'Viviane', 'Paciente Cadastrado', 'Cadastro no paciente '),
(72, '2019-04-16 13:48:34', 'Viviane', 'Paciente Editado', 'Cadastro no paciente 30'),
(73, '2019-04-16 13:49:27', 'Viviane', 'Paciente Editado', 'Cadastro no paciente 30'),
(74, '2019-04-16 13:53:01', 'Viviane', 'Paciente Editado', 'Cadastro no paciente 60'),
(75, '2019-04-16 14:08:07', 'Viviane', 'Paciente Cadastrado', 'Cadastro no paciente '),
(76, '2019-04-16 14:11:36', 'Viviane', 'Paciente Cadastrado', 'Cadastro no paciente '),
(77, '2019-04-16 14:14:40', 'Viviane', 'Paciente Cadastrado', 'Cadastro no paciente '),
(78, '2019-04-16 14:17:59', 'Viviane', 'Paciente Cadastrado', 'Cadastro no paciente '),
(79, '2019-04-16 14:20:49', 'Viviane', 'Paciente Cadastrado', 'Cadastro no paciente '),
(80, '2019-04-16 14:22:08', 'Viviane', 'Paciente Editado', 'Cadastro no paciente 67'),
(81, '2019-04-16 14:24:57', 'Viviane', 'Paciente Cadastrado', 'Cadastro no paciente '),
(82, '2019-04-16 14:29:01', 'Viviane', 'Paciente Cadastrado', 'Cadastro no paciente '),
(83, '2019-04-16 14:39:43', 'Viviane', 'Paciente Cadastrado', 'Cadastro no paciente '),
(84, '2019-04-16 14:41:52', 'Viviane', 'Paciente Cadastrado', 'Cadastro no paciente '),
(85, '2019-04-16 14:45:29', 'Viviane', 'Paciente Cadastrado', 'Cadastro no paciente '),
(86, '2019-04-16 14:47:22', 'Viviane', 'Paciente Cadastrado', 'Cadastro no paciente '),
(87, '2019-04-16 14:49:55', 'Viviane', 'Paciente Cadastrado', 'Cadastro no paciente '),
(88, '2019-04-16 14:53:37', 'Viviane', 'Paciente Cadastrado', 'Cadastro no paciente '),
(89, '2019-04-16 15:04:52', 'Viviane', 'Paciente Cadastrado', 'Cadastro no paciente '),
(90, '2019-04-16 15:12:01', 'Viviane', 'Paciente Cadastrado', 'Cadastro no paciente '),
(91, '2019-04-16 15:14:12', 'Viviane', 'Paciente Cadastrado', 'Cadastro no paciente '),
(92, '2019-04-16 15:19:14', 'Viviane', 'Paciente Cadastrado', 'Cadastro no paciente '),
(93, '2019-04-16 15:21:53', 'Viviane', 'Paciente Cadastrado', 'Cadastro no paciente '),
(94, '2019-04-16 15:23:49', 'Viviane', 'Paciente Cadastrado', 'Cadastro no paciente '),
(95, '2019-04-16 15:32:37', 'Viviane', 'Paciente Cadastrado', 'Cadastro no paciente '),
(96, '2019-04-16 15:43:53', 'Viviane', 'Paciente Cadastrado', 'Cadastro no paciente '),
(97, '2019-04-16 15:47:34', 'Viviane', 'Paciente Cadastrado', 'Cadastro no paciente '),
(98, '2019-04-16 15:56:37', 'Viviane', 'Paciente Cadastrado', 'Cadastro no paciente '),
(99, '2019-04-16 16:00:19', 'Viviane', 'Paciente Cadastrado', 'Cadastro no paciente '),
(100, '2019-04-16 16:02:34', 'Viviane', 'Paciente Cadastrado', 'Cadastro no paciente '),
(101, '2019-04-16 16:04:52', 'Viviane', 'Paciente Cadastrado', 'Cadastro no paciente '),
(102, '2019-04-16 16:15:41', 'Viviane', 'Paciente Cadastrado', 'Cadastro no paciente '),
(103, '2019-04-16 16:21:23', 'Viviane', 'Paciente Cadastrado', 'Cadastro no paciente '),
(104, '2019-04-16 16:31:15', 'Viviane', 'Paciente Cadastrado', 'Cadastro no paciente '),
(105, '2019-04-16 16:34:07', 'Viviane', 'Paciente Cadastrado', 'Cadastro no paciente '),
(106, '2019-04-16 16:36:12', 'Viviane', 'Paciente Cadastrado', 'Cadastro no paciente '),
(107, '2019-04-16 16:41:28', 'Viviane', 'Paciente Cadastrado', 'Cadastro no paciente '),
(108, '2019-04-16 16:56:38', 'Viviane', 'Paciente Editado', 'Cadastro no paciente 35'),
(109, '2019-04-16 17:00:56', 'Viviane', 'Paciente Cadastrado', 'Cadastro no paciente '),
(110, '2019-04-16 17:12:26', 'Viviane', 'Paciente Cadastrado', 'Cadastro no paciente '),
(111, '2019-04-16 17:16:21', 'Viviane', 'Paciente Cadastrado', 'Cadastro no paciente '),
(112, '2019-04-16 17:21:16', 'Viviane', 'Paciente Cadastrado', 'Cadastro no paciente '),
(113, '2019-04-16 17:26:32', 'Viviane', 'Paciente Cadastrado', 'Cadastro no paciente '),
(114, '2019-04-16 17:30:28', 'Viviane', 'Paciente Cadastrado', 'Cadastro no paciente '),
(115, '2019-04-16 17:37:09', 'Viviane', 'Paciente Cadastrado', 'Cadastro no paciente '),
(116, '2019-04-16 17:41:51', 'Viviane', 'Paciente Cadastrado', 'Cadastro no paciente '),
(117, '2019-04-16 17:44:46', 'Viviane', 'Paciente Cadastrado', 'Cadastro no paciente '),
(118, '2019-04-16 17:47:23', 'Viviane', 'Paciente Cadastrado', 'Cadastro no paciente '),
(119, '2019-04-16 17:58:21', 'Viviane', 'Paciente Cadastrado', 'Cadastro no paciente '),
(120, '2019-04-16 18:01:15', 'Viviane', 'Paciente Cadastrado', 'Cadastro no paciente '),
(121, '2019-04-16 18:08:09', 'Viviane', 'Paciente Cadastrado', 'Cadastro no paciente '),
(122, '2019-04-16 18:10:55', 'Viviane', 'Paciente Editado', 'Cadastro no paciente 41'),
(123, '2019-04-16 18:19:03', 'Viviane', 'Paciente Cadastrado', 'Cadastro no paciente '),
(124, '2019-04-16 18:21:04', 'Viviane', 'Paciente Cadastrado', 'Cadastro no paciente '),
(125, '2019-04-16 18:23:02', 'Viviane', 'Paciente Cadastrado', 'Cadastro no paciente '),
(126, '2019-04-16 18:28:52', 'Viviane', 'Paciente Cadastrado', 'Cadastro no paciente '),
(127, '2019-04-17 09:42:30', 'Viviane', 'Paciente Cadastrado', 'Cadastro no paciente '),
(128, '2019-04-17 09:45:11', 'Viviane', 'Paciente Cadastrado', 'Cadastro no paciente '),
(129, '2019-04-17 09:47:03', 'Viviane', 'Paciente Cadastrado', 'Cadastro no paciente '),
(130, '2019-04-17 10:00:41', 'Viviane', 'Paciente Editado', 'Cadastro no paciente 99'),
(131, '2019-04-17 10:02:15', 'Jade Costa', 'Paciente Editado', 'Cadastro no paciente 58'),
(132, '2019-04-17 10:02:32', 'Jade Costa', 'Paciente Editado', 'Cadastro no paciente 68'),
(133, '2019-04-17 10:02:48', 'Jade Costa', 'Paciente Editado', 'Cadastro no paciente 67'),
(134, '2019-04-17 10:03:06', 'Jade Costa', 'Paciente Editado', 'Cadastro no paciente 65'),
(135, '2019-04-17 10:03:44', 'Jade Costa', 'Paciente Editado', 'Cadastro no paciente 60'),
(136, '2019-04-17 10:35:40', 'Jade Costa', 'Paciente Cadastrado', 'Cadastro no paciente '),
(137, '2019-04-17 10:38:21', 'Jade Costa', 'Paciente Cadastrado', 'Cadastro no paciente '),
(138, '2019-04-17 10:38:46', 'Jade Costa', 'Paciente Editado', 'Cadastro no paciente 116'),
(139, '2019-04-17 10:41:56', 'Jade Costa', 'Paciente Cadastrado', 'Cadastro no paciente '),
(140, '2019-04-17 10:44:07', 'Jade Costa', 'Paciente Cadastrado', 'Cadastro no paciente '),
(141, '2019-04-17 10:50:23', 'Jade Costa', 'Paciente Cadastrado', 'Cadastro no paciente '),
(142, '2019-04-17 11:53:26', 'Jade Costa', 'Paciente Cadastrado', 'Cadastro no paciente '),
(143, '2019-04-17 11:55:31', 'Jade Costa', 'Paciente Cadastrado', 'Cadastro no paciente '),
(144, '2019-04-17 11:56:01', 'Jade Costa', 'Paciente Editado', 'Cadastro no paciente 99'),
(145, '2019-04-17 11:58:31', 'Jade Costa', 'Paciente Cadastrado', 'Cadastro no paciente '),
(146, '2019-04-17 12:04:33', 'Jade Costa', 'Paciente Cadastrado', 'Cadastro no paciente '),
(147, '2019-04-17 12:06:33', 'Jade Costa', 'Paciente Cadastrado', 'Cadastro no paciente '),
(148, '2019-04-17 12:08:53', 'Jade Costa', 'Paciente Cadastrado', 'Cadastro no paciente '),
(149, '2019-04-17 14:30:05', 'Jade Costa', 'Paciente Cadastrado', 'Cadastro no paciente '),
(150, '2019-04-17 14:31:54', 'Jade Costa', 'Paciente Cadastrado', 'Cadastro no paciente '),
(151, '2019-04-17 14:34:16', 'Jade Costa', 'Paciente Cadastrado', 'Cadastro no paciente '),
(152, '2019-04-17 14:36:23', 'Jade Costa', 'Paciente Cadastrado', 'Cadastro no paciente '),
(153, '2019-04-17 14:38:27', 'Jade Costa', 'Paciente Cadastrado', 'Cadastro no paciente '),
(154, '2019-04-17 14:40:12', 'Jade Costa', 'Paciente Cadastrado', 'Cadastro no paciente '),
(155, '2019-04-17 14:42:35', 'Jade Costa', 'Paciente Cadastrado', 'Cadastro no paciente '),
(156, '2019-04-17 14:45:31', 'Jade Costa', 'Paciente Cadastrado', 'Cadastro no paciente '),
(157, '2019-04-17 14:48:58', 'Jade Costa', 'Paciente Cadastrado', 'Cadastro no paciente '),
(158, '2019-04-17 14:54:19', 'Jade Costa', 'Paciente Cadastrado', 'Cadastro no paciente '),
(159, '2019-04-17 14:58:16', 'Jade Costa', 'Paciente Cadastrado', 'Cadastro no paciente '),
(160, '2019-04-17 15:07:48', 'Jade Costa', 'Paciente Cadastrado', 'Cadastro no paciente '),
(161, '2019-04-17 16:52:30', 'Jade Costa', 'Paciente Cadastrado', 'Cadastro no paciente '),
(162, '2019-04-17 17:05:43', 'Jade Costa', 'Paciente Cadastrado', 'Cadastro no paciente '),
(163, '2019-04-17 17:11:49', 'Jade Costa', 'Paciente Editado', 'Cadastro no paciente 125'),
(164, '2019-04-18 13:04:25', '', 'Procedimento de Tratamento Cadastrado', 'Procedimento numero 3'),
(165, '2019-04-18 13:04:41', '', 'Procedimento de Tratamento Cadastrado', 'Procedimento numero 3'),
(166, '2019-04-18 13:04:57', '', 'Procedimento de Tratamento Cadastrado', 'Procedimento numero 1'),
(167, '2019-04-18 13:06:18', '', 'Procedimento de Tratamento Cadastrado', 'Procedimento numero 1'),
(168, '2019-04-18 13:06:26', '', 'Procedimento de Tratamento Cadastrado', 'Procedimento numero 1'),
(169, '2019-04-18 13:06:38', '', 'Procedimento de Tratamento Cadastrado', 'Procedimento numero 1'),
(170, '2019-04-18 10:10:27', 'Jade Costa', 'Tratamento Cadastrado', 'Tratamento numero 203'),
(171, '2019-04-18 13:10:56', '', 'Atendimento Iniciado', 'Atendimento numero '),
(172, '2019-04-18 13:13:02', 'Michella', 'Parcela Paga', 'Pagamento de parcela numero 35'),
(173, '2019-04-18 13:33:42', 'Jade Costa', 'Tipo de pagamento Cadastrado', 'Tipo de pagamento numero 6'),
(174, '2019-04-18 13:34:04', 'Jade Costa', 'Tipo de pagamento Cadastrado', 'Tipo de pagamento numero 7'),
(175, '2019-04-18 14:02:43', 'Jade Costa', 'Tipo de pagamento Cadastrado', 'Tipo de pagamento numero 8'),
(176, '2019-04-18 14:04:43', 'Jade Costa', 'Tipo de pagamento Cadastrado', 'Tipo de pagamento numero 9'),
(177, '2019-04-18 14:11:49', 'Jade Costa', 'Tipo de pagamento Cadastrado', 'Tipo de pagamento numero 10'),
(178, '2019-04-18 15:03:58', '', 'Procedimento de Tratamento Cadastrado', 'Procedimento numero 2'),
(179, '2019-04-18 12:04:10', 'Admin', 'Tratamento Cadastrado', 'Tratamento numero 204'),
(180, '2019-04-18 15:10:01', '', 'Procedimento de Tratamento Cadastrado', 'Procedimento numero 1'),
(181, '2019-04-18 12:10:13', 'Admin', 'Tratamento Cadastrado', 'Tratamento numero 205'),
(182, '2019-04-18 16:28:57', '', 'Procedimento de Tratamento Cadastrado', 'Procedimento numero 3'),
(183, '2019-04-18 16:29:59', '', 'Procedimento de Tratamento Cadastrado', 'Procedimento numero 6'),
(184, '2019-04-18 13:30:53', 'Jade Costa', 'Tratamento Cadastrado', 'Tratamento numero 207'),
(185, '2019-04-18 16:31:58', 'Jade Costa', 'Parcela Paga', 'Pagamento de parcela numero 38'),
(186, '2019-04-18 13:43:48', 'Jade Costa', 'Anamnese Editada', 'Anamnese no Paciente 67'),
(187, '2019-04-18 13:45:30', 'Jade Costa', 'Anamnese Editada', 'Anamnese no Paciente 67'),
(188, '2019-04-18 14:14:46', 'Jade Costa', 'Paciente Editado', 'Cadastro no paciente 59'),
(189, '2019-04-18 14:19:28', 'Jade Costa', 'Paciente Editado', 'Cadastro no paciente 62'),
(190, '2019-04-18 14:23:16', 'Jade Costa', 'Paciente Editado', 'Cadastro no paciente 66'),
(191, '2019-04-18 17:39:43', '', 'Atendimento Iniciado', 'Atendimento numero 5'),
(192, '2019-04-18 19:59:50', 'Admin', 'Pagamento Cancelado', 'Pagamento numero 38'),
(193, '2019-04-18 20:14:34', 'Jade Costa', 'Procedimento Editado', 'Procedimento numero 3'),
(194, '2019-04-22 10:15:22', 'Jade Costa', 'Imagem Inserida com titulo de Preenchimento Labial', 'Imagem no cliente 99'),
(195, '2019-04-22 10:15:22', 'Jade Costa', 'Imagem Cadastrada', 'Imagem no Paciente 99'),
(196, '2019-04-22 10:15:56', 'Jade Costa', 'Imagem Inserida com titulo de Preenchimento Labial (Antes)', 'Imagem no cliente 99'),
(197, '2019-04-22 10:15:56', 'Jade Costa', 'Imagem Cadastrada', 'Imagem no Paciente 99'),
(198, '2019-04-22 10:16:40', 'Jade Costa', 'Imagem Inserida com titulo de RinomodelaÃ§Ã£o (Anted)', 'Imagem no cliente 99'),
(199, '2019-04-22 10:16:40', 'Jade Costa', 'Imagem Cadastrada', 'Imagem no Paciente 99'),
(200, '2019-04-22 13:16:49', 'Jade Costa', 'Imagem Excluida', 'Imagem no Paciente 99'),
(201, '2019-04-22 10:17:20', 'Jade Costa', 'Imagem Inserida com titulo de RinomodelaÃ§Ã£o (Antes)', 'Imagem no cliente 99'),
(202, '2019-04-22 10:17:20', 'Jade Costa', 'Imagem Cadastrada', 'Imagem no Paciente 99'),
(203, '2019-04-22 10:17:50', 'Jade Costa', 'Imagem Inserida com titulo de RinomodelaÃ§Ã£o', 'Imagem no cliente 99'),
(204, '2019-04-22 10:17:50', 'Jade Costa', 'Imagem Cadastrada', 'Imagem no Paciente 99'),
(205, '2019-04-22 10:18:31', 'Jade Costa', 'Imagem Inserida com titulo de Preenchimento Labial', 'Imagem no cliente 99'),
(206, '2019-04-22 10:18:31', 'Jade Costa', 'Imagem Cadastrada', 'Imagem no Paciente 99'),
(207, '2019-04-22 10:18:55', 'Jade Costa', 'Imagem Inserida com titulo de Preenchimento Labial (Antes)', 'Imagem no cliente 99'),
(208, '2019-04-22 10:18:55', 'Jade Costa', 'Imagem Cadastrada', 'Imagem no Paciente 99'),
(209, '2019-04-22 10:33:13', 'Jade Costa', 'Paciente Cadastrado', 'Cadastro no paciente '),
(210, '2019-04-22 10:38:59', 'Jade Costa', 'Paciente Cadastrado', 'Cadastro no paciente '),
(211, '2019-04-22 10:40:21', 'Jade Costa', 'Paciente Editado', 'Cadastro no paciente 141'),
(212, '2019-04-22 10:51:04', 'Jade Costa', 'Paciente Editado', 'Cadastro no paciente 54'),
(213, '2019-04-22 10:52:39', 'Jade Costa', 'Paciente Editado', 'Cadastro no paciente 53'),
(214, '2019-04-22 10:56:31', 'Jade Costa', 'Paciente Cadastrado', 'Cadastro no paciente '),
(215, '2019-04-22 11:01:49', 'Jade Costa', 'Paciente Cadastrado', 'Cadastro no paciente '),
(216, '2019-04-22 11:09:38', 'Jade Costa', 'Paciente Cadastrado', 'Cadastro no paciente '),
(217, '2019-04-22 11:20:22', 'Jade Costa', 'Paciente Cadastrado', 'Cadastro no paciente '),
(218, '2019-04-22 11:25:53', 'Jade Costa', 'Paciente Cadastrado', 'Cadastro no paciente '),
(219, '2019-04-22 11:30:03', 'Jade Costa', 'Paciente Cadastrado', 'Cadastro no paciente '),
(220, '2019-04-22 11:34:51', 'Jade Costa', 'Paciente Cadastrado', 'Cadastro no paciente '),
(221, '2019-04-22 13:44:18', 'Jade Costa', 'Paciente Cadastrado', 'Cadastro no paciente '),
(222, '2019-04-22 16:49:09', '', 'Procedimento de Tratamento Cadastrado', 'Procedimento numero 15'),
(223, '2019-04-22 16:49:32', '', 'Procedimento de Tratamento Cadastrado', 'Procedimento numero 3'),
(224, '2019-04-22 16:52:02', '', 'Procedimento de Tratamento Cadastrado', 'Procedimento numero 15'),
(225, '2019-04-22 13:52:33', 'Jade Costa', 'Tratamento Cadastrado', 'Tratamento numero 209'),
(226, '2019-04-22 16:52:43', '', 'Atendimento Iniciado', 'Atendimento numero '),
(227, '2019-04-22 16:54:33', '', 'Procedimento de Tratamento Cadastrado', 'Procedimento numero 3'),
(228, '2019-04-22 13:55:01', 'Jade Costa', 'Tratamento Cadastrado', 'Tratamento numero 210'),
(229, '2019-04-22 13:57:37', 'Jade Costa', 'Paciente Cadastrado', 'Cadastro no paciente '),
(230, '2019-04-22 14:03:05', 'Jade Costa', 'Paciente Cadastrado', 'Cadastro no paciente '),
(231, '2019-04-22 14:06:44', 'Jade Costa', 'Paciente Cadastrado', 'Cadastro no paciente '),
(232, '2019-04-22 14:14:19', 'Jade Costa', 'Paciente Cadastrado', 'Cadastro no paciente '),
(233, '2019-04-22 14:30:34', 'Jade Costa', 'Paciente Cadastrado', 'Cadastro no paciente '),
(234, '2019-04-22 14:35:28', 'Jade Costa', 'Paciente Cadastrado', 'Cadastro no paciente '),
(235, '2019-04-22 14:39:33', 'Jade Costa', 'Paciente Cadastrado', 'Cadastro no paciente '),
(236, '2019-04-22 14:50:54', 'Jade Costa', 'Paciente Cadastrado', 'Cadastro no paciente '),
(237, '2019-04-22 15:04:11', 'Jade Costa', 'Paciente Cadastrado', 'Cadastro no paciente '),
(238, '2019-04-22 15:16:12', 'Jade Costa', 'Paciente Cadastrado', 'Cadastro no paciente '),
(239, '2019-04-22 18:21:04', 'Jade Costa', 'Tipo de pagamento Cadastrado', 'Tipo de pagamento numero 11'),
(240, '2019-04-22 15:27:27', 'Jade Costa', 'Paciente Cadastrado', 'Cadastro no paciente '),
(241, '2019-04-22 15:28:16', 'Jade Costa', 'Paciente Editado', 'Cadastro no paciente 160'),
(242, '2019-04-22 15:38:38', 'Jade Costa', 'Paciente Editado', 'Cadastro no paciente 48'),
(243, '2019-04-22 16:12:49', 'Jade Costa', 'Paciente Cadastrado', 'Cadastro no paciente '),
(244, '2019-04-22 20:12:24', 'Jade Costa', 'Pagamento de despesas Efetuada', 'Pagamento numero 85'),
(245, '2019-04-22 20:12:50', 'Jade Costa', 'Pagamento de despesas Efetuada', 'Pagamento numero 101'),
(246, '2019-04-22 20:56:27', '', 'Procedimento de Tratamento Cadastrado', 'Procedimento numero 3'),
(247, '2019-04-22 20:56:45', '', 'Procedimento de Tratamento Cadastrado', 'Procedimento numero 16'),
(248, '2019-04-22 20:56:57', '', 'Procedimento de Tratamento Cadastrado', 'Procedimento numero 17'),
(249, '2019-04-22 20:57:24', '', 'Procedimento de Tratamento Cadastrado', 'Procedimento numero 18'),
(250, '2019-04-22 20:57:48', '', 'Procedimento de Tratamento Cadastrado', 'Procedimento numero 1'),
(251, '2019-04-22 20:58:00', '', 'Procedimento de Tratamento Cadastrado', 'Procedimento numero 1'),
(252, '2019-04-22 21:05:45', '', 'Procedimento de Tratamento Cadastrado', 'Procedimento numero 19'),
(253, '2019-04-22 18:07:29', 'Jade Costa', 'Tratamento Cadastrado', 'Tratamento numero 213'),
(254, '2019-04-22 21:16:26', '', 'Atendimento Iniciado', 'Atendimento numero '),
(255, '2019-04-23 12:20:51', '', 'Atendimento Iniciado', 'Atendimento numero '),
(256, '2019-04-23 12:26:37', '', 'Procedimento de Tratamento Cadastrado', 'Procedimento numero 6'),
(257, '2019-04-23 09:28:12', 'Jade Costa', 'Tratamento Cadastrado', 'Tratamento numero 214'),
(258, '2019-04-23 12:29:21', '', 'Procedimento de Tratamento Cadastrado', 'Procedimento numero 11'),
(259, '2019-04-23 09:31:10', 'Jade Costa', 'Tratamento Cadastrado', 'Tratamento numero 215'),
(260, '2019-04-23 12:34:01', '', 'Procedimento de Tratamento Cadastrado', 'Procedimento numero 20'),
(261, '2019-04-23 12:34:22', '', 'Procedimento de Tratamento Cadastrado', 'Procedimento numero 20'),
(262, '2019-04-23 12:34:30', '', 'Procedimento de Tratamento Cadastrado', 'Procedimento numero 20'),
(263, '2019-04-23 09:35:19', 'Jade Costa', 'Tratamento Cadastrado', 'Tratamento numero 218'),
(264, '2019-04-23 12:35:45', '', 'Procedimento de Tratamento Cadastrado', 'Procedimento numero 3'),
(265, '2019-04-23 12:35:58', '', 'Procedimento de Tratamento Cadastrado', 'Procedimento numero 1'),
(266, '2019-04-23 16:59:34', 'Jade Costa', 'Tipo de pagamento Cadastrado', 'Tipo de pagamento numero 12'),
(267, '2019-04-23 16:59:34', 'Jade Costa', 'Tipo de pagamento Cadastrado', 'Tipo de pagamento numero 13'),
(268, '2019-04-23 17:00:11', 'Jade Costa', 'Tipo de pagamento Cadastrado', 'Tipo de pagamento numero 14'),
(269, '2019-04-23 17:26:13', '', 'Atendimento Iniciado', 'Atendimento numero '),
(270, '2019-04-23 19:15:24', '', 'Procedimento de Tratamento Cadastrado', 'Procedimento numero 11'),
(271, '2019-04-23 16:16:46', 'Jade Costa', 'Tratamento Cadastrado', 'Tratamento numero 221'),
(272, '2019-04-23 19:17:01', '', 'Atendimento Iniciado', 'Atendimento numero '),
(273, '2019-04-23 21:30:53', '', 'Atendimento Iniciado', 'Atendimento numero '),
(274, '2019-04-23 21:32:05', '', 'Atendimento Iniciado', 'Atendimento numero 7'),
(275, '2019-04-23 21:33:12', 'Michella', 'Receita Cadastrada', 'Receita numero 35 no Paciente 104'),
(276, '2019-04-23 21:34:56', '', 'Atendimento Iniciado', 'Atendimento numero 9'),
(277, '2019-04-23 21:35:26', 'Michella', 'Tratamento Finalizado', 'Tratamento numero 203'),
(278, '2019-04-23 21:36:12', '', 'Atendimento Iniciado', 'Atendimento numero 8'),
(279, '2019-04-23 21:37:28', '', 'Atendimento Iniciado', 'Atendimento numero 10'),
(280, '2019-04-23 21:39:24', 'Jade Costa', 'Parcela Paga', 'Pagamento de parcela numero 50'),
(281, '2019-04-24 10:29:29', 'Jade Costa', 'Paciente Cadastrado', 'Cadastro no paciente '),
(282, '2019-04-24 13:35:53', '', 'Procedimento de Tratamento Cadastrado', 'Procedimento numero 1'),
(283, '2019-04-24 13:36:04', '', 'Procedimento de Tratamento Cadastrado', 'Procedimento numero 1'),
(284, '2019-04-24 13:36:24', '', 'Procedimento de Tratamento Cadastrado', 'Procedimento numero 3'),
(285, '2019-04-24 10:37:33', 'Jade Costa', 'Tratamento Cadastrado', 'Tratamento numero 223'),
(286, '2019-04-24 13:37:42', '', 'Atendimento Iniciado', 'Atendimento numero '),
(287, '2019-04-24 17:37:48', 'Jade Costa', 'Parcela Paga', 'Pagamento de parcela numero 39'),
(288, '2019-04-24 17:56:47', 'Michella', 'Receita Cadastrada', 'Receita numero 37 no Paciente 58'),
(289, '2019-04-24 18:03:29', '', 'Atendimento Iniciado', 'Atendimento numero 6'),
(290, '2019-04-24 18:20:05', 'Jade Costa', 'Pagamento Cancelado', 'Pagamento numero 40'),
(291, '2019-04-24 19:07:42', 'Jade Costa', 'Tipo de pagamento Cadastrado', 'Tipo de pagamento numero 15'),
(292, '2019-04-24 19:15:19', 'Jade Costa', 'Tipo de pagamento Cadastrado', 'Tipo de pagamento numero 16'),
(293, '2019-04-24 19:16:50', 'Jade Costa', 'Tipo de pagamento Cadastrado', 'Tipo de pagamento numero 17'),
(294, '2019-04-24 19:18:32', 'Jade Costa', 'Tipo de pagamento Cadastrado', 'Tipo de pagamento numero 18'),
(295, '2019-04-24 19:18:55', 'Jade Costa', 'Tipo de pagamento Cadastrado', 'Tipo de pagamento numero 19'),
(296, '2019-04-24 19:20:58', 'Jade Costa', 'Tipo de pagamento Cadastrado', 'Tipo de pagamento numero 20'),
(297, '2019-04-24 19:21:10', 'Jade Costa', 'Tipo de pagamento Cadastrado', 'Tipo de pagamento numero 21'),
(298, '2019-04-24 19:35:33', 'Jade Costa', 'Tipo de pagamento Cadastrado', 'Tipo de pagamento numero 22'),
(299, '2019-04-24 19:37:26', 'Jade Costa', 'Pagamento de despesas Efetuada', 'Pagamento numero 119'),
(300, '2019-04-24 20:12:02', 'Jade Costa', 'Parcela Paga', 'Pagamento de parcela numero 48'),
(301, '2019-04-24 20:12:08', 'Jade Costa', 'Parcela Paga', 'Pagamento de parcela numero 47'),
(302, '2019-04-24 20:12:26', 'Jade Costa', 'Parcela Paga', 'Pagamento de parcela numero 49'),
(303, '2019-04-25 10:31:39', 'Admin', 'Receita Cadastrada', 'Receita numero 38 no Paciente 68'),
(304, '2019-04-25 10:39:50', 'Admin', 'Receita Cadastrada', 'Receita numero 39 no Paciente 58'),
(305, '2019-04-25 12:09:11', 'Admin', 'Receita Cadastrada', 'Receita numero 40 no Paciente 67'),
(306, '2019-04-25 10:32:31', 'Jade Costa', 'Paciente Cadastrado', 'Cadastro no paciente '),
(307, '2019-04-25 18:39:59', '', 'Procedimento de Tratamento Cadastrado', 'Procedimento numero 1'),
(308, '2019-04-25 18:41:33', '', 'Procedimento de Tratamento Cadastrado', 'Procedimento numero 22'),
(309, '2019-04-25 18:41:49', '', 'Procedimento de Tratamento Cadastrado', 'Procedimento numero 3'),
(310, '2019-04-25 15:43:04', 'Jade Costa', 'Tratamento Cadastrado', 'Tratamento numero 224'),
(311, '2019-04-25 18:43:12', '', 'Atendimento Iniciado', 'Atendimento numero '),
(312, '2019-04-25 18:43:34', 'Jade Costa', 'Parcela Paga', 'Pagamento de parcela numero 57'),
(313, '2019-04-25 17:47:45', 'Jade Costa', 'Paciente Cadastrado', 'Cadastro no paciente '),
(314, '2019-04-25 18:41:41', 'Jade Costa', 'Paciente Cadastrado', 'Cadastro no paciente '),
(315, '2019-04-26 12:56:34', '', 'Procedimento de Tratamento Cadastrado', 'Procedimento numero 23'),
(316, '2019-04-26 12:57:52', '', 'Procedimento de Tratamento Cadastrado', 'Procedimento numero 24'),
(317, '2019-04-26 10:01:48', 'Jade Costa', 'Tratamento Cadastrado', 'Tratamento numero 226'),
(318, '2019-04-26 13:01:59', '', 'Atendimento Iniciado', 'Atendimento numero '),
(319, '2019-04-26 10:29:09', 'Jade Costa', 'Paciente Cadastrado', 'Cadastro no paciente '),
(320, '2019-04-26 13:36:31', '', 'Procedimento de Tratamento Cadastrado', 'Procedimento numero 22'),
(321, '2019-04-26 13:36:48', '', 'Procedimento de Tratamento Cadastrado', 'Procedimento numero 12'),
(322, '2019-04-26 10:37:45', 'Jade Costa', 'Tratamento Cadastrado', 'Tratamento numero 227'),
(323, '2019-04-26 17:20:06', 'Jade Costa', 'Paciente Cadastrado', 'Cadastro no paciente '),
(324, '2019-04-29 12:48:31', 'Jade Costa', 'Pagamento de despesas Efetuada', 'Pagamento numero 88'),
(325, '2019-04-29 13:56:34', 'Jade Costa', 'Pagamento de despesas Efetuada', 'Pagamento numero 103'),
(326, '2019-04-29 13:59:14', 'Jade Costa', 'Pagamento Cancelado', 'Pagamento numero 70'),
(327, '2019-04-29 14:48:52', '', 'Procedimento de Tratamento Cadastrado', 'Procedimento numero 3'),
(328, '2019-04-29 11:49:39', 'Jade Costa', 'Tratamento Cadastrado', 'Tratamento numero 228'),
(329, '2019-04-29 14:50:39', '', 'Atendimento Iniciado', 'Atendimento numero '),
(330, '2019-04-29 17:00:37', '', 'Procedimento de Tratamento Cadastrado', 'Procedimento numero 3'),
(331, '2019-04-29 14:57:47', 'Jade Costa', 'Paciente Cadastrado', 'Cadastro no paciente '),
(332, '2019-04-29 18:15:41', 'Admin', 'Receita Cadastrada', 'Receita numero 41 no Paciente 68'),
(333, '2019-04-29 18:20:41', 'Admin', 'Receita Cadastrada', 'Receita numero 42 no Paciente 68'),
(334, '2019-04-29 18:22:34', 'Admin', 'Receita Cadastrada', 'Receita numero 43 no Paciente 68'),
(335, '2019-04-29 17:07:27', 'Jade Costa', 'Paciente Editado', 'Cadastro no paciente 168'),
(336, '2019-04-29 20:08:25', '', 'Procedimento de Tratamento Cadastrado', 'Procedimento numero 3'),
(337, '2019-04-29 20:10:41', '', 'Procedimento de Tratamento Cadastrado', 'Procedimento numero 25'),
(338, '2019-04-29 17:11:14', 'Jade Costa', 'Tratamento Cadastrado', 'Tratamento numero 230'),
(339, '2019-04-29 20:19:45', 'Jade Costa', 'Tipo de pagamento Cadastrado', 'Tipo de pagamento numero 23'),
(340, '2019-04-30 17:50:00', 'Jade Costa', 'Pagamento de despesas Efetuada', 'Pagamento numero 121'),
(341, '2019-04-30 17:50:12', 'Jade Costa', 'Pagamento de despesas Efetuada', 'Pagamento numero 91'),
(342, '2019-04-30 17:50:23', 'Jade Costa', 'Pagamento de despesas Efetuada', 'Pagamento numero 126'),
(343, '2019-04-30 17:51:04', 'Jade Costa', 'Pagamento de despesas Efetuada', 'Pagamento numero 86'),
(344, '2019-04-30 14:54:35', 'Jade Costa', 'Paciente Cadastrado', 'Cadastro no paciente '),
(345, '2019-04-30 17:56:06', 'Michella', 'Atestado Cadastrado', 'Atestado no Paciente 169'),
(346, '2019-04-30 22:01:41', '', 'Procedimento de Tratamento Cadastrado', 'Procedimento numero 26'),
(347, '2019-04-30 19:02:18', 'Jade Costa', 'Tratamento Cadastrado', 'Tratamento numero 233'),
(348, '2019-04-30 22:02:56', '', 'Atendimento Iniciado', 'Atendimento numero '),
(349, '2019-05-02 17:13:13', 'Jade Costa', 'Parcela Paga', 'Pagamento de parcela numero 72'),
(350, '2019-05-02 14:15:11', 'Jade Costa', 'Paciente Editado', 'Cadastro no paciente 42'),
(351, '2019-05-02 17:46:49', '', 'Procedimento de Tratamento Cadastrado', 'Procedimento numero 3'),
(352, '2019-05-02 18:52:09', '', 'Procedimento de Tratamento Cadastrado', 'Procedimento numero 20'),
(353, '2019-05-02 15:53:16', 'Jade Costa', 'Tratamento Cadastrado', 'Tratamento numero 235'),
(354, '2019-05-02 18:53:26', '', 'Atendimento Iniciado', 'Atendimento numero '),
(355, '2019-05-02 16:49:58', 'Jade Costa', 'Paciente Cadastrado', 'Cadastro no paciente '),
(356, '2019-05-03 09:55:09', 'Jade Costa', 'Paciente Cadastrado', 'Cadastro no paciente '),
(357, '2019-05-03 13:03:46', '', 'Procedimento de Tratamento Cadastrado', 'Procedimento numero 3'),
(358, '2019-05-03 13:06:35', '', 'Procedimento de Tratamento Cadastrado', 'Procedimento numero 27'),
(359, '2019-05-03 13:09:22', '', 'Procedimento de Tratamento Cadastrado', 'Procedimento numero 29'),
(360, '2019-05-03 13:09:44', '', 'Procedimento de Tratamento Cadastrado', 'Procedimento numero 30'),
(361, '2019-05-03 10:10:21', 'Jade Costa', 'Tratamento Cadastrado', 'Tratamento numero 236'),
(362, '2019-05-03 13:10:32', '', 'Atendimento Iniciado', 'Atendimento numero '),
(363, '2019-05-03 13:11:41', '', 'Procedimento de Tratamento Cadastrado', 'Procedimento numero 1'),
(364, '2019-05-03 10:12:14', 'Jade Costa', 'Tratamento Cadastrado', 'Tratamento numero 237'),
(365, '2019-05-03 13:12:33', '', 'Atendimento Iniciado', 'Atendimento numero '),
(366, '2019-05-03 13:16:21', 'Jade Costa', 'Tipo de pagamento Cadastrado', 'Tipo de pagamento numero 24'),
(367, '2019-05-03 13:17:17', 'Jade Costa', 'Pagamento de despesas Efetuada', 'Pagamento numero 133'),
(368, '2019-05-03 13:17:25', 'Jade Costa', 'Pagamento de despesas Efetuada', 'Pagamento numero 134'),
(369, '2019-05-03 11:02:19', 'Jade Costa', 'Paciente Editado', 'Cadastro no paciente 164'),
(370, '2019-05-03 14:14:03', '', 'Procedimento de Tratamento Cadastrado', 'Procedimento numero 6'),
(371, '2019-05-03 11:14:25', 'Jade Costa', 'Tratamento Cadastrado', 'Tratamento numero 238'),
(372, '2019-05-03 14:15:17', '', 'Atendimento Iniciado', 'Atendimento numero '),
(373, '2019-05-03 14:04:09', 'Admin', 'Paciente Cadastrado', 'Cadastro no paciente '),
(374, '2019-05-03 17:07:08', '', 'Procedimento de Tratamento Cadastrado', 'Procedimento numero 22'),
(375, '2019-05-03 14:07:46', 'Admin', 'Tratamento Cadastrado', 'Tratamento numero 239'),
(376, '2019-05-03 17:07:55', '', 'Atendimento Iniciado', 'Atendimento numero '),
(377, '2019-05-03 17:44:21', '', 'Atendimento Iniciado', 'Atendimento numero '),
(378, '2019-05-03 17:45:50', '', 'Procedimento de Tratamento Cadastrado', 'Procedimento numero 3'),
(379, '2019-05-03 14:45:59', 'Admin', 'Tratamento Cadastrado', 'Tratamento numero 240'),
(380, '2019-05-03 17:49:20', '', 'Procedimento de Tratamento Cadastrado', 'Procedimento numero 6'),
(381, '2019-05-03 14:49:29', 'Admin', 'Tratamento Cadastrado', 'Tratamento numero 241'),
(382, '2019-05-03 17:49:42', '', 'Atendimento Iniciado', 'Atendimento numero '),
(383, '2019-05-03 17:49:55', '', 'Atendimento Iniciado', 'Atendimento numero '),
(384, '2019-05-03 17:51:46', '', 'Atendimento Iniciado', 'Atendimento numero '),
(385, '2019-05-03 14:53:14', '', 'Atendimento Iniciado', 'Atendimento numero '),
(386, '2019-05-03 14:54:55', '', 'Procedimento de Tratamento Cadastrado', 'Procedimento numero 3'),
(387, '2019-05-03 14:55:11', 'Admin', 'Tratamento Cadastrado', 'Tratamento numero 242'),
(388, '2019-05-03 14:55:20', '', 'Atendimento Iniciado', 'Atendimento numero '),
(389, '2019-05-03 16:23:20', 'Jade Costa', 'Paciente Cadastrado', 'Cadastro no paciente '),
(390, '2019-05-06 15:48:59', 'Jade Costa', 'Paciente Cadastrado', 'Cadastro no paciente '),
(391, '2019-05-06 18:23:42', '', 'Procedimento de Tratamento Cadastrado', 'Procedimento numero 3'),
(392, '2019-05-06 18:24:15', '', 'Procedimento de Tratamento Cadastrado', 'Procedimento numero 1'),
(393, '2019-05-06 18:24:29', '', 'Procedimento de Tratamento Cadastrado', 'Procedimento numero 1'),
(394, '2019-05-06 18:25:15', 'Jade Costa', 'Tratamento Cadastrado', 'Tratamento numero 243'),
(395, '2019-05-06 18:25:24', '', 'Atendimento Iniciado', 'Atendimento numero '),
(396, '2019-05-06 18:29:35', 'Jade Costa', 'Parcela Paga', 'Pagamento de parcela numero 68'),
(397, '2019-05-07 14:44:13', 'Jade Costa', 'Pagamento de despesas Efetuada', 'Pagamento numero 122'),
(398, '2019-05-07 14:44:24', 'Jade Costa', 'Pagamento de despesas Efetuada', 'Pagamento numero 123'),
(399, '2019-05-07 14:49:12', 'Jade Costa', 'Parcela Paga', 'Pagamento de parcela numero 56'),
(400, '2019-05-07 15:07:39', 'Jade Costa', 'Pagamento Cancelado', 'Pagamento numero 15'),
(401, '2019-05-07 15:09:02', 'Admin', 'Pagamento de despesas Efetuada', 'Pagamento numero 16'),
(402, '2019-05-07 15:27:41', '', 'Atendimento Iniciado', 'Atendimento numero 11'),
(403, '2019-05-07 15:30:17', 'Michella', 'Receita Cadastrada', 'Receita numero 44 no Paciente 99'),
(404, '2019-05-08 12:52:08', '', 'Procedimento de Tratamento Cadastrado', 'Procedimento numero 31'),
(405, '2019-05-08 12:52:32', 'Jade Costa', 'Tratamento Cadastrado', 'Tratamento numero 245'),
(406, '2019-05-08 12:52:57', '', 'Procedimento de Tratamento Cadastrado', 'Procedimento numero 3'),
(407, '2019-05-08 12:53:10', '', 'Procedimento de Tratamento Cadastrado', 'Procedimento numero 14'),
(408, '2019-05-08 12:54:09', 'Jade Costa', 'Tratamento Cadastrado', 'Tratamento numero 246'),
(409, '2019-05-08 12:54:16', '', 'Atendimento Iniciado', 'Atendimento numero '),
(410, '2019-05-08 12:54:28', 'Jade Costa', 'Parcela Paga', 'Pagamento de parcela numero 103'),
(411, '2019-05-08 12:54:37', 'Jade Costa', 'Parcela Paga', 'Pagamento de parcela numero 104'),
(412, '2019-05-08 17:04:50', 'Jade Costa', 'Parcela Paga', 'Pagamento de parcela numero 71'),
(413, '2019-05-09 09:27:15', 'Jade Costa', 'Parcela Paga', 'Pagamento de parcela numero 43'),
(414, '2019-05-09 11:17:11', 'Jade Costa', 'Paciente Cadastrado', 'Cadastro no paciente '),
(415, '2019-05-09 13:30:03', 'Admin', 'Receita Cadastrada', 'Receita numero 46 no Paciente 104'),
(416, '2019-05-09 15:26:36', 'Admin', 'Receita Cadastrada', 'Receita numero '),
(417, '2019-05-09 15:27:05', 'Admin', 'Parcela Paga', 'Pagamento de Receita numero 57'),
(418, '2019-05-10 10:57:25', 'Jade Costa', 'Pagamento de despesas Efetuada', 'Pagamento numero 90'),
(419, '2019-05-10 10:57:48', 'Jade Costa', 'Pagamento de despesas Efetuada', 'Pagamento numero 130'),
(420, '2019-05-10 10:59:06', 'Jade Costa', 'Pagamento de despesas Efetuada', 'Pagamento numero 137'),
(421, '2019-05-10 10:59:16', 'Jade Costa', 'Pagamento de despesas Efetuada', 'Pagamento numero 136'),
(422, '2019-05-10 12:02:32', '', 'Atendimento Iniciado', 'Atendimento numero '),
(423, '2019-05-10 17:48:31', 'Jade Costa', 'Pagamento de despesas Efetuada', 'Pagamento numero 124'),
(424, '2019-05-10 18:21:50', 'Jade Costa', 'Tipo de pagamento Cadastrado', 'Tipo de pagamento numero 25'),
(425, '2019-05-10 18:22:42', 'Jade Costa', 'Pagamento de despesas Efetuada', 'Pagamento numero 138'),
(426, '2019-05-13 10:16:01', 'Jade Costa', 'Paciente Cadastrado', 'Cadastro no paciente '),
(427, '2019-05-13 10:17:11', '', 'Procedimento de Tratamento Cadastrado', 'Procedimento numero 22'),
(428, '2019-05-13 10:17:28', '', 'Procedimento de Tratamento Cadastrado', 'Procedimento numero 14'),
(429, '2019-05-13 10:18:04', 'Jade Costa', 'Tratamento Cadastrado', 'Tratamento numero 247'),
(430, '2019-05-13 10:18:13', '', 'Atendimento Iniciado', 'Atendimento numero '),
(431, '2019-05-13 10:18:39', 'Jade Costa', 'Parcela Paga', 'Pagamento de parcela numero 105'),
(432, '2019-05-14 16:48:41', 'Jade Costa', 'Paciente Cadastrado', 'Cadastro no paciente '),
(433, '2019-05-14 17:23:59', '', 'Procedimento de Tratamento Cadastrado', 'Procedimento numero 3'),
(434, '2019-05-14 17:24:36', 'Jade Costa', 'Tratamento Cadastrado', 'Tratamento numero 248'),
(435, '2019-05-16 14:25:36', '', 'Atendimento Iniciado', 'Atendimento numero '),
(436, '2019-05-17 15:02:44', 'Jade Costa', 'Paciente Cadastrado', 'Cadastro no paciente '),
(437, '2019-05-17 16:08:41', '', 'Procedimento de Tratamento Cadastrado', 'Procedimento numero 3'),
(438, '2019-05-17 16:09:09', '', 'Procedimento de Tratamento Cadastrado', 'Procedimento numero 1'),
(439, '2019-05-17 16:09:31', '', 'Procedimento de Tratamento Cadastrado', 'Procedimento numero 4'),
(440, '2019-05-17 16:09:47', '', 'Procedimento de Tratamento Cadastrado', 'Procedimento numero 6'),
(441, '2019-05-17 16:09:58', '', 'Procedimento de Tratamento Cadastrado', 'Procedimento numero 31'),
(442, '2019-05-20 13:44:46', 'Jade Costa', 'Pagamento de despesas Efetuada', 'Pagamento numero 131'),
(443, '2019-05-20 13:55:41', 'Jade Costa', 'Tipo de pagamento Cadastrado', 'Tipo de pagamento numero 26'),
(444, '2019-05-20 13:57:34', 'Jade Costa', 'Tipo de pagamento Cadastrado', 'Tipo de pagamento numero 27'),
(445, '2019-05-20 13:58:15', 'Jade Costa', 'Pagamento de despesas Efetuada', 'Pagamento numero 141'),
(446, '2019-05-20 14:07:14', 'Jade Costa', 'Paciente Cadastrado', 'Cadastro no paciente '),
(447, '2019-05-20 15:10:31', '', 'Procedimento de Tratamento Cadastrado', 'Procedimento numero 31'),
(448, '2019-05-20 15:10:55', 'Jade Costa', 'Tratamento Cadastrado', 'Tratamento numero 250'),
(449, '2019-05-20 15:18:10', '', 'Atendimento Iniciado', 'Atendimento numero '),
(450, '2019-05-20 15:19:11', 'Jade Costa', 'Parcela Paga', 'Pagamento de parcela numero 107'),
(451, '2019-05-21 10:52:15', 'Jade Costa', 'Parcela Paga', 'Pagamento de parcela numero 40'),
(452, '2019-05-21 10:52:29', 'Jade Costa', 'Pagamento de despesas Efetuada', 'Pagamento numero 102'),
(453, '2019-05-21 10:54:54', 'Jade Costa', 'Pagamento de despesas Efetuada', 'Pagamento numero 142'),
(454, '2019-05-22 14:10:53', 'Jade Costa', 'Pagamento de despesas Efetuada', 'Pagamento numero 139'),
(455, '2019-05-22 14:11:06', 'Jade Costa', 'Pagamento de despesas Efetuada', 'Pagamento numero 125'),
(456, '2019-06-05 14:27:49', 'Jade Costa', 'Parcela Paga', 'Pagamento de parcela numero 51'),
(457, '2019-06-05 14:29:29', 'Jade Costa', 'Parcela Paga', 'Pagamento de parcela numero 66'),
(458, '2019-06-05 14:29:39', 'Jade Costa', 'Parcela Paga', 'Pagamento de parcela numero 58'),
(459, '2019-06-05 14:29:49', 'Jade Costa', 'Parcela Paga', 'Pagamento de parcela numero 76'),
(460, '2019-06-05 14:29:59', 'Jade Costa', 'Parcela Paga', 'Pagamento de parcela numero 83'),
(461, '2019-06-05 14:30:07', 'Jade Costa', 'Parcela Paga', 'Pagamento de parcela numero 90'),
(462, '2019-06-05 14:30:20', 'Jade Costa', 'Parcela Paga', 'Pagamento de parcela numero 73'),
(463, '2019-06-05 14:30:32', 'Jade Costa', 'Parcela Paga', 'Pagamento de parcela numero 69'),
(464, '2019-06-05 14:30:47', 'Jade Costa', 'Pagamento de despesas Efetuada', 'Pagamento numero 140'),
(465, '2019-06-05 14:30:57', 'Jade Costa', 'Pagamento de despesas Efetuada', 'Pagamento numero 129'),
(466, '2019-06-05 14:31:06', 'Jade Costa', 'Pagamento de despesas Efetuada', 'Pagamento numero 128'),
(467, '2019-06-05 15:01:45', 'Jade Costa', 'Pagamento de despesas Efetuada', 'Pagamento numero 120'),
(468, '2019-06-06 16:45:22', 'Jade Costa', 'Parcela Paga', 'Pagamento de parcela numero 98'),
(469, '2019-06-06 16:58:22', 'Jade Costa', 'Paciente Cadastrado', 'Cadastro no paciente '),
(470, '2019-06-06 17:39:57', 'Jade Costa', 'Paciente Editado', 'Cadastro no paciente 180'),
(471, '2019-06-06 17:42:16', '', 'Procedimento de Tratamento Cadastrado', 'Procedimento numero 3'),
(472, '2019-06-10 11:56:22', 'Jade Costa', 'Pagamento de despesas Efetuada', 'Pagamento numero 104'),
(473, '2019-06-10 11:56:37', 'Jade Costa', 'Parcela Paga', 'Pagamento de parcela numero 44'),
(474, '2019-07-02 14:25:02', 'Dionisio', 'Tipo de pagamento Cadastrado', 'Tipo de pagamento numero 28'),
(475, '2019-07-02 14:42:11', 'Dionisio', 'Tipo de pagamento Cadastrado', 'Tipo de pagamento numero 29'),
(476, '2019-07-02 14:53:46', 'Dionisio', 'Pagamento Cancelado', 'Pagamento numero 90'),
(477, '2019-07-03 15:44:17', 'Dionisio', 'Tipo de pagamento Cadastrado', 'Tipo de pagamento numero 30'),
(478, '2019-07-05 14:29:05', 'Dionisio', 'Tipo de pagamento Cadastrado', 'Tipo de pagamento numero 31'),
(479, '2019-07-18 14:38:43', 'Dionisio', 'Tipo de pagamento Cadastrado', 'Tipo de pagamento numero 8'),
(480, '2019-07-24 18:24:03', 'Dionisio', 'Tipo de pagamento Cadastrado', 'Tipo de pagamento numero 32');

-- --------------------------------------------------------

--
-- Estrutura da tabela `medicamento`
--

CREATE TABLE `medicamento` (
  `idmedicamento` int(5) NOT NULL,
  `descricaomed` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `medicamento`
--

INSERT INTO `medicamento` (`idmedicamento`, `descricaomed`) VALUES
(1, 'Azitromicina'),
(2, 'Dexametasona'),
(3, 'Tylenol'),
(4, 'Hirudoid'),
(5, 'Lisador'),
(6, 'Cicatrimed'),
(7, 'Cloridrato de Ciprofloxacino'),
(8, 'Diprogenta'),
(9, 'Clavulin BD'),
(10, 'Gluconato de clorexidina'),
(11, 'Kuramed Spray'),
(12, 'Toragesic'),
(13, 'Duoloxetina');

-- --------------------------------------------------------

--
-- Estrutura da tabela `procedimento`
--

CREATE TABLE `procedimento` (
  `idprocedimento` int(10) UNSIGNED NOT NULL,
  `descricao` varchar(150) NOT NULL,
  `valor` decimal(10,2) NOT NULL,
  `data_cadastro` datetime NOT NULL,
  `resp_cadastro` varchar(20) NOT NULL,
  `iddentista` int(11) NOT NULL,
  `data_edicao` datetime DEFAULT NULL,
  `editado_por` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `procedimento`
--

INSERT INTO `procedimento` (`idprocedimento`, `descricao`, `valor`, `data_cadastro`, `resp_cadastro`, `iddentista`, `data_edicao`, `editado_por`) VALUES
(1, 'Preenchimento', 1500.00, '2019-02-05 01:21:00', 'funcionario', 5, '2019-04-08 00:00:00', 'Admin'),
(2, 'Bichectomia', 2500.00, '2019-02-05 01:22:00', 'funcionario', 5, NULL, NULL),
(3, 'Botox', 1000.00, '2019-02-05 01:27:00', 'funcionario', 5, '2019-04-18 00:00:00', 'Jade Costa'),
(4, 'Fios de Lifting', 300.00, '2019-02-05 01:28:00', 'funcionario', 5, NULL, NULL),
(5, 'Microagulhamento', 250.00, '2019-02-05 01:29:00', 'funcionario', 5, NULL, NULL),
(6, 'Papada', 300.00, '2019-02-05 01:30:00', 'funcionario', 5, NULL, NULL),
(10, 'Botox Boca', 950.00, '2019-04-22 00:00:00', 'Jade Costa', 5, NULL, NULL),
(11, 'Bigode Chines ', 900.00, '2019-04-22 00:00:00', 'Jade Costa', 5, NULL, NULL),
(12, 'Botox Testa', 950.00, '2019-04-22 00:00:00', 'Jade Costa', 5, NULL, NULL),
(13, 'Botox Bruxismo', 1000.00, '2019-04-22 00:00:00', 'Jade Costa', 5, NULL, NULL),
(14, 'Preenchimento Olheira ', 1000.00, '2019-04-22 00:00:00', 'Jade Costa', 5, NULL, NULL),
(15, 'RinomodelaÃ§Ã£o ', 1000.00, '2019-04-22 00:00:00', 'Jade Costa', 5, NULL, NULL),
(16, 'Preenchimento ZigomÃ¡tico ', 900.00, '2019-04-22 00:00:00', 'Jade Costa', 5, NULL, NULL),
(17, 'Preenchimento malar', 900.00, '2019-04-22 00:00:00', 'Jade Costa', 5, NULL, NULL),
(18, 'Preenchimento bigode', 900.00, '2019-04-22 00:00:00', 'Jade Costa', 5, NULL, NULL),
(19, 'Fios de PDO', 300.00, '2019-04-22 00:00:00', 'Jade Costa', 5, NULL, NULL),
(20, 'NCTF', 700.00, '2019-04-23 00:00:00', 'Jade Costa', 5, NULL, NULL),
(22, 'Preenchimento boca', 1000.00, '2019-04-25 18:41:00', 'Jade Costa', 5, NULL, NULL),
(23, 'Preenchimento Queixo ', 1000.00, '2019-04-26 12:55:00', 'Jade Costa', 5, NULL, NULL),
(24, '1 Seringa ', 90000.00, '2019-04-26 12:57:00', 'Jade Costa', 5, NULL, NULL),
(25, 'Preenchimento Lacrimal ', 1000.00, '2019-04-29 20:10:00', 'Jade Costa', 5, NULL, NULL),
(26, 'Preenchimento maÃ§a + zigomÃ¡tico + sulco + rulga de marionete', 2000.00, '2019-04-30 22:01:00', 'Jade Costa', 5, NULL, NULL),
(27, 'Preenchimento nariz', 1000.00, '2019-05-03 13:05:00', 'Jade Costa', 5, NULL, NULL),
(28, 'Preenchimento maÃ§a + fio p asa do nariz', 1500.00, '2019-05-03 13:06:00', 'Jade Costa', 5, NULL, NULL),
(29, 'Preenchimento maÃ§a ', 2000.00, '2019-05-03 13:08:00', 'Jade Costa', 5, NULL, NULL),
(30, 'Fio para asa do nariz', 1500.00, '2019-05-03 13:08:00', 'Jade Costa', 5, NULL, NULL),
(31, 'AvaliaÃ§Ã£o', 50.00, '2019-05-08 12:51:00', 'Jade Costa', 5, NULL, NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `procedimento_tratamento`
--

CREATE TABLE `procedimento_tratamento` (
  `id` int(11) NOT NULL,
  `idtratamento` int(11) DEFAULT NULL,
  `idprocedimento` int(11) DEFAULT NULL,
  `dente` varchar(5) DEFAULT NULL,
  `face` varchar(3) DEFAULT NULL,
  `valor` decimal(10,2) DEFAULT NULL,
  `idstatustrat` tinyint(3) NOT NULL,
  `obs` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `procedimento_tratamento`
--

INSERT INTO `procedimento_tratamento` (`id`, `idtratamento`, `idprocedimento`, `dente`, `face`, `valor`, `idstatustrat`, `obs`) VALUES
(15, 200, 3, '', '', 1200.00, 1, NULL),
(16, 200, 4, '', '', 300.00, 1, NULL),
(17, 201, 4, '', '', 300.00, 1, NULL),
(18, 203, 3, '', '', 950.00, 1, NULL),
(19, 203, 3, '', '', 900.00, 1, NULL),
(20, 203, 1, '', '', 1000.00, 1, NULL),
(21, 203, 1, '', '', 1000.00, 1, NULL),
(22, 203, 1, '', '', 1500.00, 1, NULL),
(23, 203, 1, '', '', 1000.00, 1, NULL),
(24, 204, 2, '', '', 2500.00, 1, NULL),
(25, 205, 1, '', '', 1500.00, 1, NULL),
(26, 207, 3, '', '', 950.00, 1, NULL),
(27, 207, 6, '', '', 900.00, 1, NULL),
(28, 208, 15, '', '', 1000.00, 1, NULL),
(29, 208, 3, '', '', 950.00, 1, NULL),
(30, 209, 15, '', '', 1000.00, 1, NULL),
(31, 210, 3, '', '', 950.00, 1, NULL),
(32, 213, 3, '', '', 900.00, 1, NULL),
(33, 213, 16, '', '', 900.00, 1, NULL),
(34, 213, 17, '', '', 900.00, 1, NULL),
(35, 213, 18, '', '', 900.00, 1, NULL),
(36, 213, 1, '', '', 900.00, 1, NULL),
(37, 213, 1, '', '', 900.00, 1, NULL),
(38, 213, 19, '', '', 900.00, 1, NULL),
(39, 214, 6, '', '', 1800.00, 1, NULL),
(40, 215, 11, '', '', 900.00, 1, NULL),
(41, 218, 20, '', '', 700.00, 1, NULL),
(42, 218, 20, '', '', 700.00, 1, NULL),
(43, 218, 20, '', '', 700.00, 1, NULL),
(44, 219, 3, '', '', 950.00, 1, NULL),
(45, 219, 1, '', '', 1000.00, 1, NULL),
(46, 221, 11, '', '', 1000.00, 1, NULL),
(47, 223, 1, '', '', 3000.00, 1, NULL),
(48, 223, 1, '', '', 3000.00, 1, NULL),
(49, 223, 3, '', '', 950.00, 1, NULL),
(50, 224, 1, '', '', 2000.00, 1, NULL),
(51, 224, 22, '', '', 1000.00, 1, NULL),
(52, 224, 3, '', '', 950.00, 1, NULL),
(53, 226, 23, '', '', 1000.00, 1, NULL),
(54, 226, 24, '', '', 900.00, 1, NULL),
(55, 227, 22, '', '', 600.00, 1, NULL),
(56, 227, 12, '', '', 600.00, 1, NULL),
(57, 228, 3, '', '', 950.00, 1, NULL),
(58, 229, 3, '', '', 950.00, 1, NULL),
(59, 230, 3, '', '', 950.00, 1, NULL),
(60, 230, 25, '', '', 1000.00, 1, NULL),
(61, 233, 26, '', '', 2000.00, 1, NULL),
(62, 234, 3, '', '', 950.00, 1, NULL),
(63, 235, 20, '', '', 600.00, 1, NULL),
(64, 236, 3, '', '', 950.00, 1, NULL),
(65, 236, 27, '', '', 1000.00, 1, NULL),
(66, 236, 29, '', '', 2000.00, 1, NULL),
(67, 236, 30, '', '', 1500.00, 1, NULL),
(68, 237, 1, '', '', 1000.00, 1, NULL),
(69, 238, 6, '', '', 2000.00, 1, NULL),
(70, 239, 22, '', '', 1000.00, 1, NULL),
(71, 240, 3, '', '', 1000.00, 1, NULL),
(72, 241, 6, '', '', 300.00, 1, NULL),
(73, 242, 3, '', '', 1000.00, 1, NULL),
(74, 243, 3, '', '', 950.00, 1, NULL),
(75, 243, 1, '', '', 1000.00, 1, NULL),
(76, 243, 1, '', '', 1000.00, 1, NULL),
(77, 245, 31, '', '', 50.00, 1, NULL),
(78, 246, 3, '', '', 950.00, 1, NULL),
(79, 246, 14, '', '', 1000.00, 1, NULL),
(80, 247, 22, '', '', 1000.00, 1, ''),
(81, 247, 14, '', '', 1000.00, 1, ''),
(82, 248, 3, '', '', 250.00, 1, 'RegiÃ£o de glabela'),
(83, 249, 3, '', '', 950.00, 1, ''),
(84, 249, 1, '', '', 2000.00, 1, '2ml'),
(85, 249, 4, '', '', 1600.00, 1, '2'),
(86, 249, 6, '', '', 400.00, 1, ''),
(87, 249, 31, '', '', 50.00, 1, ''),
(88, 250, 31, '', '', 50.00, 1, ''),
(89, 251, 3, '', '', 850.00, 1, '');

-- --------------------------------------------------------

--
-- Estrutura da tabela `receita`
--

CREATE TABLE `receita` (
  `idreceita` int(11) NOT NULL,
  `nomerec` varchar(200) DEFAULT NULL,
  `idcliente` int(11) DEFAULT NULL,
  `data_receita` datetime DEFAULT NULL,
  `resp_receita` varchar(30) NOT NULL,
  `iddentista` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `receita`
--

INSERT INTO `receita` (`idreceita`, `nomerec`, `idcliente`, `data_receita`, `resp_receita`, `iddentista`) VALUES
(44, 'Azitro5+Dexa+Tylenol+Hirudoid', 99, '2019-05-07 18:30:17', 'Michella', 5),
(47, NULL, 58, '2019-05-13 18:38:32', '', NULL),
(48, NULL, 82, '2019-06-07 19:34:18', '', NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `receita_medicamento`
--

CREATE TABLE `receita_medicamento` (
  `idrmedicamento` int(11) NOT NULL,
  `idmedicamento` int(11) DEFAULT NULL,
  `tamanho` varchar(30) DEFAULT NULL,
  `qtd` tinyint(5) DEFAULT NULL,
  `unidade` varchar(7) DEFAULT NULL,
  `modo_usar` varchar(200) DEFAULT NULL,
  `idreceita` int(5) DEFAULT NULL,
  `tipouso` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `receita_medicamento`
--

INSERT INTO `receita_medicamento` (`idrmedicamento`, `idmedicamento`, `tamanho`, `qtd`, `unidade`, `modo_usar`, `idreceita`, `tipouso`) VALUES
(60, 1, '500mg', 1, 'cx', 'Tomar 1 (um) comprimido ao dia. Durante 5 dias.', 44, '2'),
(61, 2, '4mg', 1, 'cx', 'Tomar 1 comprimido a cada 12 horas. Durante 7 dias.', 44, '2'),
(62, 3, '759mg', 1, 'cx', 'Tomar um comprimido a cada 4 (horas) durante 7 dias.', 44, '2'),
(63, 4, '40g', 1, 'Pomada', 'Passar sobre os hematomas fazendo leves massagens 3 vezes\nao dia. AtÃ© cessar os sintomas.', 44, '1');

-- --------------------------------------------------------

--
-- Estrutura da tabela `situacao_caixa`
--

CREATE TABLE `situacao_caixa` (
  `idsituacao` tinyint(3) NOT NULL,
  `situacao` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `situacao_caixa`
--

INSERT INTO `situacao_caixa` (`idsituacao`, `situacao`) VALUES
(1, 'Pendente'),
(2, 'Pago'),
(3, 'Cancelado');

-- --------------------------------------------------------

--
-- Estrutura da tabela `status_tratamento`
--

CREATE TABLE `status_tratamento` (
  `idstatustrat` tinyint(3) NOT NULL,
  `status` varchar(40) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `status_tratamento`
--

INSERT INTO `status_tratamento` (`idstatustrat`, `status`) VALUES
(1, 'Em Tratamento'),
(2, 'Finalizado');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tipopg`
--

CREATE TABLE `tipopg` (
  `idtipopg` tinyint(5) NOT NULL,
  `descricao` varchar(40) DEFAULT NULL,
  `data_cadastro` datetime DEFAULT NULL,
  `responsavel` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `tipopg`
--

INSERT INTO `tipopg` (`idtipopg`, `descricao`, `data_cadastro`, `responsavel`) VALUES
(1, 'Padaria', NULL, ''),
(2, 'Copasa', NULL, ''),
(3, 'Cemig', NULL, ''),
(4, 'Unimed', '2019-03-11 00:00:00', 'Admin'),
(5, 'Aluguel', '2019-04-03 00:00:00', 'Admin'),
(6, 'Boleto Contador', '2019-04-18 00:00:00', 'Jade Costa'),
(7, 'Boleto SecretÃ¡rias', '2019-04-18 00:00:00', 'Jade Costa'),
(8, 'CondomÃ­nio ', '2019-04-18 00:00:00', 'Jade Costa'),
(9, 'Boleto Preenchimento ', '2019-04-18 00:00:00', 'Jade Costa'),
(10, 'Boleto Botox', '2019-04-18 00:00:00', 'Jade Costa'),
(11, 'Boleto Internet ', '2019-04-22 00:00:00', 'Jade Costa'),
(12, 'Carro ', '2019-04-23 00:00:00', 'Jade Costa'),
(13, 'Carro ', '2019-04-23 00:00:00', 'Jade Costa'),
(14, 'Copasa', '2019-04-23 00:00:00', 'Jade Costa'),
(15, 'Vinicios ', '2019-04-24 00:00:00', 'Jade Costa'),
(16, 'Tim Michella', '2019-04-24 00:00:00', 'Jade Costa'),
(17, 'Boleto Enzima', '2019-04-24 00:00:00', 'Jade Costa'),
(18, 'Tim ClÃ­nica ', '2019-04-24 00:00:00', 'Jade Costa'),
(19, 'Tim CÃ¢meras', '2019-04-24 00:00:00', 'Jade Costa'),
(20, 'Armazenamento de Dados', '2019-04-24 00:00:00', 'Jade Costa'),
(21, 'Boleto Canulas', '2019-04-24 00:00:00', 'Jade Costa'),
(22, 'Aluguel Ap', '2019-04-24 00:00:00', 'Jade Costa'),
(23, 'Boleto Preenchimento NCTF', '2019-04-29 00:00:00', 'Jade Costa'),
(24, 'Tim ', '2019-05-03 00:00:00', 'Jade Costa'),
(25, 'Tim ', '2019-05-10 00:00:00', 'Jade Costa'),
(26, 'Contador', '2019-05-20 00:00:00', 'Jade Costa'),
(27, 'Boleto Canulas', '2019-05-20 00:00:00', 'Jade Costa'),
(28, 'cemig', '2019-07-02 00:00:00', 'Dionisio'),
(29, 'inet telecom e informatica', '2019-07-02 00:00:00', 'Dionisio'),
(30, 'ALIANCA', '2019-07-03 00:00:00', 'Dionisio'),
(31, 'conselho regional de odontologia', '2019-07-05 00:00:00', 'Dionisio'),
(32, 'perfectha subskin', '2019-07-24 00:00:00', 'Dionisio');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tipopg_recep`
--

CREATE TABLE `tipopg_recep` (
  `idtipopg` tinyint(5) NOT NULL,
  `descricao` varchar(40) DEFAULT NULL,
  `data_cadastro` datetime DEFAULT NULL,
  `responsavel` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `tipopg_recep`
--

INSERT INTO `tipopg_recep` (`idtipopg`, `descricao`, `data_cadastro`, `responsavel`) VALUES
(7, 'Teste', '2019-05-07 00:00:00', 'Admin'),
(8, 'REPASSE', '2019-07-18 00:00:00', 'Dionisio');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tipouso`
--

CREATE TABLE `tipouso` (
  `idtipouso` int(11) NOT NULL,
  `descricao` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `tipouso`
--

INSERT INTO `tipouso` (`idtipouso`, `descricao`) VALUES
(1, 'Topico'),
(2, 'Oral'),
(3, 'Injetavel'),
(4, 'Intramuscular'),
(5, 'Intravenoso'),
(6, 'Subcutaneo');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tratamento`
--

CREATE TABLE `tratamento` (
  `idtratamento` int(10) NOT NULL,
  `idprocedimento` varchar(40) NOT NULL,
  `iddentista` int(3) UNSIGNED DEFAULT NULL,
  `datainicio` date NOT NULL,
  `datafim` date DEFAULT NULL,
  `obs` varchar(50) DEFAULT NULL,
  `status_tratamento` int(3) NOT NULL,
  `idcliente` int(10) NOT NULL,
  `atendente` varchar(30) NOT NULL,
  `datacadastro` datetime NOT NULL,
  `descricao` varchar(45) DEFAULT NULL,
  `nometrat` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `tratamento`
--

INSERT INTO `tratamento` (`idtratamento`, `idprocedimento`, `iddentista`, `datainicio`, `datafim`, `obs`, `status_tratamento`, `idcliente`, `atendente`, `datacadastro`, `descricao`, `nometrat`) VALUES
(203, '', 5, '2019-04-16', '2019-04-23', NULL, 2, 99, 'Jade Costa', '2019-04-18 00:00:00', NULL, 'EstÃ©tica Orofacial'),
(206, '', NULL, '2019-04-18', NULL, NULL, 0, 138, '', '0000-00-00 00:00:00', NULL, ''),
(207, '', 5, '2019-04-17', NULL, NULL, 1, 138, 'Jade Costa', '2019-04-18 00:00:00', NULL, 'EstÃ©tica Orofacial'),
(208, '', NULL, '2019-04-22', NULL, NULL, 0, 149, '', '0000-00-00 00:00:00', NULL, ''),
(209, '', 5, '2019-04-21', NULL, NULL, 1, 149, 'Jade Costa', '2019-04-22 00:00:00', NULL, 'EstÃ©tica Orofacial'),
(210, '', 5, '2019-05-09', NULL, NULL, 1, 149, 'Jade Costa', '2019-04-22 00:00:00', NULL, 'EstÃ©tica Orofacial'),
(211, '', NULL, '2019-04-22', NULL, NULL, 0, 126, '', '0000-00-00 00:00:00', NULL, ''),
(212, '', NULL, '2019-04-22', NULL, NULL, 0, 104, '', '0000-00-00 00:00:00', NULL, ''),
(213, '', 5, '2019-11-07', NULL, NULL, 1, 104, 'Jade Costa', '2019-04-22 00:00:00', NULL, 'EstÃ©tica Orofacial'),
(214, '', 5, '2018-11-30', NULL, NULL, 1, 104, 'Jade Costa', '2019-04-23 00:00:00', NULL, 'EstÃ©tica Orofacial'),
(215, '', 5, '2019-01-10', NULL, NULL, 1, 104, 'Jade Costa', '2019-04-23 00:00:00', NULL, 'EstÃ©tica Orofacial'),
(216, '', NULL, '2019-04-23', NULL, NULL, 0, 104, '', '0000-00-00 00:00:00', NULL, ''),
(217, '', NULL, '2019-04-23', NULL, NULL, 0, 104, '', '0000-00-00 00:00:00', NULL, ''),
(218, '', 5, '2019-03-14', NULL, NULL, 1, 104, 'Jade Costa', '2019-04-23 00:00:00', NULL, 'EstÃ©tica Orofacial'),
(219, '', NULL, '2019-04-23', NULL, NULL, 0, 104, '', '0000-00-00 00:00:00', NULL, ''),
(220, '', NULL, '2019-04-23', NULL, NULL, 0, 99, '', '0000-00-00 00:00:00', NULL, ''),
(221, '', 5, '2019-04-23', NULL, NULL, 1, 43, 'Jade Costa', '2019-04-23 00:00:00', NULL, 'EstÃ©tica Orofacial'),
(222, '', NULL, '2019-04-23', NULL, NULL, 0, 99, '', '0000-00-00 00:00:00', NULL, ''),
(223, '', 5, '2019-04-24', NULL, NULL, 1, 162, 'Jade Costa', '2019-04-24 00:00:00', NULL, 'EstÃ©tica Orofacial'),
(224, '', 5, '2019-07-23', NULL, NULL, 1, 163, 'Jade Costa', '2019-04-25 00:00:00', NULL, 'EstÃ©tica Orofacial'),
(225, '', NULL, '2019-04-26', NULL, NULL, 0, 165, '', '0000-00-00 00:00:00', NULL, ''),
(226, '', 5, '2019-04-25', NULL, NULL, 1, 165, 'Jade Costa', '2019-04-26 00:00:00', NULL, 'EstÃ©tica Orofacial'),
(227, '', 5, '2019-04-25', NULL, NULL, 1, 166, 'Jade Costa', '2019-04-26 00:00:00', NULL, 'EstÃ©tica Orofacial'),
(228, '', 5, '2019-04-05', NULL, NULL, 1, 167, 'Jade Costa', '2019-04-29 00:00:00', NULL, 'EstÃ©tica Orofacial'),
(229, '', NULL, '2019-04-29', NULL, NULL, 0, 91, '', '0000-00-00 00:00:00', NULL, ''),
(230, '', 5, '2019-04-29', NULL, NULL, 1, 168, 'Jade Costa', '2019-04-29 00:00:00', NULL, 'EstÃ©tica Orofacial'),
(231, '', NULL, '2019-04-29', NULL, NULL, 0, 168, '', '0000-00-00 00:00:00', NULL, ''),
(232, '', NULL, '2019-04-30', NULL, NULL, 0, 169, '', '0000-00-00 00:00:00', NULL, ''),
(233, '', 5, '2019-04-30', NULL, NULL, 1, 169, 'Jade Costa', '2019-04-30 00:00:00', NULL, 'EstÃ©tica Orofacial'),
(234, '', NULL, '2019-05-02', NULL, NULL, 0, 63, '', '0000-00-00 00:00:00', NULL, ''),
(235, '', 5, '2019-05-02', NULL, NULL, 1, 42, 'Jade Costa', '2019-05-02 00:00:00', NULL, 'EstÃ©tica Orofacial'),
(236, '', 5, '2019-05-02', NULL, NULL, 1, 171, 'Jade Costa', '2019-05-03 00:00:00', NULL, 'EstÃ©tica Orofacial'),
(237, '', 5, '2019-05-02', NULL, NULL, 1, 170, 'Jade Costa', '2019-05-03 00:00:00', NULL, 'EstÃ©tica Orofacial'),
(238, '', 5, '2019-05-03', NULL, NULL, 1, 164, 'Jade Costa', '2019-05-03 00:00:00', NULL, 'EstÃ©tica Orofacial'),
(243, '', 5, '2019-05-06', NULL, NULL, 1, 174, 'Jade Costa', '2019-05-06 18:24:00', NULL, 'EstÃ©tica Orofacial'),
(244, '', NULL, '2019-05-08', NULL, NULL, 0, 173, '', '0000-00-00 00:00:00', NULL, ''),
(245, '', 5, '2019-05-03', NULL, NULL, 1, 173, 'Jade Costa', '2019-05-08 12:52:00', NULL, 'EstÃ©tica Orofacial'),
(246, '', 5, '2019-05-08', NULL, NULL, 1, 173, 'Jade Costa', '2019-05-08 12:53:00', NULL, 'EstÃ©tica Orofacial'),
(247, '', 5, '2019-05-10', NULL, '', 1, 176, 'Jade Costa', '2019-05-13 10:17:00', NULL, 'EstÃ©tica Orofacial'),
(248, '', 5, '2019-05-14', NULL, '', 1, 177, 'Jade Costa', '2019-05-14 17:23:00', NULL, 'EstÃ©tica Orofacial'),
(249, '', NULL, '2019-05-17', NULL, NULL, 0, 178, '', '0000-00-00 00:00:00', NULL, ''),
(250, '', 5, '2019-05-20', NULL, '', 1, 179, 'Jade Costa', '2019-05-20 15:10:00', NULL, 'EstÃ©tica Orofacial'),
(251, '', NULL, '2019-06-06', NULL, NULL, 0, 180, '', '0000-00-00 00:00:00', NULL, ''),
(252, '', NULL, '2019-07-18', NULL, NULL, 0, 99, '', '0000-00-00 00:00:00', NULL, ''),
(253, '', NULL, '2019-07-19', NULL, NULL, 0, 63, '', '0000-00-00 00:00:00', NULL, '');

-- --------------------------------------------------------

--
-- Estrutura da tabela `unidade_receita`
--

CREATE TABLE `unidade_receita` (
  `idunidade` int(11) NOT NULL,
  `dsunidade` varchar(20) NOT NULL,
  `dsresumido` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `unidade_receita`
--

INSERT INTO `unidade_receita` (`idunidade`, `dsunidade`, `dsresumido`) VALUES
(1, 'Pomada', 'Pm'),
(2, 'Unidade', 'Un'),
(3, 'Caixa', 'Cx');

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuario`
--

CREATE TABLE `usuario` (
  `id_usuario` int(4) NOT NULL,
  `u_nome` varchar(30) NOT NULL,
  `senha` varchar(64) NOT NULL,
  `nivel` int(2) NOT NULL,
  `usuario` varchar(20) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `ativo` int(1) NOT NULL DEFAULT 1,
  `data_cadastro` date NOT NULL,
  `u_nivel` varchar(20) NOT NULL,
  `altera_senha` varchar(3) CHARACTER SET utf8 NOT NULL,
  `iddentista` int(3) NOT NULL,
  `resp_cadastro` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `usuario`
--

INSERT INTO `usuario` (`id_usuario`, `u_nome`, `senha`, `nivel`, `usuario`, `ativo`, `data_cadastro`, `u_nivel`, `altera_senha`, `iddentista`, `resp_cadastro`) VALUES
(1, 'Admin', 'd437de2eae8337645fff3d69abd20e9464b791d9', 10, 'admin', 1, '2018-11-18', 'Administrador', '0', 5, ''),
(2, 'Michella', 'fd7e3716ad98347b60f79af4d3e1050c26106c70', 2, 'michella', 1, '2019-02-05', '', '0', 5, ''),
(6, 'Viviane', 'eab0518a9783864e3385ca878e6b1d66b945a68f', 1, 'viviane', 1, '2019-02-05', '', '0', 0, 'Admin'),
(8, 'Jade Costa', '7cd80548fa235f83c32ed301927630951d0e5bc4', 1, 'Jade', 1, '2019-04-17', '', '0', 0, ''),
(9, 'Dionisio', '0af05cd1cb58284696999f1a79ce8da101be4a03', 1, 'dionisio', 1, '2019-06-26', '', '0', 0, '');

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuario_nivel`
--

CREATE TABLE `usuario_nivel` (
  `idnivel` tinyint(3) NOT NULL,
  `u_nivel` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `usuario_nivel`
--

INSERT INTO `usuario_nivel` (`idnivel`, `u_nivel`) VALUES
(1, 'Funcionario'),
(2, 'Dentista'),
(9, 'DentistaAdm'),
(10, 'Administrador');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `agenda`
--
ALTER TABLE `agenda`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_idcliente` (`idcliente`);

--
-- Índices para tabela `anamnese`
--
ALTER TABLE `anamnese`
  ADD PRIMARY KEY (`idanamnese`),
  ADD KEY `idcliente` (`idcliente`);

--
-- Índices para tabela `atendimento`
--
ALTER TABLE `atendimento`
  ADD PRIMARY KEY (`idatendimento`);

--
-- Índices para tabela `atestado`
--
ALTER TABLE `atestado`
  ADD PRIMARY KEY (`idatestado`);

--
-- Índices para tabela `cidade`
--
ALTER TABLE `cidade`
  ADD PRIMARY KEY (`idcidade`);

--
-- Índices para tabela `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`idcliente`);

--
-- Índices para tabela `cliente_imagens`
--
ALTER TABLE `cliente_imagens`
  ADD PRIMARY KEY (`idimagem`),
  ADD KEY `fk_pimagem_idcliente` (`idcliente`);

--
-- Índices para tabela `contas_pagar`
--
ALTER TABLE `contas_pagar`
  ADD PRIMARY KEY (`idcpagar`),
  ADD KEY `fk_movipagar_id` (`idmovipagar`);

--
-- Índices para tabela `contas_pagar_movi`
--
ALTER TABLE `contas_pagar_movi`
  ADD PRIMARY KEY (`idmovipagar`);

--
-- Índices para tabela `contas_receber`
--
ALTER TABLE `contas_receber`
  ADD PRIMARY KEY (`idparcelas`),
  ADD KEY `fk_parcelas_idmovimento` (`idmovimento`);

--
-- Índices para tabela `contas_receb_movi`
--
ALTER TABLE `contas_receb_movi`
  ADD PRIMARY KEY (`idmovimento`),
  ADD KEY `fk_pagamentos_idcliente` (`idcliente`),
  ADD KEY `fk_tratamento` (`idtratamento`);

--
-- Índices para tabela `contas_recepcao`
--
ALTER TABLE `contas_recepcao`
  ADD PRIMARY KEY (`idcpagar`),
  ADD KEY `fk_movipagar_id` (`idmovipagar`);

--
-- Índices para tabela `contas_recep_movi`
--
ALTER TABLE `contas_recep_movi`
  ADD PRIMARY KEY (`idmovipagar`);

--
-- Índices para tabela `contas_recep_receita`
--
ALTER TABLE `contas_recep_receita`
  ADD PRIMARY KEY (`idparcelas`),
  ADD KEY `fk_parcelas_idmovimento` (`idmovimento`);

--
-- Índices para tabela `contas_recep_receita_movi`
--
ALTER TABLE `contas_recep_receita_movi`
  ADD PRIMARY KEY (`idmovimento`);

--
-- Índices para tabela `dentista`
--
ALTER TABLE `dentista`
  ADD PRIMARY KEY (`iddentista`);

--
-- Índices para tabela `doencas`
--
ALTER TABLE `doencas`
  ADD PRIMARY KEY (`iddoencas`);

--
-- Índices para tabela `especialidade`
--
ALTER TABLE `especialidade`
  ADD PRIMARY KEY (`idespecialidade`);

--
-- Índices para tabela `evolucao`
--
ALTER TABLE `evolucao`
  ADD PRIMARY KEY (`idevolucao`),
  ADD KEY `fk_evo_idtratamento` (`idtratamento`);

--
-- Índices para tabela `formapg`
--
ALTER TABLE `formapg`
  ADD PRIMARY KEY (`idformapg`);

--
-- Índices para tabela `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`logid`),
  ADD KEY `HORA` (`hora`);

--
-- Índices para tabela `medicamento`
--
ALTER TABLE `medicamento`
  ADD PRIMARY KEY (`idmedicamento`);

--
-- Índices para tabela `procedimento`
--
ALTER TABLE `procedimento`
  ADD PRIMARY KEY (`idprocedimento`);

--
-- Índices para tabela `procedimento_tratamento`
--
ALTER TABLE `procedimento_tratamento`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `receita`
--
ALTER TABLE `receita`
  ADD PRIMARY KEY (`idreceita`);

--
-- Índices para tabela `receita_medicamento`
--
ALTER TABLE `receita_medicamento`
  ADD PRIMARY KEY (`idrmedicamento`),
  ADD KEY `fk_receita` (`idreceita`);

--
-- Índices para tabela `situacao_caixa`
--
ALTER TABLE `situacao_caixa`
  ADD PRIMARY KEY (`idsituacao`);

--
-- Índices para tabela `status_tratamento`
--
ALTER TABLE `status_tratamento`
  ADD PRIMARY KEY (`idstatustrat`);

--
-- Índices para tabela `tipopg`
--
ALTER TABLE `tipopg`
  ADD PRIMARY KEY (`idtipopg`);

--
-- Índices para tabela `tipopg_recep`
--
ALTER TABLE `tipopg_recep`
  ADD PRIMARY KEY (`idtipopg`);

--
-- Índices para tabela `tipouso`
--
ALTER TABLE `tipouso`
  ADD PRIMARY KEY (`idtipouso`);

--
-- Índices para tabela `tratamento`
--
ALTER TABLE `tratamento`
  ADD PRIMARY KEY (`idtratamento`),
  ADD KEY `fk_iddentista` (`iddentista`),
  ADD KEY `fk_tratamento_idcliente` (`idcliente`);

--
-- Índices para tabela `unidade_receita`
--
ALTER TABLE `unidade_receita`
  ADD PRIMARY KEY (`idunidade`);

--
-- Índices para tabela `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id_usuario`);

--
-- Índices para tabela `usuario_nivel`
--
ALTER TABLE `usuario_nivel`
  ADD PRIMARY KEY (`idnivel`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `agenda`
--
ALTER TABLE `agenda`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de tabela `anamnese`
--
ALTER TABLE `anamnese`
  MODIFY `idanamnese` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=112;

--
-- AUTO_INCREMENT de tabela `atendimento`
--
ALTER TABLE `atendimento`
  MODIFY `idatendimento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT de tabela `atestado`
--
ALTER TABLE `atestado`
  MODIFY `idatestado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de tabela `cidade`
--
ALTER TABLE `cidade`
  MODIFY `idcidade` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `clientes`
--
ALTER TABLE `clientes`
  MODIFY `idcliente` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=181;

--
-- AUTO_INCREMENT de tabela `cliente_imagens`
--
ALTER TABLE `cliente_imagens`
  MODIFY `idimagem` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT de tabela `contas_pagar`
--
ALTER TABLE `contas_pagar`
  MODIFY `idcpagar` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=178;

--
-- AUTO_INCREMENT de tabela `contas_pagar_movi`
--
ALTER TABLE `contas_pagar_movi`
  MODIFY `idmovipagar` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=105;

--
-- AUTO_INCREMENT de tabela `contas_receber`
--
ALTER TABLE `contas_receber`
  MODIFY `idparcelas` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=108;

--
-- AUTO_INCREMENT de tabela `contas_receb_movi`
--
ALTER TABLE `contas_receb_movi`
  MODIFY `idmovimento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=125;

--
-- AUTO_INCREMENT de tabela `contas_recepcao`
--
ALTER TABLE `contas_recepcao`
  MODIFY `idcpagar` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de tabela `contas_recep_movi`
--
ALTER TABLE `contas_recep_movi`
  MODIFY `idmovipagar` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de tabela `contas_recep_receita`
--
ALTER TABLE `contas_recep_receita`
  MODIFY `idparcelas` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT de tabela `contas_recep_receita_movi`
--
ALTER TABLE `contas_recep_receita_movi`
  MODIFY `idmovimento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `dentista`
--
ALTER TABLE `dentista`
  MODIFY `iddentista` int(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `doencas`
--
ALTER TABLE `doencas`
  MODIFY `iddoencas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de tabela `especialidade`
--
ALTER TABLE `especialidade`
  MODIFY `idespecialidade` tinyint(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de tabela `evolucao`
--
ALTER TABLE `evolucao`
  MODIFY `idevolucao` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de tabela `formapg`
--
ALTER TABLE `formapg`
  MODIFY `idformapg` tinyint(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de tabela `logs`
--
ALTER TABLE `logs`
  MODIFY `logid` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=481;

--
-- AUTO_INCREMENT de tabela `medicamento`
--
ALTER TABLE `medicamento`
  MODIFY `idmedicamento` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de tabela `procedimento`
--
ALTER TABLE `procedimento`
  MODIFY `idprocedimento` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT de tabela `procedimento_tratamento`
--
ALTER TABLE `procedimento_tratamento`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=90;

--
-- AUTO_INCREMENT de tabela `receita`
--
ALTER TABLE `receita`
  MODIFY `idreceita` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT de tabela `receita_medicamento`
--
ALTER TABLE `receita_medicamento`
  MODIFY `idrmedicamento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT de tabela `situacao_caixa`
--
ALTER TABLE `situacao_caixa`
  MODIFY `idsituacao` tinyint(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `tipopg`
--
ALTER TABLE `tipopg`
  MODIFY `idtipopg` tinyint(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT de tabela `tipopg_recep`
--
ALTER TABLE `tipopg_recep`
  MODIFY `idtipopg` tinyint(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de tabela `tipouso`
--
ALTER TABLE `tipouso`
  MODIFY `idtipouso` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de tabela `tratamento`
--
ALTER TABLE `tratamento`
  MODIFY `idtratamento` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=254;

--
-- AUTO_INCREMENT de tabela `unidade_receita`
--
ALTER TABLE `unidade_receita`
  MODIFY `idunidade` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id_usuario` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `agenda`
--
ALTER TABLE `agenda`
  ADD CONSTRAINT `fk_idcliente` FOREIGN KEY (`idcliente`) REFERENCES `clientes` (`idcliente`);

--
-- Limitadores para a tabela `anamnese`
--
ALTER TABLE `anamnese`
  ADD CONSTRAINT `fk_cliente_idcliente` FOREIGN KEY (`idcliente`) REFERENCES `clientes` (`idcliente`);

--
-- Limitadores para a tabela `cliente_imagens`
--
ALTER TABLE `cliente_imagens`
  ADD CONSTRAINT `fk_pimagem_idcliente` FOREIGN KEY (`idcliente`) REFERENCES `clientes` (`idcliente`);

--
-- Limitadores para a tabela `contas_pagar`
--
ALTER TABLE `contas_pagar`
  ADD CONSTRAINT `fk_movipagar_id` FOREIGN KEY (`idmovipagar`) REFERENCES `contas_pagar_movi` (`idmovipagar`);

--
-- Limitadores para a tabela `contas_receber`
--
ALTER TABLE `contas_receber`
  ADD CONSTRAINT `fk_parcelas_idmovimento` FOREIGN KEY (`idmovimento`) REFERENCES `contas_receb_movi` (`idmovimento`);

--
-- Limitadores para a tabela `contas_receb_movi`
--
ALTER TABLE `contas_receb_movi`
  ADD CONSTRAINT `fk_tratamento` FOREIGN KEY (`idtratamento`) REFERENCES `tratamento` (`idtratamento`);

--
-- Limitadores para a tabela `contas_recepcao`
--
ALTER TABLE `contas_recepcao`
  ADD CONSTRAINT `fk_idmovipagar2` FOREIGN KEY (`idmovipagar`) REFERENCES `contas_recep_movi` (`idmovipagar`);

--
-- Limitadores para a tabela `evolucao`
--
ALTER TABLE `evolucao`
  ADD CONSTRAINT `fk_evo_idtratamento` FOREIGN KEY (`idtratamento`) REFERENCES `tratamento` (`idtratamento`) ON DELETE CASCADE;

--
-- Limitadores para a tabela `receita_medicamento`
--
ALTER TABLE `receita_medicamento`
  ADD CONSTRAINT `fk_receita` FOREIGN KEY (`idreceita`) REFERENCES `receita` (`idreceita`) ON DELETE CASCADE;

--
-- Limitadores para a tabela `tratamento`
--
ALTER TABLE `tratamento`
  ADD CONSTRAINT `fk_iddentista` FOREIGN KEY (`iddentista`) REFERENCES `dentista` (`iddentista`),
  ADD CONSTRAINT `fk_tratamento_idcliente` FOREIGN KEY (`idcliente`) REFERENCES `clientes` (`idcliente`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
