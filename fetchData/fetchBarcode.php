<?php
// Configuración de la base de datos
$host = 'localhost';
$dbname = 'pos';
$user = 'root';
$password = '';

// Conexión a la base de datos
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Consultar los códigos
    $stmt = $pdo->query("SELECT codigo FROM productos");
    $codigos = $stmt->fetchAll(PDO::FETCH_COLUMN);

    // Retornar los datos como JSON
    echo json_encode($codigos);
} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>
