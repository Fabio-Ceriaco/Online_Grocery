<?php

namespace core\models;

use core\classes\DataBase;
use core\classes\Store;
use DateTime;



class Users
{

    //=======================Verificar Email============================

    public function verificar_email_existe($email)
    {
        $db = new DataBase();
        //verifica se email já existe na base de dados

        $parametros = [
            ':email' => htmlspecialchars(mb_strtolower(trim($email)))
        ];
        $emailVerify = $db->select("SELECT email FROM clientes WHERE email = :email", $parametros);

        // se o email já existe
        if (count($emailVerify) != 0) {
            return true;
        } else {
            return false;
        }
    }

    //================================================================

    public function verificar_username_existe($username)
    {

        //verificar se username já existe na base de dados
        $db = new DataBase();
        $parametros = [
            ':username' => htmlspecialchars(trim($username))
        ];
        $usernameVerify = $db->select("SELECT username FROM clientes WHERE username = :username", $parametros);

        if (count($usernameVerify) != 0) {
            return true;
        } else {
            return false;
        }
    }

    //================================================================
    public function validar_idade($data_nascimento)
    {

        // obter data atual
        $idade = '';
        $data_n = DateTime::createFromFormat('d-m-Y', $data_nascimento);



        if (date('Y') == $data_n->format('Y')) {
            $idade = 1;
        } else if (date('Y') > $data_n->format('Y')) {
            $idade = date('Y') - $data_n->format('Y');
        };

        if (date('m') < $data_n->format('m')) {
            $idade -= 1;
        } else if (date('m') == $data_n->format('m')) {
            if (date('d') == $data_n->format('d')) {
                $idade = $idade;
            }
        }
        return $idade;
    }

    //================================================================

    public function registar_cliente()
    {
        // regista o novo user na base de dados
        $db = new DataBase();

        //criar uma hase para o registo do cliente
        $purl = Store::criarHash();

        //parametros

        $parametros = [
            ':nome_completo' => htmlspecialchars(trim(mb_convert_case($_POST['nome'], MB_CASE_TITLE, 'UTF-8'))),
            ':username' => htmlspecialchars(trim($_POST['username'])),
            ':email' => htmlspecialchars(mb_strtolower(trim($_POST['email']))),
            ':password' => password_hash($_POST['password'], PASSWORD_DEFAULT),
            ':morada' => htmlspecialchars(trim($_POST['morada'])),
            ':localidade' => htmlspecialchars(trim($_POST['localidade'])),
            ':codPostal' => htmlspecialchars(trim($_POST['cod-postal'])),
            ':telefone' => htmlspecialchars(trim($_POST['telefone'])),
            ':data_nascimento' => htmlspecialchars(trim($_POST['data_nascimento'])),
            ':nif' => htmlspecialchars(trim($_POST['nif'])),
            ':purl' => $purl,
            ':ativo' => 0
        ];
        $db->insert("INSERT INTO clientes VALUES(0, :username, :email, :password, :nome_completo, :morada, :localidade, :codPostal, :telefone, :data_nascimento, :nif, :purl, :ativo, NOW(), NOW(), NULL)", $parametros);

        //retorna o purl criado

        return $purl;
    }

    //================================================================


    public function validar_email($purl)
    {


        //validar o email do novo cliente
        $db = new DataBase();

        $parametros = [
            ':purl' => $purl
        ];
        $resultado = $db->select("SELECT * FROM clientes WHERE purl = :purl", $parametros);

        // verifica se foi encontrado o cliente

        if (count($resultado) != 1) {

            return false;
        }

        // foi encontrado este cliente com o purl indicado
        $id_cliente = $resultado[0]->id_cliente;

        // atualizar dados do cliente

        $parametros = [
            ':id_cliente' => $id_cliente,

        ];

        $db->update("UPDATE clientes SET purl = null, ativo = 1, updated_at = NOW() WHERE id_cliente = :id_cliente", $parametros);

        return true;
    }

    //================================================================

    public function validar_login($email, $password)
    {

        $db = new DataBase();
        //verificar se login é valido
        $parametros = [
            ':email' => $email,
        ];

        $resultado = $db->select("SELECT * FROM clientes WHERE email = :email AND ativo = 1 AND deleted_at IS NULL", $parametros);

        if (count($resultado) != 1) {

            // não existe utilizador

            return false;
        } else {

            // temos utilizador confirmar password

            $utilizador = $resultado[0];

            //verificar password

            if (!password_verify($password, $utilizador->password)) {

                // password inválida

                return false;
            } else {

                //login válido

                return $utilizador;
            }
        }
    }

    //================================================================

    public function buscar_dados_user($id_cliente)
    {

        $db = new DataBase();
        $parametros = [
            ':id_cliente' => $id_cliente,
        ];


        $resultados = $db->select("SELECT nome_completo, username, email, morada, localidade, cod_postal, telefone, data_nascimento, nif FROM clientes WHERE id_cliente = :id_cliente", $parametros);

        return $resultados[0];
    }

    //================================================================

