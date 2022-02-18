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
 * Programa
 *  Connects to controlador Table
 */

declare(strict_types=1);

namespace Admin\Model;

use Solluzi\Database\Model\Model;

class Program extends Model
{
    public $table      = '"SYSTEM_PROGRAM"';
    public $primaryKey = '"ID"';
    public $idPolicy   = "uuid";         //{max,serial,auto,uuid}


    public function adicionarProgramaAoGrupo($grupos, $controlador)
    {
        $this->excluirProgramaDoGrupo($controlador);

        if ($grupos) {
            foreach ($grupos as $grupo) {
                $info = ['"GROUP_ID"' => $grupo, '"PROGRAM_ID"' => $controlador];
                $programaGrupoModel = new SystemGroupProgram();
                $programaGrupoModel->database('system')
                    ->insert($info)
                    ->execute();
            }
        }
    }


    public function excluirProgramaDoGrupo($controlador)
    {

        $programaGrupoModel = new SystemGroupProgram();
        $programaGrupoModel->database('system')
            ->delete()
            ->where('"PROGRAM_ID"', $controlador)
            ->execute();
    }
}
