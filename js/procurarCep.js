$(document).ready(function () {
        // recuperar cep
    function limpa_formulário_cep() {
        // Limpa valores do formulário de cep.
        // formulario de cadastro
        $("#ruaCliente").val("");
        $("#bairroCliente").val("");
        $("#cidadeCliente").val("");
        $("#estadoCliente").val("");

        // formulario de edição
        $("#ruaClienteEdit").val("");
        $("#bairroClienteEdit").val("");
        $("#cidadeClienteEdit").val("");
        $("#estadoClienteEdit").val("");

    }
    // função para exibir a mensagem de erro e pintando o campo
    function mensagemErro(msg){ 
        $('.cepInput').css(({"border-color": "red"}));
        $('#msgInvalida').removeClass("d-none").html(msg);
        limpa_formulário_cep();
    };
    
    // Quando o campo cep perde o foco.
    $(".cepInput").blur(function() {
  
        //Nova variável "cep" somente com dígitos.
        var cep = $(this).val().replace(/\D/g, '');
        //console.log(cep);
        //Verifica se campo cep possui valor informado.
        if (cep != "") {
  
            //Expressão regular para validar o CEP.
            var validacep = /^[0-9]{8}$/;
  
            //Valida o formato do CEP.
            if(validacep.test(cep)) {
  
                //Preenche os campos com "carregando" enquanto consulta webservice.
                //formulario cadastro
                $("#ruaCliente").val("Carregando..");
                $("#bairroCliente").val("Carregando..");
                $("#cidadeCliente").val("Carregando..");
                $("#estadoCliente").val("Carregando..");

                //formulario edição
                $("#ruaClienteEdit").val("Carregando..");
                $("#bairroClienteEdit").val("Carregando..");
                $("#cidadeClienteEdit").val("Carregando..");
                $("#estadoClienteEdit").val("Carregando..");
  
                //Consulta o webservice viacep.com.br/
                $.getJSON("https://viacep.com.br/ws/"+ cep +"/json/?callback=?", function(dados) {
  
                    if (!("erro" in dados)) {
                        //Atualiza os campos com os valores da consulta.

                        //formulario cadastro
                        $("#cepCliente").val(dados.cep);
                        $("#ruaCliente").val(dados.logradouro);
                        $("#bairroCliente").val(dados.bairro);
                        $("#cidadeCliente").val(dados.localidade);
                        $("#estadoCliente").val(dados.uf);

                        //formulario edit
                        $("#cepClienteEdit").val(dados.cep);
                        $("#ruaClienteEdit").val(dados.logradouro);
                        $("#bairroClienteEdit").val(dados.bairro);
                        $("#cidadeClienteEdit").val(dados.localidade);
                        $("#estadoClienteEdit").val(dados.uf);

                        $('#msgInvalida').addClass("d-none");

                    } //end if.
                    else {
                        //CEP pesquisado não foi encontrado.
                        mensagemErro("CEP não encontrado");
                        //alert("CEP não encontrado.");
                    }
                });
            } //end if.
            else {
                //cep é inválido.
                mensagemErro("Formato de CEP inválido");
                //alert("Formato de CEP inválido.");
            }
        } //end if.
        else {
            //cep sem valor, limpa formulário.
            mensagemErro("Formato de CEP inválido");
        }
    });
});

