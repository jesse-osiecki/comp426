use comp426_final

CREATE TABLE `user` ( `id` INT NOT NULL auto_increment, `username` VARCHAR(50) NOT NULL default '', `nicename` VARCHAR(255) NOT NULL default '', `email` VARCHAR(255) NOT NULL default '', `password` VARCHAR(255) NOT NULL default '', UNIQUE KEY `user_n` (`username`), UNIQUE KEY `user_e` (`email`),     PRIMARY KEY (`id`) );

CREATE TABLE `email` ( `id` INT NOT NULL auto_increment, `uid` int NOT NULL, `email_from` VARCHAR(255) NOT NULL default '', email_to VARCHAR(255) NOT NULL default '',`email_cc` VARCHAR(255) NOT NULL default '', `scheduledtime` int(11)  NOT NULL, `messagebody` LONGTEXT NOT NULL, FOREIGN KEY (`uid`) references user(id),  PRIMARY KEY (`id`) );
