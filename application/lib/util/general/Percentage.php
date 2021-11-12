<?php
declare(strict_types=1);

namespace General;

/**
 * @author Name <email@email.com>
 * @package category
 * @license MIT
 */
final class Percentage
{
    /* echo "Quanto é 11% de 22: <b>" . porcentagem_xn(11, 22) . "</b> rn <br>";
     * echo "Quanto é 22% de 11: <b>" . porcentagem_xn(22, 11) . "</b> rn <br>";
     * echo "Quanto é 99% de 100: <b>" . porcentagem_xn(99, 100) . "</b> rn <br>";
     * echo "Quanto é 99% de 105: <b>" . porcentagem_xn(99, 105) . "</b> rn <br>";
     * echo "Quanto é 201% de 105: <b>" . porcentagem_xn(201, 105) . "</b> rn <br>"; 
     */
    public static function howMuchIsXPercentOfN(float $porcentagem, float $total): float
    {
        return ($porcentagem / 100) * $total;
    }

    /**
     * Método de porcentagem: N é X% de N
     * echo "2.42 é <b>" . porcentagem_nx(2.42, 22) . "%</b> de 22.rn <br>";
     * echo "2.42 é <b>" . porcentagem_nx(2.42, 11) . "%</b> de 11.rn <br>";
     * echo "99 é <b>" . porcentagem_nx(99, 100) . "%</b> de 100.rn <br>";
     * echo "103.95 é <b>" . porcentagem_nx(103.95, 105) . "%</b> de 105.rn <br>";
     * echo "211.05 é <b>" . porcentagem_nx(211.05, 105) . "%</b> de 105.rn <br>";
     * @return void
     */
    public static function nIsXPercentOfN(float $valor, float $total) : float
    {
        return ($valor * 100) / $total;
    }

    /**
     * Método de porcentagem: N é N% de X
     * echo "2.42 é 11% de <b> "   . nIsNPercentOfX ( 2.42, 11 ) . "</b></b>.rn <br>";
     * echo "2.42 é  22% de <b>"   . nIsNPercentOfX ( 2.42, 22 ) . "</b></b>.rn <br>";
     * echo "99 é 100% de <b>  "   . nIsNPercentOfX ( 99, 100 ) . "</b></b>.rn <br>";
     * echo "103.95 é  99% de <b>" . nIsNPercentOfX ( 103.95, 99 ) . "</b></b>.rn <br>";
     * echo "2.42 é 11% de <b> "   . nIsNPercentOfX ( 211.05, 201 ) . "</b></b>.rn <br>";
     * echo "337799 é 70% de <b>"  . nIsNPercentOfX ( 337799, 70 ) . "</b></b>.rn <br>";
     * @return void
     */
    public static function nIsNPercentOfX(float $parcial, float $porcentagem): float
    {
        return ($parcial / $porcentagem) * 100;
    }

    /**
     * Undocumented function
     *
     * @param float $value
     * @param float $discountPercent
     * @return float
     */
    public function calculateDiscount(float $value, float $discountPercent): float
    {
        $result = $value - ($value * $discountPercent / 100);
        return $result;
    }
}
