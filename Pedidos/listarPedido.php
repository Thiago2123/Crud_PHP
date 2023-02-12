<?php
    include_once "../conexaoComBd.php";

    $dados_requisicao = $_REQUEST;
       
     //lista de colunas na tabela para ordenar
     $colunas = [
        0 => 'ped.id',
        2 => 'clienteNome',
        3 => 'statusPedido',
        4 => 'valorTotal',
        5 => 'criadoEm'
    ];

    $query_qnt_pedidos = "SELECT COUNT(id) AS qnt_pedidos FROM pedidos as pd";
    
    
    $result_qnt_pedidos = $conn->prepare($query_qnt_pedidos);

    $result_qnt_pedidos->execute();
    $row_qnt_pedidos  = $result_qnt_pedidos->fetch(PDO::FETCH_ASSOC);
    //var_dump($row_qnt_pedidos);
    $query_pedidos = "SELECT ped.clienteId as clienteId, cli.nome as clienteNome, ped.criadoEm as criadoEnPedidos,
                    ped.id as pedidoId, ped.statusPedido as statusPedido, COUNT(ped.clienteId) as qntPedido, 
                    prodped.precoVenda as valorTotal, ped.criadoEm as criadoEm
                    FROM clientes cli
                    INNER JOIN pedidos ped on ped.clienteId = cli.id 
                    INNER JOIN produtospedidos prodped on prodped.pedidoId = ped.id 
                   ";
    // modifcar a query para realizar a pesquisa
    if(!empty($dados_requisicao['search']['value'])){
        $query_pedidos .= " WHERE ped.id LIKE :pedidoId ";
        $query_pedidos .= " OR cli.nome LIKE :clienteNome ";
        $query_pedidos .= " OR ped.statusPedido LIKE :statusPedido ";
        //$query_pedidos .= " OR valorTotal LIKE :valorTotal ";
        $query_pedidos .= " OR ped.criadoEm LIKE :criadoEm ";
    }
    $query_pedidos.= " GROUP BY ped.id ";
    
    //modificando a query para a ordenação
    $query_pedidos .= " ORDER BY " . $colunas[$dados_requisicao['order'][0]['column']]. " " .
    $dados_requisicao['order'][0]['dir'] . " LIMIT :inicio, :quantidade";
    
    $result_pedidos = $conn->prepare($query_pedidos);
    $result_pedidos->bindParam(':inicio', $dados_requisicao['start'],PDO::PARAM_INT);
    $result_pedidos->bindParam(':quantidade', $dados_requisicao['length'],PDO::PARAM_INT);
    
    if(!empty($dados_requisicao['search']['value'])){
        $valor_pesquisa = "%" . $dados_requisicao['search']['value'] . "%";
        $result_pedidos->bindParam(':pedidoId', $valor_pesquisa ,PDO::PARAM_STR);
        $result_pedidos->bindParam(':clienteNome', $valor_pesquisa ,PDO::PARAM_STR);
        $result_pedidos->bindParam(':statusPedido', $valor_pesquisa ,PDO::PARAM_STR);
        //$result_pedidos->bindParam(':valorTotal', $valor_pesquisa ,PDO::PARAM_INT);
        $result_pedidos->bindParam(':criadoEm', $valor_pesquisa ,PDO::PARAM_STR);
    }  
    
    $result_pedidos->execute();
    //var_dump($query_pedidos);
    

    while ($row_pedido = $result_pedidos->fetch(PDO::FETCH_ASSOC)) {
        //var_dump($row_pedido);
        extract($row_pedido);
        $query_produtosPorPedido = "SELECT p.nome as nome, p.valor as valorProduto
            FROM produtospedidos pdtsp
            inner JOIN produtos p on p.id = pdtsp.produtoId
            where pedidoId = $pedidoId ";
            
        $result_produtosPedido = $conn->prepare($query_produtosPorPedido);
        $result_produtosPedido->execute();
        $row_produtosPedido = $result_produtosPedido->fetchAll(PDO::FETCH_ASSOC);
        extract($row_produtosPedido);

        $registro = [];
        //como dei o "extract" na query posso usar o nome da coluna diretamente como chave do array
        $registro[] = "$pedidoId" ;
        //var_dump( $nomeProduto['nome']);
        $registro[] = "<p>
        <div class='btn btn-warning btn-sm' data-toggle='collapse' href='#modal$pedidoId' role='button' aria-expanded='false'>
        Verificar Produtos
        </div></p>";
        foreach($row_produtosPedido as $produto_id => $produtosPedido){
            //var_dump($registro[1]);
            //var_dump($produtosPedido);
            $registro[1] .=" 
            <div class='collapse' id='modal$pedidoId'>
                <div class='card card-body'><b>".$produtosPedido['nome']."</b> </div>
            </div>";
        }        
        $registro[] = $clienteNome; 
        // coloquei o nome do select junto ao peidodId para que cada um na lista tenha um name diferente para o js 
        $registro[] = "<select name= 'selectStatusPedido$pedidoId' id='selectStatusPedido$pedidoId' onchange='salvarEditPedido($pedidoId)' class='form-control form-control-sm'>
                <option selected disable>".$statusPedido."</option>
                <option value='Aberto'>Aberto </option>
                <option value='Pago'>Pago</option>
                <option value='Cancelado'>Cancelado</option>
            </select>";
        $registro[] = "R$ ".number_format($valorTotal, 2, ",", ".") ."";
        $registro[] = $criadoEm;
        $registro[] = " <button type='button' id='$pedidoId' onclick='visualizarClientesPedido($pedidoId)' class='btn btn-primary btn-sm'>Detalhes</button> 
                            <button type='button' id='$pedidoId' onclick='excluirPedido($pedidoId)' class='btn btn-danger btn-sm'>Excluir</button>";
        $dados[] = $registro;
    }
    
    //var_dump($dados);
    $resultado = [
        "draw" => intval($dados_requisicao['draw']),
        "recordsTotal" => intval($row_qnt_pedidos['qnt_pedidos']),
        "recordsFiltered" => intval($row_qnt_pedidos['qnt_pedidos']),
        "data" => $dados,
    ];
    echo json_encode($resultado);
