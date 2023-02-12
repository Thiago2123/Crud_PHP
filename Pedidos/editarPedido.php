<?php


include_once "../conexaoComBd.php";

$selectStatusPedido = filter_input(INPUT_GET,'selectStatusPedido', FILTER_DEFAULT);
$pedidoId = filter_input(INPUT_GET,'pedidoId', FILTER_SANITIZE_NUMBER_INT);
//var_dump($pedidoId);

    if(!empty($pedidoId) OR !empty($selectStatusPedido)){
        $query_status_Pedido = "UPDATE pedidos 
                                SET statusPedido = '$selectStatusPedido'
                                WHERE pedidos.id = $pedidoId ";
        $result_status_Pedido = $conn->prepare($query_status_Pedido);
        $result_status_Pedido->execute();
    
        $retorna = ['status' => true, 'msg' => "<div class='alert alert-success' role='alert'>Produto editado com sucesso!</div>"];
    }else{
        $retorna = ['status' => false, 'msg' => "<div class='alert alert-danger' role='alert'>Erro: Produto não foi editado com sucesso!</div>"];
    }

echo json_encode($retorna);