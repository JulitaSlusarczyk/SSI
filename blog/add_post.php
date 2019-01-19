<?php
    session_start();
    if($_SESSION['rola']=="admin" || $_SESSION['rola']=="moderator")
    {

    }
    else
    {
        header('Location: index.php');
        exit();
    }
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Blog o podróżowaniu - Dodaj post</title>
    <link rel="stylesheet" type="text/css" href="style.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/ckeditor/4.8.0/ckeditor.js"></script>
</head>
<body>
    <?php 
		require_once('/var/www/vhosts/letthejourneybegin.5v.pl/httpdocs/look/title.php');
    ?>

    <?php 
		require_once('/var/www/vhosts/letthejourneybegin.5v.pl/httpdocs/look/menu.php');
    ?>
<div id="glowna">
    <div class="post">
        <form method='post'>
            <textarea id='textar'></textarea>
            <br/>
            <button type='submit' id='buttonsubmit'>Dodaj post</button>
        </form>
    </div>
</div>
    <?php
	    require_once('/var/www/vhosts/letthejourneybegin.5v.pl/httpdocs/look/sidebar.php');
    ?>

    <?php
	    require_once('/var/www/vhosts/letthejourneybegin.5v.pl/httpdocs/look/footer.php');
    ?>

<script>
	CKEDITOR.replace('textar');
</script>
</body>
</html>