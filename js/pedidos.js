$(document).ready(function () {
    $('#listar-pedidos').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": 'listarPedido.php',
        "order": [[0, 'desc']],
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.13.2/i18n/pt-BR.json",
        }
    });

    // pega a data atual e coloca no formato correto
    var data = new Date();
    var dia = String(data.getDate()).padStart(2, '0');
    var mes = String(data.getMonth() + 1).padStart(2, '0');
    var ano = data.getFullYear();
    dataAtual = dia + '/' + mes + '/' + ano;

        // console.log(dataAtual);
    // colocar o campo criadm Em a data atual
    document.getElementById('criadoEmPedido').value = dataAtual;

    // somar todos os produtos selecionad e mostrar no preço dos pedidos 
    document.getElementById("selectProdutos").addEventListener("change",(e)=>{
        let valorTotal = 0;
        for(let selecionado of e.target.options){
            let val = parseFloat(selecionado.dataset.valor.replace(',','.'));
            valorTotal += selecionado.selected ? val : 0;
        }
        document.getElementById("precoVenda").value = valorTotal.toFixed(2).replace('.',',');
    });
     
    // dar o deconto quando desfocar do campo desconto
    $("#descontoPedido").blur(function() {
        // pegar o valor que é digitado quando mudar o foco do input
        var porcentagem = $(this).val();

        // pegar o valor total do pedido sem o desconto e tranformar em float retirando a ','
        var valorOrginal = parseFloat(document.getElementById("precoVenda").value.replace(',','.'));
        // equação para decobrir o desconto
        var valorDesconto = valorOrginal / 100 * porcentagem;
        // verificar qual o novo valor com o desconto aplicado
        var valorNovoComDesconto = valorOrginal - valorDesconto
        // console.log(valorNovoComDesconto);
        
        document.getElementById("precoVenda").value = valorNovoComDesconto.toFixed(2).replace('.',',');

    });



});


function cadastrarPedido(){
    const formNovoPedido = document.getElementById("form-cad-pedido");
    // console.log(formNovoPedido );
    if(formNovoPedido){
       formNovoPedido.addEventListener("submit", async(e) => {
           e.preventDefault();
           const dadosForm= new FormData(formNovoPedido);
           // console.log(dadosForm);
   
           const dados = await fetch("cadastrarPedido.php", {
               method: "POST",
               body: dadosForm,
           });        
           const resposta = await dados.json();
           
           // console.log(resposta);
           if(resposta['status']){
               document.getElementById("msgAlertaErroCadastro").innerHTML = "";
               document.getElementById("msgAlerta").innerHTML = resposta['msg'];
               formNovoPedido.reset();
               $('#modalCadastroPedido').modal('hide');
               document.getElementById('criadoEmPedido').value = dataAtual;
               listarDataTables = $('#listar-pedidos').DataTable();
               listarDataTables.draw();
   
           }else{
               document.getElementById("msgAlertaErroCadastro").innerHTML = resposta['msg'];
           }
       });
    }
}

async function visualizarClientesPedido(pedidoId){
    //console.log("id: "+id);
    const dados = await fetch('visualizarClientesPedido.php?id=' + pedidoId);
    const resposta = await dados.json();
    //console.log(resposta);

    $('#modalvisualisarClientesPedido').modal('show');
    if(resposta['status']){
        document.getElementById("nomeVisuCliPed").innerHTML = resposta['dados'].nome;
        document.getElementById("cpfVisuCliPed").innerHTML = resposta['dados'].cpf;
        document.getElementById("ruaVisuCliPed").innerHTML = resposta['dados'].rua;
        document.getElementById("cidadeVisuCliPed").innerHTML = resposta['dados'].cidade;
        document.getElementById("estadoVisuCliPed").innerHTML = resposta['dados'].estado;
        document.getElementById("criadoEmVisuCliPed").innerHTML = resposta.dataFormatada;

        document.getElementById("msgAlerta").innerHTML = "";

    }else{
        document.getElementById("msgAlerta").innerHTML = resposta['msg'];
    }
}



async function salvarEditPedido(pedidoId) {
    var selectStatusPedido = document.getElementById("selectStatusPedido").value;
    
    //console.log(selectStatusPedido);
    //console.log(pedidoId);
    var dados = await fetch("editarPedido.php?selectStatusPedido=" + selectStatusPedido + "&pedidoId=" + pedidoId);
    var resposta = await dados.json();
    //console.log(resposta);
    if(resposta['status']){
        document.getElementById("msgAlerta").innerHTML = "";
        selectStatusPedido.reset();

        listarDataTables = $('#listar-produtos').DataTable();
        listarDataTables.draw();
    }else{
        document.getElementById("msgAlerta").innerHTML = resposta['msg'];
    }
    
};
