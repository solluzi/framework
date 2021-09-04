/* status */
INSERT INTO system_program (section,program,name,private,description,created_by)
    SELECT 
        (SELECT id FROM system_program_section where name = 'Administração' limit 1), 
        'Administracao\Controllers\Geral\Status::class',
        'status',
        'false',
        'Status do sistema',
        (SELECT id FROM system_user where login = 'mauro.miranda' limit 1)
    WHERE
        NOT EXISTS (SELECT name FROM system_program WHERE name = 'status');
/* login */
INSERT INTO system_program (section,program,name,private,description,created_by)
    SELECT 
        (SELECT id FROM system_program_section where name = 'Administração' limit 1), 
        'Administracao\Controllers\Geral\Login::class',
        'login',
        'false',
        'Acesso ao sistema',
        (SELECT id FROM system_user where login = 'mauro.miranda' limit 1)
    WHERE
        NOT EXISTS (SELECT name FROM system_program WHERE name = 'login');
/* sair */
INSERT INTO system_program (section,program,name,private,description,created_by)
    SELECT 
        (SELECT id FROM system_program_section where name = 'Administração' limit 1), 
        'Administracao\Controllers\Geral\Logout::class',
        'sair',
        'true',
        'Sair do Sistema',
        (SELECT id FROM system_user where login = 'mauro.miranda' limit 1)
    WHERE
        NOT EXISTS (SELECT name FROM system_program WHERE name = 'sair');

/* inicio */
INSERT INTO system_program (section,program,name,private,description,created_by)
    SELECT 
        (SELECT id FROM system_program_section where name = 'Administração' limit 1), 
        'Administracao\Controllers\Geral\Inicio::class',
        'inicio',
        'false',
        'Inicio',
        (SELECT id FROM system_user where login = 'mauro.miranda' limit 1)
    WHERE
        NOT EXISTS (SELECT name FROM system_program WHERE name = 'inicio');
/* solicitar.mudanca.senha */
INSERT INTO system_program (section,program,name,private,description,created_by)
    SELECT 
        (SELECT id FROM system_program_section where name = 'Administração' limit 1), 
        'Administracao\Controllers\Geral\SolicitarMudancaSenha::class',
        'solicitar.mudanca.senha',
        'false',
        'Solicitar Alteração de senha',
        (SELECT id FROM system_user where login = 'mauro.miranda' limit 1)
    WHERE
        NOT EXISTS (SELECT name FROM system_program WHERE name = 'solicitar.mudanca.senha');
/* alterar.senha */
INSERT INTO system_program (section,program,name,private,description,created_by)
    SELECT 
        (SELECT id FROM system_program_section where name = 'Administração' limit 1), 
        'Administracao\Controllers\Geral\AlterarSenha::class',
        'alterar.senha',
        'false',
        'Alterar Senha',
        (SELECT id FROM system_user where login = 'mauro.miranda' limit 1)
    WHERE
        NOT EXISTS (SELECT name FROM system_program WHERE name = 'alterar.senha');
/* cadastrar.usuario */
INSERT INTO system_program (section,program,name,private,description,created_by)
    SELECT 
        (SELECT id FROM system_program_section where name = 'Administração' limit 1), 
        'Administracao\Controllers\Usuario\Cadastrar::class',
        'cadastrar.usuario',
        'true',
        'Cadastrar usuário',
        (SELECT id FROM system_user where login = 'mauro.miranda' limit 1)
    WHERE
        NOT EXISTS (SELECT name FROM system_program WHERE name = 'cadastrar.usuario');
/* listar.usuario */
INSERT INTO system_program (section,program,name,private,description,created_by)
    SELECT 
        (SELECT id FROM system_program_section where name = 'Administração' limit 1), 
        'Administracao\Controllers\Usuario\Listar::class',
        'listar.usuario',
        'true',
        'Listar usuários',
        (SELECT id FROM system_user where login = 'mauro.miranda' limit 1)
    WHERE
        NOT EXISTS (SELECT name FROM system_program WHERE name = 'listar.usuario');
