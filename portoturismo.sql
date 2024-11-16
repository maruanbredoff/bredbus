-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Tempo de geração: 11-Maio-2021 às 14:20
-- Versão do servidor: 8.0.17
-- versão do PHP: 7.3.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `portoturismo`
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
(1, 'Reuniao joao', '2021-04-26 09:00:00', '2021-04-26 09:30:00', NULL, 'Admin', '#FFD700', 'Normal', 0),
(2, 'Reuniao joao', '2021-05-03 10:00:00', '2021-05-03 10:30:00', NULL, 'Admin', '#BB9999', 'Normal', 0),
(3, 'Encontrar com Maruan', '2021-05-04 09:00:00', '2021-05-04 09:30:00', NULL, 'Admin', '#BB9999', 'Normal', 0),
(4, 'Obrigado por se Inscrever', '2021-05-05 10:30:00', '2021-05-05 11:00:00', NULL, 'Admin', '#0071c5', 'Normal', 0);

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
  `atendente` varchar(30) NOT NULL,
  `passaporte` varchar(9) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `clientes`
--

INSERT INTO `clientes` (`idcliente`, `nome`, `cpf`, `rg`, `sexo`, `nascimento`, `endereco`, `numero`, `bairro`, `estado`, `cidade`, `cep`, `celular`, `telefone`, `email`, `data_cadastro`, `obs`, `convenio`, `matricula`, `titular`, `validade`, `foto`, `atendente`, `passaporte`) VALUES
(182, 'Maruan Gomes Bredoff', '077.189.393-84', 'mg2738273', 'Masculino', '1988-05-12', 'Rua João Lopes da Silva', '888', 'Manoel Pimenta', 'MG', 'Teófilo Otoni', '39802184', '33-98888-8888', '', '', '2021-05-01 00:00:00', '', NULL, NULL, NULL, NULL, NULL, 'Admin', 'HU33333'),
(183, 'Fabio Nunes', '093.839.383-93', 'mg26337363', 'Masculino', '1988-05-12', 'Rua das Pinhas', '999', 'Jardim Conceição ', 'SP', 'Hortolândia', '13185770', '33-98827-3837', '', '', '2021-05-03 21:23:00', '', NULL, NULL, NULL, NULL, NULL, 'Admin', 'op73637');

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
(54, 'Passaporte Andrezza', 183, 'd8df5f4f5688b9e373205c685f48a8d8jpeg', '2021-05-08 16:02:46', '', NULL, 0);

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
(1, '150.00', '2021-04-30', 1, 3, 1, NULL, NULL),
(2, '150.00', '2021-05-30', 2, 3, 1, NULL, NULL),
(3, '900.00', '2021-05-03', 1, 3, 2, NULL, NULL),
(4, '3650.00', '2021-05-03', 1, 3, 3, NULL, NULL),
(5, '3650.00', '2021-06-03', 2, 3, 3, NULL, NULL),
(6, '300.00', '2021-05-06', 1, 3, 4, NULL, NULL),
(7, '250.00', '2021-05-08', 1, 3, 5, NULL, NULL),
(8, '250.00', '2021-06-08', 2, 3, 5, NULL, NULL),
(9, '95.00', '2021-05-10', 1, 3, 6, NULL, NULL),
(10, '550.00', '2021-05-10', 1, 3, 7, NULL, NULL);

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
  `mcancelamento` varchar(100) DEFAULT NULL,
  `descricao` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `contas_pagar_movi`
--

