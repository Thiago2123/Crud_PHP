$(document).ready(function () {
    $('#listar-produtos').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": 'listarProdutos.php',
        "order": [[0, 'desc']],
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

    document.getElementById('criadoEmProduto').value = dataAtual;


})


function cadastrarProdutos() {
    const formNovoProduto = document.getElementById("form-cad-produto");
    //console.log(formNovoProduto );
    if (formNovoProduto) {
        formNovoProduto.addEventListener("submit", async (e) => {
            e.preventDefault();
            const dadosForm = new FormData(formNovoProduto);
            //console.log(dadosForm);

            const dados = await fetch("cadastrarProduto.php", {
                method: "POST",
                body: dadosForm,
            });
            const resposta = await dados.json();

            //console.log(resposta);
            if (resposta['status']) {
                document.getElementById("msgAlertaErroCadastro").innerHTML = "";
                document.getElementById("msgAlerta").innerHTML = resposta['msg'];
                formNovoProduto.reset();
                $('#modalCadastroProduto').modal('hide');
                document.getElementById('criadoEmProduto').value = dataAtual;
                listarDataTables = $('#listar-produtos').DataTable();
                listarDataTables.draw();

            } else {
                document.getElementById("msgAlertaErroCadastro").innerHTML = resposta['msg'];
            }

        });
    }
}


async function visualizarProduto(id) {
    //console.log("id: "+id);
    const dados = await fetch('visualizarProduto.php?id=' + id);
    const resposta = await dados.json();
    //console.log(resposta);

    if (resposta['status']) {
        $('#modalvisualisarProduto').modal('show');
        document.getElementById("idProdutoVis").innerHTML = resposta['dados'].id;
        document.getElementById("nomeProdutoVis").innerHTML = resposta['dados'].nome;
        document.getElementById("descricaoProdutoVis").innerHTML = resposta['dados'].descricao;
        document.getElementById("valorProdutoVis").innerHTML = 'R$  ' + resposta.valorFormatado;
        document.getElementById("criadoEmProdutoVis").innerHTML = resposta.dataFormatada;

        document.getElementById("msgAlerta").innerHTML = "";

    } else {
        document.getElementById("msgAlerta").innerHTML = resposta['msg'];
    }
}


async function modalEditarProduto(id) {
    //console.log("editar: "+id);
    const dados = await fetch('visualizarProduto.php?id=' + id);
    const resposta = await dados.json();
    //console.log(resposta);
    if (resposta['status']) {
        document.getElementById("msgAlerta").innerHTML = "";
        document.getElementById("msgAlertaEditar").innerHTML = "";

        document.getElementById('idProdutoEdit').value = resposta['dados'].id;
        document.getElementById('nomeProdutoEdit').value = resposta['dados'].nome;
        document.getElementById('descricaoProdutoEdit').value = resposta['dados'].descricao;
        document.getElementById('valorProdutoEdit').value = resposta.valorFormatado;
        //document.getElementById('criadoEmProdutoEdit').value = resposta['dados'].criado_em;
       

        $('#modalEditarProduto').modal('show');
    } else {
        document.getElementById("msgAlerta").innerHTML = resposta['msg'];
    }
};


function salvarEditProduto() {
    const formEditProduto = document.getElementById("form-edit-produto");

    if (formEditProduto) {
        formEditProduto.addEventListener("submit", async (e) => {
            e.preventDefault();
            const dadosForm = new FormData(formEditProduto);

            const dados = await fetch("editarProduto.php", {
                method: "POST",
                body: dadosForm
            })
            const resposta = await dados.json();
            //console.log(resposta);
            if (resposta['status']) {
                //document.getElementById("msgAlertaEditar").innerHTML = resposta['msg']
                document.getElementById("msgAlertaEditar").innerHTML = "";
                document.getElementById("msgAlerta").innerHTML = resposta['msg'];
                
                //limpar o formulario de editção
                formEditProduto.reset();
                $('#modalEditarProduto').modal('hide');

                //atualizar a lista de Produtos
                listarDataTables = $('#listar-produtos').DataTable();
                listarDataTables.draw();


            } else {
                document.getElementById("msgAlertaEditar").innerHTML = resposta['msg'];
            }
        });
    }
};


async function excluirProduto(id) {
    var confirmarExclusao = confirm("Tem certeza que deseja excluir o produto selecionado? ");
    //console.log (confirmarExclusao);
    if (confirmarExclusao) {
        //console.log("acessou com o id: "+id);
        const dados = await fetch("excluirProduto.php?id=" + id);
        const resposta = await dados.json();
        //console.log(resposta);

        if (resposta['status']) {
            document.getElementById("msgAlerta").innerHTML = resposta['msg'];
            //atualizar a lista de produtos
            listarDataTables = $('#listar-produtos').DataTable();
            listarDataTables.draw();
        } else {
            document.getElementById("msgAlerta").innerHTML = resposta['msg'];
        }
    }
}
