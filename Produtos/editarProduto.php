<?php


include_once "../conexaoComBd.php";

$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

// formatar para o . para que possa ser gravado no bd
$valorFormatado = str_replace(",",".",$dados['valor']);
$dados['valor'] = $valorFormatado;


if(empty($dados['id'])){
    $retorna = ['status' => false, 'msg' => "<div class='alert alert-danger' 
    role='alert'> <b>Erro</b>: Tente mais tarde, não enviado o ID: <b>".$dados['id']."</b></div>"];
}elseif(empty($dados['nome'])){
    $retorna = ['status' => false, 'msg' => "<div class='alert alert-danger' 
    role='alert'> <b>Erro</b>: Preencha o campo <b>Nome</b></div>"];
}elseif(empty($dados['descricao'])){
    $retorna = ['status' => false, 'msg' => "<div class='alert alert-danger' 
    role='alert'> <b>Erro</b>: Preencha o campo <b>Descrição</b></div>"];
}elseif(empty($dados['valor'])){
    $retorna = ['status' => false, 'msg' => "<div class='alert alert-danger' 
    role='alert'> <b>Erro</b>: Preencha o campo <b>Valor</b></div>"];
    
}else{
    $query_produto = "UPDATE produtos SET nome= :nome, descricao= :descricao, valor= :valor WHERE id=:id";
    $edit_produto = $conn->prepare($query_produto);

    $edit_produto->bindParam(':id', $dados['id']);
    $edit_produto->bindParam(':nome', $dados['nome'],PDO::PARAM_STR);
    $edit_produto->bindParam(':descricao', $dados['descricao'],PDO::PARAM_STR);
    $edit_produto->bindParam(':valor', $dados['valor'],PDO::PARAM_STR);

    if($edit_produto->execute()){
        $retorna = ['status' => true, 'msg' => "<div class='alert alert-success' role='alert'>Produto editado com sucesso!</div>"];
    }else{
        $retorna = ['status' => false, 'msg' => "<div class='alert alert-danger' role='alert'>Erro: Produto não foi editado com sucesso!</div>"];
    }

    
}

echo json_encode($retorna);