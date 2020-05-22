-- phpMyAdmin SQL Dump
-- version 4.2.12deb2+deb8u3
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: 28-Jun-2019 às 20:00
-- Versão do servidor: 5.5.60-0+deb8u1
-- PHP Version: 5.6.38-0+deb8u1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `sgtrans`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `RO_Atualizar_Custo_Manutencao_peca`(IN `PECId` INT, IN `MANId` INT, IN `PUValor` FLOAT)
    NO SQL
BEGIN
  	DECLARE valor FLOAT;
  	UPDATE manutencao SET MAN_CustoTotal= MAN_CustoTotal + PUValor WHERE MAN_Id=MANId;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `RO_Atualizar_Custo_Manutencao_servico`(IN `SERId` INT, IN `MANId` INT, IN `SUValor` FLOAT)
    NO SQL
BEGIN 	
  	UPDATE manutencao SET MAN_CustoTotal= MAN_CustoTotal + SUValor WHERE MAN_Id=MANId;
END$$

--
-- Functions
--
CREATE DEFINER=`root`@`localhost` FUNCTION `ipva`(`placa` VARCHAR(8)) RETURNS int(11)
BEGIN
    DECLARE s INT;

    IF RIGHT(placa,1) > 0 THEN SET s = RIGHT(placa,1) + 2;
    ELSE SET s = 12;
    END IF;

    RETURN s;
  END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `abastece`
--

