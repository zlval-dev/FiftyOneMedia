<?php
    session_start();
    if($_SESSION['admin'])
        header("Location: inserir-artigo.php");
    else{
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
                    FiftyOne Media - Login
                </a>
            </h1>
        </div>
    </header>

    <div class="container">

        <div class="list">

            <form method="post" action="inserir-artigo.php">
                <input type="text" id="admin_username" placeholder="Username" style="text-align: center; margin-bottom: 5px;" />
                <input type="password" id="admin_password" placeholder="Password" style="text-align: center; margin-bottom: 5px;" />
                <input type="submit" name="submit" id="admin_login" value="Login" style="margin-bottom: 0px; background-color: black; color: white; width: 50%; margin-left: 50%; cursor: pointer;" />
            </form>

        </div>



    </div>

    <!-- Ficheiros JS -->
    <script type="application/javascript" src="js/jquery.js"></script>
    <script type="application/javascript" src="js/jquery-ui/jquery-ui.min.js"></script>
    <script type="application/javascript" src="js/script.js"></script>



</body>
</html>
<?php } ?>