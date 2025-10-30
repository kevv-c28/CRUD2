<?php
include 'bd.php';
$nombre = '';
$id = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $sql_post = "DELETE FROM usuarios WHERE id = $1";
    $stmt_post = pg_prepare($conexion, "borrar_usuario", $sql_post);
    if ($stmt_post) {
        pg_execute($conexion, "borrar_usuario", [$id]);
        header("Location: index.php");
        exit;
    } else {
        echo "Error al eliminar: " . pg_last_error($conexion);
    }
}

//para mostrar confirmar
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql_get = "SELECT nombre FROM usuarios WHERE id = $1";
    $stmt_get = pg_prepare($conexion, "buscar_usuario_borrar", $sql_get);
    if ($stmt_get) {
        $resultado_get = pg_execute($conexion, "buscar_usuario_borrar", [$id]);
        $usuario = pg_fetch_assoc($resultado_get);
        if ($usuario) {
            $nombre = $usuario['nombre'];
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
    <title>Eliminar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <h2 class="mb-3">Confirmar Borrado</h2>
                <div class="alert alert-danger" role="alert">
                    ¿Estás seguro de que deseas eliminar al usuario: <strong><?php echo htmlspecialchars($nombre); ?></strong>?
                    <p>Esta acción no se puede deshacer.</p>
                </div>
                <form method="POST">
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                    <div>
                        <button type="submit" class="btn btn-danger">Confirmar eliminado</button>
                        <a href="index.php" class="btn btn-secondary">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

</body>

</html>