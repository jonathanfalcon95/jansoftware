<?php
session_start();
if (!isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] != 1) {
    header("location: login.php");
    exit;
}

/* Connect To Database */
require_once ("config/db.php"); //Contiene las variables de configuracion para conectar a la base de datos
require_once ("config/conexion.php"); //Contiene funcion que conecta a la base de datos
include("funciones.php");
$active_facturas = "";
$active_productos = "active";
$active_clientes = "";
$active_usuarios = "";
$title = "Producto";

if (isset($_POST['reference']) and isset($_POST['quantity'])) {
    $quantity = intval($_POST['quantity']);
    $reference = mysqli_real_escape_string($con, (strip_tags($_POST["reference"], ENT_QUOTES)));
    $id_producto = intval($_GET['id']);
    $costo = floatval($_POST['costo']);
    $pvp = floatval($_POST['precio']);
    $user_id = $_SESSION['user_id'];
    $firstname = $_SESSION['firstname'];
    $nota = "$firstname agregó $quantity producto(s) al inventario con un precio de venta de $pvp Bs ";
    $fecha = date("Y-m-d H:i:s");
    guardar_historial($id_producto, $user_id, $fecha, $nota, $reference, $quantity, $costo, $pvp);
    $update = agregar_stock($id_producto, $quantity, $costo,$pvp);
    if ($update == 1) {
        $message = 1;
    } else {
        $error = 1;
    }
}

if (isset($_POST['reference_remove']) and isset($_POST['quantity_remove'])) {
    $quantity = intval($_POST['quantity_remove']);
    $reference = mysqli_real_escape_string($con, (strip_tags($_POST["reference_remove"], ENT_QUOTES)));
    $id_producto = intval($_GET['id']);
    $user_id = $_SESSION['user_id'];
    $firstname = $_SESSION['firstname'];
    $costo = 0;
    $nota = "$firstname eliminó $quantity producto(s) del inventario";
    $fecha = date("Y-m-d H:i:s");
    guardar_historial($id_producto, $user_id, $fecha, $nota, $reference, $quantity, $costo);
    $update = eliminar_stock($id_producto, $quantity);
    if ($update == 1) {
        $message = 1;
    } else {
        $error = 1;
    }
}

