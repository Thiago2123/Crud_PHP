<?php
    include_once "../conexaoComBd.php";

    $id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_NUMBER_INT);

    if(!empty($id)){
        $queryPedidos = "DELETE FROM pedidos WHERE id= :id";
        $resultPedido = $conn->prepare($queryPedidos);

        $resultPedido->bindParam(":id", $id, PDO::PARAM_INT);
        
        $queryProdutosPedidos = "DELETE FROM produtospedidos where pedidoId = :id";
        $resultProdutosPedidos = $conn->prepare($queryProdutosPedidos);
        $resultProdutosPedidos->bindParam(":id", $id, PDO::PARAM_INT);
        $resultProdutosPedidos->execute();


        if($resultPedido->execute()){
            $retorna = ['status' => true, 'msg' => "<div class='alert alert-success' role='alert'>Legal!! Pedido foi <b>excluido</b> com sucesso!</div>"];
        }else{
            $retorna = ['status' => false, 'msg' => "<div class='alert alert-danger' role='alert'>Erro: Pedido não foi <b>excluido</b> com sucesso!</div>"];

        }
    }else{
        $retorna = ['status' => false, 'msg' => "<div class='alert alert-danger' role='alert'>Erro: Pedido não foi <b>excluido</b> com sucesso!</div>"];

    }

    echo json_encode($retorna);
