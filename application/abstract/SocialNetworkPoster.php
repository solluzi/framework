<?php
declare(strict_types=1);
namespace Application\Abstract;

use Application\Interface\SocialNetworkConnector;

/**
 * O Criador um factory method que pode ser usado como susbstituto
 * para chamadas diretas do construtor de um produto:
 * 
 * - Antes: $p = new FacebookConnector();
 * - Atual: $p->getSocialNetwork();
 * 
 * Dessa forma é permitido alterar o tipo de produto
 * a ser criado por subclasses de SocialNetworkPosters
 */
abstract class SocialNetworkPoster
{
    /*
    |--------------------------------------------------------------------
    | O metodo Factory atual. Retorna o conector abstrato.
    |--------------------------------------------------------------------
    |
    | Permite as subclasses retornarem qualquer conector sem 
    | quebrar o contrato da superclasse.
    |
    */
    abstract public function getSocialNetwork(): SocialNetworkConnector;

    /*
    |--------------------------------------------------------------------
    | Quando o factory method 
    |--------------------------------------------------------------------
    |
    | é usando dentro do criador da
    | logica da regra de negócios, as subclasses podem
    | alterar inderamente a logica, ao retornar diferentes
    | tipos do conector do factory Method
    |
    */
    public function post($content): void
    {
        /*
        |---------------------------------------------------------------
        | Chama a factory method para criar o objeto do produto
        |---------------------------------------------------------------
        */
        $network = $this->getSocialNetwork();
        
        /*
        |---------------------------------------------------------------
        |.. então usa como desejar
        |---------------------------------------------------------------
        */
        $network->login();
        $network->createPost($content);
        $network->logout();
    }
}