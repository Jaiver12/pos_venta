document.addEventListener("DOMContentLoaded", function() {
	$('#tblHistorialCompras').DataTable({
	    ajax: {
	        url: base_url + "Purchases/listar",
	        dataSrc: ''
	    },
	    columns: [
	    	{'data' : 'id'},
	    	{'data' : 'total'},
	    	{'data' : 'fecha'},
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

const searchCodigo = (e) => {
	e.preventDefault();

	if (e.which == 13) {
		const cod = document.getElementById("codigo").value;
		const url = base_url + "Purchases/searchCodigo/" + cod;
		const http = new XMLHttpRequest();
		http.open("GET", url, true);
		http.send();
		http.onreadystatechange = function () {
			if (this.readyState == 4 && this.status == 200) {
				const res = JSON.parse(this.responseText);
				if (res) {
					document.getElementById("id").value = res.id;
					document.getElementById("name").value = res.name;
					document.getElementById("price_comp").value = res.price_comp;
					document.getElementById("stock").focus();
				} else {
					alert("Producto no existe");
				}
			}
		}
	}
}

const subTotal = (e) => {
	e.preventDefault();
	const stock = document.getElementById("stock").value;
	const price_comp = document.getElementById("price_comp").value;
	document.getElementById("sub_total").value = price_comp * stock;

	if (e.which == 13) {
		const url = base_url + "Purchases/addPurchase";
		const frm = document.getElementById("frmPurchase");
		const http = new XMLHttpRequest();
		http.open("POST", url, true);
		http.send(new FormData(frm));
		http.onreadystatechange = function () {
			if (this.readyState == 4 && this.status == 200) {
				const res = JSON.parse(this.responseText);
				if(res == "ok") {
					frm.reset();
					addDetails();
				} else if(res == "modificado") {
					frm.reset();
					addDetails();
				}
			}
		}
	}
}
addDetails();

function addDetails() {
	const url = base_url + "Purchases/addDetails";
	const http = new XMLHttpRequest();
	http.open("GET", url, true);
	http.send();
	http.onreadystatechange = function () {
		if (this.readyState == 4 && this.status == 200) {
			const res = JSON.parse(this.responseText);
			let html = '';
			res['detail'].forEach(row => {
				html += `<tr>
					<td>${row.id_pro}</td>
					<td>${row.name}</td>
					<td>${row.stock}</td>
					<td>${row.price}</td>
					<td>${row.sub_total}</td>
					<td>
						<button class="btn btn-ms btn-danger" onclick="deleteDetail(${row.id})">
							<i class="fas fa-trash-alt"></i>
						</button>
					</td>
				</tr>`;
			});

			document.getElementById("tblDetails").innerHTML = html;
			document.getElementById("total").value = res['total'].total;
		}
	}
}

const deleteDetail = (id) => {
	const url = base_url + "Purchases/deleteDetails/" + id;
	const http = new XMLHttpRequest();
	http.open("GET", url, true);
	http.send();
	http.onreadystatechange = function () {
		if (this.readyState == 4 && this.status == 200) {
			const res = JSON.parse(this.responseText);
			if (res == "ok") {
				Swal.fire({
				  position: 'top-end',
				  icon: 'success',
				  title: 'Producto eliminado con exito',
				  showConfirmButton: false,
				  timer: 2000
				})
				addDetails();
			} else {
				Swal.fire({
				  position: 'top-end',
				  icon: 'error',
				  title: 'Error al eliminar el producto',
				  showConfirmButton: false,
				  timer: 2000
				})
			}
		}
	}
}

const GenerarCompra = () => {
Swal.fire({
	  title: 'Esta seguro de Generar la compra?',
	  text: "La compra sera guardada!",
	  icon: 'warning',
	  showCancelButton: true,
	  confirmButtonColor: '#3085d6',
	  cancelButtonColor: '#d33',
	  confirmButtonText: 'Si!',
	  cancelButtonText: 'No'
	}).then((result) => {
	  if (result.isConfirmed) {
		const url = base_url + "Purchases/register";
		const http = new XMLHttpRequest();
		http.open("GET", url, true);
		http.send();
		http.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				const res = JSON.parse(this.responseText);
				if (res.msg == "ok") {
					Swal.fire(
				      'Mensaje!',
				      'Compra realizada con exito.',
				      'success'
				    )
				    const ruta = base_url + "Purchases/generarPdf/" + res.id_compra;
				    window.open(ruta);
				    setTimeout(() => {
				    	window.location.reload();
					}, 300);
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