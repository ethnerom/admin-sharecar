<?php
global $conn;
function obrirConnexioBD() {
    global $conn;
    $servername = "172.16.9.232";
    $username = "cserra";
    $password = "Qwerty1234";
    $dbname = "BPSIX";

    // Crear connexió
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Error de connexió: " . $conn->connect_error);
    }
    $conn->set_charset('utf8');
}

function tancarConnexioBD() {
    global $conn;
    $conn->close();
}
?>
