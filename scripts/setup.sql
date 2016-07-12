DROP TABLE IF EXISTS `datsun`.`products` ;
CREATE TABLE `datsun`.`products` (
  `id`                  bigint(20)    NOT NULL AUTO_INCREMENT,
  `active`              boolean       DEFAULT TRUE,
  `item`                varchar(50)   DEFAULT NULL,
  `quantity`            int(10)       DEFAULT 1,
  `bought`              decimal(10,2) DEFAULT NULL, ## Purchase price
  `sold`                decimal(10,2) DEFAULT NULL, ## Sales price
  `notes`               varchar(255)  DEFAULT NULL,
  `activated`           timestamp     NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deactivated`         timestamp     DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ;

INSERT INTO `datsun`.`products` (
   item,
   quantity,
   bought,
   sold,
   notes
) VALUES (
  'Test Item 1',
  1,
  '5.99',
  '7.99',
  'Test items 1 description'
);

## Maybe not a great idea, doesn't account for split years etc...
## 1931 to 1986 is the reg prod range...
DROP TABLE IF EXISTS `datsun`.`models` ;
CREATE TABLE `datsun`.`models` (
  `id`                  bigint(20)    NOT NULL AUTO_INCREMENT,
  `model`               varchar(50)   NOT NULL,
  `notes`               varchar(255)  DEFAULT NULL,
  `prod_start`          int(11)       NOT NULL, ## Production start year
  `prod_end`            int(11)       NOT NULL, ## Production end year
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ;