$(document).ready(function () {
    function mensagemErro(msg){ 
        $('.cpfInput').css(({"border-color": "red"}));
        $('.msgInvalidaCpf').removeClass("d-none").html(msg);
    };
    $(".cpfInput").blur(function() {
        

        // Nova variável "cpf" mas somente com dígitos.
        cpf = $(this).val().replace(/\D/g, '');
            
        // retirar os cpfs que batem com a conta porem são invalidos
        if (cpf == "00000000000" || cpf == "11111111111" || cpf == "22222222222" || cpf == "33333333333" || 
            cpf == "44444444444" || cpf == "55555555555" ||cpf == "66666666666" || cpf == "77777777777" || 
            cpf == "88888888888" || cpf == "99999999999" ){
            
            //mensagemErro("CPF é inválido");   
            alert(cpf+" invalido");
        }
        
        // valida o primeiro digito
        var soma = 0
        var resto
        // multiplico o digito pelo tamanho do cpf e vou multiplicando por 10 e dencendo
        for (i = 1; i <= 9; i++) {
            soma = soma + parseInt(cpf.substring(i-1, i)) * (11 - i)
            resto = (soma * 10) % 11
        }
        // pela regra se o resto for 10 ou 11 é pra considerar = 0
        if ((resto == 10) || (resto == 11))  {
            resto = 0
        }
        // vejo seo resto que deu foi difente da posição 9 e 10 do cpf
        if (resto != parseInt(cpf.substring(9, 10)) ) {            
            // alert(cpf+"invalido");
            mensagemErro("CPF é inválido");
        }else{
            $('.msgInvalidaCpf').addClass("d-none").html="";
            $('.cpfInput').css(({"border-color": "ced4da"}));
        }

        // valida o segundo digito, da mesma forma porem agora é multiplicando por 11 e descendo
        soma = 0
        for (var i = 1; i <= 10; i++) 
            soma = soma + parseInt(cpf.substring(i-1, i)) * (12 - i)
            resto = (soma * 10) % 11
        if ((resto == 10) || (resto == 11)){ 
            resto = 0
        }
        if (resto != parseInt(cpf.substring(10, 11))) {
            //alert(cpf+"invalido");
            mensagemErro("CPF é inválido");

        }else{
            $('.msgInvalidaCpf').addClass("d-none").html="";
            $('.cpfInput').css(({"border-color": "ced4da"}));
        }
        
        
    });    
    
});
