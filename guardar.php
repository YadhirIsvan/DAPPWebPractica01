<?php
require __DIR__ . '/db.php';

$mensaje = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $clave = trim($_POST['clave'] ?? '');
    $nombre = trim($_POST['nombre'] ?? '');
    $telefono = trim($_POST['telefono'] ?? '');
    $direccion = trim($_POST['direccion'] ?? '');

    if ($clave === '' || $nombre === '' || $telefono === '' || $direccion === '') {
        $mensaje = 'Todos los campos son obligatorios.';
    } else {
        // Validar que no exista la clave
        $stmt = $pdo->prepare("SELECT 1 FROM contactos WHERE clave = :c");
        $stmt->execute([':c' => $clave]);
        if ($stmt->fetch()) {
            $mensaje = 'La clave ya existe. Usa otra clave.';
        } else {
            $ins = $pdo->prepare(
                "INSERT INTO contactos (clave, nombre, telefono, direccion)
                 VALUES (:c, :n, :t, :d)"
            );
            $ins->execute([
                ':c' => $clave,
                ':n' => $nombre,
                ':t' => $telefono,
                ':d' => $direccion
            ]);
            $mensaje = 'Registro guardado correctamente.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head><meta charset="UTF-8"><title>Guardar</title></head>
<body>
<h1>Guardar (crear) registro</h1>
<?php if ($mensaje): ?><p><strong><?php echo htmlspecialchars($mensaje); ?></strong></p><?php endif; ?>

<form method="post" action="guardar.php" autocomplete="off">
  <label>Clave: <input type="text" name="clave" required></label><br><br>
  <label>Nombre: <input type="text" name="nombre" required></label><br><br>
  <label>Teléfono: <input type="text" name="telefono" required></label><br><br>
  <label>Dirección: <input type="text" name="direccion" required></label><br><br>
  <button type="submit">Guardar</button>
</form>

<p><a href="principal.php">Regresar a principal</a></p>
</body>
</html>
