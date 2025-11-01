<?php
$HOST = 'localhost';
$USER = 'root';
$PASSWORD = '';
$DBNAME = 'skill_swap';

$conn = new mysqli($HOST, $USER, $PASSWORD, $DBNAME);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>