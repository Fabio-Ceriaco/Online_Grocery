<?php

//coleção de rotas

$rotas = [

    //pagina inicial
    'home' => 'main@home',
    'produtos' => 'main@produtos',
    'pesquisa_produto' => 'main@pesquisa_produto',

    //cliente
    'registar' => 'main@registar',
    'submit_registo' => 'main@submit_registo',
    'confirmar_email' => 'main@confirmar_email',
    'comentarios_clientes' => 'main@comentarios_clientes',
    'comentarios_clientes_submit' => 'main@comentarios_clientes_submit',
    'recuperar_password' => 'main@recuperar_password',
    'recuperar_password_submit' => 'main@recuperar_password_submit',
    'email_recuperacao_password' => 'main@email_recuperacao_password',

    //login
    'login' => 'main@login',
    'login_submit' => 'main@login_submit',
    'logout' => 'main@logout',

    //perfil
    'dados_pessoais' => 'main@dados_pessoais',
    'alterar_dados_pessoais' => 'main@alterar_dados_pessoais',
    'alterar_dados_pessoais_submit' => 'main@alterar_dados_pessoais_submit',
    'alterar_password' => 'main@alterar_password',
    'alterar_password_submit' => 'main@alterar_password_submit',

    //historico encomendas
    'historico_encomendas' => 'main@historico_encomendas',
    'detalhe_encomenda' => 'main@historico_encomendas_detalhe',

    //carrinho 
    'adicionar_carrinho' => 'carrinho@adicionar_carrinho',
    'limpar_carrinho' => 'carrinho@limpar_carrinho',
    'carrinho' => 'carrinho@carrinho',
    'remover_produto_carrinho' => 'carrinho@remover_produto_carrinho',
    'finalizar_encomenda' => 'carrinho@finalizar_encomenda',
    'finalizar_encomenda_resumo' => 'carrinho@finalizar_encomenda_resumo',
    'morada_alternativa' => 'carrinho@morada_alternativa',
    'confirmar_encomenda' => 'carrinho@confirmar_encomenda',

    //pagamentos


    'formas_pagamento' => 'main@formas_pagamento',
    'pagamento_tranferencia' => 'main@pagamento_tranferencia',
    'pagamento_mbway' => 'main@pagamento_mbway',
    'pagamento_mbway_submit' => 'main@pagamento_mbway_submit',


];

//define ação por defeito

$acao = 'home';

// verifica se existe a ação na query string

if (isset($_GET['q'])) {

    //verifica se a ação existe nas rotas

    if (!key_exists($_GET['q'], $rotas)) {
        $acao = 'home';
    } else {
        $acao = $_GET['q'];
    }
}

// trata a definição da rota

$partes = explode('@', $rotas[$acao]);
$controlador = 'core\\controllers\\' . ucfirst($partes[0]);
$metodo = $partes[1];

$ctr = new $controlador();
$ctr->$metodo();
