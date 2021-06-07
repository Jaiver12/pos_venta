<?php include "Views/Layouts/Header.php"; ?>

	<h1 class="mt-4">Medidas</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Inicio</li>
    </ol>

     <button type="button" class="btn btn-success mb-4" onclick="modalMedida();">
      <i class="fas fa-plus"></i> Nuevo
    </button>


    <table class="table table-light" id="tblMedidas">
    	<thead class="table-dark">
    		<tr>
    			<th>#</th>
          <th>Nombre</th>
          <th>Nombre corto</th>
    			<th>Estado</th>
    			<th></th>
    		</tr>
    		<tbody>
    		</tbody>
    	</thead>
    </table>

 <div class="modal fade" id="modalMedidas" tabindex="-1" aria-labelledby="tituloModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="tituloModalMedida">Nuevo Medida</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method="POST" id="formMedida">
        	<input type="hidden" id="id" name="id">

            <div class="form-floating mb-3">
                <input class="form-control" id="name" name="name" type="text" placeholder="name@example.com" />
                <label for="name"> Nombre</label>
            </div>

            <div class="form-floating mb-3">
                <input class="form-control" id="namecorto" name="namecorto" type="text" placeholder="name@example.com" />
                <label for="name"> Nombre Corto</label>
            </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" onclick="formMedida(event);">Guardar</button>
        </form>
      </div>
    </div>
  </div>
</div>

<?php include "Views/Layouts/Footer.php"; ?>