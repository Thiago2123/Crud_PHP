<?php 
    include_once "../conexaoComBd.php";

    $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
    //como estou colocando a ',' pelo js, tenho que voltar para o '.' para gravar no bd
    $valorFormatado = str_replace(",",".",$dados['precoVenda']);
    $dados['precoVenda'] = $valorFormatado;

    //var_dump($dados);
    if(empty($dados['selectClientes'])){
        $retorna = ['status' => false, 'msg' => "<div class='alert alert-danger' 
        role='alert'> <b>Erro</b>: Deve selecionar um <b>Cliente</b> </div>"]; 
    }elseif(empty($dados['selectProdutos'])){
        $retorna = ['status' => false, 'msg' => "<div class='alert alert-danger' 
        role='alert'> <b>Erro</b>: Deve selecionar um ou mais <b>Produto</b> </div>"]; 
    }elseif(empty($dados['statusPedido'])){
        $retorna = ['status' => false, 'msg' => "<div class='alert alert-danger' 
        role='alert'> <b>Erro</b>: Deve selecionar um <b>Status</b> </div>"]; 
    }else{
        $query_pedidos = "INSERT INTO pedidos (clienteId, statusPedido, criadoEm) 
                            VALUES (:clienteId, :statusPedido, NOW())";
        $cad_pedido = $conn->prepare($query_pedidos);
        $cad_pedido->bindParam(':clienteId', $dados['selectClientes'], PDO::PARAM_STR);
        $cad_pedido->bindParam(':statusPedido', $dados['statusPedido'], PDO::PARAM_STR);
        //$cad_pedido->bindParam(':criado_em', 'NOW()', PDO::PARAM_STMT);
        $cad_pedido->execute();
        
        //pegar ultimo id inserido no bd
        $id_pedido = $conn->lastInsertId();
        //var_dump($query_produtosPedidos);

        $query_produtosPedidos = "INSERT INTO produtospedidos (pedidoId, produtoId, precoVenda) 
            VALUES (:pedidoId, :produtoId, ".$dados['precoVenda'].")";
            $cad_produtosPedidos= $conn->prepare($query_produtosPedidos);
            $cad_produtosPedidos->bindParam(':pedidoId', $id_pedido, PDO::PARAM_INT);
            $cad_produtosPedidos->bindParam(':produtoId', $produtosSelecionados, PDO::PARAM_STR);

        foreach($dados['selectProdutos'] as $chave => $produtosSelecionados){
            $cad_produtosPedidos->execute();
            //var_dump($dados['precoVenda']);
            //var_dump($cad_produtosPedidos);

        }

        if($cad_pedido->rowCount()){
            $retorna = ['status' => true, 'msg' => "<div class='alert alert-success' 
            role='alert'>Pedido cadastrado com sucesso </div>"]; 
        }else{
            $retorna = ['status' => false, 'msg' => "<div class='alert alert-danger' 
            role='alert'> <b>Erro</b>: Não foi possivel cadastrar esse Pedido </div>"]; 
        }
    }

    echo json_encode($retorna);