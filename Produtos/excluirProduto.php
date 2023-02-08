<?php
    include_once "../conexaoComBd.php";

    $id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_NUMBER_INT);

    if(!empty($id)){
        $queryProduto = "DELETE FROM produtos WHERE id= :id";
        $resultProduto = $conn->prepare($queryProduto);

        $resultProduto->bindParam(":id", $id, PDO::PARAM_INT);

        if($resultProduto->execute()){
            $retorna = ['status' => true, 'msg' => "<div class='alert alert-success' role='alert'>Legal!! Produto foi <b>excluido</b> com sucesso!</div>"];



        }else{
            $retorna = ['status' => false, 'msg' => "<div class='alert alert-danger' role='alert'>Erro: Produto não foi <b>excluido</b> com sucesso!</div>"];

        }
    }else{
        $retorna = ['status' => false, 'msg' => "<div class='alert alert-danger' role='alert'>Erro: Produto não foi <b>excluido</b> com sucesso!</div>"];

    }

    echo json_encode($retorna);
