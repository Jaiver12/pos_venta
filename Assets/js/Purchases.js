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
}