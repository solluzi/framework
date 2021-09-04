CREATE OR REPLACE FUNCTION fn_login(dados JSON)
RETURNS text AS $$
DECLARE logged 				VARCHAR;
DECLARE logs 				JSON;
DECLARE system_programs     TEXT[];
DECLARE system_sections		TEXT[];
DECLARE systemQueryUpdate	VARCHAR;
DECLARE systemQueryInsert	VARCHAR;
DECLARE generatedKey  		VARCHAR;
DECLARE generatedSession 	VARCHAR;
DECLARE userLogin 			VARCHAR;
BEGIN 
    -- FAZ O LOGIN DO USUÁRIO
	SELECT login INTO logged FROM system_user WHERE login=dados->>'usuario' AND password=crypt(dados->>'senha', senha) AND active=true;
	
	IF logged IS NULL THEN	
		logs := '{"logged": false, "error": 401}';
		RETURN logs;
 	ELSE


		system_programs := ARRAY(SELECT 
			DISTINCT vm.program
		FROM 
			view_menu vm 
		INNER JOIN system_user su ON su.id = vm.login 
		INNER JOIN system_user_group sug ON sug.user_id = su.id
		WHERE su.login = dados->>'usuario' 
		ORDER BY vm.program );

		system_sections := ARRAY(SELECT 
			DISTINCT vm.section
		FROM 
			vw_menu vm 
		INNER JOIN system_user u ON u.id = vm.login 
		INNER JOIN system_user_group sug ON sug.user_id = su.id
		WHERE su.login = dados->>'usuario' 
		ORDER BY vm.section );

		SELECT 
			json_build_object('logged', true, 'active', active, 'program', program_id, 'token', dados->>'sessao', 'system_programs', system_programs, 'system_sections', system_sections) INTO logs 
		FROM 
			system_user su
		WHERE 
			su.login = dados->>'usuario' 
		AND 
			su.active=true LIMIT 1;

		generatedKey     = dados->>'chave';
		generatedSession = dados->>'sessao';
		userLogin        = dados->>'usuario';

		systemQueryUpdate = 'UPDATE system_access_log SET logged_out=current_timestamp WHERE login = '''||userLogin||''' AND logged_out IS NULL';
		PERFORM dblink('system_db_log', systemQueryUpdate);		

		
		systemQueryInsert = 'INSERT INTO system_access_log (key,session,login,logged_in) VALUES ('''||generatedKey||''','''||generatedSession||''','''||userLogin||''',current_timestamp)';
		PERFORM dblink('system_db_log', systemQueryInsert);

		RETURN logs;
	END IF;

END;
$$ LANGUAGE plpgsql;
--SELECT fn_login('{ "usuario": "mauro.miranda", "senha": "12345678", "sessao":"1234546545", "chave": "rtrtyrtyrytrt"}');