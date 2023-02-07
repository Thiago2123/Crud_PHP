<html>

<head>
    <title>Clientes</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.2/css/dataTables.bootstrap5.min.css">

    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="lib/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.2/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.2/js/dataTables.bootstrap5.min.js"></script>

    <script src="js/function.js"></script>
</head>

<body>
    <div class="container">
        <div class="d-flex justify-content-between align-items-center p-3 pb-2">
            <h1 class="display-6 mb-4">Listar Clientes</h1>

            <!-- Botão para acionar modal -->
            <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modalCadastroCliente">Cadastrar Cliente</button>
        </div>
        <span id="msgAlertaSucesso"></span>
        <table id="listar-cliente" class=" table table-striped table-hover display" style="width:100%">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Email</th>
                    <th>CPF</th>
                    <th>Rua</th>
                    <th>Complemento</th>
                    <th>Cidade</th>
                    <th>Estado</th>
                </tr>
            </thead>
        </table>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="modalCadastroCliente" tabindex="-1" role="dialog" aria-labelledby="TituloModalLongoExemplo" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalCadastroCliente">Cadastrar Cliente</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <span id="msgAlertaErroCadastro"></span>
                    <form method="POST" id="form-cad-cliente">
                        <div class="row">
                            <div class="form-group col-sm-6">
                                <label for="nomeCliente">Nome</label>
                                <input type="text" name="nome" class="form-control" id="nomeCliente" placeholder="Nome Completo">
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="emailCliente">E-mail</label>
                                <input type="email" name="email" class="form-control" id="emailCliente" placeholder="E-mail">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-sm-6">
                                <label for="cpfCliente">CPF</label>
                                <input type="text" name="cpf" class="form-control" id="cpfCliente" placeholder="CPF">
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="cepCliente">CEP</label>
                                <input type="text" name="cep" class="form-control" id="cepCliente" placeholder="CEP">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-sm-7">
                                <label for="ruaCliente">Rua</label>
                                <input type="text" name="rua" class="form-control" id="ruaCliente" placeholder="" readonly>
                            </div>
                            <div class="form-group col-sm-5">
                                <label for="complementoCliente">Complemento</label>
                                <input type="text" name="complemento" class="form-control" id="complementoCliente" placeholder="" readonly>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-sm-6">
                                <label for="cidadeCliente">Cidade</label>
                                <input type="text" name="cidade" class="form-control" id="cidadeCliente" placeholder="" readonly>
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="estadoCliente">Estado</label>
                                <input type="text" readonly name="estado" class="form-control" id="estadoCliente" placeholder="" >
                            </div>
                        </div>
                        <div>
                            <div>
                                <button type="submit" onclick=cadastrarCliente() class="btn btn-success btn-sm mt-4 justify-content-center" value="Cadastrar">Cadastrar</button>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

</body>
<footer>

</footer>

</html>