CREATE OR REPLACE PROCEDURE "SP_IU_USER"("p_data" JSON, "p_user" UUID)
LANGUAGE plpgsql
AS $$
DECLARE 
    VS_NAME         = VARCHAR(100);
    VS_LOGIN        = VARCHAR(88);
    VS_PASSWORD     = VARCHAR(200)
    VB_ACTIVE       = BOOLEAN;
    VU_USER         = UUID;
    VU_PROGRAM      = UUID;
    VU_CREATED_BY   = UUID;
    VU_UPDATED_BY   = UUID;
    VJ_GROUPS       = JSON;
    VJ_PROGRAMS     = JSON;
    VJ_G            = JSON;
    VJ_P            = JSON;
BEGIN
    -- SET VARIABLES
    VU_USER         = p_user;
    VS_NAME         = p_data->>'name';
    VS_LOGIN        = p_data->>'login';
    VS_PASSWORD     = crypt(p_data->>'password', gen_salt('bf'));
    VB_ACTIVE       = p_data->>'active';
    VU_PROGRAM      = p_data->>'program';
    VU_CREATED_BY   = p_user;
    VU_UPDATED_BY   = p_user;
    VJ_GROUPS       = p_data->>'groups';
    VJ_PROGRAMS     = p_data->>'groups';

    -- INSERT OU UPDATE USER
    INSERT INTO "SYSTEM_USER" ("ID", "NAME", "LOGIN", "PASSWORD","ACTIVE","PROGRAM","CREATED_BY")
    VALUES(VU_USER, VS_NAME, VS_LOGIN, VS_PASSWORD, VB_ACTIVE, VU_PROGRAM, VU_CREATED_BY)
    ON CONFLICT ("ID")
    DO
        UPDATE SET "NAME"       = VS_NAME,
                   "LOGIN"      = VS_LOGIN,
                   "ACTIVE"     = VB_ACTIVE,
                   "PROGRAM"    = VU_PROGRAM,
                   "UPDATED_BY" = VU_UPDATED_BY;

    -- DELETE FROM SYSTEM_USER_GROUP OF GIVEN USER
    DELETE FROM "SYSTEM_USER_GROUP" WHERE "USER_ID" = VU_USER;

    -- LOOP THROUGH JSON USERS
    FOR VJ_G IN SELECT * FROM JSON_ARRAY_ELEMENTS(VJ_GROUPS)
    LOOP
        -- INSERT NEW USER TO GIVEN GROUP
        INSERT INTO "SYSTEM_USER_GROUP" ("USER_ID", "GROUP_ID") VALUES (VU_USER, VJ_G->>'group');
    END LOOP;

    -- DELETE FROM SYSTEM_USER_PROGRAM OF GIVEN USER
    --DELETE FROM "SYSTEM_USER_PROGRAM" WHERE "USER_ID" = VU_USER;

    -- LOOP THROUGH JSON USERS
    --FOR VJ_P IN SELECT * FROM JSON_ARRAY_ELEMENTS(VJ_PROGRAMS)
    --LOOP
    --    -- INSERT NEW USER TO GIVEN GROUP
    --    INSERT INTO "SYSTEM_USER_PROGRAM" ("USER_ID", "PROGRAM_ID") VALUES (VU_USER, VJ_P->>'program');
    --END LOOP;
    
END;$$
