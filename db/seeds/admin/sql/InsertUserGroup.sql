INSERT INTO system_user_group (user_id, group_id)
    SELECT 
        (SELECT id FROM system_user WHERE login = 'mauro.miranda' LIMIT 1),
        (SELECT id FROM system_group WHERE name = 'Webmaster' LIMIT 1)
    WHERE
        NOT EXISTS (SELECT 
                        * 
                    FROM system_user_group 
                    WHERE user_id = (SELECT id FROM system_user  WHERE login = 'mauro.miranda' LIMIT 1)
                    AND group_id  = (SELECT id FROM system_group WHERE name  = 'Webmaster' LIMIT 1)
                );