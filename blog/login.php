<?php
    session_start();
    if(isset($_POST['submit']))
    {
        $user = $_POST['username'];
        $pwrd = $_POST['pwrd'];
        
        require_once('/var/www/vhosts/letthejourneybegin.5v.pl/httpdocs/includes/db_connect.php');
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
            $user = strip_tags($user);
            $user = $db->real_escape_string($user);
            $query = $db->query("SELECT * FROM users WHERE username='$user'");
            
            if($query->num_rows===1)
            {
                $w=$query->fetch_assoc();
                if(password_verify($pwrd,$w['password']))
                {
                    $_SESSION['uss']=$w['username'];
                    $_SESSION['rola']=$w['rola'];
                    $query->free_result();
                    header('Location:index.php');
                    exit();
                }
                else 
                {
                    $_SESSION['blad']="Błędny login i/lub hasło";
                }
            }
            else
            {
                $_SESSION['blad']="Błędny login i/lub hasło";
            }
        }
        $db->close();
        }
    catch(Exception $e)
    {
        echo "<span style='color:red;'>Błąd serwera. Spróbuj ponownie później</span>";
    }
            

        }
        
    
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Blog o podróżowaniu - Zaloguj się</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
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
    <div class="post" >
    <div style="margin-left:30px;">
    <h2>Logowanie</h2>
        <?php
            if(isset($_SESSION['blad']))
            {
                echo "<span style='color:red;'>".$_SESSION['blad']."</span>";
                echo "<br/>";
                unset($_SESSION['blad']);
            }
        ?>
        <form action="login.php" method="post">
        <p>
            <label>Login </label><input type="text" name="username" required />
        </p>
        <p>
            <label>Hasło </label><input type="password" name="pwrd" required />
        </p>
        <input type="submit" name="submit" value="Zaloguj się" />
        </form>
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