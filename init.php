<?php
$db = require_once('db.php');

$link = mysqli_connect($db['host'], $db['username'], $db['password'], $db['database']);
mysqli_set_charset($link, $db['charset']);
?>
