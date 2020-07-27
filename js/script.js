//Variaveis Globais
var about_us = false
var services = false
var portfolio = false
var contacts = false
var home = false
var submenu_about_us = true
var submenu_services = true
var top_menu = true
var chat_aberto = false
var admin = $('#utilizador').val()
if($('.language').prop('src') == 'http://zlval.pt/imagens/language/en.png'){
    var language = 'en'
}else if($('.language').prop('src') == 'http://zlval.pt/imagens/language/pt.png'){
    var language = 'pt'
}



$('.top_menu a').click(function(e){
    $('.link_submenu').removeAttr('id')
    $('.link_submenu_services').removeAttr('id')
        if(top_menu){
            //Impedir o comportamento normal do evento que seria a navegação para um novo url
            e.preventDefault()
            //Guardar numa variável o valor do atributo href do elemento clicado
            var target = $(this).attr('href')
            //Guardar numa variável a distância da secção ao topo do documento
            var distance_top = $(target).offset().top
            
            var docViewTop = $(window).scrollTop()
            if(!(docViewTop == 30 && $(this).prop('href') == "http://zlval.pt/#top_home")){
                //Animar o scroll da página para a secção desejada
                $('html, body').animate({scrollTop:distance_top+30},1000)
        
                $('.menu a').removeClass('menu_activo')
                $('.submenu a').removeClass('submenu_activo')
                $('#janela-noticia').hide(300)
                $('.article_portfolio').removeClass('article_active')
                $('.article_services').stop().animate({'left':'-29%'}, 500)
                $('.article').stop().animate({'left':'-100%'}, 1000)
                $('.submenu_about_us a').removeClass('submenu_activo')
                top_menu = false
                setTimeout(function(){ top_menu = true}, 1000)                
            }
        }
    })


 $('.submenu_about_us a').click(function(e){

        if(submenu_about_us){
            //Guardar o índice do menu clicado
            var index_sub_clicado = $(this).index()
            //Guardar o índice do menu activo
            var index_sub_activo = $('#submenu_activo').index()

            //Remover a class menu_activo de todos os menus
            $('.link_submenu').removeAttr('id')
            //Adicionar a class menu_activo ao menu clicado
            $(this).attr('id', 'submenu_activo')

            //Verificar se o menu clicado não é o que já está activo
            if( index_sub_activo !== index_sub_clicado ){
                if(index_sub_clicado == 0){
                    $(this).prop('href', '#missao')
                }else if(index_sub_clicado == 1){
                    $(this).prop('href', '#visao')
                }else{
                    $(this).prop('href', '#valores')
                }
                //Animar todas as páginas para a esquerda
                $('.article').stop().animate({'left':'-100%'}, 500)
                //Colocar à direita a página que vai aparecer
                $('.article').eq( index_sub_clicado ).stop().css('left','100%')
                //Animar a entrada da página seleccionada
                $('.article').eq( index_sub_clicado ).animate({'left':'15%'}, 1000)
                //Impedir o comportamento normal do evento que seria a navegação para um novo url
                e.preventDefault()
                //Guardar numa variável o valor do atributo href do elemento clicado
                var target = $(this).attr('href')
                //Guardar numa variável a distância da secção ao topo do documento
                var distance_top = $(target).offset().top
                //Animar o scroll da página para a secção desejada
                $('html, body').animate({scrollTop:distance_top-300},1000)
                $(this).removeAttr('href')
                submenu_about_us = false
                setTimeout(function(){ submenu_about_us = true}, 1000)
            }
        }

    })

$('.works_sections a').click(function(e){
        //Impedir o comportamento normal do evento que seria a navegação para um novo url
        e.preventDefault()
        //Guardar numa variável o valor do atributo href do elemento clicado
        var target = $(this).attr('href')
        //Guardar numa variável a distância da secção ao topo do documento
        var distance_top = $(target).offset().top
        //Animar o scroll da página para a secção desejada
        $('html, body').animate({scrollTop:distance_top+30},1000)
        //Depois de fazer scroll para o trabalho correto, abrir informação sobre o projeto e colocar o projeto como ativo
        var conteudo = $(target).html()
        $('#janela-conteudo').html(conteudo)
        $('#janela-noticia').show(600)
        //Remover a class menu_activo de todos os menus
        $('.article_portfolio').removeClass('article_active')
        //Adicionar a class menu_activo ao menu clicado
        $(target).addClass('article_active')
    })

