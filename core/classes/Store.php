<?php

namespace core\classes;

use Exception;

class Store
{
    //================================================================================================

    public static function Layout($estruturas, $dados = null)
    {

        //verifica se estruturas é um array

        if (!is_array($estruturas)) {
            throw new Exception('Coleção de estruturas inválida');
        }

        // variáveis
        if (!empty($dados) && is_array($dados)) {
            extract($dados);
        }

        //apresentar veiws da aplicação
        foreach ($estruturas as $estrutura) {
            include "../core/views/$estrutura.php";
        }
    }

    //================================================================================================

    public static function Layout_admin($estruturas, $dados = null)
    {

        //verifica se estruturas é um array

        if (!is_array($estruturas)) {
            throw new Exception('Coleção de estruturas inválida');
        }

        // variáveis
        if (!empty($dados) && is_array($dados)) {
            extract($dados);
        }

        //apresentar veiws da aplicação
        foreach ($estruturas as $estrutura) {
            include "../../core/views/$estrutura.php";
        }
    }

    //================================================================================================

    public static function clienteLogado()
    {

        //verifica se existe um cliente com sessão
        return isset($_SESSION['cliente']);
    }

    //================================================================================================

    public static function adminLogado()
    {

        // verificar se existe um admin com sessão

        return isset($_SESSION['admin']);
    }

    //================================================================================================
    public static function criarHash($num_caracteres = 12)
    {

        // criar hash
        $chars = '01234567890123456789abcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZABCDEFGHIJKLMNOPQRSTUVWXYZ';
        return substr(str_shuffle($chars), 0, $num_caracteres);
    }

    //================================================================================================

    public static function redirect($rota = '')
    {

        // realiza o redirecionamento para a URL desejada (rota)

        header("Location: " . BASE_URL_CLIENTE . "?q=$rota");
    }

    //================================================================================================

    public static function redirectAdmin($rota = '')
    {
        // realiza o redirecionamento para URL desejada (rota)
        header("Location: " . BASE_URL_ADMIN . "?q=$rota");
    }

    //================================================================================================

    public static function gerarCodigoEncomenda()
    {

        // gerar código da encomenda
        $codigo = '';

        $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZABCDEFGHIJKLMNOPQRSTUVWXYZABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $codigo .= substr(str_shuffle($chars), 0, 2);
        $codigo .= rand(100000, 999999);

        return $codigo;
    }


    //================================================================================================

    public static function aesEncriptar($valor)
    {

        return bin2hex(openssl_encrypt($valor, 'aes-256-cbc', AES_KEY, OPENSSL_RAW_DATA, AES_IV));
    }

    //================================================================================================

    public static function aesDesencriptar($valor)
    {

        return openssl_decrypt(hex2bin($valor), 'aes-256-cbc', AES_KEY, OPENSSL_RAW_DATA, AES_IV);
    }


    //================================================================================================

    public static function printData($data, $die = true)
    {

        if (is_array($data) || is_object($data)) {

            echo '<pre>';
            print_r($data);
        } else {

            echo '<pre>';
            echo $data;
        }
        if ($die) {
            die();
        }
    }
}
