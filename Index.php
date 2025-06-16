<?php
session_start();

if (!isset($_SESSION['a']) || !isset($_SESSION['b'])) {
    $_SESSION['a'] = rand(1, 20);
    $_SESSION['b'] = rand(1, 20);
}

$mensaje = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $respuesta = $_POST['respuesta'];
    $a = $_SESSION['a'];
    $b = $_SESSION['b'];
    $correcta = $a + $b;

    $esCorrecta = ($respuesta == $correcta) ? 1 : 0;
    $mensaje = $esCorrecta ? "✅ ¡Correcto!" : "❌ Incorrecto. La respuesta correcta era $correcta";

    // Guardar en la base de datos
    $conn = new mysqli("localhost", "root", "", "entrenador");
    if ($conn->connect_error) {
        die("Error de conexión: " . $conn->connect_error);
    }
    $stmt = $conn->prepare("INSERT INTO resultados (respuesta_usuario, correcta) VALUES (?, ?)");
    $stmt->bind_param("si", $respuesta, $esCorrecta);
    $stmt->execute();
    $stmt->close();
    $conn->close();

    // Generar nuevos valores
    $_SESSION['a'] = rand(1, 20);
    $_SESSION['b'] = rand(1, 20);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Entrenador Matemático</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #e0eafc, #cfdef3);
            font-family: 'Segoe UI', sans-serif;
        }
        .card {
            margin-top: 100px;
            border-radius: 15px;
            box-shadow: 0 10px 20px rgba(0,0,0,0.2);
        }
        .btn-primary {
            width: 100%;
        }
    </style>
</head>
<body>
<div class="container d-flex justify-content-center">
    <div class="card p-5 col-md-6">
        <h2 class="text-center mb-4">🧮 Entrenador Matemático</h2>
        <form method="POST">
            <div class="mb-3 text-center fs-4">
                ¿Cuánto es <?php echo $_SESSION['a']; ?> + <?php echo $_SESSION['b']; ?>?
            </div>
            <input type="number" name="respuesta" class="form-control mb-3" required autofocus>
            <button type="submit" class="btn btn-primary">Responder</button>
        </form>

        <?php if ($mensaje): ?>
            <div class="alert mt-4 text-center <?php echo strpos($mensaje, 'Correcto') !== false ? 'alert-success' : 'alert-danger'; ?>">
                <?php echo $mensaje; ?>
            </div>
        <?php endif; ?>

        <hr>
        <a href="ver_resultados.php" class="btn btn-outline-secondary mt-3">📊 Ver Historial de Respuestas</a>
    </div>
</div>
</body>
</html>
