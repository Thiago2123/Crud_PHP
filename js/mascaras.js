function mascararCpf(cpf) {
    //console.log(cpf);
    let tamanhoCpf = cpf.value.length;
    if (tamanhoCpf === 3 || tamanhoCpf === 7){
        cpf.value += '.';
    }else if(tamanhoCpf == 11){
        cpf.value += '-';
    }
};

function mascararCep(cep){
       //console.log(cep);
       let tamanhoCep = cep.value.length;
       if (tamanhoCep === 5){
            cep.value += '-';
        };
};


