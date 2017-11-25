<?php
/* >_ Developed by Vy Nghia */
require 'lib/class/cloud.class.php';
define('WEBURL', 'http://domain.com');
define('__PATH__', 'cloud/files/');

$db = new Database;
$db->dbhost('localhost');
$db->dbuser('htd_support');
$db->dbpass('1151985611');
$db->dbname('htd_support');

$db->connect();