<?php 
    include_once "../conexaoComBd.php";

    $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

    if(empty($dados['nome'])){
        $retorna = ['status' => false, 'msg' => "<div class='alert alert-danger' 
        role='alert'> <b>Erro</b>: Deve preencher o campo <b>nome</b> </div>"]; 
    }elseif(empty($dados['descricao'])){
        $retorna = ['status' => false, 'msg' => "<div class='alert alert-danger' 
        role='alert'> <b>Erro</b>: Deve preencher o campo <b>Descrição</b> </div>"]; 
    }elseif(empty($dados['valor'])){
        $retorna = ['status' => false, 'msg' => "<div class='alert alert-danger' 
        role='alert'> <b>Erro</b>: Deve preencher o campo <b>Valor</b> </div>"]; 
    }else{
        $query_produto = "INSERT INTO produtos (nome, descricao, valor, criado_em)
        VALUES (:nome, :descricao, :valor, NOW())";
        $cad_produto = $conn->prepare($query_produto);
        $cad_produto->bindParam(':nome', $dados['nome'], PDO::PARAM_STR);
        $cad_produto->bindParam(':descricao', $dados['descricao'], PDO::PARAM_STR);
        $cad_produto->bindParam(':valor', $dados['valor'], PDO::PARAM_STR);
        //$cad_produto->bindParam(':criado_em', 'NOW()', PDO::PARAM_STMT);

        $cad_produto->execute();
        if($cad_produto->rowCount()){
            $retorna = ['status' => true, 'msg' => "<div class='alert alert-success' 
            role='alert'>Produto cadastrado com sucesso </div>"]; 
        }else{
            $retorna = ['status' => false, 'msg' => "<div class='alert alert-danger' 
            role='alert'> <b>Erro</b>: Não foi possivel cadastrar esse produto </div>"]; 
        }
    }

    echo json_encode($retorna);