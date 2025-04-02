<?php



namespace core\controllers;

use core\classes\Store;
use core\classes\DataBase;
use core\classes\EnviarEmail;
use core\classes\PDF;
use core\models\AdminModel;



class Admin
{

    //================================================================
    // email = admin@admin.com
    // password = 1234
    //================================================================

    //================================================================
    public function index()
    {


        // verifica de existe algum admin logado
        if (!Store::adminLogado()) {

            Store::redirectAdmin('admin_login');
            return;
        }

        // verificar se existem ecomendas em estado PENDENTES
        $admin = new AdminModel();
        $total_encomendas_pendentes = $admin->total_encomendas_pendentes();
        $total_encomendas_em_processamento = $admin->total_encomendas_em_processamento();
        $total_encomendas_enviadas = $admin->total_encomendas_enviadas();
        $total_encomendas_canceladas = $admin->total_encomendas_canceladas();
        $total_encomendas_entregues = $admin->total_encomendas_entregues();



        // já existe um admin logado
        // preparar dados para serem enviados para a view
        $dados = [
            'total_encomendas_pendentes' => $total_encomendas_pendentes,
            'total_encomendas_em_processamento' => $total_encomendas_em_processamento,
            'total_encomendas_enviadas' => $total_encomendas_enviadas,
            'total_encomendas_canceladas' => $total_encomendas_canceladas,
            'total_encomendas_entregues' => $total_encomendas_entregues
        ];

        Store::Layout_admin([
            'admin/layouts/html_header',
            'admin/layouts/header',
            'admin/home',
            'admin/layouts/footer',
            'admin/layouts/html_footer'
        ], $dados);
    }

    //================================================================
    // AUTENTICAÇÂO
    //================================================================

    public function admin_login()
    {


        // verifica de existe algum admin logado
        if (Store::adminLogado()) {

            Store::redirectAdmin('index');
            return;
        }

        // apresenta login
        Store::Layout_admin([
            'admin/layouts/html_header',
            'admin/layouts/header',
            'admin/login',
            'admin/layouts/footer',
            'admin/layouts/html_footer'
        ]);
    }

    //================================================================
    public function admin_login_submit()
    {


        // verificar se existe algum admin logado
        if (Store::adminLogado()) {

            Store::redirectAdmin('index');
            return;
        }
        // verificar se foi submetido algum formulário
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            Store::redirectAdmin('index');
            return;
        }

        //verificar se o login é valido


        //validar se os campos vieram corretamente preenchidos

        if (!isset($_POST['admin_email']) || !isset($_POST['admin_password']) || !filter_var(trim($_POST['admin_email']), FILTER_VALIDATE_EMAIL)) {

            // erro de preenchimento do login
            $_SESSION['erro'] = 'Login inválido';
            Store::redirectAdmin('admin_login');
            return;
        }

        //preparação dos dados para o model

        $admin_email = trim(strtolower($_POST['admin_email']));
        $admin_password = $_POST['admin_password'];



        // carregamento do model e verificação do login válido
        $admin = new AdminModel();
        $resultado = $admin->validar_admin_login($admin_email, $admin_password);


