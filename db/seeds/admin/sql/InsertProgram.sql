/* status */
INSERT INTO "SYSTEM_PROGRAM" ("SECTION","PROGRAM","NAME","PRIVATE","DESCRIPTION","CREATED_BY")
    SELECT 
        (SELECT "ID" FROM "SYSTEM_PROGRAM_SECTION" where "NAME" = 'Administração' LIMIT 1), 
        'Admin\Controllers\SystemPublic\Status::class',
        'status',
        'false',
        'Status do sistema',
        (SELECT "ID" FROM "SYSTEM_USER" where "LOGIN" = 'mauro.miranda' LIMIT 1)
    WHERE
        NOT EXISTS (SELECT "NAME" FROM "SYSTEM_PROGRAM" WHERE "NAME" = 'status');
/* login */
INSERT INTO "SYSTEM_PROGRAM" ("SECTION","PROGRAM","NAME","PRIVATE","DESCRIPTION","CREATED_BY")
    SELECT 
        (SELECT "ID" FROM "SYSTEM_PROGRAM_SECTION" where "NAME" = 'Administração' limit 1), 
        'Admin\Controllers\SystemPublic\Login::class',
        'login',
        'false',
        'Acesso ao sistema',
        (SELECT "ID" FROM "SYSTEM_USER" where "LOGIN" = 'mauro.miranda' limit 1)
    WHERE
        NOT EXISTS (SELECT "NAME" FROM "SYSTEM_PROGRAM" WHERE "NAME" = 'login');
/* sair */
INSERT INTO "SYSTEM_PROGRAM" ("SECTION","PROGRAM","NAME","PRIVATE","DESCRIPTION","CREATED_BY")
    SELECT 
        (SELECT "ID" FROM "SYSTEM_PROGRAM_SECTION" where "NAME" = 'Administração' limit 1), 
        'Admin\Controllers\SystemPublic\Logout::class',
        'logout',
        'true',
        'Sair do Sistema',
        (SELECT "ID" FROM "SYSTEM_USER" where "LOGIN" = 'mauro.miranda' limit 1)
    WHERE
        NOT EXISTS (SELECT "NAME" FROM "SYSTEM_PROGRAM" WHERE "NAME" = 'logout');

/* inicio */
INSERT INTO "SYSTEM_PROGRAM" ("SECTION","PROGRAM","NAME","PRIVATE","DESCRIPTION","CREATED_BY")
    SELECT 
        (SELECT "ID" FROM "SYSTEM_PROGRAM_SECTION" where "NAME" = 'Administração' limit 1), 
        'Admin\Controllers\SystemPublic\Home::class',
        'home',
        'false',
        'Inicio',
        (SELECT "ID" FROM "SYSTEM_USER" where "LOGIN" = 'mauro.miranda' limit 1)
    WHERE
        NOT EXISTS (SELECT "NAME" FROM "SYSTEM_PROGRAM" WHERE "NAME" = 'home');
/* solicitar.mudanca.senha */
INSERT INTO "SYSTEM_PROGRAM" ("SECTION","PROGRAM","NAME","PRIVATE","DESCRIPTION","CREATED_BY")
    SELECT 
        (SELECT "ID" FROM "SYSTEM_PROGRAM_SECTION" where "NAME" = 'Administração' limit 1), 
        'Admin\Controllers\SystemPublic\ChangePasswordRequest::class',
        'change.password.request',
        'false',
        'Solicitar Alteração de senha',
        (SELECT "ID" FROM "SYSTEM_USER" where "LOGIN" = 'mauro.miranda' limit 1)
    WHERE
        NOT EXISTS (SELECT "NAME" FROM "SYSTEM_PROGRAM" WHERE "NAME" = 'change.password.request');
