<?php



namespace core\controllers;

use core\classes\Store;
use core\classes\DataBase;
use core\classes\EnviarEmail;
use core\models\Encomendas;
use core\models\Produtos;
use core\models\Users;




class Carrinho
{

    //================================================================

    public function adicionar_carrinho()
    {
        // ver quantos produtos existem no carrinho se existir sessão do carrinho

        $produtos_in_carrinho = 0;
        if (isset($_SESSION['carrinho'])) {
            foreach ($_SESSION['carrinho'] as $quantidade) {
                $produtos_in_carrinho += $quantidade;
            }
        }

        // obter o id_produto à query string passada pelo axios
        if (!isset($_GET['id_produto'])) {

            echo isset($_SESSION['carrinho']) ? $produtos_in_carrinho : 0;
            return;
        }

        // define o id do produto
        $id_produto = $_GET['id_produto'];

        $produtos = new Produtos();

        $resultados = $produtos->verificar_stock_produto($id_produto);


        if (!$resultados) {



            echo isset($_SESSION['carrinho']) ? $produtos_in_carrinho : 0;
            return;
        }

        // adiciona a variável de SESSÂO do carrinho


        $carrinho = [];

        if (isset($_SESSION['carrinho'])) {

            $carrinho = $_SESSION['carrinho'];
        }

        // adicionar produto ao carrinho

        if (key_exists($id_produto, $carrinho)) {

            // produto existe no carrinho, acrescentar uma unidade

            $carrinho[$id_produto]++;
        } else {

            //produto não existe no carrinho, adiciona novo produto
            $carrinho[$id_produto] = 1;
        }

        // atualiza os dados do carrinho na sessão

        $_SESSION['carrinho'] = $carrinho;

        //devolve a resposta (número de produtos do carrinho)

        $total_produtos = 0;

        foreach ($carrinho as $quantidade) {
            $total_produtos += $quantidade;
        }

        echo $total_produtos;
    }

    //============================================================

    public function remover_produto_carrinho()
    {
        //if (isset($_GET['id_produto'])) {
        //}

        // obter id do produto na query string
        $id_produto = $_GET['id_produto'];

        // obter o carrinho da sessão
        $carrinho = $_SESSION['carrinho'];

        // remover o produto do carrinho da sessão
        unset($carrinho[$id_produto]);

        //atualizar o carrinho na sassão 
        $_SESSION['carrinho'] = $carrinho;
        Store::redirect('carrinho');
    }

    //================================================================

    public function limpar_carrinho()
    {

        // limpa o carrinho de todos os produtos
        unset($_SESSION['carrinho']);
        Store::redirect('carrinho');
    }
    //================================================================

    public function carrinho()
    {


        // verificar se existe carrinho

        if (!isset($_SESSION['carrinho']) || count($_SESSION['carrinho']) == 0) {
            $dados = [
                'carrinho' => null,
            ];
        } else {

            $ids = [];
            foreach ($_SESSION['carrinho'] as $id_produto => $quantidade) {
                array_push($ids, $id_produto);
            }

            $ids = implode(", ", $ids);
            $produtos = new Produtos();
            $resultado = $produtos->obter_produtos_por_id($ids);

            $dados_tmp = [];
            foreach ($_SESSION['carrinho'] as $id_produto => $quantidade_carrinho) {

                // obter imagem do produto
                foreach ($resultado as $produto) {
                    if ($produto->id_produto == $id_produto) {
                        $id_produto = $produto->id_produto;
                        $imagem = $produto->imagem_produto;
                        $nome = $produto->nome_produto;
                        $quantidade = $quantidade_carrinho;
                        $preco = $produto->preco * $quantidade;

                        //inserir produto na coleçao

                        array_push($dados_tmp, [
                            'id_produto' => $id_produto,
                            'imagem' => $imagem,
                            'nome' => $nome,
                            'quantidade' => $quantidade,
                            'preco' => $preco,

                        ]);

                        break;
                    }
                }
            }

            // calcular total da encomeda
            $total_encomenda = 0;
            foreach ($dados_tmp as $item) {
                $total_encomenda += $item['preco'];
            }

            array_push($dados_tmp, $total_encomenda);

            $dados = [
                'carrinho' => $dados_tmp,
            ];
        }
        //apresenta o carrinho

        Store::Layout([
            'layouts/html_header',
            'layouts/header',
            'carrinho',
            'layouts/footer',
            'layouts/html_footer',
        ], $dados);
    }

