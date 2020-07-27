<?php
	session_start();
	require_once('database.php');
	//Obter o IP
	if (isset($_SERVER['HTTP_CLIENT_IP']))
		$ipaddress = $_SERVER['HTTP_CLIENT_IP'];
	else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
		$ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
	else if(isset($_SERVER['HTTP_X_FORWARDED']))
		$ipaddress = $_SERVER['HTTP_X_FORWARDED'];
	else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
		$ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
	else if(isset($_SERVER['HTTP_FORWARDED']))
		$ipaddress = $_SERVER['HTTP_FORWARDED'];
	else if(isset($_SERVER['REMOTE_ADDR']))
		$ipaddress = $_SERVER['REMOTE_ADDR'];
	$ipaddress = md5($ipaddress);
	$_SESSION['user'] = $ipaddress;
	if(!isset($_SESSION['language'])){
		$query_get_language = "select * from chat_users where ip='$ipaddress'";
		$result_get_language = mysqli_query($conn, $query_get_language);
		if(mysqli_num_rows($result_get_language) > 0){
			$assoc_get_language = mysqli_fetch_assoc($result_get_language);
			$_SESSION['language'] = $assoc_get_language['language'];
		}else{
			$_SESSION['language'] = 'en';
			mysqli_query($conn, "insert into chat_users (ip) values ('$ipaddress')");
		}
	}
	require_once('strings.php');
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="initial-scale=1.0, width=device-width"/>
<title>FiftyOne Media</title>
<link rel="shortcut icon" href="imagens/Logo-51M-GIF-escuro.gif" />
<link rel="stylesheet" href="css/geral.css">
<link href="https://fonts.googleapis.com/css?family=Roboto:300,400,700,900" rel="stylesheet">
</head>

