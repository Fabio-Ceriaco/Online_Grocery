<?php

namespace core\models;

use core\classes\DataBase;
use core\classes\Store;



class Encomendas
{

    public function guardar_encomenda($dados_encomenda, $dados_produtos)
    {
        $db = new DataBase();

        // guaradar dados da encomenda

        $parametros = [
            ':id_cliente' => $_SESSION['cliente'],
            ':morada' => $dados_encomenda['morada'],
            ':localidade' => $dados_encomenda['localidade'],
            ':cod_postal' => $dados_encomenda['cod_postal'],
            ':email' => $dados_encomenda['email'],
            ':telefone' => $dados_encomenda['telefone'],
            ':codigo_encomenda' => $dados_encomenda['codigo_encomenda'],
            ':status' => $dados_encomenda['status'],

        ];

        $db->insert("INSERT INTO encomendas VALUES (0, :id_cliente, NOW(), :morada, :localidade, :cod_postal, :email, :telefone, :codigo_encomenda, :status, NOW(), NOW(), null)", $parametros);

        // obter o id da encomenda
        $id_encomenda = $db->select("SELECT MAX(id_encomenda) AS id_encomenda FROM encomendas")[0]->id_encomenda;

        // guardar dados dos produtos 
        //realizar ciclo para precorrer todos os produtos que existem associados a encomenda

        foreach ($dados_produtos as $produto) {

            $parametros = [
                ':id_encomenda' => $id_encomenda,
                ':designacao_produto' => $produto['designacao_produto'],
                ':preco_unidade' => $produto['preco_unidade'],
                ':quantidade' => $produto['quantidade'],
            ];

            $db->insert("INSERT INTO encomenda_produto VALUES (0, :id_encomenda, :designacao_produto, :preco_unidade, :quantidade, NOW(), Now(), null)", $parametros);
        }
    }

    //================================================================

    public function carregar_historico_encomendas($id_cliente)
    {

        // obter o historico das encomendas do cliente

        $db = new DataBase();

        $parametros = [
            ':id_cliente' => $id_cliente,
        ];

        return $db->select("SELECT id_encomenda, data_encomenda, codigo_encomenda, status FROM encomendas WHERE id_cliente = :id_cliente ORDER BY data_encomenda DESC", $parametros);
    }

    //================================================================

    public function verificar_encomenda_cliente($id_cliente, $id_encomenda)
    {

        //ligação a base de dados
        $db = new DataBase();

        $parametros = [
            ':id_cliente' => $id_cliente,
            ':id_encomenda' => $id_encomenda,
        ];

        return  $db->select("SELECT id_encomenda FROM encomendas WHERE id_encomenda = :id_encomenda AND id_cliente = :id_cliente", $parametros)[0]->id_encomenda;
    }

    //================================================================

    public function obter_detalhes_encomenda($id_encomenda)
    {

        // ligação a base de dados
        $db = new DataBase();

        // obter daddos da encomenda e a lista de produtos
        $parametros = [
            ':id_encomenda' => $id_encomenda,
        ];

        // dados da encomenda

        $dados_encomenda = $db->select("SELECT * FROM encomendas WHERE id_encomenda = :id_encomenda", $parametros)[0];

        // dados lista de produtos da encomenda
        $produtos_encomenda = $db->select("SELECT * FROM encomenda_produto WHERE id_encomenda = :id_encomenda", $parametros);

        // devolver ao controlador os dados
        return [
            'dados_encomenda' => $dados_encomenda,
            'produtos_encomenda' => $produtos_encomenda,
        ];
    }

    //================================================================

    public function obter_detalhes_encomenda_por_codigo($codigo_encomenda)
    {

        // ligação a base de dados
        $db = new DataBase();

        // obter daddos da encomenda e a lista de produtos
        $parametros = [
            ':codigo_encomenda' => $codigo_encomenda,
        ];

        // dados da encomenda

        $dados_encomenda = $db->select("SELECT * FROM encomendas WHERE codigo_encomenda = :codigo_encomenda", $parametros)[0];

        $parametros = [
            ':id_encomenda' => $dados_encomenda->id_encomenda,
        ];

        $produtos_encomenda = $db->select("SELECT * FROM encomenda_produto WHERE id_encomenda = :id_encomenda", $parametros);

        // devolver ao controlador os dados
        return [
            'dados_encomenda' => $dados_encomenda,
            'produtos_encomenda' => $produtos_encomenda,
        ];
    }

    //================================================================
    public function efetuar_pagamento($codigo_encomenda)
    {

        // ligação a base de dados
        $db = new DataBase();

        $parametros = [
            ':codigo_encomenda' => $codigo_encomenda,
        ];

        //selecionar a encomenda através do código

        $resultado = $db->select("SELECT * FROM encomendas WHERE codigo_encomenda = :codigo_encomenda AND status = 'PENDENTE'", $parametros);

        // se a encomenda não existir ou já tiver sido processada
        if (count($resultado) == 0) {
            return false;
        }

        // alterar o estado da encomenda para EM PROCESSAMENTO
        $db->update("UPDATE encomendas SET status = 'EM PROCESSAMENTO', updated_at = NOW() WHERE codigo_encomenda = :codigo_encomenda", $parametros);

        return true;
    }
}