/* editar.usuario */
INSERT INTO system_program (section,program,name,private,description,created_by)
    SELECT 
        (SELECT id FROM system_program_section where name = 'Administração' limit 1), 
        'Administracao\Controllers\Usuario\Editar::class',
        'editar.usuario',
        'true',
        'Editar informações de usuários',
        (SELECT id FROM system_user where login = 'mauro.miranda' limit 1)
    WHERE
        NOT EXISTS (SELECT name FROM system_program WHERE name = 'editar.usuario');
/* atualizar.usuario */
INSERT INTO system_program (section,program,name,private,description,created_by)
    SELECT 
        (SELECT id FROM system_program_section where name = 'Administração' limit 1), 
        'Administracao\Controllers\Usuario\Atualizar::class',
        'atualizar.usuario',
        'true',
        'Atualizar Informações de usuário',
        (SELECT id FROM system_user where login = 'mauro.miranda' limit 1)
    WHERE
        NOT EXISTS (SELECT name FROM system_program WHERE name = 'atualizar.usuario');
/* excluir.usuario */
INSERT INTO system_program (section,program,name,private,description,created_by)
    SELECT 
        (SELECT id FROM system_program_section where name = 'Administração' limit 1), 
        'Administracao\Controllers\Usuario\Excluir::class',
        'excluir.usuario',
        'true',
        'Excluir informação de usuário',
        (SELECT id FROM system_user where login = 'mauro.miranda' limit 1)
    WHERE
        NOT EXISTS (SELECT name FROM system_program WHERE name = 'excluir.usuario');
/* alterar.status.usuario */
INSERT INTO system_program (section,program,name,private,description,created_by)
    SELECT 
        (SELECT id FROM system_program_section where name = 'Administração' limit 1), 
        'Administracao\Controllers\Usuario\AlterarStatus::class',
        'alterar.status.usuario',
        'true',
        'Alterar status do usuário',
        (SELECT id FROM system_user where login = 'mauro.miranda' limit 1)
    WHERE
        NOT EXISTS (SELECT name FROM system_program WHERE name = 'alterar.status.usuario');
/* cadastrar.grupo */
INSERT INTO system_program (section,program,name,private,description,created_by)
    SELECT 
        (SELECT id FROM system_program_section where name = 'Administração' limit 1), 
        'Administracao\Controllers\Grupo\Cadastrar::class',
        'cadastrar.grupo',
        'true',
        'Cadastrar grupo de usuários',
        (SELECT id FROM system_user where login = 'mauro.miranda' limit 1)
    WHERE
        NOT EXISTS (SELECT name FROM system_program WHERE name = 'cadastrar.grupo');
/* listar.grupo */
INSERT INTO system_program (section,program,name,private,description,created_by)
    SELECT 
        (SELECT id FROM system_program_section where name = 'Administração' limit 1), 
        'Administracao\Controllers\Grupo\Listar::class',
        'listar.grupo',
        'true',
        'Listar Grupo de usuários',
        (SELECT id FROM system_user where login = 'mauro.miranda' limit 1)
    WHERE
        NOT EXISTS (SELECT name FROM system_program WHERE name = 'listar.grupo');
/* editar.grupo */
INSERT INTO system_program (section,program,name,private,description,created_by)
    SELECT 
        (SELECT id FROM system_program_section where name = 'Administração' limit 1), 
        'Administracao\Controllers\Grupo\Editar::class',
        'editar.grupo',
        'true',
        'Editar grupo',
        (SELECT id FROM system_user where login = 'mauro.miranda' limit 1)
    WHERE
        NOT EXISTS (SELECT name FROM system_program WHERE name = 'editar.grupo');
/* atualizar.grupo */
INSERT INTO system_program (section,program,name,private,description,created_by)
    SELECT 
        (SELECT id FROM system_program_section where name = 'Administração' limit 1), 
        'Administracao\Controllers\Grupo\Atualizar::class',
        'atualizar.grupo',
        'true',
        'Atualizar grupo',
        (SELECT id FROM system_user where login = 'mauro.miranda' limit 1)
    WHERE
        NOT EXISTS (SELECT name FROM system_program WHERE name = 'atualizar.grupo');
