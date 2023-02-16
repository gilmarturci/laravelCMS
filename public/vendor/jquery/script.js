var $p = jQuery.noConflict();




//TELA DEVEDORES - exibe as div ao clicar em dados pessoais
$p(function () {
    $p('#showDadosPessoais').click(function () {
        $p("#DadosPessoais").toggle();
    });
});
//TELA DEVEDORES - exibe as div ao clicar em endereço
$p(function () {
    $p('#showEndereco').click(function () {
        $p("#enderecocollapse").toggle();
    });
});

//TELA DEVEDORES - exibe as div ao clicar em contato
$p(function () {
    $p('#showEmail').click(function () {
        $p("#emailcollapse").toggle();
    });
});
//TELA DEVEDORES - exibe as div ao clicar em telefone
$p(function () {
    $p('#showFone').click(function () {
        $p("#telefonecollapse").toggle();
    });
});

//TELA DEVEDORES - substitua ID pelo id do elemento
$p(function () {
   
    $p("#novoEmail").click(function () {
        var tag = '<input type="email" class="form-control" name="email[]"></br>';
        $p('#email').after(tag);
    });
});
//TELA DEVEDORES - substitua ID pelo id do elemento

$p(function () {
    $p("#novoFone").click(function () {
        var tag = '<input type="fone" class="form-control" name="telefone[]"></br>';
        $p('#fone').after(tag);
    });
});

//TELA DEVEDORES - mascara para campos especiais
$p(function () {
        $p("#cpf").keypress(function() {
            $(this).mask('000.000.000-00');
        });
        $p("#rg").keypress(function() {
            $(this).mask('00.000.000-0');
        });
        $p("#cnpj").keypress(function() {
            $p(this).mask('00.000.000/0000-00');
        });
        $p("#cep").keypress(function() {
            $p(this).mask('00.000-000');
        });
        $p("#altura").keypress(function() {
           $p(this).mask('90,00', {reverse: true});
        }); 
        $p("#moeda").keypress(function() {
            $p(this).mask('R$ ##.##0,00', {reverse: true});
        });        
        $p("#fixo").keypress(function() {
            $p(this).mask('(00) 0000-0009');
        });
         $p("#celular").keypress(function() {
            $p(this).mask('(00) 000000009');
        }); 
        
        $p("#data").keypress(function() {
            $p(this).mask('00/00/0000');
        });       
       $p("#hora").keypress(function() {
           $p(this).mask('00:00');
        });
});




//TELA DEVEDORES -Selecina o item mais próximo do botão EXCLUIR e envia lista para exclusao 
$p(function ($p) {
    remove = function (item) {

        var tr = $p(item).closest('div');
        var cod = $p("#cod").val();
        var email = $p(item).closest("div").find("#emaildel").val();


        if (confirm("Deseja Excluir o item da lista?")) {

            $p.ajax({
                type: 'GET', //tipo de metodo de envio
                 url: '/painel/delete/email_delete?email=' + email + '&'+ 'cod=' + cod, //URL que ira receber os dados enviados
                // data: txt,
                datatype: 'json',

                success: function (resultado) {

                    tr.fadeOut(400, function () {
                        tr.remove();
                    });
                },
                error: function () {
                    alert('erro ajax email');
                }

            });
        }
        return false;
    }
});

//TELA DEVEDORES - faz pesquisa por cep e busca endereço
$p(function () {
    $p('#cep').on('keydown', function (e) {
        var keyCode = e.keyCode || e.which;
        if (keyCode == 9 || keyCode == 13) {
            var txt = $(this).val();
            $p.ajax({
                type: 'GET', //tipo de metodo de envio
                url: '/painel/pesquisa/cep?cep=' + txt, //URL que ira receber os dados enviados
                // data: txt,
                datatype: 'json',
                success: function (resultado) {

                    console.log(resultado);
                    const obj = JSON.parse(resultado);
                    $p('#logadouro').val(obj.logradouro);
                    $p('#cidade').val(obj.localidade);
                    $p('#uf').val(obj.uf).prop('selected', true);
                    $p('#bairro').val(obj.bairro);
                },
                error: function () {
                    alert('erro ajax cep');
                }



            });
        }
    });
});

//TELA TITULO -captura o select da tela tutulos para listar os devedores por credor

$p('#select-credor').change(function () {


    $p('#select-devedor').find('option:not(:first)').remove(); // limpa as option
    var credor = $(this).val();
    $p.ajax({
        type: 'GET', //tipo de metodo de envio
        url: '/painel/searchDebertor/credor?credor=' + credor, //URL que ira receber os dados enviados
        // data: txt,
        datatype: 'json',
        success: function (data) {

            const devedor = JSON.parse(data);

            $p.each(devedor, function (value, key) {

                var tag = "<option id='option-cliente'>" + key['nome'] + "</option>";

                $p("#option-devedor").after(tag);
             
            });



        },
        error: function () {
            alert('erro ajax cep');
        }
    });

});

