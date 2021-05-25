CREATE DATABASE IF NOT EXISTS pos_venta;

use pos_venta;

CREATE TABLE users(
	id int auto_increment not null,
	user varchar(55) not null,
	name varchar(150) not null,
	password varchar(150) not null,
	id_rol int,
	id_caja int,
	status int,
	CONSTRAINT pk_user PRIMARY KEY(id)
)ENGINE=InnoDb;