CREATE TABLE IF NOT EXISTS `abastece` (
`ABA_Id` int(11) NOT NULL,
  `ABA_ValorAbastecido` decimal(8,2) NOT NULL,
  `ABA_Odometro` varchar(5) NOT NULL,
  `ABA_Litros` decimal(8,2) NOT NULL,
  `ABA_Data` date NOT NULL,
  `ABA_Combustivel` int(11) NOT NULL,
  `VEI_Id` int(11) NOT NULL,
  `POS_Id` int(11) NOT NULL,
  `USU_Id` int(11) NOT NULL,
  `ABA_Autonomia` decimal(8,1) NOT NULL,
  `ABA_Percorrido` int(6) NOT NULL,
  `ABA_Status` varchar(8) NOT NULL,
  `ABA_Consumo` varchar(15) NOT NULL,
  `ABA_EstadoTanque` int(1) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=201 DEFAULT CHARSET=utf8;

--
-- Acionadores `abastece`
--
DELIMITER //
CREATE TRIGGER `Notification_Abastece` BEFORE UPDATE ON `abastece`
 FOR EACH ROW IF NEW.ABA_Consumo = 'Alto' THEN
	INSERT INTO notificacoes SET NOT_Table='abastece', NOT_Data=NEW.ABA_Data, NOT_Placa=NEW.VEI_Id, NOT_Read=1;
END IF
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `departamento`
--

CREATE TABLE IF NOT EXISTS `departamento` (
`DEP_Id` int(11) NOT NULL,
  `DEP_Nome` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `empresa`
--

CREATE TABLE IF NOT EXISTS `empresa` (
`EMP_Id` int(11) NOT NULL,
  `EMP_Nome` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `EMP_Sigla` varchar(15) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `EMP_Telefone` varchar(11) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `EMP_Email` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `EMP_Endereco` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `EMP_Cnpj` varchar(14) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `EMP_Logo` longblob NOT NULL,
  `EMP_Tolerancia` int(4) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `funcao`
--

CREATE TABLE IF NOT EXISTS `funcao` (
`FUN_Id` int(11) NOT NULL,
  `FUN_Nome` varchar(15) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `horario_atendimentos`
--

CREATE TABLE IF NOT EXISTS `horario_atendimentos` (
`HOR_A_Id` int(11) NOT NULL,
  `Hora` time NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `IPVA`
--

CREATE TABLE IF NOT EXISTS `IPVA` (
`IPVA_Id` int(11) NOT NULL,
  `IPVA_VEI_Id` int(11) NOT NULL,
  `IPVA_Emplacado` tinyint(1) NOT NULL DEFAULT '0',
  `IPVA_Mes` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `manutencao`
--

CREATE TABLE IF NOT EXISTS `manutencao` (
`MAN_Id` int(11) NOT NULL,
  `MAN_DataHoraSaida` date NOT NULL,
  `MAN_Odometro` varchar(6) NOT NULL,
  `MAN_DataHoraEntrada` date NOT NULL,
  `MAN_CustoTotal` float NOT NULL,
  `VEI_Id` int(11) NOT NULL,
  `OFI_Id` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `marcaveiculo`
--

CREATE TABLE IF NOT EXISTS `marcaveiculo` (
`MAR_Id` int(11) NOT NULL,
  `MAR_Nome` varchar(25) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=540 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `modeloveiculo`
--

CREATE TABLE IF NOT EXISTS `modeloveiculo` (
`MOD_Id` int(11) NOT NULL,
  `MAR_ID` int(11) NOT NULL,
  `MOD_Nome` varchar(25) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5032 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `motorista`
--

CREATE TABLE IF NOT EXISTS `motorista` (
`MOT_Id` int(11) NOT NULL,
  `USU_Id` int(4) NOT NULL,
  `MOT_NumeroCnh` int(11) NOT NULL,
  `MOT_DataValidadeCnh` date NOT NULL,
  `MOT_Categoria` varchar(2) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `notificacoes`
--

CREATE TABLE IF NOT EXISTS `notificacoes` (
`NOT_Id` int(11) NOT NULL,
  `NOT_Table` varchar(55) NOT NULL,
  `NOT_Data` date NOT NULL,
  `NOT_Placa` varchar(10) NOT NULL,
  `NOT_Read` tinyint(1) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `ocorrencia`
--

CREATE TABLE IF NOT EXISTS `ocorrencia` (
`OCO_Id` int(4) NOT NULL,
  `VEI_Id` int(4) NOT NULL,
  `MOT_Id` int(4) NOT NULL,
  `TOC_Id` int(4) NOT NULL,
  `OCO_Observacao` varchar(300) NOT NULL,
  `OCO_Data` date NOT NULL,
  `OCO_Anexo1` varchar(200) NOT NULL,
  `OCO_Anexo2` varchar(200) NOT NULL,
  `OCO_Anexo3` varchar(200) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `oficina`
--

CREATE TABLE IF NOT EXISTS `oficina` (
`OFI_Id` int(11) NOT NULL,
  `OFI_RazaoSocial` varchar(200) NOT NULL,
  `OFI_Fantasia` varchar(100) NOT NULL,
  `OFI_Cnpj` varchar(14) NOT NULL,
  `OFI_Telefone` varchar(11) NOT NULL,
  `OFI_Endereco` varchar(200) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `pecas`
--

CREATE TABLE IF NOT EXISTS `pecas` (
`PEC_Id` int(11) NOT NULL,
  `PEC_Nome` varchar(100) NOT NULL,
  `PEC_Preco` float NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `peca_utilizada`
--

CREATE TABLE IF NOT EXISTS `peca_utilizada` (
`PU_Id` int(11) NOT NULL,
  `MAN_Id` int(11) NOT NULL,
  `PEC_Id` int(11) NOT NULL,
  `PU_Valor` float NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=120 DEFAULT CHARSET=utf8;

--
-- Acionadores `peca_utilizada`
--
DELIMITER //
CREATE TRIGGER `TR_adicionar_custo_Manutencao` BEFORE INSERT ON `peca_utilizada`
 FOR EACH ROW BEGIN 
	CALL RO_Atualizar_Custo_Manutencao_peca(new.PEC_Id, new.MAN_Id, new.PU_Valor);
END
//
DELIMITER ;
DELIMITER //
CREATE TRIGGER `TR_atualizar_custo_Manutencao` BEFORE UPDATE ON `peca_utilizada`
 FOR EACH ROW BEGIN 
	CALL RO_Atualizar_Custo_Manutencao_peca(new.PEC_Id, new.MAN_Id, new.PU_Valor);
END
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `posto`
--

CREATE TABLE IF NOT EXISTS `posto` (
`POS_Id` int(11) NOT NULL,
  `POS_RazaoSocial` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `POS_NomeFantasia` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `POS_Cnpj` varchar(14) COLLATE utf8_unicode_ci NOT NULL,
  `POS_Telefone` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  `POS_Endereco` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `servicos`
--

CREATE TABLE IF NOT EXISTS `servicos` (
`SER_Id` int(11) NOT NULL,
  `SER_Nome` varchar(100) NOT NULL,
  `SER_Preco` float NOT NULL,
  `SER_TempoEstimado` time NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `servico_utilizado`
--

CREATE TABLE IF NOT EXISTS `servico_utilizado` (
`SU_Id` int(11) NOT NULL,
  `MAN_Id` int(11) NOT NULL,
  `SER_Id` int(11) NOT NULL,
  `SU_Valor` float NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=87 DEFAULT CHARSET=utf8;

--
-- Acionadores `servico_utilizado`
--
DELIMITER //
CREATE TRIGGER `TR_adicionar_custo_Manutencao_servico` BEFORE INSERT ON `servico_utilizado`
 FOR EACH ROW BEGIN 
	CALL RO_Atualizar_Custo_Manutencao_servico(new.SER_Id, new.MAN_Id, new.SU_Valor);
END
//
DELIMITER ;
DELIMITER //
CREATE TRIGGER `TR_atualizar_custo_Manutencao_servico` BEFORE UPDATE ON `servico_utilizado`
 FOR EACH ROW BEGIN 
	CALL RO_Atualizar_Custo_Manutencao_servico(new.SER_Id, new.MAN_Id, new.SU_Valor);
END
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `solicitacao`
--

CREATE TABLE IF NOT EXISTS `solicitacao` (
`SOL_Id` int(11) NOT NULL,
  `SOL_Data` date NOT NULL,
  `SOL_Hora` time NOT NULL,
  `SOL_Tipo_Veiculo` int(11) NOT NULL,
  `SOL_USE_Id` int(11) NOT NULL,
  `SOL_MOT_Id` int(11) DEFAULT NULL,
  `SOL_Status` int(11) NOT NULL DEFAULT '0',
  `SOL_Veiculo` int(11) DEFAULT NULL,
  `SOL_QPessoas` int(11) NOT NULL DEFAULT '0',
  `SOL_Destino` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `SOL_Duracao` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `solicitante`
--

CREATE TABLE IF NOT EXISTS `solicitante` (
`SOL_Id` int(11) NOT NULL,
  `DEP_Id` int(11) NOT NULL,
  `USU_Id` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tipo_ocorrencia`
--

CREATE TABLE IF NOT EXISTS `tipo_ocorrencia` (
`TOC_Id` int(4) NOT NULL,
  `TOC_Nome` varchar(100) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tipo_veiculo`
--

CREATE TABLE IF NOT EXISTS `tipo_veiculo` (
`TVE_Id` int(11) NOT NULL,
  `TVE_Nome` varchar(15) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuario`
--

CREATE TABLE IF NOT EXISTS `usuario` (
`USU_Id` int(11) NOT NULL,
  `USU_Nome` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `USU_Login` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `USU_Password` int(100) NOT NULL,
  `USU_Email` varchar(100) NOT NULL,
  `USU_Celular` varchar(15) NOT NULL,
  `USU_Ativo` varchar(7) NOT NULL,
  `FUN_Id` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=60 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `veiculo`
--

CREATE TABLE IF NOT EXISTS `veiculo` (
`VEI_Id` int(11) NOT NULL,
  `VEI_TipoPlaca` int(11) NOT NULL,
  `VEI_Placa` varchar(8) NOT NULL,
  `VEI_Tipo` int(11) NOT NULL,
  `VEI_Renavam` varchar(11) NOT NULL,
  `VEI_Marca` int(11) NOT NULL,
  `VEI_Modelo` int(11) NOT NULL,
  `VEI_Combustivel` varchar(50) NOT NULL,
  `VEI_ConsumoMedio` decimal(8,1) NOT NULL,
  `VEI_CapacidadeTanque` int(3) NOT NULL,
  `VEI_Cilindrada` varchar(10) NOT NULL,
  `VEI_CapacidadePessoas` int(2) NOT NULL,
  `VEI_AnoFabricacao` int(4) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

--
-- Acionadores `veiculo`
--
DELIMITER //
CREATE TRIGGER `TR_adicionar_IPVA_Controle` AFTER INSERT ON `veiculo`
 FOR EACH ROW INSERT INTO IPVA SET IPVA_VEI_Id=NEW.VEI_Id, IPVA_Mes=(SELECT `ipva`(NEW.VEI_Placa))
//
DELIMITER ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `abastece`
--
ALTER TABLE `abastece`
 ADD PRIMARY KEY (`ABA_Id`), ADD KEY `POS_Id_fk` (`POS_Id`), ADD KEY `USU_Id` (`USU_Id`), ADD KEY `VEI_Id` (`VEI_Id`);

--
-- Indexes for table `departamento`
--
ALTER TABLE `departamento`
 ADD PRIMARY KEY (`DEP_Id`);

--
-- Indexes for table `empresa`
--
ALTER TABLE `empresa`
 ADD PRIMARY KEY (`EMP_Id`);

--
-- Indexes for table `funcao`
--
ALTER TABLE `funcao`
 ADD PRIMARY KEY (`FUN_Id`);

--
-- Indexes for table `horario_atendimentos`
--
ALTER TABLE `horario_atendimentos`
 ADD PRIMARY KEY (`HOR_A_Id`);

--
-- Indexes for table `IPVA`
--
ALTER TABLE `IPVA`
 ADD PRIMARY KEY (`IPVA_Id`), ADD KEY `IPVA_VEI_Id` (`IPVA_VEI_Id`);

--
-- Indexes for table `manutencao`
--
ALTER TABLE `manutencao`
 ADD PRIMARY KEY (`MAN_Id`), ADD KEY `OFI_Id` (`OFI_Id`), ADD KEY `VEI_Id` (`VEI_Id`);

--
-- Indexes for table `marcaveiculo`
--
ALTER TABLE `marcaveiculo`
 ADD PRIMARY KEY (`MAR_Id`);

--
-- Indexes for table `modeloveiculo`
--
ALTER TABLE `modeloveiculo`
 ADD PRIMARY KEY (`MOD_Id`), ADD KEY `MAR_ID` (`MAR_ID`);

--
-- Indexes for table `motorista`
--
ALTER TABLE `motorista`
 ADD PRIMARY KEY (`MOT_Id`), ADD KEY `USU_Id` (`USU_Id`);

--
-- Indexes for table `notificacoes`
--
ALTER TABLE `notificacoes`
 ADD PRIMARY KEY (`NOT_Id`);

--
-- Indexes for table `ocorrencia`
--
ALTER TABLE `ocorrencia`
 ADD PRIMARY KEY (`OCO_Id`), ADD KEY `VEI_Id_fk` (`VEI_Id`), ADD KEY `MOT_Id_fk` (`MOT_Id`), ADD KEY `TOC_Id_fk` (`TOC_Id`);

--
-- Indexes for table `oficina`
--
ALTER TABLE `oficina`
 ADD PRIMARY KEY (`OFI_Id`);

--
-- Indexes for table `pecas`
--
ALTER TABLE `pecas`
 ADD PRIMARY KEY (`PEC_Id`);

--
-- Indexes for table `peca_utilizada`
--
ALTER TABLE `peca_utilizada`
 ADD PRIMARY KEY (`PU_Id`), ADD KEY `PEC_Id` (`PEC_Id`), ADD KEY `MAN_Id` (`MAN_Id`);

--
-- Indexes for table `posto`
--
ALTER TABLE `posto`
 ADD PRIMARY KEY (`POS_Id`);

--
-- Indexes for table `servicos`
--
ALTER TABLE `servicos`
 ADD PRIMARY KEY (`SER_Id`);

--
-- Indexes for table `servico_utilizado`
--
ALTER TABLE `servico_utilizado`
 ADD PRIMARY KEY (`SU_Id`), ADD KEY `SER_Id` (`SER_Id`), ADD KEY `MAN_Id` (`MAN_Id`);

--
-- Indexes for table `solicitacao`
--
ALTER TABLE `solicitacao`
 ADD PRIMARY KEY (`SOL_Id`), ADD KEY `SOL_Tipo_Veiculo` (`SOL_Tipo_Veiculo`), ADD KEY `SOL_USE_Id` (`SOL_USE_Id`), ADD KEY `SOL_MOT_Id` (`SOL_MOT_Id`);

--
-- Indexes for table `solicitante`
--
ALTER TABLE `solicitante`
 ADD PRIMARY KEY (`SOL_Id`), ADD KEY `DEP_Id` (`DEP_Id`), ADD KEY `USU_Id` (`USU_Id`);

--
-- Indexes for table `tipo_ocorrencia`
--
ALTER TABLE `tipo_ocorrencia`
 ADD PRIMARY KEY (`TOC_Id`);

--
-- Indexes for table `tipo_veiculo`
--
ALTER TABLE `tipo_veiculo`
 ADD PRIMARY KEY (`TVE_Id`);

--
-- Indexes for table `usuario`
--
ALTER TABLE `usuario`
 ADD PRIMARY KEY (`USU_Id`), ADD UNIQUE KEY `USU_Login` (`USU_Login`), ADD KEY `usu_idfk` (`FUN_Id`);

--
-- Indexes for table `veiculo`
--
ALTER TABLE `veiculo`
 ADD PRIMARY KEY (`VEI_Id`), ADD KEY `VEI_Marca` (`VEI_Marca`), ADD KEY `VEI_Modelo` (`VEI_Modelo`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `abastece`
--
ALTER TABLE `abastece`
MODIFY `ABA_Id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=201;
--
-- AUTO_INCREMENT for table `departamento`
--
ALTER TABLE `departamento`
MODIFY `DEP_Id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `empresa`
--
ALTER TABLE `empresa`
MODIFY `EMP_Id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `funcao`
--
ALTER TABLE `funcao`
MODIFY `FUN_Id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `horario_atendimentos`
--
ALTER TABLE `horario_atendimentos`
MODIFY `HOR_A_Id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT for table `IPVA`
--
ALTER TABLE `IPVA`
MODIFY `IPVA_Id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `manutencao`
--
ALTER TABLE `manutencao`
MODIFY `MAN_Id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=47;
--
-- AUTO_INCREMENT for table `marcaveiculo`
--
ALTER TABLE `marcaveiculo`
MODIFY `MAR_Id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=540;
--
-- AUTO_INCREMENT for table `modeloveiculo`
--
ALTER TABLE `modeloveiculo`
MODIFY `MOD_Id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5032;
--
-- AUTO_INCREMENT for table `motorista`
--
ALTER TABLE `motorista`
MODIFY `MOT_Id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT for table `notificacoes`
--
ALTER TABLE `notificacoes`
MODIFY `NOT_Id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `ocorrencia`
--
ALTER TABLE `ocorrencia`
MODIFY `OCO_Id` int(4) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `oficina`
--
ALTER TABLE `oficina`
MODIFY `OFI_Id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `pecas`
--
ALTER TABLE `pecas`
MODIFY `PEC_Id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `peca_utilizada`
--
ALTER TABLE `peca_utilizada`
MODIFY `PU_Id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=120;
--
-- AUTO_INCREMENT for table `posto`
--
ALTER TABLE `posto`
MODIFY `POS_Id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `servicos`
--
ALTER TABLE `servicos`
MODIFY `SER_Id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `servico_utilizado`
--
ALTER TABLE `servico_utilizado`
MODIFY `SU_Id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=87;
--
-- AUTO_INCREMENT for table `solicitacao`
--
ALTER TABLE `solicitacao`
MODIFY `SOL_Id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=27;
--
-- AUTO_INCREMENT for table `solicitante`
--
ALTER TABLE `solicitante`
MODIFY `SOL_Id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `tipo_ocorrencia`
--
ALTER TABLE `tipo_ocorrencia`
MODIFY `TOC_Id` int(4) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `tipo_veiculo`
--
ALTER TABLE `tipo_veiculo`
MODIFY `TVE_Id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `usuario`
--
ALTER TABLE `usuario`
MODIFY `USU_Id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=60;
--
-- AUTO_INCREMENT for table `veiculo`
--
ALTER TABLE `veiculo`
MODIFY `VEI_Id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=15;
--
-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `abastece`
--
ALTER TABLE `abastece`
ADD CONSTRAINT `REL_ABA_USU` FOREIGN KEY (`USU_Id`) REFERENCES `usuario` (`USU_Id`),
ADD CONSTRAINT `REL_ABA_POS` FOREIGN KEY (`POS_Id`) REFERENCES `posto` (`POS_Id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `REL_ABA_VEI` FOREIGN KEY (`VEI_Id`) REFERENCES `veiculo` (`VEI_Id`);

--
-- Limitadores para a tabela `IPVA`
--
ALTER TABLE `IPVA`
ADD CONSTRAINT `IPVA_ibfk_1` FOREIGN KEY (`IPVA_VEI_Id`) REFERENCES `veiculo` (`VEI_Id`) ON DELETE CASCADE;

--
-- Limitadores para a tabela `manutencao`
--
ALTER TABLE `manutencao`
ADD CONSTRAINT `REL_MAN_OFI` FOREIGN KEY (`OFI_Id`) REFERENCES `oficina` (`OFI_Id`),
ADD CONSTRAINT `REL_MAN_VEI` FOREIGN KEY (`VEI_Id`) REFERENCES `veiculo` (`VEI_Id`);

--
-- Limitadores para a tabela `modeloveiculo`
--
ALTER TABLE `modeloveiculo`
ADD CONSTRAINT `modeloveiculo_ibfk_1` FOREIGN KEY (`MAR_ID`) REFERENCES `marcaveiculo` (`MAR_Id`);

--
-- Limitadores para a tabela `motorista`
--
ALTER TABLE `motorista`
ADD CONSTRAINT `USU_Id_fk` FOREIGN KEY (`USU_Id`) REFERENCES `usuario` (`USU_Id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `ocorrencia`
--
ALTER TABLE `ocorrencia`
ADD CONSTRAINT `MOT_Id_fk` FOREIGN KEY (`MOT_Id`) REFERENCES `usuario` (`USU_Id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `TOC_Id_fk` FOREIGN KEY (`TOC_Id`) REFERENCES `tipo_ocorrencia` (`TOC_Id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `VEI_Id_fk` FOREIGN KEY (`VEI_Id`) REFERENCES `veiculo` (`VEI_Id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `peca_utilizada`
--
ALTER TABLE `peca_utilizada`
ADD CONSTRAINT `REL_MAN_PU` FOREIGN KEY (`MAN_Id`) REFERENCES `manutencao` (`MAN_Id`) ON DELETE CASCADE,
ADD CONSTRAINT `REL_Peca_PU` FOREIGN KEY (`PEC_Id`) REFERENCES `pecas` (`PEC_Id`);

--
-- Limitadores para a tabela `servico_utilizado`
--
ALTER TABLE `servico_utilizado`
ADD CONSTRAINT `REL_MAN_SU` FOREIGN KEY (`MAN_Id`) REFERENCES `manutencao` (`MAN_Id`) ON DELETE CASCADE,
ADD CONSTRAINT `REL_Ser_SU` FOREIGN KEY (`SER_Id`) REFERENCES `servicos` (`SER_Id`);

--
-- Limitadores para a tabela `solicitacao`
--
ALTER TABLE `solicitacao`
ADD CONSTRAINT `solicitacao_ibfk_1` FOREIGN KEY (`SOL_Tipo_Veiculo`) REFERENCES `tipo_veiculo` (`TVE_Id`),
ADD CONSTRAINT `solicitacao_ibfk_2` FOREIGN KEY (`SOL_USE_Id`) REFERENCES `usuario` (`USU_Id`);

--
-- Limitadores para a tabela `solicitante`
--
ALTER TABLE `solicitante`
ADD CONSTRAINT `solicitante_fk_1` FOREIGN KEY (`DEP_Id`) REFERENCES `departamento` (`DEP_Id`),
ADD CONSTRAINT `solicitante_fk_2` FOREIGN KEY (`USU_Id`) REFERENCES `usuario` (`USU_Id`),
ADD CONSTRAINT `solicitante_ibfk_1` FOREIGN KEY (`DEP_Id`) REFERENCES `departamento` (`DEP_Id`),
ADD CONSTRAINT `solicitante_ibfk_2` FOREIGN KEY (`USU_Id`) REFERENCES `usuario` (`USU_Id`);

--
-- Limitadores para a tabela `usuario`
--
ALTER TABLE `usuario`
ADD CONSTRAINT `usu_idfk` FOREIGN KEY (`FUN_Id`) REFERENCES `funcao` (`FUN_Id`);

--
-- Limitadores para a tabela `veiculo`
--
ALTER TABLE `veiculo`
ADD CONSTRAINT `REL_VEI_MOD` FOREIGN KEY (`VEI_Modelo`) REFERENCES `modeloveiculo` (`MOD_Id`),
ADD CONSTRAINT `REL_VEI_MAR` FOREIGN KEY (`VEI_Marca`) REFERENCES `marcaveiculo` (`MAR_Id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

--
-- Extraindo dados da tabela `departamento`
--

INSERT INTO `departamento` (`DEP_Id`, `DEP_Nome`) VALUES
(5, 'Administrativo'),
(6, 'Departamento Integrado de Operações Especiais');

--
-- Extraindo dados da tabela `empresa`
--

INSERT INTO `empresa` (`EMP_Id`, `EMP_Nome`, `EMP_Sigla`, `EMP_Telefone`, `EMP_Email`, `EMP_Endereco`, `EMP_Cnpj`, `EMP_Logo`, `EMP_Tolerancia`) VALUES
(1, 'AKTO Tecnologia', 'AKTO', '126456', 'ako@aktotecnologia.com', 'Rua das Casas', '12345678912345', 0x89504e470d0a1a0a0000000d49484452000000630000005c08060000007a170bed000000017352474200aece1ce90000000467414d410000b18f0bfc6105000000097048597300000ec400000ec401952b0e1b0000213349444154785eed5d097816d5d53ed9f73d10c216206193454436c15a5404fd55440415b18888d6adf597b6b62e686d45b4b58a565bdc05eb5eb7a2162b88a0ec162a6eec4908490884ecfb36ff7dcf9df3cd9dc9f785b068f17f78e7b99973ef3973efb9e7dc7566be4990a5402770d428293e48c9a92976ecc8106c9fdb8deddf7c4b8fdcff20a58544516d4d8d9d7a6cd15c5a4205979c43bbbac5d08e94200e3b53f579873a9fd66720cba11d491898d6adb52c689547fee47338cfef021f2e795fd9229a2acacb69ee9cdbecd423047a467b919fb7d76a6969f1858ec19156617e81cd3d7234ecdc66ed48211d92f5397b488655b260beaf2c00e7f9737f6b65c4a658bd123b5abd53d239f4ebd8d51a90dec31adcb517cb99401ec8cb97bf1d50e6d162c1fd0f2a1b44d9318d271e5a6053878fc372063063d2549bd2f02ad35e54bcbac8659cc25953ade6da1ae689f18187e73d609d317818972361c7d66d56eeee6cab606f3e87a2c242ab78ff016b68cfbe3e195cf3c8bc07ed5c1ca00c9425e56e57ce2f57ba1c09508e897347fdc8a68e0c873d4c9dc07708db298785cca4343ed7d4d470ebd8b96d3bc70f851de991dc1211d02a8be7dfed1a865e7de145ab5358acaf759ba1831a128536872d338cee7f32cb89ac3e3b74bacafbb5c57f735d537cff5d3e9d1076768de6bc0f85850bfecc79ae5abe82f3e99fd6cde61c398ec819401f355663cc8422a8ecd821c36d8e07cdcdd6767b48d8337ea4cf088221ddb3f87a1d1c438a014d9ed092873760ce1007e0ec8f36e328db9bc79e73866b7d9563a0bb3f74898ce7eb6b6b6badcfd76df03b571d098e7a69bb61f55a1a326c28758f49a69ebdb368edb75f70bad5d040bbd223888288926fff3d25cdb993828282e8a5e75e60fe9c6b6fe4b303a8a184f90c088db3098b8a9a6ba9baba9ac6f41fc22965a5a5bcb20b0e0ea6e696667585be4635b5803460c61f7df649a6a7cd9c81064aa50fcfa392f973154d9455584f41e1e1ccef1a95a0ca09a12d7b775165452575cbe8cee9c702c7649fb1fddbadf4f6ab6fd0c3f7ddcfd55c9d58c7364cbae997947aef1fb972e3478ca12d9bfea3b86671da183a2d100db87951d1d1caf8d574dbbd7773ea2feeba9dcf670d1d455f7fb185e9a3c1e0a143e8a38d6b982ebee75754f6c4434c8f298da28888083a63dc59f4d8734f1df5bec28b63bae99b3ff75ecaddbd9b1db346f5905eaaa75c76de445af9d1725be2d8a0a8d9fffe66fc88d3e98b7f6fb263478f1f9f7336bdbe7409fdf2fa9be9c5a79fa33f2d7c9cde7bfb5d7af583776d89638b63e68c5d9d23a8a5be81c6d527a961eb545af7e96a9be3c06cf380376ec2e479e5e00ca88d610f10fa7f468fa5cfd7af57b2417c8d7925febaf3d4c396570ef0cac6c4c652636323858785d1d2d0033c6461e83ad638b1b43d8e70d4cec024b7332588e2675e4fbd0f5af48aeac249c9c9dc7a67fc7436b73067c2d4b4c483556b86dcdaad7a9cf727ebd0ad811e81505f574f83baf4a46fb67ca952756bd7ad5a4fd172bd9c118a9a6ab8ec1435ee434ae4bcb2189276951551efbe7de8a5f7dfa6ace2164ab8fa7abed55272ff5c2571ec7054c354fe456752edea4f28f3400b0f13b847630295adafaba36e3149767551415d1ce258fdf41b78123df9d262fad1a0a13eae292bb4632240a58784527c8f748ed5ee2fa5c69a5aa65b9ab19ad2d280970610df76209ffa77ec466a41cb69adf523daa71c06a8fd89727a8b2f1f3812d8d92198a2c78ca52eefaee0f8d1e2889db1a3630805b5b4b02360f08cd864952a55d71583830a1baba8bebe9e32d4d23710aebff5e7b4f091c7ec9883e03065f00c6df023414b6313d59755527d7995ad95f3f7d6db6fa305f3ff003123153a072b0759b44fe9adf61da4f614ca11e06b886c6e5529454446d02ee510d5aa286b7fb316380a1c913376768922e501760426b66e518936c70db4b26055b981434ea62d9b37ab4a48955ac3ec0571199d28444d96470354cb3bc13754d550cdbe833a4d1d61a161d4d4d4a82818d86deee09010ee653a4574d3fd46e8bcda720a537ac2214151d19499570df123c6613b03f30374c92a568aa94b3b85c6d81c5369879673f71e19949b9343fbd5860da828afa0ace434a601c824f4ea4a41c1f6f5b601453da1c5c080c903bc7c1326af7a5f313b0640b9fb9a1c230eecdc93cad52612bda2a9b9c94ed570eaa363a065c88243a04d6f659723c5614de0b9a7f5274b69821e818d9ee908981fca0a1c5a2bbd272797722b0fb25110e213e26990ea31e0272a272466756347980616038a114d438b9c17928eb3499b884e4ba1c44c559e3a42ed1e28e57cf6f526eeedcddc2b509e1900379da66cb063eb363d6faa62f68c1e60f30e1f2796b6c711da354ced513d02a8dfbe9597afb8c4dd2bda02fa05da906e4dd7fe4cdf937afacf7fe1337ac4d102fa98bd069034a99ed05eb9f2ec7c9e1b264e99ccf1257f7f9b351629310ee2fe6800715979ed4a0da6b0be27319db1e66b3eb717877486ef869f42c6e73b2824a3975aeac11166a5bc6a9abcc048c8547384c738ff0d586a7e28dfbdd78e615875ff0544cbb678583936e7eea6dce1bd399e59e0dc606c0fda76865272a75ac276b6d7d158537bf712ba15f937a8c9f3cac5f7e84cc1a12176ecd8c3ec0526ed85f0ca76e6498a0a6e59477750e06a5a3bc4cdc3845ebb66a5a2880ad43e8c97bc6ae9db1eb4e90c3cd80f8e4fa09ebb4a398e357773937b3ded35b20993e795939553edc172b517a8a0849e5d54fcd84d6187eb0c41d9ce3deaaf5bd66b70a1fd3923343494f2eb2a1445949d99442d15e5bcf26c0f02d65eeee5c311178d1dcf018ed0456a388a68f8e385448451485404af5e302c618ee079425dd65cdf400de595bcb1832360180c1755050798e67cd4d9a44d983cc0a44d03836e8f1c43ed8b743df0571f803e8baca6fdf19a9b9a68d299e33948236eef6d93803d03f75e32f756535064142fdf344ce33b0a990ed13078cac8d11d9229343a526da45afb1ec5c3202dcad1d5ca09a1315114991c6fa7355165de7e0a8d0ca7e84e292ea37a0dec457b65bdbcaafcfdd454a7c67a457baf403d757d754c9c01787900f62f565d2dedea1ac30b9f43e1c4d2f63882df9e81b90289596a2333203d830e1e28e674e905fe5a87f40e2f4fe405b1b1717caea9a956ad3d95c2548ff107b97511d3a50385456919abc5a2ca3d857ccf2aa673076ed581806a09dfa4bdf0f24ad59ca17596f6edc0a98f8e499d012f0f48edd081be2eccd5f7af140e357704ec1999b995b437778fcf118014ad0bd531d0a6525e9eae94738484847028a8afe46169fdda7514d3a0e70f13e1b1d13cb788231aab6aa922a780c2e36328265d3b02370211aa0b8ba922b7901de86d5b66dccb33011e3b461d003437a5a51e80aea153677f3c1cb01d6cd84bd9b23d68d5337286f6a4a6bd7b7849e65dc6fa83b4087f30795e398ca7b885bdf5c05e9f910af30b6858df0114d7d5b9671508e825557b8b986e6e6ca4d82e693cb708ea4a2bf86e2d6ef8610e0a5373913fb0039463911f50be1b4b5c777d1cddb58384d6a60fc403743e7894802d4268d7eed4635336a7f9432b676088ca2c6aa2205509718699b569549306fcf102c9c319b9bbb369a3ea1953a64fd306b10d03c051b541cd149e10cb712f1f10d5250d71f4b0dae232b2d4822022318e83f02087de535f5a49cd0d8d3c4446754ce68545d92e7b9fa1b2d47a32e982531f1d032df0f20089f3ee1c7bb6b4d0366f24ba86a9c2999728a515a1564093ce9cc0999905eacc754188890282b678ee6b95ac324c8fcc5e74f3cc6b7d8616807ee3a3f729a7a880366ed8489da313a9b1b6ce2767ca02665a4844b8ea251d795309470aaf5139a1326f1fd51e28a3b0b868e663850647f0b512be034c1d7f01db14e6d8a76c1c082e6754bff71685f7edcf955ebb6a15a7c18030a16346e4e956da8c7b79a6537096e3d209173846b0613a65c0e041fc4e569f9474fad15963a9b6a8846a0e94720baedcb38f65201f28201fa181f0b8188aebd6496d2e3b53a4ea2d7002780d95355a46ed2f648fa1aeb2ffba0f9327b41c5e9e19fff4e3155c066c5ba56c1c082e679cc07f17ad9cd17df5d7b4f41fefd97e7543e2e271a14d492f0fed5c64cc63e5b28fb9b548bf007debb537f20e1634c28831a7f1e4d7a3574f1efb1bd4841c911047d16a9c2fddb1874a8c8015953f484f034c5a10161bc53d4ecde01ca01b00cd4c69a907a06be8d4d91fcf8c838fdf71c0b66dc1e78cdab5f6b0a48c70d5c59732fd5d030f9c8aeca76c7f7be6797e45130f7b3e78e71fbc78b8e2828b69d5f28fe9c1471f6667e0764a74872436fcfe965a3a6084bcf2626aacaee3bc4c60478d551796be18deaaf20fa8a1a95a2f8bd5245f919dcf4efeae3163d254b62d50bb46dbda0bdf6a2afba4748a1c368a3a2d7aeb309e55a055f8eb431a26cf9f5ce76e5d6973ce766eb169a1d1fc48f6aac997d20b6fbec68ae3d16cdfb4ae14dbb9036ff4809afd2534e9a28b68d8a89168399c865f53ad57f3cb979bff639463d19cbbeea0db7e7b17cb20bf0bcf18474b562de3972372aa0e72daf0ccfefc38d8d14db77313669e4e2fd054601ee0ce072bc87d574da6da8deba8d7b78576aa039f33b0a4edf1e55e0a4defe2e736b98614298a9b34e08f17481e3420cf90d100a06c0755768832126818cb568faaabaa69ce7537d03fde78cb7ebd06f9689e5037de7a0bdd39fff77ce7d4bc16744a7024252524d28e924276bc59aed64b203a4bee0e9cfae898d401f0f2006f3e28b3293f8f728764f8dd8d3bce4809a2ac8316951c3c48fd3a767565229923458ca9b9a280a4091c1ee028ea95d3ad05c6ea1812456f2c7d8fc68e1fc7e930525e4da9ef1935d4f41a58687f10feee1d3b6978bf41546ae9d731f1a2c17fcb195bf7efe517fc707bc49f3378ce68292f93ebb9e59946038d9893a20b3161c6bd3c5112c0590e89e7ecca56613765f5e943174c388fd3013829323c823785e20881181a6749175a02f8375c3993b2faf6f139028023c2c3c2f98583fd4545ac83d6518213f71e6e59b7849767c6e560db425f557db6b9072796b6c711d819f55b36b1b780d716ff8dcfdaa36e481c1cf0853625bd3c642b32e621fc9bafba86ba6564d0932f2fa26aab91d30578943562f46994aa8630fc20069056cf2dcc86a409d67fb686e242c2559e8bed1407b52dcdb4b7ae9c1aeaebe986e9330d5da0b5536bd04e8eda3c6e59a77c7f3c332ef9c0b6a227dbdc037646ed8635be0b36addfc067c9ca0d272e945b650d93d7961cf0f9baf5bc1bc65b872f3cf98c9dea46891a6630d6c60787d319834ea53cb524368d0f1ac359e7f0388a080aa1513f1aa31ceb7e010d507b6e2a69d04b69fce066f52758624233e4054d11245fc7dc4e3d4c592d1798d73a9f7f2bdb4a2382cdbd60673417e62b218e2bf8081fccac75811a5a1147de1f4fd24c1a008d0337090128f9936b67d1ef7e73274507e965ac1795aae77cfad526caecd58be799fcbc3c0ef3eeb89b468e19cd6f6734907e91d98be4a008cac9cee695963872fa3557abbfa23fd210444fd150cbeab329ebd4c71f2f603e285bb161732fb4330eecd779d8f0970900da6c2f5e03b7c5735fab65713cbee819d7303377fe7d54d5dc403de33b5014b9df1e8950ea9e7dea286a5043cd989386508fee191c069d32847f16909998466a516b4b6b240485d3b861a3a958ed61ba7a7e7ff7a7271fb7a9ef1f6c730fd819219d3a6b67da686d3417db6564c06b7413b85ad2709643e281c67efc26a2baa591e3588ee25c6735f36fed72b373b81734a9eb112ebbec520a8f08a79da5fba811afee1bd79436d7d1bf367ce62b076733b00eaca30427ee3ddcb26e092fcf8cbb0ee8a1aa1892ae6cee013b2362e8708e00d131eddf7d1f2d9e7ae5459b3a3c0ccbd26fec09ead5d074f355b3edd8e12126463f2ff93e60da36f214c7e60276c6091c1f6067440e1eaaba34c769c2c4f3f92cddcb84c4f1177c4dbba5bc3c9dad96d2923ae06eec498306d2a8be83b404860c5b091942045ede9469ad6f64fef985a75946825c2379996912f06e136e8f6cc9df6d68a664ec1aa044d0fa70f3840ec433e3920f6c8b72810865732fd819e1fd072a45d5054a70c6ec59cc405681802284af9571a4bd3cad9ca6f12202eed2220ce99e4593cf3e97d66dfb92ef85a16c188bafb38d25c0437d93b7f0a5456a223f8daf4378e0ee7b992f61fd67ab7df9495e428b4cba5a06bfb3e25fd43532815e5ffc323b0501d03510dde5d0109ed0817880c4251fd81665230136f7c2354c4170f4d83398469666c6808eebcc3547ff1565bcbc4f366fa057de7f87069e3c98530a1a2a69649f811c1e5ff42c7d5590c3e9b8f581dfcd01acac7dbef6f22bd980ab96eb777d410b967dbe86af43f8b5fde37cc1bc3bef71e563d200cac2cfc4005c8fbdd5f37f798a037a2c00e3a1f12cb51f2d98002f10bc3c332eb60d049f3382d4fabbf275bdfb06cc4ce004af63842f52680302e17dbcf423ead62383ce9f3c896fcca11563a78d30462906e33e3aff0fd429349afeb97625dfd403d2c363a9b4a484567cf811c7fff2f002972340e3de12cefec2c635eb58ee99c7ff4a3bb76da7d4e0481f6fef9e3c7a7bc5877c63f2dd37de64b9e7fefe0a1dd8bf9f033e470107252627517e7d054dfcf13857fdf5d9a1e590b8f00089fb0e557ec56b8bd9d67ea10418f9d32eb076758f635a3e9ca23f7e221f52713eaca2cf0e6dca79792f3df78255575bcbb45a6efa0270c72d73586e5f4121a7e1235eca2096da2973bc77723acbf54ae8c067a0a1a181cf5595957c06205b527cd0fa78e9bf388e3c91f6e64baf5a078b8bad107d739ad3f0f116202f3797e59e7af4718e8387505757e7bb7e40a70cebc619b3388e20f5ec60d08178665c64805ddd63ad02656b7ff039a3a9e4207ff906509b275726ad030a73c7fdf11a1b1badca8a0afeb490402aad7a09cb8016e0ba471ff8233727e0ae5b7fc5e73387eaaff1004d8d4d4ce3635f921750565a667dfaf1271cc7679200e1c504855acbfef921d32843ae43800e5da3129927501b489f6e9f7cb44c5de3d4c9748218dd1fcf8c830f9b223f7c4609b6f687134bdbe3083e678424e1034b6a9b5e7a903fc262ce015e609a16be1e0d1d69e16122bc66ea15d437b50b8fbdcaf11cf03007213c2282c7669954c103b56ad9c71c7f61e1d3fcaa0e70f32f6ff5c9c92b3651d1517c46c0b509890974fa993fe6f8a8d3c7701a1e94bdf9f26b14aaaab96ad9725f19721d0274403a2675fde37b8b77f348879eb17171b4254f2f7d015d3b5d5bd0fad0307980c4c15fb76d0bb59495a832b5adfdc1b39a22ca3939833a764ae32ccd8c011dd7996b8efe2bca983c7cddb34fff7eec08541ac0441d1119c921d77e060dc0003de35399c6dd5be0ea1baee3db185141a134ed8a2bf8fd297ca8e5a619d7505d6d1df54aec48437bf4e500e08b3ea3fb9f4cfdd3bad3c79faca098e0307ef178caf4cba9dc6ae07ca53c2c240448db5b5bc6371011e0004947839a7de9953475bcde7b091cf3b7869727f1d48e1dd9b66d4219c28792c71ef4cd1bbfffcd5dc698276323e2e6b868c6ddbcb75f7dc3372e2f57132b786fbdf21ae70d080f01633c2660e4bfe4cdb7b5c78f71502b352e0b65a89598efecd5e5e5e71631efab2fb6f8d2a69d3fc9aebbcc030e2dc1cb33e3f3effa2de783f902360e0497330038a3f2ddd7f962b3100966619a96b843778b4ef455242ba913a73535e98957c0ca7dbbd5523dc2da939dc3133a563a58798553b05f831e4d107d46f61e680dedd1c77aecc187ac8bc69e633dfbf85f7d3c04a0492d3ca0f3b0cc7ebef4cbce9dc869a60ddc7609ec0c5c0f9bc2196da115b766cd4a760832189175922f632773ff0a89ccc9caa06a776cc8b9572f124e1f708aa5e613bb54cbcad99ded93c575c94111562485f8356c7b831a20acb8a0302b29289ccb40de28e37ed55205d75dfe132b2d34c6a51b20b2086828085815228ed59159679d26f6d0b4c447640de0fc60d39ad52b990e04bfaec28545b7cc7629e40e28cc1dc7f98b7f6fe2eb65d98a80a100f9ccb9ee268e6b65d17b9258562a0f608d3ff392cbec98337c4c197f3eef35d4ce9d9dd42532812b2b46c2071c91373edc78e545975873e7dce6eb890fccbdd797cfd5532eb73e5cf2be2f8e00cc9a3acda72fc2a5e75ec8e9e06b9d75fd807977dced9313a38b2d44cee4230fd8923f4079089c58da1e4fb09de242d1cf67f1e74481cfd7ae77795b7b1c67e996fafcde5beff0064fcbb879427b5bce75d37ec26500d24a376dd8c87266cb9533d0569a09530e01e5dd7aed0d9c66a2f8c001bffaa1c7a995952f2e69e8714f3df6842bdd0c661eb01dcac648b3ef67b3ec12032360df8133f6df792bd3ee827461423fad143ba82aa41577f344319ccd34a165ce1083019fad58c9d7800f483a60cab517d8b1ebfca25c770204afbff8b28f7f38e195e71759670d1de5972701800de18cf620b0143e0e8cad7be94136368218510a83e1c43838bb5b92637c893bb41317034b58f8c8632ed9bd7bf25ac92048998102b066d5a79c17f211ddbd72179f35c1c7f3cae26c06e1d5abb90dc0f5375f35dbc5c375622fd88e1d11e063c55e049e33828329382e9eb2b35228393595c3b3afbda4187a57891d2aeebc022a1fbae3965fe8e7cebec50ce4f4a60769a0014d6b0e80cd956cc6709e3ced3297ac5a86929aec5bc9a14c6f9a19705776d2d8f12a07d9050751f79e3d5bc9ed2b28649e967364f55ff721bc3ffcf63e5ff978a8955d5eece33da36c949492c201b60b8a8d675bb607ad7ed3e7055e888e993895e9f4e75ea74e613154d8a09f05401900ef2be196b686a825318d4071ef2d11406e4b20665e97989848cbfebd96129312292e5e55d206ae877c7555153fb4aaa8a8e4eb4c4d40cf7ff4619a75d3f51c17f44eeea4e42b7c72805ca7b5713436f3c46e1d2fc309f073861ef1a9fc267de12cfd24b2fadd37f8fde5f6e290ce00e010e0c795b1945f5fe9331a8ca02635435dadbaae86d39200d080b7d2f26536e429465df4e433f4eb9b6ee174c0cc479c8772f1e00a3873c2393e8722dd845c7bd54f67d3834f3cea931388bc573fb34c2f4c9e3c8c12fd0747c4d25b71fa45b9f67e33447062697b1ce190cec0ab945df26a38a05708d6acfc946faaa1a54644b4ff9b4aedc1f0d34672eb3b14d43293437b80de5659aebf7673ac805e011ba8e5b89d42f4455d251d7c673587c3459bce9830f2744aedd881a2a2a238a02b22e0f769f889178057ecf7549752387fe40add177f01c798ce10a0691dd7b200f214a072670e1de99335e5400bc0c33c85e01d7a4c98434def94741a96d9cf8eb9013953d6a4bd000f8d908768a53b160a6a65a9794a9791a78fe6b071ed7adf17e7da8380ce3825a3372d5df729bf202c4e00f0dae57553a6514e65314f605019066c6c703e372115c15f184daa891c34adf988d7d5d5d1575f6ce13cb002024c5900b4768c067401afb9b98583e8a7e72f7db01c9fdd347e470839fc8b89651f2c75f1bcb2dec3e4415f7c3168c38eaf29b7ba84a69f7721f54ae8e8b313306cd4089a7df30d74fbcfe7d8296dc3af33f0f1964d39dbed98328af236428fb854ba70cac5945bafbb3bbf44acce132e94fbfd7ad2d69592695ca7898a9ad61c00bfaf1b77ea699ce64f56e4b4636c5ae9025e4b73130740567390937cf4d94de300f061e4e9174e76f1fcc99a87c98bc448a196f219bdf47239b7ae829f9de07d5f691c4807e63ff6b05a851efacdc556ce387dc029fc251840323b35b33f07bc25fee7e79ff6a503506efdea35f4ebdfe9d765c081b29a86e242e9434b78f96dc97ae4e00854541d4dca0108483ba953772523875ca3353169f044aab55cfb64efbcef5efad96dbfe01f799a86c76a6dd68d3fe5e53582a4e35cd850495d037c8c59d06a698bee87f110c979b97bd4dc3089566cd6bfd9c0d78d01b904056168898f89a11de507a8a8701f0dee96c92a4375288e0a00ba3aba42022f3f90acc993a52d5adae36ac3055c72c5e5acb73f042ac38bb6ca34f1657e367548eb48f3879f429b93bbd01bff7a9fd3611331bcf4d2d3fa0da625ab9653a7cefa13e2781b1eef7b05c221575327f0fda19533d0f2ba4426f0176fb09adaf1ed36ee1108f0baf40ae0d92716f2a6ad494ddef8627e5a7a277e7513ed0b6d4be0b43a4deb385a9e20b06c2039fcbb077c3311012d3210ccd61da85700e0b5258b32b094c5fb01f8b56ae3d6afe9b5a54b6870d75e3ebe9ce5797a7565159d31682815e6e7f3b752daea1580df9e91af564933a75c4edfecdb43db8af3a973443c07010a3cfff433e91afbd6c2ee9a328a3d7f322b5938ed0276283eda0ef56050a9264ca969adb836b5dbf85e59c09403644890a56d53237ea5e13e588ecf6eda7b98bc40b279b565fc7b9082cbcfe76f37c65c3099eea96a24fccb892d7b77fb6c238d153f7543f88d9a47b71517a8e1ea647afdc3f758a62d041ca6f09e2cbc9e9894442bbfd8c8017b0a18010526273baf9b40a9f4456f52cfad4554fdd107dc4b421bea95536ae8b3af36db55d2d03462dad0dae032cbe879c694f5ca6d5abf9175309db172d972e69b07aed56737ed3ddc72ee387447cf475dd0d06a54dd7a6d2ba2f417f46ba1826fd482471a08e6aeb3cf9bc001ffcc054b686c03da0595499b78f199e7f9d1a904dc2ac64b036d61efa4b3f8d6f1ce6e31564b6323df6afee6cbafecdbcc3a8096b849b7c5c3f9dc5167707e5da312ace7fffa1487cbce9b685f2bb7bbe51a7d6bdba40f2587005d01e88e3ae09129ead416b66cdacc6fb9e04d47c184c3fcf7a2879cc0afbc6626df0d45c0fb431837278f737e3cef0f5dde5ece37c9d25f7c8776a685d1ced4604a5ef8105f2b3f0998b740ffbbb5c385dc7ac03f1dc117781036a8a5f5d100777359373b242ffc23df1c85eea803eebca24e6de1ca89975081da7f41978fdeff27077f6fb0b78576ddb53571b5da7d1f282aa2f73ed56ffeb5078dbbb653cec8be1877282844fb1fdf4044d1e8daaf3cbf986e99fd531e1e003d3cc9d0a4e3268da1a3476c0add3eef5e4e9b3be7573ebe17de6b855ef0cc429a76b5fe0789d001df1064a88d1c90b15e2d5c32fb30dd1e949795f38efee2cba7f2b07d2438b2ab4ee0bb017ac6f70635e7e40ccbe28067ec0805575ec4730002d0d8d0603df4bb796aec96479d12309eebb4e9174cb67ac4a5587ff9d3020ee6781f283c7cdf7c957723972128983e91e736849c117d38b4f711e97781c31ea68e255aaaab287b5037b22aca308660f340a9f73d42f133aee5cf7e63f810f5f07e2d7e4083af0c3cf6c04394bd7317fdef1dfa3fd363983be7fcf3e8d45123e8d49123f86b0a78315aae453e2d353554b1f8292a9e3b87e4b3a9c10989d4f3cb3c0afe1e7ff1da16feabcef002bfead97fd355ec17406681a0e8688a9f7e0d459f7136458e1c4321c9a9d43fad1bff173300cb6f3cc96b2e29a6baf5aba966d572aaf8dbb364d5eaa7709ca19d59c7271651fc653374e438c371e50c7fc0ff012c5ffc34d52e5f4acde841fc637ba2b16591f48bdfddc332510fde45e3c2f4ffe723b54008894fa4a8b3cfa504d5c3a2c68c65991f028e7b670402fee9d4bbafff9de921c34fa571e79dcbf40f193fd8d554ef7e7de9c3251f70888b736ed5fc907162697b1ce1073b4c01f232c2f66fb6d249835bffc8fd87861fb433febfe1c43075dc80e8ff00a8aa652394e972340000000049454e44ae426082, 10);

--
-- Extraindo dados da tabela `funcao`
--

INSERT INTO `funcao` (`FUN_Id`, `FUN_Nome`) VALUES
(1, 'Administrador'),
(2, 'Operador'),
(3, 'Motorista'),
(4, 'Solicitante');

--
-- Extraindo dados da tabela `horario_atendimentos`
--

INSERT INTO `horario_atendimentos` (`HOR_A_Id`, `Hora`) VALUES
(1, '08:00:00'),
(2, '08:30:00'),
(3, '09:00:00'),
(4, '09:30:00'),
(5, '10:00:00'),
(6, '10:30:00'),
(7, '11:00:00'),
(8, '11:30:00'),
(9, '12:00:00'),
(10, '12:30:00'),
(11, '13:00:00'),
(12, '13:30:00'),
(13, '14:00:00'),
(14, '14:30:00'),
(15, '15:00:00'),
(16, '15:00:00'),
(17, '16:00:00'),
(18, '16:30:00'),
(19, '17:00:00');

INSERT INTO `usuario` (`USU_Id`, `USU_Nome`, `USU_Login`, `USU_Password`, `USU_Email`, `USU_Celular`, `USU_Ativo`, `FUN_Id`) VALUES
(1, 'Administrador', 'adm', 123, '', '', 'Ativo', 1);