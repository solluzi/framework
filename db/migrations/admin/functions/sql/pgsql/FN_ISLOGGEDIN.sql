CREATE OR REPLACE FUNCTION "FN_ISLOGGEDIN"(key VARCHAR)
 RETURNS text
 LANGUAGE plpgsql
AS $function$
DECLARE 
	VJ_DATA 		JSON;
	VS_KEY 			VARCHAR;
BEGIN 

    VS_KEY = key;
	SELECT 
        json_build_object(
	        'user', sug."USER_ID",
	        'group', sug."GROUP_ID" 
        ) INTO VJ_DATA
    FROM "SYSTEM_USER_GROUP" sug 
    JOIN "SYSTEM_USER" su ON su."ID" = sug."USER_ID" 
    JOIN dblink('system_db_log', 'SELECT "LOGIN" FROM "SYSTEM_ACCESS_LOG" WHERE "KEY"='''||VS_KEY||''' AND "LOGGED_OUT" IS NULL') AS remote(login varchar) ON su."LOGIN" = remote.login;

	RETURN VJ_DATA;
	
END;
$function$;

SELECT "FN_ISLOGGEDIN"('aaa1e71ae2620b9306ac500a86c3bcda');