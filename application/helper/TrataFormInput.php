<?php
declare(strict_types=1);
namespace App\Helper;

class TrataFormInput
{

    private $input;

    public function input($input)
    {
        $this->input = $input;
        return $this;
    }

    public function somenteNumero(): object
    {
        $this->input = preg_replace('/[^0-9]/', '', $this->input);
        return $this;
    }

    public function decimal(): object
    {
        $_f1 = str_replace(".", "", $this->input);
        $_f2 = str_replace(",", ".", $_f1);
        $this->input = $_f2;
        return $this;
    }
    

    public function date2us($datetime = false): object
    {
        $date = str_replace('/', '-', $this->input);
        $data = new \DateTime($date);
        if ($datetime) {
            $this->input = $data->format('Y-m-d H:i:s');
            return $this;
        }

        $this->input = $data->format('Y-m-d');
        return $this;
    }

    public function toString()
    {
        return $this->input;
    }
}