DROP DATABASE IF EXISTS sysusinareciclagem;
CREATE DATABASE sysusinareciclagem CHARACTER SET UTF8 COLLATE utf8_bin;
USE sysusinareciclagem;
SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema sysusinareciclagem
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Table `tipo_cliente`
-- -----------------------------------------------------
CREATE TABLE `tipo_cliente` (
  `idtipo_cliente` INT NOT NULL AUTO_INCREMENT,
  `tipocliente` VARCHAR(45),
  PRIMARY KEY (`idtipo_cliente`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cliente`
-- -----------------------------------------------------
CREATE TABLE `cliente` (
  `idcliente` INT(11) NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(100) NOT NULL,
  `endereco` VARCHAR(250) NOT NULL,
  `telefone` VARCHAR(15) NOT NULL,
  `status` CHAR(1) NOT NULL,
  `idtipo_cliente` int NOT NULL,
  PRIMARY KEY (`idcliente`),
  CONSTRAINT `fk_cliente_tipo_cliente` FOREIGN KEY (`idtipo_cliente`) REFERENCES `tipo_cliente` (`idtipo_cliente`)
  ON DELETE CASCADE
  ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `categoria`
-- -----------------------------------------------------
CREATE TABLE `categoria` (
  `idcategoria` INT NOT NULL AUTO_INCREMENT,
  `nome_categoria` VARCHAR(40) NOT NULL,
  `status` CHAR(1) NOT NULL,
  PRIMARY KEY (`idcategoria`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `material`
-- -----------------------------------------------------
CREATE TABLE `material` (
  `idmaterial` INT(11) NOT NULL AUTO_INCREMENT,
  `nome_material` VARCHAR(40) NOT NULL,
  `quantidade` INT(5) NOT NULL,
  `status` CHAR(1) NOT NULL,
  `idcategoria` INT NOT NULL,
  PRIMARY KEY (`idmaterial`),
  CONSTRAINT `fk_material_categoria` FOREIGN KEY (`idcategoria`) REFERENCES `categoria` (`idcategoria`)
  ON DELETE CASCADE
  ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `usuario`
-- -----------------------------------------------------
CREATE TABLE `usuario` (
  `idusuario` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(45) NOT NULL,
  `email` VARCHAR(100) NOT NULL,
  `senha` CHAR(32) NOT NULL,
  `status` CHAR(1) NOT NULL,
  PRIMARY KEY (`idusuario`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `entrada`
-- -----------------------------------------------------
CREATE TABLE `entrada` (
  `identrada` INT NOT NULL AUTO_INCREMENT,
  `balanceiro` VARCHAR(45) NOT NULL,
  `motorista` VARCHAR(45) NOT NULL,
  `placa_veiculo` VARCHAR(8) NOT NULL,
  `peso_bruto` DECIMAL(5,3) NOT NULL,
  `peso_tara` DECIMAL(5,3) NOT NULL,
  `peso_liquido` DECIMAL(5,3) NOT NULL,
  `data_entrada` DATETIME NOT NULL, 
  `data_saida` DATETIME NOT NULL,
  `observacao` VARCHAR(250) NULL, 
  `idcliente` INT NOT NULL,
  `idusuario` INT NOT NULL,
  PRIMARY KEY (`identrada`),
  CONSTRAINT `fk_entrada_cliente` FOREIGN KEY (`idcliente`) REFERENCES `cliente` (`idcliente`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_entrada_usuario`
    FOREIGN KEY (`idusuario`)
    REFERENCES `usuario` (`idusuario`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `item_entrada`
-- -----------------------------------------------------
CREATE TABLE `item_entrada` (
  `idmaterial` INT NOT NULL,
  `identrada` INT NOT NULL,
  `peso` DECIMAL(5,3) NOT NULL,
  `quantidade` INT(5) NULL,

  PRIMARY KEY (`idmaterial`, `identrada`),
  CONSTRAINT `fk_item_entrada_material` FOREIGN KEY (`idmaterial`) REFERENCES `material` (`idmaterial`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_item_entrada_entrada`
    FOREIGN KEY (`identrada`)
    REFERENCES `entrada` (`identrada`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `saida`
-- -----------------------------------------------------
CREATE TABLE `saida` (
  `idsaida` INT NOT NULL AUTO_INCREMENT,
  `balanceiro` VARCHAR(45) NOT NULL,
  `motorista` VARCHAR(45) NOT NULL,
  `placa_veiculo` VARCHAR(8) NOT NULL,
  `peso_bruto` DECIMAL(5,3) NOT NULL,
  `peso_tara` DECIMAL(5,3) NOT NULL,
  `peso_liquido` DECIMAL(5,3) NOT NULL,
  `data_entrada` DATETIME NOT NULL, 
  `data_saida` DATETIME NOT NULL,
  `observacao` VARCHAR(250) NULL, 
  `idcliente` INT NOT NULL,
  `idusuario` INT NOT NULL,
  PRIMARY KEY (`idsaida`),
  CONSTRAINT `fk_saida_cliente` FOREIGN KEY (`idcliente`) REFERENCES `cliente` (`idcliente`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_saida_usuario` FOREIGN KEY (`idusuario`) REFERENCES `usuario` (`idusuario`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `item_saida`
-- -----------------------------------------------------
CREATE TABLE `item_saida` (
  `idmaterial` INT NOT NULL,
  `idsaida` INT NOT NULL,
  `peso` DECIMAL(5,3) NOT NULL,
  `quantidade` INT(5) NOT NULL,

  PRIMARY KEY (`idmaterial`, `idsaida`),
  CONSTRAINT `fk_item_saida_material` FOREIGN KEY (`idmaterial`) REFERENCES `material` (`idmaterial`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_item_saida_saida`
    FOREIGN KEY (`idsaida`)
    REFERENCES `saida` (`idsaida`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

START TRANSACTION;
INSERT INTO `usuario` (`idusuario`, `nome`, `email`, `senha`, `status`) VALUES (NULL, 'Admin', 'admin@gmail.com', md5('abc-marvel'), '1');
INSERT INTO `tipo_cliente`(`idtipo_cliente`, `tipocliente`) VALUES (1,'Fornecedor'), (2,'Consumidor'), (3,'Fornecedor e Consumidor');
COMMIT;



