<?php

namespace core\models;

use core\classes\DataBase;
use core\classes\Store;




class AdminModel
{
    //================================================================
    // AUTENTICAÇÂO
    //================================================================
    public function validar_admin_login($admin_email, $admin_password)
    {

        $db = new DataBase();
        //verificar se login é valido
        $parametros = [
            ':email' => $admin_email,
        ];

        $resultado = $db->select("SELECT * FROM admins WHERE email = :email AND deleted_at IS NULL", $parametros);
        $administrador = $resultado[0];


        if (count($resultado) != 1) {

            // não existe administrador

            return false;
        } else {

            // temos administrador confirmar password

            $administrador = $resultado[0];

            //verificar password

            if (!password_verify($admin_password, $administrador->password)) {

                // password inválida

                return false;
            } else {

                //login válido

                return $administrador;
            }
        }
    }

    //================================================================
    // CLIENTES
    //================================================================

    public function lista_clientes()
    {

        //ligação a base de dados
        $db = new DataBase();

        // obter a lista de clientes

        return $db->select("SELECT clientes.id_cliente, clientes.nome_completo, clientes.email, clientes.morada, clientes.localidade, clientes.cod_postal, clientes.telefone, clientes.data_nascimento, clientes.nif, clientes.ativo, clientes.created_at, clientes.deleted_at, COUNT(encomendas.id_encomenda) AS total_encomendas FROM clientes LEFT JOIN encomendas ON clientes.id_cliente = encomendas.id_cliente GROUP BY clientes.id_cliente");
    }

    //================================================================
    public function detalhes_cliente($id_cliente)
    {

        // ligação a base de dados
        $db = new DataBase();

        // obter os detalhes do cliente
        $parametros = [
            ':id_cliente' => $id_cliente,
        ];

        return $db->select("SELECT * FROM clientes WHERE id_cliente = :id_cliente", $parametros)[0];
    }

    //================================================================
    public function total_encomendas_cliente($id_cliente)
    {

        // ligação a base de dados
        $db = new DataBase();

        $parametros = [
            ':id_cliente' => $id_cliente,
        ];
        return $db->select("SELECT COUNT(*) AS total FROM encomendas WHERE id_cliente = :id_cliente", $parametros)[0]->total;
    }

    //================================================================
    public function historico_encomendas_cliente($id_cliente)
    {

        // ligação a base de dados
        $db = new DataBase();

        // obter o histórico de encomendas do cliente
        $parametros = [
            ':id_cliente' => $id_cliente,
        ];

        return $db->select("SELECT encomendas.data_encomenda, encomendas.codigo_encomenda, encomendas.status, encomendas.updated_at, clientes.nome_completo FROM encomendas JOIN clientes ON encomendas.id_cliente = clientes.id_cliente WHERE encomendas.id_cliente = :id_cliente", $parametros);
    }

    //================================================================
    public function alterar_estado_cliente($id_cliente, $estado)
    {

        // ligação a base de dados

        $db = new DataBase();

        $parametros = [
            ':id_cliente' => $id_cliente,
            ':estado' => $estado,
        ];

        if ($estado != 0) {

            return $db->update("UPDATE clientes SET ativo  = :estado, updated_at = NOW(), deleted_at = NULL WHERE id_cliente = :id_cliente", $parametros);
        } else {

            return $db->update("UPDATE clientes SET ativo = :estado, updated_at = NOW(), deleted_at = NOW() WHERE id_cliente = :id_cliente", $parametros);
        }
    }


    //================================================================
    // ENCOMENDAS
    //================================================================

    public function total_encomendas_pendentes()
    {
        //obter a quantidade de encomendas pendentes
        $db = new DataBase();
        $parametros = [
            ':status' => 'PENDENTE',
        ];

        $resultado = $db->select("SELECT COUNT(*) AS total FROM encomendas WHERE status = :status", $parametros);

        return $resultado[0]->total;
    }

    //================================================================

    public function total_encomendas_em_processamento()
    {

        //obter a quantidade de encomendas em processamento
        $db = new DataBase();
        $parametros = [
            ':status' => 'EM PROCESSAMENTO',
        ];

        $resultado = $db->select("SELECT COUNT(*) AS total FROM encomendas WHERE status = :status", $parametros);

        return $resultado[0]->total;
    }

    //================================================================
    public function total_encomendas_enviadas()
    {

        //obter a quantidade de encomendas em processamento
        $db = new DataBase();
        $parametros = [
            ':status' => 'ENVIADA',
        ];

        $resultado = $db->select("SELECT COUNT(*) AS total FROM encomendas WHERE status = :status", $parametros);

        return $resultado[0]->total;
    }

    //================================================================
    public function total_encomendas_entregues()
    {

        //obter a quantidade de encomendas em processamento
        $db = new DataBase();
        $parametros = [
            ':status' => 'ENTREGUE',
        ];

        $resultado = $db->select("SELECT COUNT(*) AS total FROM encomendas WHERE status = :status", $parametros);

        return $resultado[0]->total;
    }

    //================================================================
    public function total_encomendas_canceladas()
    {

        //obter a quantidade de encomendas em processamento
        $db = new DataBase();
        $parametros = [
            ':status' => 'CANCELADA',
        ];

        $resultado = $db->select("SELECT COUNT(*) AS total FROM encomendas WHERE status = :status", $parametros);

        return $resultado[0]->total;
    }

