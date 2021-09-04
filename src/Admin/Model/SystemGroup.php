<?php

/**
 * @version     1.0.0
 * @category    Model
 * @package     App
 * @subpackage  Group
 * @author      Mauro Joaquim Miranda
 * @copyright   Copyright (c) 2020 Solluzi Tecnologia da Informação LTDA-ME. (https://mauromiranda.dev)
 * @license     https://mauromiranda.dev/framework-license
 *
 * SystemGroup
 *  Connects to system_group Table
 */

declare(strict_types=1);

namespace Admin\Model;

use Model\Model;

class SystemGroup extends Model
{
    protected $table      = "system_group";
    protected $primaryKey = "id";
    protected $idPolicy   = "uuid"; // {max, serial, auto, uuid}

    public function adicionarGrupoAoPrograma($programas, $grupo)
    {
        $this->excluirProgramaDoGrupo($grupo);

        if ($programas) {
            foreach ($programas as $programa) {
                $info = ['grupo' => $grupo, 'programa' => $programa];
                $programaGrupoModel = new SystemGroupProgram();
                $programaGrupoModel->start('system')
                    ->insert($info)
                    ->execute();
            }
        }
    }


    public function excluirProgramaDoGrupo($grupo)
    {

        $programaGrupoModel = new SystemGroupProgram();
        $programaGrupoModel->start('system')
            ->delete()
            ->where('grupo', $grupo)
            ->execute();
    }

    public function adicionarUsuarioAoGrupo($usuarios, $grupo)
    {

        $this->excluirUsuarioDoGrupo($grupo);

        if ($usuarios) {
            foreach ($usuarios as $usuario) {
                $info = ['grupo' => $grupo, 'usuario' => $usuario];
                $programaGrupoModel = new SystemGroupProgram();
                $programaGrupoModel->start('system')
                    ->insert($info)
                    ->execute();
            }
        }
    }


    public function excluirUsuarioDoGrupo($grupo)
    {

        $programaGrupoModel = new SystemUserGroup();
        $programaGrupoModel->start('system')
            ->delete()
            ->where('grupo', $grupo)
            ->execute();
    }
}
