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
    require_once('/var/www/vhosts/letthejourneybegin.5v.pl/httpdocs/includes/db_connect.php');
    $db=new mysqli($host,$db_user,$db_pass,$db_name);
    $query3 = $db->query("SELECT * FROM categories");
    $i=1;
    while($w = $query3->fetch_assoc())
    {
        $_SESSION['categ_id_ap'][$i] = $w['category_id'];
        $_SESSION['categ_ap'][$i] = $w['category'];
        $i++;
    }
    $count3=$query3->num_rows;
    $query3->free_result();
    $db->close();
    if(isset($_POST['titletext']))
    {
        if($_POST['textar']=="")
        {
            $anuluj=true;
            $_SESSION['error_textar']="Post nie może być pusty!";
        }
        if($_POST['titletext']=="")
        {
            $anuluj=true;
            $_SESSION['error_titletext']="Post musi mieć tytuł!";
        }
        if($anuluj==false)
        {
            mysqli_report(MYSQLI_REPORT_STRICT);
            try
            {
                $db=new mysqli($host,$db_user,$db_pass,$db_name);
                if($db->connect_errno!=0)
                {
                    throw new Exception(mysqli_connect_errno());
                }
                else
                {
                    $data=$_POST['data'];
                    $user=$_POST['user'];
                    $titletext=$_POST['titletext'];
                    $textar=strip_tags($_POST['textar'],'<img><a><p><span><strong><em><ol><ul><li>');
                    $id=$_POST['id'];
                    $category=$_POST['select'];
                    if($db->query("INSERT INTO posts VALUES(NULL, '$user', '$titletext', '$textar', '$category' , '$data')"))
                    {
                        header("Location:index.php");
                    }
                    else
                    {
                        throw new Exception($db->error);
                    }
                }
                $db->close();
            }
            catch(Exception $e)
            {
                echo "<span style='color:red;'>Błąd serwera. Spróbuj ponownie później</span>";
            }
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
                echo "<input value='".$_SESSION['uss']."' name='user' type='hidden'/>
                <input value='".date('Y-m-d H-i-s')."' name='data' type='hidden'/>           
                <h2 style='margin:0;''>Tytuł</h2> <br/>"
            ?>

            <?php
                if(isset($_SESSION['error_titletext']))
                {
                    echo '<p><span style="color:red;">'.$_SESSION['error_titletext'].'</span></p>';
                    unset($_SESSION['error_titletext']);
                }
            ?>

            <textarea name="titletext" value="" style="resize:none;width:70%;height:20px;"></textarea> <br/>
            <h2 style="margin:0; margin-top:10px;">Treść posta</h2> 

            <?php
                if(isset($_SESSION['error_textar']))
                {
                    echo '<p><span style="color:red;">'.$_SESSION['error_textar'].'</span></p>';
                    unset($_SESSION['error_textar']);
                }
            ?> <br/>

            <?php
                echo "<textarea name='textar' value=''></textarea>
                <br/>
                <select name='select' required>";
                for($i=1;$i<=$count3;$i++)
                {
                    echo "<option value='".$_SESSION['categ_ap'][$i]."'>".$_SESSION['categ_ap'][$i]."</option>";
                }
                echo "</select>
                <br/><br/>
                <button type='submit' name='buttonsubmit'>Dodaj post</button>";
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