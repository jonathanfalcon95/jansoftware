
$(document).ready(function() {
    load(1);
    $("#resultados").load("ajax/editar_facturacion.php");
});

function load(page) {
    var q = $("#q").val();
    $("#loader").fadeIn('slow');
    $.ajax({
        url: './ajax/productos_factura.php?action=ajax&page=' + page + '&q=' + q,
        beforeSend: function(objeto) {
            $('#loader').html('<img src="./img/ajax-loader.gif"> Cargando...');
        },
        success: function(data) {
            $(".outer_div").html(data).fadeIn('slow');
            $('#loader').html('');

        }
    })
}
function agregar(id)
{
    var precio_venta = document.getElementById('precio_venta_' + id).value;
    var cantidad = document.getElementById('cantidad_' + id).value;
    var stock = document.getElementById('stock_' + id).value;
    //Inicia validacion

    if (isNaN(cantidad))
    {
        alert('Esto no es un numero');
        document.getElementById('cantidad_' + id).focus();
        return false;
    }
    if (isNaN(precio_venta))
    {
        alert('Esto no es un numero');
        document.getElementById('precio_venta_' + id).focus();
        return false;
    }
    if (isNaN(stock))
    {
        alert('Esto no es un numero');
        document.getElementById('stock_' + id).focus();
        return false;
    }
    if (parseInt(cantidad) > parseInt(stock))
    {
        alert('la cantidad no puede ser superior al stock disponible');
        document.getElementById('stock_' + id).focus();
        return false;
    }
    //Fin validacion

    $.ajax({
        type: "POST",
        url: "./ajax/editar_facturacion.php",
        data: "id=" + id + "&precio_venta=" + precio_venta + "&cantidad=" + cantidad,
        beforeSend: function(objeto) {
            $("#resultados").html("Mensaje: Cargando...");
        },
        success: function(datos) {
            $("#resultados").html(datos);
            load(1);

        }
    });
}
//	function agregar (id)
//		{
//			var precio_venta=document.getElementById('precio_venta_'+id).value;
//			var cantidad=document.getElementById('cantidad_'+id).value;
//			//Inicia validacion
//			if (isNaN(cantidad))
//			{
//			alert('Esto no es un numero');
//			document.getElementById('cantidad_'+id).focus();
//			return false;
//			}
//			if (isNaN(precio_venta))
//			{
//			alert('Esto no es un numero');
//			document.getElementById('precio_venta_'+id).focus();
//			return false;
//			}
//			//Fin validacion
//			
//			$.ajax({
//        type: "POST",
//        url: "./ajax/editar_facturacion.php",
//        data: "id="+id+"&precio_venta="+precio_venta+"&cantidad="+cantidad,
//		 beforeSend: function(objeto){
//			$("#resultados").html("Mensaje: Cargando...");
//		  },
//        success: function(datos){
//		$("#resultados").html(datos);
//		}
//			});
//		}

function eliminar(id, cantidad, idp)
{

    $.ajax({
        type: "GET",
        url: "./ajax/editar_facturacion.php",
        data: "id=" + id + "&cantidad=" + cantidad + "&idp=" + idp,
        beforeSend: function(objeto) {
            $("#resultados").html("Mensaje: Cargando...");
        },
        success: function(datos) {
            $("#resultados").html(datos);
             load(1);
        }
    });

}

$("#datos_factura").submit(function(event) {
    var id_cliente = $("#id_cliente").val();

    if (id_cliente == "") {
        alert("Debes seleccionar un cliente");
        $("#nombre_cliente").focus();
        return false;
    }
    var parametros = $(this).serialize();
    $.ajax({
        type: "POST",
        url: "ajax/editar_factura.php",
        data: parametros,
        beforeSend: function(objeto) {
            $(".editar_factura").html("Mensaje: Cargando...");
        },
        success: function(datos) {
            $(".editar_factura").html(datos);
        }
    });

    event.preventDefault();
});

$("#guardar_cliente").submit(function(event) {
    $('#guardar_datos').attr("disabled", true);

    var parametros = $(this).serialize();
    $.ajax({
        type: "POST",
        url: "ajax/nuevo_cliente.php",
        data: parametros,
        beforeSend: function(objeto) {
            $("#resultados_ajax").html("Mensaje: Cargando...");
        },
        success: function(datos) {
            $("#resultados_ajax").html(datos);
            $('#guardar_datos').attr("disabled", false);
            load(1);
        }
    });
    event.preventDefault();
})

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

function imprimir_factura(id_factura) {
    VentanaCentrada('./pdf/documentos/ver_factura.php?id_factura=' + id_factura, 'Factura', '', '1024', '768', 'true');
}