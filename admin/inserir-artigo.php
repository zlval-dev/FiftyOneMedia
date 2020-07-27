<?php

    session_start();
    if(isset($_POST['submit'])){
        $_SESSION['admin'] = true;
    }

    require_once('../database.php');
    require_once('verificar-admin.php');
    
    if(isset($_POST['inserir'])){
        $title = $_POST['titulo'];
        $html_alt = $_POST['html_alt'];
        $html_id = $_POST['html_id'];
        $descricao_pt = $_POST['descricao_pt'];
        $descricao_en = $_POST['descricao_en'];
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
            if($title != null && $html_alt != null && $html_id != null && $descricao_pt != null && $descricao_en != null){
                if(!$erro){
                    if(!($work && $miniwork)){
                        echo "<input type='hidden' class='images-error'>";
                    }else{
                        $ext_work  = pathinfo($_FILES['image-work']['name'], PATHINFO_EXTENSION);
                        $ext_miniwork  = pathinfo($_FILES['image-miniwork']['name'], PATHINFO_EXTENSION);
                        if($ext_work == $ext_miniwork){
                            $query_get_number = "select * from works";
                            $result_get_number = mysqli_query($conn, $query_get_number);
                            $number = mysqli_num_rows($result_get_number)+1;
                            move_uploaded_file($_FILES['image-work']['tmp_name'], '../imagens/works/home-project'.$number.'.'.$ext_work);
                            move_uploaded_file($_FILES['image-miniwork']['tmp_name'], '../imagens/miniworks/home-project'.$number.'.'.$ext_work);
                            $query_ins_database = "insert into works (html_id, imagem, alt, title) values ('$html_id', 'home-project".$number.".".$ext_work."', '$html_alt', '$title')";
                            $query_ins_description_pt = "insert into info (title, description, language, work) values ('img_description', '$descricao_pt', 'pt', '$number')";
                            $query_ins_description_en = "insert into info (title, description, language, work) values ('img_description', '$descricao_en', 'en', '$number')";
                            mysqli_query($conn, $query_ins_database);
                            mysqli_query($conn, $query_ins_description_pt);
                            mysqli_query($conn, $query_ins_description_en);
                            header('Location: index.php ');
                        }else{
                            echo "<input type='hidden' class='extension-error'>";
                        }
                    }
                }
            }else{
                echo "<input type='hidden' class='all-error'>";
            }
        }
    }

    /***
        Apagar registo
    ***/
    //Verificar se existe o parametro delete_id no URL
    if(isset($_GET['delete_id'])){
        //Guardar o valor do parâmetro delete_id
        $delete_id = $_GET['delete_id'];
        //Apagar o registo da base de dados
        mysqli_query($conn,"update works set deleted=true, `show`=false where id=$delete_id");
        header('Location: index.php');
    }if(isset($_GET['recover_id'])){
        //Guardar o valor do parâmetro delete_id
        $recover_id = $_GET['recover_id'];
        //Apagar o registo da base de dados
        mysqli_query($conn,"update works set deleted=false where id=$recover_id");
        header('Location: index.php');
    }


    /***
        Obter da base de dados todos os registos da tabela artigos
    ***/

    //Fazer consulta à base de dados
    $consulta = mysqli_query($conn , "SELECT * FROM works ORDER BY id");
    //Array que irá guardar a informação da base de dados
    $works = array();
    $show = 0;
    //Guardar dento da variável $eventos todos os registos devolvidos pela consulta
    while($linha = mysqli_fetch_assoc($consulta)){
        $works[] = $linha;
        if($linha['show']){
            $show++;
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
        <a><h2 id="menu" style="float:right;cursor:default;"><?php if($show < 4){echo "<a style='color:green;' class='show-number' id='".$show."'>".$show."</a>";}else{echo "<a style='color:red'; class='show-number' id='".$show."'>".$show."</a>";} ?>/4</h2></a>

        <div class="list">

            <?php for($i=0;$i<count($works);$i++){ ?>
                <div class="list-item" <?php if($works[$i]['deleted']){echo "id='list-recover'";} ?>>
                    <div class="list-title">
                        <a href="editar_section.php?id=<?php echo $works[$i]['id']; ?>" class="edit-button">
                            <?php echo $works[$i]['title']; ?>
                        </a>
                    </div>
                    <?php
                        if($works[$i]['deleted']){
                            echo "<div>
                                    <a href='index.php?recover_id=".$works[$i]['id']."' class='recover-link'></a>
                                </div>";
                        }else{
                            echo "<div class='list-delete'>
                                    <a href='index.php?delete_id=".$works[$i]['id']."' class='delete-link'></a>
                                    <a id='".$works[$i]['id']."' ";
                                    if($works[$i]['show']){echo "class='show'";}else{echo "class='unshow'";} echo " style='cursor:pointer;'></a>
                                </div>";
                        }
                    ?>
                    <div class="clear"></div>
                </div>
            <?php } ?>

        </div>

        <div class="item-insert">

            <h2 id="insert-button">Inserir artigo</h2>

        <form enctype="multipart/form-data" action="" method="post" style="margin-top:40px;" id="insert-form">

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
                <img id="img-work" accept="image/*"/>
                <input type="file" name="image-work" id="work"/>
            </label>

            <label><p>Imagem (MiniWork) - 1500x425 px</p>
                <img id="img-miniwork" accept="image/*"/>
                <input type="file" name="image-miniwork" id="miniwork"/>
            </label>

            <input type="submit" value="Inserir" name='inserir' style="border-radius:15px; background-color:black;" class="submit-button"/>

        </form>


        </div>



    </div>

    <!-- Ficheiros JS -->
    <script type="application/javascript" src="js/jquery.js"></script>
    <script type="application/javascript" src="js/jquery-ui/jquery-ui.min.js"></script>
    <script type="application/javascript" src="js/script.js"></script>



</body>
</html>
