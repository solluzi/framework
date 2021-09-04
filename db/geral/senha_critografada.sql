CREATE OR REPLACE FUNCTION senha_criptograda (  "p_senha" varchar(12) )  
    RETURNS varchar AS  
$body$  
DECLARE  
    l_ret varchar  ;  
BEGIN  
    l_ret := (crypt(p_senha, gen_salt('bf'));  
    RETURN l_ret;  
END;  
$body$  
LANGUAGE 'plpgsql'  
    VOLATILE  
    CALLED ON NULL INPUT  
    SECURITY INVOKER  
    COST 100;  