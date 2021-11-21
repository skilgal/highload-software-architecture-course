CREATE TABLE `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `userName` varchar(32) DEFAULT NULL,
  `password` varchar(32) DEFAULT NULL,
  `realName` varchar(32) DEFAULT NULL,
  `birthDate` DATE,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
