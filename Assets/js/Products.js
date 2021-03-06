let tblProduct;
var modalProducts = new bootstrap.Modal(document.getElementById('modalProducts'));

document.addEventListener("DOMContentLoaded", function() {
	tblProduct = $('#tblProducts').DataTable({
	    ajax: {
	        url: base_url + "Products/listar",
	        dataSrc: ''
	    },
	    columns: [
	    	{'data' : 'id'},
	    	{'data' : 'image'},
	    	{'data' : 'codigo'},
	    	{'data' : 'name'},
	    	{'data' : 'description'},
	    	{'data' : 'price_vent'},
	    	{'data' : 'stock'},
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

const modalProduct = () => {
	document.getElementById('tituloModalProduct').innerHTML = "Nuevo producto";
	document.getElementById("formProduct").reset();
	document.getElementById("id").value = "";
	document.getElementById("img").value = "";
	document.getElementById("img-preview").src = "";
	modalProducts.show()
}

function formProducts(e) {
	e.preventDefault();
	const codigo = document.getElementById("codigo");
	const name = document.getElementById("name");
	const description = document.getElementById("description");
	const price_comp = document.getElementById("price_comp");
	const price_vent = document.getElementById("price_vent");
	const id_medida = document.getElementById("id_medida");
	const id_category = document.getElementById("id_category");
	const img = document.getElementById("img");

	if (codigo.value == "" || name.value == "" || description.value == "" || price_comp.value == "" || price_vent.value == "") {
		Swal.fire({
		  position: 'top-end',
		  icon: 'error',
		  title: 'Todos los campos son requeridos',
		  showConfirmButton: false,
		  timer: 2000
		})
	} else {
		const url = base_url + "Products/register";
		const form = document.getElementById("formProduct");
		const http = new XMLHttpRequest();
		http.open("POST", url, true);
		http.send(new FormData(form));
		http.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				console.log(this.responseText);
				const res = JSON.parse(this.responseText);
				if (res == "si") {
					Swal.fire({
					  position: 'top-end',
					  icon: 'success',
					  title: 'Producto registrado con exito',
					  showConfirmButton: false,
					  timer: 3000
					})
					form.reset();
					modalProducts.hide();
					tblProduct.ajax.reload();
				} else if (res == "modificado") {
					Swal.fire({
					  position: 'top-end',
					  icon: 'success',
					  title: 'Producto modificado con exito',
					  showConfirmButton: false,
					  timer: 3000
					})
					form.reset();
					modalProducts.hide();
					tblProduct.ajax.reload();
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

const btnEditProduct = (id) => {
	document.getElementById('tituloModalProduct').innerHTML = "Actualizar Producto";

	const url = base_url + "Products/edit/" + id;
	const http = new XMLHttpRequest();
	http.open("GET", url, true);
	http.send();
	http.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			const res = JSON.parse(this.responseText);
			document.getElementById("id").value = res.id;
			document.getElementById("codigo").value = res.codigo;
			document.getElementById("name").value = res.name;
			document.getElementById("description").value = res.description;
			document.getElementById("price_comp").value = res.price_comp;
			document.getElementById("price_vent").value = res.price_vent;
			document.getElementById("id_medida").value = res.id_medida;
			document.getElementById("id_category").value = res.id_category;
			document.getElementById("img-preview").src = base_url + 'Assets/image/' + res.img;
			modalProducts.show();
		}
	}
}

const btnDeleteProduct = (id) => {
	Swal.fire({
	  title: 'Esta seguro de modificar?',
	  text: "El producto no se elminara de forma permanente, solo cambiara el estado!",
	  icon: 'warning',
	  showCancelButton: true,
	  confirmButtonColor: '#3085d6',
	  cancelButtonColor: '#d33',
	  confirmButtonText: 'Si!',
	  cancelButtonText: 'No'
	}).then((result) => {
	  if (result.isConfirmed) {
		const url = base_url + "Products/delete/" + id;
		const http = new XMLHttpRequest();
		http.open("GET", url, true);
		http.send();
		http.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				const res = JSON.parse(this.responseText);
				if (res == "ok") {
					Swal.fire(
				      'Mensaje!',
				      'La Producto ya esta iniactivo.',
				      'success'
				    )
				    tblProduct.ajax.reload();
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

const preview = (e) => {
	const url = e.target.files[0];
	const urlTmp = URL.createObjectURL(url);
	document.getElementById("img-preview").src = urlTmp;
}
