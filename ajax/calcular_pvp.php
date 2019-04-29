<?php

require_once ("../config/db.php"); //Contiene las variables de configuracion para conectar a la base de datos
require_once ("../config/conexion.php"); //Contiene funcion que conecta a la base de datos
include('is_logged.php'); //Archivo ver
$query_empresa = mysqli_query($con, "select * from perfil where id_perfil=1");
$row = mysqli_fetch_array($query_empresa);
$precioC = floatval($_GET['precioc']);
$porcentaje = floatval($row['porcentaje']);

$pvp = ($precioC * $porcentaje ) / 100;
$pvp = number_format($pvp, 2, '.', '');
$total = $precioC + $pvp;

echo $total;
?>