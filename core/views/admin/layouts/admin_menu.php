<div>
    <div class="mb-3">
        <a href="?q=index" class="list-group-item list-group-item-action list-group-item-success rounded-end-4 shadow <?= $_GET['q'] == 'index' ? 'active' : '' ?>">Inicio</a>
    </div>
    <div class="mb-3 ">
        <a href="?q=lista_clientes" class="list-group-item list-group-item-action list-group-item-success rounded-end-4 shadow <?= $_GET['q'] == 'lista_clientes' ? 'active' : '' ?>">Clientes</a>
    </div>
    <div class="mb-3">
        <a href="?q=lista_encomendas" class="list-group-item list-group-item-action list-group-item-success rounded-end-4 shadow <?= $_GET['q'] == 'lista_encomendas' ? 'active' : '' ?>">Encomendas</a>
    </div>

    <div class="mb-3">
        <a href="?q=consultar_produtos" class="list-group-item list-group-item-action list-group-item-success rounded-end-4 shadow <?= $_GET['q'] == 'consultar_produtos' ? 'active' : '' ?>">Consultar Produtos</a>
    </div>
    <div class="mb-3">
        <a href="?q=adicionar_produtos" class="list-group-item list-group-item-action list-group-item-success rounded-end-4 shadow <?= $_GET['q'] == 'adicionar_produtos' ? 'active' : '' ?>">Adicionar Produtos</a>
    </div>
    <div class="mb-3">
        <a href="?q=adicionar_categorias" class="list-group-item list-group-item-action list-group-item-success rounded-end-4 shadow <?= $_GET['q'] == 'adicionar_categorias' ? 'active' : '' ?>">Adicionar Categorias</a>
    </div>
    <div class="mb-3">
        <a href="?q=consultar_categorias" class="list-group-item list-group-item-action list-group-item-success rounded-end-4 shadow <?= $_GET['q'] == 'consultar_categorias' ? 'active' : '' ?>">Consultar Categorias</a>
    </div>

</div>