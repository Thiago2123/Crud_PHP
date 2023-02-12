<?php
include_once "../conexaoComBd.php";

$id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_NUMBER_INT);
if(!empty($id)){
   $query_produto =  "SELECT *
        FROM produtos WHERE id = :id LIMIT 1";
    $result_produto = $conn->prepare($query_produto);
    $result_produto->bindParam(':id', $id);
    $result_produto->execute();

    if(($result_produto) and ($result_produto->rowCount() != 0)){
        $row_produto = $result_produto->fetch(PDO::FETCH_ASSOC);
        $retorna = ['status' => true, 'dados' => $row_produto];

        //transforma a data do banco em hrs 
        $data = strtotime($row_produto['criado_em']);
        //formata a data em hrs, em dia/mes/ano
        $dataFormatada = date('d/m/Y', $data);

        //retorna os dados com a data formatada
        $retorna = $retorna + ['dataFormatada' => $dataFormatada];

        $valorFormatado = number_format($retorna['dados']['valor'], 2, ",", ".");
        $retorna = $retorna + ['valorFormatado' => $valorFormatado];
        //var_dump($retorna['dados']['valor']);

    }else{
        $retorna = ['status' => false, 'msg' => "<div class='alert alert-danger' 
        role='alert'> <b>Erro</b>: Nenhum produto encontrado</div>"];
    }

}else{
    $retorna = ['status' => false, 'msg' => "<div class='alert alert-danger' 
    role='alert'> <b>Erro</b>: Nenhum produto encontrado o id não esta vindo</div>"];
 }

echo json_encode($retorna);

?>