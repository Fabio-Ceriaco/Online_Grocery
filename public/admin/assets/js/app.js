// modal de admin estados encomedas

function apresentarModal() {
  const modalStatus = new bootstrap.Modal(
    document.getElementById("modalStatus")
  );
  modalStatus.show();
}

//========================DataTables========================================

//tabela encomendas

$("#tabela_encomendas").DataTable({
  responsive: true,
  language: {
    info: "Mostrando página _PAGE_ de _PAGES_",
    infoEmpty: "Não existem encomendas disponíveis",
    infoFiltered: "(Filtrado de um total _MAX_ encomendas)",
    lengthMenu: "Apresenta _MENU_ encomendas por página",
    zeroRecords: "Não foram encontradas encomendas",
  },
  lengthMenu: [
    [10, 15, 25, 50],
    [10, 15, 25, 50],
  ],
});

function definir_filtro() {
  let filtro = document.getElementById("select-status").value;
  // reload da página com determinado filtro
  window.location.href =
    window.location.pathname +
    "?" +
    $.param({ q: "lista_encomendas", f: filtro });
}

//tabela clientes

$("#tabela_clientes").DataTable({
  responsive: true,
  language: {
    info: "Mostrando página _PAGE_ de _PAGES_",
    infoEmpty: "Não existem clientes registados",
    infoFiltered: "(Filtrado de um total _MAX_ clientes)",
    lengthMenu: "Apresenta _MENU_ clientes por página",
    zeroRecords: "Não foram encontrados clientes",
  },
  lengthMenu: [
    [10, 15, 25, 50],
    [10, 15, 25, 50],
  ],
});

// tabela produtos

$("#tabela_produtos").DataTable({
  responsive: true,
  language: {
    info: "Mostrando página _PAGE_ de _PAGES_",
    infoEmpty: "Não existem encomendas disponíveis",
    infoFiltered: "(Filtrado de um total _MAX_ encomendas)",
    lengthMenu: "Apresenta _MENU_ encomendas por página",
    zeroRecords: "Não foram encontradas encomendas",
  },
  lengthMenu: [
    [10, 15, 25, 50],
    [10, 15, 25, 50],
  ],
});
