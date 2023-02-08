<?php
    include_once "../conexaoComBd.php";

    $id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_NUMBER_INT);

    if(!empty($id)){
        $queryCliente = "DELETE FROM clientes WHERE id= :id";
        $resultCliente = $conn->prepare($queryCliente);

        $resultCliente->bindParam(":id", $id, PDO::PARAM_INT);

        if($resultCliente->execute()){
            $retorna = ['status' => true, 'msg' => "<div class='alert alert-success' role='alert'>Legal Cliente foi Excluido com sucesso!</div>"];



        }else{
            $retorna = ['status' => false, 'msg' => "<div class='alert alert-danger' role='alert'>Erro: Cliente não foi apagado com sucesso!</div>"];

        }
    }else{
        $retorna = ['status' => false, 'msg' => "<div class='alert alert-danger' role='alert'>Erro: Cliente não foi apagado com sucesso!</div>"];

    }

    echo json_encode($retorna);
