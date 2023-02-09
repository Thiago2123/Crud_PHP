<html>

<head>
    <title>Produtos</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.2/css/dataTables.bootstrap5.min.css">

    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="../lib/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.2/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.2/js/dataTables.bootstrap5.min.js"></script>
    
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <script src="../js/pedidos.js"></script>
    <script src="../js/ajustarCep.js"></script>

</head>

<body>

    <div class="container">
        <div class="d-flex justify-content-between align-items-center p-3 pb-2">
            <h1 class="display-6 mb-4">Listar Pedidos</h1>

            <!-- Botão para acionar modal -->
            <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modalCadastroPedido">Cadastrar Pedido</button>
        </div>
        <span id="msgAlerta"></span>
        <table id="listar-pedidos" class=" table table-striped table-hover display" style="width:100%">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Produto</th>
                    <th>Cliente</th>
                    <th>Status</th>
                    <th>Valor</th>
                    <th>Data do Pedido</th>
                    <th>Ações</th>
                </tr>
            </thead>
        </table>
    </div>
    <!-- Modal cadastro-->
    <div class="modal fade" id="modalCadastroPedido" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalCadastroPedido">Cadastrar Pedido</h5>
                    <button type="button" class="close btn btn-danger btn-sm" data-dismiss="modal" aria-label="Fechar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <span id="msgAlertaErroCadastro"></span>
                    <form method="POST" id="form-cad-pedido">
                        <div class="row">
                            <div class="form-group col-sm-6">
                                <label for="nomeCliente">Cliente</label>
                                <input type="text" name="nomeCliente" class="form-control" id="nomeCliente" placeholder="Nome do Cliente">
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="descricaoProduto">Produto</label>
                                <input type="text" name="nomeProduto" class="form-control" id="nomeProduto" placeholder="Nome do Produto">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-sm-6">
                                <label class="sr-only" for="valorProduto">Valor</label>
                                <div class="input-group form-group col-sm-6">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text btn btn-success btn-md">R$</div>
                                    </div>
                                    <input type="number" name='valor' class="form-control" id="valorProduto" placeholder="Valor do Produto">
                                </div>
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="criadoEmProduto">Data de Criação</label>
                                <input type="text" name="criado_em" class="form-control" id="criadoEmProduto"  disabled >
                            </div>
                        </div>
                        <div>
                            <div>
                                <button type="submit" onclick=cadastrarProdutos() class="btn btn-success btn-sm mt-4 justify-content-center" value="Cadastrar">Cadastrar</button>
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