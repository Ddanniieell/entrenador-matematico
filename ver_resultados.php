

<?php
// Conexión a la base de datos
$conn = new mysqli("localhost", "root", "", "entrenador");

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Consulta para obtener resultados ordenados por id descendente (más recientes primero)
$sql = "SELECT id, respuesta_usuario, correcta FROM resultados ORDER BY id DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Historial de Resultados - Entrenador Matemático</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #e0eafc, #cfdef3);
            font-family: 'Segoe UI', sans-serif;
        }
        .container {
            margin-top: 50px;
        }
        table {
            background: white;
            border-radius: 8px;
            box-shadow: 0 8px 16px rgba(0,0,0,0.15);
        }
    </style>
</head>
<body>
<div class="container">
    <h2 class="mb-4 text-center">📊 Historial de Resultados</h2>

    <table class="table table-striped table-hover text-center">
        <thead class="table-primary">
            <tr>
                <th>ID</th>
                <th>Respuesta Usuario</th>
                <th>Correcta</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result->num_rows > 0): ?>
                <?php while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo htmlspecialchars($row['respuesta_usuario']); ?></td>
                    <td>
                        <?php 
                            if ($row['correcta'] == 1) echo "✅ Sí"; 
                            else echo "❌ No"; 
                        ?>
                    </td>
                </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="3">No hay resultados guardados aún.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>

    <div class="text-center mt-4">
        <a href="index.php" class="btn btn-primary">← Volver al Entrenador</a>
    </div>
</div>
</body>
</html>

<?php
$conn->close();
?>
