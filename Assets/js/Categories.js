let tblCategory;
var modalCategories = new bootstrap.Modal(document.getElementById('modalCategories'));

document.addEventListener("DOMContentLoaded", function() {
	tblCategory = $('#tblCategories').DataTable({
	    ajax: {
	        url: base_url + "Categories/listar",
	        dataSrc: ''
	    },
	    columns: [
	    	{'data' : 'id'},
	    	{'data' : 'name'},
	    	{'data' : 'status'},
	    	{'data' : 'acciones'}
	    	]
	});
})

const modalCategory = () => {
	document.getElementById('tituloModalCategory').innerHTML = "Nueva Cateoria";
	document.getElementById("formCategory").reset();
	document.getElementById("id").value = "";
	modalCategories.show()
}

function formCategories(e) {
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
		const url = base_url + "Categories/register";
		const form = document.getElementById("formCategory");
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
					  title: 'Categoria registrado con exito',
					  showConfirmButton: false,
					  timer: 3000
					})
					form.reset();
					modalCategories.hide();
					tblCategory.ajax.reload();
				} else if (res == "modificado") {
					Swal.fire({
					  position: 'top-end',
					  icon: 'success',
					  title: 'Categoria modificado con exito',
					  showConfirmButton: false,
					  timer: 3000
					})
					form.reset();
					modalCategories.hide();
					tblCategory.ajax.reload();
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

const btnEditCategory = (id) => {
	document.getElementById('tituloModalCategory').innerHTML = "Actualizar Cateoria";

	const url = base_url + "Categories/edit/" + id;
	const http = new XMLHttpRequest();
	http.open("GET", url, true);
	http.send();
	http.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			const res = JSON.parse(this.responseText);
			document.getElementById("id").value = res.id;
			document.getElementById("name").value = res.name;
			modalCategories.show();
		}
	}
}

const btnDeleteCategory = (id) => {
Swal.fire({
	  title: 'Esta seguro de modificar?',
	  text: "La categoria no se elminara de forma permanente, solo cambiara el estado!",
	  icon: 'warning',
	  showCancelButton: true,
	  confirmButtonColor: '#3085d6',
	  cancelButtonColor: '#d33',
	  confirmButtonText: 'Si!',
	  cancelButtonText: 'No'
	}).then((result) => {
	  if (result.isConfirmed) {
		const url = base_url + "Categories/delete/" + id;
		const http = new XMLHttpRequest();
		http.open("GET", url, true);
		http.send();
		http.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				const res = JSON.parse(this.responseText);
				if (res == "ok") {
					Swal.fire(
				      'Mensaje!',
				      'La Categoria ya esta iniactivo.',
				      'success'
				    )
				    tblCategory.ajax.reload();
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
