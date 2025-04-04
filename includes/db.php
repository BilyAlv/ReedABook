<?php
// db.php - Archivo de conexión a la base de datos
$host = 'localhost'; // Cambia según tu configuración
$dbname = 'readabook'; // Nombre de tu base de datos
$username = 'root'; // Tu nombre de usuario
$password = ''; // Tu contraseña

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Conexión fallida: " . $e->getMessage();
}
?>
