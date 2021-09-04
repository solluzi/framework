<?php
declare(strict_types=1);
namespace App\Examples;

use App\Abstract\SocialNetworkPoster;
use App\Helper\FacebookPoster;
use App\Helper\LinkedInPoster;

/**
 * O Código do cliente pode trabalhar com qualquer subclasse
 * do SocialNetworkPoster desde que não dependa da classe 
 * concreta
 */
function clientCode(SocialNetworkPoster $creator): void
{
    $creator->post("Olá Mundo");
    $creator->post("Faz tempo que não como mackdonalds");
}

/**
 * Durante a fase de inicialização, a aplicação pode escolher
 * qual rede social deseja trabalhar, cria um objeto da propria
 * subclasse, e passa para o código cliente
 */
echo "Testando o ConcreteCreator1:\n";
clientCode(new FacebookPoster("john_smith", "**********"));
echo "\n\n";

echo "Testando o ConcreteCreator2:\n";
clientCode(new LinkedInPoster("john_smith@example.com", "**********"));