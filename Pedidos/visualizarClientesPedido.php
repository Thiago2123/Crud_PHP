<?php
include_once "../conexaoComBd.php";

$pedidoId = filter_input(INPUT_GET, "id", FILTER_SANITIZE_NUMBER_INT);
//var_dump($pedidoId);
if(!empty($pedidoId)){
   $query_cliente_pedido =  "SELECT c.nome, c.cpf, c.rua, c.cidade, c.estado, p.criadoEm from pedidos p 
                        INNER join clientes c on c.id = p.clienteId
                        WHERE p.id = :pedidoId
                        LIMIT 1";
    $result_cliente_pedido = $conn->prepare($query_cliente_pedido);
    $result_cliente_pedido->bindParam(':pedidoId', $pedidoId);
    $result_cliente_pedido->execute();

    if(($result_cliente_pedido) and ($result_cliente_pedido->rowCount() != 0)){
        $row_cliente_pedido = $result_cliente_pedido->fetch(PDO::FETCH_ASSOC);
        $retorna = ['status' => true, 'dados' => $row_cliente_pedido];
        //transforma a data do banco em hrs 
        $data = strtotime($row_cliente_pedido['criadoEm']);
        //formata a data em hrs, em dia/mes/ano
        $dataFormatada = date('d/m/Y', $data);
        //retorna os dados com a data formatada
        $retorna = $retorna + ['dataFormatada' => $dataFormatada];
        //var_dump($retorna);
        
    }else{
        $retorna = ['status' => false, 'msg' => "<div class='alert alert-danger' 
        role='alert'> <b>Erro</b>: Nenhum produto encontrado</div>"];
    }

}else{
    $retorna = ['status' => false, 'msg' => "<div class='alert alert-danger' 
    role='alert'> <b>Erro</b>: Nenhum produto encontrado o id não esta vindo</div>"];
 }

echo json_encode($retorna);

?>