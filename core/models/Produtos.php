<?php

namespace core\models;

use core\classes\DataBase;
use core\classes\Store;


class Produtos
{
    //================================================================
    public function pesquisa_de_produtos($produto)
    {

        // ligação a base de dados
        $db = new DataBase();


        $parametros = [':nome_produto' => "%" . $produto . "%"];

        return $db->select("SELECT * FROM produtos WHERE nome_produto LIKE :nome_produto", $parametros);
    }

    //================================================================
    public function lista_produtos_disponiveis($categoria)
    {

        // procurar todas informações dos produtos na base de dados
        $db = new DataBase();

        // obter categorias dos produtos
        $categorias = $this->produto_categoria();


        $sql = "SELECT * FROM produtos ";
        $sql .= "JOIN categorias ON produtos.id_categoria = categorias.id_categoria ";
        $sql .= "WHERE visivel = 1";



        // filtrar por categoris 
        if (in_array($categoria, $categorias)) {

            $sql .= " AND nome_categoria = '$categoria'";
        }



        $produtos = $db->select($sql);

        return $produtos;
    }

    //================================================================

    public function produto_categoria()
    {

        // obter categorias

        $db = new DataBase();

        $resultados = $db->select("SELECT * FROM categorias");
        $categorias = [];

        foreach ($resultados as $resultado) {
            array_push($categorias, $resultado->nome_categoria);
        }

        return $categorias;
    }

    //================================================================

    public function produto_categoria_home()
    {

        // obter categorias

        $db = new DataBase();

        return  $db->select("SELECT * FROM categorias");
    }
    //================================================================
    public function obter_produtos_home()
    {

        // ligação a base de dados

        $db = new DataBase();

        // obter produtos

        return $db->select("SELECT * FROM produtos");
    }



    //================================================================

    public function verificar_stock_produto($id_produto)
    {

        $db = new DataBase();

        $parametros = [
            ':id_produto' => $id_produto
        ];

        $resultados = $db->select("SELECT * FROM produtos WHERE id_produto = :id_produto AND visivel = 1 AND stock > 0", $parametros);

        return count($resultados) != 0 ? true : false;
    }

    //================================================================

    public function obter_produtos_por_id($ids)
    {

        $db = new DataBase();

        $resultado = $db->select("SELECT * FROM produtos WHERE id_produto IN ($ids)");

        return $resultado;
    }

    //================================================================

    public function atualiza_stock($id_produto, $quantidade)
    {

        // ligação a base de dados
        $db = new DataBase();

        $parametros = [
            ':id_produto' => $id_produto,
        ];

        $stock = $db->select("SELECT stock FROM produtos WHERE id_produto = :id_produto", $parametros)[0]->stock;


        $parametros = [
            ':id_produto' => $id_produto,
            ':novoStock' => $stock - $quantidade,
        ];

        $db->update("UPDATE produtos Set stock = :novoStock WHERE id_produto = :id_produto ", $parametros);
    }
}
