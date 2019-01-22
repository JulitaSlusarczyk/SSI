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
                $query2 = $db->query("SELECT * FROM posts");
                $i=1;
                while($w=$query2->fetch_assoc())
                {
                    $_SESSION['pst_id'][$i]=$w['post_id'];
                    $_SESSION['use'][$i]=$w['username'];
                    $_SESSION['titlep'][$i]=$w['title'];
                    $_SESSION['bodyy'][$i]=$w['body'];
                    $_SESSION['cat'][$i]=$w['category'];
                    $i++;
                }
                $count2=$query2->num_rows;
                $query2->free_result();

                if($_GET['del']!=0 && $_GET['menu']=='post')
                {
                    $delete=$_SESSION['pst_id'][$_GET['del']];
                    if($db->query("DELETE FROM posts WHERE user_id='$delete'"))
                    {
                        header("Location:admin.php?menu=post&edit=0&del=0");
                    }
                }
                if(isset($_POST['sub2']) && $_GET['menu']=='post')
                {
                    $ti=$_POST['titlep'];
                    $bo=$_POST['bod'];
                    $pid=$_POST['id'];
                    $se2=$_POST['select2'];
                    if($db->query("UPDATE posts SET title='$ti', body='$bo', category='$se2' WHERE post_id='$pid'"))
                    {
                        header("Location:admin.php?menu=post&edit=0&del=0");
                    }
                }

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

                if($_GET['del']!=0 && $_GET['menu']=='ust')
                {
                    $delete=$_SESSION['usr_id'][$_GET['del']];
                    if($db->query("DELETE FROM users WHERE user_id='$delete'"))
                    {
                        header("Location:admin.php?menu=ust&edit=0&del=0");
                    }
                }
                if(isset($_POST['sub']) && $_GET['menu']=='ust')
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
            <div class='MenuOption' style="float:left;"><a href="admin.php?menu=ust&edit=0&del=0">Użytkownicy</a></div>
            <div class='MenuOption' style="float:left;border-right: 2px dotted #cccccc;"><a href="admin.php?menu=post&edit=0&del=0">Posty</a></div>
            <div style='clear:both;'></div>
        </div>
            <br/>
            <?php
            if($_GET['menu']=='post')
            {
                echo "<table border='1'>
                <tr>
                <th>Post_id</th>
                <th>Username</th>
                <th>Title</th>
                <th>Category</th>
                <th>Edycja</th>
                <th>Usuń</th>
                </tr>";
                
                for($i=1;$i<=$count2;$i++)
                {
                    echo "<tr>";
                    echo "<td>".$_SESSION['pst_id'][$i]."</td>";
                    echo "<td>".$_SESSION['use'][$i]."</td>";
                    echo "<td>".$_SESSION['titlep'][$i]."</td>";
                    echo "<td>".$_SESSION['cat'][$i]."</td>";
                    echo "<td><a href='admin.php?menu=post&edit=".$i."&del=0' style='cursor:pointer;'>Edytuj</a></td>";
                    echo "<td><a href='admin.php?menu=post&edit=0&del=".$i."' style='cursor:pointer;'>Usuń</a></td>";
                    echo "</tr>";
                }
                echo "</table><br/>";
                if($_GET['edit']!=0)
                {
                    $a=$_GET['edit'];
                    echo "Edytuj <br/><br/>
                    <form method='post' action='admin.php'>
                    <input type='hidden' name='id' value='".$_SESSION['pst_id'][$a]."'/>
                    Username: ".$_SESSION['use'][$a]." <br/><br/>
                    Tytuł: <input type='text' name='titlep' value='".$_SESSION['titlep'][$a]."'/><br/><br/>
                    <textarea rows='12' cols='70' name='bod' style='resize:none;'>".$_SESSION['bodyy'][$a]."</textarea><br/><br/>
                    Tagi: 
                    <select name='select2'>
                        <option value='Tag1'>Tag1</option>
                        <option value='Tag2'>Tag2</option>
                        <option value='Tag3'>Tag3</option>
                        <option value='Tag4'>Tag4</option>
                    </select><br/><br/>
                    <input type='submit' value='Zatwierdź zmiany' name='sub2'/>
                    </form>";
                }
            }
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
                    echo "<td>".$_SESSION['usr_id'][$i]."</td>";
                    echo "<td>".$_SESSION['usern'][$i]."</td>";
                    echo "<td>".$_SESSION['emaill'][$i]."</td>";
                    echo "<td>".$_SESSION['rolaa'][$i]."</td>";
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
                    <input type='hidden' name='id' value='".$_SESSION['usr_id'][$a]."'/>
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