INSERT INTO `contas_pagar_movi` (`idmovipagar`, `data_movimento`, `tipopg`, `qtdparcelas`, `valor`, `idformapg`, `resp_cadastro`, `num_doc`, `cancelado`, `data_cancelamento`, `cancelado_por`, `mcancelamento`, `descricao`) VALUES
(1, '2021-04-30 23:50:00', '2', 2, '300.00', 1, 'Admin', '', 1, '2021-05-04 00:33:00', 'Admin', 'Erro de cadastro', ''),
(2, '2021-05-03 21:32:00', '33', 1, '900.00', 1, 'Admin', '', 1, '2021-05-11 02:05:00', 'Admin', 'erro', ''),
(3, '2021-05-03 21:43:00', '34', 2, '7300.00', 1, 'Admin', '', 1, '2021-05-11 02:16:00', 'Admin', 'erro', ''),
(4, '2021-05-06 23:41:00', '1', 1, '300.00', 1, 'Admin', '', 1, '2021-05-11 02:17:00', 'Admin', 'outro erro', ''),
(5, '2021-05-08 16:05:00', '4', 2, '500.00', 2, 'Admin', '', 1, '2021-05-11 02:17:00', 'Admin', 'de novo', ''),
(6, '2021-05-10 23:15:00', '2', 1, '95.00', 1, 'Admin', '', 1, '2021-05-11 02:19:00', 'Admin', 'sdsdfsdf', 'teste'),
(7, '2021-05-10 23:19:00', '1', 1, '550.00', 1, 'Admin', '', 1, '2021-05-11 02:36:00', 'Admin', 'fgfg', 'outro teste');

-- --------------------------------------------------------

--
-- Estrutura da tabela `contas_receber`
--

