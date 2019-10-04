<?php
define( 'DB_HOST', '127.0.0.1' );
define( 'DB_CHARSET', 'utf8mb4' );
define( 'DB_COLLATE', '' );
define( 'DB_NAME', 'edu02' );
define( 'DB_USER', 'server1edu01' );
define( 'DB_PASSWORD', 'mD4j+A7sPyTIA3t/pfZ8s/9gBuRW5kKD/gyq' );

require 'safemysql.class.php';

$db = new SafeMySQL(); 
$opts = array('user' => DB_USER, 'pass' => DB_PASSWORD,'db' => DB_NAME, 'charset' => DB_CHARSET);
$db = new SafeMySQL($opts);

?>