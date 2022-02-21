<?php
declare(strict_types=1);
namespace App\Helper;

use Solluzi\Interfaces\Notification;

/**
 * O Adaptador é uma classe que vincula a interface Target e a classe Adaptee.
 * Nesse caso, permite que o aplicativo envie notificações usando o Slack
 * API.
 */
class SlackNotification implements Notification
{
    private $slack;
    private $chatId;

    public function __construct(SlackApi $slack, string $chatId)
    {
        $this->slack = $slack;
        $this->chatId = $chatId;
    }

    /**
     * Um adaptador não é apenas capaz de adaptar interfaces, mas também pode
     * converter os dados de entrada para o formato exigido pelo Adaptee.
     */
    public function send(string $title, string $message): void
    {
        $slackMessage = "#" . $title . "# " . strip_tags($message);
        $this->slack->login();
        $this->slack->sendMessage($this->chatId, $slackMessage);
    }
}