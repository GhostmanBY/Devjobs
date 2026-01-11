create schema devjobs

use devjobs


create table users_jobs (
	id int primary key auto_increment,
	name varchar(120) not null,
	email varchar(150) not null unique,
	hash_password varchar(255) not null,
	cvPersonal varchar(120)
);

create table user_company (
	id int primary key auto_increment,
	name varchar(120) not null,
	email varchar(150) not null unique,
	hash_password varchar(255) not null,
	cuilt varchar(20) not null,
	rubro varchar(120) not null,
	sitoWEB varchar(120),
	telefono varchar(25) not null,
	direccion varchar(120) not null
);
	
create table flags (
	id int primary key auto_increment,
	name varchar(120)
);

create table flags_uj (
	id int primary key auto_increment,
	id_user int not null,
	id_flag int not null,
	foreign key (id_user) references users_jobs(id),
	foreign key (id_flag) references flags(id)
);

create table flags_uc (
	id int primary key auto_increment,
	id_company int not null,
	id_flag int not null,
	foreign key (id_company) references user_company(id),
	foreign key (id_flag) references flags(id)
);

create table locations(
	id int primary key auto_increment,
	name_city varchar(120) not null
);

create table modalidad(
	id int primary key auto_increment,
	name_metod varchar(120) not null
);

create table jobs (
	id int primary key auto_increment,
	title varchar(120) not null,
	company_name varchar(120) not null,
	descripcion text not null,
	id_modalidad int not null,
	id_location int not null,
	foreign key (id_location) references locations(id),
	foreign key (id_modalidad) references modalidad(id)
);


INSERT INTO users_jobs (name, email, hash_password, cvPersonal) VALUES
('Juan Pérez', 'juan.perez@mail.com', '$2y$10$testhashjuan', 'juan_perez_cv.pdf'),
('María Gómez', 'maria.gomez@mail.com', '$2y$10$testhashmaria', 'maria_gomez_cv.pdf'),
('Lucas Fernández', 'lucas.fernandez@mail.com', '$2y$10$testhashlucas', 'lucas_fernandez_cv.pdf');

INSERT INTO user_company (name, email, hash_password, cuilt, rubro, sitoWEB, telefono, direccion) VALUES
('TechSoft SA', 'rrhh@techsoft.com', '$2y$10$hashtechsoft', '30-71234567-8', 'Software', 'https://techsoft.com', '011-4555-1234', 'Av. Corrientes 1234'),
('FinanPro SRL', 'contacto@finanpro.com', '$2y$10$hashfinanpro', '30-70987654-3', 'Finanzas', 'https://finanpro.com', '011-4666-5678', 'Av. Libertador 2500');

INSERT INTO flags (name) VALUES
('JavaScript'),
('PHP'),
('MySQL'),
('Laravel'),
('React'),
('Node.js'),
('Docker'),
('Python');

INSERT INTO flags_uj (id_user, id_flag) VALUES
(1, 1), -- Juan - JavaScript
(1, 2), -- Juan - PHP
(1, 3), -- Juan - MySQL
(2, 4), -- María - Laravel
(2, 3), -- María - MySQL
(3, 8), -- Lucas - Python
(3, 7); -- Lucas - Docker

INSERT INTO locations (name) VALUES
('Buenos Aires'),
('Córdoba'),
('Rosario')


INSERT INTO modalidad (name) VALUES
('Presencial'),
('Remoto'),
('Híbrido');

INSERT INTO jobs (title, company_name, descripcion, id_modalidad, id_location) VALUES
(
  'Desarrollador Backend PHP',
  'TechSoft SA',
  'Buscamos desarrollador backend con experiencia en PHP, MySQL y APIs REST.',
  2, -- Remoto
  3  -- Remoto
),
(
  'Frontend Developer React',
  'TechSoft SA',
  'Desarrollo de interfaces modernas usando React y consumo de APIs.',
  3, -- Híbrido
  1  -- Buenos Aires
),
(
  'Analista de Datos',
  'FinanPro SRL',
  'Análisis de grandes volúmenes de datos y generación de reportes.',
  1, -- Presencial
  1  -- Buenos Aires
),
(
  'Full Stack Developer',
  'FinanPro SRL',
  'Desarrollo full stack con PHP, Laravel y MySQL.',
  2, -- Remoto
  3  -- Remoto
);

