<?php
    session_start();
    if($_GET['tag']==NULL)
    {
        header("Location:index.php");
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
            $tag=$_GET['tag'];
            $query3 = $db->query("SELECT post_id, username, title, body, posted FROM posts WHERE category='$tag' ORDER BY posted DESC");
            $i=1;
            while($w = $query3->fetch_assoc())
            {
                $_SESSION['pt_id'][$i] = $w['post_id'];
				$_SESSION['p_username'][$i] = $w['username'];
				$_SESSION['title'][$i]=$w['title'];
				$_SESSION['body'][$i]=$w['body'];
				$_SESSION['posted'][$i]=$w['posted'];
				$i++;
            }
            if($query3->num_rows==0)
            {
                header('Location:index.php');
            }
            $count=$query3->num_rows;
            $query3->free_result();
            for($i=1;$i<=$count;$i++)
			{
				$com=$_SESSION['pt_id'][$i];
				$query2 = $db->query("SELECT comment_id FROM comments WHERE post_id='$com'");
				$com_count[$i]=$query2->num_rows;
				$query2->free_result();
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
    <title>Blog o podrozowaniu - <?php echo $_GET['tag'];?></title>
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
		<?php
			for($i = 1; $i<=$count; $i++)
			{
				echo "<div class='post'>
					<div class='textpost'> <h2><a href='post.php?id=".$_SESSION['pt_id'][$i]."&del=0'>".$_SESSION['title'][$i]. "</a></h2>
					<span style='font-size:17px;'><br/><br/>".$_SESSION['p_username'][$i]."</span>
					<span style='font-size:12px;'>".$_SESSION['posted'][$i]."</span><br/>
					<br/><p>".$_SESSION['body'][$i]."</p>
				</div>
				<div class='czytajDalej' style='float:right; margin-top:10px;font-size:17px;'><a href='post.php?id=".$_SESSION['pt_id'][$i]."&del=0'>Czytaj dalej</a></div><br/>
				<div class='comment' style='text-align:right;margin:0;margin-top:15px;font-size:13px;'><a style='cursor:pointer;' href='post.php?id=".$_SESSION['pt_id'][$i]."&del=0'>Komentarze(".$com_count[$i].")</a></div>
				<div style='clear:both;'></div>
				</div>";
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