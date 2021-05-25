let tblUser;
var modalUser = new bootstrap.Modal(document.getElementById('modalUser'));

document.addEventListener("DOMContentLoaded", function() {
	tblUser = $('#tblUsers').DataTable({
	    ajax: {
	        url: base_url + "Users/listar",
	        dataSrc: ''
	    },
	    columns: [
	    	{'data' : 'id'},
	    	{'data' : 'user'},
	    	{'data' : 'name'},
	    	{'data' : 'caja'},
	    	{'data' : 'status'},
	    	{'data' : 'acciones'}
	    	]
	});
})

function formLogin(e) {
	e.preventDefault();
	const user = document.getElementById("user");
	const password = document.getElementById("password");

	if (user.value == "") {
		password.classList.remove("is-invalid");
		user.classList.add("is-invalid");
		user.focus();
	} else if (password.value == "") {
		user.classList.remove("is-invalid");
		password.classList.add("is-invalid");
		password.focus();
	} else {
		const url = base_url + "Users/validate";
		const form = document.getElementById("formLogin");
		const http = new XMLHttpRequest();
		http.open("POST", url, true);
		http.send(new FormData(form));
		http.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				const res = JSON.parse(this.responseText);
				if (res == "ok") {
					window.location = base_url + "Users";
				} else {
					document.getElementById("alertSeccion").classList.remove("d-none");
					document.getElementById("alertSeccion").innerHTML = res;
				}
			}
		}
	}
}

const modalShow = () => {
	document.getElementById('tituloModal').innerHTML = "Nuevo usuario";
	document.getElementById("formUser").reset();
	document.getElementById("passwords").classList.remove("d-none");
	document.getElementById("id").value = "";
	modalUser.show();
}

function formUser(e) {
	e.preventDefault();
	const user = document.getElementById("user");
	const name = document.getElementById("name");
	const password = document.getElementById("password");
	const confirm = document.getElementById("confirm");
	const caja = document.getElementById("caja");

	if (user.value == "" || name.value == ""  || caja.value == "") {
		Swal.fire({
		  position: 'top-end',
		  icon: 'error',
		  title: 'Todos los campos son requeridos',
		  showConfirmButton: false,
		  timer: 2000
		})
	} else if (password.value != confirm.value ) {
		Swal.fire({
		  position: 'top-end',
		  icon: 'error',
		  title: 'Las contraseñas con son iguales',
		  showConfirmButton: false,
		  timer: 2000
		})
	} else {
		const url = base_url + "Users/register";
		const form = document.getElementById("formUser");
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
					  title: 'Usuario registrado con exito',
					  showConfirmButton: false,
					  timer: 3000
					})
					form.reset();
					modalUser.hide();
					tblUser.ajax.reload();
				} else if (res == 'modificado') {
					Swal.fire({
					  position: 'top-end',
					  icon: 'success',
					  title: 'Usuario modificado con exito',
					  showConfirmButton: false,
					  timer: 3000
					})
					form.reset();
					modalUser.hide();
					tblUser.ajax.reload();
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

function btnEditUser(id) {
	document.getElementById('tituloModal').innerHTML = "Actualizar usuario";

	const url = base_url + "Users/edit/" + id;
	const http = new XMLHttpRequest();
	http.open("GET", url, true);
	http.send();
	http.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			const res = JSON.parse(this.responseText);
			document.getElementById("id").value = res.id;
			document.getElementById("user").value = res.user;
			document.getElementById("name").value = res.name;
			document.getElementById("caja").value = res.caja;
			document.getElementById("passwords").classList.add("d-none");
			modalUser.show();
		}
	}
}