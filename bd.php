<?php
$conexion = pg_connect("host=localhost port=5432 dbname=crudd user=postgres password=Coronado2006*");

if (!$conexion){
    echo "Error al conectar a la base de datos.";
    exit; 
} else {

}
?>
