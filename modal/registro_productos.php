	<?php
		if (isset($con))
		{
	?>
	<!-- Modal -->
	<div class="modal fade" id="nuevoProducto" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-edit'></i> Agregar nuevo producto</h4>
		  </div>
		  <div class="modal-body">
			<form class="form-horizontal" method="post" id="guardar_producto" name="guardar_producto">
			<div id="resultados_ajax_productos"></div>
			  <div class="form-group">
				<label for="codigo" class="col-sm-3 control-label">Código</label>
				<div class="col-sm-8">
				  <input type="text" class="form-control" id="codigo" name="codigo" placeholder="Código del producto" required>
				</div>
			  </div>
			  
			  <div class="form-group">
				<label for="nombre" class="col-sm-3 control-label">Nombre</label>
				<div class="col-sm-8">
					<textarea class="form-control" id="nombre" name="nombre" placeholder="Nombre del producto" required maxlength="255" ></textarea>
				  
				</div>
			  </div>

			  <div class="form-group">
				<label for="descripcion" class="col-sm-3 control-label">Descripción</label>
				<div class="col-sm-8">
					<textarea class="form-control" id="descripcion" name="descripcion" placeholder="Descripción del producto" required maxlength="255" ></textarea>
				  
				</div>
			  </div>
			  <div class="form-group">
				<label for="stock" class="col-sm-3 control-label">Stock</label>
				<div class="col-sm-8">
				  <input type="number" class="form-control" id="stock" name="stock" placeholder="Cantidad de productos disponibles" required  maxlength="100">
				</div>
			  </div>
			  
                <div class="form-group">
				<label for="precio_de_compra" class="col-sm-3 control-label">Costo del producto (unidad)</label>
				<div class="col-sm-8">
                                    <input type="number" step="any" onkeyup='datos();' class="form-control" id="precioC" name="precioC" placeholder="Costo de compra" required  maxlength="100">
				</div>
			  </div>

			  <div class="form-group">
				<label for="precio_de_venta"  class="col-sm-3 control-label">Precio de venta (PVP)</label>
				<div class="col-sm-8">
				  <input type="number" step="any" class="form-control" id="precio" name="precio" placeholder="Precio de venta del producto" required  maxlength="100">
				</div>
			  </div>
			 
			 <div class="form-group">
				<label for="estado" class="col-sm-3 control-label">Estado</label>
				<div class="col-sm-8">
				 <select class="form-control" id="estado" name="estado" required>
					<option value="">-- Selecciona estado --</option>
					<option value="1" selected>Activo</option>
					<option value="0">Inactivo</option>
				  </select>
				</div>
			  </div>
			 
			
		  </div>
		  <div class="modal-footer">
		  	<a href="#" onclick="limpiar()" class='btn btn-default' title='Limpiar'> <i class="glyphicon glyphicon-erase" ></i> </a> 
		  	<!-- <button type="button" class="btn" onclick="limpiar()" data-dismiss="modal"><li class="btn-default glyphicon glyphicon-erase"></li></button> -->
			<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
			<button type="submit" class="btn btn-primary" id="guardar_datos">Guardar datos</button>
		  </div>
		  </form>
		</div>
	  </div>
	</div>
	<?php
		}
	?>