        <div id="menu">
			<?php
				if(isset($_SESSION['uss']))
				{
					echo "<div class='MenuOption' style='border-right: 2px dotted #cccccc;'><a href='logout.php'>Wyloguj się</a></div>";
					if($_SESSION['rola']=="admin")
					{
						echo "<div class='MenuOption'><a href='admin.php'>Admin</a></div>";
						echo "<div class='MenuOption'>Dodaj post</div>";
					}
					if($_SESSION['rola']=="moderator")
					{
						echo "<div class='MenuOption'>Dodaj post</div>";
					}

				}
				else
				{
					echo "<div class='MenuOption' style='border-right: 2px dotted #cccccc;'><a href='registration.php'>Zarejestruj się</a></div>";
            		echo "<div class='MenuOption'><a href='login.php'>Zaloguj się</a></div>";
				}
			?>
            <div class="MenuOption"><a href="about_me.php">O mnie</a></div>
			<div class="MenuOption"><a href="index.php">Strona główna</a></div>
			<?php
				if(isset($_SESSION['uss']))
				{
					$usss= $_SESSION['uss'];
					echo "<div class='MenuOption' style='cursor:default;'>Witaj, ".$usss."</div>";
				}
			?>
            <div style="clear:both;"></div>
        </div>