/* excluir.grupo */
INSERT INTO system_program (section,program,name,private,description,created_by)
    SELECT 
        (SELECT id FROM system_program_section where name = 'Administração' limit 1), 
        'Administracao\Controllers\Grupo\Excluir::class',
        'excluir.grupo',
        'true',
        'Excluir grupo',
        (SELECT id FROM system_user where login = 'mauro.miranda' limit 1)
    WHERE
        NOT EXISTS (SELECT name FROM system_program WHERE name = 'excluir.grupo');
/* cadastrar.secao */
INSERT INTO system_program (section,program,name,private,description,created_by)
    SELECT 
        (SELECT id FROM system_program_section where name = 'Administração' limit 1), 
        'Administracao\Controllers\Secao\Cadastrar::class',
        'cadastrar.secao',
        'true',
        'Cadastrar seão',
        (SELECT id FROM system_user where login = 'mauro.miranda' limit 1)
    WHERE
        NOT EXISTS (SELECT name FROM system_program WHERE name = 'cadastrar.secao');
/* listar.secao */
INSERT INTO system_program (section,program,name,private,description,created_by)
    SELECT 
        (SELECT id FROM system_program_section where name = 'Administração' limit 1), 
        'Administracao\Controllers\Secao\Listar::class',
        'listar.secao',
        'true',
        'Listar seção',
        (SELECT id FROM system_user where login = 'mauro.miranda' limit 1)
    WHERE
        NOT EXISTS (SELECT name FROM system_program WHERE name = 'listar.secao');
/* editar.secao */
INSERT INTO system_program (section,program,name,private,description,created_by)
    SELECT 
        (SELECT id FROM system_program_section where name = 'Administração' limit 1), 
        'Administracao\Controllers\Secao\Editar::class',
        'editar.secao',
        'true',
        'Editar seçao',
        (SELECT id FROM system_user where login = 'mauro.miranda' limit 1)
    WHERE
        NOT EXISTS (SELECT name FROM system_program WHERE name = 'editar.secao');
/* atualizar.secao */
INSERT INTO system_program (section,program,name,private,description,created_by)
    SELECT 
        (SELECT id FROM system_program_section where name = 'Administração' limit 1), 
        'Administracao\Controllers\Secao\Atualizar::class',
        'atualizar.secao',
        'true',
        'Atualizar seção',
        (SELECT id FROM system_user where login = 'mauro.miranda' limit 1)
    WHERE
        NOT EXISTS (SELECT name FROM system_program WHERE name = 'atualizar.secao');
/* excluir.secao */
INSERT INTO system_program (section,program,name,private,description,created_by)
    SELECT 
        (SELECT id FROM system_program_section where name = 'Administração' limit 1), 
        'Administracao\Controllers\Secao\Excluir::class',
        'excluir.secao',
        'true',
        'Excluir secao',
        (SELECT id FROM system_user where login = 'mauro.miranda' limit 1)
    WHERE
        NOT EXISTS (SELECT name FROM system_program WHERE name = 'excluir.secao');
/* cadastrar.programa */
INSERT INTO system_program (section,program,name,private,description,created_by)
    SELECT 
        (SELECT id FROM system_program_section where name = 'Administração' limit 1), 
        'Administracao\Controllers\Programa\Cadastrar::class',
        'cadastrar.programa',
        'true',
        'Cadastrar programa',
        (SELECT id FROM system_user where login = 'mauro.miranda' limit 1)
    WHERE
        NOT EXISTS (SELECT name FROM system_program WHERE name = 'cadastrar.programa');
/* listar.programa */
INSERT INTO system_program (section,program,name,private,description,created_by)
    SELECT 
        (SELECT id FROM system_program_section where name = 'Administração' limit 1), 
        'Administracao\Controllers\Programa\Listar::class',
        'listar.programa',
        'true',
        'Listar programa',
        (SELECT id FROM system_user where login = 'mauro.miranda' limit 1)
    WHERE
        NOT EXISTS (SELECT name FROM system_program WHERE name = 'listar.programa');
/* editar.programa */
INSERT INTO system_program (section,program,name,private,description,created_by)
    SELECT 
        (SELECT id FROM system_program_section where name = 'Administração' limit 1), 
        'Administracao\Controllers\Programa\Editar::class',
        'editar.programa',
        'true',
        'Editar programa',
        (SELECT id FROM system_user where login = 'mauro.miranda' limit 1)
    WHERE
        NOT EXISTS (SELECT name FROM system_program WHERE name = 'editar.programa');
