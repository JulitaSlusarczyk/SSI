<?php
    session_start();
    date_default_timezone_set('Europe/Warsaw');
    $anuluj=false;
    if($_SESSION['rola']=="admin" || $_SESSION['rola']=="moderator")
    {

    }
    else
    {
        header('Location: index.php');
        exit();
    }
    if(isset($_POST['textar']))
    {
        echo "i'm in";
        if($_POST['textar']=="")
        {
            $anuluj=true;
            echo "textar";
            $_SESSION['error_textar']="Post nie może być pusty!";
        }
        if($_POST['titletext']=="")
        {
            $anuluj=true;
            echo "titletext";
            $_SESSION['error_titletext']="Post musi mieć tytuł!";
        }
        if($anuluj==false)
        {
            echo "poszlo";
        }
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
            <?php
                echo "<input value=".$_SESSION['uss']." name='name' type='hidden'/>
                <input value=".date('Y-m-d H-i-s')." name='date' type='hidden'/>           
                <h2 style='margin:0;''>Tytuł</h2> <br/>"
            ?>

            <?php
                if(isset($_SESSION['error_titletext']))
                {
                    echo '<p><span style="color:red;">'.$_SESSION['error_titletext'].'</span></p>';
                    unset($_SESSION['error_titletext']);
                }
            ?>

            <textarea id="titletext" value="" style="resize:none;width:70%;height:20px;"></textarea> <br/>
            <h2 style="margin:0; margin-top:10px;">Treść posta</h2> <br/>

            <?php
                if(isset($_SESSION['error_textar']))
                {
                    echo '<p><span style="color:red;">'.$_SESSION['error_textar'].'</span></p>';
                    unset($_SESSION['error_textar']);
                }
            ?>

            <?php
                echo "<textarea id='textar' value=''></textarea>
                <br/>
                <button type='submit' id='buttonsubmit'>Dodaj post</button>";
            ?>
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