<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FlowFix</title>
</head>
<body>
    <header>
        <?php if(isset($_SESSION["userId"])) echo "<br>Connecté avec user_id => ".$_SESSION["userId"];?>
    </header>
    <?php include($contentPath); ?>
</body>
</html>