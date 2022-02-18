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

use Solluzi\Database\Model\Model;

class Group extends Model
{
    protected $table      = '"SYSTEM_GROUP"';
    protected $primaryKey = '"ID"';
    protected $idPolicy   = "uuid"; // {max, serial, auto, uuid}

    public function adicionarGrupoAoPrograma($programas, $grupo)
    {
        $this->excluirProgramaDoGrupo($grupo);

        if ($programas) {
            foreach ($programas as $programa) {
                $info = ['"GROUP_ID"' => $grupo, '"PROGRAM_ID"' => $programa];
                $programaGrupoModel = new SystemGroupProgram();
                $programaGrupoModel->database('system')
                    ->insert($info)
                    ->execute();
            }
        }
    }


    public function excluirProgramaDoGrupo($grupo)
    {

        $programaGrupoModel = new SystemGroupProgram();
        $programaGrupoModel->database('system')
            ->delete()
            ->where('"GROUP_ID"', $grupo)
            ->execute();
    }

    public function adicionarUsuarioAoGrupo($usuarios, $grupo)
    {

        $this->excluirUsuarioDoGrupo($grupo);

        if ($usuarios) {
            foreach ($usuarios as $usuario) {
                $info = ['"GROUP_ID"' => $grupo, '"USER_ID"' => $usuario];
                $programaGrupoModel = new SystemUserGroup();
                $programaGrupoModel->database('system')
                    ->insert($info)
                    ->execute();
            }
        }
    }


    public function excluirUsuarioDoGrupo($grupo)
    {

        $programaGrupoModel = new SystemUserGroup();
        $programaGrupoModel->database('system')
            ->delete()
            ->where('"GROUP_ID"', $grupo)
            ->execute();
    }
}
