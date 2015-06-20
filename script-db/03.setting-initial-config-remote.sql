SET FOREIGN_KEY_CHECKS=0;
truncate table settings;
INSERT INTO `betadev_crowdfunding_teens`.`settings` (`variable`, `description`, `value`, `idusercreator`, `creationdate`, `editiondate`) VALUES ('min_contribution', 'Contribuição mínima para campanhas', '10', null, now(), null);
INSERT INTO `betadev_crowdfunding_teens`.`settings` (`variable`, `description`, `value`, `idusercreator`, `creationdate`, `editiondate`) VALUES ('service_fee', 'Taxa de serviço de coleta de campanhas', '5', null, now(), null);
INSERT INTO `betadev_crowdfunding_teens`.`settings` (`variable`, `description`, `value`, `idusercreator`, `creationdate`, `editiondate`) VALUES ('service_fee_type', 'Tipo Taxa de serviço de coleta de campanhas. Valor fixo = 0; Porcentagem = 1', '1', null, now(), null);
SET FOREIGN_KEY_CHECKS=1;