/* alterar.senha */
INSERT INTO "SYSTEM_PROGRAM" ("SECTION","PROGRAM","NAME","PRIVATE","DESCRIPTION","CREATED_BY")
    SELECT 
        (SELECT "ID" FROM "SYSTEM_PROGRAM_SECTION" where "NAME" = 'Administração' limit 1), 
        'Admin\Controllers\SystemPublic\ChangePassword::class',
        'change.password',
        'false',
        'Alterar Senha',
        (SELECT "ID" FROM "SYSTEM_USER" where "LOGIN" = 'mauro.miranda' limit 1)
    WHERE
        NOT EXISTS (SELECT "NAME" FROM "SYSTEM_PROGRAM" WHERE "NAME" = 'change.password');
/* cadastrar.usuario */
INSERT INTO "SYSTEM_PROGRAM" ("SECTION","PROGRAM","NAME","PRIVATE","DESCRIPTION","CREATED_BY")
    SELECT 
        (SELECT "ID" FROM "SYSTEM_PROGRAM_SECTION" where "NAME" = 'Administração' limit 1), 
        'Admin\Controllers\SystemUser\Create::class',
        'create.user',
        'true',
        'Cadastrar usuário',
        (SELECT "ID" FROM "SYSTEM_USER" where "LOGIN" = 'mauro.miranda' limit 1)
    WHERE
        NOT EXISTS (SELECT "NAME" FROM "SYSTEM_PROGRAM" WHERE "NAME" = 'create.user');
/* listar.usuario */
INSERT INTO "SYSTEM_PROGRAM" ("SECTION","PROGRAM","NAME","PRIVATE","DESCRIPTION","CREATED_BY")
    SELECT 
        (SELECT "ID" FROM "SYSTEM_PROGRAM_SECTION" where "NAME" = 'Administração' limit 1), 
        'Admin\Controllers\SystemUser\Read::class',
        'user.list',
        'true',
        'Listar usuários',
        (SELECT "ID" FROM "SYSTEM_USER" where "LOGIN" = 'mauro.miranda' limit 1)
    WHERE
        NOT EXISTS (SELECT "NAME" FROM "SYSTEM_PROGRAM" WHERE "NAME" = 'user.list');
/* editar.usuario */
INSERT INTO "SYSTEM_PROGRAM" ("SECTION","PROGRAM","NAME","PRIVATE","DESCRIPTION","CREATED_BY")
    SELECT 
        (SELECT "ID" FROM "SYSTEM_PROGRAM_SECTION" where "NAME" = 'Administração' limit 1), 
        'Admin\Controllers\SystemUser\Edit::class',
        'user.edit',
        'true',
        'Editar informações de usuários',
        (SELECT "ID" FROM "SYSTEM_USER" where "LOGIN" = 'mauro.miranda' limit 1)
    WHERE
        NOT EXISTS (SELECT "NAME" FROM "SYSTEM_PROGRAM" WHERE "NAME" = 'user.edit');
/* atualizar.usuario */
INSERT INTO "SYSTEM_PROGRAM" ("SECTION","PROGRAM","NAME","PRIVATE","DESCRIPTION","CREATED_BY")
    SELECT 
        (SELECT "ID" FROM "SYSTEM_PROGRAM_SECTION" where "NAME" = 'Administração' limit 1), 
        'Admin\Controllers\SystemUser\Update::class',
        'user.update',
        'true',
        'Atualizar Informações de usuário',
        (SELECT "ID" FROM "SYSTEM_USER" where "LOGIN" = 'mauro.miranda' limit 1)
    WHERE
        NOT EXISTS (SELECT "NAME" FROM "SYSTEM_PROGRAM" WHERE "NAME" = 'user.update');
/* excluir.usuario */
INSERT INTO "SYSTEM_PROGRAM" ("SECTION","PROGRAM","NAME","PRIVATE","DESCRIPTION","CREATED_BY")
    SELECT 
        (SELECT "ID" FROM "SYSTEM_PROGRAM_SECTION" where "NAME" = 'Administração' limit 1), 
        'Admin\Controllers\SystemUser\Delete::class',
        'user.delete',
        'true',
        'Excluir informação de usuário',
        (SELECT "ID" FROM "SYSTEM_USER" where "LOGIN" = 'mauro.miranda' limit 1)
    WHERE
        NOT EXISTS (SELECT "NAME" FROM "SYSTEM_PROGRAM" WHERE "NAME" = 'user.delete');
