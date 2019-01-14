<?php
    session_start();
    if(!isset($_SESSION['uss']) || $_SESSION['rola']!="admin")
    {
        header('Location: index.php');
        exit();
    }
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Blog o podróżowaniu - panel admina</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="style.css" />
</head>
<body>
    
</body>
</html>