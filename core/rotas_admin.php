<?php

//coleção de rotas

$rotas = [

    //pagina inicial
    'index' => 'admin@index',

    //admin
    'admin_login' => 'admin@admin_login',
    'admin_login_submit' => 'admin@admin_login_submit',
    'admin_logout' => 'admin@admin_logout',

    //clientes
    'lista_clientes' => 'admin@lista_clientes',
    'detalhes_cliente' => 'admin@detalhes_cliente',
    'cliente_historico_encomendas' => 'admin@cliente_historico_encomendas',
    'ativar_cliente' => 'admin@ativar_cliente',
    'desativar_cliente' => 'admin@desativar_cliente',

    //encomendas
    'lista_encomendas' => 'admin@lista_encomendas',
    'detalhe_encomenda' => 'admin@detalhe_encomenda',
    'encomenda_alterar_estado' => 'admin@encomenda_alterar_estado',
    'criar_pdf_encomenda' => 'admin@criar_pdf_encomenda',
    'enviar_pdf_encomenda' => 'admin@enviar_pdf_encomenda',

    //produtos
    'consultar_produtos' => 'admin@consultar_produtos',
    'adicionar_produtos' => 'admin@adicionar_produtos',
    'submeter_produto' => 'admin@submeter_produto',
    'editar_produto' => 'admin@editar_produto',
    'atualaizar_produto' => 'admin@atualaizar_produto',

    //categorias
    'adicionar_categorias' => 'admin@adicionar_categorias',
    'submeter_categoria' => 'admin@submeter_categoria',
    'consultar_categorias' => 'admin@consultar_categorias',



];

//define ação por defeito

$acao = 'index';

// verifica se existe a ação na query string

if (isset($_GET['q'])) {

    //verifica se a ação existe nas rotas

    if (!key_exists($_GET['q'], $rotas)) {
        $acao = 'index';
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
