INSERT INTO system_user (login, password, active, program_id)
    SELECT 
        'mauro.miranda',
        crypt('12345678', gen_salt('bf')),
        'true',
        (SELECT id FROM system_program sp WHERE sp.name = 'listar.usuario' LIMIT 1)
    WHERE
        NOT EXISTS (SELECT login FROM system_user su WHERE su.login = 'mauro.miranda');