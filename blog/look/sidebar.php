<?php
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
			$query = $db->query("SELECT * FROM categories");
			$i=1;
			while($w = $query->fetch_assoc())
			{
				$_SESSION['category_id'][$i] = $w['category_id'];
				$_SESSION['category'][$i] = $w['category'];
				$i++;
			}
			$count=$query->num_rows;
			$query->free_result();
		}
		$db->close();
	}
	catch(Exception $e)
    {
        echo "<span style='color:red;'>Błąd serwera. Spróbuj ponownie później</span>";
    }
?>
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
				<?php
					for($i=1;$i<=$count;$i++)
					{
						echo "<li><a href='tags.php?tag=".$_SESSION['category'][$i]."'>".$_SESSION['category'][$i]."</a></li>";
					}
				?>
			</ul>
		</div>
    </div>
<div style="clear:both;"></div>
