<?php

declare(strict_types=1);

namespace Application\Interface;

interface IFormValidation
{
    public function _required($field);
    public function _alpha($field);
    public function _numeric($field);
    public function _alphaNumeric($field);
    public function _max($field);
    public function _min($field);
    public function _phone($field);
    public function _cellphone($field);
    public function _email($field);
    public function _cpf($field);
    public function _cnpj($field);
    public function _equal($field1 = null, $field2 = null);
}
