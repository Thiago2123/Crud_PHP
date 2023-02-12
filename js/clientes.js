$(document).ready(function () {
    $('#listar-cliente').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": 'listarClientes.php',
        "order": [[0, 'desc']],
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.13.2/i18n/pt-BR.json"
        }
    });

})
function cadastrarCliente(){
 const formNovoCLiente = document.getElementById("form-cad-cliente");
 //const fecharModalCadastro = new bootstrap.Modal(document.getElementById("modalCadastroCliente"));
 //console.log(formNovoCLiente );
 if(formNovoCLiente){
    formNovoCLiente.addEventListener("submit", async(e) => {
        e.preventDefault();
        const dadosForm= new FormData(formNovoCLiente);
        //console.log(dadosForm);

        const dados = await fetch("cadastrarCliente.php", {
            method: "POST",
            body: dadosForm
        });        
        const resposta = await dados.json();
        //console.log(resposta);
        if(resposta['status']){
            document.getElementById("msgAlertaErroCadastro").innerHTML = "";
            document.getElementById("msgAlerta").innerHTML = resposta['msg'];
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


async function visualizarCliente(id){
    //console.log("id: "+id);
    const dados = await fetch('visualizarCliente.php?id=' + id);
    const resposta = await dados.json();
    //console.log(resposta);

    if(resposta['status']){
        $('#modalvisualisarUsuario').modal('show');
        document.getElementById("idClienteVis").innerHTML = resposta['dados'].id;
        document.getElementById("nomeClienteVis").innerHTML = resposta['dados'].nome;
        document.getElementById("emailClienteVis").innerHTML = resposta['dados'].email;
        document.getElementById("cpfClienteVis").innerHTML = resposta['dados'].cpf;
        document.getElementById("cepClienteVis").innerHTML = resposta['dados'].cep;
        document.getElementById("ruaClienteVis").innerHTML = resposta['dados'].rua;
        document.getElementById("complementoClienteVis").innerHTML = resposta['dados'].complemento;
        document.getElementById("cidadeClienteVis").innerHTML = resposta['dados'].cidade;
        document.getElementById("estadoClienteVis").innerHTML = resposta['dados'].estado;

        
        document.getElementById("msgAlerta").innerHTML = "";

    }else{
        document.getElementById("msgAlerta").innerHTML = resposta['msg'];
    }
}

async function modalEditarCliente(id){
    //console.log("editar: "+id);
    const dados = await fetch('visualizarCliente.php?id=' + id);
    const resposta = await dados.json();
    //console.log(resposta);
    if(resposta['status']){
        document.getElementById("msgAlerta").innerHTML = "";
        document.getElementById("msgAlertaEditar").innerHTML = "";

        document.getElementById('idClienteEdit').value = resposta['dados'].id;
        document.getElementById('nomeClienteEdit').value = resposta['dados'].nome;
        document.getElementById('emailClienteEdit').value = resposta['dados'].email;
        document.getElementById('cpfClienteEdit').value = resposta['dados'].cpf;
        document.getElementById('cepClienteEdit').value = resposta['dados'].cep;
        document.getElementById('ruaClienteEdit').value = resposta['dados'].rua;
        document.getElementById('complementoClienteEdit').value = resposta['dados'].complemento;
        document.getElementById('cidadeClienteEdit').value = resposta['dados'].cidade;
        document.getElementById('estadoClienteEdit').value = resposta['dados'].estado;
        
        $('#modalEditarCliente').modal('show');
    }else{
        document.getElementById("msgAlerta").innerHTML = resposta['msg'];
    }
};

function salvarEditCliente(){ 
    const formEditCliente = document.getElementById("form-edit-cliente");
    
    if(formEditCliente){
        formEditCliente.addEventListener("submit", async(e) => {
            e.preventDefault();
            const dadosForm = new FormData(formEditCliente);

            const dados = await fetch("editarCliente.php", {
                method: "POST",
                body: dadosForm
            })
            const resposta = await dados.json();
            console.log(resposta);
            if(resposta['status']){
                //document.getElementById("msgAlertaEditar").innerHTML = resposta['msg']
                document.getElementById("msgAlertaEditar").innerHTML = "";
                document.getElementById("msgAlerta").innerHTML = resposta['msg'];
                //limpar o formulario de editção
                formEditCliente.reset();
                $('#modalEditarCliente').modal('hide');

                //atualizar a lista de clientes
                listarDataTables = $('#listar-cliente').DataTable();
                listarDataTables.draw();


            }else{
                document.getElementById("msgAlertaEditar").innerHTML = resposta['msg'];
            }
        });
    }
};


async function excluirCliente(id){
    var confirmarExclusao = confirm("Tem certeza que deseja excluir o cliente selecionado? ");
    if(confirmarExclusao){
        //console.log("acessou com o id: "+id);
        const dados = await fetch("excluirCliente.php?id=" + id);
        const resposta = await dados.json();
        //console.log(resposta);

        if(resposta['status']){
            document.getElementById("msgAlerta").innerHTML = resposta['msg'];
            //atualizar a lista de clientes
            listarDataTables = $('#listar-cliente').DataTable();
            listarDataTables.draw();
        }else{
            document.getElementById("msgAlerta").innerHTML = resposta['msg'];
        }
    }
}