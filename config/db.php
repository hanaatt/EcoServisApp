<?php
$host = 'sql200.epizy.com';
$user = 'epiz_31121671';
$pass = '7XhEahxb5zgcPgN';
$db   = 'epiz_31121671_sup25'; 

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Greska u konekciji: " . $conn->connect_error);
}
$conn->set_charset("utf8mb4");
?>
