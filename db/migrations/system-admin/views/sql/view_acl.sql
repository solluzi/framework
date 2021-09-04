CREATE OR REPLACE VIEW view_access_permission AS
    SELECT
        sp.name as name,
        sug.user_id as user,
        sg.id as group
    FROM system_program sp
    INNER JOIN system_group_program sgp ON sgp.program_id   = sp.id
    INNER JOIN system_user_group sug    ON sug.group_id     = sgp.group_id
    INNER JOIN system_group sg          ON sg.id            = sug.group_id;
