CREATE USER MAPPING IF NOT EXISTS FOR %local_user%      
    SERVER system_db_log  
    OPTIONS (user '%remote_user%', password '%remote_pass%'); 

GRANT USAGE ON FOREIGN SERVER system_db_log TO %local_user%;