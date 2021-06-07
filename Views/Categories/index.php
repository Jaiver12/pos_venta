<?php include "Views/Layouts/Header.php"; ?>

	<h1 class="mt-4">Categorias</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Inicio</li>
    </ol>

     <button type="button" class="btn btn-success mb-4" onclick="modalCategory();">
      <i class="fas fa-plus"></i> Nuevo
    </button>


    <table class="table table-light" id="tblCategories">
    	<thead class="table-dark">
    		<tr>
    			<th>#</th>
                <th>Nombre</th>
    			<th>Estado</th>
    			<th></th>
    		</tr>
    		<tbody>
    		</tbody>
    	</thead>
    </table>

 <div class="modal fade" id="modalCategories" tabindex="-1" aria-labelledby="tituloModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="tituloModalCategory">Nuevo Cliente</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method="POST" id="formCategory">
        	<input type="hidden" id="id" name="id">

            <div class="form-floating mb-3">
                <input class="form-control" id="name" name="name" type="text" placeholder="name@example.com" />
                <label for="name"> Nombre</label>
            </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" onclick="formCategories(event);">Guardar</button>
        </form>
      </div>
    </div>
  </div>
</div>

<?php include "Views/Layouts/Footer.php"; ?>