
    //datepicker
    $('.datepicker').datepicker({'dateFormat':'yy-m-d'});


    //Insert event button
    $('#insert-button').click(function(){
        $('#insert-form').toggle();
    });

    //Click nos botões de delete
    $('.delete-link').click(function(e){
        var resposta = confirm('Deseja apagar este artigo?');
        if( !resposta ){
            e.preventDefault();
        }
    });

$(document).ready(function() {
    if($(".htmlid-error").length){
        alert('Este HTML ID já existe, utilize outro')
        if($('#insert-button').length)
            $('#insert-form').toggle();
    }else if($(".all-error").length){
        alert('É preciso preencher tudo')
        if($('#insert-button').length)
            $('#insert-form').toggle();
    }else if($(".miniwork-size-error").length && $(".work-size-error").length){
        alert('As duas imagens inseridas não têm o tamanho pedido')
        if($('#insert-button').length)
            $('#insert-form').toggle();
    }else if($(".miniwork-size-error").length){
        alert('A imagem inserida no \'MiniWork\' não tem o tamanho pedido de 1500x425')
        if($('#insert-button').length)
            $('#insert-form').toggle();
    }else if($(".work-size-error").length){
        alert('A imagem inserida no \'Work\' não tem o tamanho pedido de 400x300')
        if($('#insert-button').length)
            $('#insert-form').toggle();
    }else if($(".images-error").length){
        alert('Precisas de inserir as duas fotos para poderes inserir um novo trabalho')
        if($('#insert-button').length)
            $('#insert-form').toggle();
    }else if($(".extension-error").length){
        alert('As fotos têm de ter a mesma extensão')
        if($('#insert-button').length)
            $('#insert-form').toggle();
    }

    $("#miniwork").change(function () {
        if (this.files && this.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#img-miniwork').attr('src', e.target.result);
            }
            reader.readAsDataURL(this.files[0]);
        }
    });

    $("#work").change(function () {
        if (this.files && this.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#img-work').attr('src', e.target.result);
            }
            reader.readAsDataURL(this.files[0]);
        }
    });
})

$('.show').click(function(){
    var id = $(this).prop('id')
    $.get("show.php?id="+id)
    location.reload();
})

$('.unshow').click(function(){
    if($('.show-number').prop('id') == 4){
        alert('Para poderes colocar este trabalho em destaque tens de remover um dos que estão ativo, pois só podem estar 4')
    }else{
        var id = $(this).prop('id')
        $.get("show.php?show=true&id="+id)
        location.reload()
    }
})

$('#admin_login').click(()=>{
    var username = document.getElementById('admin_username').value
    var password = document.getElementById('admin_password').value
    if(username == "fiftyonemedia" && password == "portfoliomedia")
        return true
    else{
        alert('Dados incorretos!')
        return false
    }
})