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
			</div><br/>
			<div class='comment' style='text-align:right;margin:0;margin-top:15px;font-size:13px;'>Komentarze()</div>
			<div style='clear:both;'></div>
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