/* alterar.status.usuario */
INSERT INTO "SYSTEM_PROGRAM" ("SECTION","PROGRAM","NAME","PRIVATE","DESCRIPTION","CREATED_BY")
    SELECT 
        (SELECT "ID" FROM "SYSTEM_PROGRAM_SECTION" where "NAME" = 'Administração' limit 1), 
        'Admin\Controllers\SystemUser\ChangeStatus::class',
        'user.status.change',
        'true',
        'Alterar status do usuário',
        (SELECT "ID" FROM "SYSTEM_USER" where "LOGIN" = 'mauro.miranda' limit 1)
    WHERE
        NOT EXISTS (SELECT "NAME" FROM "SYSTEM_PROGRAM" WHERE "NAME" = 'user.status.change');
/* cadastrar.grupo */
INSERT INTO "SYSTEM_PROGRAM" ("SECTION","PROGRAM","NAME","PRIVATE","DESCRIPTION","CREATED_BY")
    SELECT 
        (SELECT "ID" FROM "SYSTEM_PROGRAM_SECTION" where "NAME" = 'Administração' limit 1), 
        'Admin\Controllers\SystemGroup\Create::class',
        'group.create',
        'true',
        'Cadastrar grupo de usuários',
        (SELECT "ID" FROM "SYSTEM_USER" where "LOGIN" = 'mauro.miranda' limit 1)
    WHERE
        NOT EXISTS (SELECT "NAME" FROM "SYSTEM_PROGRAM" WHERE "NAME" = 'group.create');
/* listar.grupo */
INSERT INTO "SYSTEM_PROGRAM" ("SECTION","PROGRAM","NAME","PRIVATE","DESCRIPTION","CREATED_BY")
    SELECT 
        (SELECT "ID" FROM "SYSTEM_PROGRAM_SECTION" where "NAME" = 'Administração' limit 1), 
        'Admin\Controllers\SystemGroup\Read::class',
        'group.list',
        'true',
        'Listar Grupo de usuários',
        (SELECT "ID" FROM "SYSTEM_USER" where "LOGIN" = 'mauro.miranda' limit 1)
    WHERE
        NOT EXISTS (SELECT "NAME" FROM "SYSTEM_PROGRAM" WHERE "NAME" = 'group.list');
/* editar.grupo */
INSERT INTO "SYSTEM_PROGRAM" ("SECTION","PROGRAM","NAME","PRIVATE","DESCRIPTION","CREATED_BY")
    SELECT 
        (SELECT "ID" FROM "SYSTEM_PROGRAM_SECTION" where "NAME" = 'Administração' limit 1), 
        'Admin\Controllers\SystemGroup\Edit::class',
        'group.edit',
        'true',
        'Editar grupo',
        (SELECT "ID" FROM "SYSTEM_USER" where "LOGIN" = 'mauro.miranda' limit 1)
    WHERE
        NOT EXISTS (SELECT "NAME" FROM "SYSTEM_PROGRAM" WHERE "NAME" = 'group.edit');
/* atualizar.grupo */
INSERT INTO "SYSTEM_PROGRAM" ("SECTION","PROGRAM","NAME","PRIVATE","DESCRIPTION","CREATED_BY")
    SELECT 
        (SELECT "ID" FROM "SYSTEM_PROGRAM_SECTION" where "NAME" = 'Administração' limit 1), 
        'Admin\Controllers\SystemGroup\Update::class',
        'group.update',
        'true',
        'Atualizar grupo',
        (SELECT "ID" FROM "SYSTEM_USER" where "LOGIN" = 'mauro.miranda' limit 1)
    WHERE
        NOT EXISTS (SELECT "NAME" FROM "SYSTEM_PROGRAM" WHERE "NAME" = 'group.update');
