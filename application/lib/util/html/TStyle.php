<?php
declare (strict_types = 1);
namespace HTML;

/**
 * classe TStyle
 * classe para abstração de estilos CSS
 */
class TStyle
{
    private $name;          // nome do estilo
    private $properties;    // atributos
    private static $loaded; // array de estilos carregando

    /**
     * método construtor
     * instancia uma tag html
     * @param $name nome da TAG
     */
    public function __construct($name)
    {
        // atribui o nome estilo
        $this->name = $name;
    }

    /**
     * método __set()
     * intercepta as atribuições à propriedades do objeto
     * @param $name nome da propriedade
     * @param $value valor
     */
    public function __set($name, $value)
    {
        // substitui o "_" por "-" no nome da propriedade
        $name = str_replace('_', '-', $name);

        // armazena os valores atribuidos
        // ao array properties
        $this->properties[$name] = $value;
    }

    /**
     * método show()
     * Exibe a tag na tela
     */
    public function show()
    {
        // verifica se este estilo já foi carregado
        if (!isset(self::$loaded[$this->name])) {
            echo "<style type='text/css' media='screen'>\n";
            // exibe a abertura do estilo
            echo ".{$this->name}\n";
            echo "{\n";
            if ($this->properties) {
                // percorre as propriedades
                foreach ($this->properties as $name => $value) {
                    echo "\t {$name}: {$value};\n";
                }
            }
            echo "}\n";
            echo "</style>\n";
            // marca o estilo como já carregado
            self::$loaded[$this->name] = true;
        }
    }
}
