<?php
    session_start();
    
    if(isset($_POST['email']))
    {
        //udana walidacja
        $everythingOk=true;

        //username
        $username = $_POST['username'];
            //dlugosc username
        if(strlen($username)<3 || (strlen($username)>20))
        {
            $everythingOk=false;
            $_SESSION['error_username']="Login musi posiadać od 3 do 20 znaków!";
        }

        if(ctype_alnum($username)==false)
        {
            $everythingOk=false;
            $_SESSION['error_username']="Login może składać się tylko z cyfr i liter bez polskich znaków!";
        }
        
        
        //sprawdzenie emaila
        $email = $_POST['email'];
        $emailA = filter_var($email, FILTER_SANITIZE_EMAIL);

        if((filter_var($emailA,FILTER_VALIDATE_EMAIL)==false) || ($emailA)!=$email)
        {
            $everythingOk=false;
            $_SESSION['error_email']="Niepoprawny adres e-mail!";
        }

        //sprawdzanie hasla
        $password1=$_POST['password1'];
        $password2=$_POST['password2'];

        if((strlen($password1)<8) || (strlen($password1) >20))
        {
            $everythingOk=false;
            $_SESSION['error_password']="Hasło musi posiadać od 8 do 20 znaków!";
        }

        if($password1!=$password2)
        {
            $everythingOk=false;
            $_SESSION['error_password']="Hasła nie są takie same!";
        }

        //hashowanie hasla
        $pwrd_hash=password_hash($password1,PASSWORD_DEFAULT);

        //captcha
        $secret = "6LcKSYkUAAAAAMz5LPCqpflmweunTTus0RIPi40d";

        $check = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$secret."&response=".$_POST['g-recaptcha-response']);

        $google = json_decode($check);

        if($google->success==false)
        {
            $everythingOk=false;
            $_SESSION['error_google']="Potwierdź, że nie jesteś botem!";
        }
        
        require_once('../includes/db_connect.php');
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
                //czy email jest w bazie
                $query=$db->query("SELECT user_id FROM users where email='$email'");

                if(!$query) throw new Exception($db->error);

                $zajety_email=$query->num_rows;
                if($zajety_email>0)
                {
                    $everythingOk=false;
                    $_SESSION['error_email']="Istnieje już użytkownik o takim adresie e-mail!";
                }

                //czy login jest w bazie

                $query=$db->query("SELECT user_id FROM users where username='$username'");

                if(!$query) throw new Exception($db->error);

                $zajety_login=$query->num_rows;
                if($zajety_login>0)
                {
                    $everythingOk=false;
                    $_SESSION['error_username']="Istnieje już użytkownik o takim loginie!";
                }

                //koniec, dodanie użytkownika
                if($everythingOk==true)
                {
                    //dodanie do bazy
                    if($db->query("INSERT INTO users VALUES(NULL, '$username', '$pwrd_hash', '$email', 'None')"))
                    {
                        $_SESSION['register_success']=true;
                        header("Location:register_success.php");
                    }
                    else
                    {
                        throw new Exception($db->error);
                    }
                }

                $db->close();
            }
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
    <title>Blog o podróżowaniu - Rejestracja</title>
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
        <div style='margin-left:30px;'><h2>Rejestracja</h2>
        <form action='registration.php' method='post'>
        <p>
            <label>Login &emsp;&emsp;&emsp;&nbsp; </label><input type='text' name='username' required />
        </p>
        <?php
            if(isset($_SESSION['error_username']))
            {
                echo '<p><span style="color:red;">'.$_SESSION['error_username'].'</span></p>';
                unset($_SESSION['error_username']);
            }
        ?>
        <p>
            <label>E-mail &emsp;&emsp;&nbsp;&nbsp;&nbsp; </label><input type='email' name='email' required/>
        </p> 
        <?php
            if(isset($_SESSION['error_email']))
            {
                echo '<p><span style="color:red;">'.$_SESSION['error_email'].'</span></p>';
                unset($_SESSION['error_email']);
            }
        ?>
        <p>
            <label>Hasło &emsp;&emsp;&emsp;&nbsp; </label><input type='password' name='password1'  />
        </p>
        <?php
            if(isset($_SESSION['error_password']))
            {
                echo '<p><span style="color:red;">'.$_SESSION['error_password'].'</span></p>';
                unset($_SESSION['error_password']);
            }
        ?>

        <p>
            <label>Powtórz hasło </label><input type='password' name='password2'  />
        </p>
        <p>
        <div class='g-recaptcha' data-sitekey='6LcKSYkUAAAAAI1iDxdTU4MtPwl3fB-kn8sTTJDY'>
        </div>
        </p>
        <?php
            if(isset($_SESSION['error_google']))
            {
                echo '<p><span style="color:red;">'.$_SESSION['error_google'].'</span></p>';
                unset($_SESSION['error_google']);
            }
        ?>

        <input type='submit' name='submit2' value='Zarejestruj się' />
        </form></div>
        
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