/* excluir.grupo */
INSERT INTO "SYSTEM_PROGRAM" ("SECTION","PROGRAM","NAME","PRIVATE","DESCRIPTION","CREATED_BY")
    SELECT 
        (SELECT "ID" FROM "SYSTEM_PROGRAM_SECTION" where "NAME" = 'Administração' limit 1), 
        'Admin\Controllers\SystemGroup\Delete::class',
        'group.delete',
        'true',
        'Excluir grupo',
        (SELECT "ID" FROM "SYSTEM_USER" where "LOGIN" = 'mauro.miranda' limit 1)
    WHERE
        NOT EXISTS (SELECT "NAME" FROM "SYSTEM_PROGRAM" WHERE "NAME" = 'group.delete');
/* cadastrar.secao */
INSERT INTO "SYSTEM_PROGRAM" ("SECTION","PROGRAM","NAME","PRIVATE","DESCRIPTION","CREATED_BY")
    SELECT 
        (SELECT "ID" FROM "SYSTEM_PROGRAM_SECTION" where "NAME" = 'Administração' limit 1), 
        'Admin\Controllers\SystemSection\Create::class',
        'section.create',
        'true',
        'Cadastrar seão',
        (SELECT "ID" FROM "SYSTEM_USER" where "LOGIN" = 'mauro.miranda' limit 1)
    WHERE
        NOT EXISTS (SELECT "NAME" FROM "SYSTEM_PROGRAM" WHERE "NAME" = 'section.create');
/* listar.secao */
INSERT INTO "SYSTEM_PROGRAM" ("SECTION","PROGRAM","NAME","PRIVATE","DESCRIPTION","CREATED_BY")
    SELECT 
        (SELECT "ID" FROM "SYSTEM_PROGRAM_SECTION" where "NAME" = 'Administração' limit 1), 
        'Admin\Controllers\SystemSection\Read::class',
        'section.list',
        'true',
        'Listar seção',
        (SELECT "ID" FROM "SYSTEM_USER" where "LOGIN" = 'mauro.miranda' limit 1)
    WHERE
        NOT EXISTS (SELECT "NAME" FROM "SYSTEM_PROGRAM" WHERE "NAME" = 'section.list');
/* editar.secao */
INSERT INTO "SYSTEM_PROGRAM" ("SECTION","PROGRAM","NAME","PRIVATE","DESCRIPTION","CREATED_BY")
    SELECT 
        (SELECT "ID" FROM "SYSTEM_PROGRAM_SECTION" where "NAME" = 'Administração' limit 1), 
        'Admin\Controllers\SystemSection\Edit::class',
        'section.edit',
        'true',
        'Editar seçao',
        (SELECT "ID" FROM "SYSTEM_USER" where "LOGIN" = 'mauro.miranda' limit 1)
    WHERE
        NOT EXISTS (SELECT "NAME" FROM "SYSTEM_PROGRAM" WHERE "NAME" = 'section.edit');
/* atualizar.secao */
INSERT INTO "SYSTEM_PROGRAM" ("SECTION","PROGRAM","NAME","PRIVATE","DESCRIPTION","CREATED_BY")
    SELECT 
        (SELECT "ID" FROM "SYSTEM_PROGRAM_SECTION" where "NAME" = 'Administração' limit 1), 
        'Admin\Controllers\SystemSection\Update::class',
        'section.update',
        'true',
        'Atualizar seção',
        (SELECT "ID" FROM "SYSTEM_USER" where "LOGIN" = 'mauro.miranda' limit 1)
    WHERE
        NOT EXISTS (SELECT "NAME" FROM "SYSTEM_PROGRAM" WHERE "NAME" = 'section.update');
/* excluir.secao */
INSERT INTO "SYSTEM_PROGRAM" ("SECTION","PROGRAM","NAME","PRIVATE","DESCRIPTION","CREATED_BY")
    SELECT 
        (SELECT "ID" FROM "SYSTEM_PROGRAM_SECTION" where "NAME" = 'Administração' limit 1), 
        'Admin\Controllers\SystemSection\Delete::class',
        'section.delete',
        'true',
        'Excluir secao',
        (SELECT "ID" FROM "SYSTEM_USER" where "LOGIN" = 'mauro.miranda' limit 1)
    WHERE
        NOT EXISTS (SELECT "NAME" FROM "SYSTEM_PROGRAM" WHERE "NAME" = 'section.delete');
