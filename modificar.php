<?php
require __DIR__ . '/db.php';

$mensaje = '';
$paso = 'buscar'; // buscar | editar
$clave = '';
$registro = ['nombre' => '', 'telefono' => '', 'direccion' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (($_POST['accion'] ?? '') === 'buscar') {
        $clave = trim($_POST['clave'] ?? '');
        if ($clave === '') {
            $mensaje = 'Ingresa una clave.';
        } else {
            $stmt = $pdo->prepare("SELECT nombre, telefono, direccion
                                   FROM contactos WHERE clave = :c");
            $stmt->execute([':c' => $clave]);
            $row = $stmt->fetch();
            if (!$row) {
                $mensaje = 'No se encontró la clave.';
            } else {
                $registro = $row;
                $paso = 'editar';
            }
        }
    } elseif (($_POST['accion'] ?? '') === 'editar') {
        $clave = trim($_POST['clave'] ?? '');
        $nombre = trim($_POST['nombre'] ?? '');
        $telefono = trim($_POST['telefono'] ?? '');
        $direccion = trim($_POST['direccion'] ?? '');

        if ($clave === '' || $nombre === '' || $telefono === '' || $direccion === '') {
            $mensaje = 'Todos los campos son obligatorios.';
            $registro = ['nombre'=>$nombre, 'telefono'=>$telefono, 'direccion'=>$direccion];
            $paso = 'editar';
        } else {
            $upd = $pdo->prepare("UPDATE contactos
                                  SET nombre = :n, telefono = :t, direccion = :d
                                  WHERE clave = :c");
            $upd->execute([
                ':n' => $nombre, ':t' => $telefono, ':d' => $direccion, ':c' => $clave
            ]);
            $mensaje = 'Registro modificado correctamente.';
            $paso = 'buscar';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head><meta charset="UTF-8"><title>Modificar</title></head>
<body>
<h1>Modificar registro</h1>

<?php if ($mensaje): ?><p><strong><?php echo htmlspecialchars($mensaje); ?></strong></p><?php endif; ?>

<?php if ($paso === 'buscar'): ?>
<form method="post" action="modificar.php" autocomplete="off" style="margin-bottom:12px;">
  <input type="hidden" name="accion" value="buscar">
  <label>Clave a modificar: <input type="text" name="clave" required></label>
  <button type="submit">Buscar</button>
</form>
<?php endif; ?>

<?php if ($paso === 'editar'): ?>
<form method="post" action="modificar.php" autocomplete="off">
  <input type="hidden" name="accion" value="editar">
  <label>Clave (no editable): <input type="text" name="clave" value="<?php echo htmlspecialchars($clave); ?>" readonly></label><br><br>
  <label>Nombre: <input type="text" name="nombre" value="<?php echo htmlspecialchars($registro['nombre']); ?>" required></label><br><br>
  <label>Teléfono: <input type="text" name="telefono" value="<?php echo htmlspecialchars($registro['telefono']); ?>" required></label><br><br>
  <label>Dirección: <input type="text" name="direccion" value="<?php echo htmlspecialchars($registro['direccion']); ?>" required></label><br><br>
  <button type="submit">Guardar cambios</button>
</form>
<?php endif; ?>

<p><a href="principal.php">Regresar a principal</a></p>
</body>
</html>
