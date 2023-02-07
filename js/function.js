$(document).ready(function () {
    $('#listar-cliente').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": 'listar_clientes.php',
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.13.2/i18n/pt-BR.json"
        }
    });
    function limpa_formulário_cep() {
        // Limpa valores do formulário de cep.
        $("#ruaCliente").val("");
        $("#bairroCliente").val("");
        $("#cidadeCliente").val("");
        $("#estadoCliente").val("");
    }
    
    //Quando o campo cep perde o foco.
    $("#cepCliente").blur(function() {
  
        //Nova variável "cep" somente com dígitos.
        var cep = $(this).val().replace(/\D/g, '');
  
        //Verifica se campo cep possui valor informado.
        if (cep != "") {
  
            //Expressão regular para validar o CEP.
            var validacep = /^[0-9]{8}$/;
  
            //Valida o formato do CEP.
            if(validacep.test(cep)) {
  
                //Preenche os campos com "..." enquanto consulta webservice.
                $("#ruaCliente").val("Carregando..");
                $("#bairroCliente").val("Carregando..");
                $("#cidadeCliente").val("Carregando..");
                $("#estadoCliente").val("Carregando..");
  
                //Consulta o webservice viacep.com.br/
                $.getJSON("https://viacep.com.br/ws/"+ cep +"/json/?callback=?", function(dados) {
  
                    if (!("erro" in dados)) {
                        //Atualiza os campos com os valores da consulta.
                        $("#cepCliente").val(dados.cep);
                        $("#ruaCliente").val(dados.logradouro);
                        $("#bairroCliente").val(dados.bairro);
                        $("#cidadeCliente").val(dados.localidade);
                        $("#estadoCliente").val(dados.uf);
                    } //end if.
                    else {
                        //CEP pesquisado não foi encontrado.
                        limpa_formulário_cep();
                        alert("CEP não encontrado.");
                    }
                });
            } //end if.
            else {
                //cep é inválido.
                limpa_formulário_cep();
                alert("Formato de CEP inválido.");
            }
        } //end if.
        else {
            //cep sem valor, limpa formulário.
            limpa_formulário_cep();
        }
    });
});

function cadastrarCliente(){
 const formNovoCLiente = document.getElementById("form-cad-cliente");
 //const fecharModalCadastro = new bootstrap.Modal(document.getElementById("modalCadastroCliente"));
 //console.log(formNovoCLiente );
 if(formNovoCLiente){
    formNovoCLiente.addEventListener("submit", async(e) => {
        e.preventDefault();
        const dadosForm= new FormData(formNovoCLiente);
        //console.log(dadosForm);

        const dados = await fetch("cadastrar.php", {
            method: "POST",
            body: dadosForm
        });        
        const resposta = await dados.json();
        //console.log(resposta);
        if(resposta['status']){
            document.getElementById("msgAlertaErroCadastro").innerHTML = "";
            document.getElementById("msgAlertaSucesso").innerHTML = resposta['msg'];
            formNovoCLiente.reset();
            $('#modalCadastroCliente').modal('hide');
            listarDataTables = $('#listar-cliente').DataTable();
            listarDataTables.draw();

        }else{
            document.getElementById("msgAlertaErroCadastro").innerHTML = resposta['msg'];
        }

    });
 }
}