<body>
	<!--TOP MENU-->
	<div class="top_menu clearfix">
		<div class="logo_image left" id="removeMenu">
			<a href="#top_home">
				<figure>
					<img class="logo_gif" alt="FiftyOne Media" src="imagens/Logo-51M-GIF-escuro.gif">
				</figure>
			</a>
		</div>

		<!--Main menu-->
		<nav class="menu clearfix">
			<a href="#top_about_us" class="link_menu" id="menu_aboutus"><?php echo $lang['menu_aboutus'] ?></a>
			<a href="#top_services" class="link_menu" id="menu_services"><?php echo $lang['menu_services'] ?></a>
			<a href="#top_portfolio" class="link_menu" id="menu_portfolio"><?php echo $lang['menu_portfolio'] ?></a>
			<a href="#top_contactos" class="link_menu" id="menu_contacts"><?php echo $lang['menu_contacts'] ?></a>
		</nav>
		<!--End main menu-->
		
		<div class="right_image_top right" id="removeMenu">
			<a href="#top_home" class="home">
				<figure>
					<img class="home_image" alt="FiftyOne Media" src="imagens/Nome-RGB.png">
				</figure>
			</a>
		</div>
	</div>
	<!--END TOP MENU-->
	<div class="page" id="page_home">

		<figure>
			<img class="language" alt="language" <?php if($_SESSION['language'] == 'pt'){echo "src='imagens/language/pt.png'";}else{ echo "src='imagens/language/en.png'";} ?>>
		</figure>

		<!-- Começo do Live Chat -->
		<figure class="message-all">
			<img class="message" alt="language" src="imagens/messages-icon.png">
			<?php
				//Obter numero de notificacoes
				$query_get_user = "select * from chat_users where ip='$ipaddress'";
				$result_get_user = mysqli_query($conn, $query_get_user);
				$assoc_get_user = mysqli_fetch_assoc($result_get_user);
				$user = $assoc_get_user['id'];
				$query_get_notificacoes = "select * from mensagens where user='$user' and visto=false and admin=true";
				$result_get_notificacoes = mysqli_query($conn, $query_get_notificacoes);
				if(mysqli_num_rows($result_get_notificacoes) > 0){
					echo "<span id='notificacao'>".mysqli_num_rows($result_get_notificacoes)."</span>";
				}else{
					echo "<span id='notificacao' style='display: none;'>".mysqli_num_rows($result_get_notificacoes)."</span>";
				}
			?>
		</figure>
		<div class="message-menu-all">
			<img id="message-status" alt="status" src="imagens/offline.png">
			<div class="message-menu">
				<a class="last-online"></a>
				<img class="message-fechar" alt="close" src="imagens/message-fechar.png">
			</div>
		</div>
		<div class="message-text">
			<div class="message-message" >

			<?php
				//Obter as mensagens do utilizador
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
				echo "<input type='hidden' value='".$admin."' id='utilizador'>";
			?>

			</div>
			<div class="message-write">
				<textarea maxlength="4000000000" rows="3" id="message-context" <?php echo "placeholder='".$lang['textarea_placeholder']."'"; ?> ></textarea>
				<img alt="send" src="imagens/send.png" id="message-send">
			</div>
		</div>
		<!-- Fim do Live Chat -->


		<!--background image welcome-->
		<div class="welcome_section flex_container"  id="top_home">
			<h1 class="intro">
				<?php echo $lang['welcome'] ?>
			</h1>
		</div>
		<!--End background image welcome-->

		<!--Section Some works-->
		<div class="works_sections">
			<header class="works_section_title">
				<h1><?php echo $lang['works_section_title'] ?></h1>
			</header>

			<?php
				$query = "select * from works where deleted=false and `show`=true order by id asc";
				$result = mysqli_query($conn, $query);
				while($assoc = mysqli_fetch_assoc($result)){
					echo "<a href='#".$assoc['html_id']."'>
							<div class='works_section_item'>
								<figure>
									<img class='works_img' alt='".$assoc['alt']."' src='imagens/works/".$assoc['imagem']."'>
								</figure>
								<p class='works_txt'>
									".$assoc['title']."
								</p>
							</div>
						</a>";
				}
			?>

		</div>

		<div class="home_wallpaper_small">.</div>
	</div>
	
	<div class="page" id="page_about_us">
		<!--Sobre nós Head-->
		<div class="about_us_wallpaper flex_container" id="top_about_us">
				<h1 class="page_title" id="page_title_about">
					<?php echo $lang['menu_aboutus'] ?>
				</h1>
		</div>
		<!--END Sobre nós Head-->



		<div class="about_us_wallpaper_medium">
			<!--Submenu-->
		<nav class="submenu_about_us flex_container">
			<a class="link_submenu"><?php echo $lang['missao'] ?></a>
			<a class="link_submenu"><?php echo $lang['visao'] ?></a>
			<a class="link_submenu"><?php echo $lang['valores'] ?></a>
		</nav>
		<!--End Submenu-->
		</div>

		<section>
			<div class="about_us_section about_us_wallpaper_sides">
				<article class="article" id="missao">
					<header>
						<h1 class="article_title flex_container"><?php echo $lang['missao'] ?></h1>
					</header>
					<p class="article_txt"><?php echo $lang['desc_missao'] ?></p>

				</article>
			</div>

			<div class="about_us_section about_us_wallpaper_sides">
				<article class="article" id="visao">
					<header>
						<h1 class="article_title flex_container"><?php echo $lang['visao'] ?></h1>
					</header>
					<p class="article_txt"><?php echo $lang['desc_visao'] ?></p>

				</article>
			</div>

			<div class="about_us_section about_us_wallpaper_sides">
				<article class="article" id="valores">
					<header>
						<h1 class="article_title flex_container"><?php echo $lang['valores'] ?></h1>
					</header>
					<p class="article_txt"><?php echo $lang['desc_valores'] ?></p>

				</article>
			</div>
		</section>

		<div class="about_us_wallpaper"></div>
	</div>
	
	<div class="page" id="page_services">
		<!--Services Head-->
		<div class="services_wallpaper flex_container"  id="top_services">
			<div class="title_service flex_container">
				<h1 class="page_title">
					<?php echo $lang['menu_services'] ?>
				</h1>
			</div>
		<!--END Services Head-->
		<div class="menu_service flex_container">
		<nav class="submenu_services flex_container">
			<a class="link_submenu_services"><?php echo $lang['design_grafico'] ?></a>
			<a class="link_submenu_services"><?php echo $lang['webdesign'] ?></a>
			<a class="link_submenu_services"><?php echo $lang['animacoes'] ?></a>
		</nav>
		
		</div>
		</div>
		<!--services content-->
		<div class="services_wallpaper_medium">
			<section class="services_section flex_container">
				<article class="article_services" id="service_design">
					<figure class="icon_services flex_container">
						<img src="imagens/icon_Design.png" alt="Design Gráfico">
					</figure>
					<header>
						<h1><?php echo $lang['design_grafico'] ?></h1>
					</header>
					<p>
						<?php echo $lang['desc_design_grafico'] ?>
					</p>
				</article>

				<article class="article_services" id="service_webdesign">
					<figure class="icon_services flex_container">
						<img src="imagens/icon_webdesign.png" alt="Webdesign">
					</figure>
					<header>
						<h1><?php echo $lang['webdesign'] ?></h1>
					</header>
					<p>
						<?php echo $lang['desc_webdesign'] ?>
					</p>
				</article>

				<article class="article_services">
					<figure class="icon_services flex_container" id="service_animation">
						<img src="imagens/icon_animation.png" alt="Animações">
					</figure>
					<header>
						<h1><?php echo $lang['animacoes'] ?></h1>
					</header>
					<p>
						<?php echo $lang['desc_animacoes'] ?>
					</p>
				</article>
			</section>
		</div>
	</div>
	
	<div class="page portfolio_wallpaper" id="top_portfolio">
		<!--Portfolio head-->
		<header class="flex_container header_portfolio">
				<h1 class="page_title">
					<?php echo $lang['menu_portfolio'] ?>
				</h1>
		</header>
		<!--end Portfolio head-->

		<!--Section Some works-->

		<!--Portfolio content-->
		<section class="portfolio_section flex_container">

			<?php
				$query = "select * from works where deleted=false order by id asc";
				$result = mysqli_query($conn, $query);
				while($assoc = mysqli_fetch_assoc($result)){
					$query_descricao = "select * from info where language='".$_SESSION['language']."' and work=".$assoc['id'];
					$result_descricao = mysqli_query($conn, $query_descricao);
					$assoc_descricao = mysqli_fetch_assoc($result_descricao);
					echo "<article class='article_portfolio' id='".$assoc['html_id']."'>
							<div class='info_portfolio flex_container'>
								<header>
								<h1>".$assoc['title']."</h1>
								</header>
								<figure class='portfolio_img'>
								<img src='imagens/miniworks/".$assoc['imagem']."' alt='".$assoc['alt']."'>
								</figure>
								<p>".$assoc_descricao['description']."</p>
							</div>
						</article>";
				}
			?>

		</section>
		<div id="janela-noticia">
                <img src="imagens/fechar.png" id="janela-fechar" alt="Fechar"/>
                <div id="janela-conteudo">
                    Conteúdo de teste
                </div>
         </div>
		<div class="portfolio_wallpaper_small"></div>
		<!--end Portfolio content-->
	</div>
	<div class="page" id="page_contacts">
		<header class="contactos_wallpaper flex_container"  id="top_contactos">
			<h1 class="page_title">
				<?php echo $lang['menu_contacts'] ?>
			</h1>
		</header>

			<section class="contacts_section flex_container contactos_wallpaper_sides">
				<div class="social_media_contacts">
					<a href="https://www.facebook.com/fiftyonemedia/" target="_blank">
						<figure class="social_media_img_contacts" >
							<img src="imagens/icone_facebook.png" alt="Facebook">
						</figure>
					</a>
					<a href="https://www.instagram.com/fiftyonemedia/" target="_blank">
						<figure class="social_media_img_contacts" >
							<img src="imagens/icone_instagram.png" alt="Instagram">
						</figure>
					</a>
					<a href="https://www.behance.net/fifty1medica51" target="_blank">
						<figure class="social_media_img_contacts" >
							<img src="imagens/Icones-behance.png" alt="Behance">
						</figure>
					</a>
					<a href="https://twitter.com/fifty1media" target="_blank">
						<figure class="social_media_img_contacts" >
							<img src="imagens/Icones-twitter.png" alt="Twitter">
						</figure>
					</a>

				</div>

				<div class="contacts">
						<h1>FiftyOne Media</h1>
					<div class="contacts_item">	
							<div class="contacts_item_tittle">
								<h2>Email</h2>
							</div>
						<a href="mailto:fifty1media@gmail.com">
							<div class="contacts_info flex_container">
								<figure class="contacts_img">
									<img src="imagens/Icones-mail.png" alt="Email">
								</figure>
								<p>fifty1media@gmail.com</p>
							</div>
						</a>
					</div>
					<div class="contacts_item">
						<div class="contacts_item_tittle">
							<h2><?php echo $lang['telephone'] ?></h2>
						</div>
						<div class="contacts_info flex_container">
							<figure class="contacts_img">
								<img src="imagens/Icones-phone.png" alt= "Telefone">
							</figure>
							<a class="call_link" href="tel:+351999999999"><p>+351 999 999 999 (Ligue já)</p></a>
						</div>
					</div>

				</div>
			</section>
	</div>
	<!--FOOTER-->
	<footer>
		<div class="footer1 left">
			<div class="logo_footer_space"> 
				<figure>
					<img class="logo_footer" alt="FiftyOne Media" src="imagens/Fom-Logo-Final-Preto-Cmyk+nome.png">
				</figure>
			</div>
			<div class="apresentation_footer">
				<p class="txt_footer">
					<?php echo $lang['txt_footer'] ?>
				</p>
			</div>
		</div>
		
		<div class="social_media right">
			<a href="https://www.facebook.com/fiftyonemedia/" target="_blank">
				<figure class="social_media_img" >	
					<img src="imagens/icone_facebook.png" alt="Facebook">
				</figure>
			</a>
			<a href="mailto:fifty1media@gmail.com">
				<figure class="social_media_img" >	
					<img src="imagens/Icones-mail.png" alt="Email">
				</figure>
			</a>
			<a href="https://www.instagram.com/fiftyonemedia/" target="_blank">
				<figure class="social_media_img" >
					<img src="imagens/icone_instagram.png" alt="Instagram">
				</figure>
			</a>
			<a href="https://www.behance.net/fifty1medica51" target="_blank">
				<figure class="social_media_img" >
					<img src="imagens/Icones-behance.png" alt="Behance">
				</figure>
			</a>
			<a href="https://twitter.com/fifty1media" target="_blank">
				<figure class="social_media_img" >
					<img src="imagens/Icones-twitter.png" alt="Twitter">
				</figure>
			</a>
			
		</div>
		<div class="rights_quote right">
			<p><?php echo $lang['rights_quote'] ?></p>
		</div>
		<div class="button_backtotop">
			<a href="#top_home">
				<figure class="backtotop_icon">
					<img src="imagens/Icones-backtoptop.png" alt="Voltar para o topo">
				</figure>
			</a>
		</div>
	</footer>
	<!--END FOOTER-->
	
	<!-- Anexar ficheiros javascript -->
    <script type="application/javascript" src="js/jquery.js"></script>
    <script type="application/javascript" src="js/script.js"></script>
	
</body>
</html>