$('.button_backtotop a').click(function(e){
        //Impedir o comportamento normal do evento que seria a navegação para um novo url
        e.preventDefault()
        //Guardar numa variável o valor do atributo href do elemento clicado
        var target = $(this).attr('href')
        //Guardar numa variável a distância da secção ao topo do documento
        var distance_top = $(target).offset().top
        //Animar o scroll da página para a secção desejada
        $('html, body').animate({scrollTop:distance_top+30},2500)
	
	  	$('.menu a').removeClass('menu_activo')
	 	$('.submenu a').removeClass('submenu_activo')
 		$('#janela-noticia').hide(200)
		$('.article_portfolio').removeClass('article_active')
	  	$('.article_services').stop().animate({'left':'-29%'}, 500)
	  	$('.article').stop().animate({'left':'-100%'}, 1000)
		$('.submenu_about_us a').removeClass('submenu_activo')
        }
    )

 $('.submenu_services a').click(function(e){

        if(submenu_services){
            //Guardar o índice do menu clicado
            var index_sub_clicado = $(this).index()
            //Guardar o índice do menu activo
            var index_sub_activo = $('#submenu_activo_services').index()

            //Remover a class menu_activo de todos os menus
            $('.link_submenu_services').removeAttr('id')
            //Adicionar a class menu_activo ao menu clicado
            $(this).attr('id', 'submenu_activo_services')

            //Verificar se o menu clicado não é o que já está activo
            if( index_sub_activo !== index_sub_clicado ){
                if(index_sub_clicado == 0){
                    $(this).prop('href', '#service_design')
                }else if(index_sub_clicado == 1){
                    $(this).prop('href', '#service_webdesign')
                }else{
                    $(this).prop('href', '#service_animation')
                }
                //Animar todas as páginas para a esquerda
                $('.article_services').stop().animate({'left':'-29%'}, 500)
                //Colocar à direita a página que vai aparecer
                $('.article_services').eq( index_sub_clicado ).stop().css('right','100%')
                //Animar a entrada da página seleccionada
                $('.article_services').eq( index_sub_clicado ).animate({'left':'35%'}, 1000)
                //Impedir o comportamento normal do evento que seria a navegação para um novo url
                e.preventDefault()
                //Guardar numa variável o valor do atributo href do elemento clicado
                var target = $(this).attr('href')
                //Guardar numa variável a distância da secção ao topo do documento
                var distance_top = $(target).offset().top
                //Animar o scroll da página para a secção desejada
                $('html, body').animate({scrollTop:distance_top-300},1000)
                $(this).removeAttr('href')
                submenu_services = false
                setTimeout(function(){ submenu_services = true}, 1000)            
            }
        }
    })

 $('.article_portfolio').click(function(){

        var conteudo = $(this).html()

        $('#janela-conteudo').html(conteudo)
        $('#janela-noticia').show(600)

        //Remover a class menu_activo de todos os menus
        $('.article_portfolio').removeClass('article_active')
        //Adicionar a class menu_activo ao menu clicado
        $(this).addClass('article_active')

    })

$('#janela-fechar').click(function(){
    $('#janela-noticia').hide(600)
    $('.article_portfolio').removeClass('article_active')
})

//Função para selecionar as opções do menu corretas ao carregar a página
$(document).ready(function() {
    selectMenu()
    update()
})

