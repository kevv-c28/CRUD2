<?php

include 'db.php';
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD KEVIN</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <div class="container mt-4">
        <div class="row">
            <div class="col-md-10 offset-md-1">

                <h2 class="mb-3">Lista de Usuarios</h2>
                <a href="crear.php" class="btn btn-success mb-3">Crear Nuevo Usuario</a>

                <table class="table table-striped table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Email</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        //aquí es para la consulta de la conexión SQL para que no te olvides
                        $sql = "SELECT * FROM usuarios ORDER BY id ASC";
                        $resultado = pg_query($conexion, $sql);

                        if (!$resultado) {
                            echo "<tr><td colspan='4'>Error en la consulta: " . pg_last_error($conexion) . 
                            "</td>
                            </tr>";
                        } else {

                            while ($row = pg_fetch_assoc($resultado)) {
                                echo "<td>" . $row['id'] . "</td>";
                                echo "<td>" . htmlspecialchars($row['nombre']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                                echo "<a href='editar.php?id=" . $row['id'] . "' class='btn btn-primary btn-sm'>Editar</a> ";
                                echo "<a href='borrar.php?id=" . $row['id'] . "' class='btn btn-danger btn-sm'>Borrar</a>";
                               /*  echo "</td>";
                                echo "</tr>"; */
                            }
                        }

                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</body>

</html>