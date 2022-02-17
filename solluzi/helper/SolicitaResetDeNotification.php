<?php
declare(strict_types=1);
namespace App\Helper;

use Exception;
use PHPMailer\PHPMailer\PHPMailer;
use Solluzi\Interfaces\Notification;

/**
 * Aqui está um exemplo da classe existente que segue a interface Alvo.
 * 
 * A verdade é que muitos aplicativos reais podem não ter essa interface claramente definida.
 * Se você estiver naquele barco, sua melhor aposta seria estender o adaptador de um
 * das classes existentes do seu aplicativo. Se isso for estranho (por exemplo,
 * SlackNotification não parece uma subclasse de EmailNotification), então
 * extrair uma interface deve ser o primeiro passo.
 */
class SolicitaResetDeNotification implements Notification
{


    public function send(string $email, string $message)
    {
        $phpMailer = new PHPMailer();

        try{
            $configuracoesModel = new Configuracao;
            $infos = $configuracoesModel->start('system')
                ->select('', ['valor'])
                ->where('chave', 'smtp')
                ->get();

            
            $data = (isset($infos->valor)) ? json_decode($infos->valor) : null;

            if($data){
                
                // Informações de conexões
                $phpMailer->SMTPDebug  = 0;
                $phpMailer->isSMTP(true);
                $phpMailer->CharSet    = 'UTF-8';
                $phpMailer->Host       = $data->HOST;
                $phpMailer->SMTPAuth   = ($data->SMTP_AUTH == 'Y') ? true : false;
                $phpMailer->Username   = $data->USERNAME;
                $phpMailer->Password   = $data->PASSWORD;
                $phpMailer->SMTPSecure = $data->SMTP_SECURE;
                $phpMailer->Port       = $data->PORT;

                // Recipients
                $phpMailer->setFrom($data->FROM, $data->DOMAIN);
                $phpMailer->addAddress($email);
                
                // Content                
                $phpMailer->MsgHTML($message);
                $phpMailer->isHTML(true);
                $phpMailer->Subject = 'Solicitação de alteração de senha!';
                
                // Send
                if($phpMailer->send()){
                    return true;
                }
                
            }

        }catch(\Exception $e){
            return false;
        }
    }
}