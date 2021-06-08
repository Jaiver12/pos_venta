let tblCaja;
var modalCajas = new bootstrap.Modal(document.getElementById('modalCajas'));

document.addEventListener("DOMContentLoaded", function() {
	tblCaja = $('#tblCajas').DataTable({
	    ajax: {
	        url: base_url + "Cajas/listar",
	        dataSrc: ''
	    },
	    columns: [
	    	{'data' : 'id'},
	    	{'data' : 'caja'},
	    	{'data' : 'estado'},
	    	{'data' : 'acciones'}
	    	]
	});
})

const modalCaja = () => {
	document.getElementById('tituloModalCaja').innerHTML = "Nueva Caja";
	document.getElementById("formCajas").reset();
	document.getElementById("id").value = "";
	modalCajas.show()
}

function formCaja(e) {
	e.preventDefault();
	const name = document.getElementById("name");

	if (name.value == "") {
		Swal.fire({
		  position: 'top-end',
		  icon: 'error',
		  title: 'Todos los campos son requeridos',
		  showConfirmButton: false,
		  timer: 2000
		})
	} else {
		const url = base_url + "Cajas/register";
		const form = document.getElementById("formCajas");
		const http = new XMLHttpRequest();
		http.open("POST", url, true);
		http.send(new FormData(form));
		http.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				const res = JSON.parse(this.responseText);
				if (res == "si") {
					Swal.fire({
					  position: 'top-end',
					  icon: 'success',
					  title: 'Caja registrada con exito',
					  showConfirmButton: false,
					  timer: 3000
					})
					form.reset();
					modalCajas.hide();
					tblCaja.ajax.reload();
				} else if (res == "modificado") {
					Swal.fire({
					  position: 'top-end',
					  icon: 'success',
					  title: 'Caja modificada con exito',
					  showConfirmButton: false,
					  timer: 3000
					})
					form.reset();
					modalCajas.hide();
					tblCaja.ajax.reload();
				} else {
					Swal.fire({
					  position: 'top-end',
					  icon: 'error',
					  title: res,
					  showConfirmButton: false,
					  timer: 2000
					})
				}
			}
		}
	}
}

const btnEditCaja = (id) => {
	document.getElementById('tituloModalCaja').innerHTML = "Actualizar Caja";

	const url = base_url + "Cajas/edit/" + id;
	const http = new XMLHttpRequest();
	http.open("GET", url, true);
	http.send();
	http.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			const res = JSON.parse(this.responseText);
			document.getElementById("id").value = res.id;
			document.getElementById("name").value = res.caja;
			modalCajas.show();
		}
	}
}

const btnDeleteCaja = (id) => {
Swal.fire({
	  title: 'Esta seguro de modificar?',
	  text: "La Caja no se elminara de forma permanente, solo cambiara el estado!",
	  icon: 'warning',
	  showCancelButton: true,
	  confirmButtonColor: '#3085d6',
	  cancelButtonColor: '#d33',
	  confirmButtonText: 'Si!',
	  cancelButtonText: 'No'
	}).then((result) => {
	  if (result.isConfirmed) {
		const url = base_url + "Cajas/delete/" + id;
		const http = new XMLHttpRequest();
		http.open("GET", url, true);
		http.send();
		http.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				const res = JSON.parse(this.responseText);
				if (res == "ok") {
					Swal.fire(
				      'Mensaje!',
				      'La Medida ya esta iniactiva.',
				      'success'
				    )
				    tblCaja.ajax.reload();
				} else {
					Swal.fire(
				      'Mensaje!',
				      res,
				      'error'
				    )

				}
			}
		}
	  }
	})
}
