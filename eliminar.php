<?php
require __DIR__ . '/db.php';

$mensaje = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $clave = trim($_POST['clave'] ?? '');
    if ($clave === '') {
        $mensaje = 'Ingresa una clave.';
    } else {
        $del = $pdo->prepare("DELETE FROM contactos WHERE clave = :c");
        $del->execute([':c' => $clave]);
        if ($del->rowCount() > 0) {
            $mensaje = 'Registro eliminado .';
        } else {
            $mensaje = 'No se encontró la clave.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head><meta charset="UTF-8"><title>Eliminar</title></head>
<body>
<h1>Eliminar registro</h1>

<?php if ($mensaje): ?><p><strong><?php echo htmlspecialchars($mensaje); ?></strong></p><?php endif; ?>

<form method="post" action="eliminar.php" autocomplete="off">
  <label>Clave a eliminar: <input type="text" name="clave" required></label>
  <button type="submit">Eliminar</button>
</form>

<p><a href="principal.php">Regresar a principal</a></p>
</body>
</html>
