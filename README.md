##  COMANDOS PARA RODAR ANTES DE UTILIZAR O SISTEMA
// comando para criar seed (vendor/bin/phinx seed:create -c public/phinx.php NomeDoSeedSeeder)
// comando para rodar Seed no terminal (vendor/bin/phinx seed:run -s MainSeeder -c public/phinx.php -e development)
// Comando para criar migraion (vendor/bin/phinx create -c db/database/principal.php NomeDaMigration)
// comando para executar migrations (vendor/bin/phinx migrate -c db/database/principal.php -e development)

## CONFIGURAÇÕES DO .env necessários para rodar o sistema

##################################################################
#################### DATABASE INFORMATION ########################
##################################################################

SYSTEM_DB_HOST=""
SYSTEM_DB_USER=""
SYSTEM_DB_PASS=""
SYSTEM_DB_PORT=""
SYSTEM_DB_NAME=""
SYSTEM_DB_TYPE=""
SYSTEM_DB_CHAR=""

##################################################################
#################### TOKEN INFORMATION ###########################
##################################################################

ISS=""
SUB="<descrição do token a ser gerado>"
AUD=""
EXPIRATION_SEC="<tempo em segundos>"
JWT_ENCDEC_KEY="<Chave de condificação e decodificação do token>"