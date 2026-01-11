CREATE PROCEDURE sp_update_users_jobs(
    IN p_id INT,
    IN p_name VARCHAR(120),
    IN p_email VARCHAR(150),
    IN p_hash_password VARCHAR(255),
    IN p_cvPersonal VARCHAR(120)
)
BEGIN
    UPDATE users_jobs
    SET name = p_name,
        email = p_email,
        hash_password = p_hash_password,
        cvPersonal = p_cvPersonal
    WHERE id = p_id;
end;

CREATE PROCEDURE sp_update_user_company(
    IN p_id INT,
    IN p_name VARCHAR(120),
    IN p_email VARCHAR(150),
    IN p_hash_password VARCHAR(255),
    IN p_cuilt VARCHAR(20),
    IN p_rubro VARCHAR(120),
    IN p_sitoWEB VARCHAR(120),
    IN p_telefono VARCHAR(25),
    IN p_direccion VARCHAR(120)
)
BEGIN
    UPDATE user_company
    SET name = p_name,
        email = p_email,
        hash_password = p_hash_password,
        cuilt = p_cuilt,
        rubro = p_rubro,
        sitoWEB = p_sitoWEB,
        telefono = p_telefono,
        direccion = p_direccion
    WHERE id = p_id;
end;


CREATE PROCEDURE sp_update_flags(
    IN p_id INT,
    IN p_name VARCHAR(120)
)
BEGIN
    UPDATE flags
    SET name = p_name
    WHERE id = p_id;
end;

CREATE PROCEDURE sp_update_flags_uj(
    IN p_id INT,
    IN p_id_user INT,
    IN p_id_flag INT
)
BEGIN
    UPDATE flags_uj
    SET id_user = p_id_user,
        id_flag = p_id_flag
    WHERE id = p_id;
end;

CREATE PROCEDURE sp_update_flags_uc(
    IN p_id INT,
    IN p_id_company INT,
    IN p_id_flag INT
)
BEGIN
    UPDATE flags_uc
    SET id_company = p_id_company,
        id_flag = p_id_flag
    WHERE id = p_id;
end;

CREATE PROCEDURE sp_update_locations(
    IN p_id INT,
    IN p_name_city VARCHAR(120)
)
BEGIN
    UPDATE locations
    SET name_city = p_name_city
    WHERE id = p_id;
end;

CREATE PROCEDURE sp_update_modalidad(
    IN p_id INT,
    IN p_name_metod VARCHAR(120)
)
BEGIN
    UPDATE modalidad
    SET name_metod = p_name_metod
    WHERE id = p_id;
end;

CREATE PROCEDURE sp_update_jobs(
    IN p_id INT,
    IN p_title VARCHAR(120),
    IN p_company_name VARCHAR(120),
    IN p_descripcion TEXT,
    IN p_id_modalidad INT,
    IN p_id_location INT
)
BEGIN
    UPDATE jobs
    SET title = p_title,
        company_name = p_company_name,
        descripcion = p_descripcion,
        id_modalidad = p_id_modalidad,
        id_location = p_id_location
    WHERE id = p_id;
end;

create procedure sp_validate_email(
	in e_email varchar(150)
)
begin
	select id, hash_password,  'worker' AS role
	from users_jobs
	where email = e_email
	
	union all
	
	select hash_password, id , 'company' AS role
	from user_company
	where email = e_email
	
	limit 1;
end;
drop procedure sp_serch_id_worker;

create procedure sp_serch_id_worker(
	in e_id int
)
begin 
	select name, email
	from users_jobs
	where id = e_id
	limit 1;
end;
