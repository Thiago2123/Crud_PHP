<?php


include_once "../conexaoComBd.php";

$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

if(empty($dados['id'])){
    $retorna = ['status' => false, 'msg' => "<div class='alert alert-danger' 
    role='alert'> <b>Erro</b>: Tente mais tarde, não enviado o ID: <b>".$dados['id']."</b></div>"];
}elseif(empty($dados['nome'])){
    $retorna = ['status' => false, 'msg' => "<div class='alert alert-danger' 
    role='alert'> <b>Erro</b>: Preencha o campo <b>Nome</b></div>"];
}elseif(empty($dados['email'])){
    $retorna = ['status' => false, 'msg' => "<div class='alert alert-danger' 
    role='alert'> <b>Erro</b>: Preencha o campo <b>E-mail</b></div>"];
}elseif(empty($dados['cpf'])){
    $retorna = ['status' => false, 'msg' => "<div class='alert alert-danger' 
    role='alert'> <b>Erro</b>: Preencha o campo <b>CPF</b></div>"];
}elseif(empty($dados['cep'])){
    $retorna = ['status' => false, 'msg' => "<div class='alert alert-danger' 
    role='alert'> <b>Erro</b>: Preencha o campo <b>CEP</b></div>"];
}elseif(empty($dados['rua'])){
    $retorna = ['status' => false, 'msg' => "<div class='alert alert-danger' 
    role='alert'> <b>Erro</b>: Preencha o campo <b>Rua</b></div>"];
}elseif(empty($dados['cidade'])){
    $retorna = ['status' => false, 'msg' => "<div class='alert alert-danger' 
    role='alert'> <b>Erro</b>: Preencha o campo <b>Cidade</b></div>"];
}elseif(empty($dados['estado'])){
    $retorna = ['status' => false, 'msg' => "<div class='alert alert-danger' 
    role='alert'> <b>Erro</b>: Preencha o campo <b>Estado</b></div>"];
}else{
    $query_usuario = "UPDATE clientes SET nome= :nome, email= :email, cpf= :cpf, cep= :cep, rua= :rua,
                        complemento= :complemento, cidade= :cidade, estado= :estado                        
                        WHERE id=:id";
    $edit_usuario = $conn->prepare($query_usuario);

    $edit_usuario->bindParam(':id', $dados['id']);
    $edit_usuario->bindParam(':nome', $dados['nome'],PDO::PARAM_STR);
    $edit_usuario->bindParam(':email', $dados['email'],PDO::PARAM_STR);
    $edit_usuario->bindParam(':cpf', $dados['cpf'],PDO::PARAM_STR);
    $edit_usuario->bindParam(':cep', $dados['cep'],PDO::PARAM_STR);
    $edit_usuario->bindParam(':rua', $dados['rua'],PDO::PARAM_STR);
    $edit_usuario->bindParam(':complemento', $dados['complemento'],PDO::PARAM_STR);
    $edit_usuario->bindParam(':cidade', $dados['cidade'],PDO::PARAM_STR);
    $edit_usuario->bindParam(':estado', $dados['estado'],PDO::PARAM_STR);

    if($edit_usuario->execute()){
        $retorna = ['status' => true, 'msg' => "<div class='alert alert-success' role='alert'>Usuário editado com sucesso!</div>"];
    }else{
        $retorna = ['status' => false, 'msg' => "<div class='alert alert-danger' role='alert'>Erro: Usuário não foi editado com sucesso!</div>"];
    }

    
}

echo json_encode($retorna);