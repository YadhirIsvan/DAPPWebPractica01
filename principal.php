<?php
require __DIR__ . '/db.php';

// (Opcional) contar registros para mostrar
$total = (int) $pdo->query("SELECT COUNT(*) FROM contactos")->fetchColumn();
?>
<!DOCTYPE html>
<html lang="es">
<head><meta charset="UTF-8"><title>Principal</title></head>
<body>
<h1>Menú principal (registros: <?php echo $total; ?>)</h1>

<form action="guardar.php" method="get" style="margin-bottom:8px;">
  <button type="submit">Guardar (crear)</button>
</form>
<form action="consultar.php" method="get" style="margin-bottom:8px;">
  <button type="submit">Consultar</button>
</form>
<form action="modificar.php" method="get" style="margin-bottom:8px;">
  <button type="submit">Modificar</button>
</form>
<form action="eliminar.php" method="get" style="margin-bottom:8px;">
  <button type="submit">Eliminar</button>
</form>
</body>
</html>