    //================================================================

    public function morada_alternativa()
    {

        //fazer validadções do post 

        // receber dados via axios

        $post = json_decode(file_get_contents('php://input'), true);

        // adiciona ou altera na sessão a variável array dados_alternativos

        $_SESSION['dados_alternativos'] = [
            'morada' => $post['nova_morada'],
            'localidade' => $post['nova_localidade'],
            'cod_postal' => $post['novo_codPostal'],
            'email' => $post['novo_email'],
            'telfone' => $post['novo_telefone']
        ];
    }

    //================================================================

    public function finalizar_encomenda()
    {
        //Store::printData($_SESSION);
        //verificar se existe cliente logado

        if (!Store::clienteLogado()) {

            // coloca na sessão uma referrer temporaria

            $_SESSION['tmp_carrinho'] = true;


            // redireciona para o login

            Store::redirect('login');
            return;
        } else {

            Store::redirect('finalizar_encomenda_resumo');
        }
    }

    //================================================================

    public function finalizar_encomenda_resumo()
    {
        // verifica se existe cliente logado 
        if (!Store::clienteLogado()) {

            Store::redirect();
            return;
        }

        // verifica se pode avançar para gravação da encomenda

        if (!isset($_SESSION['carrinho']) || count($_SESSION['carrinho']) == 0) {

            Store::redirect();
            return;
        }

        // informação do carrinho

        $ids = [];
        foreach ($_SESSION['carrinho'] as $id_produto => $quantidade) {
            array_push($ids, $id_produto);
        }

        $ids = implode(", ", $ids);
        $produtos = new Produtos();
        $resultado = $produtos->obter_produtos_por_id($ids);

        $dados_tmp = [];
        foreach ($_SESSION['carrinho'] as $id_produto => $quantidade_carrinho) {

            // obter imagem do produto
            foreach ($resultado as $produto) {
                if ($produto->id_produto == $id_produto) {
                    $id_produto = $produto->id_produto;
                    $imagem = $produto->imagem_produto;
                    $nome = $produto->nome_produto;
                    $quantidade = $quantidade_carrinho;
                    $preco = $produto->preco * $quantidade;

                    //inserir produto na coleçao

                    array_push($dados_tmp, [
                        'id_produto' => $id_produto,
                        'imagem' => $imagem,
                        'nome' => $nome,
                        'quantidade' => $quantidade,
                        'preco' => $preco,

                    ]);

                    break;
                }
            }
        }

        // calcular total da encomeda
        $total_encomenda = 0;
        foreach ($dados_tmp as $item) {
            $total_encomenda += $item['preco'];
        }

        array_push($dados_tmp, $total_encomenda);

        // colocar preço total na sessão

        $_SESSION['total_encomenda'] = $total_encomenda;

        // preparar dados 

        $dados = [];

        $dados['carrinho'] = $dados_tmp;

        // obter informções do cliente

        $user = new Users();
        $dados_user = $user->buscar_dados_user($_SESSION['cliente']);
        $dados['cliente'] = $dados_user;

        // verifica se já existe um código de encomenda na sessão

        if (!isset($_SESSION['codigo_encomenda'])) {

            // gerar código da encomenda
            $codigo_encomenda = Store::gerarCodigoEncomenda();

            // guardar código da encomenda na sessão
            $_SESSION['codigo_encomenda'] = $codigo_encomenda;
        }




        Store::Layout([
            'layouts/html_header',
            'layouts/header',
            'encomenda_resumo',
            'layouts/footer',
            'layouts/html_footer',
        ], $dados);
    }


    //================================================================

