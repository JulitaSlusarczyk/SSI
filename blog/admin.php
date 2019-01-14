<?php
    session_start();
    if(!isset($_SESSION['uss']) || $_SESSION['rola']!="admin")
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
    <title>Blog o podróżowaniu - panel admina</title>
    <link rel="stylesheet" type="text/css" href="style.css" />
</head>
<body>
    <?php 
		require_once('/var/www/vhosts/letthejourneybegin.5v.pl/httpdocs/look/title.php');
	?>

	<?php 
		require_once('/var/www/vhosts/letthejourneybegin.5v.pl/httpdocs/look/menu.php');
    ?>

<div id="glowna">
    <div class='post'>
        <div id='menu'>
            <div class='MenuOptionAdmin'>opcja 1</div> <!-- nie działają style tych emu -->
            <div class='MenuOptionAdmin'>opcja 2</div>
            <div class='MenuOptionAdmin'>opcja 3</div>
            <div style='clear:both;'></div>
        </div>
    </div>
</div>
    <?php
		require_once('/var/www/vhosts/letthejourneybegin.5v.pl/httpdocs/look/sidebar.php');
    ?>
    <?php
	    require_once('/var/www/vhosts/letthejourneybegin.5v.pl/httpdocs/look/footer.php');
    ?>
</body>
</html>