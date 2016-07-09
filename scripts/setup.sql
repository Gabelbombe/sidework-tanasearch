DROP TABLE IF EXISTS `tana`.`products` ;
CREATE TABLE `tana`.`products` (
  `id`                  bigint(20)    NOT NULL AUTO_INCREMENT,
  `active`              bit(1)        DEFAULT TRUE,
  `item`                varchar(50)   DEFAULT NULL,
  `bought`              decimal(10,2) DEFAULT NULL,
  `sold`                decimal(10,2) DEFAULT NULL,
  `notes`               varchar(255)  DEFAULT NULL,
  `added`               timestamp     NOT NULL DEFAULT CURRENT_TIMESTAMP
  `sold`                timestamp     DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8
