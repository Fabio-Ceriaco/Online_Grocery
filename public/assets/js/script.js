$(".user-info").click(function () {
  if ($(".area-cliente").css("display") == "none") {
    $(".area-cliente").slideToggle("slow"); //;
  } else {
    $(".area-cliente").slideToggle("slow");
  }
});

// eventos estrelas comentarios
$(function () {
  $("#rateYo").rateYo({
    starWidth: "20px",
    fullStar: true,
    onSet: function (rating, rateYoInstance) {
      $("#rating").val(rating);
    },
  });
});

//=====================Axios===============================

function adicionar_carrinho(id_produto) {
  //adicionar produto ao carrinho
  axios.default.whithCredentials = true;

  axios
    .get("?q=adicionar_carrinho&id_produto=" + id_produto)
    .then(function (response) {
      console.log(response);
      let total_produtos = response.data;
      document.getElementById("count").innerHTML = total_produtos;
    });
}

function morada_alternativa() {
  // obter dados da morada alternativa
  axios.default.whithCredentials = true;

  axios({
    method: "POST",
    url: "?q=morada_alternativa",
    data: {
      nova_morada: document.getElementById("nova_morada").value,
      nova_localidade: document.getElementById("nova_localidade").value,
      novo_codPostal: document.getElementById("novo_codPostal").value,
      novo_email: document.getElementById("novo_email").value,
      novo_telfone: document.getElementById("novo_telefone").value,
    },
  });
}

//============================================================

// mostrar ou esconder div da morada alternativa

function usar_morada_alternativa() {
  // mostrar ou esconder div da morada alternativa
  let e = document.getElementById("check_morada_alternativa");
  let morada_alternativa = document.getElementById("morada_alternativa");

  if (e.checked == true) {
    morada_alternativa.style.display = "flex";
  } else {
    morada_alternativa.style.display = "none";
  }
}

//=====================DataTables=============================

$("#tabela-historico-encomendas").DataTable({
  responsive: true,
  language: {
    info: "Mostrando página _PAGE_ de _PAGES_",
    infoEmpty: "Não existem encomendas disponíveis",
    infoFiltered: "(Filtrado de um total _MAX_ encomendas)",
    lengthMenu: "Apresenta _MENU_ encomendas por página",
    zeroRecords: "Não foram encontradas encomendas",
  },
  lengthMenu: [
    [5, 10, 25, 50],
    [5, 10, 25, 50],
  ],
});
