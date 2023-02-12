<?php
    include_once "../conexaoComBd.php";

    $dados_requisicao = $_REQUEST;
    
    
    //lista de colunas na tabela para ordenar
    $colunas = [
        0 => 'id',
        1 => 'nome',
        2 => 'descricao',
        3 => 'valor',
        4 => 'criado_em'
    ];

    $query_qnt_produtos = "SELECT COUNT(id) AS qnt_produtos FROM produtos ";
        //modificar a query para realizar a busca
    if(!empty($dados_requisicao['search']['value'])){
        $query_qnt_produtos .= " WHERE id LIKE :id ";
        $query_qnt_produtos .= " OR nome LIKE :nome ";
        $query_qnt_produtos .= " OR descricao LIKE :descricao ";
        $query_qnt_produtos .= " OR valor LIKE :valor ";
        $query_qnt_produtos .= " OR criado_em LIKE :criado_em ";
    }

    $result_qnt_produtos = $conn->prepare($query_qnt_produtos);

    if(!empty($dados_requisicao['search']['value'])){
        $valor_pesquisa = "%" . $dados_requisicao['search']['value'] . "%";
        $result_qnt_produtos->bindParam(':id', $valor_pesquisa ,PDO::PARAM_STR);
        $result_qnt_produtos->bindParam(':nome', $valor_pesquisa ,PDO::PARAM_STR);
        $result_qnt_produtos->bindParam(':descricao', $valor_pesquisa ,PDO::PARAM_STR);
        $result_qnt_produtos->bindParam(':valor', $valor_pesquisa ,PDO::PARAM_STR);
        $result_qnt_produtos->bindParam(':criado_em', $valor_pesquisa ,PDO::PARAM_STR);
    }    

    $result_qnt_produtos->execute();
    $row_qnt_produtos  = $result_qnt_produtos->fetch(PDO::FETCH_ASSOC);
    //var_dump($row_qnt_produtos);

    $query_produtos = "SELECT * 
                        FROM produtos ";   
    // modifcar a query para realizar a pesquisa
    if(!empty($dados_requisicao['search']['value'])){
        $query_produtos .= " WHERE id LIKE :id ";
        $query_produtos .= " OR nome LIKE :nome ";
        $query_produtos .= " OR descricao LIKE :descricao ";
        $query_produtos .= " OR valor LIKE :valor ";
        $query_produtos .= " OR criado_em LIKE :criado_em ";
    }    
    
    //modificando a query para a ordenação
    $query_produtos .= " ORDER BY " . $colunas[$dados_requisicao['order'][0]['column']]. " " .
    $dados_requisicao['order'][0]['dir'] . " LIMIT :inicio, :quantidade";


    $result_produtos = $conn->prepare($query_produtos);
    $result_produtos->bindParam(':inicio', $dados_requisicao['start'],PDO::PARAM_INT);
    $result_produtos->bindParam(':quantidade', $dados_requisicao['length'],PDO::PARAM_INT);
    
    if(!empty($dados_requisicao['search']['value'])){
        $valor_pesquisa = "%" . $dados_requisicao['search']['value'] . "%";
        $result_produtos->bindParam(':id', $valor_pesquisa ,PDO::PARAM_STR);
        $result_produtos->bindParam(':nome', $valor_pesquisa ,PDO::PARAM_STR);
        $result_produtos->bindParam(':descricao', $valor_pesquisa ,PDO::PARAM_STR);
        $result_produtos->bindParam(':valor', $valor_pesquisa ,PDO::PARAM_STR);
        $result_produtos->bindParam(':criado_em', $valor_pesquisa ,PDO::PARAM_STR);
    }    


    $result_produtos->execute();
    //var_dump($result_produtos);
     


    while ($row_produto = $result_produtos->fetch(PDO::FETCH_ASSOC)) {
        //var_dump($row_produto);
        extract($row_produto);
        
        $registro = [];
        //como dei o "extract" na query posso usar o nome da coluna diretamente como chave do array
        $registro[] = $id;
        $registro[] = $nome;
        $registro[] = $descricao;
        $registro[] = "R$ ".number_format($valor, 2, ",", ".") ."";
        $registro[] = $criado_em;
        $registro[] = " <button type='button' id='$id' onclick='visualizarProduto($id)' class='btn btn-primary btn-sm'>Detalhes</button> 
                            <button type='button' id='$id' onclick='modalEditarProduto($id)' class='btn btn-warning btn-sm'>Editar</button> 
                            <button type='button' id='$id' onclick='excluirProduto($id)' class='btn btn-danger btn-sm'>Excluir</button>";
        $dados[] = $registro;
    }
    
    //var_dump($dados);
    $resultado = [
        "draw" => intval($dados_requisicao['draw']),
        "recordsTotal" => intval($row_qnt_produtos['qnt_produtos']),
        "recordsFiltered" => intval($row_qnt_produtos['qnt_produtos']),
        "data" => $dados,
    ];

    echo json_encode($resultado);

?>
