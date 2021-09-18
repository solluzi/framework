<?php


use Phinx\Seed\AbstractSeed;

class InsertGroupProgram extends AbstractSeed
{
    public function run()
    {
        // Busca o Grupo
        $sqlGrupo = $this->query('SELECT "ID" FROM "SYSTEM_GROUP" WHERE "NAME"=\'Webmaster\' LIMIT 1');
        $lnGrupo  = $sqlGrupo->fetch(PDO::FETCH_OBJ);

        // Busca Programas
        $sqlPrograma  = $this->query('SELECT "ID" FROM "SYSTEM_PROGRAM"');
        $lnsProgramas = $sqlPrograma->fetchAll(PDO::FETCH_OBJ);
        
        if(($lnGrupo) && ($lnsProgramas)){
            
            foreach($lnsProgramas as $value){
                $sql = "INSERT INTO \"SYSTEM_GROUP_PROGRAM\" (\"GROUP_ID\", \"PROGRAM_ID\") 
                            SELECT
                                '{$lnGrupo->ID}', 
                                '{$value->ID}'
                            WHERE
                                NOT EXISTS(SELECT * FROM \"SYSTEM_GROUP_PROGRAM\" WHERE \"GROUP_ID\" = '$lnGrupo->ID' AND \"PROGRAM_ID\" = '$value->ID')";
                $stmt = $this->query($sql);
                $stmt->execute();
            }
        }
        
    }
}
