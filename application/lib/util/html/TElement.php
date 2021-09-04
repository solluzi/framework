<?php
declare (strict_types = 1);
namespace HTML;

/**
 * Classe TElement
 * Classe para construção de tags HTML
 */
class TElement
{
    private $name;          // nome da TAG
    private $properties;    // propriedades da TAG
    private $children;      // conteúdo da TAG

    /**
     * método construtor
     * instancia uma tag html
     * @param $name nome da tag
     */
    public function __construct($name)
    {
        // define o nome do elemento
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
        // armazena os valores atribuidos
        // ao array properties
        $this->properties[$name] = $value;
    }

    /**
     * método add()
     * Adiciona um elemento filho
     * @param $child objeto filho
     */
    public function add($child)
    {
        $this->children[] = $child;
    }

    /**
     * método open()
     * Exibe a tag de abertura na tela
     */
    private function open()
    {
        // exibe a tag de abertura na tela
        echo "<{$this->name}";
        if ($this->properties) {
            // percorre as propriedades
            foreach ($this->properties as $name => $value) {
                echo " {$name}=\"{$value}\"";
            }
        }
        echo '>';
    }

    /**
     * método show()
     * Exibe a tag na tela, junstamente com seu conteudo
     */
    public function show()
    {
        // abre a tag
        $this->open();
        echo "\n";
        // se possui conteudo
        if ($this->children) {
            // percorre todos os objetos filhos
            foreach ($this->children as $child) {
                // se for objeto
                if (is_object($child)) {
                    $child->show();
                } elseif ((is_string($child)) or (is_numeric($child))) {
                    // se for texto
                    echo $child;
                }
            }
            // fecha a tag
            $this->close();
        }
    }

    /**
     * método close()
     * Fecha uma TAG HTML
     */
    private function close()
    {
        echo "</{$this->name}>\n";
    }
}
