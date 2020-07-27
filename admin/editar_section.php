<?php

    require_once('../database.php');
    require_once('verificar-admin.php');

    //Guardar numa variável o parametro id do URL
    $id = $_GET['id'];

    //Fazer consulta à base de dados
    $consulta = mysqli_query($conn , "SELECT * FROM works WHERE id = $id");
    //Guardar numa variável o registo encontrado pela consulta
    $section = mysqli_fetch_assoc($consulta);
    $query = mysqli_query($conn, "select * from info where work=$id");
    while($linha = mysqli_fetch_assoc($query)){
        $descricoes[] = $linha;
    }

    //Ao carregar guardar
    if(isset($_POST['guardar'])){
        $title = $_POST['titulo'];
        $html_alt = $_POST['html_alt'];
        $html_id = $_POST['html_id'];
        $descricao_pt = $_POST['descricao_pt'];
        $descricao_en = $_POST['descricao_en'];
        $query = "update works set title='$title', alt='$html_alt', html_id='$html_id' where id=$id";
        $query_descricao_pt = "update info set description='$descricao_pt' where language='pt' and work=$id";
        $query_descricao_en = "update info set description='$descricao_en' where language='en' and work=$id";
        $erro = false;
        $work = false;
        $miniwork = false;
        $htmlid = false;
        $query_verifica_htmlid = "select * from works where html_id='$html_id' and id!=$id";
        $result_verifica_htmlid = mysqli_query($conn, $query_verifica_htmlid);
        if(mysqli_num_rows($result_verifica_htmlid) > 0){
            echo "<input type='hidden' class='htmlid-error'>";
            $htmlid = true;
        }else{
            if($_FILES["image-work"]["size"] > 0){
                $image_info = getimagesize($_FILES["image-work"]['tmp_name']);
                if($image_info[0] == '400' && $image_info[1] == '300'){
                    $work = true;
                }else{
                    echo "<input type='hidden' class='work-size-error'>";
                    $erro = true;
                }
            }if($_FILES["image-miniwork"]["size"] > 0){
                $image_info = getimagesize($_FILES["image-miniwork"]['tmp_name']);
                if($image_info[0] == '1500' && $image_info[1] == '425'){
                    $entrou = true;
                    $miniwork = true;
                }else{
                    echo "<input type='hidden' class='miniwork-size-error'>";
                    $erro = true;
                }
            }
        }if(!$htmlid){
            if(!$erro){
                if($work){
                    unlink('../imagens/works/'.$section['imagem']);
                    move_uploaded_file($_FILES['image-work']['tmp_name'], '../imagens/works/'.$section['imagem']);
                }if($miniwork){
                    unlink('../imagens/miniworks/'.$section['imagem']);
                    move_uploaded_file($_FILES['image-miniwork']['tmp_name'], '../imagens/miniworks/'.$section['imagem']);
                }
                mysqli_query($conn, $query);
                mysqli_query($conn, $query_descricao_en);
                mysqli_query($conn, $query_descricao_pt);
                header('Location: index.php ');
            }
        }
    }else{
        $title = $section['title'];
        $html_alt = $section['alt'];
        $html_id = $section['html_id'];
        if($descricoes[0]['language'] == 'en'){
            $descricao_en = $descricoes[0]['description'];
        }else{
            $descricao_en = $descricoes[1]['description'];
        }if($descricoes[0]['language'] == 'pt'){
            $descricao_pt = $descricoes[0]['description'];
        }else{
            $descricao_pt = $descricoes[1]['description'];
        }
    }

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Administração</title>
    <link type="text/css" rel="stylesheet" href="css/style.css" />
    <link type="text/css" rel="stylesheet" href="js/jquery-ui/jquery-ui.min.css" />
    <link rel="shortcut icon" href="img/fom.png" />
</head>
<body>

<div id="overlay">
        <div id="overlay-content"></div>
    </div>

    <header class="main-header">
        <div class="container">
            <h1>
                <a href="..">
                    FiftyOne Media - Gestor de conteúdos
                </a>
            </h1>
        </div>
    </header>

    <div class="container">

        <a href="index.php"><h2  id="menu">Trabalhos</h2></a>
        <a href="traducoes.php"><h2 id="menu">Traduções</h2></a>
        <a href="mensagens.php"><h2 id="menu">Mensagens</h2></a>
        <a href="desbugar-chat.php" target="_blank" style="float: right;"><h2 id="menu">Desbugar Chat</h2></a>

        <form enctype="multipart/form-data" action="" method="post" style="margin-top:40px;">

            <label>Título
                <input type="text" style="border-radius:15px; margin-top: 5px;" name="titulo" value="<?php echo $title; ?>"/>
            </label>

            <label>HTML - ALT
                <input type="text" style="border-radius:15px; margin-top: 5px;" name="html_alt" value="<?php echo $html_alt; ?>"/>
            </label>

            <label>HTML - ID
                <input type="text" style="border-radius:15px; margin-top: 5px;" name="html_id" value="<?php echo $html_id; ?>"/>
            </label>

            <label>Descrição em Português
                <textarea name="descricao_pt" style="resize:none;border-radius:15px; margin-top: 5px;" class="editor"><?php echo $descricao_pt; ?></textarea>
            </label>

            <label>Descrição em Inglês
                <textarea name="descricao_en" style="resize:none;border-radius:15px; margin-top: 5px;" class="editor"><?php echo $descricao_en; ?></textarea>
            </label>

            <label><p>Imagem (Work) - 400x300 px</p>
                <img src="../imagens/works/<?php echo $section['imagem']; ?>" id="img-work" accept="image/*"/>
                <input type="file" name="image-work" id="work"/>
            </label>

            <label><p>Imagem (MiniWork) - 1500x425 px</p>
                <img src="../imagens/miniworks/<?php echo $section['imagem']; ?>" id="img-miniwork" accept="image/*"/>
                <input type="file" name="image-miniwork" id="miniwork"/>
            </label>

            <input type="submit" value="Guardar" name='guardar' style="border-radius:15px; background-color:black;" class="submit-button"/>

        </form>

    </div>

    <!-- Anexar ficheiros javascript -->
    <script type="application/javascript" src="js/jquery.js"></script>
    <script type="application/javascript" src="js/jquery-ui/jquery-ui.min.js"></script>
    <script type="application/javascript" src="js/script.js"></script>

</body>
</html>
