let tblMedida;
var modalMedidas = new bootstrap.Modal(document.getElementById('modalMedidas'));

document.addEventListener("DOMContentLoaded", function() {
	tblMedida = $('#tblMedidas').DataTable({
	    ajax: {
	        url: base_url + "Medidas/listar",
	        dataSrc: ''
	    },
	    columns: [
	    	{'data' : 'id'},
	    	{'data' : 'name'},
	    	{'data' : 'namecorto'},
	    	{'data' : 'status'},
	    	{'data' : 'acciones'}
	    	],
	    	language: {
                "url": "//cdn.datatables.net/plug-ins/1.10.11/i18n/Spanish.json"
            },
            dom: "<'row'<'col-sm-4'l><'col-sm-4 text-center'B><'col-sm-4'f>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-5'i><'col-sm-7'p>>",
                buttons: [{
                //Botón para Excel
                extend: 'excelHtml5',
                footer: true,
                title: 'Archivo',
                filename: 'Export_File',

                //Aquí es donde generas el botón personalizado
                text: '<span class="badge badge-success"><i class="fas fa-file-excel"></i></span>'
            },
            //Botón para PDF
            {
                extend: 'pdfHtml5',
                download: 'open',
                footer: true,
                title: 'Reporte de usuarios',
                filename: 'Reporte de usuarios',
                text: '<span class="badge  badge-danger"><i class="fas fa-file-pdf"></i></span>',
                exportOptions: {
                    columns: [0, ':visible']
                }
            },
            //Botón para copiar
            {
                extend: 'copyHtml5',
                footer: true,
                title: 'Reporte de usuarios',
                filename: 'Reporte de usuarios',
                text: '<span class="badge  badge-primary"><i class="fas fa-copy"></i></span>',
                exportOptions: {
                    columns: [0, ':visible']
                }
            },
            //Botón para print
            {
                extend: 'print',
                footer: true,
                filename: 'Export_File_print',
                text: '<span class="badge badge-light"><i class="fas fa-print"></i></span>'
            },
            //Botón para cvs
            {
                extend: 'csvHtml5',
                footer: true,
                filename: 'Export_File_csv',
                text: '<span class="badge  badge-success"><i class="fas fa-file-csv"></i></span>'
            },
            {
                extend: 'colvis',
                text: '<span class="badge  badge-info"><i class="fas fa-columns"></i></span>',
                postfixButtons: ['colvisRestore']
            }
        ]
	});
})

const modalMedida = () => {
	document.getElementById('tituloModalMedida').innerHTML = "Nueva Medida";
	document.getElementById("formMedida").reset();
	document.getElementById("id").value = "";
	modalMedidas.show()
}

function formMedida(e) {
	e.preventDefault();
	const name = document.getElementById("name");
	const namecorto = document.getElementById("namecorto");

	if (name.value == "" || namecorto.value == "") {
		Swal.fire({
		  position: 'top-end',
		  icon: 'error',
		  title: 'Todos los campos son requeridos',
		  showConfirmButton: false,
		  timer: 2000
		})
	} else {
		const url = base_url + "Medidas/register";
		const form = document.getElementById("formMedida");
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
					  title: 'Medida registrada con exito',
					  showConfirmButton: false,
					  timer: 3000
					})
					form.reset();
					modalMedidas.hide();
					tblMedida.ajax.reload();
				} else if (res == "modificado") {
					Swal.fire({
					  position: 'top-end',
					  icon: 'success',
					  title: 'Medida modificada con exito',
					  showConfirmButton: false,
					  timer: 3000
					})
					form.reset();
					modalMedidas.hide();
					tblMedida.ajax.reload();
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

const btnEditMedida = (id) => {
	document.getElementById('tituloModalMedida').innerHTML = "Actualizar Medida";

	const url = base_url + "Medidas/edit/" + id;
	const http = new XMLHttpRequest();
	http.open("GET", url, true);
	http.send();
	http.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			const res = JSON.parse(this.responseText);
			document.getElementById("id").value = res.id;
			document.getElementById("name").value = res.name;
			document.getElementById("namecorto").value = res.namecorto;
			modalMedidas.show();
		}
	}
}

const btnDeleteMedida = (id) => {
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
		const url = base_url + "Medidas/delete/" + id;
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
				    tblMedida.ajax.reload();
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
