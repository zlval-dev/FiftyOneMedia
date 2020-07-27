<?php

    require_once('../database.php');
    require_once('verificar-admin.php');

    /*** Notícias ***/

    //Guardar numa variável uma consulta à Base de Dados
    $consulta = mysqli_query($conn,'SELECT * FROM info where work is null ORDER BY title ASC');
    //Criar um ciclo para guardar na variável $noticias a informação das várias linhas encontradas pela consulta à Base de Dados
    while( $linha = mysqli_fetch_assoc($consulta) ){
        $noticias[] = $linha;
    }



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

        <div class="lista">

            <?php for($i=0;$i<count($noticias);$i++){?>
            <div class="lista-item">
                <div class="lista-titulo">
                    <?php echo $noticias[$i]['title'] . "-" . $noticias[$i]['language']; ?>
                </div>
                <div class="lista-data">
                    <?php echo $noticias[$i]['description']; ?>
                </div>
                <div class="lista-editar">
                    <a href="traducoes-editar.php?id=<?php echo $noticias[$i]['id']; ?>" class="editar">
                    </a>
                </div>

                <div class="clear"></div>
            </div>
            <?php } ?>

        </div>

    </div>
    <!-- Fim do contentor -->

    <!-- Anexar ficheiros javascript -->
    <script type="application/javascript" src="js/jquery.js"></script>
    <script type="application/javascript" src="js/script.js"></script>

</body>
</html>
