<?php
// https://eltonminetto.dev/post/2018-08-01-monorepo-drone/
return [  
    /*
    |---------------------------------------------------------------------------------------------------------------------------------------------------------
    |                                                        ADMINISTRACTION SECTION OF THE ROUTE
    |---------------------------------------------------------------------------------------------------------------------------------------------------------
    */ 
    'main' => [
        ['GET'      , '/status'                                 , Admin\Controllers\SystemPublic\Status::class                  , 'status'                  ],
        ['POST'     , '/login'                                  , Admin\Controllers\SystemPublic\Login::class                   , 'login'                   ],
        ['GET'      , '/logout/'                                , Admin\Controllers\SystemPublic\Logout::class                  , 'logout'                  ],
        ['GET'      , '/home'                                   , Admin\Controllers\SystemPublic\Home::class                    , 'home'                    ], 
        ['POST'     , '/password/reset'                         , Admin\Controllers\SystemPublic\ChangePasswordRequest::class   , 'change.password.request' ], 
        ['POST'     , '/password/[*:token]/change'              , Admin\Controllers\SystemPublic\ChangePassword::class          , 'change.password'         ],
        ['GET'      , '/acl/[a:controller]/'                    , Admin\Controllers\SystemPublic\Acl::class                     , 'acl'                     ],
        /*
        |-----------------------------------------------------------------------------------------------------------------------------------------------------
        |                                                           ROUTE FOR THE LOGS
        |-----------------------------------------------------------------------------------------------------------------------------------------------------
        */
        ['POST'     , '/access-log/[i:page]/[i:by_page]'        , Admin\Controllers\SystemLog\AccessLog::class                  , 'access.log'              ], 
        ['POST'     , '/audit/[i:page]/[i:by_page]'             , Admin\Controllers\SystemLog\SqlLog::class                     , 'audit'                   ], 
        
        /*
        |-----------------------------------------------------------------------------------------------------------------------------------------------------
        |                                                           ROUTE FOR THE USER
        |-----------------------------------------------------------------------------------------------------------------------------------------------------
        */
        ['POST'     , '/user'                                   , Admin\Controllers\SystemUser\Create::class                    , 'user.create'             ],
        ['POST'     , '/user/[i:page]/[i:by_page]'              , Admin\Controllers\SystemUser\Read::class                      , 'user.list'               ],
        ['GET'      , '/user/[h:id]/edit'                       , Admin\Controllers\SystemUser\Edit::class                      , 'edit.user'               ],
        ['PUT'      , '/user/[h:id]/update'                     , Admin\Controllers\SystemUser\Update::class                    , 'user.update'             ],
        ['DELETE'   , '/user/[h:id]/delete'                     , Admin\Controllers\SystemUser\Delete::class                    , 'user.delete'             ],
        ['GET'      , '/user/[h:id]/status'                     , Admin\Controllers\SystemUser\ChangeStatus::class              , 'user.status.change'      ],

        /*
        |-----------------------------------------------------------------------------------------------------------------------------------------------------
        |                                                        ROUTE FOR USER PROFILE
        |-----------------------------------------------------------------------------------------------------------------------------------------------------
        */
        ['GET'      , '/profile/'                                , Admin\Controllers\UserProfile\Edit::class                    , 'edit.profile'            ],
        ['POST'     , '/profile'                                 , Admin\Controllers\UserProfile\Update::class                  , 'update.profile'          ],
        
        /*
        |-----------------------------------------------------------------------------------------------------------------------------------------------------
        |                                                       ROUTE FOR THE USER GROUPS
        |-----------------------------------------------------------------------------------------------------------------------------------------------------
        */
        ['POST'     , '/group'                                  , Admin\Controllers\SystemGroup\Create::class                   , 'group.create'            ],
        ['POST'     , '/group/[i:page]/[i:by_page]'             , Admin\Controllers\SystemGroup\Read::class                     , 'group.list'              ],
        ['GET'      , '/group/[h:id]/edit'                      , Admin\Controllers\SystemGroup\Edit::class                     , 'group.edit'              ],
        ['PUT'      , '/group/[h:id]/update'                    , Admin\Controllers\SystemGroup\Update::class                   , 'group.update'            ],
        ['DELETE'   , '/group/[h:id]/delete'                    , Admin\Controllers\SystemGroup\Delete::class                   , 'group.delete'            ],
        ['POST'     , '/group/programa'                         , Admin\Controllers\SystemGroup\GrupoEPrograma::class           , 'group.program'           ],
        /*
        |-----------------------------------------------------------------------------------------------------------------------------------------------------
        |                                                     ROUTE FOR THE PROGRAM SECTION
        |-----------------------------------------------------------------------------------------------------------------------------------------------------
        */
        ['POST'     , '/section'                                , Admin\Controllers\SystemSection\Create::class                 , 'section.create'          ],
        ['POST'     , '/section/[i:page]/[i:by_page]'           , Admin\Controllers\SystemSection\Read::class                   , 'section.list'            ],
        ['POST'     , '/section/[h:id]/edit'                    , Admin\Controllers\SystemSection\Edit::class                   , 'section.edit'            ],
        ['PUT'      , '/section/[h:id]/update'                  , Admin\Controllers\SystemSection\Update::class                 , 'section.update'          ],
        ['DELETE'   , '/section/[h:id]/delete'                  , Admin\Controllers\SystemSection\Delete::class                 , 'section.delete'          ],
        /*
        |-----------------------------------------------------------------------------------------------------------------------------------------------------
        |                                                      ROUTE FOR THE SYSTEM PROGRAM
        |-----------------------------------------------------------------------------------------------------------------------------------------------------
        */
        ['POST'     , '/program'                                , Admin\Controllers\SystemProgram\Create::class                 , 'program.create'          ],
        ['POST'     , '/program/[i:page]/[i:by_page]'           , Admin\Controllers\SystemProgram\Read::class                   , 'program.list'            ],
        ['POST'     , '/program/[h:id]/edit'                    , Admin\Controllers\SystemProgram\Edit::class                   , 'program.edit'            ],
        ['PUT'      , '/program/[h:id]/update'                  , Admin\Controllers\SystemProgram\Update::class                 , 'program.update'          ],
        ['DELETE'   , '/program/[h:id]/delete'                  , Admin\Controllers\SystemProgram\Delete::class                 , 'program.delete'          ],
        /*
        |-----------------------------------------------------------------------------------------------------------------------------------------------------
        |                                                    ROUTE FOR THE SYSTEM CONFIGURATIONS
        |-----------------------------------------------------------------------------------------------------------------------------------------------------
        */
        ['POST'     , '/configuration'                           , Admin\Controllers\SystemConfiguration\CreateOrUpdate::class   , 'config.create.update'   ],
        ['GET'      , '/configuration/[h:chave]/read'            , Admin\Controllers\SystemConfiguration\Read::class             , 'config.list'            ],
    ]    
];
