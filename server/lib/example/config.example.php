<?php
/* >_ Developed by Vy Nghia */
require 'lib/class/cloud.class.php';
define('WEBURL', '{WEBURL}');
define('__PATH__', '{PATH}');

$db = new Database;
$db->dbhost('{DB_HOST}');
$db->dbuser('{DB_USER}');
$db->dbpass('{DB_PASS}');
$db->dbname('{DB_NAME}');

$db->connect();