//Função para atualizar em tempo real o chat
function update(){
    //Obter os dados das novas mensagens e numero das mensagens
    $.get("update-chat.php", function(data){
        duce = jQuery.parseJSON(data)
        if(duce.length > 0){
            var notificacoes = duce[0]
            var novas_mensagens = []
            var contador = 1
            while(contador < duce.length){
                novas_mensagens.push(duce[contador])
                contador++
            }
        }
        if(notificacoes > 0){
            $('#notificacao').css('display', 'block')
            $('#notificacao').html(notificacoes)
            if(chat_aberto){
                while(novas_mensagens.length != 0){
                    if(admin){
                        $('.message-message').append("<div class='container_admin'><p id='message-context-admin' style='margin-top: 2px;' class='this-message'></p></div>")
                        $('.this-message').text(novas_mensagens[0])
                        $('.this-message').removeClass()
                    }else{
                        $('.message-message').append("<div class='container_admin'><p style='margin-top: 15px;'></p><p id='message-context-admin' class='this-message'></p></div>")
                        $('.this-message').text(novas_mensagens[0])
                        $('.this-message').removeClass()
                        admin = true
                    }
                    novas_mensagens.shift()
                }
                removerNotificacoes()
                $(".message-text").scrollTop($(".message-text")[0].scrollHeight)
            }
        }
    });
    $.get("status.php", function(data){
        duce = jQuery.parseJSON(data)
        if(duce[0] == 1){
            $('#message-status').attr('src', 'imagens/online.png')
            $('.last-online').text('')
        }else if(duce[0] == 0){
            $('#message-status').attr('src', 'imagens/offline.png')
            if(language == 'pt'){
                $('.last-online').text('Online a '+duce[3]+' '+duce[4])
            }else{
                $('.last-online').text('Online to '+duce[3]+' '+duce[4])
            }
        }
    });
    setTimeout(update, 1000);
}

//Função para selecionar as opções do menu corretas na ação do scroll
$( window ).scroll(function() {
    selectMenu()
})

//Função para remover as opções selecionadas no menu
$('#removeMenu').click(function(){
    removeActive()
})

//Função para remover todo o que está selecionado no menu
function removeActive(){
    $('#menu_aboutus').removeClass('submenu_activo')
    $('#menu_services').removeClass('submenu_activo')
    $('#menu_portfolio').removeClass('submenu_activo')
    $('#menu_contacts').removeClass('submenu_activo')
    about_us = false
    services = false
    portfolio = false
    contacts = false
    home = false
}

//Função para selecionar as opções no menu
function selectMenu(){
    //Dados do scroll
    var docViewTop = $(window).scrollTop()
    var docViewBottom = docViewTop + $(window).height()
    //Dados da section about_us
    var elemTopAbout = $('.about_us_section').offset().top
    var elemBottomAbout = elemTopAbout + $('.about_us_section').height()
    //Dados da section services
    var elemTopServices = $('.services_section').offset().top
    var elemBottomServices = elemTopServices + $('.services_section').height()
    //Dados da section portfolio
    var elemTopPortfolio = $('.portfolio_section').offset().top
    var elemBottomPortfolio = elemTopPortfolio + $('.portfolio_section').height()
    //Dados da section contacts
    var elemTopContacts = $('.contacts_section').offset().top
    var elemBottomContacts = elemTopContacts + $('.contacts_section').height()
    //Dados do home
    var elemTopHome = $('.intro').offset().top
    var elemBottomHome = elemTopHome + $('.intro').height()
    //Se estiver na parte de about_us, remove o que esta selecionado e coloca selecionado no about_us
    if(((elemBottomAbout <= docViewBottom+200) && (elemTopAbout >= docViewTop)) && about_us == false){
        removeActive()
        $('#menu_aboutus').addClass('submenu_activo')
        about_us = true
    }
    //Se estiver na parte de services, remove o que esta selecionado e coloca selecionado no services
    else if(((elemBottomServices <= docViewBottom-270) && (elemTopServices >= docViewTop)) && services == false){
        removeActive()
        $('#menu_services').addClass('submenu_activo')
        services = true
    }
    //Se estiver na parte de portfolio, remove o que esta selecionado e coloca selecionado no portfolio
    else if(((elemBottomPortfolio <= docViewBottom+500) && (elemTopPortfolio >= docViewTop)) && portfolio == false){
        removeActive()
        $('#menu_portfolio').addClass('submenu_activo')
        portfolio = true
    }
    //Se estiver na parte de contacts, remove o que esta selecionado e coloca selecionado no contacts
    else if(((elemBottomContacts <= docViewBottom+500) && (elemTopContacts >= docViewTop)) && contacts == false){
        removeActive()
        $('#menu_contacts').addClass('submenu_activo')
        contacts = true
    }
    //Se estiver na parte do home, remove tudo
    else if(((elemBottomHome <= docViewBottom) && (elemTopHome >= docViewTop-900)) && home == false){
        removeActive()
        home = true
    }
}

