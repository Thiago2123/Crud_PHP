<?php 
    include_once "../conexaoComBd.php";

    $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

    if(empty($dados['nome'])){
        $retorna = ['status' => false, 'msg' => "<div class='alert alert-danger' 
        role='alert'> <b>Erro</b>: Deve preencher o campo <b>nome</b> </div>"]; 
    }elseif(empty($dados['email'])){
        $retorna = ['status' => false, 'msg' => "<div class='alert alert-danger' 
        role='alert'> <b>Erro</b>: Deve preencher o campo <b>email</b> </div>"]; 
    }elseif(empty($dados['cpf'])){
        $retorna = ['status' => false, 'msg' => "<div class='alert alert-danger' 
        role='alert'> <b>Erro</b>: Deve preencher o campo <b>cpf</b> </div>"]; 
    }elseif(empty($dados['cep'])){
        $retorna = ['status' => false, 'msg' => "<div class='alert alert-danger' 
        role='alert'> <b>Erro</b>: Deve preencher o campo <b>CEP</b> </div>"]; 
    }else{
        $query_cliente = "INSERT INTO clientes (nome, email, cpf, cep, rua, complemento, cidade, estado)
        VALUES (:nome, :email, :cpf, :cep, :rua, :complemento, :cidade, :estado)";
        $cad_cliente = $conn->prepare($query_cliente);
        $cad_cliente->bindParam(':nome', $dados['nome'], PDO::PARAM_STR);
        $cad_cliente->bindParam(':email', $dados['email'], PDO::PARAM_STR);
        $cad_cliente->bindParam(':cpf', $dados['cpf'], PDO::PARAM_STR);
        $cad_cliente->bindParam(':cep', $dados['cep'], PDO::PARAM_STR);
        $cad_cliente->bindParam(':rua', $dados['rua'], PDO::PARAM_STR);
        $cad_cliente->bindParam(':complemento', $dados['complemento'], PDO::PARAM_STR);
        $cad_cliente->bindParam(':cidade', $dados['cidade'], PDO::PARAM_STR);
        $cad_cliente->bindParam(':estado', $dados['estado'], PDO::PARAM_STR);

        $cad_cliente->execute();
        if($cad_cliente->rowCount()){
            $retorna = ['status' => true, 'msg' => "<div class='alert alert-success' 
            role='alert'>Cadastrado com sucesso </div>"]; 
        }else{
            $retorna = ['status' => false, 'msg' => "<div class='alert alert-danger' 
            role='alert'> <b>Erro</b>: Não foi possivel cadastrar esse usuario </div>"]; 
        }
    }

    echo json_encode($retorna);