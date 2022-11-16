<?php
$host = 'localhost';
$user = 'root';
$pass = '';
$db_name = 'tblog';

$conn = mysqli_connect($host, $user, $pass, $db_name);

if ($conn->connect_error) {
	die("Errore di connessione: " . $conn->connect_error);
}
?>