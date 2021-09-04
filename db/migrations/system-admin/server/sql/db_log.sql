CREATE SERVER IF NOT EXISTS
    system_db_log
FOREIGN DATA WRAPPER postgres_fdw
OPTIONS (host '%host%', dbname '%db_name%', port '%port%');