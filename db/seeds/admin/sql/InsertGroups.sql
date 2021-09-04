INSERT INTO system_group (name, created_by)
    SELECT 
        'Webmaster', (SELECT id FROM system_user WHERE login = 'mauro.miranda' LIMIT 1)
    WHERE
        NOT EXISTS (SELECT name FROM system_group WHERE name = 'Webmaster');