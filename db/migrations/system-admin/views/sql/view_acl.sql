CREATE OR REPLACE VIEW "VW_ACCESS_PERMISSION" AS
    SELECT
        "SP"."NAME"     AS "NAME",
        "SUG"."USER_ID" AS "USER",
        "SG"."ID"       AS "GROUP"
    FROM "SYSTEM_PROGRAM" "SP"
    JOIN "SYSTEM_GROUP_PROGRAM" "SGP" ON "SGP"."PROGRAM_ID"   = "SP"."ID"
    JOIN "SYSTEM_USER_GROUP" "SUG"    ON "SUG"."GROUP_ID"     = "SGP"."GROUP_ID"
    JOIN "SYSTEM_GROUP" "SG"          ON "SG"."ID"            = "SUG"."GROUP_ID";