CREATE TABLE `contas_receber` (
  `idparcelas` smallint(6) NOT NULL,
  `valor` decimal(10,2) NOT NULL,
  `vencimento` date DEFAULT NULL,
  `parcela` tinyint(4) NOT NULL,
  `valorpg` decimal(10,2) NOT NULL,
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

INSERT INTO `contas_receber` (`idparcelas`, `valor`, `vencimento`, `parcela`, `valorpg`, `idcliente`, `idsituacao`, `idmovimento`, `data_pg`, `quem_recebeu`, `num_doc`, `emitente`, `agencia`, `banco`, `contadeposito`, `depositante`) VALUES
(127, '0.00', '0000-00-00', 0, '960.00', 182, 0, 129, '2021-05-07 01:12:46', 'Admin', NULL, NULL, NULL, NULL, NULL, NULL),
(128, '0.00', NULL, 0, '3540.00', 182, 0, 129, '2021-05-07 01:43:26', 'Admin', NULL, NULL, NULL, NULL, NULL, NULL),
(129, '0.00', NULL, 0, '1000.00', 182, 0, 131, '2021-05-07 02:01:07', 'Admin', NULL, NULL, NULL, NULL, NULL, NULL),
(130, '0.00', NULL, 0, '2000.00', 182, 0, 131, '2021-05-07 02:01:57', 'Admin', NULL, NULL, NULL, NULL, NULL, NULL),
(131, '0.00', NULL, 0, '500.00', 182, 0, 131, '2021-05-07 02:40:57', 'Admin', NULL, NULL, NULL, NULL, NULL, NULL),
(132, '0.00', NULL, 0, '700.00', 182, 0, 133, '2021-05-07 02:46:57', 'Admin', NULL, NULL, NULL, NULL, NULL, NULL),
(133, '0.00', NULL, 0, '3000.00', 183, 0, 130, '2021-05-08 15:59:20', 'Admin', NULL, NULL, NULL, NULL, NULL, NULL),
(134, '0.00', NULL, 0, '800.00', 183, 0, 130, '2021-05-08 16:00:59', 'Admin', NULL, NULL, NULL, NULL, NULL, NULL),
(135, '0.00', NULL, 0, '2500.00', 183, 0, 135, '2021-05-08 16:01:30', 'Admin', NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `contas_receber_pg`
--

CREATE TABLE `contas_receber_pg` (
  `idpg` int(11) NOT NULL,
  `valorpg` decimal(10,2) NOT NULL,
  `datapg` date DEFAULT NULL,
  `idmovimento` int(3) NOT NULL,
  `quem_recebeu` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `contas_receb_movi`
--

CREATE TABLE `contas_receb_movi` (
  `idmovimento` int(11) NOT NULL,
  `idcliente` int(11) NOT NULL,
  `valor_restante` decimal(10,2) NOT NULL,
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
  `mcancelamento` varchar(100) DEFAULT NULL,
  `idpassagem` int(11) DEFAULT NULL,
  `entrada` decimal(10,2) DEFAULT NULL,
  `vencimento` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `contas_receb_movi`
--

INSERT INTO `contas_receb_movi` (`idmovimento`, `idcliente`, `valor_restante`, `qtdparcelas`, `idtratamento`, `data_movimento`, `idformapg`, `num_doc`, `desconto`, `valor_total`, `cancelado`, `data_cancelamento`, `cancelado_por`, `mcancelamento`, `idpassagem`, `entrada`, `vencimento`) VALUES
(129, 182, '0.00', 2, 0, '2021-05-11 00:00:00', 2, NULL, NULL, '5500.00', 0, NULL, NULL, NULL, 41, '1000.00', '1969-12-31'),
(130, 183, '3800.00', 5, 0, '2021-05-07 00:00:00', 1, NULL, NULL, '6800.00', 0, NULL, NULL, NULL, 42, '3000.00', '2021-05-14'),
(131, 182, '7000.00', 0, 0, '2021-05-06 22:25:00', 1, NULL, NULL, '9000.00', 0, NULL, NULL, NULL, 49, '2000.00', NULL),
(132, 182, '8000.00', 0, 0, '2021-05-06 22:33:00', 1, NULL, NULL, '8000.00', 0, NULL, NULL, NULL, 50, '0.00', NULL),
(133, 182, '1600.00', 0, 0, '2021-05-06 22:44:00', 2, NULL, NULL, '2000.00', 0, NULL, NULL, NULL, 56, '400.00', '2021-05-05'),
(134, 182, '6500.00', 0, 0, '2021-05-11 00:00:00', 1, NULL, NULL, '9000.00', 0, NULL, NULL, NULL, 57, '2500.00', '2021-06-06'),
(135, 183, '7000.00', 0, 0, '2021-05-08 00:00:00', 1, NULL, NULL, '7000.00', 0, NULL, NULL, NULL, 60, '0.00', '2021-05-05');

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

--
-- Extraindo dados da tabela `contas_recepcao`
--

INSERT INTO `contas_recepcao` (`idcpagar`, `valor`, `vencimento`, `parcela`, `idsituacao`, `idmovipagar`, `data_pg`, `quem_pagou`) VALUES
(17, '700.00', '2021-05-07', 1, 2, 17, '2021-05-08 19:08:00', 'Admin'),
(18, '2000.00', '2021-05-07', 1, 2, 18, '2021-05-07 07:17:00', 'Admin'),
(19, '4000.00', '2021-05-08', 1, 2, 19, '2021-05-08 19:07:00', 'Admin');

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
  `resp_edicao` varchar(30) DEFAULT NULL,
  `descricao` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `contas_recep_movi`
--

INSERT INTO `contas_recep_movi` (`idmovipagar`, `data_movimento`, `tipopg`, `qtdparcelas`, `valor`, `idformapg`, `resp_cadastro`, `num_doc`, `cancelado`, `data_cancelamento`, `cancelado_por`, `mcancelamento`, `data_edicao`, `resp_edicao`, `descricao`) VALUES
(17, '2021-05-07 04:04:00', '8', 1, '700.00', 1, 'Admin', '', 0, NULL, NULL, NULL, '2021-05-07 04:25:00', 'Admin', 'Teste'),
(18, '2021-05-07 04:13:00', '', 1, '2000.00', 1, 'Admin', '', 0, NULL, NULL, NULL, '2021-05-07 04:22:00', 'Admin', 'Dinheiro Viagem Maruan'),
(19, '2021-05-08 16:07:00', NULL, 1, '4000.00', 1, 'Admin', '', 0, NULL, NULL, NULL, NULL, NULL, 'Despesa Passagem ANdrezza');

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

--
-- Extraindo dados da tabela `contas_recep_receita`
--

INSERT INTO `contas_recep_receita` (`idparcelas`, `valor`, `vencimento`, `parcela`, `mensagem`, `idcliente`, `idsituacao`, `idmovimento`, `data_pg`, `quem_recebeu`, `contadeposito`, `depositante`, `agencia`, `banco`, `num_doc`, `emitente`) VALUES
(58, '3400.00', '2021-05-07', 1, '', 0, 1, 5, NULL, '', NULL, NULL, NULL, NULL, '', 'Aluguel'),
(59, '3000.00', '2021-05-08', 1, '', 0, 2, 6, '2021-05-08 16:06:24', 'Admin', 0, '', NULL, NULL, '', '');

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
  `resp_edicao` varchar(30) DEFAULT NULL,
  `descricao` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `contas_recep_receita_movi`
--

INSERT INTO `contas_recep_receita_movi` (`idmovimento`, `valor`, `qtdparcelas`, `data_movimento`, `idformapg`, `num_doc`, `desconto`, `cancelado`, `data_cancelamento`, `cancelado_por`, `mcancelamento`, `tipopg`, `data_edicao`, `resp_edicao`, `descricao`) VALUES
(5, '3400.00', 1, '2021-05-07 04:39:00', 2, '', '0.00', 0, NULL, NULL, NULL, 0, '2021-05-07 04:46:00', 'Admin', 'Teste 2'),
(6, '3000.00', 1, '2021-05-08 16:06:00', 1, NULL, '0.00', 0, NULL, NULL, NULL, 0, NULL, NULL, 'Pagamento de Joao');

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
(5, 'Michella Murta', '000.000.000-00', NULL, '1985-02-05', 'PraÃ§a Tiradentes', 'Centro', 'TeÃ³filo Otoni', 'MG', '39800001', '33-00000-0000', NULL, 'Feminino', '', 4, '100.00', 0, 'Admin', '0000-00-00 00:00:00');

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
(2, 'Cartão de Credito'),
(3, 'Cartão de Debito'),
(6, 'Transferencia'),
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
-- Estrutura da tabela `passagem`
--

CREATE TABLE `passagem` (
  `idpassagem` int(20) NOT NULL,
  `idcliente` int(11) DEFAULT NULL,
  `origem` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `destino` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `data_passagem` date DEFAULT NULL,
  `data_cadastro` datetime DEFAULT NULL,
  `atendente` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `status_passagem` int(2) NOT NULL,
  `obs` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `passagem`
--

INSERT INTO `passagem` (`idpassagem`, `idcliente`, `origem`, `destino`, `data_passagem`, `data_cadastro`, `atendente`, `status_passagem`, `obs`) VALUES
(40, 182, NULL, NULL, NULL, '2021-05-01 00:09:00', NULL, 0, NULL),
(41, 182, 'São Paulo', 'Acapulco', '2021-06-03', '1969-12-31 21:00:00', 'Admin', 1, 'teste'),
(42, 183, 'Sao Paulo', 'Cancun', '2021-05-14', '1969-12-31 21:00:00', 'Admin', 1, ''),
(43, 182, NULL, NULL, NULL, '2021-05-06 20:26:00', NULL, 0, NULL),
(44, 182, NULL, NULL, NULL, '2021-05-06 20:29:00', NULL, 0, NULL),
(45, 182, NULL, NULL, NULL, '2021-05-06 20:30:00', NULL, 0, NULL),
(46, 182, NULL, NULL, NULL, '2021-05-06 21:13:00', NULL, 0, NULL),
(47, 182, NULL, NULL, NULL, '2021-05-06 21:16:00', NULL, 0, NULL),
(48, 182, NULL, NULL, NULL, '2021-05-06 22:20:00', NULL, 0, NULL),
(49, 182, 'Belo Horizonte', 'Texas', '2021-05-11', '2021-05-06 22:23:00', 'Admin', 1, ''),
(50, 182, 'Belo Horizonte', 'Texas', '2021-05-20', '2021-05-06 22:32:00', 'Admin', 1, ''),
(51, 182, NULL, NULL, NULL, '2021-05-06 22:34:00', NULL, 0, NULL),
(52, 182, NULL, NULL, NULL, '2021-05-06 22:34:00', NULL, 0, NULL),
(53, 182, NULL, NULL, NULL, '2021-05-06 22:36:00', NULL, 0, NULL),
(54, 182, NULL, NULL, NULL, '2021-05-06 22:36:00', NULL, 0, NULL),
(55, 182, NULL, NULL, NULL, '2021-05-06 22:41:00', NULL, 0, NULL),
(56, 182, 'Teofilo Otoni', 'Recife', '2021-05-07', '2021-05-06 22:43:00', 'Admin', 1, ''),
(57, 182, 'Belo Horizonte', 'Texas', '2021-05-20', '1969-12-31 21:00:00', 'Admin', 1, 'popopo'),
(58, 182, NULL, NULL, NULL, '2021-05-06 22:49:00', NULL, 0, NULL),
(59, 182, NULL, NULL, NULL, '2021-05-07 00:00:00', NULL, 0, NULL),
(60, 183, 'Teofilo Otoni', 'Texas', '2021-05-12', '1969-12-31 21:00:00', 'Admin', 1, '');

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
(48, NULL, 82, '2019-06-07 19:34:18', '', NULL),
(49, 'Dexametasona Pomada', 177, '2021-04-27 23:58:35', 'Admin', 5),
(50, NULL, 177, '2021-04-27 23:58:46', '', NULL),
(51, 'Dexametasona Pomada', 177, '2021-04-27 23:59:04', 'Admin', 5);

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
(63, 4, '40g', 1, 'Pomada', 'Passar sobre os hematomas fazendo leves massagens 3 vezes\nao dia. AtÃ© cessar os sintomas.', 44, '1'),
(65, 2, NULL, 1, 'Bisnaga', 'Aplique sob a área tratada 3 vezes por dia.', 49, '1'),
(66, 2, NULL, 1, 'Bisnaga', 'Aplique sob a área tratada 3 vezes por dia.', 51, '1');

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
(3, 'Cancelado'),
(4, 'Parcial');

-- --------------------------------------------------------

--
-- Estrutura da tabela `status_passagem`
--

CREATE TABLE `status_passagem` (
  `idstatuspass` tinyint(3) NOT NULL,
  `status` varchar(40) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `status_passagem`
--

INSERT INTO `status_passagem` (`idstatuspass`, `status`) VALUES
(1, 'Agendado'),
(2, 'Finalizado'),
(3, 'Deportado'),
(4, 'Cancelada');

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
(32, 'perfectha subskin', '2019-07-24 00:00:00', 'Dionisio'),
(33, 'Aluguel Carro', '2021-05-03 00:00:00', 'Admin'),
(34, 'Passagem Familia Castro', '2021-05-03 00:00:00', 'Admin');

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
  `altera_senha` varchar(3) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `iddentista` int(3) NOT NULL,
  `resp_cadastro` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `usuario`
--

INSERT INTO `usuario` (`id_usuario`, `u_nome`, `senha`, `nivel`, `usuario`, `ativo`, `data_cadastro`, `u_nivel`, `altera_senha`, `iddentista`, `resp_cadastro`) VALUES
(1, 'Admin', 'd437de2eae8337645fff3d69abd20e9464b791d9', 1, 'admin', 1, '2018-11-18', 'Administrador', '0', 5, ''),
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
-- Índices para tabela `atendimento`
--
ALTER TABLE `atendimento`
  ADD PRIMARY KEY (`idatendimento`);

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
-- Índices para tabela `contas_receber_pg`
--
ALTER TABLE `contas_receber_pg`
  ADD PRIMARY KEY (`idpg`),
  ADD KEY `fk_idmovi` (`idmovimento`);

--
-- Índices para tabela `contas_receb_movi`
--
ALTER TABLE `contas_receb_movi`
  ADD PRIMARY KEY (`idmovimento`),
  ADD KEY `fk_passagem` (`idpassagem`),
  ADD KEY `fk_clientes` (`idcliente`);

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
-- Índices para tabela `passagem`
--
ALTER TABLE `passagem`
  ADD PRIMARY KEY (`idpassagem`);

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
-- Índices para tabela `status_passagem`
--
ALTER TABLE `status_passagem`
  ADD PRIMARY KEY (`idstatuspass`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `atendimento`
--
ALTER TABLE `atendimento`
  MODIFY `idatendimento` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `cidade`
--
ALTER TABLE `cidade`
  MODIFY `idcidade` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `clientes`
--
ALTER TABLE `clientes`
  MODIFY `idcliente` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=184;

--
-- AUTO_INCREMENT de tabela `cliente_imagens`
--
ALTER TABLE `cliente_imagens`
  MODIFY `idimagem` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT de tabela `contas_pagar`
--
ALTER TABLE `contas_pagar`
  MODIFY `idcpagar` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de tabela `contas_pagar_movi`
--
ALTER TABLE `contas_pagar_movi`
  MODIFY `idmovipagar` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de tabela `contas_receber`
--
ALTER TABLE `contas_receber`
  MODIFY `idparcelas` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=136;

--
-- AUTO_INCREMENT de tabela `contas_receber_pg`
--
ALTER TABLE `contas_receber_pg`
  MODIFY `idpg` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `contas_receb_movi`
--
ALTER TABLE `contas_receb_movi`
  MODIFY `idmovimento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=136;

--
-- AUTO_INCREMENT de tabela `contas_recepcao`
--
ALTER TABLE `contas_recepcao`
  MODIFY `idcpagar` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de tabela `contas_recep_movi`
--
ALTER TABLE `contas_recep_movi`
  MODIFY `idmovipagar` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de tabela `contas_recep_receita`
--
ALTER TABLE `contas_recep_receita`
  MODIFY `idparcelas` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT de tabela `contas_recep_receita_movi`
--
ALTER TABLE `contas_recep_receita_movi`
  MODIFY `idmovimento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de tabela `dentista`
--
ALTER TABLE `dentista`
  MODIFY `iddentista` int(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

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
-- AUTO_INCREMENT de tabela `passagem`
--
ALTER TABLE `passagem`
  MODIFY `idpassagem` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT de tabela `receita`
--
ALTER TABLE `receita`
  MODIFY `idreceita` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT de tabela `receita_medicamento`
--
ALTER TABLE `receita_medicamento`
  MODIFY `idrmedicamento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT de tabela `situacao_caixa`
--
ALTER TABLE `situacao_caixa`
  MODIFY `idsituacao` tinyint(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `tipopg`
--
ALTER TABLE `tipopg`
  MODIFY `idtipopg` tinyint(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

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
-- AUTO_INCREMENT de tabela `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id_usuario` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `cliente_imagens`
--
ALTER TABLE `cliente_imagens`
  ADD CONSTRAINT `fk_pimagem_idcliente` FOREIGN KEY (`idcliente`) REFERENCES `clientes` (`idcliente`) ON DELETE CASCADE ON UPDATE RESTRICT;

--
-- Limitadores para a tabela `contas_pagar`
--
ALTER TABLE `contas_pagar`
  ADD CONSTRAINT `fk_movipagar_id` FOREIGN KEY (`idmovipagar`) REFERENCES `contas_pagar_movi` (`idmovipagar`) ON DELETE CASCADE ON UPDATE RESTRICT;

--
-- Limitadores para a tabela `contas_receber`
--
ALTER TABLE `contas_receber`
  ADD CONSTRAINT `fk_parcelas_idmovimento` FOREIGN KEY (`idmovimento`) REFERENCES `contas_receb_movi` (`idmovimento`) ON DELETE CASCADE ON UPDATE RESTRICT;

--
-- Limitadores para a tabela `contas_receber_pg`
--
ALTER TABLE `contas_receber_pg`
  ADD CONSTRAINT `fk_idmovi` FOREIGN KEY (`idmovimento`) REFERENCES `contas_receb_movi` (`idmovimento`);

--
-- Limitadores para a tabela `contas_receb_movi`
--
ALTER TABLE `contas_receb_movi`
  ADD CONSTRAINT `fk_clientes` FOREIGN KEY (`idcliente`) REFERENCES `clientes` (`idcliente`),
  ADD CONSTRAINT `fk_passagem` FOREIGN KEY (`idpassagem`) REFERENCES `passagem` (`idpassagem`);

--
-- Limitadores para a tabela `contas_recepcao`
--
ALTER TABLE `contas_recepcao`
  ADD CONSTRAINT `fk_idmovipagar2` FOREIGN KEY (`idmovipagar`) REFERENCES `contas_recep_movi` (`idmovipagar`);

--
-- Limitadores para a tabela `receita_medicamento`
--
ALTER TABLE `receita_medicamento`
  ADD CONSTRAINT `fk_receita` FOREIGN KEY (`idreceita`) REFERENCES `receita` (`idreceita`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
