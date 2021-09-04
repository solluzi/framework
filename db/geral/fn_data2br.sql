CREATE OR REPLACE FUNCTION fn_data2br (  "p_data" timestamptz )  
    RETURNS varchar AS  
$body$  
DECLARE  
    l_ret   varchar  ;  
BEGIN  
    l_ret := (to_char(p_data,'dd/MM/yyyy HH24:MI:SS'));  
    RETURN l_ret;  
END;  
$body$  
LANGUAGE 'plpgsql'  
    VOLATILE  
    CALLED ON NULL INPUT  
    SECURITY INVOKER  
    COST 100;  