/* atualizar.programa */
INSERT INTO system_program (section,program,name,private,description,created_by)
    SELECT 
        (SELECT id FROM system_program_section where name = 'Administração' limit 1), 
        'Administracao\Controllers\Programa\Atualizar::class',
        'atualizar.programa',
        'true',
        'Atualizar programa',
        (SELECT id FROM system_user where login = 'mauro.miranda' limit 1)
    WHERE
        NOT EXISTS (SELECT name FROM system_program WHERE name = 'atualizar.programa');
/* excluir.programa */
INSERT INTO system_program (section,program,name,private,description,created_by)
    SELECT 
        (SELECT id FROM system_program_section where name = 'Administração' limit 1), 
        'Administracao\Controllers\Programa\Excluir::class',
        'excluir.programa',
        'true',
        'Excluir programa',
        (SELECT id FROM system_user where login = 'mauro.miranda' limit 1)
    WHERE
        NOT EXISTS (SELECT name FROM system_program WHERE name = 'excluir.programa');
/* criar.configuracao */
INSERT INTO system_program (section,program,name,private,description,created_by)
    SELECT 
        (SELECT id FROM system_program_section where name = 'Administração' limit 1), 
        'Administracao\Controllers\Configuracao\Cadastrar::class',
        'criar.configuracao',
        'true',
        'Criar configuracao',
        (SELECT id FROM system_user where login = 'mauro.miranda' limit 1)
    WHERE
        NOT EXISTS (SELECT name FROM system_program WHERE name = 'criar.configuracao');
/* exibir.configuracao */
INSERT INTO system_program (section,program,name,private,description,created_by)
    SELECT 
        (SELECT id FROM system_program_section where name = 'Administração' limit 1), 
        'Administracao\Controllers\Configuracao\Listar::class',
        'exibir.configuracao',
        'true',
        'Exibir configuração',
        (SELECT id FROM system_user where login = 'mauro.miranda' limit 1)
    WHERE
        NOT EXISTS (SELECT name FROM system_program WHERE name = 'exibir.configuracao');
/* ACL */
INSERT INTO system_program (section,program,name,private,description,created_by)
    SELECT 
        (SELECT id FROM system_program_section where name = 'Administração' limit 1), 
        'Administracao\Controllers\Geral\Acl::class',
        'acl',
        'false',
        'Permissões de acesso',
        (SELECT id FROM system_user where login = 'mauro.miranda' limit 1)
    WHERE
        NOT EXISTS (SELECT name FROM system_program WHERE name = 'acl');
/* log.acesso */
INSERT INTO system_program (section,program,name,private,description,created_by)
    SELECT 
        (SELECT id FROM system_program_section where name = 'Logs' limit 1), 
        'Administracao\Controllers\Log\LogAcesso::class',
        'log.acesso',
        'true',
        'Listar acessos de usuários',
        (SELECT id FROM system_user where login = 'mauro.miranda' limit 1)
    WHERE
        NOT EXISTS (SELECT name FROM system_program WHERE name = 'log.acesso');
/* auditoria */
INSERT INTO system_program (section,program,name,private,description,created_by)
    SELECT 
        (SELECT id FROM system_program_section where name = 'Logs' limit 1), 
        'Administracao\Controllers\Log\Auditoria::class',
        'auditoria',
        'true',
        'Auditar ações dentro do sistema',
        (SELECT id FROM system_user where login = 'mauro.miranda' limit 1)
    WHERE
        NOT EXISTS (SELECT name FROM system_program WHERE name = 'auditoria');
/* secao.acl */
INSERT INTO system_program (section,program,name,private,description,created_by)
    SELECT 
        (SELECT id FROM system_program_section where name = 'Logs' limit 1), 
        'Administracao\Controllers\Secao\SecaoAcl::class',
        'secao.acl',
        'true',
        'Controle de acesso Para Menu',
        (SELECT id FROM system_user where login = 'mauro.miranda' limit 1)
    WHERE
        NOT EXISTS (SELECT name FROM system_program WHERE name = 'secao.acl');