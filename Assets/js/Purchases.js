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
			res.forEach(row => {
				html += `<tr>
					<td>${row['id']}</td>
					<td>${row['name']}</td>
					<td>${row['stock']}</td>
					<td>${row['price']}</td>
					<td>${row['sub_total']}</td>
					<td>
						<button class="btn btn-ms btn-danger">X</button>
					</td>
				</tr>`;
			});
			document.getElementById("tblDetails").innerHTML = html;
		}
	}
}