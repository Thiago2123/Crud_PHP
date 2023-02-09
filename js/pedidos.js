$(document).ready(function () {
    $('#listar-pedidos').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": 'listarPedido.php',
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.13.2/i18n/pt-BR.json",
        }
    });

var data = new Date();
var dia = String(data.getDate()).padStart(2, '0');
var mes = String(data.getMonth() + 1).padStart(2, '0');
var ano = data.getFullYear();
dataAtual = dia + '/' + mes + '/' + ano;

    //console.log(dataAtual);

document.getElementById('criadoEmPedido').value = dataAtual;


})


function cadastrarPedidos(){
    const formNovoPedido = document.getElementById("form-cad-pedido");
    //console.log(formNovoPedido );
    if(formNovoPedido){
       formNovoPedido.addEventListener("submit", async(e) => {
           e.preventDefault();
           const dadosForm= new FormData(formNovoPedido);
           //console.log(dadosForm);
   
           const dados = await fetch("cadastrarPedido.php", {
               method: "POST",
               body: dadosForm,
           });        
           const resposta = await dados.json();
           
           //console.log(resposta);
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