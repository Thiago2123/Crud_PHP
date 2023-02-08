<?php
include_once "../conexaoComBd.php";

$id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_NUMBER_INT);
if(!empty($id)){
   $query_cliente =  "SELECT id, nome, email, cpf, cep, rua, complemento, cidade, estado
        FROM clientes WHERE id = :id LIMIT 1";
    $result_cliente = $conn->prepare($query_cliente);
    $result_cliente->bindParam(':id', $id);
    $result_cliente->execute();

    if(($result_cliente) and ($result_cliente->rowCount() != 0)){
        $row_cliente = $result_cliente->fetch(PDO::FETCH_ASSOC);
        $retorna = ['status' => true, 'dados' => $row_cliente];
    }else{
        $retorna = ['status' => false, 'msg' => "<div class='alert alert-danger' 
        role='alert'> <b>Erro</b>: Nenhum usuario encontrado</div>"];
    }

}else{
    $retorna = ['status' => false, 'msg' => "<div class='alert alert-danger' 
    role='alert'> <b>Erro</b>: Nenhum usuario encontrado o id não esta vindo</div>"];
}

echo json_encode($retorna);

?>