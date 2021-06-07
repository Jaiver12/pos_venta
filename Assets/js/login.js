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