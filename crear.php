<?php
//esto procesa el formulario con POST. para que no se me olvide
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include 'bd.php';
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $nombre_consulta = "crear_usuario";
    $sql = "INSERT INTO usuarios (nombre, email) VALUES ($1, $2)";
    $stmt = pg_prepare($conexion, $nombre_consulta, $sql);

    if ($stmt) {
        $resultado = pg_execute($conexion, $nombre_consulta, [$nombre, $email]);
        if ($resultado) {
            header("Location: index.php");
            exit;
        } else {
            echo "Error al guardar el usuario: " . pg_last_error($conexion);
        }
    } else {
        echo "Error al preparar la consulta: " . pg_last_error($conexion);
    }
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Usuario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <h2 class="mb-3">Crear Nuevo Usuario</h2>
                <form method="POST">
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre:</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email:</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                        <a href="index.php" class="btn btn-secondary">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

</body>

</html>