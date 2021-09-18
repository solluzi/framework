CREATE OR REPLACE FUNCTION FN_ENCRYPT_PASSWORD (  "p_senha" VARCHAR(12) )  
    RETURNS VARCHAR AS  
$body$  
DECLARE  
    l_ret VARCHAR  ;  
BEGIN  
    l_ret := (CRYPT(p_senha, gen_salt('bf'));  
    RETURN l_ret;  
END;  
$body$  
LANGUAGE 'plpgsql'  
    VOLATILE  
    CALLED ON NULL INPUT  
    SECURITY INVOKER  
    COST 100;  