//Função para alterar o idioma e dar reload na pagina
$('.language').click(function(){
    if(language == 'pt'){
        $.get("/language.php?idioma=en")
        location.reload()
    }else{
        $.get("/language.php?idioma=pt")
        location.reload()
    }
})

//Abrir mensagens
$('.message-all').click(function(){
    $.get("update-chat.php", function(data){
        duce = jQuery.parseJSON(data)
        if(duce.length > 0){
            var notificacoes = duce[0]
            var novas_mensagens = []
            var contador = 1
            while(contador < duce.length){
                novas_mensagens.push(duce[contador])
                contador++
            }
        }
        if(notificacoes > 0){
            if(chat_aberto){
                while(novas_mensagens.length != 0){
                    if(admin){
                        $('.message-message').append("<div class='container_admin'><p id='message-context-admin' style='margin-top: 2px;'>"+novas_mensagens[0]+"</p></div>")
                    }else{
                        $('.message-message').append("<div class='container_admin'><p style='margin-top: 15px;'></p><p id='message-context-admin'>"+novas_mensagens[0]+"</p></div>")
                        admin = true
                    }
                    novas_mensagens.shift()
                }
                removerNotificacoes()
                $(".message-text").scrollTop($(".message-text")[0].scrollHeight)
            }
        }
    });
    $(this).css('display', 'none')
    $('.message-text').css('display', 'block')
    $('.message-menu').css('display', 'block')
    $('.message-menu-all').css('display', 'block')
    $('#message-context').focus()
    chat_aberto = true
    $(".message-text").scrollTop($(".message-text")[0].scrollHeight)
})

//Função para remover Notificações
function removerNotificacoes(){
    $.get("retirar-notificacoes.php")
    $('#notificacao').css('display', 'none')
    $('#notificacao').html('')
}

//Ao carregar no x fechar mensagens
$('.message-fechar').click(function(){
    fecharMensagens()
})

//Ao carregar 'esc' fechar mensagens
$(document).on('keyup', function(event) {
    if (event.keyCode == 27) {
        fecharMensagens()
    }
})

//Função para fechar mensagens
function fecharMensagens(){
    $('.message-all').css('display', 'block')
    $('.message-text').css('display', 'none')
    $('.message-menu').css('display', 'none')
    $('.message-menu-all').css('display', 'none')
    $('#message-context').val('')
    chat_aberto = false
}

//Enviar mensagem ao carregar na imagem
$('#message-send').click(function(){
  enviarMensagem()  
})

//Enviar mensagem ao clicar 'enter'
$('#message-context').keypress(function (e) { 
    if(e.which == 13) {
        if(!event.shiftKey){
            enviarMensagem()
            return false
        }else{
            return false;
        }
    }
});

//Função para enivar mensagem
function enviarMensagem(){
    var texto = $('#message-context').prop('value')
    if(texto.replace(/\s/g,'').length > 0){
        if(admin){
            $('.message-message').append("<div class='container_guess'><p style='margin-top: 15px;'></p><p id='message-context-guess' class='this-message'></p></div>")
            $('.this-message').text(texto)
            $('.this-message').removeClass()
            admin = false;
        }else{
            $('.message-message').append("<div class='container_guess'><p id='message-context-guess' style='margin-top: 2px;' class='this-message'>/p></div>")
            $('.this-message').text(texto)
            $('.this-message').removeClass()
        }
        $('#message-context').val('')
        $(".message-text").scrollTop($(".message-text")[0].scrollHeight)
        $.get("/enviar-mensagem.php?mensagem="+texto.replace(/&/g,'%26'))
    }
    $('#message-context').focus()
}