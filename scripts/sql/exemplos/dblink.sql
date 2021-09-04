select * from dblink('dbname=log_acesso port=5432 host=172.20.0.12 user=user_v1api_db_log_dev password=kg$7equfa0LP&!ydse75ubNwUi@4gtkepRXJS@B$tTV8uPErFy', 'SELECT id, login FROM log_acesso' )  as cust ( id float, login varchar(50) );


-- Cria servidores para cross database
CREATE SERVER 
    db_log
FOREIGN DATA WRAPPER dblink_log
OPTIONS (host '172.20.0.12', dbname 'log_acesso', port '5432');


CREATE USER MAPPING FOR loguser      
        SERVER db_log  
        OPTIONS (user 'user_v1api_db_log_dev', password 'kg$7equfa0LP&!ydse75ubNwUi@4gtkepRXJS@B$tTV8uPErFy'); 