//TELA TITULO -captura o select da tela tutulos - devedor para listar o CPF do devedor
$p('#select-devedor').change(function () {


    var nome = $(this).val();

    $p.ajax({
        type: 'GET', //tipo de metodo de envio
        url: '/painel/searchCpf/nome?nome=' + nome, //URL que ira receber os dados enviados
        // data: txt,
        datatype: 'json',
        success: function (data) {

            const cpf = JSON.parse(data);
            
                    $p('#cpf').val(cpf);
        },
        error: function () {
            alert('erro ajax cep');
        }
    });

});

//TELA TITULO - Abre novo campo para cadastro de parcela
$p(document).on('click', '.add-parcela', function () {
         var tag = '<tr class="info-titulo"><td><input name="data-vencimento[]" type="date" class="form-control"></td>\n\
                        <td><input id="moeda" type="text" class="form-control" placeholder="R$" name="valor[]"></td>\n\
                        <td><input  type="number" class="form-control"  placeholder="Ctr" name="contrato[]"></td>\n\
                        <td><input  type="number" class="form-control" placeholder="Pc" name="parcela[]"></td>\n\
                        <td> <input type="date" class="form-control" name="data-geracao[]"></td>\n\
                        <td><button type="button" class="btn btn-block btn-dark btn-flat add-parcela">+</button></td>\n\
                        <td><button type="button" class="btn btn-block btn-danger btn-flat del-parcela">-</button></td></tr>';

    $p('.card-body .tabela .body-titulo').append(tag);
       
    });
    
    
    
    //TELA TITULO - exclui a linha de cadastrar nova parcela
$p(document).on('click', '.del-parcela', function () {
     $(this).closest('tr').remove(); 
});
    
    
   
// TELA TITULOS -checkbox marcar todos os checkBox
  // checkbox marcar todos
document.getElementById("check_all_1").onclick = function() {
     $('input:checkbox').not(this).prop('checked', this.checked);
};
      


//TELA TITULO - Remove os titulos selecionados na check
document.getElementById("del-titulo").onclick = function () {
    //Remove a informação da view
    ckList = document.querySelectorAll("input[type=checkbox]:checked");
    ckList.forEach(function (el) {
        el.parentElement.parentElement.remove();
    });

             //Remove a informação do banco

    var contrato = $p(ckList).closest("tr").find("#contrato").text();
    var parcela = $p(ckList).closest("tr").find("#parcela").text();
    var debertor_id = $p(ckList).closest("tr").find("#debertor-id").text();

        if (confirm("Deseja Excluir o item da lista?")) {
            
            $.ajax({
                type: 'GET', //tipo de metodo de envio
                 url: '/painel/del.titulo/destroy?contrato=' + contrato + '&'+ 'parcela=' + parcela+ '&'+ 'debertor_id=' + debertor_id, //URL que ira receber os dados enviados
               // data: txt,
                datatype: 'json',

                success: function (resultado) {

                   alert("Titulo removido com sucesso");
                },
                error: function () {
                    alert('erro contate o suporte');
                }

            });
        }
        return false;
    
};

// Abre modal da tela alterar status titulo
$p(function () {
    $('#status-titulo').click(function () {
        $('#modal').modal('show');
    });
});


//TELA TITULO - altera status do titulo
document.getElementById("info-baixa").onclick = function () {
  
    ckList = document.querySelectorAll("input[type=checkbox]:checked");
    
    var debertor_id = $p(ckList).closest("tr").find("#debertor-id").text();
    var contrato = $p(ckList).closest("tr").find("#contrato").text();
    var parcela = $p(ckList).closest("tr").find("#parcela").text();
    var debertor_id = $p(ckList).closest("tr").find("#debertor-id").text();
    var status = $p(ckList).closest("tr").find("#status").text();
    var data_pgto = $p("#data-pagamento").val();
    var portador = $p("#portador").val();
    var forma_pgto = $p("#forma-pagamento").val();
    var valor = $p("#valor").val();
    var juros = $p("#juros").val();
    var multa = $p("#multa").val();
    var desconto = $p("#desconto").val();

            
            $.ajax({
                type: 'GET', //tipo de metodo de envio
                 url: '/painel/update.titulo/update?contrato=' + contrato + '&'+ 'parcela=' + parcela+ '&'+ 'debertor_id=' + debertor_id
                         +'&'+ 'status=' + status+'&'+ 'data_pgto=' + data_pgto+'&'+ 'portador=' + portador +'&'+ 'forma_pgto=' + forma_pgto
                 +'&'+ 'valor=' + valor +'&'+ 'juros=' + juros+'&'+ 'multa=' + multa +'&'+ 'desconto=' + desconto, 
               // data: txt,
                datatype: 'json',

                success: function (resultado) {

                   alert(resultado);
                   location.reload();
                },
                error: function () {
                    alert('erro contate o suporte');
                }

            });
        
        return false;
    
};


