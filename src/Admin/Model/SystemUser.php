<?php

/**
 * @version     1.0.0
 * @category    Model
 * @package     App
 * @subpackage  User
 * @author      Mauro Joaquim Miranda
 * @copyright   Copyright (c) 2020 Solluzi Tecnologia da Informação LTDA-ME. (https://mauromiranda.dev)
 * @license     https://mauromiranda.dev/framework-license
 *
 * SystemUser
 *  connects to system_user table used for account
 */

declare(strict_types=1);

namespace Admin\Model;

use Model\Model;

class SystemUser extends Model
{
    protected $table      = '"SYSTEM_USER"';
    protected $primaryKey = '"ID"';
    protected $idPolicy   = "uuid"; // {max, serial, auto, uuid}

     /**
     * Integra o usuário a um grupo de acesso
     *
     * @param object $dados
     * @param string $usuario
     * @return void
     */
    public function inserirGrupoAoUsuario(object $dados, string $usuario): void
    {
        $this->excluirUsuarioDoGrupo($usuario);

        if ($dados) {
            foreach ($dados as $dado) {
                $info = [
                    '"USER_ID"'  => $usuario,
                    '"GROUP_ID"' => $dado
                ];
                $usuarioGrupoQuery  = new SystemUserGroup();
                $usuarioGrupoInsert = $usuarioGrupoQuery->database('system');
                $usuarioGrupoInsert->insert($info)->execute();
            }
        }
    }

    /**
     * Remove o usuário do grupo ao qual ele está atrelado
     *
     * @param string $usuario
     * @return void
     */
    public function excluirUsuarioDoGrupo(string $usuario): void
    {
        $usuarioGrupoQuery  = new SystemUserGroup();
        $usuarioGrupoDelete = $usuarioGrupoQuery->database('system');
        $usuarioGrupoDelete
            ->delete()
            ->where('"USER_ID"', $usuario)
            ->execute();
    }
}
