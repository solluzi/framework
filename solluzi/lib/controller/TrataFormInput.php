<?php

declare(strict_types=1);

namespace Solluzi\Lib\Controller;


class TrataFormInput
{
    private $input;
    public function input($input='')
    {
        $this->input = $input;
        return $this;
    }

    public function date2us($oldSeparator, $newSeparator, $datetime = false)
    {
        $date = str_replace($oldSeparator, $newSeparator, $this->input);
        $data = new \DateTime($date);
        if ($datetime) {
            $this->input = $data->format('Y-m-d H:i:s');
            return $this;
        }

        $this->input = $data->format('Y-m-d');
        return $this;
    }

    public function toNumber()
    {
        $this->input = preg_replace('/[^0-9]/', '', $this->input);
        return $this;
    }

    public function toUpper()
    {
        $this->input = strtoupper($this->input);
        return $this;
    }

    public function toLower()
    {
        $this->input = strtolower($this->input);
        return $this;
    }

    public function toUcFirst()
    {
        $this->input = ucfirst($this->input);
        return $this;
    }

    public function toTrim()
    {
        $this->input = trim($this->input);
        return $this;
    }

    public function toPrintThis()
    {
        var_dump($this);
    }

    public function toArray($separator)
    {
        $this->input = explode($separator, $this->input);
        return $this;
    }

    public function toJson()
    {
        $this->input = json_encode($this->input);
        return $this->input;
    }

    public function toString()
    {
        return $this->input;
    }
}