if (isset($_GET['id'])) {
    $id_producto = intval($_GET['id']);
    $query = mysqli_query($con, "select * from products where id_producto='$id_producto'");
    $row = mysqli_fetch_array($query);
} else {
    die("Producto no existe");
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <?php include("head.php"); ?>
    </head>
    <body>
        <?php
        include("navbar.php");
        include("modal/agregar_stock.php");
        include("modal/eliminar_stock.php");
        include("modal/editar_productos.php");
        ?>

        <div class="container">

            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-sm-4 col-sm-offset-2 text-center">
                                    <img class="item-img img-responsive" src="img/stock.png" alt=""> 
                                    <br>
                                    <a href="#" class="btn btn-danger" onclick="eliminar('<?php echo $row['id_producto']; ?>')" title="Eliminar"> <i class="glyphicon glyphicon-trash"></i> Eliminar </a> 
                                    <a href="#myModal2" data-toggle="modal" data-codigo='<?php echo $row['codigo_producto']; ?>' data-nombre='<?php echo $row['nombre_producto']; ?>' data-descripcion='<?php echo $row['descripcion'] ?>' data-precioc='<?php echo $row['precio_compra'] ?>' data-precio='<?php echo $row['precio_producto'] ?>' data-stock='<?php echo $row['stock']; ?>' data-id='<?php echo $row['id_producto']; ?>' class="btn btn-info" title="Editar"> <i class="glyphicon glyphicon-pencil"></i> Editar </a>	

                                </div>

                                <div class="col-sm-4 text-left">
                                    <div class="row margin-btm-20">
                                        <div class="col-sm-12">
                                            <span class="current-stock "> <?php echo $row['nombre_producto']; ?></span>
                                        </div>
                                        <div class="col-sm-12 margin-btm-10">
                                            <span class="item-number"><?php echo $row['codigo_producto']; ?></span>
                                        </div>
                                        <div class="col-sm-12 margin-btm-10">
                                        </div>
                                        <div class="col-sm-12">
                                            <span class="current-stock">Stock disponible</span>
                                        </div>
                                        <div class="col-sm-12 margin-btm-10">
                                            <span class="item-quantity"><?php echo $row['stock']; ?></span>
                                        </div>
                                        <div class="col-sm-12">
                                            <span class="current-stock"> Precio venta  </span>
                                        </div>
                                        <div class="col-sm-12">
                                            <span class="item-price">Bs <?php echo number_format($row['precio_producto'], 2, ",", "."); ?></span>
                                        </div>

                                        <div class="col-sm-12 margin-btm-10">
                                        </div>
                                        <div class="col-sm-6 col-xs-6 col-md-4 ">
                                            <a href="#add-stock" data-toggle="modal" data-target="#add-stock" data-precioc='<?php echo $row['precio_compra'] ?>' data-precio='<?php echo $row['precio_producto']?>'  ><img width="100px"  src="img/stock-in.png"></a>
                                        </div>
                                        <div class="col-sm-6 col-xs-6 col-md-4">
                                            <a href="" data-toggle="modal" data-target="#remove-stock"><img width="100px"  src="img/stock-out.png"></a>
                                        </div>
                                        <div class="col-sm-12 margin-btm-10">
                                        </div>


                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="row">

                                <div class="col-sm-8 col-sm-offset-2 text-left">
                                    <div class="row">
                                        <?php
                                        if (isset($message)) {
                                            ?>
                                            <div class="alert alert-success alert-dismissible" role="alert">
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                <strong>Aviso!</strong> Datos procesados exitosamente.
                                            </div>	
                                            <?php
                                        }
                                        if (isset($error)) {
                                            ?>
                                            <div class="alert alert-danger alert-dismissible" role="alert">
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                <strong>Error!</strong> No se pudo procesar los datos.
                                            </div>	
                                            <?php
                                        }
                                        ?>	
                                        <table class='table table-bordered'>
                                            <tr>
                                                <th class='text-center' colspan=5 >HISTORIAL DE INVENTARIO</th>
                                            </tr>
                                            <tr>
                                                <td>Fecha</td>
                                                <td>Hora</td>
                                                <td>Descripción</td>
                                                <td>Costo de compra (Bs)</td>
                                                <td>Referencia</td>
                                                <td class='text-center'>Total</td>
                                            </tr>
                                            <?php
                                            $query = mysqli_query($con, "select * from historial where id_producto='$id_producto'");
                                            while ($row = mysqli_fetch_array($query)) {
                                                ?>
                                                <tr>
                                                    <td><?php echo date('d/m/Y', strtotime($row['fecha'])); ?></td>
                                                    <td><?php echo date('H:i:s', strtotime($row['fecha'])); ?></td>
                                                    <td><?php echo $row['nota']; ?></td>
                                                    <td><?php echo number_format($row['costo'], 2, ",", "."); ?></td>
                                                    <td><?php echo $row['referencia']; ?></td>
                                                    <td class='text-center'><?php echo $row['cantidad']; ?></td>
                                                </tr>		
                                                <?php
                                            }
                                            ?>
                                        </table>
                                    </div>


                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>



        </div>


        <?php
        include("footer.php");
        ?>
        <script type="text/javascript" src="js/productos.js"></script>
    </body>
</html>
<script>
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
                                                    window.setTimeout(function() {
                                                        $(".alert").fadeTo(500, 0).slideUp(500, function() {
                                                            $(this).remove();
                                                        });
                                                        location.replace('productos.php');
                                                    }, 500);
                                                }
                                            });
                                            event.preventDefault();
                                        })

                                        $('#myModal2').on('show.bs.modal', function(event) {
                                            var button = $(event.relatedTarget) // Button that triggered the modal
                                            var codigo = button.data('codigo') // Extract info from data-* attributes
                                            var nombre = button.data('nombre')
                                            var descripcion = button.data('descripcion')
                                            //var categoria = button.data('categoria')
                                            var precioc = button.data('precioc')
                                            var precio = button.data('precio')
                                            var stock = button.data('stock')
                                            var id = button.data('id')
                                            var modal = $(this)
                                            modal.find('.modal-body #mod_codigo').val(codigo)
                                            modal.find('.modal-body #mod_nombre').val(nombre)
                                            modal.find('.modal-body #mod_descripcion').val(descripcion)
                                            modal.find('.modal-body #mod_precioC').val(precioc)
                                            modal.find('.modal-body #mod_precio').val(precio)
                                            modal.find('.modal-body #mod_stock').val(stock)
                                            modal.find('.modal-body #mod_id').val(id)
                                        })
                                        
                                        $('#add-stock').on('show.bs.modal', function(event) {
                                            var button = $(event.relatedTarget) // Button that triggered the modal
                                           
                                            var costo = button.data('precioc')
                                            var precio = button.data('precio')

                                            var modal = $(this)
                                            modal.find('.modal-body #costo').val(costo)
                                            modal.find('.modal-body #precio').val(precio)

                                        })
                                        function eliminar(id) {
                                            var q = $("#q").val();
                                            if (confirm("Realmente deseas eliminar el producto?")) {
                                                location.replace('productos.php?delete=' + id);
                                            }
                                        }
                                        function limpiar() {


                                            /*$("#mod_codigo").val("");*/
                                            $("#mod_nombre").val("");
                                            $("#mod_descripcion").val("");
                                            $("#mod_stock").val("");
                                            $("#mod_precioC").val("");
                                            $("#mod_precio").val("");


                                        }


                                        function calcularpvp() {
                                            $('#actualizar_datos').attr("disabled", true);

                                            var precioc = $("#mod_precioC").val();
                                            $.ajax({
                                                type: "POST",
                                                url: "ajax/calcular_pvp.php?action=ajax&precioc=" + precioc,
//                                            data: parametros,
                                                beforeSend: function(objeto) {
                                                    $("#resultados_ajax2").html("Mensaje: Cargando...");
                                                },
                                                success: function(datos) {
                                                    $("#mod_precio").val(datos);
//                                                    $("#precio").html(datos);
                                                    $('#actualizar_datos').attr("disabled", false);

                                                }
                                            });
                                            event.preventDefault();
                                        }
                                        function calcularpvp1() {
                                            $('#actualizar_datos').attr("disabled", true);

                                            var precioc = $("#costo").val();
                                            $.ajax({
                                                type: "POST",
                                                url: "ajax/calcular_pvp.php?action=ajax&precioc=" + precioc,
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