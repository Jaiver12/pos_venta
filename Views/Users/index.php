<?php include "Views/Layouts/Header.php"; ?>

	<h1 class="mt-4">Usuarios</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Inicio</li>
    </ol>

    <button type="button" class="btn btn-success mb-4" onclick="modalShow();">
	  <i class="fas fa-plus"></i> Nuevo
	</button>


    <table class="table table-light" id="tblUsers">
    	<thead class="table-dark">
    		<tr>
    			<th>#</th>
    			<th>Usuario</th>
    			<th>Nombre</th>
    			<th>Caja</th>
    			<th>Status</th>
    			<th></th>
    		</tr>
    		<tbody>
    		</tbody>
    	</thead>
    </table>

 <div class="modal fade" id="modalUser" tabindex="-1" aria-labelledby="tituloModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="tituloModal">Nuevo Usuario</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method="POST" id="formUser">
        	<input type="hidden" id="id" name="id">

        	<div class="form-floating mb-3">
                <input class="form-control" id="user" name="user" type="text" placeholder="name@example.com" />
                <label for="user"> Usuario</label>
            </div>
            <div class="form-floating mb-3">
                <input class="form-control" id="name" name="name" type="text" placeholder="name@example.com" />
                <label for="name"> Nombre</label>
            </div>

            <div id="passwords">
            	<div class="form-floating mb-3">
	                <input class="form-control" id="password" name="password" type="password" placeholder="name@example.com" />
	                <label for="password"> Contraseña</label>
	            </div>
	            <div class="form-floating mb-3">
	                <input class="form-control" id="confirm" name="confirm" type="password" placeholder="name@example.com" />
	                <label for="confirm">Confirmar Contraseña</label>
	            </div>
            </div>

            <div class="form-floating mb-3">
				  <select class="form-select" id="caja" name="caja" aria-label="Floating label select example">
				  	<?php foreach ($data['cajas'] as $caja) { ?>
					    <option value="<?=$caja['id']?>"><?=$caja['caja']?></option>
				    <?php } ?>
				  </select>
				  <label for="caja">Caja</label>
			</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" onclick="formUser(event);">Guardar</button>
        </form>
      </div>
    </div>
  </div>
</div>

<?php include "Views/Layouts/Footer.php"; ?>