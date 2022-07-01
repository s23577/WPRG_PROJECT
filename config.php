<?php
$dbuser = 'ala';
$dbpass = 'ala';

// Check connection
try {
    $db = new PDO("mysql:host=127.0.0.1;dbname=db_wprg", $dbuser, $dbpass);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}

