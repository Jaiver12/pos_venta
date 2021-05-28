<?php include "Views/Layouts/Header.php"; ?>

	<h1 class="mt-4">Clientes</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Inicio</li>
    </ol>

     <button type="button" class="btn btn-success mb-4" onclick="modalClient();">
      <i class="fas fa-plus"></i> Nuevo
    </button>


    <table class="table table-light" id="tblClients">
    	<thead class="table-dark">
    		<tr>
    			<th>#</th>
    			<th>DNI</th>
    			<th>Nombre</th>
                <th>Telefino</th>
    			<th>Dirección</th>
    			<th>Status</th>
    			<th></th>
    		</tr>
    		<tbody>
    		</tbody>
    	</thead>
    </table>

 <div class="modal fade" id="modalClients" tabindex="-1" aria-labelledby="tituloModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="tituloModalClient">Nuevo Cliente</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method="POST" id="formClient">
        	<input type="hidden" id="id" name="id">

        	<div class="form-floating mb-3">
                <input class="form-control" id="dni" name="dni" type="text" placeholder="name@example.com" />
                <label for="dni"> DNI</label>
            </div>
            <div class="form-floating mb-3">
                <input class="form-control" id="name" name="name" type="text" placeholder="name@example.com" />
                <label for="name"> Nombre</label>
            </div>

            <div id="passwords">
            	<div class="form-floating mb-3">
	                <input class="form-control" id="phone" name="phone" type="text" placeholder="name@example.com" />
	                <label for="phone"> Telefono</label>
	            </div>
	            <div class="form-floating mb-3">
                    <textarea class="form-control" name="addres" id="addres" cols="30" rows="10"></textarea>
	                <label for="addres">Direccion</label>
	            </div>
            </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" onclick="formClients(event);">Guardar</button>
        </form>
      </div>
    </div>
  </div>
</div>

<?php include "Views/Layouts/Footer.php"; ?>