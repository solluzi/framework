INSERT INTO system_program_section (name) 
    SELECT 'Administração'
    WHERE
        NOT EXISTS (SELECT name FROM system_program_section WHERE name = 'Administração');

INSERT INTO system_program_section (name) 
    SELECT 'Logs'
    WHERE
        NOT EXISTS (SELECT name FROM system_program_section WHERE name = 'Logs');
