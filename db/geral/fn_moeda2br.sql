CREATE OR REPLACE FUNCTION fn_moeda2br(valor FLOAT)
    RETURNS VARCHAR(15) AS 
$body$
DECLARE
----------- Parametros -------------
    pValor ALIAS FOR $1;
----------- variaveis --------------
    vValor VARCHAR;
BEGIN
    SELECT to_char(pValor, 'L9G999G990D99') INTO vValor;
    RETURN vValor;
END;
$body$
LANGUAGE plpgsql;