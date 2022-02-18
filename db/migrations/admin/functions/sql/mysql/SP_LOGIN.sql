CREATE PROCEDURE `SP_LOGIN`(dados JSON)
BEGIN
	DECLARE VS_LOGS 			JSON;
	DECLARE VA_PROGRAMAS,
			VA_SECTION,			
			VS_QUERY_UPDATE,
			VS_QUERY_INSERT,
			VS_CHAVE_GERADA,
			VS_SESSAO_GERADA,
			VS_LOGADO,
			VS_LOGIN_USUARIO 	TEXT;
		

    DECLARE EXIT HANDLER FOR sqlwarning
	BEGIN
		GET DIAGNOSTICS CONDITION 1 @sqlstate = RETURNED_SQLSTATE, 
		 @errno = MYSQL_ERRNO, @text = MESSAGE_TEXT;
		SET @full_error = CONCAT("ERROR ", @errno, " (", @sqlstate, "): ", @text);
		ROLLBACK;
		SELECT @full_error;		
	END;

	DECLARE exit handler for sqlexception
	BEGIN
		GET DIAGNOSTICS CONDITION 1 @sqlstate = RETURNED_SQLSTATE, @errno = MYSQL_ERRNO, @text = MESSAGE_TEXT;
		SET @full_error = CONCAT("ERROR ", @errno, " (", @sqlstate, "): ", @text);	
		
		ROLLBACK;
		SELECT @full_error;
	END;
		
    -- FAZ O LOGIN DO USUÁRIO
	SELECT login INTO logado FROM system_user WHERE login=json_value(dados, '$.usuario') AND password=encrypt(json_value(dados, '$.senha'), password) AND active;

	IF logado IS NULL THEN
		SELECT '{"logado": false, "error": 401}';
 	ELSE
 	
		SELECT 
			GROUP_CONCAT(DISTINCT json_array(vm.program)) INTO programas
		FROM 
			vw_system_menu vm 
		JOIN system_user u ON u.id = vm.login 
		JOIN system_user_group ug ON ug.`user` = u.id
		WHERE u.login = json_value(dados, '$.usuario')
		ORDER BY vm.program;
		SET @programas = REPLACE (programas, '],[',',');
		
	
		SELECT 
			GROUP_CONCAT(DISTINCT JSON_ARRAY(vm.section)) INTO secao
		FROM 
			vw_system_menu vm 
		JOIN system_user u ON u.id = vm.login 
		JOIN system_user_group ug ON ug.user = u.id
		WHERE u.login = json_value(dados, '$.usuario')
		ORDER BY vm.section ;
		SET @secao = REPLACE (secao, '],[',',');
		
	
		SELECT 
			JSON_OBJECT('logado', true, 'ativo', active, 'token',json_value(dados, '$.sessao'), 'programas', CONCAT("'",@programas,"'"), 'secao', CONCAT("'",@secao,"'")) INTO logs 
		FROM 
			system_user u 
		WHERE 
			login = json_value(dados, '$.usuario')
		AND 
			active LIMIT 1;
		
		SET chave_gerada  = json_value(dados, '$.chave');
		SET sessao_gerada = json_value(dados, '$.sessao');
		SET login_usuario = json_value(dados, '$.usuario');

		START TRANSACTION;
			UPDATE system_access_log SET logged_out=current_timestamp WHERE login = json_value(dados, '$.usuario') AND logged_out IS NULL;
		
			INSERT INTO system_access_log (`key`,session,login,logged_in,logged_out) VALUES (chave_gerada,sessao_gerada,login_usuario,current_timestamp,NULL);
		COMMIT;

		SELECT logs;
	END IF;

END