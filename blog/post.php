<?php
    session_start();

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
            $postID = $_GET['id'];
            $query3 = $db->query("SELECT post_id, username, title, body, posted FROM posts WHERE post_id='$postID'");
            $row = $query3->fetch_assoc();
            $query3->free_result();
            $query2 = $db->query("SELECT * FROM comments WHERE post_id='$postID'");
            $i=1;
            while($w = $query2->fetch_assoc())
            {
                $row2['comment_id'][$i]=$w['comment_id'];
                $row2['post_id'][$i]=$w['post_id'];
                $row2['username'][$i]=$w['username'];
                $row2['comment'][$i]=$w['comment'];
                $i++;
            }
            $count=$query2->num_rows;
            $query2->free_result();
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
    <script src="main.js"></script>
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
        for($i = 1; $i<=$count; $i++)
        {
            echo "<div class='post' style='background-color:##4e83d8;'>
                <span style='font-size:19px;'>".$row2['username'][$i]."</span>
                <p style='font-size:15px;'>".$row2['comment'][$i]."</p></div>";
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