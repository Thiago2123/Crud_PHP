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
<?php     include_once "../conexaoComBd.php"; ?>

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
                    <th class="col-4">Produtos</th>
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
                            <div class="form-group col-sm-12">
                                <label for="nomeCliente">Cliente</label>
                                <select class="form-control col-sm-6" name="selectClientes">
                                    <option value= "" selected>Selecione o Cliente</option>
                                    <?php 
                                        $querySelectClientes = "SELECT * FROM clientes ORDER BY nome";
                                        $resultSelectClientes = $conn->prepare($querySelectClientes);
                                        $resultSelectClientes->execute();
                                        while($rowSelectClientes  = $resultSelectClientes->fetch(PDO::FETCH_ASSOC)){
                                            extract($rowSelectClientes);
                                            echo "<option name='nomeCliente' class='form-control' id='nomeCliente' value='$id'>$nome </option>";
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group col-sm-12">
                                <label for="nomeProduto">Selecione os Produtos</label>
                                <select class="form-control col-sm-6" name="selectProdutos[]" id= "selectProdutos" multiple>
                                    <?php 
                                        $querySelectClientes = "SELECT * FROM produtos ORDER BY nome";
                                        $resultSelectClientes = $conn->prepare($querySelectClientes);
                                        $resultSelectClientes->execute();
                                        while($rowSelectClientes  = $resultSelectClientes->fetch(PDO::FETCH_ASSOC)){
                                            extract($rowSelectClientes);
                                            echo "<option data-valor='$valor' name='nomeProduto' class='form-control' id='nomeProduto' value='$id'>
                                                $nome  =  R$ " . number_format($valor, 2, ',','.')."
                                            </option>";
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                                <label for="precoVenda">Valor do Pedido</label>
                                <div class="input-group form-group col-sm-4" style="width: 100%;">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text btn btn-success btn-md">R$</div>
                                    </div>
                                    <input type="text" name='precoVenda' class="form-control" id="precoVenda" placeholder="Valor do Pedido" readonly>
                                </div>
                                <div class="form-group col-sm-4">
                                    <label for="statusPedido">Status</label>
                                    <select type="text" name="statusPedido" class="form-control" id="statusPedido" >
                                        <option value="Aberto">Aberto</option>
                                        <option value="Pago">Pago</option>
                                        <option value="Cancelado">Cancelado</option>
                                    </select>
                                </div>
                                <div class="form-group col-sm-4">
                                    <label for="descontoPedido">Desconto em %</label>
                                    <input type="text" name="descontoPedido" class="form-control" id="descontoPedido"  placeholder="10" >
                                </div>
                                <div class="form-group col-sm-4 ">
                                    <label for="criadoEmPedido">Data de Criação</label>
                                    <input type="text" name="criado_em" class="form-control" id="criadoEmPedido"  disabled >
                                </div>
                        </div>
                        <div>
                            <div>
                                <button type="submit" onclick= "cadastrarPedido()" class="btn btn-success btn-sm mt-4 justify-content-center" value="Cadastrar">Cadastrar</button>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

     <!-- Modal Visualizar-->
     <div class="modal fade" id="modalvisualisarClientesPedido" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalvisualisarClientesPedido">Detalhes do Cliente nesse pedido</h5>
                    <button type="button" class="close btn btn-danger btn-sm" data-dismiss="modal" aria-label="Fechar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <dl class="row">
                        <dt class="col-sm-6">Nome</dt>
                        <dd class="col-sm-6"><span id="nomeVisuCliPed"></span></dd>

                        <dt class="col-sm-6">CPF</dt>
                        <dd class="col-sm-6"><span id="cpfVisuCliPed"></span></dd>

                        <dt class="col-sm-6">Rua</dt>
                        <dd class="col-sm-6"><span id="ruaVisuCliPed"></span></dd>

                        <dt class="col-sm-6">Cidade</dt>
                        <dd class="col-sm-6"><span id="cidadeVisuCliPed"></span></dd>

                        <dt class="col-sm-6">Estado</dt>
                        <dd class="col-sm-6"><span id="estadoVisuCliPed"></span></dd>

                        <dt class="col-sm-6">Data do pedido</dt>
                        <dd class="col-sm-6"><span id="criadoEmVisuCliPed"></span></dd>
                    </dl>
                </div>

            </div>
        </div>
    </div>
</body>
<footer>

</footer>

</html>