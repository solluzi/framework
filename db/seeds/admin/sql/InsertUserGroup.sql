INSERT INTO "SYSTEM_USER_GROUP" ("USER_ID", "GROUP_ID")
    SELECT 
        (SELECT "ID" FROM "SYSTEM_USER" WHERE "LOGIN" = 'mauro.miranda' LIMIT 1),
        (SELECT "ID" FROM "SYSTEM_GROUP" WHERE "NAME" = 'Webmaster' LIMIT 1)
    WHERE
        NOT EXISTS (SELECT 
                        * 
                    FROM  "SYSTEM_USER_GROUP"
                    WHERE "USER_ID"   = (SELECT "ID" FROM "SYSTEM_USER"  WHERE "LOGIN" = 'mauro.miranda' LIMIT 1)
                    AND   "GROUP_ID"  = (SELECT "ID" FROM "SYSTEM_GROUP" WHERE "NAME"  = 'Webmaster'     LIMIT 1)
                );