<?php
declare (strict_types = 1);

namespace General;

/**
 * Undocumented class
 */
final class Date
{

    /**
     * Transform date from Brazilian format to Us
     *
     * @param [type] $value
     * @return string
     */
    public static function date2br($value, $datetime = false): string
    {
        $tratado = str_replace('/', '-', $value);
        $data = new \DateTime($tratado);
        if ($datetime) {
            $result = $data->format('d/m/Y H:i:s');
            return $result;
        }

        $result = $data->format('d/m/Y');
        return $result;
    }

    /**
     * Transform date from Us form to Brazilian
     *
     * @param [type] $value
     * @return string
     */
    public static function date2us($value, $datetime = false): string
    {
        $date = str_replace('/', '-', $value);
        $data = new \DateTime($date);
        if ($datetime) {
            $result = $data->format('Y-m-d H:i:s');
            return $result;
        }

        $result = $data->format('Y-m-d');
        return $result;
    }
}
