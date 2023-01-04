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
            $p(this).mask('R$ #.##0,00', {reverse: true});
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
                console.log(key['nome']);
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
        var tag = '<tr class="info-titulo" ><td><input type="date" class="form-control" name="data-vencimento[]" ></td>\n\
                        <td><input id="moeda" type="text" class="form-control" placeholder="R$" name="valor[]"></td>\n\
                        <td><input  type="number" class="form-control"  placeholder="Ctr" name="contrato[]"></td>\n\
                        <td><input  type="number" class="form-control" placeholder="Pc" name="parcela[]"></td>\n\
                        <td> <input type="date" class="form-control" name="data-geracao[]"></td>\n\
                        <td><button type="button" class="btn btn-block btn-dark btn-flat add-parcela">+</button></td>\n\
                        <td><button type="button" class="btn btn-block btn-danger btn-flat del-parcela">-</button></td></tr>';
       
        $p('.body-titulo').after(tag);
    });


//TELA TITULO - exclui a linha de cadastrar nova parcela
$p(document).on('click', '.del-parcela', function () {
    $p(this).closest('.info-titulo').remove(); 
});
