<?php include "Views/Layouts/Header.php"; ?>

	<h1 class="mt-4">Productos</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Inicio</li>
    </ol>

     <button type="button" class="btn btn-success mb-4" onclick="modalProduct();">
      <i class="fas fa-plus"></i> Nuevo
    </button>


    <table class="table table-light" id="tblProducts">
    	<thead class="table-dark">
    		<tr>
          <th>#</th>
          <th>Imagen</th>
    			<th>Codigo</th>
          <th>Nombre</th>
          <th>Descripcion</th>
          <th>Precio</th>
          <th>Stock</th>
    			<th>Estado</th>
    			<th></th>
    		</tr>
    		<tbody>
    		</tbody>
    	</thead>
    </table>

 <div class="modal fade" id="modalProducts" tabindex="-1" aria-labelledby="tituloModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="tituloModalProduct">Nuevo Producto</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method="POST" id="formProduct">
        	<input type="hidden" id="id" name="id">

            <div class="form-floating mb-3">
                <input class="form-control" id="codigo" name="codigo" type="text" placeholder="name@example.com" />
                <label for="codigo"> Codigo de barra</label>
            </div>

            <div class="form-floating mb-3">
                <input class="form-control" id="name" name="name" type="text" placeholder="name@example.com" />
                <label for="name"> Nombre</label>
            </div>

            <div class="form-floating mb-3">
                <input class="form-control" id="description" name="description" type="text" placeholder="name@example.com" />
                <label for="description"> Descripcion</label>
            </div>

            <div class="form-floating mb-3">
                <input class="form-control" id="price_comp" name="price_comp" type="number" placeholder="name@example.com" />
                <label for="price_comp"> Precio de compra</label>
            </div>

            <div class="form-floating mb-3">
                <input class="form-control" id="price_vent" name="price_vent" type="number" placeholder="name@example.com" />
                <label for="price_vent"> Precio de venta</label>
            </div>

            <div class="form-floating mb-3">
                <select class="form-select" id="id_medida" name="id_medida" aria-label="Floating label select example">
                  <?php foreach ($data['medidas'] as $medida) { ?>
                    <option value="<?=$medida['id']?>"><?=$medida['name']?></option>
                  <?php } ?>
                </select>
                <label for="medida">Medidas</label>
            </div>

            <div class="form-floating mb-3">
                <select class="form-select" id="id_category" name="id_category" aria-label="Floating label select example">
                  <?php foreach ($data['categories'] as $category) { ?>
                    <option value="<?=$category['id']?>"><?=$category['name']?></option>
                  <?php } ?>
                </select>
                <label for="category">Categorias</label>
            </div>

            <div class="form-floating mb-3">
                <label class="form-label">Elige la foto</label>
                <div class="card">
                  <div class="card-body">
                    <label for="img" class="btn btn-primary"><i class="fas fa-image"></i></label>
                    <input class="d-none" type="file" id="img" name="img" onchange="preview(event)">
                    <img id="img-preview" class="img-thumbnail">
                  </div>
                </div>

            </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" onclick="formProducts(event);">Guardar</button>
        </form>
      </div>
    </div>
  </div>
</div>

<?php include "Views/Layouts/Footer.php"; ?>