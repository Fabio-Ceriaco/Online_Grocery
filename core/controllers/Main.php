<?php

namespace core\controllers;



use core\classes\Store;
use core\classes\DataBase;
use core\classes\EnviarEmail;
use core\classes\PDF;
use core\models\Encomendas;
use core\models\Produtos;
use core\models\Users;



class Main
{

    //================================================================
    public function home()
    {
        $categoria = new Produtos();
        $produto = new Produtos();
        $user = new Users();







        $dados = [
            'categorias' => $categoria->produto_categoria_home(),
            'comentarios_home' => $user->obter_coemtarios_home(),
            'produtos_home' => $produto->obter_produtos_home(),
        ];

        Store::Layout([
            'layouts/html_header',
            'layouts/header',
            'home',
            'layouts/footer',
            'layouts/html_footer'
        ], $dados);
    }

    //=================================================================
    public function produtos()
    {

        //apresenta a página produtos

        // carregar lista de produtops
        $produtos = new Produtos();

        //analisa que categoria mostrar
        $c = 'todos';
        if (isset($_GET['c'])) {

            $c = $_GET['c'];
        }

        $categorias = $produtos->produto_categoria();
        $lista_produtos = $produtos->lista_produtos_disponiveis($c);


        $dados = [
            'conteudo_produtos' => $lista_produtos,
            'categorias_produtos' => $categorias
        ];

        Store::Layout([
            'layouts/html_header',
            'layouts/header',
            'produtos',
            'layouts/footer',
            'layouts/html_footer'
        ], $dados);
    }

    //===================================================================

    public function login()
    {

        if (Store::clienteLogado()) {

            Store::redirect();
            return;
        }

        Store::Layout([
            'layouts/html_header',
            'layouts/header',
            'login',
            'layouts/footer',
            'layouts/html_footer',
        ]);
    }

    //=================================================================
    public function registar()
    {

        //verifica se já existe sessão aberta 
        if (Store::clienteLogado()) {
            Store::redirect();
            return;
        }


        //apresenta a página de registo

        Store::Layout([
            'layouts/html_header',
            'layouts/header',
            'registar',
            'layouts/footer',
            'layouts/html_footer',
        ]);
    }

    //================================================================

    public function submit_registo()
    {

        //verifica se já existe sessão
        if (Store::clienteLogado()) {
            Store::redirect();
            return;
        }

        //verifica se houve submissão de um formulário

        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            $this->home();
            return;
        }

        // criação do novo cliente
        $user = new Users();
        //verificar se senhas são iguais

        if ($_POST['password'] !== $_POST['cpassword']) {

            // as passwords são diferentes
            $_SESSION['erro'] = 'As passwords não são iguais';
            $this->registar();
            return;
        }

        // verifica na base de dados se email já existe

        if ($user->verificar_email_existe($_POST['email'])) {
            $_SESSION['erro'] = 'Já existe um cliente com esse email.';
            $this->registar();
            return;
        }



        // verificar na base de dados se username já existe
        if ($user->verificar_username_existe($_POST['username'])) {
            $_SESSION['erro'] = 'Já existe um cliente com esse Username';
            $this->registar();
            return;
        }

        $idade = $user->validar_idade($_POST['data_nascimento']);

        if ($idade < 18) {
            $_SESSION['erro'] = 'Deve ter no minimo 18 anos para realizar o registo';
            Store::redirect('registar');
            return;
        }

        // inserir novo cliente na base de dados e devolver o purl
        $email_cliente = strtolower(trim($_POST['email']));
        $purl = $user->registar_cliente();


        // envio do email para o cliente

        $email = new EnviarEmail();
        $resultado = $email->enviar_email_confirmacao_novo_cliente($email_cliente, $purl);

