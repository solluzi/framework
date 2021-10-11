CREATE OR REPLACE VIEW "VW_MENU" AS
    SELECT 
        "SP"."NAME"  AS "PROGRAM", 
        "SG"."ID"    AS "GROUP", 
        "SU"."ID"    AS "LOGIN", 
        "SPS"."NAME" AS "SECTION" 
    FROM "SYSTEM_PROGRAM" "SP" 
    JOIN "SYSTEM_GROUP_PROGRAM" "SGP"     ON "SGP"."PROGRAM_ID"= "SP"."ID" 
    JOIN "SYSTEM_GROUP" "SG"              ON "SG"."ID"         = "SGP"."GROUP_ID"
    JOIN "SYSTEM_USER_GROUP" "SUG"        ON "SUG"."GROUP_ID"  = "SG"."ID" 
    JOIN "SYSTEM_USER" "SU"               ON "SU"."ID"         = "SUG"."USER_ID"
    JOIN "SYSTEM_PROGRAM_SECTION" "SPS"   ON "SPS"."ID"        = "SP"."SECTION" ;