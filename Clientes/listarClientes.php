<?php
    include_once "../conexaoComBd.php";
    
    $dados_requisicao = $_REQUEST;

    //lista de colunas na tabela para ordenar
    $colunas = [
        0 => 'id',
        1 => 'nome',
        2 => 'email',
        3 => 'cpf',
        4 => 'rua',
        5 => 'complemento',
        6 => 'cidade',
        7 => 'estado'
    ];


    $query_qnt_clientes = "SELECT COUNT(id) AS qnt_clientes FROM clientes ";

    //modificar a query para realizar a pesquisa
    if(!empty($dados_requisicao['search']['value'])){
        $query_qnt_clientes .= " WHERE id LIKE :id ";
        $query_qnt_clientes .= " OR nome LIKE :nome ";
        $query_qnt_clientes .= " OR email LIKE :email ";
        $query_qnt_clientes .= " OR cpf LIKE :cpf ";
        $query_qnt_clientes .= " OR cidade LIKE :cidade ";
        $query_qnt_clientes .= " OR estado LIKE :estado ";
    }
    
    $result_qnt_clientes = $conn->prepare($query_qnt_clientes);
    
    if(!empty($dados_requisicao['search']['value'])){
        $valor_pesquisa = "%" . $dados_requisicao['search']['value'] . "%";
        $result_qnt_clientes->bindParam(':id', $valor_pesquisa ,PDO::PARAM_STR);
        $result_qnt_clientes->bindParam(':nome', $valor_pesquisa ,PDO::PARAM_STR);
        $result_qnt_clientes->bindParam(':email', $valor_pesquisa ,PDO::PARAM_STR);
        $result_qnt_clientes->bindParam(':cpf', $valor_pesquisa ,PDO::PARAM_STR);
        $result_qnt_clientes->bindParam(':cidade', $valor_pesquisa ,PDO::PARAM_STR);
        $result_qnt_clientes->bindParam(':estado', $valor_pesquisa ,PDO::PARAM_STR);
    }    
    $result_qnt_clientes->execute();
    $row_qnt_clientes  = $result_qnt_clientes->fetch(PDO::FETCH_ASSOC);

    //quantidades de clientes
    //var_dump($row_qnt_clientes);
    $query_clientes = "SELECT * 
                        FROM CLIENTES "; 
    // modifcar a query para realizar a pesquisa
    if(!empty($dados_requisicao['search']['value'])){
        $query_clientes .= " WHERE id LIKE :id ";
        $query_clientes .= " OR nome LIKE :nome ";
        $query_clientes .= " OR email LIKE :email ";
        $query_clientes .= " OR cpf LIKE :cpf ";
        $query_clientes .= " OR cidade LIKE :cidade ";
        $query_clientes .= " OR estado LIKE :estado ";
    }

    //modificando a query para a ordenação
    $query_clientes .= " ORDER BY " . $colunas[$dados_requisicao['order'][0]['column']]. " " .
        $dados_requisicao['order'][0]['dir'] . " LIMIT :inicio, :quantidade";


    $result_clientes = $conn->prepare($query_clientes);
    $result_clientes->bindParam(':inicio', $dados_requisicao['start'],PDO::PARAM_INT);
    $result_clientes->bindParam(':quantidade', $dados_requisicao['length'],PDO::PARAM_INT);

    if(!empty($dados_requisicao['search']['value'])){
        $valor_pesquisa = "%" . $dados_requisicao['search']['value'] . "%";
        $result_clientes->bindParam(':id', $valor_pesquisa ,PDO::PARAM_STR);
        $result_clientes->bindParam(':nome', $valor_pesquisa ,PDO::PARAM_STR);
        $result_clientes->bindParam(':email', $valor_pesquisa ,PDO::PARAM_STR);
        $result_clientes->bindParam(':cpf', $valor_pesquisa ,PDO::PARAM_STR);
        $result_clientes->bindParam(':cidade', $valor_pesquisa ,PDO::PARAM_STR);
        $result_clientes->bindParam(':estado', $valor_pesquisa ,PDO::PARAM_STR);
    }    

    $result_clientes-> execute();
    
    while($row_cliente = $result_clientes->fetch(PDO::FETCH_ASSOC)){
        //var_dump($row_cliente);
        extract($row_cliente);
        $registro = [];
        //como dei o "extract" na query posso usar o nome da coluna diretamente como chave do array
        $registro[] = $id;
        $registro[] = $nome;
        $registro[] = $email;
        $registro[] = $cpf;
        $registro[] = $rua;
        $registro[] = " <button type='button' id='$id' onclick='visualizarCliente($id)' class='btn btn-primary btn-sm'>Detalhes</button> 
                        <button type='button' id='$id' onclick='modalEditarCliente($id)' class='btn btn-warning btn-sm'>Editar</button> 
                        <button type='button' id='$id' onclick='excluirCliente($id)' class='btn btn-danger btn-sm'>Excluir</button>";
        $dados[] = $registro;
    }
    //var_dump($dados);



    //criar um objeto para o js
    //documentação do dataTables https://datatables.net/examples/data_sources/server_side
    $resultado = [
        "draw" => intval($dados_requisicao['draw']),
        "recordsTotal" => intval($row_qnt_clientes['qnt_clientes']),
        "recordsFiltered" => intval($row_qnt_clientes['qnt_clientes']),
        "data"=> $dados,
    ];

    //var_dump($resultado)
    // não pode ter outro echo, esse deve ser o unico
    echo json_encode($resultado);
?>