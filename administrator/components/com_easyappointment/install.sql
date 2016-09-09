DROP TABLE IF EXISTS `#__make_appointment_payments`;
DROP TABLE IF EXISTS `#__make_appointment_reservations`;
DROP TABLE IF EXISTS `#__make_appointment_services`;
DROP TABLE IF EXISTS `#__make_appointment_staff`;

CREATE TABLE `#__make_appointment_payments` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `keyring` varchar(50) NOT NULL DEFAULT '',
  `code` varchar(50) NOT NULL DEFAULT '',
  `params` text NOT NULL,
  `checked_out` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `keyring` (`keyring`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE `#__make_appointment_reservations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user` int(10) unsigned NOT NULL DEFAULT '0',
  `staff` int(10) unsigned NOT NULL DEFAULT '0',
  `service` int(10) unsigned NOT NULL DEFAULT '0',
  `appointmentDate` date NOT NULL,
  `startingTime` mediumint(10) unsigned NOT NULL DEFAULT '0',
  `endingTime` mediumint(10) unsigned NOT NULL DEFAULT '0',
  `name` varchar(255) NOT NULL DEFAULT '',
  `email` varchar(255) NOT NULL DEFAULT '',
  `phone` varchar(255) NOT NULL DEFAULT '',
  `address` text NOT NULL,
  `comments` text NOT NULL,
  `keyring` varchar(50) NOT NULL DEFAULT '',
  `published` tinyint(1) NOT NULL DEFAULT '0',
  `checked_out` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `keyring` (`keyring`),
  KEY `idx_date` (`appointmentDate`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE `#__make_appointment_services` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '',
  `parent` int(10) NOT NULL DEFAULT '0',
  `description` text NOT NULL,
  `length` int(3) NOT NULL DEFAULT '30',
  `price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `published` tinyint(1) NOT NULL DEFAULT '1',
  `ordering` int(11) unsigned NOT NULL DEFAULT '1',
  `checked_out` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE `#__make_appointment_staff` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user` int(10) unsigned NOT NULL DEFAULT '0',
  `name` varchar(255) NOT NULL DEFAULT '',
  `description` text NOT NULL,
  `picture` varchar(255) NOT NULL,
  `services` text NOT NULL,
  `schedules` text NOT NULL,
  `params` text NOT NULL,
  `published` tinyint(1) NOT NULL DEFAULT '1',
  `ordering` int(11) unsigned NOT NULL DEFAULT '1',
  `checked_out` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `idx_user` (`user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
