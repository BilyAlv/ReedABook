<?php
// Establecer conexión con la base de datos
$host = "localhost";
$usuario = "root";  
$contraseña = ""; 
$base_de_datos = "readabook";  

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Comprobar si el formulario fue enviado y si el email está presente
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['email'])) {
    $email = $_POST['email'];

    // Validar el formato del correo electrónico
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Insertar el correo electrónico en la tabla 'suscriptores'
        $sql = "INSERT INTO suscriptores (email) VALUES ('$email')";

        if ($conn->query($sql) === TRUE) {
            echo "¡Te has suscrito con éxito!";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "El correo electrónico no es válido.";
    }
}

$conn->close();
?>
