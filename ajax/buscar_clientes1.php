<?php

include('is_logged.php'); //Archivo verifica que el usario que intenta acceder a la URL esta logueado
/* Connect To Database */
require_once ("../config/db.php"); //Contiene las variables de configuracion para conectar a la base de datos
require_once ("../config/conexion.php"); //Contiene funcion que conecta a la base de datos
//Archivo de funciones PHP
include("../funciones.php");
//	$action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
//		$id_producto=intval($_GET['id']);
$cedula = mysqli_real_escape_string($con, (strip_tags($_GET['cedula'], ENT_QUOTES)));

//echo $cedula;
$sql = "select * from clientes where cedula='$cedula'";
$query = mysqli_query($con, $sql);
$count = mysqli_num_rows($query);
$return_arr = array();
if ($count == 0) {
    $row_array['validacion'] = "no";
        

        array_push($return_arr, $row_array);
         mysqli_close($con);

    /* Toss back results as json encoded array. */
    echo json_encode($return_arr);


} else {

    

    while ($row = mysqli_fetch_array($query)) {
        $id_cliente = $row['id_cliente'];
        $row_array['value'] = $row['nombre_cliente'];
        $row_array['id_cliente'] = $id_cliente;
        $row_array['cedula'] = $row['cedula'];
        $row_array['nombre_cliente'] = $row['nombre_cliente'];
        $row_array['telefono_cliente'] = $row['telefono_cliente'];

        array_push($return_arr, $row_array);
    }



    /* Free connection resources. */
    mysqli_close($con);

    /* Toss back results as json encoded array. */
    echo json_encode($return_arr);
}

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

