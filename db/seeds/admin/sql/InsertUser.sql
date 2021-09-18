INSERT INTO "SYSTEM_USER" ("NAME","LOGIN", "PASSWORD", "ACTIVE", "PROGRAM_ID")
    SELECT 
        'MAURO MIRANDA',
        'mauro.miranda',
        crypt('12345678', gen_salt('bf')),
        'true',
        (SELECT "ID" FROM "SYSTEM_PROGRAM" "SP" WHERE "SP"."NAME" = 'listar.usuario' LIMIT 1)
    WHERE
        NOT EXISTS (SELECT "LOGIN" FROM "SYSTEM_USER" "SU" WHERE "SU"."LOGIN" = 'mauro.miranda');