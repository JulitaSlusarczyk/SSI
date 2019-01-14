<?php
    session_start();
    if(!isset($_SESSION['uss']))
    {

	}
	else $usss= $_SESSION['uss'];
	$count=0;
	
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
			while($w = $query2->fetch_assoc())
			{
				$_SESSION['post_id'][$i] = $w['post_id'];
				$_SESSION['p_username'][$i] = $w['username'];
				$_SESSION['title'][$i]=$w['title'];
				$_SESSION['body'][$i]=$w['body'];
				$_SESSION['category'][$i]=$w['category'];
				$_SESSION['posted'][$i]=$w['posted'];
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
    <title>Blog o podróżowaniu - Strona główna</title>
    <link rel="stylesheet" href="style.css" type="text/css" />
</head>

<body>
    <div id="blog">
    
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
						<div class='textpost'> <h2>".$_SESSION["title"][$i];
					echo "</h2>
						<span style='font-size:17px;'><br/><br/>".$_SESSION['p_username'][$i]."</span>
						<span style='font-size:12px;'>".$_SESSION['posted'][$i]."</span><br/>
						<br/><p>".$_SESSION['body'][$i]."</p>
					</div>
					<div class='czytajDalej' style='float:right; margin-top:10px;font-size:17px;'>Czytaj dalej</div><br/>
					<div class='comment' style='text-align:right;margin:0;margin-top:15px;font-size:13px;'><a style='cursor:pointer;'>Komentarze()</a></div>
					<div style='clear:both;''></div>
				</div>";
				}
			?>
        	

    
        </div>
        <div class="sideBar">
            <div id="myimg">
                <img src="zdj2.jpg" style="border-radius:60px; margin-left:auto; margin-bottom:auto;"/>
            </div>
			<div id="opis" style="text-align: center;">
				<br/> <h4>Opis </h4><br/> 
				Lorem ipsum dolor sit amet, summo democritum vel in, nam ut impedit volumus platonem, ea sed simul labore. Et mel solum dolor offendit, partiendo repudiare duo ad, mei minim dicam nominavi id. Ne eius omittam sea. Eu mel dicit regione propriae, has ut purto nostro. <br/>
			</div>
			<div id="tagi">
			<br/> <h4>Tagi </h4>
				<ul id="tags">
					<li><a>Tag1</a></li>
					<li><a>Tag2</a></li>
					<li><a>Tag3</a></li>
					<li><a>Tag4</a></li>
				</ul>
			</div>
        </div>
        <div style="clear:both;"></div>
        
    </div>
<?php
	require_once('/var/www/vhosts/letthejourneybegin.5v.pl/httpdocs/look/footer.php');
?>
</body>
</html>