    public function confirmar_encomenda()
    {
        // verificar se existe cliente logado
        if (!Store::clienteLogado()) {
            Store::redirect();
            return;
        }

        // verifica se pode avançar para gravação da encomenda

        if (!isset($_SESSION['carrinho']) || count($_SESSION['carrinho']) == 0) {

            Store::redirect();
            return;
        }

        // enviar email para o cliente com os dados da encomenda e pagamento
        $dados_encomenda = [];
        $produtos = new Produtos();

        // obter dados do produtos
        $ids = [];
        foreach ($_SESSION['carrinho'] as $id_produto => $quantidade) {
            array_push($ids, $id_produto);
            // atualizar stock produto
            $produtos->atualiza_stock($id_produto, $quantidade);
        }

        $ids = implode(", ", $ids);

        $produtos_da_encomenda = $produtos->obter_produtos_por_id($ids);

        // esturtura dos dados dos produtos

        $string_produtos = [];

        foreach ($produtos_da_encomenda as $produto) {


            // quantidade
            $quantidade = $_SESSION['carrinho'][$produto->id_produto];

            // string do produto
            $string_produtos[] = "$quantidade x $produto->nome_produto - " . number_format($produto->preco, 2, ',', '.') . "€ / unid.";
        };

        // lista de produtos para o email
        $dados_encomenda['lista_produtos'] = $string_produtos;

        // preco total da encomenda para o email
        $dados_encomenda['total_encomenda'] = number_format($_SESSION['total_encomenda'], 2, ',', '.') . "€";

        // dados de pagamento para o email 
        $dados_encomenda['dados_pagamento'] = [
            'numero_da_conta' => '1234567890',
            'codigo_encomenda' => $_SESSION['codigo_encomenda'],
            'total_encomenda' => number_format($_SESSION['total_encomenda'], 2, ',', '.') . "€"
        ];


        //enviar email para cliente com os dados da encomenda
        $email = new EnviarEmail();
        $email_cliente = $_SESSION['email'];
        $email->enviar_email_confirmacao_encomenda($email_cliente, $dados_encomenda);



        $dados_encomenda = [];
        $dados_encomenda['id_cliente'] = $_SESSION['cliente'];

        // morada

        if (isset($_SESSION['dados_alternativos']['morada']) && !empty($_SESSION['dados_alternativos']['morada'])) {

            // considerar morada alternativa
            $dados_encomenda['morada'] = $_SESSION['dados_alternativos']['morada'];
            $dados_encomenda['localidade'] = $_SESSION['dados_alternativos']['localidade'];
            $dados_encomenda['cod_postal'] = $_SESSION['dados_alternativos']['cod_postal'];
            $dados_encomenda['email'] = $_SESSION['dados_alternativos']['email'];
            $dados_encomenda['telefone'] = $_SESSION['dados_alternativos']['telefone'];
        } else {

            // considerar morada do cliente na base de dados

            $cliente = new Users();

            $dados_cliente = $cliente->buscar_dados_user($_SESSION['cliente']);

            $dados_encomenda['morada'] = $dados_cliente->morada;
            $dados_encomenda['localidade'] = $dados_cliente->localidade;
            $dados_encomenda['cod_postal'] = $dados_cliente->cod_postal;
            $dados_encomenda['email'] = $dados_cliente->email;
            $dados_encomenda['telefone'] = $dados_cliente->telefone;
        }

        // codigo encomenda

        $dados_encomenda['codigo_encomenda'] = $_SESSION['codigo_encomenda'];

        // status

        $dados_encomenda['status'] = 'PENDENTE';
        $dados_encomenda['mensagem'] = '';

        // dados dos produtos da encomenda

        //$produtos_da_encomenda (nome_produto, preco);
        $dados_produtos = [];

        foreach ($produtos_da_encomenda as $produto) {
            $dados_produtos[] = [
                'designacao_produto' => $produto->nome_produto,
                'preco_unidade' => $produto->preco,
                'quantidade' => $_SESSION['carrinho'][$produto->id_produto],
            ];
        }


        $encomenda = new Encomendas();
        $encomenda->guardar_encomenda($dados_encomenda, $dados_produtos);


        // preparação dos dados para apresentar na página de agradecimento

        $codigo_encomenda = $_SESSION['codigo_encomenda'];
        $total_encomenda = $_SESSION['total_encomenda'];

        // limpar todos os dados da encomenda que estão no carrinho

        unset($_SESSION['codigo_encomenda']);
        unset($_SESSION['carrinho']);
        unset($_SESSION['total_encomenda']);
        unset($_SESSION['dados_alternativos']);


        // apresentar a página a agradecer a encomenda
        $dados = [
            'codigo_encomenda' => $codigo_encomenda,
            'total_encomenda' => $total_encomenda,
        ];


        Store::Layout([
            'layouts/html_header',
            'layouts/header',
            'confirmar_encomenda',
            'layouts/footer',
            'layouts/html_footer',
        ], $dados);
    }
}
