<html>

<head>
    <title>Produtos</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.2/css/dataTables.bootstrap5.min.css">

    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="../lib/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.2/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.2/js/dataTables.bootstrap5.min.js"></script>
    
    <script src="https://kit.fontawesome.com/3dd3effadf.js" crossorigin="anonymous"></script>

    <script src="../js/produtos.js"></script>
    <script src="../js/procurarCep.js"></script>

</head>

<body>

    <div class="container p-2">
        <nav class="nav nav-pills nav-fill">
            <a class="btn nav-item nav-link " href="../Clientes/homeCliente.php">Clientes</a>
            <a class="nav-item nav-link active" href="">Produtos</a>
            <a class="nav-item nav-link " href="../Pedidos/homePedidos.php">Pedidos</a>
        </nav>
        <div class="d-flex justify-content-between align-items-center p-3 pb-2">
            <h1 class="display-6 mb-4">Listar Produtos</h1>

            <!-- Botão para acionar modal -->
            <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modalCadastroProduto"><i class="fa-solid fa-plus"> </i> Cadastrar Produto</button>
        </div>
        <span id="msgAlerta"></span>
        <table id="listar-produtos" class=" table table-striped table-hover display" style="width:100%">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Descrição</th>
                    <th>Valor</th>
                    <th>Criado em</th>
                    <th class='col-3' ></th>
                </tr>
            </thead>
        </table>
    </div>
    <!-- Modal cadastro-->
    <div class="modal fade" id="modalCadastroProduto" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalCadastroProduto">Cadastrar Produto</h5>
                    <button type="button" class="close btn btn-danger btn-sm" data-dismiss="modal" aria-label="Fechar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <span id="msgAlertaErroCadastro"></span>
                    <form method="POST" id="form-cad-produto">
                        <div class="row">
                            <div class="form-group col-sm-6">
                                <label for="nomeProduto">Nome</label>
                                <input type="text" name="nome" class="form-control" id="nomeProduto" placeholder="Nome do Produto">
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="descricaoProduto">Descrição</label>
                                <textarea type="text" name="descricao" class="form-control" id="descricaoProduto" placeholder="Descrição do Produto"></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-sm-6">
                                <label class="sr-only" for="valorProduto">Valor</label>
                                <div class="input-group form-group col-sm-6">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text btn btn-success btn-md">R$</div>
                                    </div>
                                    <input type="text" name='valor' class="form-control" id="valorProduto" placeholder="00.00">
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
    <!-- Modal Visualizar-->
    <div class="modal fade" id="modalvisualisarProduto" tabindex="-1" role="dialog" aria-labelledby="TituloModalLongoExemplo" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalvisualisarProduto">Detalhes do Produto</h5>
                    <button type="button" class="close btn btn-danger btn-sm" data-dismiss="modal" aria-label="Fechar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <dl class="row">
                        <dt class="col-sm-3">ID</dt>
                        <dd class="col-sm-9"><span id="idProdutoVis"></span></dd>

                        <dt class="col-sm-3">Nome</dt>
                        <dd class="col-sm-9"><span id="nomeProdutoVis"></span></dd>

                        <dt class="col-sm-3">Descrição</dt>
                        <dd class="col-sm-9"><span id="descricaoProdutoVis"></span></dd>

                        <dt class="col-sm-3">Valor</dt>
                        <dd class="col-sm-9"><span id="valorProdutoVis"></span></dd>

                        <dt class="col-sm-3">Criado Em</dt>
                        <dd class="col-sm-9"><span id="criadoEmProdutoVis"></span></dd>
                    </dl>
                </div>

            </div>
        </div>
    </div>
    <!-- Modal Editar-->
    <div class="modal fade" id="modalEditarProduto" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEditarProdutoLabel">Editar Produto</h5>
                    <button type="button" class="close btn btn-danger btn-sm" data-dismiss="modal" aria-label="Fechar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <span id="msgAlertaEditar"></span>
                    <form method="POST" id="form-edit-produto">
                        <input type="hidden" name="id" id="idProdutoEdit">
                        <div class="row">
                            <div class="form-group col-sm-6">
                                <label for="nomeProdutoEdit">Nome</label>
                                <input type="text" name="nome" class="form-control" id="nomeProdutoEdit" placeholder="Nome do produto">
                            </div>
                            <div class="col-sm-6">
                                <label class="sr-only" for="valorProdutoEdit">Valor</label>
                                <div class="input-group form-group col-sm-6">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text btn btn-success btn-md">R$</div>
                                    </div>
                                    <input type="text" name='valor' class="form-control" id="valorProdutoEdit" placeholder="Valor">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                                <label for="descricaoProdutoEdit">Descrição</label>
                                <textarea type="text" name="descricao" class="form-control" id="descricaoProdutoEdit" placeholder="Descrição"></textarea
                            div>
                        </div>
                            <button type="submit" onclick=salvarEditProduto(id) class="btn btn-success btn-sm mt-2" value="Salvar">Salvar</button>
                        
                    </form>
                </div>

            </div>
        </div>
    </div>
   
</body>
<footer>

</footer>

</html>