        //analise do resultado
        if (is_bool($resultado)) {

            // login inválido
            $_SESSION['erro'] = 'Login inválido';
            Store::redirectAdmin('admin_login');
            return;
        } else {

            // login válido colocar dados do admin na sessão

            $_SESSION['admin'] = $resultado->id_admin;
            $_SESSION['admin_email'] = $resultado->email;


            //redirecionar para página inicial do Backoffice

            Store::redirectAdmin('index');
        }
    }

    //================================================================
    public function admin_logout()
    {

        // realizar logout do admin
        unset($_SESSION['admin']);
        unset($_SESSION['admin_email']);
        Store::redirectAdmin('index');
    }

    //================================================================
    // CLIENTES
    //================================================================

    public function lista_clientes()
    {
        // verificar se existe algum admin logado
        // verificar se existe algum admin logado
        if (!Store::adminLogado()) {
            Store::redirectAdmin('admin_login');
            return;
        }
        // carregar a lista de clientes
        $admin = new AdminModel();
        $lista_clientes = $admin->lista_clientes();



        // apresenta a lista de clientes 
        $dados = [
            'lista_clientes' => $lista_clientes,
        ];
        // apresenta a página dos clientes
        Store::Layout_admin([
            'admin/layouts/html_header',
            'admin/layouts/header',
            'admin/lista_clientes',
            'admin/layouts/footer',
            'admin/layouts/html_footer'
        ], $dados);
    }

    //================================================================
    public function detalhes_cliente()
    {

        // verificar se existe algum admin logado
        if (!Store::adminLogado()) {
            Store::redirectAdmin('admin_login');
            return;
        }

        // verificar se foi passdo algum valor na query string
        if (!isset($_GET['id'])) {
            Store::redirectAdmin();
            return;
        }
        if (strlen($_GET['id']) != 32) {
            Store::redirectAdmin();
            return;
        }

        $id_cliente = Store::aesDesencriptar($_GET['id']);

        //verificar de o id cliente é válido
        if (empty($id_cliente)) {
            Store::redirectAdmin();
            return;
        }


        // obter os detalhes do cliente
        $admin = new AdminModel();
        $detalhes_cliente = $admin->detalhes_cliente($id_cliente);
        $total_encomendas = $admin->total_encomendas_cliente($id_cliente);


        // carregar os dados da view

        $dados = [
            'detalhes_cliente' => $detalhes_cliente,
            'total_encomendas' => $total_encomendas,
        ];
        // carrega os detalhes do cliente na view
        Store::Layout_admin([
            'admin/layouts/html_header',
            'admin/layouts/header',
            'admin/detalhes_cliente',
            'admin/layouts/footer',
            'admin/layouts/html_footer'
        ], $dados);
    }

    //================================================================
    public function cliente_historico_encomendas()
    {

        // verificar se existe algum admin logado
        if (!Store::adminLogado()) {
            Store::redirectAdmin('admin_login');
            return;
        }

        // verificar se foi passado algum valor na query string
        if (!isset($_GET['id'])) {
            Store::redirectAdmin('detalhes_cliente');
            return;
        }

        // verficar se o valor passado na query string é válido
        if (strlen($_GET['id']) != 32) {
            Store::redirectAdmin('detalhes_cliente');
            return;
        }

        $id_cliente = Store::aesDesencriptar($_GET['id']);

        if (empty($id_cliente)) {
            Store::redirectAdmin('detalhes_cliente');
            return;
        }

        // carregar historico de encomenddas do cleinte
        $admin = new AdminModel();
        $historico_encomendas = $admin->historico_encomendas_cliente($id_cliente);


        $dados = [
            'historico_encomendas' => $historico_encomendas,

        ];

        // carrega o histórico  do cliente na view
        Store::Layout_admin([
            'admin/layouts/html_header',
            'admin/layouts/header',
            'admin/historico_encomendas_cliente',
            'admin/layouts/footer',
            'admin/layouts/html_footer'
        ], $dados);
    }

    //================================================================
    public function ativar_cliente()
    {

        //verificar se existe admin logado

        if (!Store::adminLogado()) {
            Store::redirectAdmin('admin_login');
            return;
        }

        //verificar se foi passado valor pela query string

        if (!isset($_GET['id'])) {
            Store::redirectAdmin('lista_clientes');
            return;
        }

        // verificar se o valor passado é válido
        if (strlen($_GET['id']) != 32) {
            Store::redirectAdmin('lista_clientes');
            return;
        }

        $id_cliente = Store::aesDesencriptar($_GET['id']);

        if (empty($id_cliente)) {
            Store::redirectAdmin('lista_clientes');
            return;
        }

        // alterar o estadodo cliente para ativo

        $admin = new AdminModel();
        $ativo = 1;
        $admin->alterar_estado_cliente($id_cliente, $ativo);

        Store::redirectAdmin('lista_clientes');
    }

    //================================================================
    public function desativar_cliente()
    {

        //verificar se existe admin logado

        if (!Store::adminLogado()) {
            Store::redirectAdmin('admin_login');
            return;
        }

        //verificar se foi passado valor pela query string

        if (!isset($_GET['id'])) {
            Store::redirectAdmin('lista_clientes');
            return;
        }

        // verificar se o valor passado é válido
        if (strlen($_GET['id']) != 32) {
            Store::redirectAdmin('lista_clientes');
            return;
        }

        $id_cliente = Store::aesDesencriptar($_GET['id']);

        if (empty($id_cliente)) {
            Store::redirectAdmin('lista_clientes');
            return;
        }

        // alterar o estadodo cliente para ativo

        $admin = new AdminModel();
        $ativo = 0;
        $admin->alterar_estado_cliente($id_cliente, $ativo);

        Store::redirectAdmin('lista_clientes');
    }

    //================================================================
    // ENCOMENDAS
    //================================================================

    public function lista_encomendas()
    {
        // verificar se existe algum admin logado
        if (!Store::adminLogado()) {
            Store::redirectAdmin('admin_login');
            return;
        }

        // apresenta a lista de encomendas (com filtro se este estiver defenido )
        $filtros = [
            'pendente' => 'PENDENTE',
            'pago' => 'PAGO',
            'em_processamento' => 'EM PROCESSAMENTO',
            'enviada' => 'ENVIADA',
            'cancelada' => 'CANCELADA',
            'entregue' => 'ENTREGUE'
        ];
        $filtro = '';
        // verifica se existe um filtro na query string
        if (isset($_GET['f'])) {
            //verifica se a variável é uma key dos filtros
            if (key_exists($_GET['f'], $filtros)) {
                $filtro = $filtros[$_GET['f']];
            }
        }

        // fazer verificações do id cliente passado na query string

        // obter o id cliente se existir na query string
        $id_cliente = null;
        if (isset($_GET['c'])) {
            $id_cliente = Store::aesDesencriptar($_GET['c']);
        }

        // carregar lista de encomendas
        $admin = new AdminModel();
        $lista_encomendas = $admin->lista_encomendas($filtro, $id_cliente);



        // prepara dados para a view da lista de encomendas
        $dados = [
            'lista_encomendas' => $lista_encomendas,
            'filtro' => $filtro,
        ];
        // apresenta a página das encomendas
        Store::Layout_admin([
            'admin/layouts/html_header',
            'admin/layouts/header',
            'admin/lista_encomendas',
            'admin/layouts/footer',
            'admin/layouts/html_footer'
        ], $dados);
    }

    //================================================================

    public function detalhe_encomenda()
    {

        // verificar se existe algum admin logado
        if (!Store::adminLogado()) {
            Store::redirectAdmin('admin_login');
            return;
        }

        // verificar se foi passado algum valor na query string

        if (!isset($_GET['id'])) {
            Store::redirectAdmin('lista_encomendas');
            return;
        }

        // verificar se o valor passado na query string é válido
        if (strlen($_GET['id']) != 32) {
            Store::redirectAdmin('lista_encomendas');
            return;
        }

        $id_encomenda = Store::aesDesencriptar($_GET['id']);

        if (empty($id_encomenda)) {
            Store::redirectAdmin('lista_encomendas');
            return;
        }

        // carregar detalhes da encomenda
        $admin = new AdminModel();
        $encomenda = $admin->detalhes_encomenda($id_encomenda);

        $dados = [
            'encomenda' => $encomenda,
        ];

        // carrega os detalhes da encomenda na view
        Store::Layout_admin([
            'admin/layouts/html_header',
            'admin/layouts/header',
            'admin/detalhe_encomenda',
            'admin/layouts/footer',
            'admin/layouts/html_footer'
        ], $dados);
    }

    //================================================================
    public function encomenda_alterar_estado()
    {
        // verificar se exiete um admin logado
        if (!Store::adminLogado()) {
            Store::redirectAdmin('admin_login');
            return;
        }

        // verificar se foram passados os valores na query string
        if (!isset($_GET['id']) && !isset($_GET['s'])) {
            Store::redirectAdmin();
            return;
        }

        // verificar se o estado passado na query string é válido
        if (!in_array($_GET['s'], STATUS)) {
            Store::redirectAdmin();
            return;
        }

        //verificar se o valor do id da encomenda passado na query string é válido
        if (strlen($_GET['id']) != 32) {
            Store::redirectAdmin();
            return;
        }

        $id_encomenda = Store::aesDesencriptar($_GET['id']);
        $estado = $_GET['s'];

        if (empty($id_encomenda)) {
            Store::redirectAdmin();
            return;
        }

        // regras de negócio para gerir a encomenda (novo estado)

        // atualizar estado da encomenda
        $admin = new AdminModel();

        switch ($estado) {
            case 'PENDENTE':
                $admin->alterar_estado_encomenda($id_encomenda, $estado);
                $this->operacao_notificacao_mudanca_estado($id_encomenda);
                break;
            case 'EM PROCESSAMENTO':
                $admin->alterar_estado_encomenda($id_encomenda, $estado);
                $this->operacao_notificacao_mudanca_estado($id_encomenda);
                break;
            case 'ENVIADA':
                $admin->alterar_estado_encomenda($id_encomenda, $estado);
                $this->operacao_email_encomenda_enviada($id_encomenda);
                break;
            case 'CANCELADA':
                $admin->alterar_estado_encomenda($id_encomenda, $estado);
                $this->operacao_email_encomenda_cancelada($id_encomenda);
                break;
            case 'ENTREGUE':
                $admin->alterar_estado_encomenda($id_encomenda, $estado);
                $this->operacao_notificacao_mudanca_estado($id_encomenda);
                break;
        }

        // redireciona para a página da própria encomenda
        Store::redirectAdmin("detalhe_encomenda&id=" . $_GET['id']);
    }

    //================================================================
    // OPERAÇÔES APÒS MUDANÇA DE ESTADO
    //================================================================

    private function operacao_notificacao_mudanca_estado($id_encomenda)
    {

        $admin = new AdminModel();
        $dados_encomenda = $admin->detalhes_encomenda($id_encomenda);
        $email_cliente = $dados_encomenda['dados_encomenda']->email;

        // código para envio de email com a informação de encomenda enviada
        $email = new EnviarEmail();
        $resultado = $email->email_mudanca_estado($email_cliente, $dados_encomenda);
    }

    //================================================================

    private function operacao_email_encomenda_enviada($id_encomenda)
    {
        $admin = new AdminModel();
        $dados_encomenda = $admin->detalhes_encomenda($id_encomenda);
        $email_cliente = $dados_encomenda['dados_encomenda']->email;

        // código para envio de email com a informação de encomenda enviada
        $email = new EnviarEmail();
        $resultado = $email->email_encomenda_enviada($email_cliente, $dados_encomenda);
    }

    //================================================================
    private function operacao_email_encomenda_cancelada($id_encomenda)
    {

        $admin = new AdminModel();
        $dados_encomenda = $admin->detalhes_encomenda($id_encomenda);
        $email_cliente = $dados_encomenda['dados_encomenda']->email;

        // código para envio de email com a informação de encomenda enviada
        $email = new EnviarEmail();
        $resultado = $email->email_encomenda_cancelada($email_cliente, $dados_encomenda);
    }

    //================================================================
    public function criar_pdf_encomenda()
    {

        // verificar se existe algum admin logado
        if (!Store::adminLogado()) {
            Store::redirectAdmin('admin_login');
            return;
        }

        // verificar se foi passado algum valor na query string
        if (!isset($_GET['e'])) {

            Store::redirectAdmin('detalhe_encomenda&id=' . $_GET['e']);
            return;
        }

        // verificar se o valor passado na query string é válido
        if (strlen($_GET['e']) != 32) {

            Store::redirectAdmin('detalhe_encomenda&id=' . $_GET['e']);
            return;
        }

        $id_encomenda = Store::aesDesencriptar($_GET['e']);

        if (empty($id_encomenda)) {

            Store::redirectAdmin('detalhe_encomenda&id=' . $_GET['e']);
            return;
        }

        // obter dados da encomenda
        $admin = new AdminModel();
        $dados_encomenda = $admin->detalhes_encomenda($id_encomenda);
        $dados_cliente = $admin->detalhes_cliente($dados_encomenda['dados_encomenda']->id_cliente);



        // gerar PDF com os dados obtidos

        $pdf = new PDF();

        $pdf->set_font_family('courier new');
        $pdf->set_font_size('12px');

        $pdf->set_position_dimension(250, 135, 100, 30);
        $pdf->write(substr($dados_encomenda['dados_encomenda']->data_encomenda, 0, 10));

        $pdf->set_position_dimension(570, 135, 100, 30);
        $pdf->write($dados_encomenda['dados_encomenda']->codigo_encomenda);

        $pdf->set_position_dimension(80, 200, 600, 20);
        $pdf->write($dados_cliente->nome_completo);

        $pdf->set_position_dimension(80, 220, 600, 20);
        $pdf->write($dados_cliente->morada);

        $pdf->set_position_dimension(80, 240, 600, 20);
        $pdf->write($dados_cliente->cod_postal);

        $pdf->set_position_dimension(140, 240, 600, 20);
        $pdf->write($dados_cliente->localidade);

        $pdf->set_x(80);
        $pdf->set_y(350);
        $pdf->set_width(600);
        $pdf->set_height(20);
        $pdf->set_position_dimension(80, 350, 600, 20);
        $pdf->write('Produto');

        $pdf->set_position_dimension(360, 350, 600, 20);
        $pdf->write('Quantidade');

        $pdf->set_position_dimension(660, 350, 600, 20);
        $pdf->write('Preço/Uni.');

        $pdf->set_position_dimension(80, 365, 670, 20);
        $pdf->write('<hr>');

        $total = 0;
        $y = 390;
        foreach ($dados_encomenda['produtos_encomenda'] as $produtos) {


            $pdf->set_position_dimension(90, $y, 600, 20);
            $pdf->write($produtos->designacao_produto);
            $pdf->set_position_dimension(390, $y, 600, 20);
            $pdf->write($produtos->quantidade);
            $pdf->set_position_dimension(680, $y, 600, 20);
            $pdf->write($produtos->preco_unidade);

            $y += 30;
            $total += $produtos->quantidade * $produtos->preco_unidade;
        }


        $pdf->set_align('right');
        $pdf->set_font_size('30px');
        $pdf->set_font_weight('bold');
        $pdf->set_position_dimension(80, 765, 670, 30);

        $pdf->write('Total : ' . number_format($total, 2, ',', '.') . '€');


        $pdf->set_pdf_template(getcwd() . '/assets/templates_pdf/nota_encomenda.pdf');

        $pdf->show_pdf();
    }

    //================================================================
    public function enviar_pdf_encomenda()
    {

        // verificar se existe algum admin logado
        if (!Store::adminLogado()) {
            Store::redirectAdmin('admin_login');
            return;
        }

        // verificar se foi passado algum valor pela query string

        if (!isset($_GET['e'])) {
            Store::redirectAdmin('detalhe_encomenda&id=' . $_GET['e']);
            return;
        }

        // verificar se o valor passdo pela query string é válido

        if (strlen($_GET['e']) != 32) {
            Store::redirectAdmin('detalhe_encomenda&id=' . $_GET['e']);
            return;
        }

        $id_encomenda = Store::aesDesencriptar($_GET['e']);

        if (empty($id_encomenda)) {
            Store::redirectAdmin('detalhe_encomenda&id=' . $_GET['e']);
            return;
        }

        // obter dados da encomenda
        $admin = new AdminModel();
        $dados_encomenda = $admin->detalhes_encomenda($id_encomenda);
        $dados_cliente = $admin->detalhes_cliente($dados_encomenda['dados_encomenda']->id_cliente);


        // gerar PDF com os dados obtidos

        $pdf = new PDF();

        $pdf->set_pdf_template(getcwd() . '/assets/templates_pdf/nota_encomenda.pdf');

        $pdf->set_font_family('courier new');
        $pdf->set_font_size('12px');

        $pdf->set_position_dimension(250, 135, 100, 30);
        $pdf->write(substr($dados_encomenda['dados_encomenda']->data_encomenda, 0, 10));

        $pdf->set_position_dimension(570, 135, 100, 30);
        $pdf->write($dados_encomenda['dados_encomenda']->codigo_encomenda);

        $pdf->set_position_dimension(80, 200, 600, 20);
        $pdf->write($dados_cliente->nome_completo);

        $pdf->set_position_dimension(80, 220, 600, 20);
        $pdf->write($dados_cliente->morada);

        $pdf->set_position_dimension(80, 240, 600, 20);
        $pdf->write($dados_cliente->cod_postal);

        $pdf->set_position_dimension(140, 240, 600, 20);
        $pdf->write($dados_cliente->localidade);

        $pdf->set_x(80);
        $pdf->set_y(350);
        $pdf->set_width(600);
        $pdf->set_height(20);
        $pdf->set_position_dimension(80, 350, 600, 20);
        $pdf->write('Produto');

        $pdf->set_position_dimension(360, 350, 600, 20);
        $pdf->write('Quantidade');

        $pdf->set_position_dimension(660, 350, 600, 20);
        $pdf->write('Preço/Uni.');

        $pdf->set_position_dimension(80, 365, 670, 20);
        $pdf->write('<hr>');

        $total = 0;
        $y = 390;
        foreach ($dados_encomenda['produtos_encomenda'] as $produtos) {


            $pdf->set_position_dimension(90, $y, 600, 20);
            $pdf->write($produtos->designacao_produto);
            $pdf->set_position_dimension(390, $y, 600, 20);
            $pdf->write($produtos->quantidade);
            $pdf->set_position_dimension(680, $y, 600, 20);
            $pdf->write($produtos->preco_unidade);

            $y += 30;
            $total += $produtos->quantidade * $produtos->preco_unidade;
        }


        $pdf->set_align('right');
        $pdf->set_font_size('30px');
        $pdf->set_font_weight('bold');
        $pdf->set_position_dimension(80, 765, 670, 30);


        // apresentar pdf criado

        $pdf->write('Total : ' . number_format($total, 2, ',', '.') . '€');
        $ficheiro = $dados_encomenda['dados_encomenda']->codigo_encomenda . '_' . date('YmdHis') . '.pdf';
        $email_cliente = $dados_cliente->email;

        $pdf->save_pdf($ficheiro);

        // enviar o email com ficheiro em anexo

        $email = new EnviarEmail();
        $resultado = $email->enviar_pdf_encomenda_para_cliente($email_cliente, $ficheiro);

        if ($resultado) {
            $_SESSION['sucesso'] = 'Email enviado com sucesso.';
            Store::redirectAdmin('detalhe_encomenda&id=' . $_GET['e']);
            //eliminar o ficheiro pdf enviado 
            unlink(PDF_PATH . $ficheiro);
            return;
        } else {
            $_SESSION['erro'] = 'Ocurreu um erro com o envio do email.';
            Store::redirectAdmin('detalhe_encomenda&id=' . $_GET['e']);
            return;
        }
    }

    //================================================================
    // PRODUTOS
    //================================================================

    public function consultar_produtos()
    {
        // verificar se existe um admin logado
        if (!Store::adminLogado()) {
            Store::redirect('admin_login');
            return;
        }

        // obter dados de produtos da base de dados
        $admin = new AdminModel();
        $produtos = $admin->obter_produtos_na_db();

        $dados = [
            'produtos' => $produtos,
        ];

        Store::Layout_admin([
            'admin/layouts/html_header',
            'admin/layouts/header',
            'admin/consultar_produtos',
            'admin/layouts/footer',
            'admin/layouts/html_footer'
        ], $dados);
    }

    //================================================================
    public function adicionar_produtos()
    {
        // verificar se existe um admin logado
        if (!Store::adminLogado()) {
            Store::redirectAdmin('admin_login');
            return;
        }

        // obter categorias da db
        $admin = new AdminModel();
        $categorias = $admin->obter_categorias();


        $dados = [
            'categorias' => $categorias,
        ];

        Store::Layout_admin([
            'admin/layouts/html_header',
            'admin/layouts/header',
            'admin/adicionar_produtos',
            'admin/layouts/footer',
            'admin/layouts/html_footer'
        ], $dados);
    }

    //================================================================

    public function submeter_produto()
    {


        // verificar se existe um admin logado
        if (!Store::adminLogado()) {
            Store::redirectAdmin('admin_login');
            return;
        }

        // verificar se foi submetido um formulário

        if ($_SERVER['REQUEST_METHOD'] != 'POST') {

            Store::redirectAdmin();
            return;
        }




        // validar se o dados do formulário estão todos preenchidos
        if (empty($_POST['produto-nome']) || empty($_POST['produto-descricao']) || empty($_POST['produto-categoria']) || empty($_POST['produto-preco']) || empty($_POST['produto-stock']) || empty($_FILES['produto-imagem'])) {

            $_SESSION['erro'] = "Todos os campos do formulário deve ser preenchidos.";
            Store::redirectAdmin('adicionar_produtos');
            return;
        }

        // validar o preço do produto
        if (!is_numeric($_POST['produto-preco']) || $_POST['produto-preco'] <= 0) {
            $_SESSION['erro'] = "Introduza um preço válido.";
            Store::redirectAdmin('adicionar_produtos');
            return;
        }

        // validar o stock do produto
        if (!is_numeric($_POST['produto-stock']) || $_POST['produto-stock'] <= 0) {
            $_SESSION['erro'] = "Introduza um stock válido.";
            Store::redirectAdmin('adicionar_produto');
            return;
        }

        // validar o formato da imagem
        if ($_FILES['produto-imagem']['type'] != 'image/jpeg' && $_FILES['produto-imagem']['type'] != 'image/png') {
            $_SESSION['erro'] = "Só é permitido o upload de ficheiros JPEG ou PNG.";
            Store::redirectAdmin('adicionar_produtos');
            return;
        }

        // validar o tamanho da imagem
        if ($_FILES['produto-imagem']['size'] > 10000000) {
            $_SESSION['erro'] = "o ficheiro de imagem não pode exceder os 10MB.";
            Store::redirectAdmin('adicionar_produtos');
            return;
        }


        $nome_produto = htmlspecialchars(trim(ucwords($_POST['produto-nome'])));
        $descricao_produto = htmlspecialchars(trim(ucfirst($_POST['produto-descricao'])));
        $categoria_produto = $_POST['produto-categoria'];
        $preco_produto = htmlspecialchars(trim($_POST['produto-preco']));
        $stock_produto = htmlspecialchars(trim($_POST['produto-stock']));
        $visibilidade_produto = $_POST['produto-visivel'];
        $imagem_produto = "assets/img/produtos/" . $_FILES['produto-imagem']['name'];

        if (str_ends_with($nome_produto, 's')) {
            $nome_produto = substr($nome_produto, 0, -1);
        }

        $dados_produto = [
            'nome' => $nome_produto,
            'descricao' => $descricao_produto,
            'categoria' => $categoria_produto,
            'preco' => $preco_produto,
            'stock' => $stock_produto,
            'visivel' => $visibilidade_produto,
            'imagem' => $imagem_produto,
        ];

        $admin = new AdminModel();
        $admin->adicionar_produtos($dados_produto);

        // guardar imagem na pasta

        $pasta_imagens = getcwd() . '/assets/img/produtos/' . $_FILES['produto-imagem']['name'];

        move_uploaded_file($_FILES['produto-imagem']['tmp_name'], $pasta_imagens);

        Store::redirectAdmin('consultar_produtos');
    }

    //================================================================
    public function editar_produto()
    {

        // verificar se existe um admin logado
        if (!Store::adminLogado()) {
            Store::redirectAdmin('admin_login');
            return;
        }

        // verificar se foi passado valor pela query string
        if (!isset($_GET['id'])) {
            Store::redirectAdmin('consultar_produtos');
            return;
        }

        //verificar se o valor passado é válido 
        if (strlen($_GET['id']) != 32) {
            Store::redirectAdmin('consultar_produtos');
            return;
        }

        $id_produto = Store::aesDesencriptar($_GET['id']);

        if (empty($id_produto)) {
            Store::redirectAdmin('consultar_produtos');
            return;
        }

        // obter dados do produto

        $admin = new AdminModel();



        $dados = [
            'dados_produto' => $admin->obter_dados_produto($id_produto),
            'categorias' => $admin->obter_categorias(),
        ];

        Store::Layout_admin([
            'admin/layouts/html_header',
            'admin/layouts/header',
            'admin/editar_produtos',
            'admin/layouts/footer',
            'admin/layouts/html_footer'
        ], $dados);
    }

    //================================================================
    public function atualaizar_produto()
    {



        // verificar se existe um admin logado
        if (!Store::adminLogado()) {
            Store::redirectAdmin('admin_login');
            return;
        }

        // verificar se foi submetido um formulário

        if ($_SERVER['REQUEST_METHOD'] != 'POST') {

            Store::redirectAdmin('editar_produto&id=' . Store::aesEncriptar($_POST['id_produto']));
            return;
        }


        // validar se o dados do formulário estão todos preenchidos
        if (empty($_POST['produto-nome']) || empty($_POST['produto-descricao']) || empty($_POST['produto-categoria']) || empty($_POST['produto-preco']) || empty($_POST['produto-stock'])) {

            $_SESSION['erro'] = "Todos os campos do formulário deve ser preenchidos.";
            Store::redirectAdmin('editar_produto&id=' . Store::aesEncriptar($_POST['id_produto']));
            return;
        }

        // validar o preço do produto
        if (!is_numeric($_POST['produto-preco']) || $_POST['produto-preco'] <= 0) {
            $_SESSION['erro'] = "Introduza um preço válido.";
            Store::redirectAdmin('editar_produto&id=' . Store::aesEncriptar($_POST['id_produto']));
            return;
        }

        // validar o stock do produto
        if (!is_numeric($_POST['produto-stock']) || $_POST['produto-stock'] <= 0) {
            $_SESSION['erro'] = "Introduza um stock válido.";
            Store::redirectAdmin('editar_produto&id=' . Store::aesEncriptar($_POST['id_produto']));
            return;
        }

        $id_produto = $_POST['id_produto'];
        $nome_produto = htmlspecialchars(trim(ucwords($_POST['produto-nome'])));
        $descricao_produto = htmlspecialchars(trim(ucfirst($_POST['produto-descricao'])));
        $categoria_produto = $_POST['produto-categoria'];
        $preco_produto = htmlspecialchars(trim($_POST['produto-preco']));
        $stock_produto = htmlspecialchars(trim($_POST['produto-stock']));
        $visibilidade_produto = $_POST['produto-visivel'];


        if (str_ends_with($nome_produto, 's')) {
            $nome_produto = substr($nome_produto, 0, -1);
        }

        $dados_produto = [
            'id_produto' => $id_produto,
            'nome' => $nome_produto,
            'descricao' => $descricao_produto,
            'categoria' => $categoria_produto,
            'preco' => $preco_produto,
            'stock' => $stock_produto,
            'visivel' => $visibilidade_produto,

        ];

        $admin = new AdminModel();
        $admin->atualizar_produto($dados_produto);

        Store::redirectAdmin('consultar_produtos');
    }

    //================================================================
    // CATEGORIAS
    //================================================================
    public function adicionar_categorias()
    {


        Store::Layout_admin([
            'admin/layouts/html_header',
            'admin/layouts/header',
            'admin/adicionar_categoria',
            'admin/layouts/footer',
            'admin/layouts/html_footer',
        ]);
    }

    //================================================================
    public function submeter_categoria()
    {

        // verificar se existe um admin logado
        if (!Store::adminLogado()) {
            Store::redirectAdmin('admin_login');
            return;
        }

        // verificar se foi submetido um formulário

        if ($_SERVER['REQUEST_METHOD'] != 'POST') {

            Store::redirectAdmin('adicionar_categorias');
            return;
        }




        // validar se o dados do formulário estão todos preenchidos
        if (empty($_POST['categoria-nome']) ||  empty($_FILES['categoria-imagem'])) {

            $_SESSION['erro'] = "Todos os campos do formulário deve ser preenchidos.";
            Store::redirectAdmin('adicionar_categorias');
            return;
        }


        // validar o formato da imagem
        if ($_FILES['categoria-imagem']['type'] != 'image/jpeg' && $_FILES['categoria-imagem']['type'] != 'image/png') {
            $_SESSION['erro'] = "Só é permitido o upload de ficheiros JPEG ou PNG.";
            Store::redirectAdmin('adicionar_categorias');
            return;
        }

        // validar o tamanho da imagem
        if ($_FILES['categoria-imagem']['size'] > 10000000) {
            $_SESSION['erro'] = "o ficheiro de imagem não pode exceder os 10MB.";
            Store::redirectAdmin('adicionar_categorias');
            return;
        }


        $nome_categoria = htmlspecialchars(trim(ucwords($_POST['categoria-nome'])));
        $imagem_categoria = "assets/img/categorias/" . $_FILES['categoria-imagem']['name'];



        $dados_categoria = [
            'nome' => $nome_categoria,
            'imagem' => $imagem_categoria,
        ];

        $admin = new AdminModel();
        $admin->adicionar_categoria($dados_categoria);

        // guardar imagem na pasta

        $pasta_imagem = getcwd() . '/assets/img/categorias/' . $_FILES['categoria-imagem']['name'];

        move_uploaded_file($_FILES['categoria-imagem']['tmp_name'], $pasta_imagem);

        Store::redirectAdmin();
    }

    //================================================================
    public function consultar_categorias()
    {
        if (!Store::adminLogado()) {
            Store::redirectAdmin('admin_login');
            return;
        }

        $admin = new AdminModel();

        $dados = [
            'categorias' => $admin->obter_categorias(),
        ];

        Store::Layout_admin([
            'admin/layouts/html_header',
            'admin/layouts/header',
            'admin/consultar_categorias',
            'admin/layouts/footer',
            'admin/layouts/html_footer',
        ], $dados);
    }
}
