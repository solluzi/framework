CREATE OR REPLACE FUNCTION "FN_FORMAT_CPF_CNPJ"( AlphaText VARCHAR(50) )
   RETURNS VARCHAR(50) AS $$
DECLARE
  FormattedText VARCHAR(50) = '';
  NumChar       INTEGER;
  NumericChar   CHAR;
BEGIN
  AlphaText := regexp_replace(AlphaText, '[^0-9]', '', 'g');
  NumChar   := LENGTH( AlphaText );
  if (NumChar > 14) OR (NumChar < 11) THEN
    RETURN NULL;
  elsif NumChar = 11 THEN
    FormattedText := regexp_replace( AlphaText, '(\d{3})(\d{3})(\d{3})(\d{2})', '\1.\2.\3-\4');
  else
    FormattedText := regexp_replace( AlphaText, '(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})', '\1.\2.\3/\4-\5');
  end if;
    
  RETURN FormattedText;
END;
$$ LANGUAGE plpgsql;

-- Exemplo de uso
-- select p_cpfcnpj Original, FormatCPFCNPJ( p_cpfcnpj ) Formatado * from tabela;
-- Exemplo de update
-- update tabela set p_cpfcnpj = FormatCPFCNPJ( p_cpfcnpj )
