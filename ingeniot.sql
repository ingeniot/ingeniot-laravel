CREATE DATABASE IF NOT EXISTS ingeniot;
    SET TIME_ZONE = '-03:00';
USE ingeniot;

CREATE TABLE tenants (
	id INT(11) NOT NULL UNIQUE AUTO_INCREMENT,
	name VARCHAR(25) NOT NULL UNIQUE,
	created_date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP(),
	updated_date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP(),
	active TINYINT DEFAULT 0,
	type VARCHAR (25) NOT NULL,
        country VARCHAR (25) NOT NULL,
        state VARCHAR (25) NOT NULL,
	city VARCHAR (25) NOT NULL,
	address VARCHAR (25) NOT NULL,
        phone VARCHAR (25) NOT NULL,
        email VARCHAR (25) NOT NULL,
	CONSTRAINT pk_tenants PRIMARY KEY(id)
)ENGINE=InnoDb;


CREATE TABLE customers (
	id INT(11) NOT NULL UNIQUE AUTO_INCREMENT,
        tenant_id INT (11) NOT NULL,
	name VARCHAR(25) NOT NULL UNIQUE,
	created_date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP(),
	updated_date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP(),
	active TINYINT DEFAULT 0,
	type VARCHAR (25) NOT NULL,
        country VARCHAR (25) NOT NULL,
        state VARCHAR (25) NOT NULL,
	city VARCHAR (25) NOT NULL,
	address VARCHAR (25) NOT NULL,
        phone VARCHAR (25) NOT NULL,
        email VARCHAR (25) NOT NULL,
	CONSTRAINT pk_customers PRIMARY KEY(id),
	CONSTRAINT fk_customers_tenants FOREIGN KEY(tenant_id) REFERENCES tenants(id)
)ENGINE=InnoDb;

CREATE TABLE users (
	id INT(11) NOT NULL UNIQUE AUTO_INCREMENT,
        customer_id INT(11),
	email VARCHAR(30) NOT NULL UNIQUE,
	password VARCHAR(255) NOT NULL,
	name VARCHAR(50) NOT NULL,
	surname VARCHAR(50),
	role VARCHAR(11) NOT NULL,
	created_date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP(),
	updated_date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP(),
	active TINYINT DEFAULT 0,
        desciption text,
        image varchar (255),
        token varchar(255),
	CONSTRAINT pk_users PRIMARY KEY(id),
	CONSTRAINT fk_users_customers FOREIGN KEY(customer_id) REFERENCES customers(id)
)ENGINE=InnoDb;

CREATE TABLE devices (
	id INT(11) NOT NULL UNIQUE AUTO_INCREMENT,
	customer_id INT (11) NOT NULL,
	name VARCHAR(25) NOT NULL UNIQUE,
        description VARCHAR (25),
	created_date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP(),
	updted_date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP(),        
	active TINYINT DEFAULT 0,
	type VARCHAR (25) NOT NULL,
        serial INT (11),
	token VARCHAR (64),
        label VARCHAR (25),
	CONSTRAINT pk_devices PRIMARY KEY(id),
	CONSTRAINT fk_devices_customers FOREIGN KEY(customer_id) REFERENCES customers(id)
)ENGINE=InnoDb;

CREATE TABLE domains (
	id INT(11) NOT NULL UNIQUE AUTO_INCREMENT,
        customer_id INT (11) NOT NULL,
	name VARCHAR(25) NOT NULL UNIQUE,
	created_date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP(),
	updated_date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP(),
	active TINYINT DEFAULT 0,
        type VARCHAR (25) NOT NULL,
        label VARCHAR (25),
        description VARCHAR (25),
	CONSTRAINT pk_domains PRIMARY KEY(id),
	CONSTRAINT fk_domains_customers FOREIGN KEY(customer_id) REFERENCES customers(id)
)ENGINE=InnoDb;


CREATE TABLE sys_settings (
	id INT(11) NOT NULL UNIQUE AUTO_INCREMENT,
        keyword VARCHAR(11),
	json VARCHAR(255),
	CONSTRAINT pk_sys_settings PRIMARY KEY(id)
);



CREATE TABLE `mqtt_user` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(100) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `salt` varchar(35) DEFAULT NULL,
  `is_superuser` tinyint(1) DEFAULT 0,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `mqtt_username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `mqtt_acl` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `allow` int(1) DEFAULT 1 COMMENT '0: deny, 1: allow',
  `ipaddr` varchar(60) DEFAULT NULL COMMENT 'IpAddress',
  `username` varchar(100) DEFAULT NULL COMMENT 'Username',
  `clientid` varchar(100) DEFAULT NULL COMMENT 'ClientId',
  `access` int(2) NOT NULL COMMENT '1: subscribe, 2: publish, 3: pubsub',
  `topic` varchar(100) NOT NULL DEFAULT '' COMMENT 'Topic Filter',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO 'mqtt_acl' ('id','allow', 'ipaddr', 'username', 'clientid', 'access', 'topic')
VALUES
	(1,1,NULL, '$all', NULL,2,'#'),
	(2,0,NULL,'$all', NULL,1,'$SYS/#'),
	(3,0,NULL,'$all', NULL,1,'eq #'),
	(5,1,'127.0.0.1',NULL, NULL,2,'$SYS/#'),
	(6,1,'127.0.0.1',NULL,NULL,2,'#'),
	(7,1,NULL,'dashboard',NULL,1,'$SYS/#');

INSERT INTO 'users' ('email')
VALUES
	("ingeniot@gmail.com"),
	("bachediaz@gmail.com");
