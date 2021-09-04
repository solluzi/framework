CREATE OR REPLACE VIEW view_menu AS
    SELECT 
        sp.name AS program, 
        sg.id AS group, 
        su.id AS login, 
        sps.name AS section 
    FROM system_program sp 
    INNER JOIN system_group_program sgp     ON gp.program_id= sp.id 
    INNER JOIN system_group sg              ON sg.id        = sgp.group_id 
    INNER JOIN system_user_group sug        ON sug.group_id = g.id 
    INNER JOIN system_user su               ON su.id        = sug.user_id
    INNER JOIN system_program_section sps   ON sps.id       = sp.section ;