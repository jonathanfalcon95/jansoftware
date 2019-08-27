<?php
date_default_timezone_set('America/Caracas');


session_start();
if (!isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] != 1) {
    header("location: login.php");
    exit;
}

/* Connect To Database */
require_once ("config/db.php"); //Contiene las variables de configuracion para conectar a la base de datos
require_once ("config/conexion.php"); //Contiene funcion que conecta a la base de datos

$active_facturas = "";
$active_productos = "active";
$active_clientes = "";
$active_usuarios = "";
$title = "Productos ";
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <?php include("head.php"); ?>
    </head>
    <body>
        <?php
        include("navbar.php");
        ?>

        <div class="container">
            <div class="panel panel-primary">
                <div style="background:grey" class="panel-heading">
                    <div class="btn-group pull-right">
                        <button type='button' class="btn btn-primary" data-toggle="modal" data-target="#nuevoProducto"><span class="glyphicon glyphicon-plus" ></span> Nuevo Producto</button>
                    </div>
                    <h4><i class='glyphicon glyphicon-search'></i> Buscar Productos</h4>
                </div>
                <div class="panel-body">



                    <?php
                    include("modal/registro_productos.php");
                    include("modal/editar_productos.php");
                    ?>
                    <form class="form-horizontal" role="form" id="datos_cotizacion">

                        <div class="form-group row">
                            <label for="q" class="col-md-2 control-label">Código o nombre</label>
                            <div class="col-md-5">
                                <input type="text" class="form-control" id="q" placeholder="Código o nombre del producto" onkeyup='load(1);'>
                            </div>
                            <div class="col-md-3">
                                <button type="button" class="btn btn-default" onclick='load(1);'>
                                    <span class="glyphicon glyphicon-search" ></span> Buscar</button>
                                <span id="loader"></span>
                            </div>

                        </div>



                    </form>
                    <div id="resultados"></div><!-- Carga los datos ajax -->
                    <div class='outer_div'></div><!-- Carga los datos ajax -->






                </div>
            </div>

        </div>
        <hr>
        <?php
        include("footer.php");
        ?>
        <script type="text/javascript" src="js/productos.js"></script>
    </body>
</html>
<script>
                                    $("#guardar_producto").submit(function(event) {
                                        $('#guardar_datos').attr("disabled", true);

                                        var parametros = $(this).serialize();
                                        $.ajax({
                                            type: "POST",
                                            url: "ajax/nuevo_producto.php",
                                            data: parametros,
                                            beforeSend: function(objeto) {
                                                $("#resultados_ajax_productos").html("Mensaje: Cargando...");
                                            },
                                            success: function(datos) {
                                                $("#resultados_ajax_productos").html(datos);
                                                $('#guardar_datos').attr("disabled", false);
                                                load(1);
                                            }
                                        });
                                        event.preventDefault();
                                    })

                                    $("#editar_producto").submit(function(event) {
                                        $('#actualizar_datos').attr("disabled", true);

                                        var parametros = $(this).serialize();
                                        $.ajax({
                                            type: "POST",
                                            url: "ajax/editar_producto.php",
                                            data: parametros,
                                            beforeSend: function(objeto) {
                                                $("#resultados_ajax2").html("Mensaje: Cargando...");
                                            },
                                            success: function(datos) {
                                                $("#resultados_ajax2").html(datos);
                                                $('#actualizar_datos').attr("disabled", false);
                                                load(1);
                                            }
                                        });
                                        event.preventDefault();
                                    })

                                    function obtener_datos(id) {
                                        var codigo_producto = $("#codigo_producto" + id).val();
                                        var nombre_producto = $("#nombre_producto" + id).val();
                                        var estado = $("#estado" + id).val();
                                        var precio_producto = $("#precio_producto" + id).val();
                                        $("#mod_id").val(id);
                                        $("#mod_codigo").val(codigo_producto);
                                        $("#mod_nombre").val(nombre_producto);
                                        $("#mod_precio").val(precio_producto);
                                        $("#mod_estado").val(estado);
                                    }
                                    function limpiar() {

                                        /*$("#mod_id").val("");
                                         $("#mod_codigo").val("");
                                         $("#mod_nombre").val("");
                                         $("#mod_descripcion").val("");
                                         $("#mod_stock").val("");
                                         $("#mod_precioc").val("");
                                         $("#mod_precio").val("");*/
                                        $("#id").val("");
                                        $("#codigo").val("");
                                        $("#nombre").val("");
                                        $("#descripcion").val("");
                                        $("#stock").val("");
                                        $("#precioC").val("");
                                        $("#precio").val("");

                                    }
                                    $(document).ready(function() {
<?php
if (isset($_GET['delete'])) {
    ?>
                                            eliminar(<?php echo intval($_GET['delete']) ?>);
    <?php
}
?>


                                    });



                                    function datos() {//funcion para calcular el precio del producto al porcentaje de ganancia
                                        $('#actualizar_datos').attr("disabled", true);

                                        var precioc = $("#precioC").val();
                                        $.ajax({
                                            type: "POST",
                                            url: "ajax/calcular_pvp.php?action=ajax&precioc="+precioc,
//                                            data: parametros,
                                            beforeSend: function(objeto) {
                                                $("#resultados_ajax2").html("Mensaje: Cargando...");
                                            },
                                            success: function(datos) {
                                                $("#precio").val(datos);
//                                                    $("#precio").html(datos);
                                                $('#actualizar_datos').attr("disabled", false);

                                            }
                                        });
                                        event.preventDefault();
                                    }
</script>