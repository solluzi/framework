CREATE OR REPLACE FUNCTION "FN_LOGIN"(dados JSON)
RETURNS TEXT AS $$
DECLARE 
	VJ_LOGS 				JSON;
	VA_SYSTEM_PROGRAMS    	TEXT[];
	VA_SYSTEM_SECTIONS		TEXT[];
	VS_LOGGED 				VARCHAR;
	VS_QUERY_UPDATE			VARCHAR;
	VS_QUERY_INSERT			VARCHAR;
	VS_GENERATED_KEY  		VARCHAR;
	VS_GENERATED_SESSION 	VARCHAR;
	VS_USER_LOGIN 			VARCHAR;
BEGIN 
    -- FAZ O LOGIN DO USUÁRIO
	SELECT "LOGIN" INTO VS_LOGGED FROM "SYSTEM_USER" WHERE "LOGIN"=dados->>'usuario' AND "PASSWORD"=crypt(dados->>'senha', "PASSWORD") AND "ACTIVE";
	
	IF VS_LOGGED IS NULL THEN	
		VJ_LOGS := '{"logged": false, "error": 401}';
		RETURN VJ_LOGS;
 	ELSE


		VA_SYSTEM_PROGRAMS := ARRAY(SELECT 
			 DISTINCT "VM"."PROGRAM"
		FROM 
			 "VW_MENU" "VM" 
		JOIN  "SYSTEM_USER" 	  "SU"  ON "SU"."ID"       = "VM"."LOGIN" 
		JOIN  "SYSTEM_USER_GROUP" "SUG" ON "SUG"."USER_ID" = "SU"."ID"
		WHERE "SU"."LOGIN" = dados->>'usuario' 
		ORDER BY "VM"."PROGRAM" );

		VA_SYSTEM_SECTIONS := ARRAY(SELECT 
			DISTINCT "VM"."SECTION"
		FROM 
			  "VW_MENU" "VM" 
		JOIN  "SYSTEM_USER"       "SU"  ON "SU"."ID"       = "VM"."LOGIN" 
		JOIN  "SYSTEM_USER_GROUP" "SUG" ON "SUG"."USER_ID" = "SU"."ID"
		WHERE "SU"."LOGIN" = dados->>'usuario' 
		ORDER BY "VM"."SECTION" );

		SELECT 
			json_build_object(
				'logged', true, 
				'active', "ACTIVE", 
				'program', "PROGRAM_ID", 
				'token', dados->>'sessao', 
				'system_programs', VA_SYSTEM_PROGRAMS, 
				'system_sections', VA_SYSTEM_SECTIONS
			) INTO VJ_LOGS 
		FROM 
			"SYSTEM_USER" "SU"
		WHERE 
			"SU"."LOGIN" = dados->>'usuario' 
		AND 
			"SU"."ACTIVE" LIMIT 1;

		VS_GENERATED_KEY     = dados->>'chave';
		VS_GENERATED_SESSION = dados->>'sessao';
		VS_USER_LOGIN        = dados->>'usuario'; 

		VS_QUERY_UPDATE = 'UPDATE "SYSTEM_ACCESS_LOG" SET "LOGGED_OUT"=current_timestamp WHERE "LOGIN" = '''||VS_USER_LOGIN||''' AND "LOGGED_OUT" IS NULL';
		PERFORM dblink('system_db_log', VS_QUERY_UPDATE);		

		-- UPDATE SYSTEM_ACCESS_LOG
		VS_QUERY_INSERT = 'INSERT INTO "SYSTEM_ACCESS_LOG" (
											"KEY",
											"SESSION",
											"LOGIN",
											"LOGGED_IN"
										) VALUES (
											'''||VS_GENERATED_KEY||''',
											'''||VS_GENERATED_SESSION||''',
											'''||VS_USER_LOGIN||''',
											current_timestamp
										)';
		PERFORM dblink('system_db_log', VS_QUERY_INSERT);

		RETURN VJ_LOGS;
	END IF;

END;
$$ LANGUAGE plpgsql;
--SELECT fn_login('{ "usuario": "mauro.miranda", "senha": "12345678", "sessao":"1234546545", "chave": "rtrtyrtyrytrt"}');