    public function verificar_email_existe_outra_conta($id_cliente, $email)
    {
        // verificar se existe o email em outra conta
        $db = new DataBase();

        $parametros = [
            ':id_cliente' => $id_cliente,
            ':email' => $email,
        ];

        $verifica = $db->select("SELECT email FROM clientes WHERE email = :email AND id_cliente != :id_cliente", $parametros);

        if (count($verifica) != 0) {
            return true;
        } else {
            return false;
        }
    }

    //================================================================

    public function verifica_username_existe_outra_conta($id_cliente, $username)
    {

        // verifica se existe o username em outra conta
        $db = new DataBase();

        $parametros = [
            ':id_cliente' => $id_cliente,
            ':username' => $username,
        ];

        $verifica = $db->select("SELECT username FROM clientes WHERE username = :username AND id_cliente != :id_cliente", $parametros);

        if (count($verifica) != 0) {
            return true;
        } else {
            return false;
        }
    }

    //================================================================
    public function atualizar_dados_utilizador($id_cliente, $nome_completo, $username, $email, $morada, $localidade, $cod_postal, $telefone, $data_nascimento, $nif)
    {

        // ligação a base de dados
        $db = new DataBase();

        $parametros = [
            ':id_cliente' => $id_cliente,
            ':nome_completo' => $nome_completo,
            ':username' => $username,
            ':email' => $email,
            ':morada' => $morada,
            ':localidade' => $localidade,
            ':cod_postal' => $cod_postal,
            ':telefone' => $telefone,
            ':data_nascimento' => $data_nascimento,
            ':nif' => $nif,
        ];

        $db->update("UPDATE clientes SET nome_completo = :nome_completo,  username = :username, email = :email, morada = :morada, localidade = :localidade, cod_postal = :cod_postal, telefone = :telefone, data_nascimento = :data_nascimento, nif = :nif, updated_at = NOW() WHERE id_cliente = :id_cliente", $parametros);
    }

    //================================================================

    public function veriticar_password_atual($id_cliente, $password_atual)
    {

        // ligação a base de dados
        $db = new DataBase();

        $parametros = [
            ':id_cliente' => $id_cliente,
        ];

        $verifica = $db->select("SELECT password FROM clientes WHERE id_cliente = :id_cliente ", $parametros)[0]->password;

        return password_verify($password_atual, $verifica);
    }

    //================================================================

    public function atualizar_password($id_cliente, $nova_password)
    {

        // ligação a base de dados

        $db = new DataBase();

        // hash da nova password

        $hash_nova_password = password_hash($nova_password, PASSWORD_DEFAULT);

        $parametros = [
            ':id_cliente' => $id_cliente,
            ':nova_password' => $hash_nova_password,
        ];

        $resultado = $db->update("UPDATE clientes SET password = :nova_password, updated_at = NOW() WHERE id_cliente = :id_cliente", $parametros);
    }

    //================================================================
    public function recupearcao_password($id_cliente, $nova_password)
    {


        // ligação a base de dados

        $db = new DataBase();

        // hash da nova password

        $hash_nova_password = password_hash($nova_password, PASSWORD_DEFAULT);

        $parametros = [
            ':id_cliente' => $id_cliente[0]->id_cliente,
            ':nova_password' => $hash_nova_password,
        ];

        $resultado = $db->update("UPDATE clientes SET password = :nova_password, updated_at = NOW() WHERE id_cliente = :id_cliente", $parametros);
    }

    //================================================================
    public function obter_dados_cliente_email($email_cliente)
    {

        // ligação a base de dados
        $db = new DataBase();

        // preparar dados para pesquisa
        $parametros = [
            ':email_cliente' => $email_cliente,
        ];

        // pequisar dados na base de dados

        return $db->select("SELECT id_cliente FROM clientes WHERE email = :email_cliente", $parametros);
    }
    //================================================================
    public function obter_comentarios_clientes($pagina)
    {

        // ligação a base de dados
        $db = new DataBase();
        $limit = 3;
        $start = ($pagina - 1) * $limit;

        $comentarios = $db->select("SELECT comentario_clientes.*, clientes.nome_completo FROM comentario_clientes LEFT JOIN clientes ON comentario_clientes.id_cliente = clientes.id_cliente LIMIT $start, $limit");
        $total_comentarios = $db->select("SELECT count(id_comentario) AS total_comentarios FROM comentario_clientes")[0]->total_comentarios;


        return [
            'comentarios' => $comentarios,
            'total_comentarios' => $total_comentarios,
            'limit' => $limit,
            'pagina' => $pagina,

        ];
    }

    //================================================================
    public function submit_comentario($id_cliente, $comentario, $rating)
    {

        // ligação a base de dados

        $db = new DataBase();

        // preparar dados para inserir na base de dados

        $parametros = [
            ':id_cliente' => $id_cliente,
            ':comentario' => $comentario,
            ':rating' => $rating,
        ];

        return $db->insert("INSERT INTO comentario_clientes VALUES (0, :id_cliente, :comentario, :rating, NOW(), NOW(), null)", $parametros);
    }

    //================================================================
    public function obter_coemtarios_home()
    {

        // ligação a base de dados 
        $db = new DataBase();

        return $db->select("SELECT comentario_clientes.*, clientes.username as nome_cliente FROM comentario_clientes LEFT JOIN clientes ON comentario_clientes.id_cliente = clientes.id_cliente LIMIT 3");
    }
}
