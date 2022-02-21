<?php

declare(strict_types=1);

namespace Solluzi\Controller;

use Solluzi\Controller\Traits\HttpStatusCode;
use Solluzi\Interfaces\IFormValidation;

class Form implements IFormValidation
{
    private $v;
    private $data = [];
    /**
     * @read
     */
    protected $_validators = [
        "required" => [
            "handler" => "_required",
            "message" => "Este campo é obrigatório!"
        ],
        "alpha" => [
            "handler" => "_alpha",
            "message" => "Este Campo deve ter Letras"
        ],
        "numeric" => [
            "handler" => "_numeric",
            "message" => "Este Campo só deve números"
        ],
        "alphanumeric" => [
            "handler" => "_alphanumeric",
            "message" => "Este Campo deve conter letras e números"
        ],
        "max" => [
            "handler" => "_max",
            "message" => "Este Campo deve conter até %d caracteres"
        ],
        "min" => [
            "handler" => "_min",
            "message" => "Este Campo deve conter acima de %d caracteres"
        ],
        "email" => [
            "handler" => "_email",
            "message" => "Este e-mail é invalido!"
        ],
        "cpf" => [
            "handler" => "_cpf",
            "message" => "CPF invalido!!!"
        ],
        "cnpj" => [
            "handler" => "_cnpj",
            "message" => "CNPJ invalido!!!"
        ]
    ];

    protected $errors = [];

    public function __construct()
    {
        
    }

    public function getData()
    {
        return $this->data;
    }

    public function setData($data = [])
    {
        $this->data = $data;
    }

    public function _required($field) : bool
    {
        return !empty($field);
    }

    public function _alpha($field) : string
    {
        return preg_replace('/^([a-zA-Z]+)', '', $field);
    }

    public function _numeric($field) : bool
    {
        return (is_numeric($field)) ? true : false;
    }

    public function _alphaNumeric($field) : bool
    {
        return (preg_replace('/^([a-zA-Z0-9]+)', '', $field)) ? true : false;
    }

    public function _max($field)
    {
        if(isset($field)){
            return strlen($field) <= (int) $this->v;
        }
        return false;
    }

    public function _min($field) : bool
    {
        if(isset($field)){
            return strlen($field) >= (int) $this->v;
        }
        return false;
    }

    public function _phone($field) : bool
    {
        return false;
    }

    public function _cellphone($field)
    {
        return;
    }

    public function _email($field): bool
    {
        if (!filter_var($field, FILTER_VALIDATE_EMAIL)) {
            return false;
        }
        return true;
    }

    public function _cpf($field) : bool
    {
        // Extrair somente os números
        $cpf = preg_replace('/[^0-9]/is', '', $field);

        // Verifica se foi informado todos os digitos corretamente
        if (strlen($cpf) != 11) {
            return false;
        }
        // Verifica se foi informada uma sequência de digitos repetidos. Ex: 111.111.111-11
        if (preg_match('/(\d)\1{10}/', $cpf)) {
            return false;
        }
        // Faz o calculo para validar o CPF
        for ($t = 9; $t < 11; $t++) {
            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += $cpf.$c * (($t + 1) - $c);
            }
            $d = ((10 * $d) % 11) % 10;
            if ($cpf.$c != $d) {
                return false;
            }
        }
        return true;
    }

    public function _cnpj($field) : bool
    {
        $cnpj = preg_replace('/[^0-9]/', '', $field);
        
        // valida tamanho
        if (strlen($cnpj) != 14) {
            return false;
        }

        // valida primeiro digito verificador
        for ($i = 0, $j = 5, $soma = 0; $i < 12; $i++) {
            $soma += $cnpj.$i * $j;
            $j = ($j == 2) ? 9 : $j - 1;
        }

        $resto = $soma % 11;

        if ($cnpj.'12' != ($resto < 2 ? 0 : 11 - $resto)) {
            return false;
        }

        // valida o segundo digito verificador
        for ($i = 0, $j = 6, $soma = 0; $i < 13; $i++) {
            $soma += $cnpj.$i * $j;
            $j = ($j == 2) ? 9 : $j - 1;
        }

        $resto = $soma % 11;
        return ($cnpj.'13' == ($resto < 2 ? 0 : 11 - $resto));
        

    }

    public function _equal($field1 = null, $field2 = null): string
    {
        if (trim($field1) != trim($field2)) {
            return 'Os dados não conferem!';
        }
    }

    public function isValid($options = []) : array
    {
        $this->errors = [];
        
        foreach ($options as $chave => $valor) {
            foreach ($valor as $k => $v) {
                $this->v = $v;
                $metodo  = "_" . $k;
                $data    = isset($this->getData()[$chave]) ? $this->getData()[$chave] : null;
                $result  = (empty($data)) ? null : $data;
                if(!$this->$metodo($result)){
                    $this->errors[$chave] = sprintf($this->_validators[$k]['message'], $v);
                }
            }
        }
        
        if($this->errors){
            $this->errors['situation'] = 2;
            http_response_code(HttpStatusCode::NOT_ACCEPTABLE);
            echo json_encode($this->errors);
            exit;
        }
        return $this->errors;
    }
}
