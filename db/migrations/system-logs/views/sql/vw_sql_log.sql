CREATE OR REPLACE VIEW vw_sql_log AS
    SELECT 
        auditoria.comando,
        auditoria.created_at,
        u.login
    FROM usuario u 
    INNER JOIN 
    dblink(
    	'db_log', 
    	'SELECT usuario, comando, created_at FROM auditoria') 
    AS auditoria (
    	usuario uuid, 
    	comando json, 
    	created_at date
    ) ON auditoria.usuario = u.id;
