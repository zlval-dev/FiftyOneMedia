$(window).on('load', function() {
    $.get("administracao.php?status=online")
});

$(window).on('beforeunload', function(){
    $.get("administracao.php?status=offline")
})

$('#message-context').focus()
$(".message-text").scrollTop($(".message-text")[0].scrollHeight)

//Enviar mensagem ao clicar 'enter'
$('#message-context').keypress(function (e) { 
    if(e.which == 13) {
        var texto = $('#message-context').prop('value')
        var user = $('#utilizador').val()
        $.get("enviar-mensagem.php?user="+user+"&mensagem="+texto.replace(/&/g,'%26'))
        $('#message-context').val('')
        location.reload()
    }
});

$('.message-fechar').click(function(){
    var user = $('#utilizador').val()
    $.get("mensagem-visto.php?user="+user)
    window.location.replace("mensagens.php");
})