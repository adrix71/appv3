--
-- Pop Bootstrap MySQL Database
--

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
CREATE TABLE IF NOT EXISTS `roles` (
  `id` int(16) NOT NULL AUTO_INCREMENT,
  `parent_id` int(16),
  `name` varchar(255) NOT NULL,
  `verification` int(1),
  `approval` int(1),
  `permissions` text,
  PRIMARY KEY (`id`),
  INDEX `role_name` (`name`),
  CONSTRAINT `fk_role_parent_id` FOREIGN KEY (`parent_id`) REFERENCES `roles` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2002 ;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `parent_id`, `name`, `verification`, `approval`, `permissions`) VALUES
(2001, NULL, 'Admin', 1, 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(16) NOT NULL AUTO_INCREMENT,
  `role_id` int(16),
  `username` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `password` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `email` varchar(255),
  `active` int(1),
  `verified` int(1),
  `last_login` datetime,
  `last_ip` varchar(255),
  `last_ua` varchar(255),
  `total_logins` int(16) DEFAULT '0',
  `failed_attempts` int(16) DEFAULT '0',
  PRIMARY KEY (`id`),
  INDEX `role_id` (`role_id`),
  INDEX `username` (`username`),
  CONSTRAINT `fk_user_role` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1002 ;

--
-- Dumping data for table `users`
--
INSERT INTO `users` (`id`, `role_id`, `username`, `password`, `active`, `verified`) VALUES
(1001, 2001, 'admin', '$2y$08$ckh6UXNYdjdSVzhlcWh2OOCrjBWHarr8Fxf3i2BYVlC29Ag/eoGkC', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_sessions`
--

CREATE TABLE `user_sessions` (
  `id` int(16) NOT NULL AUTO_INCREMENT,
  `user_id` int(16) DEFAULT NULL,
  `session_id` varchar(255) NOT NULL,
  `ip` varchar(255) NOT NULL,
  `ua` varchar(255) NOT NULL,
  `start` int(16) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE `session_key` (`id`, `user_id`, `session_id`),
  CONSTRAINT `fk_user_session_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=3002 ;

-- --------------------------------------------------------

--
-- Table structure for table `user_logins`
--

DROP TABLE IF EXISTS `user_logins`;
CREATE TABLE `user_logins` (
  `id` int(16) NOT NULL AUTO_INCREMENT,
  `user_id` int(16) DEFAULT NULL,
  `ip` varchar(255) NOT NULL,
  `ua` varchar(255) NOT NULL,
  `timestamp` datetime NOT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_user_login_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=4002 ;