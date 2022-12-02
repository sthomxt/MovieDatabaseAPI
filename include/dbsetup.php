<?php
include '../class/mysql.class.php';

// to do: enter database info to setup
$db = new MYSQL('server', 'user', 'pw', '3307');
echo $db->create_db('TMDB');
?>