/* cadastrar.programa */
INSERT INTO "SYSTEM_PROGRAM" ("SECTION","PROGRAM","NAME","PRIVATE","DESCRIPTION","CREATED_BY")
    SELECT 
        (SELECT "ID" FROM "SYSTEM_PROGRAM_SECTION" where "NAME" = 'Administração' limit 1), 
        'Admin\Controllers\SystemProgram\Create::class',
        'program.create',
        'true',
        'Cadastrar programa',
        (SELECT "ID" FROM "SYSTEM_USER" where "LOGIN" = 'mauro.miranda' limit 1)
    WHERE
        NOT EXISTS (SELECT "NAME" FROM "SYSTEM_PROGRAM" WHERE "NAME" = 'program.create');
/* listar.programa */
INSERT INTO "SYSTEM_PROGRAM" ("SECTION","PROGRAM","NAME","PRIVATE","DESCRIPTION","CREATED_BY")
    SELECT 
        (SELECT "ID" FROM "SYSTEM_PROGRAM_SECTION" where "NAME" = 'Administração' limit 1), 
        'Admin\Controllers\SystemProgram\Read::class',
        'program.list',
        'true',
        'Listar programa',
        (SELECT "ID" FROM "SYSTEM_USER" where "LOGIN" = 'mauro.miranda' limit 1)
    WHERE
        NOT EXISTS (SELECT "NAME" FROM "SYSTEM_PROGRAM" WHERE "NAME" = 'program.list');
/* editar.programa */
INSERT INTO "SYSTEM_PROGRAM" ("SECTION","PROGRAM","NAME","PRIVATE","DESCRIPTION","CREATED_BY")
    SELECT 
        (SELECT "ID" FROM "SYSTEM_PROGRAM_SECTION" where "NAME" = 'Administração' limit 1), 
        'Admin\Controllers\SystemProgram\Edit::class',
        'program.edit',
        'true',
        'Editar programa',
        (SELECT "ID" FROM "SYSTEM_USER" where "LOGIN" = 'mauro.miranda' limit 1)
    WHERE
        NOT EXISTS (SELECT "NAME" FROM "SYSTEM_PROGRAM" WHERE "NAME" = 'program.edit');
/* atualizar.programa */
INSERT INTO "SYSTEM_PROGRAM" ("SECTION","PROGRAM","NAME","PRIVATE","DESCRIPTION","CREATED_BY")
    SELECT 
        (SELECT "ID" FROM "SYSTEM_PROGRAM_SECTION" where "NAME" = 'Administração' limit 1), 
        'Admin\Controllers\SystemProgram\Update::class',
        'program.update',
        'true',
        'Atualizar programa',
        (SELECT "ID" FROM "SYSTEM_USER" where "LOGIN" = 'mauro.miranda' limit 1)
    WHERE
        NOT EXISTS (SELECT "NAME" FROM "SYSTEM_PROGRAM" WHERE "NAME" = 'program.update');
/* excluir.programa */
INSERT INTO "SYSTEM_PROGRAM" ("SECTION","PROGRAM","NAME","PRIVATE","DESCRIPTION","CREATED_BY")
    SELECT 
        (SELECT "ID" FROM "SYSTEM_PROGRAM_SECTION" where "NAME" = 'Administração' limit 1), 
        'Admin\Controllers\SystemProgram\Delete::class',
        'program.delete',
        'true',
        'Excluir programa',
        (SELECT "ID" FROM "SYSTEM_USER" where "LOGIN" = 'mauro.miranda' limit 1)
    WHERE
        NOT EXISTS (SELECT "NAME" FROM "SYSTEM_PROGRAM" WHERE "NAME" = 'program.delete');
/* criar.configuracao */
INSERT INTO "SYSTEM_PROGRAM" ("SECTION","PROGRAM","NAME","PRIVATE","DESCRIPTION","CREATED_BY")
    SELECT 
        (SELECT "ID" FROM "SYSTEM_PROGRAM_SECTION" where "NAME" = 'Administração' limit 1), 
        'Admin\Controllers\SystemConfiguration\CreateOrUpdate::class',
        'configuration.create.or.update',
        'true',
        'Criar configuracao',
        (SELECT "ID" FROM "SYSTEM_USER" where "LOGIN" = 'mauro.miranda' limit 1)
    WHERE
        NOT EXISTS (SELECT "NAME" FROM "SYSTEM_PROGRAM" WHERE "NAME" = 'configuration.create.or.update');
