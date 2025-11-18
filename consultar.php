<?php
require __DIR__ . '/db.php';

$buscada = trim($_GET['clave'] ?? '');
$filas = [];

if ($buscada !== '') {
    $stmt = $pdo->prepare("SELECT clave, nombre, telefono, direccion
                           FROM contactos WHERE clave = :c ORDER BY clave");
    $stmt->execute([':c' => $buscada]);
    $filas = $stmt->fetchAll();
} else {
    $stmt = $pdo->query("SELECT clave, nombre, telefono, direccion
                         FROM contactos ORDER BY clave");
    $filas = $stmt->fetchAll();
}
?>
<!DOCTYPE html>
<html lang="es">
<head><meta charset="UTF-8"><title>Consultar</title></head>
<body>
<h1>Consultar registros</h1>

<form method="get" action="consultar.php" style="margin-bottom:10px;">
  <label>Buscar por clave: <input type="text" name="clave" value="<?php echo htmlspecialchars($buscada); ?>"></label>
  <button type="submit">Buscar</button>
  <a href="consultar.php">Ver todos</a>
</form>

<?php if (empty($filas)): ?>
  <p>No hay registros para mostrar.</p>
<?php else: ?>
  <table border="1" cellspacing="0" cellpadding="6">
    <tr>
      <th>Clave</th><th>Nombre</th><th>Teléfono</th><th>Dirección</th>
    </tr>
    <?php foreach ($filas as $r): ?>
      <tr>
        <td><?php echo htmlspecialchars($r['clave']); ?></td>
        <td><?php echo htmlspecialchars($r['nombre']); ?></td>
        <td><?php echo htmlspecialchars($r['telefono']); ?></td>
        <td><?php echo htmlspecialchars($r['direccion']); ?></td>
      </tr>
    <?php endforeach; ?>
  </table>
<?php endif; ?>

<p><a href="principal.php">Regresar a principal</a></p>
</body>
</html>
