<?php 
// DB connection parameters
/*
define('DB_HOST','localhost');
define('DB_USER','root');
define('DB_PASS','');
define('DB_NAME','carrental');
*/

define('DB_HOST','mysql.cba.pl');
define('DB_USER','cris');
define('DB_PASS','884652078910kbKB');
define('DB_NAME','bestfragers');
// Establish database connection
try
{
$dbh = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME,DB_USER, DB_PASS,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
}
catch (PDOException $e)
{
exit("Error: " . $e->getMessage());
}
?>