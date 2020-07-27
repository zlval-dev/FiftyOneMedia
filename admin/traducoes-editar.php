<?php

    require_once('../database.php');
    require_once('verificar-admin.php');
    
    //Guardar numa variável o parâmetro id do URL
    $id = $_GET['id'];

    //Verificar se existe submissão do formulário
    if(isset($_POST['guardar'])){

        //Guardar em variáveis a informação enviada pelo formulário
        $descricao = $_POST['descricao'];

        //Actualizar a Base de Dados com a informação enviada pelo formulário
        mysqli_query($conn,"UPDATE info SET description='$descricao' WHERE id = '$id'");
        header("Location: traducoes.php");
    }

    //Guardar numa variável uma consulta à Base de Dados
    $consulta = mysqli_query($conn,"SELECT * FROM info WHERE id = '$id'");
    //Guardar numa variável a informação dos registos encontrados pela consulta
    $noticia = mysqli_fetch_assoc($consulta);

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Administração</title>
    <link href="https://fonts.googleapis.com/css?family=Noto+Serif" rel="stylesheet">
    <link type="text/css" rel="stylesheet" href="css/style.css" />
    <link type="text/css" rel="stylesheet" href="css/style-traducoes.css" />
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

    </div>

    <!-- Contentor -->
    <div class="contentor conteudo">

        <h1>Editar - <a style="color: white; font-size: 22px;"><?php echo $noticia['title'].'-'.$noticia['language'] ?></a></h1>

        <form action="" method="post" style="margin-top: 40px;">

            <label><a>Descrição</a>
                <textarea name="descricao" class="input-texto caixa-texto" style="margin-top:15px;border-radius:15px;resize:none;outline:none;"><?php echo $noticia['description']; ?></textarea>
            </label>

            <div>
                <input type="submit" value="Guardar" name="guardar" class="botao-submit" style="outline:none;"/>
            </div>

        </form>

    </div>
    <!-- Fim do contentor -->

    <!-- Anexar ficheiros javascript -->
    <script type="application/javascript" src="js/jquery.js"></script>
    <script type="application/javascript" src="js/jquery-ui/jquery-ui.min.js"></script>
    <script type="application/javascript" src="js/script.js"></script>

</body>
</html>
