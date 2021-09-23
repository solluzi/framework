CREATE OR REPLACE FUNCTION "FN_DATE2BR" (  "p_data" timestamptz, "p_type" BOOLEAN)  
    RETURNS VARCHAR AS  
$body$  
DECLARE  
    l_ret   VARCHAR  ;  
BEGIN 
    IF p_type THEN
        l_ret := (to_char(p_data,'dd/MM/yyyy HH24:MI:SS'));  
        RETURN l_ret;  
    ELSE
        l_ret := (to_char(p_data,'dd/MM/yyyy'));  
        RETURN l_ret; 
    END IF;
END;  
$body$  
LANGUAGE 'plpgsql'  
    VOLATILE  
    CALLED ON NULL INPUT  
    SECURITY INVOKER  
    COST 100;  