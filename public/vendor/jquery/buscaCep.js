// qnd não for passar parametro a melhor opção é o LOAD
$(function (){
    $('#load').bind('click', function (){
         $('#testeAjax').load('testeAjax.php');     
        
    });
});


//chamada para Json

$(function (){
    $('#form').bind('submit', function (e){
        e.preventDefault();
        var txt = $(this).serialize();
        console.log(txt);
        alert('aqui');
        $.ajax({
            type:'POST',//tipo de metodo de envio
            url:'json.php',//URL que ira receber os dados enviados
            data:txt,
            dataType:'json',
            
            success:function(json) {
               alert(json.nome);
            },
            error:function(){
                alert('erro ajax');
            }
            
            
            
        });
    });
});
