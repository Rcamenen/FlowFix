<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/style.css">
    <title>FlowFix</title>
</head>
<body class="container">
    <header>
        <?php if(isset($_SESSION["userId"])) echo "<br>Connecté avec user_id => ".$_SESSION["userId"];?>
        <?php if(isset($_SESSION["teamsId"])) {
            echo "ID des teams : ";
            foreach($_SESSION["teamsId"] as $team){

                echo " / ".$team;

            }

        };?>
    </header>
    <?php include($contentPath); ?>
</body>
</html>