        if ($resultado) {

            //apresenta a página de informação de envio do email

            Store::Layout([
                'layouts/html_header',
                'layouts/header',
                'registar_cliente_sucesso',
                'layouts/footer',
                'layouts/html_footer',
            ]);

            return;
        } else {
            echo 'Aconteceu um erro';
        }
    }

    //================================================================

    public function confirmar_email()
    {

        //verifica se já existe sessão
        if (Store::clienteLogado()) {
            Store::redirect();
            return;
        }

        //verificar se existe na query string um purl
        if (!isset($_GET['purl'])) {
            $this->home();
            return;
        }

        $purl = $_GET['purl'];

        //verifica se o purl é válido
        if (strlen($purl) != 12) {
            $this->home();
            return;
        }

        $user = new Users();
        $resultado = $user->validar_email($purl);

        if ($resultado) {

            //apresenta a página de informação de email confirmado

            Store::Layout([
                'layouts/html_header',
                'layouts/header',
                'email_confirmado_sucesso',
                'layouts/footer',
                'layouts/html_footer',
            ]);

            return;
        } else {

            //redirecionar para a página inicial
            Store::redirect();
        }
    }

    //=================================================================

    public function login_submit()
    {

        //verifica se já existe sessão

        if (Store::clienteLogado()) {
            Store::redirect();
            return;
        }

        //verifica se foi efetuado o post do login

        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            Store::redirect();
            return;
        }

        //verifica se o login é valido


        //validar se os campos vieram coreetamente preenchidos

        if (!isset($_POST['email']) || !isset($_POST['password']) || !filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL)) {

            // erro de preenchimento do login
            $_SESSION['erro'] = 'Login inválido';
            Store::redirect('login');
            return;
        }

        //preparação dos dados para o model

        $utilizador_email = trim(strtolower($_POST['email']));
        $password = $_POST['password'];

        // carregamento do model e verificação do login válido
        $user = new Users();
        $resultado = $user->validar_login($utilizador_email, $password);

        //analise do resultado
        if (is_bool($resultado)) {

            // login inválido
            $_SESSION['erro'] = 'Login inválido';
            Store::redirect('login');
            return;
        } else {

            // login válido

            $_SESSION['cliente'] = $resultado->id_cliente;
            $_SESSION['nome_completo'] = $resultado->nome_completo;
            $_SESSION['username'] = $resultado->username;
            $_SESSION['email'] = $resultado->email;



            //redirecionar para home page
            if (isset($_SESSION['tmp_carrinho'])) {

                //remove a variável temporária da sessão

                unset($_SESSION['tmp_carrinho']);

                // redireciona para o carrinho
                Store::redirect('finalizar_encomenda_resumo');
            } else {

                //redireciona para a home
                Store::redirect();
            }
        }
    }

    //=================================================================

    public function logout()
    {

        //remove as variaveis da sessão e redirecina para home
        unset($_SESSION['cliente']);
        unset($_SESSION['nome']);
        unset($_SESSION['username']);
        unset($_SESSION['email']);

        Store::redirect();
    }

    //=================================================================

    public function dados_pessoais()
    {
        // verificar se existe um tilizador logado
        if (!Store::clienteLogado()) {
            Store::redirect();
            return;
        }

        // obter informações do user
        $user = new Users();

        $dtemp = $user->buscar_dados_user($_SESSION['cliente']);

        $dados_cliente = [
            'Nome completo' => $dtemp->nome_completo,
            'Username' => $dtemp->username,
            'Email' => $dtemp->email,
            'Morada' => $dtemp->morada,
            'Localidade' => $dtemp->localidade,
            'Código Postal' => $dtemp->cod_postal,
            'Telefone' => $dtemp->telefone,
            'Data Nascimento' => $dtemp->data_nascimento,
            'NIF' => $dtemp->nif,
        ];

        $dados = [
            'dados_cliente' => $dados_cliente,
        ];

        //apresentação da página de dados pessoias
        Store::Layout([
            'layouts/html_header',
            'layouts/header',
            'dados_pessoais',
            'layouts/footer',
            'layouts/html_footer',
        ], $dados);
    }

    //=================================================================

    public function alterar_dados_pessoais()
    {

        // verificar se existe um tilizador logado
        if (!Store::clienteLogado()) {
            Store::redirect();
            return;
        }

        // obter informações do user
        $user = new Users();


        $dados = [
            'dados_pessoais' => $user->buscar_dados_user($_SESSION['cliente']),
        ];

        //apresentação da página de dados pessoias
        Store::Layout([
            'layouts/html_header',
            'layouts/header',
            'alterar_dados_pessoais',
            'layouts/footer',
            'layouts/html_footer',
        ], $dados);
    }

    //=================================================================

    public function alterar_dados_pessoais_submit()
    {
        // verifica se existe cliente logado
        if (!Store::clienteLogado()) {
            Store::redirect();
            return;
        }

        //verifica se existiu submissão de formulário

        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            Store::redirect();
            return;
        }

        // validara dados
        $nome_completo = htmlspecialchars(trim($_POST['nome_completo']));
        $username = htmlspecialchars(trim($_POST['username']));
        $email = htmlspecialchars(strtolower(trim($_POST['email'])));
        $morada = htmlspecialchars(trim($_POST['morada']));
        $localidade = htmlspecialchars(trim($_POST['localidade']));
        $cod_postal = htmlspecialchars(trim($_POST['cod-postal']));
        $telefone = htmlspecialchars(trim($_POST['telefone']));
        $data_nascimento = htmlspecialchars(trim($_POST['data_nascimento']));
        $nif = htmlspecialchars(trim($_POST['nif']));

        // verificar se todos os campos estão preenchidos

        if (empty($nome_completo) || empty($username) || empty($email) || empty($morada) || empty($localidade) || empty($cod_postal) || empty($telefone) || empty($data_nascimento) || empty($nif)) {
            $_SESSION['erro'] = "Todos os campos devem estár preenchidos.";
            Store::redirect('alterar_dados_pessoais');
            return;
        }

        // validar email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['erro'] = "O email introduzido não é válido.";
            Store::redirect('alterar_dados_pessoais');
            return;
        }

        // verificar se este email e username já existem noutra conta de email
        $user = new Users();
        $verifica_email = $user->verificar_email_existe_outra_conta($_SESSION['cliente'], $email);
        $verifica_username = $user->verifica_username_existe_outra_conta($_SESSION['cliente'], $username);

        if ($verifica_email) {
            $_SESSION['erro'] = "Já existe uma outra conta com este email.";
            Store::redirect('alterar_dados_pessoais');
            return;
        }

        if ($verifica_username) {
            $_SESSION['erro'] = "Já existe uma outra conta com este username.";
            Store::redirect('alterar_dados_pessoais');
            return;
        }

        // atualizar dados do cliente na base de dados

        $user->atualizar_dados_utilizador($_SESSION['cliente'], $nome_completo, $username, $email, $morada, $localidade, $cod_postal, $telefone, $data_nascimento, $nif);

        // atualizar dados do cliente na sessão
        $_SESSION['nome_completo'] = $nome_completo;
        $_SESSION['username'] = $username;
        $_SESSION['email'] = $email;

        // redirecionar cliente para a página dados pessoias com mensagem de sucesso
        $_SESSION['sucesso'] = "Dados atualizados com sucesso";
        Store::redirect('dados_pessoais');
    }

    //=================================================================

    public function alterar_password()
    {
        // verificar se existe um tilizador logado
        if (!Store::clienteLogado()) {
            Store::redirect();
            return;
        }



        //apresentação da página de dados pessoias
        Store::Layout([
            'layouts/html_header',
            'layouts/header',
            'alterar_password',
            'layouts/footer',
            'layouts/html_footer',
        ]);
    }

    //=================================================================

    public function alterar_password_submit()
    {
        // verifica se existe cliente logado
        if (!Store::clienteLogado()) {
            Store::redirect();
            return;
        }

        // verifica se existiu submissão de um formulário

        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            Store::redirect();
            return;
        }

        // validar dados
        $password_atual = htmlspecialchars($_POST['password_atual']);
        $nova_password = htmlspecialchars($_POST['nova_password']);
        $confirmar_password = htmlspecialchars($_POST['confirmar_password']);

        // verificar se todos os campos estão preenchidos
        if (empty($password_atual) || empty($nova_password) || empty($confirmar_password)) {
            $_SESSION['erro'] = "Todos os campos deve estar preenchidos";
            Store::redirect('alterar_password');
            return;
        }

        // verificar se a password atual está correta
        $user = new Users();
        $verifica_password_atual = $user->veriticar_password_atual($_SESSION['cliente'], $password_atual);

        if (!$verifica_password_atual) {
            $_SESSION['erro'] = "Password atual inválida.";
            Store::redirect('alterar_password');
            return;
        }

        // verifica se a nova password vem com dados
        if (strlen($nova_password) < 8) {
            $_SESSION['erro'] = "A nova password deve ter mais de 8 caracteres.";
            Store::redirect('alterar_password');
            return;
        }

        // verifica se a nova password é igual a atual
        if ($nova_password == $password_atual) {
            $_SESSION['erro'] = "A nova password não pode ser igual a password atual.";
            Store::redirect('alterar_password');
            return;
        }

        //verificar se nova password e a sua confirmação são iguais

        if ($nova_password != $confirmar_password) {
            $_SESSION['erro'] = "A confirmação da password não coincide com a nova password.";
            Store::redirect('alterar_password');
            return;
        }

        // atualizar password na base de dados
        $user->atualizar_password($_SESSION['cliente'], $nova_password);

        // redirecionar cliente para a página dados pessoais com a mensagem de sucesso
        $_SESSION['sucesso'] = "Password alterada com sucesso.";
        Store::redirect('dados_pessoais');
        return;
    }

    //================================================================
    public function recuperar_password()
    {
        //verificar se existe cliente logado

        if (Store::clienteLogado()) {
            Store::redirect();
            return;
        }

        Store::Layout([
            'layouts/html_header',
            'layouts/header',
            'recuperar_password',
            'layouts/footer',
            'layouts/html_footer',
        ]);
    }

    //================================================================
    public function recuperar_password_submit()
    {

        //verificar se existe cliente logado

        if (Store::clienteLogado()) {
            Store::redirect();
            return;
        }

        // verificar se foi submetido um formulário 
        if ($_SERVER['REQUEST_METHOD'] != "POST") {
            Store::redirect();
            return;
        }

        // validar email

        if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $_SESSION['erro'] = "O email introduzido não é válido.";
            Store::redirect('recuperar_password');
            return;
        }

        $email_cliente = htmlspecialchars(trim(mb_strtolower($_POST['email'])));



        $user = new Users();

        $verificar_conta = $user->obter_dados_cliente_email($email_cliente);


        if ($verificar_conta != '') {

            $nova_password = Store::criarHash();
            $user->recupearcao_password($verificar_conta, $nova_password);

            // enviar email com nova password
            $email_nova_password = new EnviarEmail();
            $email_nova_password->enviar_email_com_nova_password($email_cliente, $nova_password);
            Store::Layout([
                'layouts/html_header',
                'layouts/header',
                'email_recuperacao_password',
                'layouts/footer',
                'layouts/html_footer',
            ]);
        } else {
            $_SESSION['erro'] = "O email introduzido não é válido.";
            Store::redirect('recuperar_password');
            return;
        };
    }

    //=================================================================

    public function historico_encomendas()
    {
        if (!Store::clienteLogado()) {
            Store::redirect();
            return;
        }

        // carregar historico de encomendas
        $encomenda = new Encomendas();
        $historico_encomendas = $encomenda->carregar_historico_encomendas($_SESSION['cliente']);

        // prepara dados para a view do historico das encomendas
        $dados = [
            'historico_encomendas' => $historico_encomendas,
        ];

        // apresentar view do historico das encomendas
        Store::Layout([
            'layouts/html_header',
            'layouts/header',
            'historico_encomendas',
            'layouts/footer',
            'layouts/html_footer',
        ], $dados);
    }

    //=================================================================

    public function historico_encomendas_detalhe()
    {

        // verificar se existe cliente logado
        if (!Store::clienteLogado()) {
            Store::redirect();
            return;
        }
        // verificar se foi passado um id de encomenda
        if (!isset($_GET['id'])) {
            Store::redirect('historico_encomendas');
            return;
        }
        $_id_encomenda = null;

        //verifica se o id_incomenda é uma string com 32 caracteres
        if (strlen($_GET['id']) != 32) {
            Store::redirect();
            return;
        } else {

            // descriptar id da encomenda
            $id_encomenda = Store::aesDesencriptar($_GET['id']);
            if (empty($id_encomenda)) {
                Store::redirect();
                return;
            }
        }


        $encomenda = new Encomendas();

        // verificar se encomenda pretence ao cliente
        $verificar_encomenda_cliente = $encomenda->verificar_encomenda_cliente($_SESSION['cliente'], $id_encomenda);

        if ($verificar_encomenda_cliente != $id_encomenda) {
            Store::redirect('historico_encomendas');
            return;
        }

        //obter os detalhes da encomenda
        $detalhes_encomenda = $encomenda->obter_detalhes_encomenda($id_encomenda);

        //calcular o valor total da encomenda
        $total = 0;

        foreach ($detalhes_encomenda['produtos_encomenda'] as $produtos) {
            $total += $produtos->preco_unidade * $produtos->quantidade;
        }

        // prepara dados para a view dos detalhes da encomenda
        $dados = [
            'dados_encomenda' => $detalhes_encomenda['dados_encomenda'],
            'produtos_encomenda' => $detalhes_encomenda['produtos_encomenda'],
            'total_encomenda' => $total,
        ];

        // apresentar view dos detalhes da encomenda
        Store::Layout([
            'layouts/html_header',
            'layouts/header',
            'detalhes_encomendas',
            'layouts/footer',
            'layouts/html_footer',
        ], $dados);
    }
    //=================================================================
    public function comentarios_clientes()
    {

        //verificar a pagina passada na query string
        if (!is_numeric($_GET['page'])) {

            Store::redirect('comentarios_cleintes');
            return;
        }
        if (isset($_GET['page'])) {

            $pagina = $_GET['page'];
        } else {

            $pagina = 1;
        }
        $user = new Users();
        $comentarios = $user->obter_comentarios_clientes($pagina);

        $dados = [
            'comentarios' => $comentarios,
        ];


        Store::Layout([
            'layouts/html_header',
            'layouts/header',
            'comentarios_clientes',
            'layouts/footer',
            'layouts/html_footer'
        ], $dados);
    }

    //================================================================
    public function comentarios_clientes_submit()
    {
        // verificar se exiete um cliente logado
        if (!Store::clienteLogado()) {
            Store::redirect();
            return;
        }

        // verificar se exsite um formulário submetido
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            Store::redirect();
            return;
        }

        // obter dados do POST
        $comentario = htmlspecialchars(trim($_POST['comentario']));
        $rating = $_POST['rating'];

        $user = new Users();
        $user->submit_comentario($_SESSION['cliente'], $comentario, $rating);
        Store::redirect('comentarios_clientes');
    }

    //=================================================================

    public function pesquisa_produto()
    {
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            Store::redirect();
            return;
        }

        $produto = htmlspecialchars(trim($_POST['search']));
        if (str_ends_with($produto, 's')) {
            $produto = substr($produto, 0, -1);
        }

        $produtos = new Produtos();
        $pesquisa = $produtos->pesquisa_de_produtos($produto);

        if (count($pesquisa) == 0) {
            $_SESSION['erro'] = 'Produto não encontrado.';
            Store::redirect();
            return;
        } else {

            $dados = [
                'pesquisa' => $pesquisa,
            ];
        };

        Store::Layout([
            'layouts/html_header',
            'layouts/header',
            'pesquisa_produto',
            'layouts/footer',
            'layouts/html_footer'
        ], $dados);
    }

    //===================================================================
    public function formas_pagamento()
    {

        //verificar se existe cliente logado
        if (!Store::clienteLogado()) {
            Store::redirect();
            return;
        }

        // verificar se foi passado algum valor pela query string
        if (!isset($_GET['id'])) {
            Store::redirect('?q=detalhe_encomenda&id=' . $_GET['id']);
            return;
        };

        // verificar se o valor passado é válido
        if (strlen($_GET['id']) != 32) {
            Store::redirect('?q=detalhe_encomenda&id=' . $_GET['id']);
            return;
        }
        $codigo_encomenda = Store::aesDesencriptar($_GET['id']);

        if (empty($codigo_encomenda)) {
            Store::redirect('?q=detalhe_encomenda&id=' . $_GET['id']);
            return;
        }

        $encomenda = new Encomendas();
        $dados_encomenda = $encomenda->obter_detalhes_encomenda($codigo_encomenda);
        //calcular o valor total da encomenda
        $total = 0;

        foreach ($dados_encomenda['produtos_encomenda'] as $produtos) {
            $total += $produtos->preco_unidade * $produtos->quantidade;
        }

        $dados = [
            'dados_encomenda' => $dados_encomenda,
            'total_encomenda' => $total,
        ];



        Store::Layout([
            'layouts/html_header',
            'layouts/header',
            'formas_pagamento',
            'layouts/footer',
            'layouts/html_footer'
        ], $dados);
    }
    //=================================================================
    public function pagamento_tranferencia()
    {

        // simulação do webhook do getaway de pagamento
        if (!Store::clienteLogado()) {
            Store::redirect();
            return;
        }

        // verificar se o código da encomenda vem indicado

        if (!isset($_GET['codigo'])) {
            Store::redirect('?q=detalhe_encomenda&id=' . $_GET['codigo']);
            return;
        };

        // verificar se o valor passado é válido
        if (strlen($_GET['codigo']) != 32) {
            Store::redirect('?q=detalhe_encomenda&id=' . $_GET['codigo']);
            return;
        }
        $codigo_encomenda = Store::aesDesencriptar($_GET['codigo']);

        if (empty($codigo_encomenda)) {
            Store::redirect('?q=detalhe_encomenda&id=' . $_GET['codigo']);
            return;
        }

        // verificar se existe o código ativo (PENDENTE)
        $encomenda = new Encomendas();
        $user = new Users();
        $dados_cliente = $user->buscar_dados_user($_SESSION['cliente']);

        $dados_encomenda = $encomenda->obter_detalhes_encomenda_por_codigo($codigo_encomenda);
        $resultado = $encomenda->efetuar_pagamento($codigo_encomenda);
        //calcular o valor total da encomenda
        $total = 0;

        foreach ($dados_encomenda['produtos_encomenda'] as $produtos) {
            $total += $produtos->preco_unidade * $produtos->quantidade;
        }

        $dados = [
            'dados_encomenda' => $encomenda->obter_detalhes_encomenda_por_codigo($codigo_encomenda),
            'total_encomenda' => $total,
        ];

        if ($resultado) {

            $email_pagamento = new EnviarEmail();
            $email_pagamento->enviar_email_dados_pagamento($dados_cliente->email, $dados);
            Store::redirect('historico_encomendas');
            return;
        }
    }

    //=================================================================
    public function pagamento_mbway()
    {

        // verificar se existe cliente logado
        if (!Store::clienteLogado()) {
            Store::redirect();
            return;
        }

        // verificar se foi passado algum valor pela query string
        if (!isset($_GET['codigo'])) {
            die('aqui1');
            Store::redirect('?q=formas_pagamento&id=' . $_GET['codigo']);
            return;
        };

        // verificar se o valor passado é válido
        if (strlen($_GET['codigo']) != 32) {
            die('aqui2');
            Store::redirect('?q=formas_pagamento&id=' . $_GET['codigo']);
            return;
        }
        $codigo_encomenda = Store::aesDesencriptar($_GET['codigo']);

        if (empty($codigo_encomenda)) {
            die('aqui3');
            Store::redirect('?q=formas_pagamento&id=' . $_GET['codigo']);
            return;
        }

        //passar dados para view
        $dados = [
            'codigo_encomenda' => $codigo_encomenda,
        ];
        Store::Layout([
            'layouts/html_header',
            'layouts/header',
            'pagamento_mbway',
            'layouts/footer',
            'layouts/html_footer'
        ], $dados);
    }
    //=================================================================
    public function pagamento_mbway_submit()
    {

        // verificar se cliente logado
        if (!Store::clienteLogado()) {
            Store::redirect();
            return;
        }

        // verificar se foi submetido um formulário
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            Store::redirect('historico_encomendas');
            return;
        }
        $codigo_encomenda = Store::aesDesencriptar($_POST['codigo_encomenda']);

        $encomenda = new Encomendas();
        $resultado = $encomenda->efetuar_pagamento($codigo_encomenda);

        if ($resultado) {

            Store::redirect('historico_encomendas');
            return;
        }
    }
}
