CREATE OR REPLACE VIEW view_program AS
    SELECT
        sps.id AS section_id,
        sps.name AS section,
        sp.id AS program_id,
        sp.description AS description
    FROM system_program_section sps
    INNER JOIN system_program sp ON sp.section = sps.id;
