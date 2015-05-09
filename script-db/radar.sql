SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

CREATE SCHEMA IF NOT EXISTS `radar` DEFAULT CHARACTER SET utf8 ;
USE `radar` ;

-- -----------------------------------------------------
-- Table `radar`.`users`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `radar`.`users` ;

CREATE  TABLE IF NOT EXISTS `radar`.`users` (
  `idusers` INT(11) NOT NULL AUTO_INCREMENT ,
  `username` VARCHAR(10) NULL DEFAULT NULL ,
  `firstname` VARCHAR(20) NULL DEFAULT NULL ,
  `lastname` VARCHAR(20) NULL DEFAULT NULL ,
  `email` VARCHAR(70) NULL DEFAULT NULL ,
  `userpassword` VARCHAR(32) NULL DEFAULT NULL ,
  `changepassword` INT(1) NULL DEFAULT NULL ,
  `hash_value` VARCHAR(64) NULL DEFAULT NULL ,
  `hash_date` DATETIME NULL DEFAULT NULL ,
  PRIMARY KEY (`idusers`) )
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `radar`.`radio_station`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `radar`.`radio_station` ;

CREATE  TABLE IF NOT EXISTS `radar`.`radio_station` (
  `idstation` INT(11) NOT NULL AUTO_INCREMENT ,
  `stationname` VARCHAR(40) NOT NULL ,
  `creationdate` VARCHAR(45) NULL DEFAULT NULL ,
  `editiondate` DATETIME NULL DEFAULT NULL ,
  PRIMARY KEY (`idstation`) ,
  UNIQUE INDEX `stationname_UNIQUE` (`stationname` ASC) )
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `radar`.`markets`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `radar`.`markets` ;

CREATE  TABLE IF NOT EXISTS `radar`.`markets` (
  `idmarket` INT(11) NOT NULL AUTO_INCREMENT ,
  `marketname` VARCHAR(40) NOT NULL ,
  `creationdate` DATETIME NULL DEFAULT NULL ,
  `editiondate` DATETIME NULL DEFAULT NULL ,
  PRIMARY KEY (`idmarket`) ,
  UNIQUE INDEX `marketname_UNIQUE` (`marketname` ASC) )
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `radar`.`album`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `radar`.`album` ;