    //================================================================
    public function lista_encomendas($filtro, $id_cliente = null)
    {

        // apresentar lista de encomenda dependendo do filtro
        $db = new DataBase();



        $sql = "SELECT encomendas.*, clientes.nome_completo FROM encomendas JOIN clientes ON encomendas.id_cliente = clientes.id_cliente";
        //Obter encomendas pendentes
        if ($filtro != '') {
            $sql .= " WHERE status = '$filtro'";
        }

        // verifica se para alem do filtro existe o id cliente
        if (!empty($id_cliente)) {

            $sql .= " AND clientes.id_cliente = '$id_cliente'";
        }

        $sql .= " ORDER BY id_encomenda DESC";


        $resultado = $db->select($sql);

        return $resultado;
    }

    //================================================================

    public function detalhes_encomenda($id_encomenda)
    {

        // ligação a base de dados
        $db = new DataBase();

        //  obeter os detalhes da encomenda
        $parametros = [
            ':id_encomenda' => $id_encomenda,
        ];
        // dados da encomenda
        $dados_encomenda = $db->select("SELECT encomendas.*, clientes.nome_completo FROM encomendas JOIN clientes ON encomendas.id_cliente = clientes.id_cliente WHERE id_encomenda = :id_encomenda", $parametros)[0];

        // lista de produtos da encomenda
        $produtos_encomenda = $db->select("SELECT * FROM encomenda_produto WHERE id_encomenda = :id_encomenda", $parametros);

        return [
            'dados_encomenda' => $dados_encomenda,
            'produtos_encomenda' => $produtos_encomenda,
        ];
    }

    //================================================================

    public function alterar_estado_encomenda($id_encomenda, $estado)
    {

        // ligação a base de dados
        $db = new DataBase();

        // alterar estado da encomenda
        $parametros = [
            ':id_encomenda' => $id_encomenda,
            ':status' => $estado,
        ];

        return $db->update("UPDATE encomendas SET status = :status, updated_at = NOW() WHERE id_encomenda = :id_encomenda", $parametros);
    }

    //================================================================
    // PRODUTOS
    //================================================================

    public function obter_produtos_na_db()
    {

        // ligação a base de dados
        $db = new DataBase();

        // obter lista de produtos
        return $db->select("SELECT produtos.*, categorias.nome_categoria as nome_categoria FROM produtos LEFT JOIN categorias ON produtos.id_categoria = categorias.id_categoria");
    }

    //================================================================
    public function obter_categorias()
    {

        // ligação a base de dados
        $db = new DataBase();

        // obter lista de categorias
        return $db->select("SELECT * FROM categorias");
    }

    //================================================================
    public function adicionar_produtos($dados_produto)
    {

        // ligação a base de dados
        $db = new DataBase();



        $parametros = [
            ':id_categoria' => $dados_produto['categoria'],
            ':nome_produto' => $dados_produto['nome'],
            ':descricao' => $dados_produto['descricao'],
            ':preco' => $dados_produto['preco'],
            ':stock' => $dados_produto['stock'],
            ':visivel' => $dados_produto['visivel'],
            ':imagem' => $dados_produto['imagem'],
        ];

        // adicionar produto à base de dados

        return $db->insert("INSERT INTO produtos Values (0, :id_categoria, :nome_produto, :descricao, :imagem, :preco, :stock, :visivel, NOW(), NOW(), NULL)", $parametros);
    }

    //================================================================

    public function obter_dados_produto($id_produto)
    {

        // ligação a base de dados

        $db = new DataBase();

        // obter dados do produto

        $parametros = [
            ':id_produto' => $id_produto,
        ];

        return $db->select("SELECT * FROM produtos WHERE id_produto = :id_produto", $parametros);
    }
    //================================================================
    public function atualizar_produto($dados_produto)
    {

        // ligação a base de dados
        $db = new DataBase();



        $parametros = [
            ':id_produto' => $dados_produto['id_produto'],
            ':id_categoria' => $dados_produto['categoria'],
            ':nome_produto' => $dados_produto['nome'],
            ':descricao' => $dados_produto['descricao'],
            ':preco' => $dados_produto['preco'],
            ':stock' => $dados_produto['stock'],
            ':visivel' => $dados_produto['visivel'],

        ];

        // adicionar produto à base de dados

        return $db->update("UPDATE produtos SET id_categoria = :id_categoria, nome_produto = :nome_produto, descricao = :descricao, preco = :preco, stock = :stock, visivel = :visivel, updated_at = NOW(), deleted_at = NULL WHERE id_produto = :id_produto", $parametros);
    }

    //================================================================
    // CATEGORIAS
    //================================================================

    public function adicionar_categoria($dados_categoria)
    {


        // ligação a base de dados 
        $db = new DataBase();

        // preparar query

        $parametros = [
            ':nome_categoria' => $dados_categoria['nome'],
            ':imagem' => $dados_categoria['imagem'],
        ];

        return $db->insert("INSERT INTO categorias VALUES (0, :nome_categoria, :imagem, NOW(), NOW(), NULL)", $parametros);
    }

    //================================================================
}
