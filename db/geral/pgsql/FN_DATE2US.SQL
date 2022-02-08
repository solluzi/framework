CREATE OR REPLACE FUNCTION "FN_DATE2US" (  "p_data" timestamptz, "p_type" boolean)  
    RETURNS varchar AS  
$body$  
DECLARE  
    l_ret   varchar  ;  
BEGIN 
    IF p_type THEN
        l_ret := (to_char(p_data,'yyyy-MM-dd HH24:MI:SS'));  
        RETURN l_ret;  
    ELSE
        l_ret := (to_char(p_data,'yyyy-MM-dd'));  
        RETURN l_ret; 
    END IF;
END;  
$body$  
LANGUAGE 'plpgsql'  
    VOLATILE  
    CALLED ON NULL INPUT  
    SECURITY INVOKER  
    COST 100;  