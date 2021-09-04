<?php


use Phinx\Seed\AbstractSeed;

class InsertGroupProgram extends AbstractSeed
{
    public function run()
    {
        // Busca o Grupo
        $sqlGrupo = $this->query("SELECT id FROM system_group WHERE name='Webmaster' LIMIT 1");
        $lnGrupo  = $sqlGrupo->fetch(PDO::FETCH_OBJ);

        // Busca Programas
        $sqlPrograma  = $this->query("SELECT id FROM system_program");
        $lnsProgramas = $sqlPrograma->fetchAll(PDO::FETCH_OBJ);
        
        if(($lnGrupo) && ($lnsProgramas)){
            
            foreach($lnsProgramas as $value){
                $sql = "INSERT INTO system_group_program (group_id, program_id) 
                            SELECT
                                '{$lnGrupo->id}', 
                                '{$value->id}'
                            WHERE
                                NOT EXISTS(SELECT * FROM system_group_program WHERE group_id = '$lnGrupo->id' AND program_id = '$value->id')";
                $stmt = $this->query($sql);
                $stmt->execute();
            }
        }
        
    }
}
