<?php
// Configura tu conexión a la base de datos
$host = 'localhost'; // Cambia según tu configuración
$db = 'pos';
$user = 'root'; // Cambia según tu configuración
$pass = ''; // Cambia según tu configuración

try {
    $conn = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Consulta para obtener los productos
    $sql = "SELECT codigo, descripcion, unidad, stock FROM productos";
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    // Obtener los resultados
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Generar CSV
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="productos.csv"');
    $output = fopen('php://output', 'w');

    // Encabezados del CSV
    fputcsv($output, ['Codigo', 'Descripcion', 'Unidad', 'Stock']);

    // Agregar los datos al CSV
    foreach ($result as $row) {
        fputcsv($output, $row);
    }

    fclose($output);
    exit();

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

$conn = null;
?>
