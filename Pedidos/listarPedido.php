<?php
    include_once "../conexaoComBd.php";

    $dados_requisicao = $_REQUEST;
    
    
    //lista de colunas na tabela para ordenar
    $colunas = [
        0 => 'pd.id',
        1 => 'nomeProduto',
        2 => 'c.nome',
        3 => 'pd.statusPedido',
        4 => 'pd.valorPedido',
        5 => 'pd.dataPedido'
    ];

    $query_qnt_pedidos = "SELECT COUNT(id) AS qnt_pedidos FROM pedidos as pd";

    if(!empty($dados_requisicao['search']['value'])){
        $query_qnt_pedidos .= " WHERE pd.id LIKE :id ";
        $query_qnt_pedidos .= " OR idProduto LIKE :idProduto ";
        $query_qnt_pedidos .= " OR idCliente LIKE :idCliente ";
        $query_qnt_pedidos .= " OR statusPedido LIKE :statusPedido ";
        $query_qnt_pedidos .= " OR pd.valorPedido LIKE :valorPedido ";
        $query_qnt_pedidos .= " OR dataPedido LIKE :dataPedido ";
    }

    $result_qnt_pedidos = $conn->prepare($query_qnt_pedidos);

    if(!empty($dados_requisicao['search']['value'])){
        $valor_pesquisa = "%" . $dados_requisicao['search']['value'] . "%";
        $result_qnt_pedidos->bindParam(':id', $valor_pesquisa ,PDO::PARAM_INT);
        $result_qnt_pedidos->bindParam(':idProduto', $valor_pesquisa ,PDO::PARAM_STR);
        $result_qnt_pedidos->bindParam(':idCliente', $valor_pesquisa ,PDO::PARAM_STR);
        $result_qnt_pedidos->bindParam(':statusPedido', $valor_pesquisa ,PDO::PARAM_STR);
        $result_qnt_pedidos->bindParam(':valorPedido', $valor_pesquisa ,PDO::PARAM_STR);
        $result_qnt_pedidos->bindParam(':dataPedido', $valor_pesquisa ,PDO::PARAM_STR);
    }    
    
    
    $result_qnt_pedidos->execute();
    $row_qnt_pedidos  = $result_qnt_pedidos->fetch(PDO::FETCH_ASSOC);
    //var_dump($row_qnt_pedidos);

    $query_pedidos = "SELECT pd.id, p.nome as nomeProduto, c.nome, pd.statusPedido, pd.valorPedido, pd.dataPedido 
                        FROM pedidos pd
                        INNER JOIN clientes c on pd.idCliente = c.id
                        INNER JOIN produtos p on pd.idProduto = p.id
                        "; 

    if(!empty($dados_requisicao['search']['value'])){
        $query_pedidos .= " WHERE pd.id LIKE :id ";
        $query_pedidos .= " OR p.nome LIKE :nomeProduto ";
        $query_pedidos .= " OR c.nome LIKE :nome ";
        $query_pedidos .= " OR pd.statusPedido LIKE :statusPedido ";
        $query_pedidos .= " OR pd.valorPedido LIKE :valorPedido ";
        $query_pedidos .= " OR pd.dataPedido LIKE :dataPedido ";
    }   

    //modificando a query para a ordenação
    $query_pedidos .= " ORDER BY " . $colunas[$dados_requisicao['order'][0]['column']]. " " .
    $dados_requisicao['order'][0]['dir'] . " LIMIT :inicio, :quantidade";


    $result_pedidos = $conn->prepare($query_pedidos);
    $result_pedidos->bindParam(':inicio', $dados_requisicao['start'],PDO::PARAM_INT);
    $result_pedidos->bindParam(':quantidade', $dados_requisicao['length'],PDO::PARAM_INT);
    //var_dump($result_pedidos);

    if(!empty($dados_requisicao['search']['value'])){
        $valor_pesquisa = "%" . $dados_requisicao['search']['value'] . "%";
        $result_pedidos->bindParam(':id', $valor_pesquisa ,PDO::PARAM_INT);
        $result_pedidos->bindParam(':nomeProduto', $valor_pesquisa ,PDO::PARAM_STR);
        $result_pedidos->bindParam(':nome', $valor_pesquisa ,PDO::PARAM_STR);
        $result_pedidos->bindParam(':statusPedido', $valor_pesquisa ,PDO::PARAM_STR);
        $result_pedidos->bindParam(':valorPedido', $valor_pesquisa ,PDO::PARAM_STR);
        $result_pedidos->bindParam(':dataPedido', $valor_pesquisa ,PDO::PARAM_STR);
    }    
/*SELECT sum(p.valor) as 'Valor total 'FROM `pedidos` pd 
INNER JOIN clientes c on c.id = pd.idCliente
INNER JOIN produtos p on p.id = pd.idProduto
where pd.idCliente = 1 and pd.id = 1*/

    $result_pedidos->execute();
     
    //$nomeProdutos=['alo' => 'produto 1'];

    while ($row_pedido = $result_pedidos->fetch(PDO::FETCH_ASSOC)) {
        // var_dump($row_pedido);
        extract($row_pedido);

        $registro = [];
        //como dei o "extract" na query posso usar o nome da coluna diretamente como chave do array
        $registro[] = $id;
        $registro[] = $nomeProduto;
        $registro[] = $nome;
        $registro[] = "<select class='form-control form-control-sm'>
        <option selected>".$statusPedido."</option>
        <option value='Aberto' onclick= 'salvarEditProduto($id)'>Aberto </option>
        <option value='Pago' onclick= 'salvarEditProduto($id)'>Pago</option>
        <option value='Cancelado' onclick= 'salvarEditProduto($id)'>Cancelado</option>
        </select>";
        $registro[] = $valorPedido;
        $registro[] = $dataPedido;
        $registro[] = " <button type='button' id='$id' onclick='visualizarPedido($id)' class='btn btn-primary btn-sm'>Detalhes</button> 
                            <button type='button' id='$id' onclick='modalEditarPedido($id)' class='btn btn-warning btn-sm'>Editar</button> 
                            <button type='button' id='$id' onclick='excluirPedido($id)' class='btn btn-danger btn-sm'>Excluir</button>";
        $dados[] = $registro;
    }
    
    //var_dump($dados);
    $resultado = [
        "draw" => intval($dados_requisicao['draw']),
        "recordsTotal" => intval($row_qnt_pedidos['qnt_pedidos']),
        "recordsFiltered" => intval($row_qnt_pedidos['qnt_pedidos']),
        "data" => $dados,
    ];
    if($dados_requisicao['recordsFiltered'] = 0) {
        $resultado = ['status' => false, 'msg' => "<div class='alert alert-danger' role='alert'>Erro: Produto não foi editado com sucesso!</div>"];

    }

    echo json_encode($resultado);

?>
