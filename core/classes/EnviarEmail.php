<?php

namespace core\classes;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class EnviarEmail
{

    //================================================================================================
    public function enviar_email_confirmacao_novo_cliente($email_cliente, $purl)
    {


        //Envia um email para o novo cliente para confirmar o email

        //construção do link para validar email

        $link = BASE_URL_CLIENTE . '?q=confirmar_email&purl=' . $purl;
        $mail = new PHPMailer(true);

        try {
            // opções servidor
            $mail->SMTPDebug = SMTP::DEBUG_OFF;
            $mail->isSMTP();
            $mail->Host       = EMAIL_HOST;
            $mail->SMTPAuth   = true;
            $mail->Username   = EMAIL_FROM;
            $mail->Password   = EMAIL_PASS;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = EMAIL_PORT;
            $mail->CharSet    = "UTF-8";

            // emisor e recetor
            $mail->setFrom(EMAIL_FROM, APP_NAME);
            $mail->addAddress($email_cliente);


            //Attachments
            //$mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
            //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

            // assunto
            $mail->isHTML(true);
            $mail->Subject = APP_NAME . ' - Confirmação de email.';

            //mensagem
            $html = '<p>Seja bem-vindo à nossa loja' . APP_NAME . '</p>';
            $html .= '<p>Para poder entrar na nossa loja, necessita confirmar o seu email.</p>';
            $html .= '<p>Para confirmar o email, click no link abaixo:</p>';
            $html .= '<p><a href="' . $link . '">Confirmar Email</a></p>';
            $html .= '<p><i><small>' . APP_NAME . '</small></i></p>';

            $mail->Body = $html;


            $mail->send();

            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    //================================================================================================

    public function enviar_email_confirmacao_encomenda($email_cliente, $dados_encomenda)
    {
        //Envia um email de confrimação da encomanda com dados de pagamento

        //construção do link para validar email


        $mail = new PHPMailer(true);

        try {
            // opções servidor
            $mail->SMTPDebug = SMTP::DEBUG_OFF;
            $mail->isSMTP();
            $mail->Host       = EMAIL_HOST;
            $mail->SMTPAuth   = true;
            $mail->Username   = EMAIL_FROM;
            $mail->Password   = EMAIL_PASS;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = EMAIL_PORT;
            $mail->CharSet    = "UTF-8";

            // emisor e recetor
            $mail->setFrom(EMAIL_FROM, APP_NAME);
            $mail->addAddress($email_cliente);
            $mail->addAddress(EMAIL_FROM);



            //Attachments
            //$mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
            //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

            // assunto
            $mail->isHTML(true);
            $mail->Subject = APP_NAME . ' - Confirmação da encomanda - ' . $dados_encomenda['dados_pagamento']['codigo_encomenda'] . '.';

            //mensagem
            $html = '<p>Este email serve para confirmar a sua encomenda.</p>';
            $html .= '<h3>DADOS DA ENCOMENDA:</h3>';

            //lista dos produtos

            $html .= '<ul>';
            foreach ($dados_encomenda['lista_produtos'] as $produto) {
                $html .= "<li>$produto</li>";
            }
            $html .= '</ul>';

            //total

            $html .= '<p>Total: <strong>' . $dados_encomenda['total_encomenda'] . '</strong></p>';

            // dados pagamento
            $html .= '<hr>';
            $html .= "<h3>PAGAMENTO</h3>";
            $html .= "<p>Por favor dirija-se a sua aréa de cliente > encomendas, ao aceder aos detalhes da encomenda onde poderá realizar o pagamento desta encomenda. </strong></p>";
            $html .= "<p>Código da encomenda : <strong>" . $dados_encomenda['dados_pagamento']['codigo_encomenda'] . "</strong></p>";
            $html .= "<p>Com os melhores cumprimentos.</p>";
            $html .= '<hr>';
            $html .= APP_NAME;

            //nota importante

            $html .= '<p>NOTA : A sua encomenda só será processada após pagamento. </p>';


            $mail->Body = $html;


            $mail->send();

            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    //================================================================================================
    public function email_encomenda_enviada($email_cliente, $dados_encomenda)
    {

        //Envia um email de confrimação de encomanda enviada

        //construção do link para validar email


        $mail = new PHPMailer(true);

        try {
            // opções servidor
            $mail->SMTPDebug = SMTP::DEBUG_OFF;
            $mail->isSMTP();
            $mail->Host       = EMAIL_HOST;
            $mail->SMTPAuth   = true;
            $mail->Username   = EMAIL_FROM;
            $mail->Password   = EMAIL_PASS;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = EMAIL_PORT;
            $mail->CharSet    = "UTF-8";

            // emisor e recetor
            $mail->setFrom(EMAIL_FROM, APP_NAME);
            $mail->addAddress($email_cliente);
            $mail->addAddress(EMAIL_FROM);



            //Attachments
            //$mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
            //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

            // assunto
            $mail->isHTML(true);
            $mail->Subject = APP_NAME . " - Encomenda " . $dados_encomenda['dados_encomenda']->status . " - " . $dados_encomenda['dados_encomenda']->codigo_encomenda . '.';

            //mensagem
            $html = '<h3>ENCOMENDA ENVIADA:</h3>';
            $html .= '<hr>';
            $html .= '<p>Este email serve para confirmar que a sua encomenda foi enviada com sucesso.</p>';
            $html .= '<p>Mais uma vez agradeçemos que tenha escolhido os nossos serviços.</p>';
            $html .= '<p>Volte sempre.</p>';
            $html .= '<hr>';
            $html .= '<strong>Mercearia Online</strong>';




            $mail->Body = $html;


            $mail->send();

            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    //================================================================================================
    public function email_encomenda_cancelada($email_cliente, $dados_encomenda)
    {

        //Envia um email de confrimação de encomanda enviada

        //construção do link para validar email


        $mail = new PHPMailer(true);

        try {
            // opções servidor
            $mail->SMTPDebug = SMTP::DEBUG_OFF;
            $mail->isSMTP();
            $mail->Host       = EMAIL_HOST;
            $mail->SMTPAuth   = true;
            $mail->Username   = EMAIL_FROM;
            $mail->Password   = EMAIL_PASS;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = EMAIL_PORT;
            $mail->CharSet    = "UTF-8";

            // emisor e recetor
            $mail->setFrom(EMAIL_FROM, APP_NAME);
            $mail->addAddress($email_cliente);
            $mail->addAddress(EMAIL_FROM);



            //Attachments
            //$mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
            //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

            // assunto
            $mail->isHTML(true);
            $mail->Subject = APP_NAME . " - Encomenda " . $dados_encomenda['dados_encomenda']->status . " - " . $dados_encomenda['dados_encomenda']->codigo_encomenda . '.';

            //mensagem
            $html = '<h3>ENCOMENDA CANCELADA:</h3>';
            $html .= '<hr>';
            $html .= '<p>Este email serve para confirmar que a sua encomenda foi cancelada com sucesso.</p>';
            $html .= '<p>Ficamos tristes, mas agradeçemos a sua escolha pelos os nossos serviços.</p>';
            $html .= '<p>Volte sempre.</p>';
            $html .= '<hr>';
            $html .= '<strong>Mercearia Online</strong>';




            $mail->Body = $html;


            $mail->send();

            return true;
        } catch (Exception $e) {
            return false;
        }
    }
    //================================================================================================
    public function email_mudanca_estado($email_cliente, $dados_encomenda)
    {

        //Envia um email de confrimação de encomanda enviada

        //construção do link para validar email


        $mail = new PHPMailer(true);

        try {
            // opções servidor
            $mail->SMTPDebug = SMTP::DEBUG_OFF;
            $mail->isSMTP();
            $mail->Host       = EMAIL_HOST;
            $mail->SMTPAuth   = true;
            $mail->Username   = EMAIL_FROM;
            $mail->Password   = EMAIL_PASS;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = EMAIL_PORT;
            $mail->CharSet    = "UTF-8";

            // emisor e recetor
            $mail->setFrom(EMAIL_FROM, APP_NAME);
            $mail->addAddress($email_cliente);
            $mail->addAddress(EMAIL_FROM);



            //Attachments
            //$mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
            //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

            // assunto
            $mail->isHTML(true);
            $mail->Subject = APP_NAME . " - Encomenda " . $dados_encomenda['dados_encomenda']->status . " - " . $dados_encomenda['dados_encomenda']->codigo_encomenda . '.';

            //mensagem
            $html = "<h3>ENCOMENDA " . $dados_encomenda['dados_encomenda']->status . ":</h3>";
            $html .= '<hr>';
            $html .= "<p>Este email serve para confirmar que a sua encomenda foi alterada para " . $dados_encomenda['dados_encomenda']->status . ".</p>";
            $html .= '<p>Agradeçemos a sua escolha pelos os nossos serviços.</p>';
            $html .= '<p>Com os melhores cumprimentos.</p>';
            $html .= '<hr>';
            $html .= '<strong>Mercearia Online</strong>';




            $mail->Body = $html;


            $mail->send();

            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    //================================================================================================

    public function enviar_pdf_encomenda_para_cliente($email_cliente, $ficheiro_pdf)
    {


        $mail = new PHPMailer(true);

        try {
            // opções servidor
            $mail->SMTPDebug = SMTP::DEBUG_OFF;
            $mail->isSMTP();
            $mail->Host       = EMAIL_HOST;
            $mail->SMTPAuth   = true;
            $mail->Username   = EMAIL_FROM;
            $mail->Password   = EMAIL_PASS;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = EMAIL_PORT;
            $mail->CharSet    = "UTF-8";

            // emisor e recetor
            $mail->setFrom(EMAIL_FROM, APP_NAME);
            $mail->addAddress($email_cliente);
            $mail->addAddress(EMAIL_FROM);



            //Attachments
            $mail->addAttachment('../../pdfs/' . $ficheiro_pdf);         //Add attachments
            //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

            // assunto
            $mail->isHTML(true);
            $mail->Subject = APP_NAME . ' - Documento com detalhes da encomenda.';

            //mensagem

            $html = '<p>Segue em anexo um PDF com os detalhes da sua encomenda.</p>';
            $html .= '<p>Com os melhores cumprimentos.</p>';
            $html .= '<hr>';
            $html .= '<strong>' . APP_NAME . '</strong>';




            $mail->Body = $html;


            $mail->send();

            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    //================================================================================================

    public function enviar_email_dados_pagamento($email_cliente, $dados_encomenda)
    {
        //Envia um email de confrimação da encomanda com dados de pagamento

        //construção do link para validar email


        $mail = new PHPMailer(true);

        try {
            // opções servidor
            $mail->SMTPDebug = SMTP::DEBUG_OFF;
            $mail->isSMTP();
            $mail->Host       = EMAIL_HOST;
            $mail->SMTPAuth   = true;
            $mail->Username   = EMAIL_FROM;
            $mail->Password   = EMAIL_PASS;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = EMAIL_PORT;
            $mail->CharSet    = "UTF-8";

            // emisor e recetor
            $mail->setFrom(EMAIL_FROM, APP_NAME);
            $mail->addAddress($email_cliente);
            $mail->addAddress(EMAIL_FROM);



            //Attachments
            //$mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
            //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

            // assunto
            $mail->isHTML(true);
            $mail->Subject = APP_NAME . ' - Dados para pagamento - ' . $dados_encomenda['dados_encomenda']['dados_encomenda']->codigo_encomenda . '.';

            //mensagem
            $html = '<p>Este email contem os dados para pagamento por transferência bancária.</p>';



            // dados pagamento
            $html .= '<hr>';
            $html .= "<h3>DADOS DE PAGAMENTO</h3>";
            $html .= "<p>Entidade: 23456 </strong></p>";
            $html .= "<p>Referencias : <strong>234 332 456</strong></p>";
            $html .= '<p>Valor: <strong>' . number_format($dados_encomenda['total_encomenda'], 2, ',', '.')  . '€</strong></p>';
            $html .= "<p>Com os melhores cumprimentos.</p>";
            $html .= '<hr>';
            $html .= APP_NAME;

            //nota importante

            $html .= '<p>NOTA : A sua encomenda só será processada após pagamento. </p>';


            $mail->Body = $html;


            $mail->send();

            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    //================================================================================================
    public function enviar_email_com_nova_password($email_cliente, $nova_password)
    {

        //Envia um email para o novo cliente para confirmar o email

        //construção do link para validar email

        $link = BASE_URL_CLIENTE . '?q=login';
        $mail = new PHPMailer(true);

        try {
            // opções servidor
            $mail->SMTPDebug = SMTP::DEBUG_OFF;
            $mail->isSMTP();
            $mail->Host       = EMAIL_HOST;
            $mail->SMTPAuth   = true;
            $mail->Username   = EMAIL_FROM;
            $mail->Password   = EMAIL_PASS;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = EMAIL_PORT;
            $mail->CharSet    = "UTF-8";

            // emisor e recetor
            $mail->setFrom(EMAIL_FROM, APP_NAME);
            $mail->addAddress($email_cliente);


            //Attachments
            //$mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
            //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

            // assunto
            $mail->isHTML(true);
            $mail->Subject = APP_NAME . ' - Recuperação de Password.';

            //mensagem
            $html = '<p>Este email contem a sua nova password.</p>';
            $html .= '<p>Após aceder a sua conta com esta password, pode fazer a alteração da mesma na sua área de cliente.</p>';
            $html .= '<p>Email: ' . $email_cliente . '</p>';
            $html .= '<p>Nova Password: ' . $nova_password . '</p>';
            $html .= '<p>Pressione o link para ser redirecionado para a nossa página de login.</p>';
            $html .= '<p><a href="' . $link . '">Realizar login.</a></p>';
            $html .= '<p><i><small>' . APP_NAME . '</small></i></p>';

            $mail->Body = $html;


            $mail->send();

            return true;
        } catch (Exception $e) {
            return false;
        }
    }
}
