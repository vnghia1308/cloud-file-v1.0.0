<?php
/* CREATE ADMIN TABLE */
mysql_query("CREATE TABLE `admin` (
  `username` text NOT NULL,
  `password` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;");
/* CREATE POST TABLE */
mysql_query("CREATE TABLE `file` (
  `id` int(11) NOT NULL,
  `file_name` text NOT NULL,
  `file_name_download` text NOT NULL,
  `file_type` text NOT NULL,
  `code` text NOT NULL,
  `time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1");
/* INSERT TO ADMIN TABLE */
mysql_query("INSERT INTO `admin` (`username`, `password`) VALUES
('admin', 'nghiametrai')");
/* SET `id` IS PRIMARY KEY FOR POST TABLE */
mysql_query("ALTER TABLE `file`
  ADD PRIMARY KEY (`id`)");
/* SET AUTO_INCREMENT FOR POST TABLE */
mysql_query("ALTER TABLE `file`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT");

/* CHECK MYSQL */  
if(mysql_error())
	echo mysql_error();
else
	echo (true);