<?php
include 'bd.php';
$nombre = '';
$email = '';
$id = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];

    $sql = "UPDATE usuarios SET nombre = $1, email = $2 WHERE id = $3";
    $stmt = pg_prepare($conexion, "actualizar_usuario", $sql);

    if ($stmt) {
        $resultado = pg_execute($conexion, "actualizar_usuario", [$nombre, $email, $id]);
        if ($resultado) {
            header("Location: index.php");
            exit;
        } else {
            echo "Error al actualizar: " . pg_last_error($conexion);
        }
    } else {
        echo "Error al preparar la actualización: " . pg_last_error($conexion);
    }
}

//solo carga los datos del usuario con el GET. acuerdate
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql_get = "SELECT * FROM usuarios WHERE id = $1";
    $stmt_get = pg_prepare($conexion, "buscar_usuario", $sql_get);

    if ($stmt_get) {
        $resultado_get = pg_execute($conexion, "buscar_usuario", [$id]);
        $usuario = pg_fetch_assoc($resultado_get);

        if ($usuario) {
            $nombre = $usuario['nombre'];
            $email = $usuario['email'];
        } else {
            header("Location: index.php");
            exit;
        }
    } else {
        echo "Error al preparar la búsqueda: " . pg_last_error($conexion);
        exit;
    }
} else {
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <h2 class="mb-3">Editar Usuario</h2>
                <form method="POST">
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre:</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo htmlspecialchars($nombre); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email:</label>
                        <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required>
                    </div>
                    <div>
                        <button type="submit" class="btn btn-primary">Actualizar</button>
                        <a href="index.php" class="btn btn-secondary">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

</body>

</html>