<?php
    session_start();
    if(!isset($_SESSION['uss']) || $_SESSION['rola']!="admin")
    {
        header('Location: index.php');
        exit();
    }
    if($_GET['menu']==NULL || $_GET['edit']==NULL || $_GET['del']==NULL)
    {
        header("Location:admin.php?menu=ust&edit=0&del=0");
    }
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
                $query = $db->query("SELECT * FROM users");
            
                $i=1;
                while($w=$query->fetch_assoc())
                {
                    $_SESSION['usr_id'][$i]=$w['user_id'];
                    $_SESSION['usern'][$i]=$w['username'];
                    $_SESSION['emaill'][$i]=$w['email'];
                    $_SESSION['rolaa'][$i]=$w['rola'];
                    $i++;
                }
                $count=$query->num_rows;
                $query->free_result();

                if($_GET['del']!=0)
                {
                    $delete=$_GET['del'];
                    if($db->query("DELETE FROM users WHERE user_id='$delete'"))
                    {
                        header("Location:admin.php?menu=ust&edit=0&del=0");
                    }
                }
                if(isset($_POST['sub']))
                {
                    $em=$_POST['emaill'];
                    $uid=$_POST['id'];
                    $se=$_POST['select'];
                    if($db->query("UPDATE users SET email='$em', rola='$se' WHERE user_id='$uid'"))
                    {
                        header("Location:admin.php?menu=ust&edit=0&del=0");
                    }
                }
            }
            $db->close();
        }
        catch(Exception $e)
        {
            echo "<span style='color:red;'>Błąd serwera. Spróbuj ponownie później</span>";
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
            <div class='MenuOption' style="float:left;"><a>Użytkownicy</a></div>
            <div class='MenuOption' style="float:left;border-right: 2px dotted #cccccc;"><a>Posty</a></div>
            <div style='clear:both;'></div>
        </div>
            <br/>
            <?php
            if($_GET['menu']=='ust')
            {
                echo "<table border='1'>
                <tr>
                <th>User_id</th>
                <th>Username</th>
                <th>Email</th>
                <th>Rola</th>
                <th>Edycja</th>
                <th>Usuń</th>
                </tr>";
                
                for($i=1;$i<=$count;$i++)
                {
                    echo "<tr>";
                    echo "<td>" . $_SESSION['usr_id'][$i] . "</td>";
                    echo "<td>" . $_SESSION['usern'][$i] . "</td>";
                    echo "<td>" . $_SESSION['emaill'][$i] . "</td>";
                    echo "<td>" . $_SESSION['rolaa'][$i] . "</td>";
                    echo "<td><a href='admin.php?menu=ust&edit=".$i."&del=0' style='cursor:pointer;'>Edytuj</a></td>";
                    echo "<td><a href='admin.php?menu=ust&edit=0&del=".$i."' style='cursor:pointer;'>Usuń</a></td>";
                    echo "</tr>";
                }
                echo "</table><br/>";
                if($_GET['edit']!=0)
                {
                    $a=$_GET['edit'];
                    echo "Edytuj <br/><br/>
                    <form method='post' action='admin.php'>
                    <input type='hidden' name='id' value='".$a."'/>
                    Username: ".$_SESSION['usern'][$a]." 
                    E-mail: <input type='text' name='emaill' value='".$_SESSION['emaill'][$a]."'/>
                    Rola: 
                    <select name='select' required>
                        <option value='admin'>admin</option>
                        <option value='moderator'>moderator</option>
                        <option value='none'>none</option>
                    </select><br/><br/>
                    <input type='submit' value='Zatwierdź zmiany' name='sub'/>
                    </form>";
                }
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