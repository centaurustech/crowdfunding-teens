SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- CREATE SCHEMA IF NOT EXISTS `betadev_crowdfunding_teens` DEFAULT CHARACTER SET utf8 ;
USE `betadev_crowdfunding_teens` ;

-- -----------------------------------------------------
-- Table `betadev_crowdfunding_teens`.`country`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `betadev_crowdfunding_teens`.`country` ;

CREATE TABLE IF NOT EXISTS `betadev_crowdfunding_teens`.`country` (
  `country_id` CHAR(3) CHARACTER SET 'utf8' COLLATE 'utf8_unicode_ci' NOT NULL DEFAULT '',
  `country_name` CHAR(52) CHARACTER SET 'utf8' COLLATE 'utf8_unicode_ci' NOT NULL DEFAULT '',
  `country_continent` ENUM('Asia','Europe','North America','Africa','Oceania','Antarctica','South America') CHARACTER SET 'utf8' COLLATE 'utf8_unicode_ci' NOT NULL DEFAULT 'Asia',
  `country_region` CHAR(26) CHARACTER SET 'utf8' COLLATE 'utf8_unicode_ci' NOT NULL DEFAULT '',
  `surface_area` FLOAT(10,2) NOT NULL DEFAULT '0.00',
  `indep_year` SMALLINT(6) NULL DEFAULT NULL,
  `population` INT(11) NOT NULL DEFAULT '0',
  `life_expectancy` FLOAT(3,1) NULL DEFAULT NULL,
  `gnp` FLOAT(10,2) NULL DEFAULT NULL,
  `gnp_old` FLOAT(10,2) NULL DEFAULT NULL,
  `local_name` CHAR(45) CHARACTER SET 'utf8' COLLATE 'utf8_unicode_ci' NOT NULL DEFAULT '',
  `government_form` CHAR(45) CHARACTER SET 'utf8' COLLATE 'utf8_unicode_ci' NOT NULL DEFAULT '',
  `head_of_state` CHAR(60) CHARACTER SET 'utf8' COLLATE 'utf8_unicode_ci' NULL DEFAULT NULL,
  `capital` INT(11) NULL DEFAULT NULL,
  `country_short_id` CHAR(2) CHARACTER SET 'utf8' COLLATE 'utf8_unicode_ci' NOT NULL DEFAULT '',
  PRIMARY KEY (`country_id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;


-- -----------------------------------------------------
-- Table `betadev_crowdfunding_teens`.`city`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `betadev_crowdfunding_teens`.`city` ;

CREATE TABLE IF NOT EXISTS `betadev_crowdfunding_teens`.`city` (
  `city_id` INT(11) NOT NULL AUTO_INCREMENT,
  `city_name` CHAR(35) CHARACTER SET 'utf8' COLLATE 'utf8_unicode_ci' NOT NULL DEFAULT '',
  `country_id` CHAR(3) CHARACTER SET 'utf8' COLLATE 'utf8_unicode_ci' NOT NULL DEFAULT '',
  `state_id` INT(11) NULL DEFAULT NULL,
  `district` CHAR(20) CHARACTER SET 'utf8' COLLATE 'utf8_unicode_ci' NOT NULL DEFAULT '',
  `population` INT(11) NOT NULL DEFAULT '0',
  `country_country_id` CHAR(3) CHARACTER SET 'utf8' COLLATE 'utf8_unicode_ci' NOT NULL,
  PRIMARY KEY (`city_id`),
  INDEX `country_id` (`country_id` ASC),
  INDEX `state_id` (`state_id` ASC),
  INDEX `fk_city_country1_idx` (`country_country_id` ASC),
  CONSTRAINT `fk_city_country1`
    FOREIGN KEY (`country_country_id`)
    REFERENCES `betadev_crowdfunding_teens`.`country` (`country_id`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT)
ENGINE = InnoDB
AUTO_INCREMENT = 4080
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;


-- -----------------------------------------------------
-- Table `betadev_crowdfunding_teens`.`document_type`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `betadev_crowdfunding_teens`.`document_type` ;

CREATE TABLE IF NOT EXISTS `betadev_crowdfunding_teens`.`document_type` (
  `doctype_id` INT(11) NOT NULL AUTO_INCREMENT,
  `doctype_name` VARCHAR(45) NULL,
  PRIMARY KEY (`doctype_id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `betadev_crowdfunding_teens`.`people`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `betadev_crowdfunding_teens`.`people` ;

CREATE TABLE IF NOT EXISTS `betadev_crowdfunding_teens`.`people` (
  `idpeople` INT(11) NOT NULL AUTO_INCREMENT,
  `fullname` VARCHAR(45) NULL DEFAULT NULL,
  `picture_url` VARCHAR(255) NULL DEFAULT NULL,
  `doctype_id` INT(11) NULL,
  `docnum` VARCHAR(45) NULL,
  `address` VARCHAR(100) NULL DEFAULT NULL,
  `phone` VARCHAR(45) NULL DEFAULT NULL,
  `zipcode` VARCHAR(8) NULL DEFAULT NULL,
  `email` VARCHAR(45) NULL DEFAULT NULL,
  `creationdate` DATETIME NULL DEFAULT NULL,
  `editiondate` DATETIME NULL DEFAULT NULL,
  PRIMARY KEY (`idpeople`),
  INDEX `fk_people_doctype_idx` (`doctype_id` ASC),
  CONSTRAINT `fk_people_doctype`
    FOREIGN KEY (`doctype_id`)
    REFERENCES `betadev_crowdfunding_teens`.`document_type` (`doctype_id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `betadev_crowdfunding_teens`.`users`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `betadev_crowdfunding_teens`.`users` ;

CREATE TABLE IF NOT EXISTS `betadev_crowdfunding_teens`.`users` (
  `iduser` INT(11) NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(10) NULL DEFAULT NULL,
  `userpassword` VARCHAR(32) NULL DEFAULT NULL,
  `changepassword` INT(1) NULL DEFAULT 0,
  `hash_value` VARCHAR(64) NULL DEFAULT NULL,
  `hash_date` DATETIME NULL DEFAULT NULL,
  `idpeople` INT(11) NULL DEFAULT NULL,
  `facebook_id` VARCHAR(255) NULL DEFAULT NULL,
  `creationdate` DATETIME NULL DEFAULT NULL,
  `editiondate` DATETIME NULL DEFAULT NULL,
  `is_admin` TINYINT(1) NULL DEFAULT 0,
  PRIMARY KEY (`iduser`),
  INDEX `fk_users_1_idx` (`idpeople` ASC),
  CONSTRAINT `fk_users_1`
    FOREIGN KEY (`idpeople`)
    REFERENCES `betadev_crowdfunding_teens`.`people` (`idpeople`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `betadev_crowdfunding_teens`.`campaigns`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `betadev_crowdfunding_teens`.`campaigns` ;

CREATE TABLE IF NOT EXISTS `betadev_crowdfunding_teens`.`campaigns` (
  `idcampaign` INT(11) NOT NULL AUTO_INCREMENT,
  `camp_name` VARCHAR(45) NULL DEFAULT NULL,
  `camp_description` VARCHAR(255) NULL DEFAULT NULL,
  `camp_expire` DATE NULL DEFAULT NULL,
  `camp_goal` DECIMAL(12,2) NULL DEFAULT NULL,
  `iduser` INT(11) NULL DEFAULT NULL,
  `camp_completed` INT(3) NULL DEFAULT '0',
  `camp_collected` DECIMAL(12,2) NULL DEFAULT '0.00',
  `creationdate` DATETIME NULL DEFAULT NULL,
  `editiondate` DATETIME NULL DEFAULT NULL,
  PRIMARY KEY (`idcampaign`),
  INDEX `fk_campaigns_users_idx` (`iduser` ASC),
  CONSTRAINT `fk_campaigns_users`
    FOREIGN KEY (`iduser`)
    REFERENCES `betadev_crowdfunding_teens`.`users` (`iduser`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 4
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci;


-- -----------------------------------------------------
-- Table `betadev_crowdfunding_teens`.`campaigns_images_gallery`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `betadev_crowdfunding_teens`.`campaigns_images_gallery` ;

CREATE TABLE IF NOT EXISTS `betadev_crowdfunding_teens`.`campaigns_images_gallery` (
  `idimagesgallery` INT(11) NOT NULL AUTO_INCREMENT,
  `imgurl` TEXT NULL DEFAULT NULL,
  `idcampaign` INT(11) NULL DEFAULT NULL,
  `creationdate` DATETIME NULL DEFAULT NULL,
  `editiondate` DATETIME NULL DEFAULT NULL,
  PRIMARY KEY (`idimagesgallery`),
  INDEX `fk_campaing-images-gallery_1` (`idcampaign` ASC),
  CONSTRAINT `fk_campaing-images-gallery_1`
    FOREIGN KEY (`idcampaign`)
    REFERENCES `betadev_crowdfunding_teens`.`campaigns` (`idcampaign`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
AUTO_INCREMENT = 2
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci;


-- -----------------------------------------------------
-- Table `betadev_crowdfunding_teens`.`campaigns_urls`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `betadev_crowdfunding_teens`.`campaigns_urls` ;

CREATE TABLE IF NOT EXISTS `betadev_crowdfunding_teens`.`campaigns_urls` (
  `idurl` INT(11) NOT NULL AUTO_INCREMENT,
  `url` VARCHAR(45) NULL DEFAULT NULL,
  `idcampaign` INT(11) NULL DEFAULT NULL,
  `datecreation` DATETIME NULL,
  `editiondate` DATETIME NULL,
  PRIMARY KEY (`idurl`),
  INDEX `fk_campaign-urls_1_idx` (`idcampaign` ASC),
  CONSTRAINT `fk_campaign-urls`
    FOREIGN KEY (`idcampaign`)
    REFERENCES `betadev_crowdfunding_teens`.`campaigns` (`idcampaign`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `betadev_crowdfunding_teens`.`payments_method`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `betadev_crowdfunding_teens`.`payments_method` ;

CREATE TABLE IF NOT EXISTS `betadev_crowdfunding_teens`.`payments_method` (
  `payment_method_id` INT(11) NOT NULL AUTO_INCREMENT,
  `payment_method_name` VARCHAR(45) NULL,
  PRIMARY KEY (`payment_method_id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `betadev_crowdfunding_teens`.`contributions`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `betadev_crowdfunding_teens`.`contributions` ;

CREATE TABLE IF NOT EXISTS `betadev_crowdfunding_teens`.`contributions` (
  `idcontribution` INT(11) NOT NULL AUTO_INCREMENT,
  `idcampaign` INT(11) NULL DEFAULT NULL,
  `iduser` INT(11) NULL DEFAULT NULL,
  `amount` DECIMAL(12,2) NULL DEFAULT NULL,
  `service_fee` DECIMAL(12,2) NULL,
  `total_payment` DECIMAL(12,2) NULL,
  `payment_date` DATETIME NULL,
  `payment_method_id` INT(11) NULL,
  `payment_trans` VARCHAR(100) NULL,
  `payment_status` INT(3) NULL DEFAULT NULL,
  `nickname` VARCHAR(100) NOT NULL DEFAULT 'Anônimo',
  `notes` TEXT NULL,
  `hide_contrib_name` BIT(1) NULL DEFAULT b'0',
  `hide_contrib_value` BIT(1) NULL DEFAULT b'0',
  PRIMARY KEY (`idcontribution`),
  INDEX `fk_colaborators_campaign_idx` (`idcampaign` ASC),
  INDEX `fk_colaborators_users_idx` (`iduser` ASC),
  INDEX `fk_contributions_payments_idx` (`payment_method_id` ASC),
  CONSTRAINT `fk_colaborators_campaign`
    FOREIGN KEY (`idcampaign`)
    REFERENCES `betadev_crowdfunding_teens`.`campaigns` (`idcampaign`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_colaborators_users`
    FOREIGN KEY (`iduser`)
    REFERENCES `betadev_crowdfunding_teens`.`users` (`iduser`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_contributions_payments`
    FOREIGN KEY (`payment_method_id`)
    REFERENCES `betadev_crowdfunding_teens`.`payments_method` (`payment_method_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `betadev_crowdfunding_teens`.`modules`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `betadev_crowdfunding_teens`.`modules` ;

CREATE TABLE IF NOT EXISTS `betadev_crowdfunding_teens`.`modules` (
  `idmodule` INT(11) NOT NULL AUTO_INCREMENT,
  `modulename` VARCHAR(40) NULL DEFAULT NULL,
  `url` VARCHAR(512) NULL DEFAULT NULL,
  `id_parent` INT(11) NULL DEFAULT NULL,
  `creationdate` DATETIME NULL DEFAULT NULL,
  `editiondate` DATETIME NULL DEFAULT NULL,
  PRIMARY KEY (`idmodule`),
  INDEX `fk_module_parentmodule` (`id_parent` ASC),
  CONSTRAINT `fk_module_parentmodule`
    FOREIGN KEY (`id_parent`)
    REFERENCES `betadev_crowdfunding_teens`.`modules` (`idmodule`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `betadev_crowdfunding_teens`.`permissions`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `betadev_crowdfunding_teens`.`permissions` ;

CREATE TABLE IF NOT EXISTS `betadev_crowdfunding_teens`.`permissions` (
  `idpermission` INT(11) NOT NULL AUTO_INCREMENT,
  `iduser` INT(11) NOT NULL,
  `idmodule` INT(11) NOT NULL,
  `user_role` INT(11) NULL DEFAULT NULL,
  PRIMARY KEY (`idpermission`),
  INDEX `fk_permissions_users_idx` (`iduser` ASC),
  INDEX `fk_permissions_modules1_idx` (`idmodule` ASC),
  CONSTRAINT `fk_permissions_modules1`
    FOREIGN KEY (`idmodule`)
    REFERENCES `betadev_crowdfunding_teens`.`modules` (`idmodule`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_permissions_users`
    FOREIGN KEY (`iduser`)
    REFERENCES `betadev_crowdfunding_teens`.`users` (`iduser`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `betadev_crowdfunding_teens`.`settings`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `betadev_crowdfunding_teens`.`settings` ;

CREATE TABLE IF NOT EXISTS `betadev_crowdfunding_teens`.`settings` (
  `idsetting` INT(11) NOT NULL AUTO_INCREMENT,
  `variable` VARCHAR(20) NOT NULL,
  `description` VARCHAR(100) NULL DEFAULT NULL,
  `value` VARCHAR(50) NOT NULL,
  `idusercreator` INT(11) NULL DEFAULT NULL,
  `creationdate` DATETIME NULL DEFAULT NULL,
  `editiondate` DATETIME NULL DEFAULT NULL,
  PRIMARY KEY (`idsetting`),
  INDEX `fk_settings_users1_idx` (`idusercreator` ASC),
  CONSTRAINT `fk_settings_users1`
    FOREIGN KEY (`idusercreator`)
    REFERENCES `betadev_crowdfunding_teens`.`users` (`iduser`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `betadev_crowdfunding_teens`.`state`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `betadev_crowdfunding_teens`.`state` ;

CREATE TABLE IF NOT EXISTS `betadev_crowdfunding_teens`.`state` (
  `state_id` INT(11) NOT NULL AUTO_INCREMENT,
  `state_name` CHAR(35) CHARACTER SET 'utf8' COLLATE 'utf8_unicode_ci' NOT NULL DEFAULT '',
  `country_id` CHAR(3) CHARACTER SET 'utf8' COLLATE 'utf8_unicode_ci' NOT NULL DEFAULT '',
  `population` INT(11) NOT NULL DEFAULT '0',
  `country_country_id` CHAR(3) CHARACTER SET 'utf8' COLLATE 'utf8_unicode_ci' NOT NULL,
  PRIMARY KEY (`state_id`),
  INDEX `fk_state_country1_idx` (`country_country_id` ASC),
  CONSTRAINT `fk_state_country1`
    FOREIGN KEY (`country_country_id`)
    REFERENCES `betadev_crowdfunding_teens`.`country` (`country_id`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT)
ENGINE = InnoDB
AUTO_INCREMENT = 4111
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;


-- -----------------------------------------------------
-- Table `betadev_crowdfunding_teens`.`paises`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `betadev_crowdfunding_teens`.`paises` ;

CREATE TABLE IF NOT EXISTS `betadev_crowdfunding_teens`.`paises` (
  `iso` CHAR(2) CHARACTER SET 'utf8' COLLATE 'utf8_unicode_ci' NOT NULL,
  `iso3` CHAR(3) CHARACTER SET 'utf8' COLLATE 'utf8_unicode_ci' NOT NULL,
  `numcode` SMALLINT(6) NULL DEFAULT NULL,
  `nome` VARCHAR(255) CHARACTER SET 'utf8' COLLATE 'utf8_unicode_ci' NOT NULL,
  PRIMARY KEY (`iso`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;


-- -----------------------------------------------------
-- Table `betadev_crowdfunding_teens`.`withdrawals`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `betadev_crowdfunding_teens`.`withdrawals` ;

CREATE TABLE IF NOT EXISTS `betadev_crowdfunding_teens`.`withdrawals` (
  `idwithdrawal` INT(11) NOT NULL,
  `idcampaign` INT(11) NULL DEFAULT NULL,
  `amount` DECIMAL(12,2) NULL DEFAULT NULL,
  `service_fee` DECIMAL(12,2) NULL,
  `withdrawal_date` DATETIME NULL,
  `payment_method_id` INT(11) NULL,
  `payments_trans` VARCHAR(100) NULL,
  `payments_status` INT(3) NULL,
  PRIMARY KEY (`idwithdrawal`),
  INDEX `fk_colaborators_campaign_idx` (`idcampaign` ASC),
  INDEX `fk_withdrawals_payments_idx` (`payment_method_id` ASC),
  CONSTRAINT `fk_withdrawals_campaigns`
    FOREIGN KEY (`idcampaign`)
    REFERENCES `betadev_crowdfunding_teens`.`campaigns` (`idcampaign`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_withdrawals_payments`
    FOREIGN KEY (`payment_method_id`)
    REFERENCES `betadev_crowdfunding_teens`.`payments_method` (`payment_method_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
