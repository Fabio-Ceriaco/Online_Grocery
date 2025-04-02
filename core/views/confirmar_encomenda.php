<section class="container-fluid">
    <div class="container my-5" style="max-width: 600px">
        <h2 class="mt-3">Encomenda Confirmada</h2>
        <p>Muito obrigado pela sua encomenda.</p>
        <div>
            <h4>Dados de pagamento</h4>
            <div>
                <p>Conta bancária: 1234567890</p>
                <p>Código da encomenda: <strong><?= $codigo_encomenda ?></strong></p>
                <p>Total : <strong><?= number_format($total_encomenda, 2, ',', '.') . "€" ?></strong></p>
            </div>
        </div>
        <p>Foi enviado um email com a confirmação da sua encomenda e os dados de pagamento.<br>
            <br>
            A sua encomenda só será processada após confrimação do pagamento.
        </p>
        <br>
        <p>Por favor verifique se o email aparece na sua conta ou se foi para a pasta do SPAM.</p>
    </div>
    <div class="row justify-content-center mb-4"><a href="?q=home" class="btn btn-success" style="max-width: 150px;">Voltar</a></div>
</section>