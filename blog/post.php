<?php
    session_start();
    date_default_timezone_set('Europe/Warsaw');

    require_once('/var/www/vhosts/letthejourneybegin.5v.pl/httpdocs/includes/db_connect.php');
    mysqli_report(MYSQLI_REPORT_STRICT);
    if($_GET['id']==NULL || $_GET['del']==NULL)
    {
        header("Location:index.php");
    }
	try
    {
        $db=new mysqli($host,$db_user,$db_pass,$db_name);
        if($db->connect_errno!=0)
        {
            throw new Exception(mysqli_connect_errno());
		}
		else
		{
            $postID=$_GET['id'];
            $query3 = $db->query("SELECT post_id, username, title, body, posted FROM posts WHERE post_id='$postID'");
            $row = $query3->fetch_assoc();
            if($query3->num_rows==0)
            {
                header('Location:index.php');
            }
            $query3->free_result();
            $query2 = $db->query("SELECT * FROM comments WHERE post_id='$postID'");
            $i=1;
            while($w = $query2->fetch_assoc())
            {
                $row2['comment_id'][$i]=$w['comment_id'];
                $row2['post_id'][$i]=$w['post_id'];
                $row2['username'][$i]=$w['username'];
                $row2['comment'][$i]=$w['comment'];
                $row2['date'][$i]=$w['date'];
                $i++;
            }
            $count=$query2->num_rows;
            $query2->free_result();

            if($_GET['del']==0)
            {

            }
            else
            {
                $us=$_SESSION['uss'];
                $delete=$_GET['del'];
                if($db->query("DELETE FROM comments WHERE username='$us' AND post_id='$postID' AND comment_id='$delete'"))
                {
                    header("Location:post.php?id=".$postID."&del=0");
                }
                
                if($_SESSION['rola']=='admin')
                {
                    if($db->query("DELETE FROM comments WHERE post_id='$postID' AND comment_id='$delete'"))
                    {
                        header("Location:post.php?id=".$postID."&del=0");
                    }
                }
            }

            if(isset($_POST['btnsubmit']))
            {
                if($_POST['comment']=="")
                {
                    $_SESSION['error_comment']="Komentarz nie może być pusty!";
                    header("Location:post.php?id=".$_POST['id']."");
                }
                else
                {
                    $date=$_POST['date'];
                    $user=$_POST['user'];
                    $comm=strip_tags($_POST['comment'],"<img>");
                    $id=$_POST['id'];
                    if($db->query("INSERT INTO comments VALUES(NULL, '$id', '$user', '$comm', '$date')"))
                    {
                        header("Location:post.php?id=".$id."&del=0");
                    }
                    else
                    {
                        throw new Exception($db->error);
                    }
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
    <title>Blog o podróżowaniu - <?php echo $row['title']; ?></title>
    <link rel="stylesheet" type="text/css"href="style.css" />
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
			<div class='textpost'> <h2><?php echo $row['title']; ?></h2>
				<span style='font-size:17px;'><br/><br/><?php echo $row['username']; ?></span>
				<span style='font-size:12px;'><?php echo $row['posted']; ?></span><br/>
				<br/><p><?php echo $row['body']; ?></p>
			</div>
        </div>
        <?php
                if(isset($_SESSION['uss']))
                {
                    echo "<div class='post'>";
            
                    echo "<form method='post' action='post.php'>
                        <input value='".$_SESSION['uss']."' name='user' type='hidden'/>
                        <input value='".date('Y-m-d H-i-s')."' name='date' type='hidden'/>
                        <input value='".$postID."' name='id' type='hidden'/>
                        <textarea name='comment' style='resize:none;width:70%;height:150px;' value=''></textarea><br/>
                        <input value='Dodaj komentarz' name='btnsubmit' type='submit'/>
                        </form>";
                    
                    if(isset($_SESSION['error_comment']))
                    {
                        echo '<p><span style="color:red;">'.$_SESSION['error_comment'].'</span></p>';
                        unset($_SESSION['error_comment']);
                    } 
                    echo "</div>";
                }
        ?>
        <?php
        for($i = 1; $i<=$count; $i++)
        {
            echo "<div class='post' style='background-color:##4e83d8;'>
                <span style='font-size:19px;'>".$row2['username'][$i]." </span><span style='font-size:10px;'>".$row2['date'][$i]."</span>
                <p style='font-size:15px;'>".$row2['comment'][$i]."</p>";
            if(isset($_SESSION['uss']))
            {
                if($_SESSION['uss']==$row2['username'][$i] || $_SESSION['rola']=='admin')
                {   
                    echo "<a style='font-size:12px;cursor:pointer;' href='post.php?id=".$postID."&del=".$row2['comment_id'][$i]."'> Usuń</a>";
                }
            }
            echo "</div>";
        }
        ?>
    </div>
<?php
	require_once('/var/www/vhosts/letthejourneybegin.5v.pl/httpdocs/look/sidebar.php');
?>
<?php
require_once('/var/www/vhosts/letthejourneybegin.5v.pl/httpdocs/look/footer.php');
?>
</body>
</html>