/* exibir.configuracao */
INSERT INTO "SYSTEM_PROGRAM" ("SECTION","PROGRAM","NAME","PRIVATE","DESCRIPTION","CREATED_BY")
    SELECT 
        (SELECT "ID" FROM "SYSTEM_PROGRAM_SECTION" where "NAME" = 'Administração' limit 1), 
        'Admin\Controllers\SystemConfiguration\Read::class',
        'configuration.list',
        'true',
        'Exibir configuração',
        (SELECT "ID" FROM "SYSTEM_USER" where "LOGIN" = 'mauro.miranda' limit 1)
    WHERE
        NOT EXISTS (SELECT "NAME" FROM "SYSTEM_PROGRAM" WHERE "NAME" = 'configuration.list');
/* ACL */
INSERT INTO "SYSTEM_PROGRAM" ("SECTION","PROGRAM","NAME","PRIVATE","DESCRIPTION","CREATED_BY")
    SELECT 
        (SELECT "ID" FROM "SYSTEM_PROGRAM_SECTION" where "NAME" = 'Administração' limit 1), 
        'Admin\Controllers\SystemPublic\Acl::class',
        'acl',
        'false',
        'Permissões de acesso',
        (SELECT "ID" FROM "SYSTEM_USER" where "LOGIN" = 'mauro.miranda' limit 1)
    WHERE
        NOT EXISTS (SELECT "NAME" FROM "SYSTEM_PROGRAM" WHERE "NAME" = 'acl');
/* log.acesso */
INSERT INTO "SYSTEM_PROGRAM" ("SECTION","PROGRAM","NAME","PRIVATE","DESCRIPTION","CREATED_BY")
    SELECT 
        (SELECT "ID" FROM "SYSTEM_PROGRAM_SECTION" where "NAME" = 'Logs' limit 1), 
        'Admin\Controllers\SystemLog\AccessLog::class',
        'access.log',
        'true',
        'Listar acessos de usuários',
        (SELECT "ID" FROM "SYSTEM_USER" where "LOGIN" = 'mauro.miranda' limit 1)
    WHERE
        NOT EXISTS (SELECT "NAME" FROM "SYSTEM_PROGRAM" WHERE "NAME" = 'access.log');
/* auditoria */
INSERT INTO "SYSTEM_PROGRAM" ("SECTION","PROGRAM","NAME","PRIVATE","DESCRIPTION","CREATED_BY")
    SELECT 
        (SELECT "ID" FROM "SYSTEM_PROGRAM_SECTION" where "NAME" = 'Logs' limit 1), 
        'Admin\Controllers\SystemLog\SqlLog::class',
        'audit',
        'true',
        'Auditar ações dentro do sistema',
        (SELECT "ID" FROM "SYSTEM_USER" where "LOGIN" = 'mauro.miranda' limit 1)
    WHERE
        NOT EXISTS (SELECT "NAME" FROM "SYSTEM_PROGRAM" WHERE "NAME" = 'audit');
/* secao.acl */
INSERT INTO "SYSTEM_PROGRAM" ("SECTION","PROGRAM","NAME","PRIVATE","DESCRIPTION","CREATED_BY")
    SELECT 
        (SELECT "ID" FROM "SYSTEM_PROGRAM_SECTION" where "NAME" = 'Logs' limit 1), 
        'Admin\Controllers\Section\Acl::class',
        'section.acl',
        'true',
        'Controle de acesso Para Menu',
        (SELECT "ID" FROM "SYSTEM_USER" where "LOGIN" = 'mauro.miranda' limit 1)
    WHERE
        NOT EXISTS (SELECT "NAME" FROM "SYSTEM_PROGRAM" WHERE "NAME" = 'section.acl');