CREATE  TABLE IF NOT EXISTS `radar`.`album` (
  `idalbum` INT(11) NOT NULL AUTO_INCREMENT ,
  `imguralbum` VARCHAR(5) NOT NULL ,
  `idmarket` INT(11) NOT NULL ,
  `idstation` INT(11) NOT NULL ,
  `idusercreator` INT(11) NOT NULL ,
  `imgurcreationdate` DATETIME NULL ,
  `creationdate` DATETIME NULL ,
  `editiondate` DATETIME NULL DEFAULT NULL ,
  PRIMARY KEY (`idalbum`) ,
  INDEX `fk_album_users1_idx` (`idusercreator` ASC) ,
  INDEX `fk_album_radio_station1_idx` (`idstation` ASC) ,
  INDEX `fk_album_markets1_idx` (`idmarket` ASC) ,
  INDEX `idx_imgurcreationdate` (`imgurcreationdate` ASC) ,
  CONSTRAINT `fk_album_users1`
    FOREIGN KEY (`idusercreator` )
    REFERENCES `radar`.`users` (`idusers` )
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_album_radio_station1`
    FOREIGN KEY (`idstation` )
    REFERENCES `radar`.`radio_station` (`idstation` )
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_album_markets1`
    FOREIGN KEY (`idmarket` )
    REFERENCES `radar`.`markets` (`idmarket` )
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `radar`.`assoc_markets_users`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `radar`.`assoc_markets_users` ;

CREATE  TABLE IF NOT EXISTS `radar`.`assoc_markets_users` (
  `iduser` INT(11) NOT NULL ,
  `idmarket` INT(11) NOT NULL ,
  `creationdate` DATETIME NULL DEFAULT NULL ,
  `editiondate` DATETIME NULL DEFAULT NULL ,
  PRIMARY KEY (`iduser`, `idmarket`) ,
  INDEX `fk_assoc_markets_users_users1_idx` (`iduser` ASC) ,
  INDEX `fk_assoc_markets_users_markets1_idx` (`idmarket` ASC) ,
  CONSTRAINT `fk_assoc_markets_users_markets1`
    FOREIGN KEY (`idmarket` )
    REFERENCES `radar`.`markets` (`idmarket` )
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_assoc_markets_users_users1`
    FOREIGN KEY (`iduser` )
    REFERENCES `radar`.`users` (`idusers` )
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `radar`.`assoc_stations_users`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `radar`.`assoc_stations_users` ;

CREATE  TABLE IF NOT EXISTS `radar`.`assoc_stations_users` (
  `iduser` INT(11) NOT NULL ,
  `idstation` INT(11) NOT NULL ,
  `creationdate` DATETIME NULL DEFAULT NULL ,
  `editiondate` DATETIME NULL DEFAULT NULL ,
  PRIMARY KEY (`iduser`, `idstation`) ,
  INDEX `fk_assoc_stations_users_users1_idx` (`iduser` ASC) ,
  INDEX `fk_assoc_stations_users_radio_station1_idx` (`idstation` ASC) ,
  CONSTRAINT `fk_assoc_stations_users_users1`
    FOREIGN KEY (`iduser` )
    REFERENCES `radar`.`users` (`idusers` )
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_assoc_stations_users_radio_station1`
    FOREIGN KEY (`idstation` )
    REFERENCES `radar`.`radio_station` (`idstation` )
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `radar`.`modules`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `radar`.`modules` ;

CREATE  TABLE IF NOT EXISTS `radar`.`modules` (
  `idmodule` INT(11) NOT NULL AUTO_INCREMENT ,
  `modulename` VARCHAR(40) NULL ,
  `url` VARCHAR(512) NULL DEFAULT NULL ,
  `id_parent` INT(11) NULL DEFAULT NULL ,
  `creationdate` DATETIME NULL ,
  `editiondate` DATETIME NULL DEFAULT NULL ,
  PRIMARY KEY (`idmodule`) ,
  INDEX `fk_module_parentmodule` (`id_parent` ASC) ,
  CONSTRAINT `fk_module_parentmodule`
    FOREIGN KEY (`id_parent` )
    REFERENCES `radar`.`modules` (`idmodule` )
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `radar`.`permissions`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `radar`.`permissions` ;

CREATE  TABLE IF NOT EXISTS `radar`.`permissions` (
  `idpermission` INT(11) NOT NULL AUTO_INCREMENT ,
  `iduser` INT(11) NOT NULL ,
  `idmodule` INT(11) NOT NULL ,
  `user_role` INT(11) NULL ,
  PRIMARY KEY (`idpermission`) ,
  INDEX `fk_permissions_users_idx` (`iduser` ASC) ,
  INDEX `fk_permissions_modules1_idx` (`idmodule` ASC) ,
  CONSTRAINT `fk_permissions_users`
    FOREIGN KEY (`iduser` )
    REFERENCES `radar`.`users` (`idusers` )
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_permissions_modules1`
    FOREIGN KEY (`idmodule` )
    REFERENCES `radar`.`modules` (`idmodule` )
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `radar`.`settings`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `radar`.`settings` ;

CREATE  TABLE IF NOT EXISTS `radar`.`settings` (
  `idsetting` INT(11) NOT NULL AUTO_INCREMENT ,
  `variable` VARCHAR(20) NOT NULL ,
  `description` VARCHAR(100) NULL ,
  `value` VARCHAR(50) NOT NULL ,
  `idusercreator` INT(11) NOT NULL ,
  `creationdate` DATETIME NULL ,
  `editiondate` DATETIME NULL DEFAULT NULL ,
  PRIMARY KEY (`idsetting`) ,
  INDEX `fk_settings_users1_idx` (`idusercreator` ASC) ,
  CONSTRAINT `fk_settings_users1`
    FOREIGN KEY (`idusercreator` )
    REFERENCES `radar`.`users` (`idusers` )
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

USE `radar` ;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
