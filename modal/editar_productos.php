	<?php
		if (isset($con))
		{
	?>
	<!-- Modal -->
	<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-edit'></i> Editar producto</h4>
		  </div>
		  <div class="modal-body">
			<form class="form-horizontal" method="post" id="editar_producto" name="editar_producto">
			<div id="resultados_ajax2"></div>
			  <div class="form-group">
				<label for="mod_codigo" class="col-sm-3 control-label">Código</label>
				<div class="col-sm-8">
				  <input type="text" class="form-control" id="mod_codigo" name="mod_codigo" placeholder="Código del producto" required>
					<input type="hidden" name="mod_id" id="mod_id">
				</div>
			  </div>
			   <div class="form-group">
				<label for="mod_nombre" class="col-sm-3 control-label">Nombre</label>
				<div class="col-sm-8">
				  <textarea class="form-control" id="mod_nombre" name="mod_nombre" placeholder="Nombre del producto" required></textarea>
				</div>
			  </div>
			  <div class="form-group">
				<label for="mod_descripcion" class="col-sm-3 control-label">Descripción</label>
				<div class="col-sm-8">
					<textarea class="form-control" id="mod_descripcion" name="mod_descripcion" placeholder="Descripción del producto" required maxlength="255" ></textarea>
				  
				</div>
			  </div>
			   <div class="form-group">
				<label for="mod_stock" class="col-sm-3 control-label">Stock</label>
				<div class="col-sm-8">
				  <input type="number" class="form-control" id="mod_stock" name="mod_stock" placeholder="Cantidad de productos disponibles" required  maxlength="100">
				</div>
			  </div>
			  
                <div class="form-group">
				<label for="mod_precioC" class="col-sm-3 control-label">Costo del producto (unidad)</label>
				<div class="col-sm-8">
                                    <input type="number" step="any" onkeyup='calcularpvp();' class="form-control" id="mod_precioC" name="mod_precioC" placeholder="Costo de compra" required  maxlength="100">
				</div>
			  </div>
			  <div class="form-group">
				<label for="mod_precio" class="col-sm-3 control-label">Precio de venta</label>
				<div class="col-sm-8">
				  <input type="number" step="any"  class="form-control" id="mod_precio" name="mod_precio" placeholder="Precio de venta del producto" required  maxlength="8">
				</div>
			  </div>
			  <div class="form-group">
				<label for="mod_estado" class="col-sm-3 control-label">Estado</label>
				<div class="col-sm-8">
				 <select class="form-control" id="mod_estado" name="mod_estado" required>
					<option value="">-- Selecciona estado --</option>
					<option value="1" selected>Activo</option>
					<option value="0">Inactivo</option>
				  </select>
				</div>
			  </div>
			  
			 
			 
			
		  </div>
		  <div class="modal-footer">
		  	<a href="#" onclick="limpiar()" class='btn btn-default' title='Limpiar'> <i class="glyphicon glyphicon-erase" ></i> </a> 
		  	
			<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
			<button type="submit" class="btn btn-primary" id="actualizar_datos">Actualizar datos</button>
		  </div>
		  </form>
		</div>
	  </div>
	</div>
	<?php
		}
	?>