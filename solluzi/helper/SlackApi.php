<?php
declare(strict_types=1);
namespace App\Helper;

/**
 * O Adaptee é uma classe útil, incompatível com a interface Target. Vocês
 * não pode simplesmente entrar e mudar o código da classe para seguir o alvo
 * interface, já que o código pode ser fornecido por uma biblioteca de terceiros.
 */
class SlackApi
{
    private $login;
    private $apiKey;

    public function __construct(string $login, string $apiKey)
    {
        $this->login  = $login;
        $this->apiKey = $apiKey;
    }

    public function login(): void
    {
        // solicita authenticação ao webservice do Slack
        echo "Logado na conta do Slack '{$this->login}'\n";
    }

    public function sendMessage(string $chatId, string $message): void
    {
        // Envia a mensagem para o webservice do slack
        echo "Enviado a seguinte mensagem ao '$chatId' chat: '$message'.\n";
    }
}