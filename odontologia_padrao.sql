-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 04-Fev-2019 às 21:32
-- Versão do servidor: 10.1.37-MariaDB
-- versão do PHP: 7.1.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `odontologia`
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
  `tipo` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `agenda`
--

INSERT INTO `agenda` (`id`, `title`, `start`, `end`, `idcliente`, `resp_agenda`, `color`, `tipo`) VALUES
(2, 'Teste', '2018-12-25 09:00:00', '2018-12-25 09:30:00', NULL, '', '#1C1C1C', ''),
(3, 'Natalia Ramalho', '2018-12-27 14:00:00', '2018-12-27 16:00:00', 14, '', '#228B22', ''),
(4, 'Natalia Lilian Ramal', '2019-01-02 08:00:00', '2019-01-02 09:30:00', 14, 'funcionario', '#FF4500', ''),
(6, 'Natalia Ramalho', '2019-01-08 09:00:00', '2019-01-08 09:30:00', NULL, 'funcionario', '#228B22', 'Encaixe'),
(7, 'Maruan Bredoff', '2019-01-09 08:30:00', '2019-01-09 09:00:00', NULL, 'funcionario', '#F90000', 'Normal'),
(8, 'Consulta de Rotina Maruan', '2019-01-10 08:30:00', '2019-01-10 09:00:00', NULL, 'funcionario', '#0071c5', 'Normal'),
(9, 'Consulta Nickolas', '2019-01-11 10:00:00', '2019-01-11 10:30:00', NULL, 'funcionario', '#228B22', 'Normal'),
(10, 'Botox de Nickolas', '2019-01-09 10:30:00', '2019-01-09 11:00:00', NULL, 'funcionario', '#228B22', 'Normal'),
(11, 'Maruan Bredoff', '2019-01-16 09:30:00', '2019-01-16 10:00:00', NULL, 'funcionario', '#0071c5', 'Normal'),
(12, 'Giovanni', '2019-01-30 10:00:00', '2019-01-30 10:30:00', NULL, 'Maruan', '#228B22', 'Normal'),
(13, 'Paciente Maruan', '2019-02-04 09:00:00', '2019-02-04 09:30:00', NULL, 'funcionario', '#228B22', 'Normal');

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
(7, 14, 24, '69', '1.55', 28.72, 34.58, '2019-01-01', 'Nao', '', '', 'Nao', '', 'Nao', 'Nao', '', '', '', 'Nao', 'Nao', 'Nao', '', 'Nao', NULL, 'Nao', '', 'Nao', 'Nao', 'Nao', '', 'Nao', '', '12, 4', 'Nao', '', '2019-01-11 00:45:00', 'funcionario'),
(10, 15, 26, '88', '1.85', 25.71, 20.63, '0000-00-00', 'Nao', '', '', 'Nao', '', 'Nao', 'Nao', '', '', '', 'Sim', 'Nao', 'Nao', '', 'Nao', NULL, 'Nao', '', 'Nao', 'Nao', 'Nao', '', 'Nao', '', '4, 8, 12', 'Nao', '', '2018-12-23 13:31:00', 'funcionario'),
(11, 1, 30, '70', '1.80', 21.6, 16.62, '0000-00-00', 'Nao', '', '', 'Nao', '', 'Nao', 'Nao', '', '', '', 'Nao', 'Sim', 'Nao', '', 'Nao', NULL, 'Nao', '', 'Nao', 'Nao', 'Sim', '', 'Nao', '', '1, 4, 8', 'Nao', '', '2019-01-11 12:35:00', 'funcionario');

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
(1, 'Maruan Gomes Bredoff Ramalho de Oliveira', '07718939650', 'mg.17.686.466', 'Masculino', '1988-12-05', 'Rua Trinta e TrÃªs', '30', 'Mucuri', 'MG', 'TeÃ³filo Otoni', '39802110', '33988273841', '', 'maruanworkti@gmail.com', '2018-11-30 20:54:00', '', 0, '', '', '', 'f5bec92c35fec7657e2751fd0dae2881', 'funcionario'),
(14, 'Natalia Lilian Ramal', '09838493848', 'mg1723383', 'Feminino', '1994-03-24', 'Rua Trinta e TrÃªs', '306', 'Mucuri', 'MG', 'TeÃ³filo Otoni', '39802110', '33988152694', '3335236463', 'nataliaramalhooliv@gmail.com', '2018-12-11 22:09:00', '', NULL, NULL, NULL, NULL, 'ad6ac31a209cfc615cf07c35ea767f5d.jpg', 'funcionario'),
(15, 'Vinicius Ramalho', '07718939483', 'mg16273647', 'Masculino', '1992-04-22', 'Rua SebastiÃ£o Vieira Colen', '30', 'Jardim Iracema', 'MG', 'TeÃ³filo Otoni', '39801110', '33988173645', '', '', '2018-12-23 13:19:00', '', NULL, NULL, NULL, NULL, '8535d1c14de4759ced71b1f29120589b.jpg', 'funcionario'),
(16, 'Teste Masculino foto', '09919283928', '', 'Masculino', '2019-01-02', 'Rua JoÃ£o Lopes da Silva', '22222', 'Manoel Pimenta', 'MG', 'TeÃ³filo Otoni', '39802184', '33988172847', '33988273837', '', '2019-01-10 06:51:00', '', NULL, NULL, NULL, NULL, '', 'funcionario'),
(18, 'Paciente teste', '077.283.738-27', 'mg-27.817.283', 'Masculino', '1986-04-12', 'Rua Camilo Prates', '400', 'Centro', 'MG', 'TeÃ³filo Otoni', '39800100', '33-98827-3637', '33-3523-4536', '', '2019-01-11 10:48:00', '', NULL, NULL, NULL, NULL, '', 'funcionario'),
(19, 'Teste de cliente', '877.898.987-89', '', 'Feminino', '2019-01-14', 'PraÃ§a Tiradentes', '20', 'Centro', 'MG', 'TeÃ³filo Otoni', '39800001', '33-98827-3837', '', '', '2019-01-17 13:14:00', '', NULL, NULL, NULL, NULL, '', 'funcionario');

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
  `idprocedimento` tinyint(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `cliente_imagens`
--

INSERT INTO `cliente_imagens` (`idimagem`, `nomeimg`, `idcliente`, `foto`, `data_upload`, `idprocedimento`) VALUES
(20, '343434', 19, 'ed686a34545aa981e8db037f6f26ac46angeas.jpg', '2019-02-01 22:50:08', 39),
(21, '343434', 19, '1a1b83a29fa157cb9c032cb0e9bfe7bfps.jpg', '2019-02-01 22:50:36', 127),
(22, 'Teste', 1, 'e363d5b953d85544fe44521ce8fb5814santhemum.jpg', '2019-02-03 14:09:01', 127);

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
(68, '33.33', '2019-12-22', 1, 2, 27, '2019-01-22 00:56:44', 'funcionario'),
(69, '33.33', '2020-01-22', 2, 2, 27, '2019-01-26 21:43:50', 'funcionario'),
(70, '33.33', '2020-02-22', 3, 2, 27, '2019-02-04 17:58:06', 'Admin');

-- --------------------------------------------------------

--
-- Estrutura da tabela `contas_pagar_movi`
--

CREATE TABLE `contas_pagar_movi` (
  `idmovipagar` int(11) NOT NULL,
  `data_movimento` datetime DEFAULT NULL,
  `idtipopg` tinyint(3) NOT NULL,
  `qtdparcelas` tinyint(3) NOT NULL,
  `valor` decimal(10,2) NOT NULL,
  `idformapg` tinyint(3) NOT NULL,
  `resp_cadastro` varchar(30) NOT NULL,
  `num_doc` varchar(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `contas_pagar_movi`
--

INSERT INTO `contas_pagar_movi` (`idmovipagar`, `data_movimento`, `idtipopg`, `qtdparcelas`, `valor`, `idformapg`, `resp_cadastro`, `num_doc`) VALUES
(27, '2019-01-22 00:53:00', 3, 3, '100.00', 1, 'funcionario', '');

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
  `quem_recebeu` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `contas_receber`
--

INSERT INTO `contas_receber` (`idparcelas`, `valor`, `vencimento`, `parcela`, `mensagem`, `idcliente`, `idsituacao`, `idmovimento`, `data_pg`, `quem_recebeu`) VALUES
(10, '240.00', '2019-02-03', 1, '', 18, 1, 82, NULL, ''),
(11, '240.00', '2019-03-03', 2, '', 18, 1, 82, NULL, ''),
(12, '240.00', '2019-02-03', 1, '', 1, 2, 83, '2019-02-04 15:38:55', 'funcionario'),
(13, '240.00', '2019-03-03', 2, '', 1, 1, 83, NULL, '');

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
  `desconto` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `contas_receb_movi`
--

INSERT INTO `contas_receb_movi` (`idmovimento`, `idcliente`, `valor`, `qtdparcelas`, `idtratamento`, `data_movimento`, `idformapg`, `num_doc`, `desconto`) VALUES
(82, 18, '480.00', 2, 180, '2019-02-03 13:44:05', 2, '33454', '40.00'),
(83, 1, '480.00', 2, 181, '2019-02-04 14:31:04', 2, '4443', '0.00');

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
(1, 'Michella Murta', '07738493849', 'mg.17.686.466', '2000-06-01', 'Rua edite leoncio nascimento', 'Minas Gerais', '1', '1', NULL, '(33)988374637', '', 'Masculino', 'cro1234', 1, NULL, NULL, '', '0000-00-00 00:00:00'),
(2, 'Dentista Teste', '07738493849', NULL, '2019-01-02', 'Rua edite leoncio nascimento', 'Minas Gerais', 'Teofilo Otoni', 'MG', '', '(33)988374637', NULL, 'Masculino', 'cro3434', 3, '10.00', 44, '', '2019-02-04 17:07:00'),
(3, 'teste Masculino', '837.847.837-48', NULL, '2019-01-15', 'Rua Manoel LeÃ´ncio Neto', 'Lourival Soares da CostaÂ', '0', '0', '39802123', '33988273847', NULL, 'Masculino', '', 5, '20.00', 0, 'Admin', '0000-00-00 00:00:00');

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

--
-- Extraindo dados da tabela `evolucao`
--

INSERT INTO `evolucao` (`idevolucao`, `evolucao`, `idtratamento`, `foto`, `data_evo`, `resp_evo`, `evo_editado_por`, `data_evo_edicao`, `idprocedtratamento`) VALUES
(3, 'eegegeg', 181, NULL, '2019-02-04 16:08:24', 'Admin', NULL, NULL, 12),
(4, 'fgfhfgh', 181, NULL, '2019-02-04 16:08:38', 'Admin', NULL, NULL, 12),
(5, 'kkkk', 181, NULL, '2019-02-04 16:09:49', 'Admin', NULL, NULL, 12);

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
(5, 'Nota Promissoria');

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
(10, 'Gluconato de clorexidina');

-- --------------------------------------------------------

--
-- Estrutura da tabela `procedimento`
--

CREATE TABLE `procedimento` (
  `idprocedimento` int(10) UNSIGNED NOT NULL,
  `descricao` varchar(150) NOT NULL,
  `valor` decimal(10,2) NOT NULL,
  `data_cadastro` datetime NOT NULL,
  `resp_cadastro` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `procedimento`
--

INSERT INTO `procedimento` (`idprocedimento`, `descricao`, `valor`, `data_cadastro`, `resp_cadastro`) VALUES
(1, 'Condicionamento em Odontologia', '76.80', '2018-12-22 21:31:18', 'admin'),
(2, 'Consulta odontológica ', '96.00', '2018-12-22 21:31:18', 'admin'),
(3, 'Consulta odontológica inicial ', '96.00', '2018-12-22 21:31:19', 'admin'),
(4, 'Consulta para avaliação técnica: auditoria inicial ou final ', '96.00', '2018-12-22 21:31:19', 'admin'),
(5, 'Diagnóstico anatomopatológico em citologia esfoliativa da região BMF', '105.60', '2018-12-22 21:31:19', 'admin'),
(6, 'Diagnóstico anatomopatológico em material de biópsia da região BMF', '105.60', '2018-12-22 21:31:19', 'admin'),
(7, 'Diagnóstico anatomopatológico em peça cirúrgica da região BMF ', '105.60', '2018-12-22 21:31:20', 'admin'),
(8, 'Diagnóstico anatomopatológico em punção da região BMF', '105.60', '2018-12-22 21:31:20', 'admin'),
(9, 'Diagnóstico e planejamento para tratamento odontológico', '192.00', '2018-12-22 21:31:20', 'admin'),
(10, 'Diagnóstico e tratamento da halitose - por sessão', '144.00', '2018-12-22 21:31:20', 'admin'),
(11, 'Diagnóstico e tratamento de estomatite herpética', '124.80', '2018-12-22 21:31:21', 'admin'),
(12, 'Diagnóstico e tratamento de estomatite por candidose', '124.80', '2018-12-22 21:31:21', 'admin'),
(13, 'Diagnóstico e tratamento de xerostomia', '124.80', '2018-12-22 21:31:21', 'admin'),
(14, 'Diagnóstico por meio de enceramento - por arcada', '115.20', '2018-12-22 21:31:21', 'admin'),
(15, 'Diagnóstico por meio de procedimentos laboratoriais', '105.60', '2018-12-22 21:31:22', 'admin'),
(16, 'Fotografia - unidade ', '9.60', '2018-12-22 21:31:22', 'admin'),
(17, 'Modelos ortodônticos - par', '38.40', '2018-12-22 21:31:22', 'admin'),
(18, 'Radiografia da ATM - série completa ', '57.60', '2018-12-22 21:31:23', 'admin'),
(19, 'Radiografia da mão e punho - carpal  ', '48.00', '2018-12-22 21:31:23', 'admin'),
(20, 'Radiografia interproximal - bite-wing', '15.36', '2018-12-22 21:31:23', 'admin'),
(21, 'Radiografia oclusal  ', '38.40', '2018-12-22 21:31:23', 'admin'),
(22, 'Radiografia panorâmica ', '57.60', '2018-12-22 21:31:23', 'admin'),
(23, 'Radiografia periapical ', '15.36', '2018-12-22 21:31:23', 'admin'),
(24, 'Radiografia ânterio-posterior da região BMF', '57.60', '2018-12-22 21:31:23', 'admin'),
(25, 'Radiografia póstero-anterior da região BMF', '57.60', '2018-12-22 21:31:24', 'admin'),
(26, 'Slides - unidade ', '9.60', '2018-12-22 21:31:24', 'admin'),
(27, 'Telerradiografia com traçado computadorizado ', '57.60', '2018-12-22 21:31:24', 'admin'),
(28, 'Telerradiografia sem traçado computadorizado ', '48.00', '2018-12-22 21:31:24', 'admin'),
(29, 'Tomografia computadorizada por feixe cônico - cone beam ', '403.20', '2018-12-22 21:31:24', 'admin'),
(30, 'Tomografia convencional - linear ou multidirecional ', '115.20', '2018-12-22 21:31:24', 'admin'),
(31, 'Alveoloplastia / correção de rebordo residual - por segmento', '364.80', '2018-12-22 21:31:25', 'admin'),
(32, 'Amputação radicular com obturação retrógrada  ', '192.00', '2018-12-22 21:31:25', 'admin'),
(33, 'Amputação radicular sem obturação retrógrada  ', '192.00', '2018-12-22 21:31:25', 'admin'),
(34, 'Apicetomia de caninos ou incisivos ', '240.00', '2018-12-22 21:31:25', 'admin'),
(35, 'Apicetomia de caninos ou incisivos - com obturação retrógrada ', '288.00', '2018-12-22 21:31:26', 'admin'),
(36, 'Apicetomia de molares ', '393.60', '2018-12-22 21:31:27', 'admin'),
(37, 'Apicetomia de molares - com obturação retrógrada ', '441.60', '2018-12-22 21:31:28', 'admin'),
(38, 'Apicetomia de pré-molares ', '288.00', '2018-12-22 21:31:28', 'admin'),
(39, 'Apicetomia de pré-molares - com obturação retrógrada ', '336.00', '2018-12-22 21:31:29', 'admin'),
(40, 'Aprofundamento/aumento de vestíbulo - por segmento ', '432.00', '2018-12-22 21:31:29', 'admin'),
(41, 'Aumento de coroa clínica - por elemento', '288.00', '2018-12-22 21:31:30', 'admin'),
(42, 'Biópsia de boca', '144.00', '2018-12-22 21:31:30', 'admin'),
(43, 'Biópsia de glândula salivar', '144.00', '2018-12-22 21:31:30', 'admin'),
(44, 'Biópsia de lábio', '144.00', '2018-12-22 21:31:30', 'admin'),
(45, 'Biópsia de língua', '144.00', '2018-12-22 21:31:31', 'admin'),
(46, 'Biópsia de mandíbula', '144.00', '2018-12-22 21:31:31', 'admin'),
(47, 'Biópsia de maxila', '144.00', '2018-12-22 21:31:31', 'admin'),
(48, 'Bridectomia', '240.00', '2018-12-22 21:31:31', 'admin'),
(49, 'Bridotomia', '211.20', '2018-12-22 21:31:31', 'admin'),
(50, 'Cirurgia a retalho - por segmento', '288.00', '2018-12-22 21:31:32', 'admin'),
(51, 'Cirurgia com aplicação de aloenxertos - por segmento', '384.00', '2018-12-22 21:31:32', 'admin'),
(52, 'Cirurgia para torus mandibular - bilateral em uma sessão ', '403.20', '2018-12-22 21:31:32', 'admin'),
(53, 'Cirurgia para torus mandibular - unilateral', '240.00', '2018-12-22 21:31:32', 'admin'),
(54, 'Cirurgia para torus palatino', '240.00', '2018-12-22 21:31:33', 'admin'),
(55, 'Cirurgia para tumores odontogênicos - sem reconstrução', '364.80', '2018-12-22 21:31:33', 'admin'),
(56, 'Cirurgia periodontal a retalho - por segmento', '288.00', '2018-12-22 21:31:33', 'admin'),
(57, 'Citologia esfoliativa da região BMF', '96.00', '2018-12-22 21:31:33', 'admin'),
(58, 'Controle de hemorragia com aplicação de agente hemostático', '96.00', '2018-12-22 21:31:33', 'admin'),
(59, 'Controle de hemorragia sem aplicação de agente hemostático', '96.00', '2018-12-22 21:31:34', 'admin'),
(60, 'Controle pós-operatório (por sessão) ', '96.00', '2018-12-22 21:31:34', 'admin'),
(61, 'Criocirurgia de neoplasias da região BMF (por sessão)', '153.60', '2018-12-22 21:31:34', 'admin'),
(62, 'Crioterapia ou termoterapia (por sessão)', '134.40', '2018-12-22 21:31:34', 'admin'),
(63, 'Cunha proximal ', '163.20', '2018-12-22 21:31:35', 'admin'),
(64, 'Drenagem de abscesso hematoma e/ou flegmão da região BMF - extra oral', '144.00', '2018-12-22 21:31:36', 'admin'),
(65, 'Drenagem de abscesso hematoma e/ou flegmão da região BMF - intra oral', '144.00', '2018-12-22 21:31:36', 'admin'),
(66, 'Enxerto com osso autógeno da linha oblíqua - por área enxertada', '768.00', '2018-12-22 21:31:36', 'admin'),
(67, 'Enxerto com osso autógeno do mento - por área enxertada', '672.00', '2018-12-22 21:31:36', 'admin'),
(68, 'Enxerto com osso liofilizado - por área enxertada', '192.00', '2018-12-22 21:31:37', 'admin'),
(69, 'Enxerto conjuntivo subepitelial - por elemento', '432.00', '2018-12-22 21:31:37', 'admin'),
(70, 'Enxerto gengival livre - por elemento', '364.80', '2018-12-22 21:31:37', 'admin'),
(71, 'Enxerto pediculado - por elemento ', '288.00', '2018-12-22 21:31:37', 'admin'),
(72, 'Exérese de  mucocele', '144.00', '2018-12-22 21:31:37', 'admin'),
(73, 'Exérese de cistos odontológicos de mandíbula e maxila', '240.00', '2018-12-22 21:31:38', 'admin'),
(74, 'Exérese de lipoma em região BMF', '240.00', '2018-12-22 21:31:38', 'admin'),
(75, 'Exérese de rânula ', '336.00', '2018-12-22 21:31:38', 'admin'),
(76, 'Exodontia  de raiz residual ', '144.00', '2018-12-22 21:31:38', 'admin'),
(77, 'Exodontia a retalho', '172.80', '2018-12-22 21:31:38', 'admin'),
(78, 'Exodontia de permanente  ', '144.00', '2018-12-22 21:31:38', 'admin'),
(79, 'Exodontia de permanente por indicação ortodôntica/protética ', '172.80', '2018-12-22 21:31:39', 'admin'),
(80, 'Frenulectomia  labial ', '240.00', '2018-12-22 21:31:39', 'admin'),
(81, 'Frenulectomia lingual', '364.80', '2018-12-22 21:31:39', 'admin'),
(82, 'Frenulotomia labial ', '192.00', '2018-12-22 21:31:39', 'admin'),
(83, 'Frenulotomia lingual ', '240.00', '2018-12-22 21:31:39', 'admin'),
(84, 'Gengivectomia - por segmento', '336.00', '2018-12-22 21:31:39', 'admin'),
(85, 'Gengivoplastia - por segmento', '192.00', '2018-12-22 21:31:40', 'admin'),
(86, 'Implante ortodôntico - por unidade', '192.00', '2018-12-22 21:31:40', 'admin'),
(87, 'Implante ósseo integrado - por unidade', '384.00', '2018-12-22 21:31:40', 'admin'),
(88, 'Implante zigomático - por unidade', '576.00', '2018-12-22 21:31:40', 'admin'),
(89, 'Levantamento do seio maxilar com osso autógeno', '768.00', '2018-12-22 21:31:40', 'admin'),
(90, 'Levantamento do seio maxilar com osso homólogo', '576.00', '2018-12-22 21:31:40', 'admin'),
(91, 'Levantamento do seio maxilar com osso liofilizado', '576.00', '2018-12-22 21:31:41', 'admin'),
(92, 'Manutenção de tratamento cirúrgico - por sessão', '96.00', '2018-12-22 21:31:41', 'admin'),
(93, 'Odonto-secção - por elemento', '144.00', '2018-12-22 21:31:41', 'admin'),
(94, 'Punção aspirativa ', '115.20', '2018-12-22 21:31:41', 'admin'),
(95, 'Punção aspirativa orientada por imagem', '115.20', '2018-12-22 21:31:42', 'admin'),
(96, 'Reabertura e colocação de cicratizador implantodôntico - por unidade', '96.00', '2018-12-22 21:31:42', 'admin'),
(97, 'Reconstrução de sulco gengivo-labial - por segmento', '240.00', '2018-12-22 21:31:42', 'admin'),
(98, 'Redução cruenta de fratura álveolo dentária', '288.00', '2018-12-22 21:31:42', 'admin'),
(99, 'Redução incruenta de fratura álveolo dentária', '172.80', '2018-12-22 21:31:43', 'admin'),
(100, 'Reeducação e/ou reabilitação de distúrbios BMF - por sessão', '144.00', '2018-12-22 21:31:43', 'admin'),
(101, 'Reeducação e/ou reabilitação de seqüelas em traumatismos da região BMF - por sessão', '144.00', '2018-12-22 21:31:43', 'admin'),
(102, 'Regeneração tecidual guiada - RTG', '384.00', '2018-12-22 21:31:43', 'admin'),
(103, 'Reimplante dentário com contenção', '384.00', '2018-12-22 21:31:43', 'admin'),
(104, 'Remoção de Dente Incluso / Impactado', '364.80', '2018-12-22 21:31:43', 'admin'),
(105, 'Remoção de dente semi Incluso / impactado', '364.80', '2018-12-22 21:31:44', 'admin'),
(106, 'Remoção de dreno extra-oral', '96.00', '2018-12-22 21:31:44', 'admin'),
(107, 'Remoção de dreno intra-oral', '96.00', '2018-12-22 21:31:44', 'admin'),
(108, 'Remoção de implante não osseo integrado', '134.40', '2018-12-22 21:31:44', 'admin'),
(109, 'Remoção de implante ósseo integrado no seio maxilar', '384.00', '2018-12-22 21:31:44', 'admin'),
(110, 'Remoção de odontoma', '364.80', '2018-12-22 21:31:44', 'admin'),
(111, 'Remoção de tamponamento nasal', '96.00', '2018-12-22 21:31:44', 'admin'),
(112, 'Retirada de corpo estranho oroantral ou oronasal da região BMF', '432.00', '2018-12-22 21:31:45', 'admin'),
(113, 'Retirada de corpo estranho subcutâneo ou submucoso da região BMF', '144.00', '2018-12-22 21:31:45', 'admin'),
(114, 'Retirada dos meios de fixação da região BMF', '144.00', '2018-12-22 21:31:45', 'admin'),
(115, 'Sepultamento radicular (por elemento)', '172.80', '2018-12-22 21:31:45', 'admin'),
(116, 'Sutura de ferida na região BMF', '115.20', '2018-12-22 21:31:45', 'admin'),
(117, 'Tratamento cirúrgico das fistulas buco nasal ou buco sinusal', '336.00', '2018-12-22 21:31:45', 'admin'),
(118, 'Tratamento cirúrgico de bridas constritivas da região BMF - por lesão', '144.00', '2018-12-22 21:31:45', 'admin'),
(119, 'Tratamento cirúrgico dos tumores benignos dos tecidos moles - Por Lesão ', '240.00', '2018-12-22 21:31:45', 'admin'),
(120, 'Tratamento de alveolite ', '96.00', '2018-12-22 21:31:46', 'admin'),
(121, 'Tratamento regenerativo com enxerto de osso autógeno', '672.00', '2018-12-22 21:31:46', 'admin'),
(122, 'Tunelização (por elemento)', '192.00', '2018-12-22 21:31:46', 'admin'),
(123, 'Ulectomia', '96.00', '2018-12-22 21:31:46', 'admin'),
(124, 'Ulotomia ', '76.80', '2018-12-22 21:31:46', 'admin'),
(125, 'Aparelho protetor bucal (por arcada)', '336.00', '2018-12-22 21:31:47', 'admin'),
(126, 'Aplicação de cariostático -1 sessão - duas arcadas', '76.80', '2018-12-22 21:31:47', 'admin'),
(127, 'Aplicação de selante - Técnica invasiva - por elemento', '115.20', '2018-12-22 21:31:47', 'admin'),
(128, 'Aplicação de selante de fóssulas e fissuras - por elemento', '67.20', '2018-12-22 21:31:48', 'admin'),
(129, 'Aplicação tópica de flúor - por arcada', '96.00', '2018-12-22 21:31:48', 'admin'),
(130, 'Aplicação tópica de verniz fluoretado (por arcada)', '38.40', '2018-12-22 21:31:48', 'admin'),
(131, 'Atividade educativa em saude bucal ', '76.80', '2018-12-22 21:31:48', 'admin'),
(132, 'Ativdade educativa para pais e cuidadores', '76.80', '2018-12-22 21:31:48', 'admin'),
(133, 'Controle de biofilme - por sessão', '96.00', '2018-12-22 21:31:48', 'admin'),
(134, 'Controle de cárie incipiente - por consulta trimestral', '96.00', '2018-12-22 21:31:48', 'admin'),
(135, 'Profilaxia e polimento coronário ', '96.00', '2018-12-22 21:31:49', 'admin'),
(136, 'Remineralização - por sessão', '144.00', '2018-12-22 21:31:49', 'admin'),
(137, 'Teste de capacidade tampão da saliva', '67.20', '2018-12-22 21:31:49', 'admin'),
(138, 'Teste de contagem microbiológica', '67.20', '2018-12-22 21:31:49', 'admin'),
(139, 'Teste de fluxo salivar', '67.20', '2018-12-22 21:31:49', 'admin'),
(140, 'Teste de ph salivar', '67.20', '2018-12-22 21:31:49', 'admin'),
(141, 'Adequação do meio bucal - por arcada', '96.00', '2018-12-22 21:31:49', 'admin'),
(142, 'Ajuste oclusal por desgaste seletivo (por sessão)', '115.20', '2018-12-22 21:31:49', 'admin'),
(143, 'Capeamento pulpar direto (excluindo restauração final)', '96.00', '2018-12-22 21:31:50', 'admin'),
(144, 'Clareamento de dente desvitalizado (por sessão)', '105.60', '2018-12-22 21:31:50', 'admin'),
(145, 'Clareamento dentário caseiro (por arcada)', '316.80', '2018-12-22 21:31:50', 'admin'),
(146, 'Clareamento dentário de consultório (por arcada)', '316.80', '2018-12-22 21:31:50', 'admin'),
(147, 'Colagem de fragmentos dentários', '144.00', '2018-12-22 21:31:50', 'admin'),
(148, 'Conserto em prótese total / parcial', '144.00', '2018-12-22 21:31:50', 'admin'),
(149, 'Coroa livre de metal sobre implante em ceramica', '576.00', '2018-12-22 21:31:51', 'admin'),
(150, 'Coroa livre de metal sobre implante em cerômero', '576.00', '2018-12-22 21:31:51', 'admin'),
(151, 'Coroa metalo Cerâmica', '576.00', '2018-12-22 21:31:51', 'admin'),
(152, 'Coroa metalo cerâmica sobre implante', '576.00', '2018-12-22 21:31:51', 'admin'),
(153, 'Coroa metalo plástica (cerômero)', '576.00', '2018-12-22 21:31:51', 'admin'),
(154, 'Coroa metalo-plástica sobre implante (cerômero)', '576.00', '2018-12-22 21:31:51', 'admin'),
(155, 'Coroa provisória (por elemento)', '144.00', '2018-12-22 21:31:51', 'admin'),
(156, 'Coroa provisória prensada (por elemento)', '144.00', '2018-12-22 21:31:51', 'admin'),
(157, 'Coroa provisória sobre implante', '144.00', '2018-12-22 21:31:52', 'admin'),
(158, 'Coroa provisória sobre implante em carga imediata', '144.00', '2018-12-22 21:31:52', 'admin'),
(159, 'Coroa total em Cerâmica Pura ', '576.00', '2018-12-22 21:31:52', 'admin'),
(160, 'Coroa total em cerômero', '576.00', '2018-12-22 21:31:53', 'admin'),
(161, 'Coroa total metálica', '576.00', '2018-12-22 21:31:53', 'admin'),
(162, 'Curativo de demora ', '144.00', '2018-12-22 21:31:54', 'admin'),
(163, 'Dessensibilização dentária (por segmento) ', '96.00', '2018-12-22 21:31:54', 'admin'),
(164, 'Faceta Direta em Resina Fotopolimerizável', '192.00', '2018-12-22 21:31:54', 'admin'),
(165, 'Faceta em cerâmica pura', '384.00', '2018-12-22 21:31:54', 'admin'),
(166, 'Faceta em cerômero', '384.00', '2018-12-22 21:31:54', 'admin'),
(167, 'Guia cirúrgico para implantes', '144.00', '2018-12-22 21:31:55', 'admin'),
(168, 'Guia cirúrgico para prótese total imediata', '144.00', '2018-12-22 21:31:55', 'admin'),
(169, 'Imobilização dentária - decíduo ou permnente', '192.00', '2018-12-22 21:31:55', 'admin'),
(170, 'Intermediário protético para implantes', '192.00', '2018-12-22 21:31:55', 'admin'),
(171, 'Manutenção de prótese sobre implantes ', '76.80', '2018-12-22 21:31:55', 'admin'),
(172, 'Núcleo de Preenchimento', '153.60', '2018-12-22 21:31:55', 'admin'),
(173, 'Núcleo Metálico Fundido', '192.00', '2018-12-22 21:31:55', 'admin'),
(174, 'Órtese Miorrelaxante (placa oclusal estabilizadora)', '432.00', '2018-12-22 21:31:55', 'admin'),
(175, 'Órtese Reposicionadora (placa oclusal reposicionadora)', '528.00', '2018-12-22 21:31:56', 'admin'),
(176, 'Overdenture Barra Clipe ou O\'ring sobre dois implantes', '1152.00', '2018-12-22 21:31:56', 'admin'),
(177, 'Overdenture Barra Clipe ou O\'ring sobre quatro ou mais implantes', '1152.00', '2018-12-22 21:31:56', 'admin'),
(178, 'Overdenture Barra Clipe ou O\'ring sobre três implantes', '1152.00', '2018-12-22 21:31:56', 'admin'),
(179, 'Pino pré-fabricado', '96.00', '2018-12-22 21:31:56', 'admin'),
(180, 'Preparo para Núcleo Intra-radicular', '96.00', '2018-12-22 21:31:57', 'admin'),
(181, 'Prótese fixa adesiva direta provisória (por elemento)', '288.00', '2018-12-22 21:31:57', 'admin'),
(182, 'Prótese fixa adesiva indireta em metalo cerâmica - por elemento', '576.00', '2018-12-22 21:31:57', 'admin'),
(183, 'Prótese fixa adesiva indireta em metalo-plástica - cerômero - por elemento', '576.00', '2018-12-22 21:31:57', 'admin'),
(184, 'Prótese parcial fixa em metalo cerâmica (por elemento)', '576.00', '2018-12-22 21:31:57', 'admin'),
(185, 'Prótese parcial fixa em metalo plástica - cerômero (por elemento)', '576.00', '2018-12-22 21:31:57', 'admin'),
(186, 'Prótese parcial fixa implanto-suportada (por elemento)', '576.00', '2018-12-22 21:31:57', 'admin'),
(187, 'Prótese parcial fixa provisória (por elemento)', '144.00', '2018-12-22 21:31:57', 'admin'),
(188, 'Prótese parcial fixa provisória em carga imediata (por elemento)', '163.20', '2018-12-22 21:31:58', 'admin'),
(189, 'Prótese parcial removível com encaixes de precisão ou de semi precisão', '864.00', '2018-12-22 21:31:58', 'admin'),
(190, 'Prótese parcial removível com grampos bilateral', '672.00', '2018-12-22 21:31:58', 'admin'),
(191, 'Prótese parcial removível provisória em acrílico com ou sem grampos', '288.00', '2018-12-22 21:31:58', 'admin'),
(192, 'Prótese total (por arcada)', '672.00', '2018-12-22 21:31:58', 'admin'),
(193, 'Prótese total imediata (por arcada)', '672.00', '2018-12-22 21:31:58', 'admin'),
(194, 'Protocolo Branemarck em carga imediata para cinco implantes (parte protética)', '864.00', '2018-12-22 21:31:58', 'admin'),
(195, 'Protocolo Branemarck em carga imediata para quatro implantes (parte protética)', '864.00', '2018-12-22 21:31:59', 'admin'),
(196, 'Protocolo Branemarck para cinco implantes ', '1152.00', '2018-12-22 21:31:59', 'admin'),
(197, 'Protocolo Branemarck para quatro implantes', '1152.00', '2018-12-22 21:31:59', 'admin'),
(198, 'Pulpectomia - independentemente da seqüência do tratamento', '96.00', '2018-12-22 21:31:59', 'admin'),
(199, 'Pulpotomia - independentemente da seqüência do tratamento', '96.00', '2018-12-22 21:32:00', 'admin'),
(200, 'Raspagem sub-gengival para tratamento não cirúrgico da periodontite grave de alto risco - por segmento', '182.40', '2018-12-22 21:32:00', 'admin'),
(201, 'Raspagem sub-gengival para tratamento não cirúrgico da periodontite leve de baixo risco - por segmento', '96.00', '2018-12-22 21:32:00', 'admin'),
(202, 'Raspagem sub-gengival para tratamento não cirúrgico da periodontite moderada de médio risco - por segmento', '124.80', '2018-12-22 21:32:01', 'admin'),
(203, 'Raspagem supra-gengival para tratamento da gengivite - por arcada', '124.80', '2018-12-22 21:32:01', 'admin'),
(204, 'Recimentação de trabalhos protéticos ', '96.00', '2018-12-22 21:32:01', 'admin'),
(205, 'Redução de luxação da ATM com bloqueio intermaxilar', '96.00', '2018-12-22 21:32:01', 'admin'),
(206, 'Redução simples de luxação da ATM', '96.00', '2018-12-22 21:32:01', 'admin'),
(207, 'Reembasamento de coroa provisória', '96.00', '2018-12-22 21:32:01', 'admin'),
(208, 'Reembasamento de prótese total ou parcial (imediato)', '144.00', '2018-12-22 21:32:02', 'admin'),
(209, 'Reembasamento de prótese total ou parcial (mediato)', '288.00', '2018-12-22 21:32:02', 'admin'),
(210, 'Remoção de Corpo Estranho Intracanal (por conduto)', '192.00', '2018-12-22 21:32:02', 'admin'),
(211, 'Remoção de Fatores de Retenção', '96.00', '2018-12-22 21:32:02', 'admin'),
(212, 'Remoção de Material Obturador Intracanal para Retratamento Endodontico', '192.00', '2018-12-22 21:32:02', 'admin'),
(213, 'Remoção de Núcleo Intra-radicular (por elemento)', '192.00', '2018-12-22 21:32:02', 'admin'),
(214, 'Remoção de trabalhos protéticos - por elementos suportes', '96.00', '2018-12-22 21:32:03', 'admin'),
(215, 'Restauração de Amálgama - classe I - 1 face', '124.80', '2018-12-22 21:32:03', 'admin'),
(216, 'Restauração de Amálgama - Classe II - 2 faces', '144.00', '2018-12-22 21:32:03', 'admin'),
(217, 'Restauração de Amálgama - Classe II - 3 faces', '172.80', '2018-12-22 21:32:03', 'admin'),
(218, 'Restauração de Amálgama - classe II - 4 faces', '201.60', '2018-12-22 21:32:04', 'admin'),
(219, 'Restauração de porcelana (inlay / onlay)', '528.00', '2018-12-22 21:32:04', 'admin'),
(220, 'Restauração em cerâmica pura - inlay e onlay', '528.00', '2018-12-22 21:32:04', 'admin'),
(221, 'Restauração em cerômero - inlay e onlay', '528.00', '2018-12-22 21:32:04', 'admin'),
(222, 'Restauração em ionômero de vidro – Classe I - 1 face ', '96.00', '2018-12-22 21:32:05', 'admin'),
(223, 'Restauração em ionômero de vidro – Classe II - 2 faces', '115.20', '2018-12-22 21:32:05', 'admin'),
(224, 'Restauração em ionômero de vidro – Classe II - 3 faces', '115.20', '2018-12-22 21:32:05', 'admin'),
(225, 'Restauração Metálica Fundida (inlay / onlay)', '528.00', '2018-12-22 21:32:05', 'admin'),
(226, 'Restauração Resina Fotopolimerizável - Classe I - 1 face', '144.00', '2018-12-22 21:32:06', 'admin'),
(227, 'Restauração Resina Fotopolimerizável Classe II - 2 faces', '192.00', '2018-12-22 21:32:06', 'admin'),
(228, 'Restauração Resina Fotopolimerizável Classe II - 3 faces', '240.00', '2018-12-22 21:32:06', 'admin'),
(229, 'Restauração Resina Fotopolimerizável Classe II - 4 faces', '268.80', '2018-12-22 21:32:06', 'admin'),
(230, 'Restauração Resina Fotopolimerizável Classe III ', '144.00', '2018-12-22 21:32:06', 'admin'),
(231, 'Restauração Resina Fotopolimerizável Classe IV ', '268.80', '2018-12-22 21:32:06', 'admin'),
(232, 'Restauração Resina Fotopolimerizável Classe V ', '144.00', '2018-12-22 21:32:06', 'admin'),
(233, 'Restauração Temporária/tratamento expectante', '67.20', '2018-12-22 21:32:06', 'admin'),
(234, 'Retratamento Endodôntico de Canino e Pré-Molar birradiculares', '336.00', '2018-12-22 21:32:07', 'admin'),
(235, 'Retratamento Endodôntico de Incisivo/Canino /Pré-molar uniradiculares', '240.00', '2018-12-22 21:32:07', 'admin'),
(236, 'Retratamento Endodôntico de Molar ', '432.00', '2018-12-22 21:32:07', 'admin'),
(237, 'Tratamento conservador de Luxação da Articulação Têmporo-Mandibular ', '96.00', '2018-12-22 21:32:07', 'admin'),
(238, 'Tratamento da manutenção para periodontite grave (2 em 2 meses)', '144.00', '2018-12-22 21:32:07', 'admin'),
(239, 'Tratamento de abscesso periodontal agudo', '144.00', '2018-12-22 21:32:07', 'admin'),
(240, 'Tratamento de fluorose', '76.80', '2018-12-22 21:32:08', 'admin'),
(241, 'Tratamento de gengivite necrosante aguda - GNA (por sessão)', '96.00', '2018-12-22 21:32:08', 'admin'),
(242, 'Tratamento de manutenção para periodontite leve (6 em 6 meses)', '144.00', '2018-12-22 21:32:08', 'admin'),
(243, 'Tratamento de manutenção para periodontite moderada (4 em 4 meses)', '144.00', '2018-12-22 21:32:08', 'admin'),
(244, 'Tratamento de perfuração endodôntico', '192.00', '2018-12-22 21:32:08', 'admin'),
(245, 'Tratamento endodôntico de canino / pré-molar - birradiculares', '336.00', '2018-12-22 21:32:08', 'admin'),
(246, 'Tratamento endodôntico de dentes com rizogênese Incompleta (por sessão)', '144.00', '2018-12-22 21:32:08', 'admin'),
(247, 'Tratamento Endodôntico de Incisivo / Canino / Pré-molar - Uni - radicular', '240.00', '2018-12-22 21:32:08', 'admin'),
(248, 'Tratamento Endodôntico de Molar ', '432.00', '2018-12-22 21:32:09', 'admin'),
(249, 'Coroa de acetato', '240.00', '2018-12-22 21:32:09', 'admin'),
(250, 'Coroa de aço', '240.00', '2018-12-22 21:32:09', 'admin'),
(251, 'Coroa de policarbonato', '240.00', '2018-12-22 21:32:09', 'admin'),
(252, 'Exodontia de  decíduos', '96.00', '2018-12-22 21:32:09', 'admin'),
(253, 'Mantenedor de espaço fixo', '192.00', '2018-12-22 21:32:09', 'admin'),
(254, 'Mantenedor de espaço removível', '192.00', '2018-12-22 21:32:09', 'admin'),
(255, 'Pulpotomia em decíduo', '192.00', '2018-12-22 21:32:09', 'admin'),
(256, 'Restauração atraumática - por elemento', '57.60', '2018-12-22 21:32:09', 'admin'),
(257, 'Tratamento endodôntico em decíduos  ', '192.00', '2018-12-22 21:32:10', 'admin'),
(258, 'Aletas Gomes', '230.40', '2018-12-22 21:32:10', 'admin'),
(259, 'Aparelho de Thurow', '144.00', '2018-12-22 21:32:10', 'admin'),
(260, 'Aparelho extra-bucal ', '249.60', '2018-12-22 21:32:10', 'admin'),
(261, 'Aparelho Ordotôntico Fixo Estético - por arcada', '576.00', '2018-12-22 21:32:10', 'admin'),
(262, 'Aparelho Ordotôntico Fixo Metálico - por arcada', '480.00', '2018-12-22 21:32:10', 'admin'),
(263, 'Aparelho ortodontico fixo metálico parcial', '240.00', '2018-12-22 21:32:10', 'admin'),
(264, 'Aparelho Removível com alças Bionator invertida ou de Escheler', '240.00', '2018-12-22 21:32:10', 'admin'),
(265, 'Aparelho de Protração Mandibular -APM', '153.60', '2018-12-22 21:32:10', 'admin'),
(266, 'Arco Lingual ', '153.60', '2018-12-22 21:32:11', 'admin'),
(267, 'Barra Transpalatina Fixa', '153.60', '2018-12-22 21:32:11', 'admin'),
(268, 'Barra Transpalatina Removível', '134.40', '2018-12-22 21:32:11', 'admin'),
(269, 'Bionator de Balters', '288.00', '2018-12-22 21:32:11', 'admin'),
(270, 'Blocos geminados de Clark (twinblock)', '278.40', '2018-12-22 21:32:12', 'admin'),
(271, 'Botão de Nance', '153.60', '2018-12-22 21:32:12', 'admin'),
(272, 'Contenção Fixa (por arcada)', '153.60', '2018-12-22 21:32:12', 'admin'),
(273, 'Disjuntor Palatino', '314.88', '2018-12-22 21:32:12', 'admin'),
(274, 'Distalizador de Hilgers', '240.00', '2018-12-22 21:32:12', 'admin'),
(275, 'Distalizador tipo Jones Jig ', '240.00', '2018-12-22 21:32:12', 'admin'),
(276, 'Documentação eletromiográfica', '182.40', '2018-12-22 21:32:12', 'admin'),
(277, 'Grade Palatina Fixa ', '153.60', '2018-12-22 21:32:12', 'admin'),
(278, 'Grade Palatina Removível', '144.00', '2018-12-22 21:32:13', 'admin'),
(279, 'Herbst Encapsulado', '182.40', '2018-12-22 21:32:13', 'admin'),
(280, 'Manutenção de Aparelho Ortodôntico', '144.00', '2018-12-22 21:32:13', 'admin'),
(281, 'Máscara Facial - Delaire Tração Reversa', '144.00', '2018-12-22 21:32:13', 'admin'),
(282, 'Mentoneira', '144.00', '2018-12-22 21:32:13', 'admin'),
(283, 'Modelador elástico de Bimler', '288.00', '2018-12-22 21:32:13', 'admin'),
(284, 'Obtenção de modelos gnatostáticos de Planas', '230.40', '2018-12-22 21:32:13', 'admin'),
(285, 'Pistas diretas de Planas superior e inferior', '254.40', '2018-12-22 21:32:13', 'admin'),
(286, 'Pistas indiretas de Planas', '288.00', '2018-12-22 21:32:14', 'admin'),
(287, 'Placa de Hawley', '105.60', '2018-12-22 21:32:14', 'admin'),
(288, 'Placa de Hawley com torno expansor', '144.00', '2018-12-22 21:32:14', 'admin'),
(289, 'Placa de Schwarz', '240.00', '2018-12-22 21:32:14', 'admin'),
(290, 'Placa Dupla de Sanders', '288.00', '2018-12-22 21:32:14', 'admin'),
(291, 'Placa encapsulada de Maurício', '259.20', '2018-12-22 21:32:15', 'admin'),
(292, 'Placa Lábio-ativa ', '211.20', '2018-12-22 21:32:15', 'admin'),
(293, 'Quadrihélice', '220.80', '2018-12-22 21:32:15', 'admin'),
(294, 'Regulador de função de Frankel', '326.40', '2018-12-22 21:32:15', 'admin'),
(295, 'Simões Network', '240.00', '2018-12-22 21:32:15', 'admin'),
(296, 'Estabelecimento de vínculo com paciente com necessidades especiais (por sessão)', '153.60', '2018-12-22 21:32:15', 'admin'),
(297, 'Estabelecimento de vínculo com paciente idoso com transtornos psíquicos - por sessão', '153.60', '2018-12-22 21:32:15', 'admin'),
(298, 'Estabelecimento de vínculo com paciente idoso independente - uma sessão', '96.00', '2018-12-22 21:32:15', 'admin'),
(299, 'Estabelecimento de vínculo com paciente idoso parcialmente dependente - por sessão', '115.20', '2018-12-22 21:32:16', 'admin'),
(300, 'Estabelecimento de vínculo com paciente idoso totalmente dependente - por sessão', '153.60', '2018-12-22 21:32:16', 'admin'),
(302, 'Estabilização do paciente por meio de contenção física e/ou mecânica ', '153.60', '2018-12-22 21:32:16', 'admin'),
(303, 'Orientação de higiene bucal para pais e/ou cuidadores ', '76.80', '2018-12-22 21:32:16', 'admin'),
(304, 'Sedação consciente com óxido nitroso e oxigênio ', '192.00', '2018-12-22 21:32:16', 'admin'),
(305, 'Sedação medicamentosa ambulatorial', '153.60', '2018-12-22 21:32:16', 'admin');

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
  `idstatustrat` tinyint(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `procedimento_tratamento`
--

INSERT INTO `procedimento_tratamento` (`id`, `idtratamento`, `idprocedimento`, `dente`, `face`, `valor`, `idstatustrat`) VALUES
(1, 152, 258, '', '', '230.40', 1),
(2, 153, 259, '', '', '144.00', 1),
(3, 154, 260, '', '', '249.60', 1),
(4, 157, 141, '', '', '96.00', 1),
(5, 158, 258, '', '', '230.40', 1),
(6, 169, 261, '', '', '576.00', 1),
(7, 169, 262, '', '', '480.00', 1),
(8, 173, 258, '', '', '230.40', 1),
(9, 178, 258, '', '', '230.40', 1),
(10, 179, 258, '', '', '230.40', 1),
(11, 180, 262, '', '', '480.00', 1),
(12, 181, 262, '', '', '480.00', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `receita`
--

CREATE TABLE `receita` (
  `idreceita` int(11) NOT NULL,
  `nomerec` varchar(60) DEFAULT NULL,
  `idcliente` int(11) DEFAULT NULL,
  `data_receita` datetime DEFAULT NULL,
  `resp_receita` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `receita`
--

INSERT INTO `receita` (`idreceita`, `nomerec`, `idcliente`, `data_receita`, `resp_receita`) VALUES
(2, 'Receita para cicatriz', 1, '2019-02-02 22:01:48', ''),
(4, 'Recita para estrias', 1, '2019-02-03 11:27:13', '');

-- --------------------------------------------------------

--
-- Estrutura da tabela `receita_medicamento`
--

CREATE TABLE `receita_medicamento` (
  `idrmedicamento` int(11) NOT NULL,
  `idmedicamento` int(11) DEFAULT NULL,
  `tamanho` varchar(30) NOT NULL,
  `qtd` tinyint(5) DEFAULT NULL,
  `unidade` varchar(3) DEFAULT NULL,
  `modo_usar` varchar(200) DEFAULT NULL,
  `idreceita` int(5) DEFAULT NULL,
  `tipouso` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `receita_medicamento`
--

INSERT INTO `receita_medicamento` (`idrmedicamento`, `idmedicamento`, `tamanho`, `qtd`, `unidade`, `modo_usar`, `idreceita`, `tipouso`) VALUES
(2, 6, '500mg', 1, 'Cx', '1 vez a cada 2 dias pelo período de 1 semana', 2, 'Topico'),
(3, 2, '300ml', 1, 'Cx', '1 vez a cada 8 horas', 2, 'Topico'),
(4, 5, '500mg', 1, 'Cx', 'Aplicar sob a área tratada 4 (quatro) vezes ao dia. Durante 7 (sete) dias.', 2, 'Oral'),
(5, 1, '500mg', 2, 'Pm', '', 2, 'Oral'),
(6, 7, '150ml', 2, 'Cx', 'Usar 1 vez a cada 2 dias por um perÃ­odo de 2 semanas ate sarar', 4, NULL);

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
  `descricao` varchar(40) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `tipopg`
--

INSERT INTO `tipopg` (`idtipopg`, `descricao`) VALUES
(1, 'Padaria'),
(2, 'Copasa'),
(3, 'Cemig');

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
  `status_tratamento` varchar(25) NOT NULL,
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
(174, '', NULL, '2019-02-03', NULL, NULL, '', 1, '', '0000-00-00 00:00:00', NULL, ''),
(175, '', NULL, '2019-02-03', NULL, NULL, '', 1, '', '0000-00-00 00:00:00', NULL, ''),
(176, '', NULL, '2019-02-03', NULL, NULL, '', 1, '', '0000-00-00 00:00:00', NULL, ''),
(177, '', NULL, '2019-02-03', NULL, NULL, '', 1, '', '0000-00-00 00:00:00', NULL, ''),
(178, '', NULL, '2019-02-03', NULL, NULL, '', 1, '', '0000-00-00 00:00:00', NULL, ''),
(180, '', 2, '2019-02-05', NULL, NULL, 'Tratando', 18, 'Admin', '2019-02-04 00:00:00', NULL, 'Teste de Tratamento'),
(181, '', 3, '2019-02-05', NULL, NULL, 'Tratando', 1, 'Admin', '2019-02-03 00:00:00', NULL, 'Tratamento de estrias');

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
  `ativo` int(1) NOT NULL DEFAULT '1',
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
(1, 'Admin', '976b05f793ff426e5fc3aee138954bbef2984d8a', 10, 'admin', 1, '2018-11-18', 'Administrador', '0', 1, ''),
(2, 'funcionario', '976b05f793ff426e5fc3aee138954bbef2984d8a', 1, 'funcionario', 1, '2018-11-22', 'Funcionario', '0', 2, '');

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
(10, 'Administrador');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `agenda`
--
ALTER TABLE `agenda`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_idcliente` (`idcliente`);

--
-- Indexes for table `anamnese`
--
ALTER TABLE `anamnese`
  ADD PRIMARY KEY (`idanamnese`),
  ADD KEY `idcliente` (`idcliente`);

--
-- Indexes for table `cidade`
--
ALTER TABLE `cidade`
  ADD PRIMARY KEY (`idcidade`);

--
-- Indexes for table `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`idcliente`);

--
-- Indexes for table `cliente_imagens`
--
ALTER TABLE `cliente_imagens`
  ADD PRIMARY KEY (`idimagem`),
  ADD KEY `fk_pimagem_idcliente` (`idcliente`);

--
-- Indexes for table `contas_pagar`
--
ALTER TABLE `contas_pagar`
  ADD PRIMARY KEY (`idcpagar`),
  ADD KEY `fk_movipagar_id` (`idmovipagar`);

--
-- Indexes for table `contas_pagar_movi`
--
ALTER TABLE `contas_pagar_movi`
  ADD PRIMARY KEY (`idmovipagar`);

--
-- Indexes for table `contas_receber`
--
ALTER TABLE `contas_receber`
  ADD PRIMARY KEY (`idparcelas`),
  ADD KEY `fk_parcelas_idmovimento` (`idmovimento`);

--
-- Indexes for table `contas_receb_movi`
--
ALTER TABLE `contas_receb_movi`
  ADD PRIMARY KEY (`idmovimento`),
  ADD KEY `fk_pagamentos_idcliente` (`idcliente`),
  ADD KEY `fk_tratamento` (`idtratamento`);

--
-- Indexes for table `dentista`
--
ALTER TABLE `dentista`
  ADD PRIMARY KEY (`iddentista`);

--
-- Indexes for table `doencas`
--
ALTER TABLE `doencas`
  ADD PRIMARY KEY (`iddoencas`);

--
-- Indexes for table `especialidade`
--
ALTER TABLE `especialidade`
  ADD PRIMARY KEY (`idespecialidade`);

--
-- Indexes for table `evolucao`
--
ALTER TABLE `evolucao`
  ADD PRIMARY KEY (`idevolucao`),
  ADD KEY `fk_evo_idtratamento` (`idtratamento`);

--
-- Indexes for table `formapg`
--
ALTER TABLE `formapg`
  ADD PRIMARY KEY (`idformapg`);

--
-- Indexes for table `medicamento`
--
ALTER TABLE `medicamento`
  ADD PRIMARY KEY (`idmedicamento`);

--
-- Indexes for table `procedimento`
--
ALTER TABLE `procedimento`
  ADD PRIMARY KEY (`idprocedimento`);

--
-- Indexes for table `procedimento_tratamento`
--
ALTER TABLE `procedimento_tratamento`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `receita`
--
ALTER TABLE `receita`
  ADD PRIMARY KEY (`idreceita`);

--
-- Indexes for table `receita_medicamento`
--
ALTER TABLE `receita_medicamento`
  ADD PRIMARY KEY (`idrmedicamento`),
  ADD KEY `fk_receita` (`idreceita`);

--
-- Indexes for table `situacao_caixa`
--
ALTER TABLE `situacao_caixa`
  ADD PRIMARY KEY (`idsituacao`);

--
-- Indexes for table `status_tratamento`
--
ALTER TABLE `status_tratamento`
  ADD PRIMARY KEY (`idstatustrat`);

--
-- Indexes for table `tipopg`
--
ALTER TABLE `tipopg`
  ADD PRIMARY KEY (`idtipopg`);

--
-- Indexes for table `tratamento`
--
ALTER TABLE `tratamento`
  ADD PRIMARY KEY (`idtratamento`),
  ADD KEY `fk_iddentista` (`iddentista`),
  ADD KEY `fk_tratamento_idcliente` (`idcliente`);

--
-- Indexes for table `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id_usuario`);

--
-- Indexes for table `usuario_nivel`
--
ALTER TABLE `usuario_nivel`
  ADD PRIMARY KEY (`idnivel`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `agenda`
--
ALTER TABLE `agenda`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `anamnese`
--
ALTER TABLE `anamnese`
  MODIFY `idanamnese` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `cidade`
--
ALTER TABLE `cidade`
  MODIFY `idcidade` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `clientes`
--
ALTER TABLE `clientes`
  MODIFY `idcliente` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `cliente_imagens`
--
ALTER TABLE `cliente_imagens`
  MODIFY `idimagem` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `contas_pagar`
--
ALTER TABLE `contas_pagar`
  MODIFY `idcpagar` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT for table `contas_pagar_movi`
--
ALTER TABLE `contas_pagar_movi`
  MODIFY `idmovipagar` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `contas_receber`
--
ALTER TABLE `contas_receber`
  MODIFY `idparcelas` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `contas_receb_movi`
--
ALTER TABLE `contas_receb_movi`
  MODIFY `idmovimento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=84;

--
-- AUTO_INCREMENT for table `dentista`
--
ALTER TABLE `dentista`
  MODIFY `iddentista` int(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `doencas`
--
ALTER TABLE `doencas`
  MODIFY `iddoencas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `especialidade`
--
ALTER TABLE `especialidade`
  MODIFY `idespecialidade` tinyint(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `evolucao`
--
ALTER TABLE `evolucao`
  MODIFY `idevolucao` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `formapg`
--
ALTER TABLE `formapg`
  MODIFY `idformapg` tinyint(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `medicamento`
--
ALTER TABLE `medicamento`
  MODIFY `idmedicamento` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `procedimento`
--
ALTER TABLE `procedimento`
  MODIFY `idprocedimento` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=306;

--
-- AUTO_INCREMENT for table `procedimento_tratamento`
--
ALTER TABLE `procedimento_tratamento`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `receita`
--
ALTER TABLE `receita`
  MODIFY `idreceita` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `receita_medicamento`
--
ALTER TABLE `receita_medicamento`
  MODIFY `idrmedicamento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `situacao_caixa`
--
ALTER TABLE `situacao_caixa`
  MODIFY `idsituacao` tinyint(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tipopg`
--
ALTER TABLE `tipopg`
  MODIFY `idtipopg` tinyint(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tratamento`
--
ALTER TABLE `tratamento`
  MODIFY `idtratamento` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=182;

--
-- AUTO_INCREMENT for table `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id_usuario` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
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
  ADD CONSTRAINT `fk_parcelas_idmovimento` FOREIGN KEY (`idmovimento`) REFERENCES `contas_receb_movi` (`idmovimento`) ON DELETE CASCADE;

--
-- Limitadores para a tabela `contas_receb_movi`
--
ALTER TABLE `contas_receb_movi`
  ADD CONSTRAINT `fk_tratamento` FOREIGN KEY (`idtratamento`) REFERENCES `tratamento` (`idtratamento`) ON DELETE CASCADE;

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
