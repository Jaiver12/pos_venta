let tblClient;
var modalClients = new bootstrap.Modal(document.getElementById('modalClients'));

document.addEventListener("DOMContentLoaded", function() {
	tblClient = $('#tblClients').DataTable({
	    ajax: {
	        url: base_url + "Clients/listar",
	        dataSrc: ''
	    },
	    columns: [
	    	{'data' : 'id'},
	    	{'data' : 'dni'},
	    	{'data' : 'name'},
	    	{'data' : 'phone'},
	    	{'data' : 'addres'},
	    	{'data' : 'status'},
	    	{'data' : 'acciones'}
	    	]
	});
})

const modalClient = () => {
	document.getElementById('tituloModalClient').innerHTML = "Nuevo clientes";
	document.getElementById("formClient").reset();
	document.getElementById("id").value = "";
	modalClients.show()
}

function formClients(e) {
	e.preventDefault();
	const dni = document.getElementById("dni");
	const name = document.getElementById("name");
	const phone = document.getElementById("phone");
	const addres = document.getElementById("addres");

	if (dni.value == "" || name.value == ""  || phone.value == "" || addres.value == "") {
		Swal.fire({
		  position: 'top-end',
		  icon: 'error',
		  title: 'Todos los campos son requeridos',
		  showConfirmButton: false,
		  timer: 2000
		})
	} else {
		const url = base_url + "Clients/register";
		const form = document.getElementById("formClient");
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
					  title: 'Cliente registrado con exito',
					  showConfirmButton: false,
					  timer: 3000
					})
					form.reset();
					modalClients.hide();
					tblClient.ajax.reload();
				} else if (res == "modificado") {
					Swal.fire({
					  position: 'top-end',
					  icon: 'success',
					  title: 'Cliente modificado con exito',
					  showConfirmButton: false,
					  timer: 3000
					})
					form.reset();
					modalClients.hide();
					tblClient.ajax.reload();
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

const btnEditClient = (id) => {
	document.getElementById('tituloModalClient').innerHTML = "Actualizar cliente";

	const url = base_url + "Clients/edit/" + id;
	const http = new XMLHttpRequest();
	http.open("GET", url, true);
	http.send();
	http.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			const res = JSON.parse(this.responseText);
			document.getElementById("id").value = res.id;
			document.getElementById("dni").value = res.dni;
			document.getElementById("name").value = res.name;
			document.getElementById("phone").value = res.phone;
			document.getElementById("addres").value = res.addres;
			modalClients.show();
		}
	}
}

const btnDeleteClient = (id) => {
Swal.fire({
	  title: 'Esta seguro de modificar?',
	  text: "El cliente no se elminara de forma permanente, solo cambiara el estado!",
	  icon: 'warning',
	  showCancelButton: true,
	  confirmButtonColor: '#3085d6',
	  cancelButtonColor: '#d33',
	  confirmButtonText: 'Si!',
	  cancelButtonText: 'No'
	}).then((result) => {
	  if (result.isConfirmed) {
		const url = base_url + "Clients/delete/" + id;
		const http = new XMLHttpRequest();
		http.open("GET", url, true);
		http.send();
		http.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				const res = JSON.parse(this.responseText);
				if (res == "ok") {
					Swal.fire(
				      'Mensaje!',
				      'El Cliente ya esta iniactivo.',
				      'success'
				    )
				    tblClient.ajax.reload();
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
