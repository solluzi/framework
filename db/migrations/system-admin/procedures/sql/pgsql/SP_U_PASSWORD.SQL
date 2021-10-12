CREATE OR REPLACE PROCEDURE "SP_IU_USER"("p_data" JSON, "p_user" UUID)
LANGUAGE plpgsql
AS $$
DECLARE
    VS_NEW_PASSWORD     = VARCHAR(200);
    VU_USER             = UUID;
BEGIN
    -- SET VARIABLES
    VS_USER         = p_user;
    VS_NEW_PASSWORD = crypt(p_data->>'new_password', gen_salt('bf'));
    
    UPDATE "SYSTEM_USER" 
       SET "PASSWORD"=VS_NEW_PASSWORD 
     WHERE "PASSWORD"=crypt(dados->>'former_password', "PASSWORD") 
       AND "USER"=VU_USER 
       AND "ACTIVE";

    COMMIT;
END;$$