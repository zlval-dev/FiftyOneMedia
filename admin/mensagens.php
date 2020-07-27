<?php

    require_once('../database.php');
    require_once('verificar-admin.php');

    /***
        Obter da base de dados todos os registos da tabela artigos
    ***/

    //Fazer consulta à base de dados
    $consulta = mysqli_query($conn , "select * from mensagens where admin=false and visto=false group by user order by data asc");
    //Array que irá guardar a informação da base de dados
    $works = array();
    //Guardar dento da variável $eventos todos os registos devolvidos pela consulta
    while($linha = mysqli_fetch_assoc($consulta)){
        $works[] = $linha;
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

        <div class="list">
            <?php 
            
            if(sizeof($works) == 0){ echo "<div class='list-item'>
                <div class='list-title'>
                    <a class='edit-button'>
                        Não tens mensagens
                    </a>
                </div>
                <div class='clear'></div>
            </div>"; }
            
            for($i=0;$i<count($works);$i++){ ?>
                <div class="list-item">
                    <div class="list-title">
                        <a href="?user=<?php echo $works[$i]['user'] ?>" class="edit-button">
                            <?php echo "Uitlizador".($i+1); ?>
                        </a>
                    </div>
                    <div class="clear"></div>
                </div>
            <?php } ?>
        </div>

        <?php if(isset($_GET['user'])){ ?>

		<div class="message-menu-all">
			<div class="message-menu">
				<img class="message-fechar" alt="close" src="../imagens/message-fechar.png">
			</div>
		</div>
		<div class="message-text">
			<div class="message-message" >

			<?php
                //Obter as mensagens do utilizador
                $user = $_GET['user'];
				$query_get_messages = "select * from mensagens where user='$user' order by data asc";
				$result_get_messages = mysqli_query($conn, $query_get_messages);
				$primeira = true;
				if(mysqli_num_rows($result_get_messages) == 0){
					$admin = true;
				}
				while($assoc_get_messages = mysqli_fetch_assoc($result_get_messages)){
					if($primeira){
						if($assoc_get_messages['admin']){
							$admin = true;
							echo "<div class='container_admin'>
									<p style='margin-top: 15px;'></p>
									<p id='message-context-admin'>".htmlspecialchars($assoc_get_messages['mensagem'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8')."</p>
								</div>";
						}else{
							$admin = false;
							echo "<div class='container_guess'>
									<p style='margin-top: 15px;'></p>
									<p id='message-context-guess'>".htmlspecialchars($assoc_get_messages['mensagem'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8')."</p>
								</div>";
						}
						$primeira = false;
					}else{
						if($assoc_get_messages['admin']){
							if($admin){
								echo "<div class='container_admin'>
										<p id='message-context-admin' style='margin-top: 2px;'>".htmlspecialchars($assoc_get_messages['mensagem'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8')."</p>
									</div>";
							}else{
								echo "<div class='container_admin'>
										<p style='margin-top: 15px;'></p>
										<p id='message-context-admin'>".htmlspecialchars($assoc_get_messages['mensagem'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8')."</p>
									</div>";
								$admin = true;
							}
						}else{
							if($admin){
								echo "<div class='container_guess'>
										<p style='margin-top: 15px;'></p>
										<p id='message-context-guess'>".htmlspecialchars($assoc_get_messages['mensagem'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8')."</p>
									</div>";
								$admin = false;
							}else{
								echo "<div class='container_guess' style='margin-top: 2px;'>
										<p id='message-context-guess'>".htmlspecialchars($assoc_get_messages['mensagem'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8')."</p>
									</div>";
							}
						}
					}
                }
                echo "<input type='hidden' value='".$user."' id='utilizador'><p style='padding-top:10px;'></p>";
			?>

			</div>
			<div class="message-write">
				<textarea maxlength="4000000000" rows="3" id="message-context" <?php echo "placeholder='Responde aqui...'"; ?> ></textarea>
			</div>
		</div>

        <?php } ?>

    </div>

    <!-- Ficheiros JS -->
    <script type="application/javascript" src="js/jquery.js"></script>
    <script type="application/javascript" src="js/jquery-ui/jquery-ui.min.js"></script>
    <script type="application/javascript" src="js/script.js"></script>
    <script type="application/javascript" src="js/administracao.js"></script>           

</body>
</html>
