<?php
// https://eltonminetto.dev/post/2018-08-01-monorepo-drone/
return [  
    /*
    |---------------------------------------------------------------------------------------------------------------------------------------------------------
    |                                                        ADMINISTRACTION SECTION OF THE ROUTE
    |---------------------------------------------------------------------------------------------------------------------------------------------------------
    */ 
    'principal' => [
        ['GET'      , '/status'                                 , Admin\Controllers\SystemPublic\Status::class                  , 'status'                  ],
        ['POST'     , '/login'                                  , Admin\Controllers\SystemPublic\Login::class                   , 'login'                   ],
        ['GET'      , '/logout/'                                , Admin\Controllers\SystemPublic\Logout::class                  , 'sair'                    ],
        ['GET'      , '/inicio'                                 , Admin\Controllers\SystemPublic\Home::class                    , 'inicio'                  ], 
        ['POST'     , '/resetar-senha'                          , Admin\Controllers\SystemPublic\SolicitarMudancaSenha::class   , 'solicitar.mudanca.senha' ], 
        ['POST'     , '/alterar-senha/[*:token]'                , Admin\Controllers\SystemPublic\AlterarSenha::class            , 'alterar.senha'           ],
        ['GET'      , '/acl/[*:controller]/'                    , Admin\Controllers\SystemPublic\Acl::class                     , 'acl'                     ],
        /*
        |-----------------------------------------------------------------------------------------------------------------------------------------------------
        |                                                           ROUTE FOR THE LOGS
        |-----------------------------------------------------------------------------------------------------------------------------------------------------
        */
        ['POST'     , '/log-acesso/[i:page]/[i:by_page]'        , Admin\Controllers\SystemLog\AccessLog::class                  , 'log.acesso'              ], 
        ['POST'     , '/auditoria/[i:page]/[i:by_page]'         , Admin\Controllers\SystemLog\SqlLog::class                     , 'auditoria'               ], 
        
        /*
        |-----------------------------------------------------------------------------------------------------------------------------------------------------
        |                                                           ROUTE FOR THE USER
        |-----------------------------------------------------------------------------------------------------------------------------------------------------
        */
        ['POST'     , '/usuario'                                , Admin\Controllers\SystemUser\Create::class                    , 'cadastrar.usuario'       ],
        ['POST'     , '/usuario/[i:page]/[i:by_page]'           , Admin\Controllers\SystemUser\Read::class                      , 'listar.usuario'          ],
        ['GET'      , '/usuario/[*:id]'                         , Admin\Controllers\SystemUser\Edit::class                      , 'editar.usuario'          ],
        ['PUT'      , '/usuario/[*:id]'                         , Admin\Controllers\SystemUser\Update::class                    , 'atualizar.usuario'       ],
        ['DELETE'   , '/usuario/[*:id]'                         , Admin\Controllers\SystemUser\Delete::class                    , 'excluir.usuario'         ],
        ['GET'      , '/usuario/status/[*:id]/'                 , Admin\Controllers\SystemUser\ChangeStatus::class              , 'alterar.status.usuario'  ],

        /*
        |-----------------------------------------------------------------------------------------------------------------------------------------------------
        |                                                        ROUTE FOR USER PROFILE
        |-----------------------------------------------------------------------------------------------------------------------------------------------------
        */
        ['GET'      , '/perfil/'                                , Admin\Controllers\Perfil\Edit::class                          , 'editar.perfil'           ],
        ['POST'     , '/perfil'                                 , Admin\Controllers\Perfil\Update::class                        , 'atualizar.perfil'        ],
        
        /*
        |-----------------------------------------------------------------------------------------------------------------------------------------------------
        |                                                       ROUTE FOR THE USER GROUPS
        |-----------------------------------------------------------------------------------------------------------------------------------------------------
        */
        ['POST'     , '/grupo'                                  , Admin\Controllers\SystemGroup\Create::class                   , 'cadastrar.grupo'         ],
        ['POST'     , '/grupo/[i:page]/[i:by_page]'             , Admin\Controllers\SystemGroup\Read::class                     , 'listar.grupo'            ],
        ['GET'      , '/grupo/[*:id]'                           , Admin\Controllers\SystemGroup\Edit::class                     , 'editar.grupo'            ],
        ['PUT'      , '/grupo/[*:id]'                           , Admin\Controllers\SystemGroup\Update::class                   , 'atualizar.grupo'         ],
        ['DELETE'   , '/grupo/[*:id]'                           , Admin\Controllers\SystemGroup\Delete::class                   , 'excluir.grupo'           ],
        ['POST'     , '/grupo/programa'                         , Admin\Controllers\SystemGroup\GrupoEPrograma::class           , 'grupo.e.permissao'       ],
        /*
        |-----------------------------------------------------------------------------------------------------------------------------------------------------
        |                                                     ROUTE FOR THE PROGRAM SECTION
        |-----------------------------------------------------------------------------------------------------------------------------------------------------
        */
        ['POST'     , '/secao'                                  , Admin\Controllers\SystemSection\Create::class                 , 'cadastrar.secao'         ],
        ['POST'     , '/secao/[i:page]/[i:by_page]'             , Admin\Controllers\SystemSection\Read::class                   , 'listar.secao'            ],
        ['POST'     , '/secao/editar'                           , Admin\Controllers\SystemSection\Edit::class                   , 'editar.secao'            ],
        ['PUT'      , '/secao/[*:id]'                           , Admin\Controllers\SystemSection\Update::class                 , 'atualizar.secao'         ],
        ['DELETE'   , '/secao/[*:id]'                           , Admin\Controllers\SystemSection\Delete::class                 , 'excluir.secao'           ],
        /*
        |-----------------------------------------------------------------------------------------------------------------------------------------------------
        |                                                      ROUTE FOR THE SYSTEM PROGRAM
        |-----------------------------------------------------------------------------------------------------------------------------------------------------
        */
        ['POST'     , '/programa'                               , Admin\Controllers\SystemProgram\Create::class                 , 'cadastrar.programa'      ],
        ['POST'     , '/programa/[i:page]/[i:by_page]'          , Admin\Controllers\SystemProgram\Read::class                   , 'listar.programa'         ],
        ['POST'     , '/programa/editar'                        , Admin\Controllers\SystemProgram\Edit::class                   , 'editar.programa'         ],
        ['PUT'      , '/programa/[*:id]'                        , Admin\Controllers\SystemProgram\Update::class                 , 'atualizar.programa'      ],
        ['DELETE'   , '/programa/[*:id]'                        , Admin\Controllers\SystemProgram\Delete::class                 , 'excluir.programa'        ],
        ['GET'      , '/programa'                               , Admin\Controllers\SystemProgram\ProgramaAgrupado::class       , 'programa.agrupado'       ],
        ['GET'      , '/programa/menu'                          , Admin\Controllers\SystemProgram\MenuAcl::class                , 'programa.acl'            ],
        /*
        |-----------------------------------------------------------------------------------------------------------------------------------------------------
        |                                                    ROUTE FOR THE SYSTEM CONFIGURATIONS
        |-----------------------------------------------------------------------------------------------------------------------------------------------------
        */
        ['POST'     , '/configuracao'                           , Admin\Controllers\SystemConfiguration\CreateOrUpdate::class   , 'criar.configuracao'      ],
        ['GET'      , '/configuracao/[*:chave]/'                , Admin\Controllers\SystemConfiguration\Read::class             , 'exibir.configuracao'     ],
        /*
        |-----------------------------------------------------------------------------------------------------------------------------------------------------
        |                                                            ROUTE FOR THE ACL
        |-----------------------------------------------------------------------------------------------------------------------------------------------------
        */
        ['GET'      , '/secao/acl/'                             , Admin\Controllers\Secao\SecaoAcl::class                       , 'secao.acl'               ],
    ]    
];
