<?php

define( 'DB_HOST', '127.0.0.1' );
define( 'DB_CHARSET', 'utf8mb4' );
define( 'DB_COLLATE', '' );
define( 'DB_NAME', 'moodle_37' );
define( 'DB_USER', 'root' );
define( 'DB_PASSWORD', 'mysql' );

require 'safemysql.class.php';

$db = new SafeMySQL(); 
$opts = array('user' => DB_USER, 'pass' => DB_PASSWORD,'db' => DB_NAME, 'charset' => DB_CHARSET);
$db = new SafeMySQL($opts);

?>