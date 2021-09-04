<?php
declare(strict_types=1);
namespace App\Examples;

use App\Helper\EmailNotification;
use App\Helper\SlackApi;
use App\Helper\SlackNotification;
use App\Interface\Notification;

/**
 * O código do cliente pode funcionar com qualquer classe que siga a interface Target.
 */
function clientCode(Notification $notification)
{
    echo $notification->send("Website is down!",
    "<strong style='color:red;font-size: 50px;'>Alert!</strong> " .
    "Our website is not responding. Call admins and bring it up!");
}

echo "O código do cliente foi projetado corretamente e funciona com notificações por e-mail:\n";
$notification = new EmailNotification("developers@example.com");
clientCode($notification);
echo "\n\n";

echo "O mesmo código do cliente pode funcionar com outras classes via adaptador:\n";
$slackApi = new SlackApi("example.com", "**************");
$notification = new SlackNotification($slackApi, "Example.com developers");
clientCode($notification);