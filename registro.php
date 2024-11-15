<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');

session_start();
include 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST["nombre"];
    $descripcion = $_POST["descripcion"];
    $categoria = $_POST["categoria"];
    $precio = $_POST["precio"];
    $cantidad = $_POST["cantidad"];
    $codigo = $_POST["codigo"];

    $validar_producto = "SELECT * FROM productos WHERE nombre = '$nombre'";
    $q_validar_producto = mysqli_query($conn, $validar_producto);

    // Verifica si la consulta se ejecutó correctamente
    if ($q_validar_producto === false) {
        echo "Error en la consulta SQL: " . mysqli_error($conn);
        exit;
    }

    $numr_validar_producto = mysqli_num_rows($q_validar_producto);

    if ($numr_validar_producto > 0) {
        echo 'El producto ya se encuentra registrado.';
    } else {
        $sql = "INSERT INTO productos (nombre, descripcion, categoria, precio, cantidad, codigo) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);

        // Verifica si la preparación de la consulta fue exitosa
        if ($stmt === false) {
            echo "Error en la preparación de la consulta: " . $conn->error;
            exit;
        }

        $stmt->bind_param("ssssss", $nombre, $descripcion, $categoria, $precio, $cantidad, $codigo);

        if ($stmt->execute()) {
            echo "Registro Exitoso.";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    }

    $conn->close();
}
?>
