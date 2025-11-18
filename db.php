<?php
// db.php — conexión PDO a PostgreSQL
$DB_HOST = 'localhost';
$DB_NAME = 'crud';
$DB_USER = 'postgres';     // <-- si tu usuario real es 'postgres', cámbialo aquí
$DB_PASS = 'mi_contraseña';

$dsn = "pgsql:host=$DB_HOST;dbname=$DB_NAME;port=5432";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

try {
    $pdo = new PDO($dsn, $DB_USER, $DB_PASS, $options);
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}
