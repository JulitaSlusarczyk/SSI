<?php
    session_start();
    if(!isset($_SESSION['register_success']))
    {
        header('Location: index.php');
        exit();
    }
    else
    {
        unset($_SESSION['register_success']);
    }
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Blog o podróżowaniu - Udana rejestracja</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="style.css" />
    <script src='https://www.google.com/recaptcha/api.js'></script>
</head>
<body>
    <?php 
		require_once('../look/title.php');
    ?>

    <?php 
		require_once('../look/menu.php');
	?>

<div id="glowna">
    <div class="post">
    <div style='margin-left:30px;'><h2>Dziękujemy za rejestrację! Zaloguj się na konto!</h2> </div>
    </div>
</div>
<?php
	require_once('../look/sidebar.php');
?>

<?php
	require_once('../look/footer.php');
?>
    
</body>
</html>