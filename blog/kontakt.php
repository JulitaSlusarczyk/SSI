<?php
    session_start();
    if(isset($_POST['send']))
    {
        if(isset($_SESSION['uss']))
        {
            $message=$_SESSION['email']." ".$_POST['form_textarea'];
            mail("julietta816@o2.pl","Formularz kontaktowy",$message);
            $_SESSION['wyslano']="Wiadomość została wysłana!";
        }
        else
        {
            $message=$_POST['unknown_email']." ".$_POST['form_textarea'];
            mail("julietta816@o2.pl","Formularz kontaktowy",$message);
            $_SESSION['wyslano']="Wiadomość została wysłana!";
        }
    }
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Blog o podróżowaniu - Formularz kontaktowy</title>
    <link rel="stylesheet" type="text/css" href="style.css" />
    <script src="main.js"></script>
</head>
<body>
    <?php 
		require_once('/var/www/vhosts/letthejourneybegin.5v.pl/httpdocs/look/title.php');
	?>

	<?php 
		require_once('/var/www/vhosts/letthejourneybegin.5v.pl/httpdocs/look/menu.php');
    ?>

    <div id='glowna'>
        <div class='post'>
            <p style='font-size:20px;'><strong>Formularz kontaktowy</strong></p>
            <form method='post' action='kontakt.php'>
            E-mail: 
            <?php 
            if(isset($_SESSION['uss'])) 
            {
                echo $_SESSION['email'];
            } 
            else 
            {
                echo "&nbsp;&nbsp;&nbsp;&nbsp;<input required type='email' name='unknown_email'/>";
            }
            ?> <br/>
            Wiadomość: 
            <p><textarea required name='form_textarea' style='resize:none;width:70%;height:150px;'></textarea></p>
            <input type='submit' name='send' value='Prześlij'/>
            </form>
            <?php
            if(isset($_SESSION['wyslano']))
            {
                echo '<p><span style="font-size:20px;">'.$_SESSION['wyslano'].'</span></p>';
                unset($_SESSION['wyslano']);
            }
            ?>
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